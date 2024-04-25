<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Rules\Name;

class CategoryController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Category::class;


    /**
     *  @OA\Get(
     *      path="/api/categories",
     *      tags={"Categorías"},
     *      summary="Listar todas las categorías de la tienda",
     *      @OA\Response(
     *          response=200,
     *          description="Categorías listadas correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Category"
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
     *  )
     */
    public function index()
    {
        return parent::index();
    }


    /**
     *  Crea una nueva categoría
     *  @OA\Post(
     *      path="/api/categories",
     *      tags={"Categorías"},
     *      summary="Crear una nueva categoría en la tienda",
     *      @OA\RequestBody(
     *          request="StoreCategory",
     *          description="Datos de la categoría a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Category",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Categoría creada correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Category",
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
     *  ) 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Los datos de la categoría creada
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', 'unique:categories', new Name, 'between:3,50'],
            'description' => ['required', 'between:5,700'],
            'state' => ['filled', 'in:Activa,Inactiva']
        ]);
        //Almacenar la categoría en la base de datos
        return parent::store($request);
    }

    /**
     * Actualiza los datos de la categoría
     * @OA\Put(
     *      path="/api/categories/{id}",
     *      tags={"Categorías"},
     *      summary="Actualizar los datos de una nueva categoría en la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la categoría a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="UpdateCategory",
     *          description="Datos modificados de la categoría a actualizae",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Category",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Categoría actualizada correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Category",
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
     *  ) 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Id de la categoría a actualizar
     * @return \Illuminate\Http\Response Los nuevos datos de la categoría actualizada
     */
    public function update(Request $request, $id)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new Name, 'between:3,50'],
            'description' => ['required', 'between:5,700'],
            'state' => ['filled', 'in:Activa,Inactiva']
        ]);
        //Actualizar la categoría
        return parent::update($request, $id);
    }

    /**
     * Actualiza el estado de una categoría
     * @OA\Put(
     *      path="/api/categories/{id}/state/{state}",
     *      tags={"Categorías"},
     *      summary="Cambiar el estado de una categoría en la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la categoría a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="state",
     *          description="Nuevo estado de la categoría",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Se cambió el estado de la categoría correctamente",
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
     *  ) 
     * 
     * @param  int  $id Id de la categoría a actualizar el estado
     * @param  string $state Nuevo estado de la categoría
     * 
     * @return \Illuminate\Http\Response
     */
    public function state($id, $state)
    {
        //Validar los datos
        Validator::make(['id' => $id, 'state' => $state], [
            'id' => ['required', 'integer'],
            'state' => ['required', 'in:Activa,Inactiva']
        ])->validate();
        //Actualizar al nuevo estado
        return parent::updateMultipleRows([$id], ['state' => $state]);
    }

    /**
     * Inactiva las categorías
     * @OA\Put(
     *      path="/api/categories/state",
     *      tags={"Categorías"},
     *      summary="Inactivar las categorías de la tienda",
     *      @OA\RequestBody(
     *          request="Inactive Category",
     *          description="Ids de las categorías a inactivar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              examples={
     *                  @OA\Examples(
     *                      example="InactiveCategory(ies)", 
     *                      summary="Ejemplo de petición para inactivar categorías",
     *                      value={
     *                          "ids":{5,6,7,8}
     *                      }
     *                  ),
     *              },
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Ids",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Categorías inactivadas correctamente",
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
     *  )
     * 
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inactive(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Inactivar categorías
        return parent::updateMultipleRows($ids, ['state' => 'Inactiva']);
    }

    /**
     * @OA\Delete(
     *      path="/api/categories",
     *      tags={"Categorías"},
     *      summary="Eliminar las categorías de la tienda",
     *      @OA\RequestBody(
     *          request="Destroy Category",
     *          description="Ids de las categorías a eliminar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              examples={
     *                  @OA\Examples(
     *                      example="DestroyCategory(ies)", 
     *                      summary="Ejemplo de petición para eliminar categorías",
     *                      value={
     *                          "ids":{5,6,7,8}
     *                      }
     *                  ),
     *              },
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Ids",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Categorías eliminadas correctamente",
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
     *  )
     * 
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return parent::destroy($request);
    }
}
