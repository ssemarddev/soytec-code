<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Permission::class;

    /**
     * @OA\Get(
     *      path="/api/permissions",
     *      tags={"Permisos del sistema"},
     *      summary="Listar todos los permisos del sistema",
     *      @OA\Response(
     *          response=200,
     *          description="Permisos listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Permission",
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
}
