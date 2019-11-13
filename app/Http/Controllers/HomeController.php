<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Retailer;
use App\Town;
use App\Order;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $result = DB::select(
            "
                SELECT 
                    prod.name as name,
                    sum(ordd.qty) as total
                FROM orderdetails ordd
                INNER JOIN products prod ON prod.id = ordd.product_id
                WHERE ordd.deleted = '0'
                AND ordd.active = '1'
                AND ordd.created_at >=  DATE_FORMAT(NOW() ,'%Y-%m-01') 
                GROUP BY prod.id, prod.name
                LIMIT 10
            "
        );

        $last_calls = Order::where(['active' => '1', 'deleted' => '0'])
                        ->whereRaw('created_at >= ?',[date('Y-m-d')])
                        ->orderBy('created_at', 'DESC')->take(5)->get();


        return view('home', compact('result', 'last_calls'));
    }

    public function test($code) {
        $result = Town::where(['code' => $code])->first();

        if (empty($result)) {
            return 'true';
        } else {
            return 'false';
        }
    }
}
