<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:clients,email',
            'phone'   => 'nullable|string',
            'company' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Client::create($data);

        return redirect()
            ->route('clients.index')
            ->with('success','Client created.');
    }

    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:clients,email,' . $client->client_id . ',client_id',
            'phone'   => 'nullable|string',
            'company' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $client->update($data);

        return redirect()
            ->route('clients.index')
            ->with('success','Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success','Client deleted.');
    }
}
