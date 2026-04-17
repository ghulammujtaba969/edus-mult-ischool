<?php

namespace App\Http\Controllers;

use App\Models\FeeInvoice;
use App\Models\FeePayment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FeePaymentController extends Controller
{
    public function create(FeeInvoice $feeInvoice): View
    {
        $feeInvoice->load(['student.user', 'feeType']);
        return view('fee-payments.create', compact('feeInvoice'));
    }

    public function store(Request $request, FeeInvoice $feeInvoice): RedirectResponse
    {
        $validated = $request->validate([
            'amount_paid' => 'required|numeric|min:1|max:' . $feeInvoice->balance_amount,
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,bank,online',
            'reference_no' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($feeInvoice, $validated) {
            FeePayment::create([
                'campus_id' => auth()->user()->campus_id,
                'fee_invoice_id' => $feeInvoice->id,
                'student_id' => $feeInvoice->student_id,
                'amount_paid' => $validated['amount_paid'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'reference_no' => $validated['reference_no'],
                'notes' => $validated['notes'],
                'received_by' => auth()->id(),
            ]);

            $feeInvoice->increment('paid_amount', $validated['amount_paid']);
            $feeInvoice->decrement('balance_amount', $validated['amount_paid']);

            if ($feeInvoice->balance_amount <= 0) {
                $feeInvoice->update(['status' => 'paid']);
            } else {
                $feeInvoice->update(['status' => 'partial']);
            }
        });

        return redirect()->route('admin.fee-invoices.show', $feeInvoice)
            ->with('success', 'Payment recorded successfully.');
    }
}
