<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf; // Si vous utilisez DomPDF pour Laravel

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Charger les clients et l'entreprise
        $clients = Client::all();
        $company = Company::find(1);

        // Appliquer des filtres et préparer les requêtes
        $invoices = Invoice::paginate(10); // Paginer les factures

        // Filtrage par client
        if ($request->filled('client_id')) {
        }
        // Retourner la vue avec les données nécessaires
        return view('contents.invoice', compact('clients', 'invoices', 'company'));
    }


    public function update(Request $request, $id)
    {
        // Valider les données du formulaire
        $request->validate([
            'paidAmount' => 'required|numeric',
            'paymentMethod' => 'required|string',
            'paymentDescription' => 'nullable|string',
        ]);

        // Trouver la facture par ID
        $invoice = Invoice::findOrFail($id);

        // Mettre à jour les données de la facture
        $invoice->paidAmount = $request->paidAmount;
        $invoice->paymentMethod = $request->paymentMethod;
        $invoice->paymentDescription = $request->paymentDescription;

        // Calculer le montant restant
        $invoice->remainingAmount = $invoice->totalAmount - $invoice->paidAmount;

        // Sauvegarder les changements dans la base de données
        $invoice->save();

        // Rediriger avec un message de succès
        return redirect()->route('invoice.index')->with('success', 'Facture mise à jour avec succès!');
    }

        /**
         * Remove the specified resource from storage.
         */


    public function printInvoice($id)
    {
        $invoice = Invoice::with(['client', 'company'])->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        // Affiche directement le PDF dans la page
        return $pdf->stream('facture-' . $invoice->invoiceReference . '.pdf');
    }

}
