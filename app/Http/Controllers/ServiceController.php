<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Service::class;
}
