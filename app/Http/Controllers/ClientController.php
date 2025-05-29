<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $clients = Client::where('last_name', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->paginate(3);
        } else {
            $clients = Client::paginate(3);
        }

        return view('contents.client.index', compact('clients'));
    }


    public function show(Client $client)
    {
        return view('contents.client.show', compact('client'));
    }

    public function create()
    {
        return view('contents.client.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name_arabic' => 'nullable|string|max:255',
            'first_name_arabic' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female', // ou les options que vous préférez
            'date_of_birth' => 'required|date',
            'country' => 'required|string|max:100',
            'passport_number' => 'nullable|string|max:20',
            'phone' => 'required|string|max:15|unique:clients',
            'affiliate' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'cin' => 'required|string|max:10|unique:clients',
        ]);

        Client::create($validatedData);
        return redirect()->route('client.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('contents.client.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name_arabic' => 'nullable|string|max:255',
            'first_name_arabic' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female', // ou les options que vous préférez
            'date_of_birth' => 'required|date',
            'country' => 'required|string|max:100',
            'passport_number' => 'nullable|string|max:20',
            'phone' => 'required|string|max:15|unique:clients',
            'affiliate' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'cin' => 'required|string|max:10|unique:clients',
        ]);

        $client->update($validatedData);
        return redirect()->route('client.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('client.index')->with('success', 'Client deleted successfully.');
    }
}
