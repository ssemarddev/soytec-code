<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     schema="Message",
 *     description="Mensajes de un chat de soporte técnico",
 *     type="object",
 *     required={"chat_id","message"},
 *     @OA\Property(
 *         property="chat_id",
 *         type="integer",
 *         description="Id del chat al que pertence este mensaje"
 *     ),
 *     @OA\Property(
 *         property="chat",
 *         type="object",
 *         description="Chat al que pertence este mensaje",
 *         ref="#/components/schemas/Chat"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="Id del usuario que envió este mensaje o <code>null</code> si fue enviado por soporte técnico",
 *         default="null"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         description="Usuario que envió este mensaje o <code>null</code> si fue enviado por soporte técnico",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OA\Property(
 *         property="client_id",
 *         type="integer",
 *         description="Id del cliente que envió este mensaje o <code>null</code> si no fue enviado por ningún cliente",
 *         default="null"
 *     ),
 *     @OA\Property(
 *         property="client",
 *         type="object",
 *         description="Cliente que envió este mensaje o <code>null</code> si no fue enviado por ningún cliente",
 *         ref="#/components/schemas/Client",
 *         default="null"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Texto del mensaje",
 *         minLength=3,
 *         maxLength=700
 *     ),
 *     @OA\Property(
 *         property="annexed",
 *         type="string",
 *         description="Nombre de la imagen anexada al mensaje o <code>null</code> si no hay ninguna imagen anexada",
 *         default="null"
 *     ),
 * ),
 */
class Message extends BaseModel
{

    /**
     * Obtener el chat del mensaje
     * 
     * @return Chat El modelo del chat del mensaje
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Obtener el usuario que envió el mensaje
     * 
     * @return User El modelo del usuario que envió el mensaje o <code>null</code> si fue enviado por Soporte Técnico
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el cliente que envió el mensaje
     * 
     * @return Client El modelo del cliente que envió el mensaje o <code>null</code> si fue enviado por Soporte Técnico
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Incluir el usuario que envió el mensaje en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->user) {
            $data['user'] = $this->user;
        } else {
            $data['user'] = null;
        }
        if ($this->client) {
            $data['client'] = $this->client;
        } else {
            $data['client'] = null;
        }
        return $data;
    }
}
