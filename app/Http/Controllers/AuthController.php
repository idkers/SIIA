<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de inicio de sesión.
     */
    public function mostrarIngreso(): View
    {
        return view('ingresar');
    }

    /**
     * Procesar el inicio de sesión.
     */
    public function ingresar(Request $request): RedirectResponse
    {
        $credenciales = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.required' => 'Ingresa tu correo electrónico.',
                'email.email' => 'Ingresa un correo electrónico válido.',
                'password.required' => 'Ingresa tu contraseña.',
            ]
        );

        if (!Auth::attempt($credenciales)) {
            throw ValidationException::withMessages([
                'email' => 'El correo o la contraseña no son correctos.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('welcome'))
            ->with('success', 'Has iniciado sesión correctamente.');
    }

    /**
     * Mostrar el formulario de registro.
     */
    public function mostrarRegistro(): View
    {
        return view('registrar');
    }

    /**
     * Registrar un usuario nuevo.
     */
    public function registrar(Request $request): RedirectResponse
    {
        $datos = $request->validate(
            [
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^\S+(?:\s+\S+)+$/u',
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
            ],
            [
                'nombre.required' => 'Ingresa tu nombre completo.',
                'nombre.string' => 'El nombre debe ser un texto válido.',
                'nombre.max' => 'El nombre no puede superar los 255 caracteres.',
                'nombre.regex' => 'Ingresa al menos tu nombre y un apellido.',

                'email.required' => 'Ingresa tu correo electrónico.',
                'email.email' => 'Ingresa un correo electrónico válido.',
                'email.max' => 'El correo no puede superar los 255 caracteres.',
                'email.unique' => 'Ya existe una cuenta registrada con este correo.',

                'password.required' => 'Ingresa una contraseña.',
                'password.string' => 'La contraseña debe ser un texto válido.',
                'password.min' => 'La contraseña debe contener al menos 8 caracteres.',
                'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            ]
        );

        $usuario = User::create([
            'name' => $datos['nombre'],
            'email' => $datos['email'],
            'password' => $datos['password'],
            'rol' => 'usuario',
        ]);

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()
            ->route('welcome')
            ->with('success', 'Tu cuenta fue creada correctamente.');
    }

    /**
     * Cerrar la sesión actual.
     */
    public function salir(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('welcome')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}