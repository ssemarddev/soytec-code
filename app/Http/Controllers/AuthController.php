<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
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
            'username' => ['required'],
            'password' => ['required']
        ]);

        $remember = $request->has('remember') && $request->boolean('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $request->user()->tokens()->delete();
            //Generar permisos del token
            $abilities = [];
            foreach ($request->user()->permissions as $permission) {
                $abilities[] = $permission->permission->permission;
            }
            //Generar token API
            $token = $request->user()->createToken(csrf_token(), $abilities);
            //Guardar una cookie con el valor del token
            setcookie('TOKEN-API', $token->plainTextToken, time() + 3600 * 24);
            //Redirigir a la página de solicitud
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'El nombre de usuario o contraseña es incorrecto',
        ])->onlyInput('username');
    }
}
