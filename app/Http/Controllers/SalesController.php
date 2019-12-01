<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use App\Retailer;
use App\Town;
use App\Product;
use App\Order;
use App\Orderdetail;
use Session;
use App\Http\Controllers\EmailController;
use App\Services\Curl\Curlmarico;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where(['deleted' => '0'])->orderBy('created_at', 'DESC')->paginate(20);

        return view('sales.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'retailer_id' => 'required|max:20',
            'phone' => 'required|max:20',
            'name' => 'required|max:128',
            'location' => 'required',
            'bazar' => 'required|max:128',
            'businessarea' => 'required|max:128',
            'quest' => 'required',
            'req' => 'required',
            'solution' => 'required|max:20',
            'calltype' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        if (!array_key_exists('product_id', $request->all())) {
            
            return response()->json(['error'=>array('Add order instruments')]);
        
        } else {

            foreach ($request->product_id as $key => $value) {
                if (empty($value)) {
                    return response()->json(['error'=>array('Prduct cannot be empty')]);
                }
            }

        }

        if (!array_key_exists('quantity', $request->all())) {
            
            return response()->json(['error'=>array('Add order instruments properly')]);
        
        } else {

            foreach ($request->quantity as $key => $value) {
                if (empty($value)) {
                    return response()->json(['error'=>array('Quantity cannot be empty')]);
                }
            }

        }

        if (!array_key_exists('subtotal', $request->all())) {
            
            return response()->json(['error'=>array('Add order instruments properly')]);
        
        } else {

            foreach ($request->subtotal as $key => $value) {
                if (empty($value)) {
                    return response()->json(['error'=>array('Prduct or Quantity cannot be empty')]);
                }
            }

        }

        $retailer = Retailer::where(['id' => $request->retailer_id])->first();

        DB::beginTransaction();

        try {

            $id = DB::table('orders')->insertGetId(
                [
                    'retailer_id' => $request->retailer_id,
                    'code' => time(),
                    'phone' => $request->phone,
                    'name' => $request->name,
                    'location' => $request->location,
                    'bazar' => $request->bazar,
                    'businessarea' => $request->businessarea,
                    'quest' => $request->quest,
                    'req' => $request->req,
                    'solution' => $request->solution,
                    'calltype' => $request->calltype,   
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'createdbyuserid' => Auth::user()->id,
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            

            $code = 'OD-'.sprintf('%06d', $id).'-'.rand(10,100);

            Order::where(['id' => $id])->update(
              [
                'code' => $code,
              ]
            );
            
            foreach ($request->product_id as $key => $value) {
                DB::table('orderdetails')->insert([
                    'product_id' => $value,
                    'order_id' => $id,
                    'unitprice' => $request->rate[$key],
                    'qty' => $request->quantity[$key],
                    'subtotal' => $request->subtotal[$key],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'createdbyuserid' => Auth::user()->id,
                    'updatedbyuserid' => Auth::user()->id,
                ]);
            }
            
            DB::commit();

            $sale = Order::where(['id' => $id])->first();

            $body = view('sales.show', compact('sale'));
            
            (new EmailController)->sendmail([$retailer->Distributor->email], $body, null, 'New Sale Notification');

            $notify = new Curlmarico();

            $notify->notifysale($id);

            return response()->json(['success'=> array('Order Placed Successfully')]);
        
        } catch (\Exception $e) {

          DB::rollback();
          return $e->getMessage();
          return response()->json(['error'=>array('Could not place order!')]);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Order::where(['id' => $id])->first();
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function addorderdetails(){
        $products = Product::where(['active' => '1', 'deleted' => '0'])->get();
        
        $rand = time();

        $product_id = "<option value=''>Select</option>";

        foreach ($products as $key => $value) {
            $product_id .= "<option value='$value->id'>$value->name</option>";
        }

        $html = "<tr> <td> <select class='form-control prod_id' id='mane$rand' name='product_id[]'> $product_id </select> </td> <td> <input class='form-control rate' id='rate$rand' type='text' name='rate[]' readonly> </td> <td> <input class='form-control qty' type='number' id='qty$rand' name='quantity[]'> </td> <td><input type='text' class='subtotal' name='subtotal[]' readonly></td> <td><span class='delete btn btn-danger btn-xs'>Remove</span></td> </tr>";

        return json_encode($html);
    }

    public function getprice($id){
        return Product::where(['id' => $id])->first();
    }


    private function hasOrderitems($request){
        
        if (!array_key_exists('product_id', $request)) {
            
            return false;
        
        } else {



        }

        if (!array_key_exists('qty', $request)) {
            
            return false;
        
        }

        if (!array_key_exists('subtotal', $request)) {
            
            return false;
        
        }
        
        return true;
        
    }


    public function search(Request $request) {

      $result = Order::where(['deleted' => '0']);

      if (!empty($request->from)) {
        $result->where('created_at', '>=', $request->from);
      }

      if (!empty($request->to)) {
        $result->where('created_at', '<=', $request->to.' 23:59:59');
      }
      
      $orders = $result->orderBy('created_at', 'DESC')->paginate(20);

      $from = $request->from;
      $to = $request->to;

      return view('sales.getsearch', compact('orders','from','to'));
    }


    public function download($from, $to) {

      $result = Orderdetail::where(['deleted' => '0']);

      if (!empty($from)) {
        $result->where('created_at', '>=', $from);
      }

      if (!empty($to)) {
        $result->where('created_at', '<=', $to.' 23:59:59');
      }
      
      $orders = $result->orderBy('created_at', 'DESC')->get();

      return view('sales.download', compact('orders'));
    }

}
