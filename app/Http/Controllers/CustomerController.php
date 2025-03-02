<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = Customer::all();
        
        $searchQuery = $request->input('customer');
        $city = $request->input('city', 'all');
        $status = $request->input('status', 'all');

        $customers = Customer::query();

        // Apply filters based on the input parameters
        if ($searchQuery) {
            $customers->where('customer', 'like', "%$searchQuery%");
        }

        if ($city !== 'all') {
            $customers->where('city', $city);
        }

        if ($status !== 'all') {
            $customers->where('status', $status);
        }

        // Execute the query and get the filtered customers
        $customers = $customers->get();
        
        foreach ($customers as $customer) {
            $total_billing = invoice::where('customer_id', $customer->id)->sum('net_amount');
            $total_payments = Payments::where('customer_id', $customer->id)->sum('amount');
            $customer['balance'] = number_format(($total_billing - $total_payments), 1, '.', ',');
        }

        $cities = $customers->pluck('city')->unique()->values()->toArray();

        if ($request->ajax()) {
            return view('customer.index', compact('customers', 'cities'));
        }

        return view('customer.index', compact('customers','cities'));
        // return response()->json($cities);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();

        return view('customer.add-customer', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (strtolower($value) === 'm/s') {
                        $fail('The customer field is required.');
                    }
                },
            ],
            'person_name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (strtolower($value) === 'mr.') {
                        $fail('The person name field is required.');
                    }
                },
            ],
            'phone' => 'required|string|max:255|unique:customers,phone',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if customer already exists in the same city
        $duplicate = Customer::where('city', $request->city)
            ->where('customer', $request->customer)
            ->exists();

        if ($duplicate) {
            return redirect()->back()->withErrors([
                'customer' => "The customer is already exists in '{$request->city}'."
            ])->withInput();
        }

        // Prepare data for saving
        $data = $request->all();

        // Handle the image upload if present
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/images', $fileName, 'public'); // Store in public disk

            $data['image'] = $fileName; // Save the file path in the database
        }

        // Save the customer
        Customer::create($data);

        return redirect()->route('customer.create')->with('success', 'Customer added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $customer = Customer::find($request->customer_id);


        if ($request->status == 'active') {
            $total_billing = invoice::where('customer_id', $customer->id)->sum('net_amount');
            $total_payments = Payments::where('customer_id', $customer->id)->sum('amount');
            $balance = number_format(($total_billing - $total_payments), 1, '.', ',');
            if ($balance == 0) {
                $customer->status = 'in_active';
            } else {
                return redirect()->back()->with('warning', 'If you are In Active that Customer to clear there balance.');
            }
        } else {
            $customer->status = 'active';
        }
        $customer->save();
        return redirect()->back()->with('success', 'Status updated successfully');
    }
    public function customerStatment(Request $request)
    {
        $customer_id = $request->customerId;
        if ($customer_id) {
            $dateTo = $request->dateTo;
            $dateFrom = $request->dateFrom;

            $previousBalance = 0;

            if ($dateTo != null) {
                $billAmount = Invoice::where('customer_id', $customer_id)
                    ->where('date', '<', $dateTo)
                    ->orderBy('date', 'asc')
                    ->get()->sum('net_amount');

                $paymentAmount = Payments::where('customer_id', $customer_id)
                    ->where('date', '<', $dateTo)
                    ->orderBy('date', 'asc')
                    ->get()->sum('amount');

                $previousBalance = $billAmount - $paymentAmount;
            }

            if ($dateFrom != null && $dateTo != null) {
                $bills = Invoice::where('customer_id', $customer_id)
                    ->whereBetween('date', [$dateTo, $dateFrom])
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array

                $payments = Payments::where('customer_id', $customer_id)
                    ->whereBetween('date', [$dateTo, $dateFrom])
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array
            }
            else if ($dateTo != null) {
                $bills = Invoice::where('customer_id', $customer_id)
                    ->where('date', '>=', $dateTo)
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array

                $payments = Payments::where('customer_id', $customer_id)
                    ->where('date', '>=', $dateTo)
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array
            }
            else if ($dateFrom != null) {
                $bills = Invoice::where('customer_id', $customer_id)
                    ->where('date', '<=', $dateFrom)
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array

                $payments = Payments::where('customer_id', $customer_id)
                    ->where('date', '<=', $dateFrom)
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array
            }
            else {
                $bills = Invoice::where('customer_id', $customer_id)
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array

                $payments = Payments::where('customer_id', $customer_id)
                    ->orderBy('date', 'asc')
                    ->get()
                    ->toArray(); // Convert collection to array
            }

            foreach ($bills as &$bill) { // Use reference (&)
                $bill['date'] = date('d-M-Y, D', strtotime($bill['date']));
                $bill['transaction'] = 'Invoice';
                $bill['reference'] = $bill['invoice_no'];
                $bill['description'] = "Total Qty ". $bill['total_quantity'] ." - Pcs.";
                $bill['sales'] = number_format($bill['net_amount'], 1, '.', ',');
                $bill['payment'] = "-";
                $bill['balance'] = 0;
            }
            unset($bill);

            foreach ($payments as &$payment) {
                $payment['date'] = date('d-M-Y, D', strtotime($payment['date']));

                $payment['transaction'] = 'Payment';
                
                switch ($payment['type']) {
                    case 'cash':
                        $payment['reference'] = "-";
                        $payment['description'] = 'Cash';
                        break;
                    case 'cheque':
                        $payment['reference'] = $payment['cheque_no'];
                        $payment['description'] = 'Cheque | ' . $payment['bank'];
                        break;
                    case 'slip':
                        $payment['reference'] = $payment['slip_no'];
                        $payment['description'] = 'Slip | ' . $payment['party'];
                        break;
                    case 'online':
                        $payment['reference'] = $payment['t_id'];
                        $payment['description'] = 'Online | ' . $payment['bank'];
                        break;
                    case 'adjustment':
                        $payment['reference'] = "-";
                        $payment['description'] = 'Adjustment | ' . $payment['remarks'];;
                        break;
                    default:
                        $payment['reference'] = '-';
                        $payment['description'] = '-';
                        break;
                }

                $payment['sales'] = "-";
                $payment['payment'] = number_format($payment['amount'], 1, '.', ',');
                $payment['balance'] = 0;
            }
            unset($payment);

            // Merge and sort both data by date
            $customerStatement = array_merge($bills, $payments);
             
            usort($customerStatement, function ($a, $b) {
                // Compare by 'date' first
                $dateComparison = strtotime($a['date']) - strtotime($b['date']);
            
                // If dates are the same, compare by 'created_at'
                if ($dateComparison === 0) {
                    return strtotime($a['created_at']) - strtotime($b['created_at']);
                }
            
                return $dateComparison;
            });            

            $temporayBalance = $previousBalance;

            foreach ($customerStatement as $key => &$statement) {
                if ($statement['transaction'] == 'Invoice') {
                    $temporayBalance += $statement['net_amount'];
                    $statement['balance'] = $temporayBalance;
                } else {
                    $temporayBalance -= $statement['amount'];
                    $statement['balance'] = $temporayBalance;
                }

                $statement['balance'] = $statement['balance'];
                $previousBalance = $previousBalance;
            }

            $customers = Customer::all();
            return view('customer.customer-statment', compact('customers', 'customerStatement', 'previousBalance'));
            // return $customerStatement;
        } else {
            $customers = Customer::all();
            return view('customer.customer-statment', compact('customers'));
        }
    }
}
