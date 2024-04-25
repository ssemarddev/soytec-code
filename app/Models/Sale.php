<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *  @OA\Schema(
 *      schema="Sale",
 *      description="Registro de venta",
 *      type="object",
 *      required={"client_id","price","total"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id del registro de ventas en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="client_id",
 *          type="integer",
 *          description="Id del cliente que realizó la compra en la tienda",
 *      ),
 *      @OA\Property(
 *          property="client",
 *          type="object",
 *          description="Cliente que realizó la compra en la tienda",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Client")
 *          }
 *      ),
 *      @OA\Property(
 *          property="price",
 *          type="double",
 *          description="Monto de la venta sin impuestos",
 *      ),
 *      @OA\Property(
 *          property="tax",
 *          type="double",
 *          description="Impuestos de la compra",
 *          default="0.00"
 *      ),
 *      @OA\Property(
 *          property="total",
 *          type="double",
 *          description="Monto total de la venta con impuestos",
 *      ),
 *      @OA\Property(
 *          property="payType",
 *          type="string",
 *          description="Tipo de método de pago usado para abonar el costo total de la venta",
 *          enum={"Efectivo", "Stripe","Paypal","Mercado Pago"},
 *          default="Efectivo"
 *      ),
 *      @OA\Property(
 *          property="state",
 *          type="string",
 *          description="Estado de la venta",
 *          enum={"Entregado","Por entregar"},
 *          default="Por entregar"
 *      ),
 *  ),
 */
class Sale extends BaseModel
{
    use HasFactory;

    /**
     * Obtener el cliente que realizó la compra
     * 
     * @return Client El modelo del cliente que realizó la compra
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Incluir el cliente que realizó la compra en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        // change the value of the 'mime' key
        if ($this->client) {
            $data['client'] = $this->client;
        } else {
            $data['client'] = null;
        }
        return $data;
    }
}
