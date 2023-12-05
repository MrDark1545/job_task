<?php

namespace App\Imports;

use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class orderImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        set_time_limit(300);
        // dd($row);
        $orders = new Orders([
            "Order_Date" => Carbon::createFromFormat('m/d/Y H:i:s', $row['order_date'])->format('Y-m-d H:i:s'),
            "Email_address" => $row['email_address'],
            "Order_Status" => $row['order_status'],
            "quantity" => $row['product_qty'],
          
        ]);
        
        $result = Orders::selectRaw(
        'Email_address as email,
        MIN(order_date) as first_order,
        MAX(order_date) as last_order,
        COUNT(order_date) as total_orders,
        SUM(quantity) as total_quantity,
        DATEDIFF(MAX(order_date), MIN(order_date)) as day_diff'
        )->groupBy('Email_address')->paginate(15);

       
        return $result;
    }
}
