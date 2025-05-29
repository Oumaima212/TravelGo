<?php
namespace App\Http\Controllers;
use App\Models\Extra;

use App\Models\ExtraDetail;
use Illuminate\Http\Request;

class ExtraDetailController extends Controller
{
    public function index(Request $request)
    {
        $extraDetails = ExtraDetail::when($request->search, function ($query, $search) {
            return $query->where('extraCompanyName', 'like', "%{$search}%");
        })->paginate(10);

        // Récupérer tous les extras pour le formulaire d'ajout
        $extras = Extra::all();

        return view('contents.detailExtra', compact('extraDetails', 'extras'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'idExtra' => 'required|exists:extras,id',
            'extraCompanyName' => 'required|string|max:255',
            'extraPurchasePrice' => 'required|numeric|min:0',
            'extraSalePrice' => 'required|numeric|min:0',

        ]);

        ExtraDetail::create([
            'idExtra' => $request->idExtra,
            'extraCompanyName' => $request->extraCompanyName,
            'extraPurchasePrice' => $request->extraPurchasePrice,
            'extraSalePrice' => $request->extraSalePrice,

        ]);

        return redirect()->route('extra_details.index')->with('success', 'Détail ajouté avec succès.');
    }

    public function edit($id)
    {
        // Récupérer le détail d'extra avec l'ID donné
        $detail = ExtraDetail::findOrFail($id);

        // Retourner la vue avec les détails de l'extra
        return view('contents.editDetailExtra', compact('detail'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'extraCompanyName' => 'required|string|max:255',
            'extraPurchasePrice' => 'required|numeric|min:0',
            'extraSalePrice' => 'required|numeric|min:0',

        ]);

        $detail = ExtraDetail::findOrFail($id);
        $detail->update([
            'extraCompanyName' => $request->extraCompanyName,
            'extraPurchasePrice' => $request->extraPurchasePrice,
            'extraSalePrice' => $request->extraSalePrice,

        ]);

        return redirect()->route('extra_details.index')->with('success', 'Détail modifié avec succès.');
    }

    public function destroy($id)
    {
        $detail = ExtraDetail::findOrFail($id);
        $detail->delete();
        return redirect()->route('extra_details.index')->with('success', 'Détail supprimé avec succès.');
    }
}
