<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::paginate(10); // Adjust the pagination as needed
        return view('contents.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contents.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'serviceFee' => 'required|numeric',
            'invoicePrefix' => 'required|string|max:10',
            'invoiceNumber' => 'required|integer',
            'paymentPrefix' => 'required|string|max:10',
            'paymentNumber' => 'required|integer',
            'biography' => 'nullable|string',
        ]);

        // Handle the logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Create the company
        Company::create([
            'logo' => $logoPath,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'serviceFee' => $request->serviceFee,
            'invoicePrefix' => $request->invoicePrefix,
            'invoiceNumber' => $request->invoiceNumber,
            'paymentPrefix' => $request->paymentPrefix,
            'paymentNumber' => $request->paymentNumber,
            'biography' => $request->biography,
        ]);

        return redirect()->route('company.index')->with('success', 'Entreprise créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return view('contents.company.show', compact('company'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('contents.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'serviceFee' => 'required|numeric',
            'invoicePrefix' => 'required|string|max:10',
            'invoiceNumber' => 'required|integer',
            'paymentPrefix' => 'required|string|max:10',
            'paymentNumber' => 'required|integer',
            'biography' => 'nullable|string',
        ]);

        // Handle the logo upload
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $company->logo = $logoPath;
        }

        // Update the company
        $company->update($request->except('logo'));

        return redirect()->route('company.index')->with('success', 'Entreprise mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('company.index')->with('success', 'Entreprise supprimée avec succès.');
    }

}
