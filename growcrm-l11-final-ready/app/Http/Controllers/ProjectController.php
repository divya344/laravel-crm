<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Client;

class ProjectController extends Controller
{
    /* -----------------------------------------------------------
       LIST PROJECTS
    ------------------------------------------------------------ */
    public function index()
    {
        $projects = Project::with('client')
            ->orderBy('project_id', 'desc')
            ->paginate(15);

        return view('projects.index', compact('projects'));
    }


    /* -----------------------------------------------------------
       CREATE PAGE
    ------------------------------------------------------------ */
    public function create()
    {
        // Correct column is 'company'
        $clients = Client::orderBy('company')->get();

        return view('projects.create', compact('clients'));
    }


    /* -----------------------------------------------------------
       STORE PROJECT
    ------------------------------------------------------------ */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_title'        => 'required|string|max:255',
            'project_description'  => 'nullable|string',
            'project_clientid'     => 'nullable|exists:clients,id',   // FIXED
            'project_start_date'   => 'nullable|date',
            'project_end_date'     => 'nullable|date',
            'project_status'       => 'nullable|in:pending,in_progress,completed,on_hold',
        ]);

        Project::create($data);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully.');
    }


    /* -----------------------------------------------------------
       SHOW PAGE
    ------------------------------------------------------------ */
    public function show($id)
    {
        $project = Project::with([
            'client',
            'tasks',
            'invoices'
        ])->findOrFail($id);

        return view('projects.show', compact('project'));
    }


    /* -----------------------------------------------------------
       EDIT PAGE
    ------------------------------------------------------------ */
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        // Correct column is 'company'
        $clients = Client::orderBy('company')->get();

        return view('projects.edit', compact('project', 'clients'));
    }


    /* -----------------------------------------------------------
       UPDATE PROJECT
    ------------------------------------------------------------ */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $data = $request->validate([
            'project_title'        => 'required|string|max:255',
            'project_description'  => 'nullable|string',
            'project_clientid'     => 'nullable|exists:clients,id',   // FIXED
            'project_start_date'   => 'nullable|date',
            'project_end_date'     => 'nullable|date',
            'project_status'       => 'nullable|in:pending,in_progress,completed,on_hold',
        ]);

        $project->update($data);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }


    /* -----------------------------------------------------------
       DELETE PROJECT
    ------------------------------------------------------------ */
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
