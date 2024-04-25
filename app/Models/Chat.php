<?php

namespace App\Models;

/**
 * @OA\Schema(
 *      schema="Chat",
 *      description="Chat del módulo de soporte",
 *      type="object",
 *      required={"title"},
 *      @OA\Property(
 *          property="title",
 *          type="string",
 *          description="Nombre del chat",
 *          minLength=3,
 *          maxLength=100
 *      ),
 *      @OA\Property(
 *          property="closed",
 *          type="boolean",
 *          description="<code>true</code> si el chat está cerrado o <code>false</code> si no"
 *      ),
 *      @OA\Property(
 *          property="messages",
 *          type="array<Message>",
 *          description="Mensajes del chat",
 *          
 *      ),
 * )
 */
class Chat extends BaseModel
{

    /**
     * Obtener los mensajes del chat
     * 
     * @return array<Message> Todos los mensajes pertenecientes al chat
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Incluir los mensajes del chat en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->messages) {
            $data['messages'] = $this->messages;
        } else {
            $data['messages'] = [];
        }
        return $data;
    }
}
