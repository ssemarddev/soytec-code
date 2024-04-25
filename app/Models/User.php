<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *      schema="User",
 *      description="Usuario del sistema",
 *      type="object",
 *      required={"name","lastName","avatar","email","username","password","gender"},
 *      @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         description="Id del administrador en la base de datos"
 *     ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre(s) del usuario",
 *          minLength=3,
 *          maxLength=40
 *      ),
 *      @OA\Property(
 *          property="lastName",
 *          type="string",
 *          description="Apellidos del usuario",
 *          minLength=3,
 *          maxLength=60
 *      ),
 *      @OA\Property(
 *          property="avatar",
 *          type="string",
 *          description="Nombre del archivo en el directorio 'src/img/avatars/' que se usuará como avatar del usuario",
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          description="Email del usuario",
 *          minLength=3,
 *          maxLength=100
 *      ),
 *      @OA\Property(
 *          property="username",
 *          type="string",
 *          description="Nombre de usuario del usuario (usado para loguearse)",
 *          minLength=3,
 *          maxLength=40
 *      ),
 *      @OA\Property(
 *          property="password",
 *          type="password",
 *          description="Contraseña del usuario",
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string",
 *          description="Número de teléfono del usuario"
 *      ),
 *      @OA\Property(
 *         property="gender",
 *         type="string",
 *         description="Género del usuario",
 *         enum={"Otro","Femenino", "Masculino"},
 *      ),
 *      @OA\Property(
 *         property="level",
 *         type="string",
 *         description="Nivel de acceso del usuario (los usuarios administradores son los únicos que pueden consultar y/o modificar secciones críticas del sistema)",
 *         enum={"Usuario", "Administrador"},
 *         default="Usuario"
 *      ),
 *      @OA\Property(
 *         property="state",
 *         type="string",
 *         description="Estado del usuario",
 *         enum={"Activa","Bloqueada"},
 *         default="Bloqueada"
 *      )
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Indica que todos los atributos pueden ser asignados de forma masiva
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Indica los atributos que estarán ocultos en el array de salida del modelo
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
     * Obtener todos los permisos del usuario
     * 
     * @return array<UserPermission> El modelo de todos los permisos del usuario
     */
    public function permissions()
    {
        return $this->hasMany(UserPermission::class);
    }

    /**
     * Conocer si un usuario posee un determinado permiso
     * 
     * @return boolean <code>true</code> si el usuario posee el permiso o <code>false</code> si no.
     */
    public function isPermissionExist($permissionId)
    {
        foreach ($this->permissions() as $permission) {
            if ($permission->permission_id == $permissionId)
                return true;
        }
        return false;
    }

    /**
     * Incluir los permisos del usuario en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->permissions) {
            $data['permissions'] = $this->permissions;
        } else {
            $data['permissions'] = [];
        }
        return $data;
    }
}
