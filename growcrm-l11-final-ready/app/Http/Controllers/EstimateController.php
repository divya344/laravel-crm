<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EstimateController extends Controller
{
    /**
     * Display a listing of estimates with infinite scroll support.
     */
    public function index(Request $request)
    {
        $query = Estimate::orderByDesc('bill_created');
        $perPage = 10;

        // If the request is AJAX (for infinite scroll)
        if ($request->ajax()) {
            $estimates = $query->paginate($perPage);
            return view('pages.estimates._list', compact('estimates'))->render();
        }

        $estimates = $query->paginate($perPage);
        return view('pages.estimates.index', compact('estimates'));
    }

    /**
     * Show the form for creating a new estimate.
     */
    public function create()
    {
        return view('pages.estimates.create');
    }

    /**
     * Store a newly created estimate in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estimate_number'    => 'required|string|max:50|unique:estimates,estimate_number',
            'client_name'        => 'nullable|string|max:255',
            'bill_amount'        => 'required|numeric|min:0',
            'bill_status'        => 'required|in:draft,sent,approved,rejected',
            'bill_date'          => 'nullable|date',
            'bill_expiry_date'   => 'nullable|date|after_or_equal:bill_date',
            'bill_notes'         => 'nullable|string',
        ]);

        // ✅ Add CRM-style timestamps
        $validated['bill_created'] = Carbon::now();
        $validated['bill_updated'] = Carbon::now();

        Estimate::create($validated);

        return redirect()->route('estimates.index')->with('success', 'Estimate created successfully!');
    }

    /**
     * Show the form for editing the specified estimate.
     */
    public function edit(Estimate $estimate)
    {
        return view('pages.estimates.edit', compact('estimate'));
    }

    /**
     * Update the specified estimate.
     */
    public function update(Request $request, Estimate $estimate)
    {
        $validated = $request->validate([
            'estimate_number'    => 'required|string|max:50|unique:estimates,estimate_number,' . $estimate->bill_estimateid . ',bill_estimateid',
            'client_name'        => 'nullable|string|max:255',
            'bill_amount'        => 'required|numeric|min:0',
            'bill_status'        => 'required|in:draft,sent,approved,rejected',
            'bill_date'          => 'nullable|date',
            'bill_expiry_date'   => 'nullable|date|after_or_equal:bill_date',
            'bill_notes'         => 'nullable|string',
        ]);

        $validated['bill_updated'] = Carbon::now();

        $estimate->update($validated);

        return redirect()->route('estimates.index')->with('success', 'Estimate updated successfully!');
    }

    /**
     * Remove the specified estimate.
     */
    public function destroy(Estimate $estimate)
    {
        $estimate->delete();

        return redirect()->route('estimates.index')->with('success', 'Estimate deleted successfully!');
    }

    /**
     * Display a single estimate (View Page).
     */
    public function show(Estimate $estimate)
    {
        return view('pages.estimates.show', compact('estimate'));
    }
}
