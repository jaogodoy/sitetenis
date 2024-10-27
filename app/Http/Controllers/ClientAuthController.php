<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('Home_template.register'); // Corrigido para Home_template.register
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
            'role' => 'client', // Define o papel como client
        ]);

        Auth::login($user);
        return redirect()->route('client.dashboard')->with('success', 'Registro concluído com sucesso! Você está logado como Cliente.');
    }

    public function showLoginForm()
    {
        return view('Home_template.login'); // Corrigido para Home_template.login
    }

    public function login(Request $request)
{
    // Validar as credenciais do cliente
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Tentar autenticar o cliente
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirecionar para o dashboard do cliente
        return redirect()->route('client.dashboard')->with('success', 'Login bem-sucedido!');
    }

    // Se as credenciais estiverem incorretas
    return back()->withErrors([
        'email' => 'As credenciais fornecidas estão incorretas.',
    ]);
}


}
