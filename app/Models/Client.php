<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *      schema="Client",
 *      description="Cliente registrado en el sistema",
 *      type="object",
 *      required={"name", "lastName", "avatar", "email", "password"},
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         description="Id del cliente en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre(s) del cliente",
 *          minLength=3,
 *          maxLength=40
 *      ),
 *      @OA\Property(
 *          property="lastName",
 *          type="string",
 *          description="Apellidos del cliente",
 *          minLength=3,
 *          maxLength=60
 *      ),
 *      @OA\Property(
 *          property="avatar",
 *          type="string",
 *          description="Nombre del archivo en el directorio 'src/img/avatars/' que se usuará como avatar del cliente",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          description="Email del cliente",
 *          minLength=3,
 *          maxLength=100
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="string",
 *          description="Contraseña del cliente",
 *          readOnly=true
 *      ),
 *      @OA\Property(
 *         property="gender",
 *         type="string",
 *         description="Género del cliente",
 *         enum={"Otro","Femenino", "Masculino"},
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string",
 *          description="Número de teléfono del cliente"
 *      ),
 *      @OA\Property(
 *          property="province",
 *          type="string",
 *          description="Estado, provincia o condado donde vive  del cliente",
 *          minLength=3,
 *          maxLength=30
 *      ),
 *      @OA\Property(
 *          property="city",
 *          type="string",
 *          description="Ciudad donde vive cliente",
 *          minLength=3,
 *          maxLength=30
 *      ),
 *      @OA\Property(
 *          property="address",
 *          type="string",
 *          description="Dirección postal del cliente",
 *          minLength=3,
 *          maxLength=70
 *      ),
 *      @OA\Property(
 *         property="state",
 *         type="string",
 *         description="Estado del cliente",
 *         enum={"Activa", "Bloqueada"},
 *         default="Bloqueada"
 *      )
 * )
 */
class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Indica que todos los atributos pueden ser asignados de forma masiva
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Los atributos que estarán ocultos en el array de salida del modelo
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope para incluir todos los registros con los ids pasados en el argumento $ids
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param array $ids Ids de los modelos a incluir en el scope
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIds($query, $ids)
    {
        foreach ($ids as $id) {
            $query = $query->orWhere('id', $id);
        }
        return $query;
    }

    /**
     * Crear un array a partir de las etiquetas del producto e incluirlo como un atributo más del modelo
     *
     * @return array Etiquetas del modelo agrupadas en un Array
     */
    public function getAvatarPathAttribute()
    {
        if ($this->avatar !== null) {
            if (Str::of($this->avatar)->contains('https')) {
                return $this->avatar;
            } else {
                return asset("src/img/$this->avatar");
            }
        } else {
            return asset('src/img/blank-profile.svg');
        }
    }

    /**
     * Incluir la categoria del producto en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        $data['avatar'] = $this->avatarPath;
        return $data;
    }
}
