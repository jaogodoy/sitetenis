<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('Admintemplate.register'); // Corrigido para Admintemplate.register
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'admin', // Define o papel como admin
        ]);

        Auth::login($user);
        return redirect()->route('admin.dashboard')->with('success', 'Registro concluído com sucesso! Você está logado como Administrador.');
    }

    public function showLoginForm()
    {
        return view('Admintemplate.login'); // Corrigido para Admintemplate.login
    }

    public function login(Request $request)
{
    // Validar as credenciais do administrador
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Tentar autenticar o admin
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirecionar para o dashboard do admin
        return redirect()->route('admin.dashboard')->with('success', 'Login bem-sucedido!');
    }

    // Se as credenciais estiverem incorretas
    return back()->withErrors([
        'email' => 'As credenciais fornecidas estão incorretas.',
    ]);
}
}
