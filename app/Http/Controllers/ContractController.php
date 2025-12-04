<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Client;

class ContractController extends Controller
{
    /**
     * List all contracts.
     */
    public function index()
    {
        $contracts = Contract::orderBy('doc_created', 'desc')->paginate(10);

        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show Create Form
     */
    public function create()
    {
        $clients = Client::all();
        return view('contracts.create', compact('clients'));
    }

    /**
     * Store Contract
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_title'        => 'required|string|max:255',
            'doc_clientid'     => 'required|exists:clients,id',
            'doc_date_start'   => 'nullable|date',
            'doc_date_end'     => 'nullable|date|after_or_equal:doc_date_start',
            'doc_value'        => 'nullable|numeric',
            'doc_status'       => 'required|string',
        ]);

        Contract::create([
            'doc_title'        => $request->doc_title,
            'doc_clientid'     => $request->doc_clientid,
            'doc_date_start'   => $request->doc_date_start,
            'doc_date_end'     => $request->doc_date_end,
            'doc_value'        => $request->doc_value,
            'doc_status'       => $request->doc_status,
            'doc_creatorid'    => auth()->id(),
        ]);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract created successfully!');
    }

    /**
     * Show Single Contract
     */
    public function show($id)
    {
        $contract = Contract::with('creator')->findOrFail($id);
        return view('contracts.show', compact('contract'));
    }

    /**
     * Edit Contract
     */
    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        $clients = Client::all();

        return view('contracts.edit', compact('contract', 'clients'));
    }

    /**
     * Update Contract
     */
    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);

        $request->validate([
            'doc_title'        => 'required|string|max:255',
            'doc_clientid'     => 'required|exists:clients,id',
            'doc_date_start'   => 'nullable|date',
            'doc_date_end'     => 'nullable|date|after_or_equal:doc_date_start',
            'doc_value'        => 'nullable|numeric',
            'doc_status'       => 'required|string',
        ]);

        $contract->update([
            'doc_title'        => $request->doc_title,
            'doc_clientid'     => $request->doc_clientid,
            'doc_date_start'   => $request->doc_date_start,
            'doc_date_end'     => $request->doc_date_end,
            'doc_value'        => $request->doc_value,
            'doc_status'       => $request->doc_status,
        ]);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract updated successfully!');
    }

    /**
     * Delete Contract
     */
    public function destroy($id)
    {
        Contract::findOrFail($id)->delete();

        return redirect()->route('contracts.index')
            ->with('success', 'Contract deleted successfully!');
    }
}
