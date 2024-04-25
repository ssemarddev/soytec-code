<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *  @OA\Schema(
 *      schema="Quotation",
 *      description="Cotización del sistema",
 *      type="object",
 *      required={"client_id","name","description","services"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id de la cotización en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="client_id",
 *          type="integer",
 *          description="Id del cliente de la cotización"
 *      ),
 *      @OA\Property(
 *          property="client",
 *          type="object",
 *          description="Cliente de la cotización",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Client")
 *          }
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          description="Nombre de la cotización",
 *          minLength=3,
 *          maxLength=50
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string",
 *          description="Descripción de la cotización",
 *          minLength=3,
 *          maxLength=300
 *      ),
 *      @OA\Property(
 *          property="services",
 *          type="array",
 *          description="Servicios de la cotización",
 *          @OA\Items(
 *              ref="#/components/schemas/Service"
 *          )
 *      ),
 *  ),
 */
class Quotation extends BaseModel
{
    use HasFactory;

    /**
     * Obtener todos los servicios de la cotización
     * 
     * @return array<Service> El modelo de todos los servicios de la cotización
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Obtener el cliente de la cotización
     * 
     * @return Client El modelo del cliente de la cotización
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Incluir los servicios y el cliente de la cotización en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        if ($this->services) {
            $data['services'] = $this->services;
        } else {
            $data['services'] = [];
        }
        if ($this->client) {
            $data['client'] = $this->client;
        } else {
            $data['client'] = [];
        }
        return $data;
    }
}
