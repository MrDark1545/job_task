<?php

namespace App\Http\Controllers;
use Input;
use Carbon\Carbon;

use App\Exports\stockExport;
use App\Imports\orderImport;
use App\Models\Orders;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class orderController extends Controller
{
     public function index()
    {
        $result = session(['data']);        
        return view('stock.index', ['result' => $result]);
    }
    
    public function importOrder()
    {
        return view('stock.import');
    }

    public function uploadOrder(Request $request)
    {
        $filedata = Excel::toCollection(new OrderImport, $request->file('file'));
        foreach ($filedata as $data) 
        {
            foreach($data as $row)
            {
                $email = $row['email_address'];
                $orderDate = $row['order_date'];
                $quantity = $row['product_qty'];
                if (!isset($userOrders[$email])) {
                    // Initialize user's data if it's the first time encountering the email
                    $userOrders[$email] = [
                        'email' => $email,
                        'first_order_date' => $orderDate,
                        'last_order_date' => $orderDate,
                        'total_quantity_ordered' => $quantity,
                        'total_orders' => 1,
                        'date_difference' => 0,
                    ];
                } else {
                    // Update last order date and increment total quantity ordered
                    $userOrders[$email]['last_order_date'] = $orderDate;
                    $userOrders[$email]['total_quantity_ordered'] += $quantity;
                    $userOrders[$email]['total_orders'] += 1;
                    $firstOrderDate = Carbon::createFromFormat('m/d/Y H:i:s', $userOrders[$email]['first_order_date']);
                    $lastOrderDate = Carbon::createFromFormat('m/d/Y H:i:s', $userOrders[$email]['last_order_date']);
                    $difference = $lastOrderDate->diffInDays($firstOrderDate);
                    $userOrders[$email]['date_difference'] = $difference;
                }
            }
        }
        foreach ($userOrders as $userData) 
        {
            $formattedData[] = [
                'email' => $userData['email'],
                'first_order_date' => $userData['first_order_date'],
                'last_order_date' => $userData['last_order_date'],
                'total_quantity_ordered' => $userData['total_quantity_ordered'],
                'total_orders' =>$userData['total_orders'],
                'day_diff' => $userData['date_difference'],
            ];
        }
        //storing data in sessions so we can use that data in export without processing again and again
        session(['data' => $formattedData]);
    return view('stock.index', ['result' => $formattedData]);
    }

    public function export() 
    {
        $data = session('data');
        $result = collect($data);
        return Excel::download(new stockExport($result), 'orders_list.xlsx');
    }

}
