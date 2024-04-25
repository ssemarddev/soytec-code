<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Rules\Name;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RepairController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Repair::class;

    /**
     * @OA\Get(
     *      path="/api/repairs",
     *      tags={"Equipos del taller"},
     *      summary="Listar todos los equipos del taller",
     *      @OA\Response(
     *          response=200,
     *          description="Equipos del taller listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Repair",
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

    public function latest()
    {
        return response()->json(Repair::latest('finished')->take(4)->get());
    }

    /**
     * Registra un nuevo equipo en el taller
     * @OA\Post(
     *      path="/api/repairs",
     *      tags={"Equipos del taller"},
     *      summary="Registra un nuevo equipo en el taller",
     *      @OA\RequestBody(
     *          request="StoreRepair",
     *          description="Datos del nuevo equipo a registrar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Repair",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Equipo registrado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Repair"
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
     * @return \Illuminate\Http\Response Los datos del nuevo equipo registrado
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new Name, 'between:3,60'],
            'contact' => ['required', new Phone],
            'price' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'payType' => ['filled', 'in:Efectivo,Paypal,Mercado Pago,Stripe'],
            'state' => ['required'],
            'finished' => ['required', 'date_format:Y-m-d H:i'],
            'tags' => ['required']
        ]);
        //Obtener los datos de la petición
        $data = $request->all();
        //Crear el id del referencia
        $data['reference'] = bin2hex(random_bytes(6));
        //Crear la instancia del modelo en la base de datos
        $repair = Repair::create($data);
        //Retornar el nuevo modelo
        return response()->json($repair);
    }

    /**
     * Actualiza los datos de un equipo del taller
     * @OA\Put(
     *      path="/api/repairs/{id}",
     *      tags={"Equipos del taller"},
     *      summary="Actualizar los datos de un equipo del taller",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del equipo a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="UpdateRepair",
     *          description="Datos modificados del equipo a actualizar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Repair",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Equipo actualizado correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Repair",
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
     * @param  int  $id Id del equipo a actualizar
     * @return \Illuminate\Http\Response Los datos modificados del equipo actualizado
     */
    public function update(Request $request, $id)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new Name, 'between:3,60'],
            'contact' => ['required', new Phone],
            'price' => ['required', 'regex:/^[\d.]+$/', 'between:1,12'],
            'payType' => ['filled', 'in:Efectivo,Paypal,Mercado Pago,Stripe'],
            'state' => ['required'],
            'finished' => ['required', 'date_format:Y-m-d H:i'],
            'tags' => ['required']
        ]);
        //Actualizar los datos
        return parent::update($request, $id);
    }

    /**
     * Actualiza el estado de una reparación
     * @OA\Put(
     *      path="/api/repairs/{id}/state/{state}",
     *      tags={"Equipos del taller"},
     *      summary="Actualizar el estado de un equipo en reparación del taller",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id del equipo a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="state",
     *          description="Nuevo estado del equipo",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Se cambió el estado del equipo correctamente",
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
     * @param  int  $id Id del equipo a actualizar
     * @return \Illuminate\Http\Response
     */
    public function state(Request $request, $id)
    {
        //Validar los datos
        Validator::make(['id' => $id, 'state' => $request->state], [
            'id' => ['required', 'integer'],
            'state' => ['required']
        ])->validate();
        //Actualizar el equipo
        return parent::updateMultipleRows([$id], ['state' => $request->state]);
    }

    /**
     * Marca una reparación como lista para recoger
     * @OA\Put(
     *      path="/api/repairs/state",
     *      tags={"Equipos del taller"},
     *      summary="Marcar una reparación como 'Lista para recoger'",
     *      @OA\RequestBody(
     *          request="RepairsReady",
     *          description="Ids de los equipos del taller a marcar como 'Listos para recoger'",
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
     *          description="Equipos del taller marcados como 'Listos para recoger'",
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
    public function ready(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Actualizar el equipo
        return parent::updateMultipleRows($ids, ['state' => 'Listo para recoger']);
    }

    /**
     * @OA\Delete(
     *      path="/api/repairs",
     *      tags={"Equipos del taller"},
     *      summary="Eliminar los equipos del taller",
     *      @OA\RequestBody(
     *          request="DestroyRepairs",
     *          description="Ids de los equipos del taller a eliminar",
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
     *          description="Equipos del taller eliminados correctamente",
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
