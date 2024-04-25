<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @OA\Info(
 *      version="1.0.0", 
 *      title="Documentación de la API de Soytec",
 *      description="Documentación de la API de Soytec.",
 * 
 *      @OA\Contact(
 *          name="MSomnium",
 *          url="https://www.github.com",
 *          email="msomnium.info@gmail.com"
 *      ),
 * 
 *      @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     ),
 * ),
 * 
 *     @OA\Component(
 *         @OA\Schema(
 *         schema="Ids",
 *         description="Ids de los registros usados para operaciones comunones (actualizar|eliminar)",
 *         type="object",
 *         required={"ids"},
 *         @OA\Property(
 *             title="ids",
 *             type="array",
 *             description="Ids de los registros",
 *             items={"integer"},

 *         )
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer Token de autorización",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Error al validar los datos de la petición",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 format="string",
 *                 description="Mensaje general del error"
 *             ),
 *             @OA\Property(
 *                 property="errors",
 *                 format="object<key<array>>",
 *                 description="Mensajes de error de todas los parámetros que no fueron validados"
 *             ),
 *             examples={
 *                 @OA\Examples(
 *                     example="UnprocessableContentError", 
 *                     summary="Error al validar los datos de la petición",
 *                     value={
 *                         "message":"The description must be between 5 and 1000 characters.",
 *                          "errors":{
 *                              "description":{
 *                                  "The description must be between 5 and 1000 characters."
 *                               }
 *                          }
 *                     }
 *                 ),
 *             },
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Error de autenticación o el token ha expirado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 format="string",
 *                 description="Mensaje de error de autenticación",
 *                 default="Unauthenticated.",
 *             ),
 *             examples={
 *                 @OA\Examples(
 *                     example="UnprocessableContentError", 
 *                     summary="Error al autenticar el usuario o no se ha enviado el token",
 *                     value={
 *                         "message":"Unauthenticated."
 *                     }
 *                 ),
 *             },
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error en el servidor",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 format="string",
 *                 description="Mensaje de error en el servidor",
 *                 default="Server Error.",
 *             ),
 *             examples={
 *                 @OA\Examples(
 *                     example="UnprocessableContentError", 
 *                     summary="Error en el servidor al hacer la petición",
 *                     value={
 *                         "message":"Server Error."
 *                     }
 *                 ),
 *             },
 *         )
 *     )
 * ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Modelo al cuál está enlazado el controlador
     * @var Model
     */
    protected $model;

    /**
     * Obtener lista de registros
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->model::all());
    }

    /**
     * Crea un nuevo registro en la base de datos
     *
     * @return \Illuminate\Http\Response Los datos del nuevo registro
     */
    public function store(Request $request)
    {
        //Crear la instancia del modelo en la base de datos
        $data = $request->all();
        $item = $this->model::create($data);
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    /**
     * Actualiza un registro de la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id Id del registro a actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Obtener datos de la petición
        $data = $request->except(['_method']);
        //Actualizar el modelo
        $this->model::where('id', $id)->update($data);
        //Retornar el nuevo modelo
        $item = $this->model::find($id);
        return response()->json($item);
    }

    /**
     * Eliminar registros de la base de datos a partir de los ids pasados en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Obtener ids
        $ids = Str::of($request->ids)->explode(',');
        //Eliminar los modelos
        $this->model::ids($ids)->delete();
        //Retornar respuesta
        return response('', 200);
    }

    /**
     * Actualiza varios registros a la vez
     *
     * @param  array  $ids Ids de los registros a actualizar
     * @param  array $data Nuevos datos de los registros
     * @return \Illuminate\Http\Response
     */
    public function updateMultipleRows($ids, $data)
    {
        //Actualizar los registros
        $this->model::ids($ids)->update($data);
        //Retornar código de estado 200
        return response('', 200);
    }
}
