<?php

namespace App\Exports;

use App\Orderdetail;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('sales.download', [
            'orders' => Orderdetail::where(['deleted' => '0', 'active' => '1'])->whereBetween('created_at', [date('Y-m-d').' 00:00:01', date('Y-m-d').' 23:59:59'])->get()
        ]);
    }
}
