<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Retailer;
use App\Town;

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
        return view('home');
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
