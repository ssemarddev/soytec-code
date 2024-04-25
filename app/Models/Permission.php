<?php

namespace App\Models;

/**
 *  @OA\Schema(
 *      schema="Permission",
 *      description="Permisos del sistema",
 *      type="object",
 *      required={"permission","name"},
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         description="Id del permiso en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="permission",
 *          type="string",
 *          description="Clave del permiso",
 *          minLength=5,
 *          maxLength=100
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre descriptivo del permiso",
 *          minLength=5,
 *          maxLength=100
 *      ),
 *  ),
 */
class Permission extends BaseModel
{
    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;
}
