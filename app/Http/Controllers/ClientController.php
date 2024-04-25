<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\Client;
use App\Rules\AlphaSpace;
use App\Rules\Password;
use App\Rules\Phone;

class ClientController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Client::class;

    /**
     * @OA\Get(
     *      path="/api/clients",
     *      tags={"Clientes"},
     *      summary="Listar todos los clientes del taller",
     *      @OA\Response(
     *          response=200,
     *          description="Clientes listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Client",
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
     * Registra un nuevo cliente
     * @OA\Post(
     *      path="/api/clients",
     *      tags={"Clientes"},
     *      summary="Crear un nuevo cliente del taller",
     *      @OA\RequestBody(
     *          request="StoreClient",
     *          description="Datos del nuevo cliente a registrar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Client",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Cliente creado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Client"
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
     * @return \Illuminate\Http\Response Los datos del nuevo cliente generado
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new AlphaSpace, 'between:3,40'],
            'lastName' => ['filled', new AlphaSpace, 'between:3,60'],
            'avatar' => ['filled', 'image', Rule::dimensions()->minWidth(500)->minHeight(500), 'between:3,2048'],
            'email' => ['required', 'email', 'unique:clients'],
            'password' => ['required', new Password, 'between:5,100'],
            'gender' => ['filled', 'in:Masculino,Femenino,Otro'],
            'phone' => ['filled', new Phone],
            'province' => ['filled', new AlphaSpace, 'between:5,30'],
            'city' => ['filled', new AlphaSpace, 'between:5,30'],
            'address' => ['filled', 'between:5,70'],
            'state' => ['filled', 'in:Activa,Bloqueada']
        ]);
        //Registrar cliente
        //Obtener los datos de la petición
        $data = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('users', 'images');
            $data['avatar'] = $path;
        }
        if(!isset($data['gender'])) {
            $data['gender'] = 'Otro';
        }
        $data['password'] = bcrypt($data['password']);
        $client = Client::create($data);
        //Retornar el nuevo modelo
        return response()->json($client);
    }

    /**
     * Actualizar el estado de un cliente
     * @OA\Put(
     *      path="/api/clients/{id}/state/{state}",
     *      tags={"Clientes"},
     *      summary="Cambiar el estado de un cliente del taller",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del cliente a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="state",
     *          description="Estado del cliente",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Se cambió el estado del cliente correctamente",
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
     * @param  int  $id Id del cliente a actualizar el estado
     * @param  string $state Nuevo estado del cliente
     * @return \Illuminate\Http\Response
     */
    public function state($id, $state)
    {
        //Validar los datos
        Validator::make(['id' => $id, 'state' => $state], [
            'id' => ['required', 'integer'],
            'state' => ['required', 'in:Activa,Bloqueada']
        ])->validate();
        return parent::updateMultipleRows([$id], ['state' => $state]);
    }

    /**
     * Bloquear los clientes pasados en los ids de la petición
     * @OA\Put(
     *      path="/api/clients/state",
     *      tags={"Clientes"},
     *      summary="Bloquear clientes del taller",
     *      @OA\RequestBody(
     *          request="BanClient",
     *          description="Ids de los clientes a bloquear",
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
     *          description="Clientes bloqueados correctamente",
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
        //Actualizar nuevos estados de los usuarios
        return parent::updateMultipleRows($ids, ['state' => 'Bloqueada']);
    }

    /**
     * @OA\Delete(
     *      path="/api/clients",
     *      tags={"Clientes"},
     *      summary="Eliminar los clientes del taller",
     *      @OA\RequestBody(
     *          request="DestroyClients",
     *          description="Ids de los clientes a eliminar",
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
     *          description="Clientes eliminados correctamente",
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
