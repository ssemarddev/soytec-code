<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     schema="Review",
 *     description="Reseñas hechas por los usuarios",
 *     type="object",
 *     required={"client_id","comment","review"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         description="Id del producto en la base de datos"
 *     ),
 *     @OA\Property(
 *         property="client_id",
 *         type="integer",
 *         description="Id del cliente que hizo la reseña"
 *     ),
 *     @OA\Property(
 *         property="client",
 *         type="object",
 *         description="Cliente que hizo la reseña",
 *         readOnly=true,
 *         allOf={
 *             @OA\Schema(ref="#/components/schemas/Client")
 *         }
 *     ),
 *     @OA\Property(
 *         property="comment",
 *         type="string",
 *         description="Comentario de la reseña",
 *         minLength=3,
 *         maxLength=300
 *     ),
 *     @OA\Property(
 *         property="review",
 *         type="integer",
 *         description="Cantidad de estrellas de la reseña",
 *         minimum=1,
 *         maximum=5
 *     ),
 *     @OA\Property(
 *         property="confirmed",
 *         type="boolean",
 *         description="<code>true</code> si la reseña fue confirmada y será visible para los clientes o <code>false</code> si no.",
 *         default="false"
 *     ),
 * ),
 */
class Review extends BaseModel
{
    /**
     * Obtener el cliente que realizó la reseña
     * 
     * @return Client El modelo del cliente que hizo la reseña
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Incluir el cliente que hizo la reseña en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->client) {
            $data['client'] = $this->client;
        } else {
            $data['client'] = null;
        }
        return $data;
    }
}
