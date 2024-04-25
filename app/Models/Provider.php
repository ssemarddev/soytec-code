<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *  @OA\Schema(
 *      schema="Provider",
 *      description="Proveedor de piezas y/o herramientas",
 *      type="object",
 *      required={"name","email"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id del proveedor en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre del proveedor",
 *          minLength=3,
 *          maxLength=80
 *      ),
 *      @OA\Property(
 *          property="address",
 *          type="string",
 *          description="Dirección postal del proveedor",
 *          minLength=3,
 *          maxLength=200,
 *          default=""
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          description="Email del proveedor",
 *          minLength=3,
 *          maxLength=80
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string",
 *          description="Número de teléfono del proveedor",
 *          minLength=5,
 *          maxLength=15,
 *          default=""
 *      ),
 *      @OA\Property(
 *          property="website",
 *          type="string",
 *          description="Sitio web del proveedor",
 *          minLength=5,
 *          maxLength=100,
 *          default=""
 *      ),
 *      
 *  ),
 */
class Provider extends BaseModel
{
    use HasFactory;

    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;
}
