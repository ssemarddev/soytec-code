<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Rules\AlphaSpace;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Piece::class;

    /**
     * @OA\Get(
     *      path="/api/pieces",
     *      tags={"Inventario"},
     *      summary="Listar todas las entradas del inventario del taller",
     *      @OA\Response(
     *          response=200,
     *          description="Administradores listados correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Piece",
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
     * Crea una nueva entrada en el inventario del taller
     * @OA\Post(
     *      path="/api/pieces",
     *      tags={"Inventario"},
     *      summary="Crear una nueva entrada en el inventario",
     *      @OA\RequestBody(
     *          request="StorePiece",
     *          description="Datos de la nueva entrada en el inventario a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Piece",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Entrada creada correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Piece"
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
            'name' => ['required', new AlphaSpace, 'between:3,60'],
            'model' => ['filled', new AlphaSpace, 'between:3,60'],
            'description' => ['required', 'between:5,700'],
            'username' => ['required', 'alpha_num', 'unique:users'],
            'stock' => ['required', 'integer'],
            'unit_id' => ['required', 'exists:units']
        ]);
        return parent::store($request);
    }

    /**
     * Actualiza los datos de una entrada en el inventario del taller
     * @OA\Put(
     *      path="/api/pieces/{id}",
     *      tags={"Inventario"},
     *      summary="Actualizar los datos de una entrada del inventario del taller",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la la entrada del formulario a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="UpdatePiece",
     *          description="Datos modificados de la entrada en el inventario a actualizar",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Piece",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Entrada actualizada correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Piece",
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
     * @param  int  $id Id del usuario a actualizar
     * @return \Illuminate\Http\Response Los datos modificados del usuario actualizado
     */
    public function update(Request $request, $id)
    {
        //Validar los datos
        $request->validate([
            'name' => ['required', new AlphaSpace, 'between:3,60'],
            'model' => ['filled', new AlphaSpace, 'between:3,60'],
            'description' => ['required', 'between:5,700'],
            'username' => ['required', 'alpha_num', 'unique:users'],
            'stock' => ['required', 'integer'],
            'unit_id' => ['required', 'exists:units']
        ]);
        return parent::update($request, $id);
    }

    /**
     * @OA\Delete(
     *      path="/api/pieces",
     *      tags={"Inventario"},
     *      summary="Eliminar las entradas del inventario del taller",
     *      @OA\RequestBody(
     *          request="DestroyPieces",
     *          description="Ids de las entradas a eliminar",
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
     *          description="Entradas eliminadas correctamente",
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
