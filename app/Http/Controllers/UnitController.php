<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Unit::class;

    /**
     *  @OA\Get(
     *      path="/api/units",
     *      tags={"Unidades de medida"},
     *      summary="Listar todas las unidades de medida del sistema",
     *      @OA\Response(
     *          response=200,
     *          description="Unidades de medidas listadas correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Unit",
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
}
