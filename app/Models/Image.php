<?php

namespace App\Models;

/**
 * @OA\Schema(
 *      schema="Image",
 *      description="Chat del módulo de soporte",
 *      type="object",
 *      required={"title"},
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre del archivo",
 *          minLength=3,
 *          maxLength=30
 *      ),
 *      @OA\Property(
 *          property="color_id",
 *          type="int",
 *          description="Id del color al que pertenece la imagen"
 *      ),
 *      @OA\Property(
 *          property="color",
 *          type="Object",
 *          readOnly="true",
 *          description="Modelo del color al que pertece la imagen",
 *          ref="#/components/Schemas/Color"
 *      ),
 * )
 */
class Image extends BaseModel
{

    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Crear un array a partir de las etiquetas del producto e incluirlo como un atributo más del modelo
     * 
     * @return array Etiquetas del modelo agrupadas en un Array
     */
    public function getUrlAttribute()
    {
        return asset("src/img/$this->name");
    }

    /**
     * Obtener los mensajes del chat
     * 
     * @return Color Modelo del color al que pertenece la imagen
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Incluir la categoria del producto en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        $data['url'] = $this->url;
        return $data;
    }
}
