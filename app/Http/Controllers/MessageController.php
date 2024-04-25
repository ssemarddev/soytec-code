<?php

namespace App\Http\Controllers;

use App\Events\MessageDeleted;
use App\Events\MessageSend;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{

    /**
     * Modelo al cuál está vinculado este controlador
     */
    protected $model = Message::class;

    /**
     * Crea un nuevo mensaje y añadirlo a un chat
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Los datos del nuevo mensaje creado
     */
    public function store(Request $request)
    {
        //Validar los datos
        $request->validate([
            'message' => ['required', 'between:3,1000'],
            'image' => ['annexed', 'image', 'between:3,4096'],
            'chat_id' => ['required', 'integer', 'exists:chats,id'],
            'client_id' => ['integer', 'exists:clients,id']
        ]);
        //Obtener los datos del mensaje de la petición
        $data = $request->all();
        //Verificar si no es un mensaje del Soporte Técnico para añadir el usuario logueado como remitente
        if (!$request->exists('user_id')) {
            $data['user_id'] = $request->user()->id;
        }
        //Comprobar si se anexó un imagen y guardarla en el almacenamiento
        if ($request->exists('annexed')) {
            $path = $request->file('annexed')->store('messages');
            $data['annexed'] = $path;
        }
        //Crear el nuevo mensaje
        $message = Message::create($data);
        //Notificar de nuevo mensaje para actualizar con WebSockets
        MessageSend::dispatch($message);
        //Retornar el nuevo mensaje
        return response()->json($message);
    }

    /**
     * Elimina los mensajes pasados en los ids de la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Obtener los ids del la petición
        $ids = Str::of($request->ids)->explode(',');
        foreach ($ids as $id) {
            //Recuperar el modelo
            $message = Message::find($id);
            //Eliminar el modelo si no es un mensaje de Soporte Técnico
            if ($message->user !== null) {
                MessageDeleted::dispatch($message);
                $result = $message->delete();
                //Verificar si se eliminó y eliminar la imagen anexada si existía
                if ($result == 1 && $message->annexed !== null) {
                    //Eliminar imagen anexada del mensaje
                    Storage::disk('images')->delete($message->annexed);
                }
            }
        }
        return response('', 200);
    }
}
