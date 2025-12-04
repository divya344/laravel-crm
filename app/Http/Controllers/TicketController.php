<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\Project;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        // Correct column is 'company'
        $clients = Client::orderBy('company')->get();
        $projects = Project::orderBy('project_title')->get();

        return view('tickets.create', compact('clients', 'projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_subject'   => 'required|string|max:255',
            'ticket_message'   => 'nullable|string',
            'ticket_clientid'  => 'nullable|exists:clients,id',
            'ticket_projectid' => 'nullable|exists:projects,project_id',
        ]);

        Ticket::create([
            'ticket_subject'   => $request->ticket_subject,
            'ticket_message'   => $request->ticket_message,
            'ticket_status'    => 'open',
            'ticket_userid'    => auth()->id(),
            'ticket_clientid'  => $request->ticket_clientid,
            'ticket_projectid' => $request->ticket_projectid,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Correct column -> company
        $clients = Client::orderBy('company')->get();
        $projects = Project::orderBy('project_title')->get();

        return view('tickets.edit', compact('ticket', 'clients', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ticket_subject'   => 'required|string|max:255',
            'ticket_message'   => 'nullable|string',
            'ticket_status'    => 'required|in:open,in_progress,answered,closed',
            'ticket_clientid'  => 'nullable|exists:clients,id',
            'ticket_projectid' => 'nullable|exists:projects,project_id',
        ]);

        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'ticket_subject'   => $request->ticket_subject,
            'ticket_message'   => $request->ticket_message,
            'ticket_status'    => $request->ticket_status,
            'ticket_clientid'  => $request->ticket_clientid,
            'ticket_projectid' => $request->ticket_projectid,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket updated successfully!');
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }
}
