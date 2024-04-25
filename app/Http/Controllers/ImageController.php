<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class ImageController extends BaseController
{

    /**
     * @OA\Delete(
     *      path="/api/images/{id}",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la imagen a eliminar",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      tags={"Imágenes"},
     *      summary="Eliminar imagen de un producto",
     *      @OA\Response(
     *          response=200,
     *          description="Imagen eliminada correctamente",
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
    public function destroy($id)
    {
        $image = Image::find($id);
        $name = $image->name;
        if ($image->delete() == 1) {
            Storage::disk('images')->delete($name);
        }
        return response('');
    }
}
