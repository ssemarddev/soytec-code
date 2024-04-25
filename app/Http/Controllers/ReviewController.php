<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Review::class;

    /**
     * @OA\Get(
     *      path="/api/reviews",
     *      tags={"Reseñas"},
     *      summary="Listar todas las reseñas del taller",
     *      @OA\Response(
     *          response=200,
     *          description="Reseñas listadas correctamente",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(
     *                  ref="#/components/schemas/Review"
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
     * Registra una reseña de un usuario
     * @OA\Post(
     *      path="/api/reviews",
     *      tags={"Reseñas"},
     *      summary="Crear una nueva reseña del taller",
     *      @OA\RequestBody(
     *          request="StoreReview",
     *          description="Datos de la nueva reseña a crear",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  ref="#/components/schemas/Review",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Reseña creada correctamente",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/Review"
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
     * @return \Illuminate\Http\Response Los datos de la nueva reseña
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'review' => ['required', 'in:1,2,3,4,5'],
            'comment' => ['required', 'between:10,300'],
            'confirmed' => ['filled', 'in:true,false'],
        ]);
        //Crear la reseña en la base de datos
        return parent::store($request);
    }

    /**
     * Confirmar una reseña para que pueda ser mostrada al resto de usuarios
     * @OA\Put(
     *      path="/api/reviews/confirmed",
     *      tags={"Reseñas"},
     *      summary="Confirmar una reseña de un cliente del taller",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la reseña a actualizar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          request="ConfirmReview",
     *          description="Ids de las reseñas a confirmar",
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
     *          description="Reseñas confirmadas correctamente",
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
    public function confirmed(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Actualizar reseña
        return parent::updateMultipleRows($ids, ['confirmed' => true]);
    }

    /**
     * No confirmar una reseña, para que quede oculta al resto de usuarios
     * @OA\Put(
     *      path="/api/reviews/unconfirmed",
     *      tags={"Reseñas"},
     *      summary="Desconfirmar una reseña de un cliente del taller",
     *      @OA\RequestBody(
     *          request="UnconfirmReview",
     *          description="Ids de las reseñas a desconfirmar",
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
     *          description="Reseñas desconfirmadas correctamente",
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
    public function unconfirmed(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Actualizar reseña
        return parent::updateMultipleRows($ids, ['confirmed' => false]);
    }

    /**
     * @OA\Delete(
     *      path="/api/reviews",
     *      tags={"Reseñas"},
     *      summary="Eliminar las reseñas del taller",
     *      @OA\RequestBody(
     *          request="DestroyReviews",
     *          description="Ids de las reseñas a eliminar",
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
     *          description="Reseñas eliminadas correctamente",
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
