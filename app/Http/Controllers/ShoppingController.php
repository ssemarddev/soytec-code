<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller
{
    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Shopping::class;

    /**
     * @OA\Get(
     *      path="/api/shopping",
     *      tags={"Compras"},
     *      summary="Listar todos los registros de compra del taller",
     *      @OA\Response(
     *          response=200,
     *          description="Registros de compra listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Shopping",
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

    /**
     * Crea un nuevo registro de compra
     * @OA\Post(
     *      path="/api/shopping",
     *      tags={"Compras"},
     *      summary="Crear un nuevo registro de compra del taller",
     *      @OA\RequestBody(
     *          request="StoreShopping",
     *          description="Datos del nuevo registro de compra a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Shopping",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Registros de compra creado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Shopping"
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
     * @return \Illuminate\Http\Response Los datos del nuevo registro de compra
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'provider_id' => ['required', 'integer', 'exists:providers,id'],
            'quantity' => ['required', 'integer'],
            'cost' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
        ]);
        //Obtener los datos de la petición
        $data = $request->except('piece');
        //Añadir el administrador logueado como autor de la compra
        $data['user_id'] = $request->user()->id;
        //Si la pieza o herramienta no existe en el inventario crearla
        if ($request->piece_id == '') {
            //Obtener los datos de la nueva pieza a registrar
            $piece = $request->only('piece')['piece'];
            //Validar los datos de la nueva pieza
            Validator::make($piece, [
                'name' => ['required', 'unique:pieces', 'between:3,60'],
                'model' => ['required', 'between:3,60'],
                'description' => ['between:3,700'],
                'stock' => ['required', 'integer'],
                'unit_id' => ['required', 'integer', 'exists:units,id']
            ])->validate();
            //Almacenar la pieza en la base de datos 
            $data['piece_id'] = Piece::create($piece)->id;
        }
        //Crear el registro de compra
        $item = Shopping::create($data);
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    /**
     * @OA\Delete(
     *      path="/api/shopping",
     *      tags={"Compras"},
     *      summary="Eliminar registros de compras del taller",
     *      @OA\RequestBody(
     *          request="DestroyShopping",
     *          description="Ids de los registros de compra a eliminar",
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
     *          description="Registros de compra eliminados correctamente",
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
        return parent::destroy($request);
    }
}
