<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    // List all payments with pagination
    public function index()
    {
        $payments = Payment::with('booking.user')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    // Show payment details
    public function show($id)
    {
        $payment = Payment::with('booking.user')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    // (Optional) Add more methods if needed (e.g., delete, refund)
}
