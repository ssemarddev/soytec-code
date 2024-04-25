<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Rules\Name;
use App\Rules\Phone;
use App\Rules\WebSite;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Provider::class;

    /**
     * @OA\Get(
     *      path="/api/providers",
     *      tags={"Proveedores"},
     *      summary="Listar todos los proveedores del taller",
     *      @OA\Response(
     *          response=200,
     *          description="Proveedores listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Provider",
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
     * Crea un nuevo proveedor
     * @OA\Post(
     *      path="/api/providers",
     *      tags={"Proveedores"},
     *      summary="Crear un nuevo proveedor del taller",
     *      @OA\RequestBody(
     *          request="StoreProvider",
     *          description="Datos del nuevo proveedor a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/User",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Proveedor creado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/User"
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
     * @return \Illuminate\Http\Response Los datos del nuevo proveedor registrado
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new Name, 'unique:providers', 'between:3,80'],
            'address' => ['filled', 'between:5,200'],
            'email' => ['required', 'email', 'between:5,80'],
            'phone' => ['filled', new Phone, 'between:5,20'],
            'website' => ['filled', new WebSite, 'between:5,100'],
        ]);
        //Crear el proveedor
        return parent::store($request);
    }

    /**
     * Actualiza los datos de un proveedor
     * @OA\Put(
     *      path="/api/providers/{id}",
     *      tags={"Proveedores"},
     *      summary="Actualizar los datos de un proveedor del taller",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del proveedor a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="UpdateProvider",
     *          description="Datos modificados del proveedor a actualizar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/User",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Administrador actualizado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/User",
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Id del proveedor a actualizar
     * @return \Illuminate\Http\Response Los datos del proveedor actualizados
     */
    public function update(Request $request, $id)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new Name, 'between:3,80'],
            'address' => ['filled', 'between:5,200'],
            'email' => ['required', 'email', 'between:5,80'],
            'phone' => ['filled', new Phone, 'between:5,20'],
            'website' => ['filled', 'url', 'between:5,100'],
        ]);
        //Actualizar datos del proveedor
        return parent::update($request, $id);
    }

    /**
     * @OA\Delete(
     *      path="/api/providers",
     *      tags={"Proveedores"},
     *      summary="Eliminar los proveedores del taller",
     *      @OA\RequestBody(
     *          request="DestroyAdmins",
     *          description="Ids de los proveedores a eliminar",
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
     *          description="Proveedores eliminados correctamente",
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
