<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sale;

use Carbon\Carbon;

class SaleController extends Controller
{

    protected $model = Sale::class;

    /**
     * @OA\Get(
     *      path="/api/sales",
     *      tags={"Ventas"},
     *      summary="Listar todos los registros de venta de la tienda",
     *      @OA\Response(
     *          response=200,
     *          description="Registros de ventas listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Sale",
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
        return response()->json(Sale::latest()->take(5)->get());
    }

    public function lastTwoMonths() {
        $date = Carbon::now();
        $date->day = 1;
        $sales = Sale::whereDate('created_at', '>=', $date->subMonths(1)->toDateString())->orderBy('created_at')->get();
        return response()->json($sales);
    }

    /**
     * Registra una nueva compra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Marca los registros de compra pasados en los ids de la petición como "Por entregar"
     * @OA\Put(
     *      path="/api/sales/delivered",
     *      tags={"Ventas"},
     *      summary="Marcar registros de ventas como 'Por entregar'",
     *      @OA\RequestBody(
     *          request="UnconfirmReview",
     *          description="Ids de los registros de ventas a marcar como 'Por entregar'",
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
     *          description="Registros de ventas marcados como 'Por entregar'",
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
    public function undelivered(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Actualizar registros
        return parent::updateMultipleRows($ids, ['state' => 'Por entregar']);
    }

    /**
     * Marca los registros de compra pasados en los ids de la petición como "Entregados"
     * @OA\Put(
     *      path="/api/sales/undelivered",
     *      tags={"Ventas"},
     *      summary="Marcar registros de ventas como 'Entregado'",
     *      @OA\RequestBody(
     *          request="UnconfirmReview",
     *          description="Ids de los registros de ventas a marcar como 'Entregado'",
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
     *          description="Registros de ventas marcados como 'Entregado' correctamente",
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
    public function delivered(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Actualizar registros
        return parent::updateMultipleRows($ids, ['state' => 'Entregado']);
    }
}
