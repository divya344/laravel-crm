<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Invoice;
use App\Models\Estimate;
use App\Models\Lead;
use App\Models\Ticket;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        // Counts
        $clients = Client::count();
        $projects = Project::count();

        // Correct task_status column
        $tasksCompleted = Task::where('task_status', 'completed')->count();

        // INVOICES → correct column is amount
        $invoicesCount = Invoice::count();
        $invoicesTotal = Invoice::sum('amount');

        // Other counts
        $estimates = Estimate::count();
        $leads = Lead::count();
        $ticketsOpen = Ticket::where('ticket_status', 'open')->count();

        // Correct payments column
        $paymentsTotal = Payment::sum('payment_amount');

        // Project statuses (correct column project_status)
        $projectsByStatus = Project::selectRaw('project_status, count(*) as total')
            ->groupBy('project_status')
            ->pluck('total', 'project_status')
            ->toArray();

        // Tasks
        $tasksTotal = Task::count();
        $tasksInProgress = Task::where('task_status', 'in_progress')->count();
        $tasksPending = Task::where('task_status', 'pending')->count();

        // Revenue (use SUM(amount), NOT invoice_total)
        $revenue = Invoice::selectRaw('DATE_FORMAT(issue_date, "%Y-%m") as month, SUM(amount) as total')
            ->whereNotNull('issue_date')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->pluck('total', 'month')
            ->toArray();

        // Recent Projects
        $recentProjects = Project::orderBy('project_id', 'desc')->take(6)->get();

        return view('dashboard.analytic', compact(
            'clients',
            'projects',
            'tasksCompleted',
            'invoicesCount',
            'invoicesTotal',
            'estimates',
            'leads',
            'ticketsOpen',
            'paymentsTotal',
            'projectsByStatus',
            'tasksTotal',
            'tasksInProgress',
            'tasksPending',
            'revenue',
            'recentProjects'
        ));
    }
}
