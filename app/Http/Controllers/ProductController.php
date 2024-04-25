<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Rules\Name;

class ProductController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Product::class;

    /**
     * @OA\Get(
     *      path="/api/products",
     *      tags={"Productos de la tienda"},
     *      summary="Listar todos los productos de la tienda",
     *      @OA\Response(
     *          response=200,
     *          description="Productos listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Product",
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     */
    public function index()
    {
        return parent::index();
    }

    public function popular() {
        $popular = DB::select("SELECT `products`.`id` as 'id', `products`.`image` as 'image', `products`.`name` as 'name', `products`.`trademark` as 'trademark', `products`.`model` as 'model', `products`.`cost` as 'cost', `products`.`price` as 'price',`products`.`stock` as 'stock', `products`.`min` as 'min', SUM(`quantity`) as 'quantity' FROM `sold_products` INNER JOIN `products` ON `product_id` = `products`.`id` GROUP BY `product_id` ORDER BY `quantity` DESC LIMIT 5");
        return response()->json($popular);
    }

    /**
     * Crea un nuevo producto en la tienda
     * @OA\Post(
     *      path="/api/products",
     *      tags={"Productos de la tienda"},
     *      summary="Crear un nuevo producto en la tienda",
     *      @OA\RequestBody(
     *          request="StoreProduct",
     *          description="Datos del nuevo producto a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Product"
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Producto creado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Product"
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Los datos del nuevo producto generado
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'code' => ['required', 'unique:products', 'digits_between:10,14'],
            'sku' => ['required', 'alpha_num', 'between:3,5'],
            'name' => ['required', new Name, 'unique:products', 'between:3,100'],
            'description' => ['required', 'between:5,700'],
            'image' => ['required', 'image', Rule::dimensions()->minWidth(500)->minHeight(500), 'between:3,2048'],
            'cost' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'price' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'offer' => ['filled', 'regex:/^[\d.]+$/', 'between:1,12'],
            'stock' => ['required', 'integer'],
            'min' => ['required', 'integer'],
            'model' => ['required', new Name, 'between:1,100'],
            'trademark' => ['required', new Name, 'between:1,50'],
            'type' => ['filled', 'in:Físico,Digital'],
            'category_id' => ['required', 'integer'],
            'state' => ['filled', 'in:Activo,Inactivo'],
            'tags' => ['required']
        ]);
        //Obtener los datos de la petición
        $data = $request->except('colors');
        //Guardar la imagen en el almacenamiento
        $path = $request->file('image')->store('products', 'images');
        $data['image'] = $path;
        //Crear la instancia del modelo en la base de datos
        $product = Product::create($data);
        $colors = $request->colors;
        foreach ($colors as $i => $color) {
            $id = Color::create(['name' => $color['name'], 'color' => $color['color'], 'product_id' => $product->id])->id;
            $images = $request->file('colors')[$i];
            foreach ($images as $image) {
                $path = $image->store('products', 'images');
                Image::create(['name' => $path, 'color_id' => $id]);
            }
        }
        //Retornar el nuevo modelo
        return response()->json($product);
    }

    /**
     * Actualiza los datos de un producto
     * @OA\Put(
     *      path="/api/products/{id}",
     *      tags={"Productos de la tienda"},
     *      summary="Actualizar los datos de un producto de la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del producto a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="UpdateProduct",
     *          description="Datos modificados del producto a actualizar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Product",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Producto actualizado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Product",
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Id del producto a actualizar
     * @return \Illuminate\Http\Response Los datos modificados del producto actualizado
     */
    public function update(Request $request, $id)
    {
        //Validar los datos
        $request->validate([
            'code' => ['required', 'digits_between:10,14'],
            'sku' => ['required', 'alpha_num', 'between:3,5'],
            'name' => ['required', new Name, 'between:3,100'],
            'description' => ['required', 'between:5,700'],
            'image' => ['filled', 'image', Rule::dimensions()->minWidth(500)->minHeight(500), 'between:3,2048'],
            'cost' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'price' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'offer' => ['filled', 'regex:/^[\d.]+$/', 'between:1,12'],
            'stock' => ['required', 'integer'],
            'min' => ['required', 'integer'],
            'model' => ['filled', new Name, 'between:1,100'],
            'trademark' => ['filled', new Name, 'between:1,50'],
            'type' => ['filled', 'in:Físico,Digital'],
            'category_id' => ['required', 'integer'],
            'state' => ['filled', 'in:Activo,Inactivo'],
            'tags' => ['required']
        ]);
        //Obtener los datos de la petición
        $data = $request->except(['_method', 'colors']);
        //Guardar la imagen en el almacenamiento si se envió una nueva imagen para actualizar
        if ($request->hasFile('image')) {
            $old = Product::find($id);
            $name = Str::afterLast($old->image, '/');
            $request->file('image')->storeAs('products', $name, 'images');
            //TODO (Preparar para eliminar esta línea de abajo)
            unset($data['image']);
        }
        //Actualizar el producto
        Product::where('id', $id)->update($data);
        $colors = $request->colors;
        foreach ($colors as $i => $color) {
            $colorId = 0;
            if (isset($color['id'])) {
                Color::where('id', $color['id'])->update(['name' => $color['name'], 'color' => $color['color']]);
                $colorId = $color['id'];
            } else {
                $colorId = Color::create(['name' => $color['name'], 'color' => $color['color'], 'product_id' => $id])->id;
            }
            if ($request->hasFile("colors.$i")) {
                $images = $request->file('colors')[$i];
                foreach ($images as $image) {
                    $path = $image->store('products', 'images');
                    Image::create(['name' => $path, 'color_id' => $colorId]);
                }
            }
        }
        //Retornar el nuevo modelo
        $item = Product::find($id);
        return response()->json($item);
    }

    /**
     * Actualiza el estado de un producto
     * @OA\Put(
     *      path="/api/products/{id}/state/{state}",
     *      tags={"Productos de la tienda"},
     *      summary="Cambiar el estado de un producto de la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del producto a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="state",
     *          description="Nuevo estado del producto",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Se cambió el estado del producto correctamente",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     * @param  int  $id Id del producto a actualizar el estado
     * @param  string $state Nuevo estado del producto
     * @return \Illuminate\Http\Response
     */
    public function state($id, $state)
    {
        //Validar los datos
        Validator::make(['id' => $id, 'state' => $state], [
            'id' => ['required', 'integer'],
            'state' => ['required', 'regex:/^[\d.]+$/', 'between:1,12']
        ])->validate();
        //Actualizar el producto
        return parent::updateMultipleRows([$id], ['state' => $state]);
    }

    /**
     * Inactiva los productos pasados en los ids de la petición
     * @OA\Put(
     *      path="/api/products/state",
     *      tags={"Productos de la tienda"},
     *      summary="Inactiva productos de la tienda",
     *      @OA\RequestBody(
     *          request="InactiveProduct",
     *          description="Ids de los productos a inactivar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Ids",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Productos inactivados correctamente",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inactive(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Actualizar el producto
        return parent::updateMultipleRows($ids, ['state' => 'Inactivo']);
    }

    /**
     * Crea una nueva oferta
     * @OA\Put(
     *      path="/api/products/{id}/offer",
     *      tags={"Productos de la tienda"},
     *      summary="Crear oferta para un producto de la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del producto a crear la oferta",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Se creó la oferta del producto correctamente",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Id del plan a crear la oferta
     * @return \Illuminate\Http\Response
     */
    public function offer(Request $request, $id)
    {
        //Validar los datos
        Validator::make(['id' => $id, 'offer' => $request->offer], [
            'id' => ['required', 'integer'],
            'offer' => ['filled', 'regex:/^[\d.]+$/', 'between:1,12'],
        ])->validate();
        //Actualizar el plan
        return parent::updateMultipleRows([$id], ['offer' => $request->offer]);
    }

    /**
     * Eliminar una oferta
     * @OA\Put(
     *      path="/api/products/{id}/unoffer",
     *      tags={"Productos de la tienda"},
     *      summary="Eliminar oferta para un producto de la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del producto a eliminar la oferta",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Se eliminó la oferta del producto correctamente",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     * @param  int  $id Id del plan a eliminar la oferta
     * @return \Illuminate\Http\Response
     */
    public function unoffer($id)
    {
        //Actualizar el plan
        return parent::updateMultipleRows([$id], ['offer' => null]);
    }

    /**
     * Elimina los productos de la tienda pasados en los ids de la petición
     * @OA\Delete(
     *      path="/api/products",
     *      tags={"Productos de la tienda"},
     *      summary="Eliminar los productos de la tienda",
     *      @OA\RequestBody(
     *          request="DestroyProducts",
     *          description="Ids de los productos a eliminar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Ids",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Productos eliminados correctamente",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          ref="#/components/responses/422"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          ref="#/components/responses/401"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          ref="#/components/responses/500"
     *      ),
     * )
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Obtener el id de los productos en un array
        $ids = Str::of($request->ids)->explode(',');
        foreach ($ids as $id) {
            //Recuperar el modelo
            $product = Product::find($id);
            $data = $product->toArray();
            Storage::append("data.json", json_encode($data));
            //Eliminar el modelo
            $result = $product->delete();
            //Verificar si se eliminó y eliminar la imagen
            if ($result == 1) {
                //Eliminar imagen del producto
                Storage::disk('images')->delete($data['image']);
                foreach ($data['colors'] as $color) {
                    Storage::append("example.json", "example");
                    foreach ($color['images'] as $image) {
                        Storage::append("example2.json", "example");
                        Storage::disk('images')->delete($image->name);
                    }
                }
            }
        }
        return response('', 200);
    }
}
