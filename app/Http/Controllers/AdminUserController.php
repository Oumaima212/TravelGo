<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(3);

        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(3);

        return view('contents.users.index', compact('users'));
    }

    public function create()
    {
        $user = new User;
        $isUpdate = false;
        return view('contents.users.create', compact('user', 'isUpdate'));
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $formFields['password'] = Hash::make($formFields['password']);

        User::create($formFields);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('contents.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $isUpdate = true;
        return view('contents.users.create', compact('user', 'isUpdate'));
    }

    public function update(Request $request, User $user)
    {
        $formFields = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string', // Validation pour le rôle
            // 'password' => 'nullable|string|min:6|confirmed', // Inclure si le mot de passe peut être mis à jour
        ]);

        // Mettez à jour le mot de passe uniquement si un nouveau mot de passe est fourni
        // if ($request->filled('password')) {
        //     $formFields['password'] = Hash::make($request->password);
        // }

        $user->update($formFields);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
