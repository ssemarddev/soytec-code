<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Service;
use App\Rules\Name;

class QuotationController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Quotation::class;

    /**
     * @OA\Get(
     *      path="/api/quotations",
     *      tags={"Cotizaciones"},
     *      summary="Listar todas las cotizaciones de la tienda",
     *      @OA\Response(
     *          response=200,
     *          description="Cotizaciones listadas correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Quotation",
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
     * Crear una nueva cotización
     * @OA\Post(
     *      path="/api/quotations",
     *      tags={"Cotizaciones"},
     *      summary="Crear un nuevo administrador de la tienda",
     *      @OA\RequestBody(
     *          request="StoreQuotation",
     *          description="Datos de la cotización a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Quotation",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Cotización creada correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Quotation"
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
     * @return \Illuminate\Http\Response Los datos de la nueva cotización creada
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', new Name, 'unique:quotations', 'between:3,50'],
            'description' => ['required', 'between:5,100'],
        ]);
        //Obtener los datos de la petición
        $data = $request->except('services');
        //Crear la cotización
        $quotation = Quotation::create($data);
        //Añadir los servicios si se creó la cotización
        if ($quotation !== null) {
            $quotation->services()->createMany($request->services);
        }
        //Retornar el nuevo modelo
        return response()->json($quotation);
    }

    /**
     * Actualizar los datos de una cotización
     * @OA\Put(
     *      path="/api/quotations/{id}",
     *      tags={"Cotizaciones"},
     *      summary="Actualizar los datos de una cotización",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la cotización a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="UpdateQuotation",
     *          description="Datos modificados de la cotización a actualizar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Quotation",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Cotización actualizada correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Quotation",
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
     * @param  int  $id Id de la cotizacióna a actualizar
     * @return \Illuminate\Http\Response Los datos modificados de la cotización actualizada
     */
    public function update(Request $request, $id)
    {
        //Validar los datos
        $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'name' => ['required', new Name, 'between:3,50'],
            'description' => ['required', 'between:5,700'],
        ]);
        //Obtener los datos en la petición
        $data = $request->except(['_method', 'services']);
        //Actualizar el modelo
        Quotation::where('id', $id)->update($data);
        //Obtener el modelo cpm los datos actualizados
        $quotation = Quotation::find($id);
        //Eliminar los viejos servicios asociados a la cotización
        Service::where('quotation_id', $quotation->id)->delete();
        //Agregar nuevos servicios
        $quotation->services()->createMany($request->services);
        //Refrescar el modelo
        $quotation->refresh();
        //Retornar datos
        return response()->json($quotation);
    }

    /**
     * @OA\Delete(
     *      path="/api/quotations",
     *      tags={"Cotizaciones"},
     *      summary="Eliminar las cotizaciones",
     *      @OA\RequestBody(
     *          request="DestroyQuotations",
     *          description="Ids de las cotizaciones a eliminar",
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
     *          description="Cotizaciones eliminadas correctamente",
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
