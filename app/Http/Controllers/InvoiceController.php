<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Customer;
use App\Models\invoice;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|min:1',
            'customer_id' => 'nullable'
        ]);

        $query = $request->get('query');
        $customerId = $request->get('customer_id');

        // Fetch invoices with customer relationship
        $invoices = Invoice::with('customer');

        if ($query) {
            $invoices->where('invoice_no', 'LIKE', "%{$query}%");
        }

        if ($customerId !== "all" && !empty($customerId)) {
            $invoices->where('customer_id', $customerId);
        }

        $invoices = $invoices->get();

        // Calculate balances
        foreach ($invoices as $invoice) {
            $previous_bills = Invoice::where('customer_id', $invoice->customer_id)
                ->where(function ($q) use ($invoice) {
                    $q->where('date', '<', $invoice->date)
                        ->orWhere(function ($q) use ($invoice) {
                            $q->where('date', '=', $invoice->date)
                                ->whereTime('created_at', '<', $invoice->created_at);
                        });
                })
                ->sum("net_amount");

            $previous_payments = Payments::where('customer_id', $invoice->customer_id)
                ->where(function ($q) use ($invoice) {
                    $q->where('date', '<', $invoice->date)
                        ->orWhere(function ($q) use ($invoice) {
                            $q->where('date', '=', $invoice->date)
                                ->whereTime('created_at', '<', $invoice->created_at);
                        });
                })
                ->sum("amount");

            $invoice['previous_balance'] = $previous_bills - $previous_payments;
        }

        // Calculate total billing per customer
        foreach ($invoices as $invoice) {
            $invoice->customer->balance = Invoice::where('customer_id', $invoice->customer_id)->sum('net_amount');
            $invoice['date'] = date('d-M-Y, D', strtotime($invoice->date));
        }

        $customers = Customer::all();

        // Return the full view for both normal and AJAX requests
        return view('invoices.index', compact('invoices', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('status', 'active')->get();

        foreach ($customers as $customer) {
            $total_billing = invoice::where('customer_id', $customer->id)->sum('net_amount');
            $total_payments = Payments::where('customer_id', $customer->id)->sum('amount');
            $customer->balance = $total_billing - $total_payments;
        }

        $last_invoice = invoice::orderby('id', 'desc')->first();

        if (!$last_invoice) {
            $last_invoice = new invoice();
            $last_invoice->invoice_no = '0000-0000';
        }

        $articlesNo = Article::select('article_no')->get();

        return view('invoices.create-invoice', compact('customers', 'last_invoice', 'articlesNo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer|exists:customers,id',
            'discount' => 'nullable|integer',
            'date' => 'required|date',
            'invoice_no' => 'required|string',
            'total_quantity' => 'required|integer|min:1',
            'total_amount' => 'required|integer|min:1',
            'net_amount' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data["date"] = date('Y-m-d', strtotime($request->date));
        $data["discount"] = $request->discount ?? 0;

        invoice::create($data);

        $customer = Customer::where('id', $request->customer_id)->first();

        $discount = $request->discount ?? 0;

        $articles = json_decode($request->articles_array, true);

        if (is_array($articles)) {
            foreach ($articles as $article) {
                $articleNo = $article['articleNo'] ?? null;
                $quantity = $article['quantity'] ?? 0;

                if ($articleNo && $quantity > 0) {
                    $articleRecord = Article::where('article_no', $articleNo)->first();

                    if ($articleRecord) {
                        $articleRecord->increment('sold_quantity', $quantity);
                    }
                }
            }
        }

        return redirect()->route('invoice.create')->with('success', 'Invoice Save Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice $invoice)
    {
        //
    }
    public function getArticleDetails(Request $request)
    {
        $articleNo = $request->article_no;

        $article = Article::where('article_no', $articleNo)->first();

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        // Calculate the quantity_in_stock
        $quantity_in_stock = $article->quantity - $article->sold_quantity;

        $sales_rate = $article->sales_rate;

        $description = $article->fabric_type;

        $image = $article->image;

        // Return only the quantity_in_stock value
        return response()->json(compact('quantity_in_stock', 'sales_rate', 'description', 'image'));
    }
}
