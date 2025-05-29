<?php

namespace App\Http\Controllers;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\Commission;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $commissions = Commission::where('name', 'like', '%' . $search . '%')->paginate(10);
        } else {
            // Sinon, récupérer toutes les entrées
            $commissions = Commission::paginate(10);
        }
        return view('contents.commission', compact('commissions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:actif,inactif',
        ]);

        Commission::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('commission.index')->with('success', 'Commission créée avec succès.');
    }



    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:actif,inactif',
        ]);

        $commission->update($request->all());
        return redirect()->route('commission.index')->with('success', 'Commission mise à jour.');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();
        return redirect()->route('commission.index')->with('success', 'Commission supprimée.');
    }
}
