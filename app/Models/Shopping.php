<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *  @OA\Schema(
 *      schema="Shopping",
 *      description="Registro de compra de pieza o herramienta",
 *      type="object",
 *      required={"piece_id","user_id","provider_id","quantity","cost"},
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          readOnly=true,
 *          description="Id del registro de compra en la base de datos"
 *      ),
 *      @OA\Property(
 *          property="piece_id",
 *          type="iteger",
 *          description="Id de la pieza o herramienta",
 *      ),
 *      @OA\Property(
 *          property="piece",
 *          type="object",
 *          description="Pieza o herramienta",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Piece")
 *          }
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          type="iteger",
 *          description="Id del usuario que registró la compra",
 *      ),
 *      @OA\Property(
 *          property="user",
 *          type="object",
 *          description="Usuario que registró la compra",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/User")
 *          }
 *      ),
 *      @OA\Property(
 *          property="provider_id",
 *          type="iteger",
 *          description="Id del proveedor de la compra",
 *      ),
 *      @OA\Property(
 *          property="provider",
 *          type="object",
 *          description="Proveedor de la compra",
 *          readOnly=true,
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Provider")
 *          }
 *      ),
 *      @OA\Property(
 *          property="quantity",
 *          type="integer",
 *          description="Cantidad comprada",
 *          minimum=1
 *      ),
 *      @OA\Property(
 *          property="cost",
 *          type="double",
 *          description="Costo de la compra"
 *      ),
 *  ),
 */
class Shopping extends BaseModel
{
    use HasFactory;

    /**
     * Obtener la pieza o herramienta que fue comprada
     * 
     * @return Piece Modelo de la pieza o herramienta que fue comprada
     */
    public function piece()
    {
        return $this->belongsTo(Piece::class);
    }

    /**
     * Obtener el usuario que hizo la compra
     * 
     * @return User El modelo del usuario que hizo la compra
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el proveedor de la compra
     * 
     * @return Provider El proveedor al que fue realizada la compra
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Incluir la pieza o herramienta, el usuario y el proveedor de la compra en el array de salida del modelo
     */
    public function toArray()
    {
        $data = parent::toArray();
        // change the value of the 'mime' key
        if ($this->piece) {
            $data['piece'] = $this->piece;
        } else {
            $data['piece'] = null;
        }
        if ($this->user) {
            $data['user'] = $this->user;
        } else {
            $data['user'] = null;
        }
        if ($this->provider) {
            $data['provider'] = $this->provider;
        } else {
            $data['provider'] = null;
        }
        return $data;
    }
}
