<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Project;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('project')->latest()->paginate(20);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('invoices.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number'=>'required|string|unique:invoices,number',
            'project_id'=>'nullable|exists:projects,id',
            'amount'=>'required|numeric',
            'status'=>'nullable|in:draft,sent,paid,overdue',
            'issue_date'=>'nullable|date',
            'due_date'=>'nullable|date',
        ]);

        Invoice::create($data);
        return redirect()->route('invoices.index')->with('success','Invoice created.');
    }

    public function edit(Invoice $invoice)
    {
        $projects = Project::orderBy('name')->get();
        return view('invoices.edit', compact('invoice','projects'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'number'=>'required|string|unique:invoices,number,'.$invoice->id,
            'project_id'=>'nullable|exists:projects,id',
            'amount'=>'required|numeric',
            'status'=>'nullable|in:draft,sent,paid,overdue',
            'issue_date'=>'nullable|date',
            'due_date'=>'nullable|date',
        ]);

        $invoice->update($data);
        return redirect()->route('invoices.index')->with('success','Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success','Invoice deleted.');
    }
}
