<?php

namespace App\Models;

class Event extends BaseModel
{
    /**
     * Indicar que el modelo no maneja columnas created_at y updated_at
     *
     * @var bool
     */
    public $timestamps = false;
}
