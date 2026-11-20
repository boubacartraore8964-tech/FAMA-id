<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerificateurController extends Controller
{
    public function index()
    {
        $verificateurs = User::where('role', 'verificateur')->latest()->paginate(10);
        return view('admin.verificateurs.index', compact('verificateurs'));
    }

    public function create()
    {
        return view('admin.verificateurs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'poste' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'poste' => $validated['poste'],
            'password' => Hash::make($validated['password']),
            'role' => 'verificateur',
            'is_active' => true,
        ]);

        return redirect()->route('verificateurs.index')->with('success', 'Compte vérificateur créé avec succès.');
    }
    public function edit(User $verificateur)
{
    return view('admin.verificateurs.edit', compact('verificateur'));
}

public function update(Request $request, User $verificateur)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255|unique:users,email,' . $verificateur->id,
        'poste' => 'required|string|max:255',
        'password' => 'nullable|string|min:6',
    ]);

    if (!empty($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

    $verificateur->update($validated);

    return redirect()->route('verificateurs.index')->with('success', 'Compte vérificateur mis à jour.');
}

    public function destroy(User $verificateur)
    {
        if ($verificateur->role === 'verificateur') {
            $verificateur->delete();
        }
        return redirect()->route('verificateurs.index')->with('success', 'Compte vérificateur supprimé.');
    }
}