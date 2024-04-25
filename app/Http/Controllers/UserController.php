<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\UserPermission;
use App\Rules\AlphaSpace;
use App\Rules\Avatar;
use App\Rules\Password;
use App\Rules\Phone;

class UserController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = User::class;

    /**
     * @OA\Get(
     *      path="/api/admins",
     *      tags={"Administradores"},
     *      summary="Listar todos los administradores de la tienda",
     *      @OA\Response(
     *          response=200,
     *          description="Administradores listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/User",
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
     * Crea un nuevo usuario
     * @OA\Post(
     *      path="/api/admins",
     *      tags={"Administradores"},
     *      summary="Crear un nuevo administrador de la tienda",
     *      @OA\RequestBody(
     *          request="StoreAdmin",
     *          description="Datos del nuevo administrador a crear",
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
     *          description="Administrador creado correctamente",
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
     * @return \Illuminate\Http\Response Los datos del nuevo usuario creado
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new AlphaSpace, 'between:3,40'],
            'lastName' => ['required', new AlphaSpace, 'between:3,60'],
            'avatar' => [new Avatar],
            'email' => ['required', 'email', 'unique:users'],
            'username' => ['required', 'alpha_num', 'unique:users'],
            'password' => ['required', new Password, 'between:5,100'],
            'gender' => ['filled', 'in:Masculino,Femenino,Otro'],
            'phone' => ['required', new Phone],
            'level' => ['filled', 'in:Administrador,Usuario'],
            'state' => ['filled', 'in:Activa,Bloqueada']
        ]);
        //Obtener los datos del usuario de la petición
        $data = $request->except('permissions');
        //Encriptar la contraseña
        $data['password'] = bcrypt($data['password']);
        //Almacenzar el usuario en la base de datos
        $user = User::create($data);
        //Añadir los permisos de usuario
        $permissionsIds = Str::of($request->permissions)->explode(',');
        $permissions = [];
        foreach ($permissionsIds as $permission) {
            $permissions[] = ['user_id' => $user->id, 'permission_id' => $permission];
            if ($permission == 1) break;
        }
        UserPermission::insert($permissions);
        //Refrescar el modelo
        $user->fresh();
        //Retornar los datos del usuario
        return response()->json($user);
    }

    /**
     * Actualiza los datos de un usuario
     * @OA\Put(
     *      path="/api/admins/{id}",
     *      tags={"Administradores"},
     *      summary="Actualizar los datos de un administrador de la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del administrador a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="UpdateCategory",
     *          description="Datos modificados del administrador a actualizar",
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
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Id del usuario a actualizar
     * @return \Illuminate\Http\Response Los datos modificados del usuario actualizado
     */
    public function update(Request $request, $id)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', '', new AlphaSpace, 'between:3,40'],
            'lastName' => ['required', new AlphaSpace, 'between:3,60'],
            'avatar' => [new Avatar],
            'email' => ['required', 'email'],
            'username' => ['required', 'alpha_num'],
            'password' => ['required', 'current_password', 'between:5,100'],
            'gender' => ['filled', 'in:Masculino,Femenino,Otro'],
            'phone' => ['required', new Phone],
            'level' => ['filled', 'in:Administrador,Usuario'],
            'state' => ['filled', 'in:Activa,Bloqueada']
        ]);
        //Obtener los datos del usuario de la petición
        $data = $request->except(['_method', 'password', 'permissions']);
        //Actualizar los datos
        User::where('id', $id)->update($data);
        //Obtener los datos del usuario actualizado
        $user = User::find($id);
        //Eliminar los permisos del usuario viejos
        UserPermission::where('user_id', $id)->delete();
        //Registrar los nuevos permisos del usuario
        $permissionsIds = Str::of($request->permissions)->explode(',');
        $permissions = [];
        foreach ($permissionsIds as $permission) {
            $permissions[] = ['user_id' => $id, 'permission_id' => $permission];
            if ($permission == 1) break;
        }
        UserPermission::insert($permissions);
        //Refrescar el modelo
        $user->fresh();
        //Retornar los nuevos datos del usuario
        return response()->json($user);
    }

    /**
     * Actualizar el estado de un usuario
     * @OA\Put(
     *      path="/api/admins/{id}/state/{state}",
     *      tags={"Administradores"},
     *      summary="Cambiar el estado de un administrador de la tienda",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del administrador a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="state",
     *          description="Nuevo estado del administrador",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Se cambió el estado del administrador correctamente",
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
     * @param  int  $id Id del usuario a actualizar el estado
     * @param  string $state Estado del usuario
     * @return \Illuminate\Http\Response
     */
    public function state($id, $state)
    {
        //Validar los datos
        Validator::make(['id' => $id, 'state' => $state], [
            'id' => ['required', 'integer'],
            'state' => ['required', 'in:Activa,Bloqueada']
        ])->validate();
        //Actualizar datos del usuario
        return parent::updateMultipleRows($id, ['state' => $state]);
    }

    /**
     * Bloquear usuarios pasados en los ids de la petición
     * @OA\Put(
     *      path="/api/admins/state",
     *      tags={"Administradores"},
     *      summary="Bloquear administradores de la tienda",
     *      @OA\RequestBody(
     *          request="Inactive Category",
     *          description="Ids de los administradores a inactivar",
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
     *          description="Administradores bloqueados correctamente",
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
        //Bloquear usuarios
        return parent::updateMultipleRows($ids, ['state' => 'Bloqueada']);
    }

    /**
     * @OA\Delete(
     *      path="/api/admins",
     *      tags={"Administradores"},
     *      summary="Eliminar los administradores de la tienda",
     *      @OA\RequestBody(
     *          request="DestroyAdmins",
     *          description="Ids de los administradores a eliminar",
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
     *          description="Administradores eliminados correctamente",
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
