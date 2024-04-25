<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Rules\Name;
use Illuminate\Routing\Controller as BaseController;

class EventController extends BaseController
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Event::class;

    public function index($month)
    {
        // $events = Event::where('date', )
        // return parent::index();
        $events = Event::whereMonth('date', $month)->get();
        return response()->json($events);
    }
}
