<?php

namespace App\Models;

/**
 *  @OA\Schema(
 *      schema="Category",
 *      description="Categoría de la tienda",
 *      type="object",
 *      required={"name","description"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id de la categoría en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre de la categoría",
 *          minLength=3,
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Descripción de la categoría",
 *          pattern="[A-Za-z0-9 (),%\.¡!´:#]",
 *          minLength=3,
 *          maxLength=700
 *      ),
 *      @OA\Property(
 *          property="state",
 *          type="string",
 *          description="Estado de la categoría",
 *          enum={"Activa","Inactiva"},
 *          default="Activa"
 *      ),
 *  ),
 */
class Category extends BaseModel
{
    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;
}
