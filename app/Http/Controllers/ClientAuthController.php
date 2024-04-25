<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $credentials['state'] = 'Activa';

        if (Auth::guard('client')->attempt($credentials)) {
            $request->session()->regenerate();
            $client = Client::where('email', $credentials['email'])->first();
            $client->tokens()->delete();
            //Generar token API
            $token = $client->createToken(csrf_token());
            //Guardar una cookie con el valor del token
            setcookie('TOKEN-API', $token->plainTextToken, time() + 3600 * 24);
            return response()->json(["result" => "autenticated", "client" => $client]);
        }

        return response()->json(["result" => "error"], 401);
    }

    public function socialite($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function sign(Request $request, $driver)
    {
        $socialiteUser = Socialite::driver($driver)->user();
        $client = Client::updateOrCreate([
            "{$driver}_id" => $socialiteUser->id
        ], [
            'name' => $socialiteUser->name,
            'email' => $socialiteUser->email,
            'avatar' => $socialiteUser->getAvatar(),
            "{$driver}_token" => $socialiteUser->token,
            "{$driver}_refresh_token" => $socialiteUser->refreshToken,
        ]);
        Auth::guard('client')->login($client);
        $request->session()->regenerate();
        $client->tokens()->delete();
        //Generar token API
        $token = $client->createToken(csrf_token());
        //Guardar una cookie con el valor del token
        setcookie('TOKEN-API', $token->plainTextToken, time() + 3600 * 24);
        // return response()->json(["result" => "autenticated", "client" => $client]);
        return redirect('http://localhost:5173/');
    }
}
