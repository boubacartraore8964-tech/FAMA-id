<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParametreController extends Controller
{
    public function index()
    {
        return view('admin.parametres');
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    /** @var \App\Models\User $user */
    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return back()->with('success', 'Mot de passe mis à jour avec succès.');
}
public function updateSoldierCredentials(Request $request)
{
    $request->validate([
        'soldat_email' => 'required|string',
        'soldat_password' => 'nullable|string|min:6',
    ]);

    $user = \App\Models\User::where('role', 'soldat')->first();
    
    if ($user) {
        $user->email = $request->soldat_email;
        if ($request->filled('soldat_password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->soldat_password);
        }
        $user->save();
        return back()->with('success', 'Identifiants du guichet soldat mis à jour avec succès.');
    }

    return back()->withErrors(['error' => 'Compte soldat introuvable.']);
}
}