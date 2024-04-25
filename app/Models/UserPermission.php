<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *  @OA\Schema(
 *      schema="UserPermission",
 *      description="Permisos del usuario",
 *      type="object",
 *      required={"permission_id","user_id"},
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         description="Id del registro del permiso del usuario en la base de datos"
 *     ),
 *      @OA\Property(
 *          property="permission_id",
 *          type="integer",
 *          description="Id del permiso del sistema"
 *      ),
 *      @OA\Property(
 *          property="permission",
 *          type="object",
 *          description="Permiso del sistema",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Permission")
 *          }
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          description="Id del usuario al que pertenece el permiso"
 *      ),
 *      @OA\Property(
 *          property="user",
 *          type="object",
 *          description="Usuario al que pertenece el permiso",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/User")
 *          }
 *      )
 *  ),
 */
class UserPermission extends BaseModel
{
    use HasFactory;

    /**
     * Obtener los datos del permiso del usuario
     * 
     * @return Permission El modelo de los datos del permiso del usuario
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * Obtener el usuario al que pertenece el permiso
     * 
     * @return User El modelo del usuario al que pertenece el permiso
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Incluir los datos del permiso del usuario en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->permission) {
            $data['permission'] = $this->permission;
        } else {
            $data['permission'] = null;
        }
        return $data;
    }
}
