<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function show_register()
    {

        return view('register', ['cities' => City::all()]);
    }


    public function register(RegisterUserRequest $request)
    {

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->has('is_executor') ? 2 : 1,
            'city_id' => $request->city,
        ]);

        \auth()->login($user);

        return back();
    }

    public function login(LoginUserRequest $request)
    {
        if (Auth::attempt($request->validated())) {

            $request->session()->regenerate();

            return \redirect(route('tasks.index'));
        }
        return back()->with(['error' => 'Такого пользователя не существует']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return \redirect('/');
    }
}
