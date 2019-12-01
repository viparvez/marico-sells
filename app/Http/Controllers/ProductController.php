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

        $products = Product::where(['deleted' => '0'])->orderBy('name', 'ASC')->get();

        return view('products.index', compact('products'));

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

        $validator = Validator::make($request->all(), [

            'name' => 'required|max:64',

            'sku_code' => 'required|max:64',

            'sku_desc' => 'required|max:128',

            'unitprice' => 'required|numeric|max:9999999.99',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



        DB::beginTransaction();



        try {



            Product::create(

                [

                    'name' => $request->name,

                    'sku_code' => $request->sku_code,

                    'sku_desc' => $request->sku_desc,

                    'unitprice' => $request->unitprice,

                    'created_at' => date('Y-m-d H:i:s'),

                    'updated_at' => date('Y-m-d H:i:s'),

                    'createdbyuserid' => Auth::user()->id,

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );



            DB::commit();



            return response()->json(['success'=>'Product Created Successfully!']);

   

        } catch (\Exception $e) {



          DB::rollback();

          return response()->json(['error'=>array('Could not add')]);



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

        $prod = Product::where(['id' => $id])->first();

        return view('products.show', compact('prod'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $prod = Product::where(['id' => $id])->first();

        return view('products.edit', compact('prod'));

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

        $validator = Validator::make($request->all(), [

            'name' => 'required|max:64',

            'sku_code' => 'required|max:64|unique:products,sku_code,'.$id,

            'sku_desc' => 'required|max:128',

            'unitprice' => 'required|numeric|max:9999999.99',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



        DB::beginTransaction();



        try {



            Product::where(['id' => $id])->update(

                [

                    'name' => $request->name,

                    'sku_code' => $request->sku_code,

                    'sku_desc' => $request->sku_desc,

                    'unitprice' => $request->unitprice,

                    'active' => $request->active,

                    'updated_at' => date('Y-m-d H:i:s'),

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );



            DB::commit();



            return response()->json(['success'=>'Product Updated Successfully!']);

   

        } catch (\Exception $e) {



          DB::rollback();

          

          return response()->json(['error'=>array('Could not update')]);



        }

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

            'file' => 'required|mimes:csv,txt',

        ]);

        

        if ($validator->fails()) {

            Session::flash('error', 'Please upload valid file!'); 

            return redirect()->back();

        }

        

        $file = $request->file('file');

        $csvData = file_get_contents($file);

        $rows = array_map('str_getcsv', file($file, FILE_SKIP_EMPTY_LINES));

        $header = array_shift($rows);

        

        $validation = new Productimport();



        $checkData = $validation->checkImportData($rows);



        if(count($checkData) > 0){



            $report_error = [];



            foreach ($checkData as $key => $value) {

                $report_error[$key]['name'] = $value['0'];

                $report_error[$key]['sku_code'] = $value['1'];

                $report_error[$key]['sku_desc'] = $value['2'];

                $report_error[$key]['price'] = $value['3'];

                $report_error[$key]['message'] = $value['message'];

		$report_error[$key]['RowNumber'] = $value['RowNumber'];

            }

            

            Session::flash('error', 'File could not be uploaded. Please check for errors.');

            return view('products.import', compact('report_error'));

        }



        DB::beginTransaction();



        try {



            foreach ($rows as $row) {

                

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

                

            }



            DB::commit();



            Session::flash('success', 'Data imported successfully!'); 

            return redirect()->back();

            

        } catch (Exception $e) {

            DB::rollback();

            Session::flash('error', 'File could not be uploaded. Please check for duplicates.');

            return redirect()->back();

        }

        

    }







}

