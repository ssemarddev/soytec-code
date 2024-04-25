<?php

namespace App\Http\Controllers;

use App\Events\ChatCreated;
use App\Events\ChatDeleted;
use App\Models\Chat;
use App\Rules\AlphaNumSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Chat::class;

    /**
     * Crea un nuevo chat
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Los datos del nuevo chat creado
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'title' => ['required', new AlphaNumSpace, 'unique:chats', 'between:3,50']
        ]);
        //Obtener los datos del nuevo chat en la petición
        $data = $request->all();
        //Crear la instancia del modelo en la base de datos
        $chat = Chat::create($data);
        //Llamar al evento para actualizar mediante WebSockets
        ChatCreated::dispatch($chat);
        //Retornar el nuevo modelo
        return response()->json($chat);
    }

    /**
     * Elimina los chats de los ids pasados en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Obtener ids de los chats a eliminar
        $ids = Str::of($request->ids)->explode(',');
        foreach ($ids as $id) {
            //Recuperar el modelo
            $chat = Chat::find($id);
            //Llamar el evento para actualizar mediante WebSockets
            ChatDeleted::dispatch($chat);
            //Eliminar el modelo
            $chat->delete();
        }
        return response('', 200);
    }
}
