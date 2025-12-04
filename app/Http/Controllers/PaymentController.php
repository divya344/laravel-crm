<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with('client')->orderByDesc('payment_date');
        $perPage = 10;

        if ($request->ajax()) {
            $payments = $query->paginate($perPage);
            return view('pages.payments._list', compact('payments'))->render();
        }

        $payments = $query->paginate($perPage);
        return view('pages.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        // ✔ FIXED — use correct column names (client_id)
        $clients = Client::select('client_id', 'name')
            ->orderBy('name')
            ->get();

        return view('pages.payments.create', compact('clients'));
    }

    /**
     * Store a newly created payment in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // ✔ FIXED — exists rule must use client_id
            'payment_clientid' => 'nullable|exists:clients,client_id',
            'payment_method'   => 'required|string|max:100',
            'payment_amount'   => 'required|numeric|min:0',
            'payment_status'   => 'required|in:pending,completed,failed',
            'payment_date'     => 'nullable|date',
            'payment_notes'    => 'nullable|string|max:500',
        ]);

        $validated['payment_reference'] = 'PAY-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        $validated['payment_created'] = Carbon::now();
        $validated['payment_updated'] = Carbon::now();

        Payment::create($validated);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment created successfully!');
    }

    /**
     * Display a single payment record.
     */
    public function show(Payment $payment)
    {
        return view('pages.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing a payment.
     */
    public function edit(Payment $payment)
    {
        // ✔ FIXED — correct columns
        $clients = Client::select('client_id', 'name')
            ->orderBy('name')
            ->get();

        return view('pages.payments.edit', compact('payment', 'clients'));
    }

    /**
     * Update an existing payment.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            // ✔ FIXED — use client_id
            'payment_clientid' => 'nullable|exists:clients,client_id',
            'payment_method'   => 'required|string|max:100',
            'payment_amount'   => 'required|numeric|min:0',
            'payment_status'   => 'required|in:pending,completed,failed',
            'payment_date'     => 'nullable|date',
            'payment_notes'    => 'nullable|string|max:500',
        ]);

        $validated['payment_updated'] = Carbon::now();

        $payment->update($validated);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment updated successfully!');
    }

    /**
     * Delete a payment record.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment deleted successfully!');
    }
}
