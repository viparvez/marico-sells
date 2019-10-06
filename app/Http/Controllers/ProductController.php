<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use App\Product;
use Session;
use App\Services\Product\Productimport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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


    /**
     * Display a the CSV import form.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('products.import');
    }


    public function handleimport(Request $request){

        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);
        
        if ($validator->fails()) {
            //return response()->json(['error'=>$validator->errors()->all()]);
            return redirect()->back()->withErrors($validator);
        }
        
        $file = $request->file('file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);
        
        $validation = new Productimport();

        return $validation->checkImportData($rows);

        foreach ($rows as $row) {
            /*
            $row = array_combine($header, $row);
            
            Product::create([
                'name' => $row['name'],
                'sku_code' => $row['code'],
                'sku_desc' => $row['description'],
                'unit_price' => $row['price'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'createdbyuserid' => Auth::user()->id,
                'updatedbyuserid' => Auth::user()->id,
            ]);
            
            Product::create([
                'name' => $row[0],
                'sku_code' => $row[1],
                'sku_desc' => $row[2],
                'unitprice' => $row[3],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'createdbyuserid' => Auth::user()->id,
                'updatedbyuserid' => Auth::user()->id,
            ]);
            */

        }
        
        Session::flash('message', 'This is a message!'); 
        return redirect()->back();

    }



}
