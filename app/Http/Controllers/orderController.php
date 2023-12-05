<?php

namespace App\Http\Controllers;

use App\Exports\stockExport;
use App\Imports\orderImport;
use App\Models\Orders;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class orderController extends Controller
{
    //
     public function index()
    {
         $result = Orders::selectRaw(
            'Email_address as email,
            MIN(order_date) as first_order,
            MAX(order_date) as last_order,
            COUNT(order_date) as total_orders,
            SUM(quantity) as total_quantity,
            DATEDIFF(MAX(order_date), MIN(order_date)) as day_diff'
            )->groupBy('Email_address')->paginate(15);
        
            return view('stock.index', ['result' => $result]);
    }
    public function importOrder()
    {
        return view('stock.import');
    }

    public function uploadOrder(Request $request)
    {
        Excel::import(new orderImport, $request->file);
        
        return redirect()->route('stock.index')->with('success', 'User Imported Successfully');
    }

    public function export() 
    {
        $result = Orders::selectRaw(
            'Email_address as email,
            MIN(order_date) as first_order,
            MAX(order_date) as last_order,
            COUNT(order_date) as total_orders,
            SUM(quantity) as total_quantity,
            DATEDIFF(MAX(order_date), MIN(order_date)) as day_diff'
            )->groupBy('Email_address')->get();
        return Excel::download(new stockExport($result), 'orders_list.xlsx');
    }

}
