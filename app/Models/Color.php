<?php

namespace App\Models;

/**
 * @OA\Schema(
 *      schema="Color",
 *      description="Chat del módulo de soporte",
 *      type="object",
 *      required={"title"},
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre del color",
 *          minLength=3,
 *          maxLength=60
 *      ),
 *      @OA\Property(
 *          property="color",
 *          type="string",
 *          description="Valor hexadecimal (#rrggbb) del color",
 *          minLength=6,
 *          maxLength=7
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          type="int",
 *          description="Id del producto al que pertenece el color"
 *      ),
 *      @OA\Property(
 *          property="images",
 *          type="array",
 *          description="Imágenes del color",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Image")
 *          }
 *      ),
 * )
 */
class Color extends BaseModel
{

    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Obtener los mensajes del chat
     * 
     * @return array<Image> Todos los mensajes pertenecientes al chat
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Incluir los mensajes del chat en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->images) {
            $data['images'] = $this->images;
        } else {
            $data['images'] = [];
        }
        return $data;
    }
}
