<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserController extends Controller
{
    use SoftDeletes;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("available_users", ["usuários" => $users]);
    }

    public function login()
    {
        return view('user.login');
    }

    public function confirmLogin(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:3",
            "email" => "required",
            "password" => "required|min:5"
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !password_verify($request->input('password'), $user->password)) {
            return redirect()->route('login')->with('erro', 'Email ou senha incorretos');
        }

        if ($user->isAdmin) {
            Auth::loginUsingId($user->id);

            return redirect()->intended('/');
        }

        // Autenticação como usuário normal
        Auth::loginUsingId($user->id);

        return redirect()->intended();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register()
    {
        return view('user.register');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,)
    {
        $user = User::create($request->validate([
            "name" => 'required|min:3',
            "email" => 'required',
            "password" => Hash::make('required|min:3')
        ]));

        event(new Registered($user));

        return redirect()->route('home.view')->with('sucesso', 'Conta Criada com sucesso!');
    }


    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
    /**
     * Display the specified resource.
     */
    // public function show(User $user)
    // {
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("editig_user", ["current_user" => $user->name]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->validate([
            "name" => 'required|min:3',
        ]));

        return redirect()->route('home.view')->with('sucesso', 'Conta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user,)
    {
        $user->delete();
        return redirect()->route('home.view')->with('sucesso', 'Conta deletada com sucesso!');
    }
}
