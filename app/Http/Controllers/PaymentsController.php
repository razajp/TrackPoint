<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = Payments::with('customer')->get();
        
        $request->validate([
            'customer_id' => 'nullable',
            'type' => 'nullable',
            'status' => 'nullable'
        ]);

        $customerId = $request->get('customer_id');
        $type = $request->get('type');
        $status = $request->get('status');

        $payments = Payments::with('customer');

        if ($customerId !== "all" && !empty($customerId)) {
            $payments->where('customer_id', $customerId);
        }

        if ($type !== "all" && !empty($type)) {
            $payments->where('type', $type);
        }

        if ($status !== "all" && !empty($status)) {
            if ($status == 'pending') {
                $payments->whereIn('type', ['slip', 'cheque'])->whereNull('clear_date');
            } elseif ($status == 'cleared') {
                $payments->whereIn('type', ['slip', 'cheque'])->whereNotNull('clear_date');
            }
        }

        $payments = $payments->get();
        
        foreach ($payments as $payment){
            $payment['amount'] = number_format($payment['amount'], 2, '.', ',');
            $payment['date'] = date('d-M-Y, D', strtotime($payment['date']));
            $payment['issue_date'] = date('d-M-Y, D', strtotime($payment['issue_date']));
            if ($payment['clear_date'] != null) {
                $payment['clear_date'] = date('d-M-Y, D', strtotime($payment['clear_date']));
            } else {
                $payment['clear_date'] = "Pending";
            }
        }

        $customers = Customer::all();

        return view('payments.index', compact('payments', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();

        foreach ($customers as $customer) {
            $total_billing = Invoice::where('customer_id', $customer->id)->sum('net_amount');
            $total_payments = Payments::where('customer_id', $customer->id)->sum('amount');
            $customer->balance = $total_billing - $total_payments;
        }

        return view('payments.add-payment', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_token' => 'required|string',
            'customer_id' => 'required|integer',
            'type' => 'required|string',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'cheque_no' => 'nullable|string',
            'bank' => 'nullable|string',
            'issue_date' => 'nullable|date',
            'clear_date' => 'nullable|date',
            'slip_no' => 'nullable|string',
            'party' => 'nullable|string',
            't_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Payments::create($request->all());

        return redirect()->route('payment.create')->with('success', 'Payment added successfully');
        // return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Payments $payments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payments $payments)
    {
        //
    }
}
