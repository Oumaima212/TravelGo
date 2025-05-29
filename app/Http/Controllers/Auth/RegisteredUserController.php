<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log; // Importation ajoutée


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255', // Validation pour le rôle
            'phone' => 'nullable|string|max:20', // Validation pour le téléphone
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'role' => $validatedData['role'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'dateJoined' => now(),
            'password' => Hash::make($validatedData['password']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route($user->getRedirectRoute()));

    }

}
