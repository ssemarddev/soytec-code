<?php

namespace App\Models;

/**
 *  @OA\Schema(
 *      schema="Unit",
 *      description="Unidades de medida del sistema",
 *      type="object",
 *      required={"name","description","type"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id de la unidad de medida en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre de la unidad de medida",
 *          minLength=3,
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Descripción de la unidad de medida",
 *          minLength=3,
 *          maxLength=200
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          description="Tipo de unidad de medida",
 *          enum={"Peso","Volumen","Longitud","Cantidad"},
 *      ),
 *  ),
 */
class Unit extends BaseModel
{
    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;
}
