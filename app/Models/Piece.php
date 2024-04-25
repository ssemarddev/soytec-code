<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Piece",
 *     description="Pieza o herramienta en el invetario",
 *     type="object",
 *     required={"name","description","unit_id"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre de la pieza o herramienta",
 *         minLength=3,
 *         maxLength=60
 *     ),
 *     @OA\Property(
 *         property="model",
 *         type="string",
 *         description="Modelo de la pieza o herramienta",
 *         minLength=3,
 *         maxLength=60,
 *         default="null"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Descripción de la pieza o herramienta",
 *         minLength=3,
 *         maxLength=700
 *     ),
 *     @OA\Property(
 *         property="unit_id",
 *         type="iteger",
 *         description="Id de la unidad de medida de la pieza o herramienta",
 *     ),
 *     @OA\Property(
 *         property="unit",
 *         type="object",
 *         description="Unidad de medida de la pieza o herramienta",
 *         ref="#/components/schemas/Unit"
 *     )
 * ),
 */
class Piece extends BaseModel
{
    use HasFactory;

    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Obtener la unidad de medida
     * 
     * @return Unit Unidad de medida de la pieza o herramienta en inventario
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Incluir la unidad de medida en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->unit) {
            $data['unit'] = $this->unit->name;
        } else {
            $data['unit'] = null;
        }
        return $data;
    }
}
