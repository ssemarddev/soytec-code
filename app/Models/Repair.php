<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

/**
 *  @OA\Schema(
 *      schema="Repair",
 *      description="Equipo en el taller de reparación",
 *      type="object",
 *      required={"name","price","state","finished"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id del equipo en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre del equipo en el taller",
 *          minLength=3,
 *          maxLength=60
 *      ),
 *      @OA\Property(
 *          property="reference",
 *          type="string",
 *          description="Id de referencia del equipo en el taller",
 *          minLength=12,
 *          maxLength=12,
 *          readOnly=true
 *      ),
 *      @OA\Property(
 *          property="price",
 *          type="double",
 *          description="Monto total de la reparación (con impuesto incluído)"
 *      ),
 *      @OA\Property(
 *          property="payType",
 *          type="string",
 *          description="Tipo de método de pago usado para abonar el costo total de la reparación",
 *          enum={"Efectivo", "Stripe","Paypal","Mercado Pago"},
 *          default="Efectivo"
 *      ),
 *      @OA\Property(
 *          property="state",
 *          type="string",
 *          description="Estado de la reparación.",
 *          minLength=3,
 *          maxLength=100
 *      ),
 *      @OA\Property(
 *          property="finished",
 *          type="dateTime",
 *          description="Fecha de terminación aproximada de la reparación."
 *      ),
 *      @OA\Property(
 *          property="delivered",
 *          type="boolean",
 *          description="<code>true</code> si el producto fue entregado al cliente o <code>false</code> si aún no ha sido entregado.",
 *          default="false"
 *      ),
 *  ),
 */
class Repair extends BaseModel
{
    use HasFactory;

    /**
     * Crear un array a partir de las etiquetas del equipo en el taller e incluirlo como un atributo más del modelo
     * 
     * @return array Etiquetas del modelo agrupadas en un Array
     */
    public function getTagsAttribute()
    {
        return Str::of($this->attributes['tags'])->explode(',');
    }
}
