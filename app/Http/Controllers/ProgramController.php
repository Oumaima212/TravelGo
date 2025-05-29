<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\User;
use App\Models\Commission;
use Illuminate\Http\Request;
use App\Models\Extra;
use App\Models\Country;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::paginate(15);
        $users = User::all();
        $commissions = Commission::all();
        $countries = Country::all();
        $extras = Extra::with('details')->get();

        return view('contents.program', compact('programs', 'users', 'commissions', 'countries', 'extras'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    //   dd($request->total_price);
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'prestataire_id' => 'required|integer|exists:users,id',
        'country_id' => 'required|integer|exists:countries,id',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'profit' => 'nullable|numeric|min:0',
        'total_price' => 'required|numeric|min:0', // Validation pour total_price

    ]);

    $program = Program::create($validated);

    // Ajouter des extras si fournis
    if ($request->has('extras')) {
        foreach ($request->input('extras') as $extraData) {
            $program->extras()->attach($extraData['extra_id'], [
                'extra_details_id' => $extraData['extra_details_id'] ?? null,
                'extra_sale_price' => $extraData['extra_sale_price'] ?? 0,
            ]);
        }
    }

    // Calculer et mettre à jour le prix total
    $program->calculateTotalPrice();

    return redirect()->route('program.index')->with('success', 'Programme ajouté avec succès.');
}



}
