<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of countries with optional search functionality.
     */
    public function index(Request $request)
    {
        // Get the search term if provided
        $search = $request->input('search');

        // Filter the countries based on the search term
        $query = Country::query();
        if ($search) {
            $query->where('nomCountry', 'like', '%' . $search . '%');
        }

        // Paginate the results
        $countries = $query->paginate(10);

        // Return the view with countries and search term
        return view('contents.country', compact('countries', 'search'));
    }

    /**
     * Store a newly created country in the database.
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'nomCountry' => 'required|string|max:255',
        ]);

        // Create the new country
        Country::create([
            'nomCountry' => $request->nomCountry,
        ]);

        // Redirect back with a success message
        return redirect()->route('country.index')->with('success', 'Country added successfully!');
    }

    /**
     * Show the form for editing the specified country (not implemented).
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified country in storage (not implemented).
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified country from storage (not implemented).
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('country.index')->with('success', 'country supprimée.');

    }
}
