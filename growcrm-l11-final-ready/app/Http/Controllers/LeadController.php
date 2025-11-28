<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display Kanban + Table view.
     */
    public function index()
    {
        // Table view
        $leads = Lead::orderBy('lead_created', 'desc')->paginate(10);

        // Kanban board
        $boards = [
            [
                'id' => 'new',
                'name' => 'New',
                'color' => 'info',
                'leads' => Lead::where('lead_status', 'new')->get(),
            ],
            [
                'id' => 'contacted',
                'name' => 'Contacted',
                'color' => 'primary',
                'leads' => Lead::where('lead_status', 'contacted')->get(),
            ],
            [
                'id' => 'qualified',
                'name' => 'Qualified',
                'color' => 'warning',
                'leads' => Lead::where('lead_status', 'qualified')->get(),
            ],
            [
                'id' => 'converted',
                'name' => 'Converted',
                'color' => 'success',
                'leads' => Lead::where('lead_status', 'converted')->get(),
            ],
            [
                'id' => 'closed',
                'name' => 'Closed',
                'color' => 'danger',
                'leads' => Lead::where('lead_status', 'closed')->get(),
            ],
        ];

        return view('pages.leads.wrapper', compact('leads', 'boards'));
    }

    /**
     * Create form
     */
    public function create()
    {
        return view('pages.leads.create');
    }

    /**
     * Store new lead
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_firstname' => 'required|string|max:255',
            'lead_lastname'  => 'nullable|string|max:255',
            'lead_status'    => 'required|in:new,contacted,qualified,converted,closed',
        ]);

        $validated['lead_creatorid'] = auth()->id();
        $validated['lead_created']   = now();

        Lead::create($validated);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Show single lead
     */
    public function show(Lead $lead)
    {
        return view('pages.leads.show', compact('lead'));
    }

    /**
     * Edit lead
     */
    public function edit(Lead $lead)
    {
        return view('pages.leads.edit', compact('lead'));
    }

    /**
     * Update lead
     */
    public function update(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'lead_firstname' => 'required|string|max:255',
            'lead_lastname'  => 'nullable|string|max:255',
            'lead_status'    => 'required|in:new,contacted,qualified,converted,closed',
        ]);

        $validated['lead_updated'] = now();

        $lead->update($validated);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Delete lead
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
