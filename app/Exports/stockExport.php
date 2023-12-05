<?php

namespace App\Exports;

use App\Models\Orders;
use Illuminate\Support\Collection;
use App\Models\stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class stockExport implements FromCollection ,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
     protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Email',
            'first order date',
            'last order date',
            'total orders',
            'total quantity',
            'Days difference '
        ];
    }
}
