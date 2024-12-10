<?php

namespace App\Http\Controllers;
use App\Models\Medicine;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function exportExcel() {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }


    public function index(Request $request)
    {
        //
        $searchDate = $request->input('search_order');  // Get search date from input

    // Build query based on user and filter date if provided
    $query = Order::where('user_id', Auth::user()->id)->OrderBy('created_at', 'DESC');

    if ($searchDate) {
        // Filter orders by the input date
        $query->whereDate('created_at', '=', $searchDate);
    }

    // Paginate the results after applying the date filter
    $orders = $query->simplePaginate(8);

        return view('order.cashier.cashier', compact('orders'));
    }

    public function indexAdmin(Request $request)
    {
        $searchDate = $request->input('search_order');  // Get search date from input

        // Build query based on user and filter date if provided
        $query = Order::with('user')->OrderBy('created_at', 'DESC');

        if ($searchDate) {
            // Filter orders by the input date
            $query->whereDate('created_at', '=', $searchDate);
        }

        // Paginate the results after applying the date filter
        $orders = $query->simplePaginate(8);

            return view('order.admin.index', compact('orders'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $medicines = Medicine::all();
        return view('order.form' , compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'medicines' => 'required',
        ], [
            'name_customer.required' => 'Customer name is required',
            'medicines.required' => 'Medicines is required',
        ]);

        $arrayValues = array_count_values($request->medicines);
        $arraynewmedicines = [];
        $total = 0;

        foreach ($arrayValues as $key => $value) {
            $medicines = Medicine::where('id', $key)->first();

            if ($medicines->stock < $value) {
                $valueBefore = [
                    "name_customer" => $request->name_customer,
                    "medicines" => $request->medicines
                ];
                $msg = 'Stock Obat ' . $medicines['name'] . ' Tidak Cukup';
                return redirect()->back()->withInput()->with(['failed' => $msg, 'valueBefore' => $valueBefore]);
            } else {
                $medicines->stock -= $value;
                $medicines->save();
            }

            $totalPrice = $medicines->price * $value;
            $arrayItem = [
                "id" => $key,
                "name_medicine" => $medicines->name,
                "qty" => $value,
                "price" => $medicines->price,
                "total_price" => $totalPrice,
            ];
            $total += $totalPrice;
            array_push($arraynewmedicines, $arrayItem);
        }

        $orders = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arraynewmedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $total, // Save total without PPN
        ]);

        if ($orders) {
            $result = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->first();
            return redirect()->route('purchase.show', $result->id);
        } else {
            return redirect()->back()->with('failed', 'Order failed');
        }
    }
    public function downloadPDF($id)
    {
        $order = Order::where('id', $id)->first()->toArray();

        //buat nama variabel yang akan digunakan di pdf
        view()->share('order', $order);

        //panggil file yang akan diubah menjadi pdf
        $pdf = Pdf::loadView('order.cashier.pdf', $order);

        return $pdf->download('struk-pembelian.pdf');
   }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, $id)
    {
        //
        $order = Order::Where('id' , $id)->first();

        return view('order.cashier.print' , compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
