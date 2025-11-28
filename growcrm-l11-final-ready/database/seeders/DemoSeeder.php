<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\Invoice;
use App\Models\Estimate;
use App\Models\Lead;
use App\Models\Contract;
use App\Models\Ticket;
use App\Models\Payment;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create Clients
        Client::factory(10)->create();

        // Create Projects for Clients
        Project::factory(20)->create();

        // Create Tasks for Projects
        Task::factory(50)->create();

        // Create Invoices for Projects
        Invoice::factory(30)->create();

        // Create Estimates, Leads, Contracts, Tickets, Payments
        Estimate::factory(15)->create();
        Lead::factory(12)->create();
        Contract::factory(8)->create();
        Ticket::factory(12)->create();
        Payment::factory(20)->create();
    }
}
