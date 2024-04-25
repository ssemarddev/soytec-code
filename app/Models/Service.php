<?php

namespace App\Models;

/**
 *  @OA\Schema(
 *      schema="Service",
 *      description="Servicios de una cotización",
 *      type="object",
 *      required={"quotation_id","name","description"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id del servicio de la cotización en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="quotation_id",
 *          type="integer",
 *          description="Id de la cotización a la que pertenece el servicio",
 *          readOnly=true
 *      ),
 *      @OA\Property(
 *          property="quotation",
 *          type="object",
 *          description="Cotización a la que pertece el servicio",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Quotation")
 *          }
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre del servicio",
 *          minLength=3,
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Descripción del servicio",
 *          minLength=3,
 *          maxLength=700
 *      )
 *  ),
 */
class Service extends BaseModel
{
    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Obtener la cotización a la que pertenece este servicio
     * 
     * @return Quotation El modelo de la cotización al que pertenece este servicio
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
