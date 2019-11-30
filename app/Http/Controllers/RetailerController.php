<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Validator;

use Auth;

use App\Distributor;

use App\Retailer;

use App\Town;

use Session;

use App\Services\Retailer\Retailerimport;



class RetailerController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $retailers = Retailer::where(['deleted' => '0'])->orderBy('shopname', 'ASC')->get();

        $distributors = Distributor::where(['deleted' => '0'])->orderBy('distributorname', 'ASC')->get();

        return view('retailers.index', compact('retailers', 'distributors'));

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

            'shopname' => 'required|max:128',

            'code' => 'required|max:64|unique:retailers',

            'ownername' => 'required|max:128',

            'distributor_id' => 'required',

            'rmn' => 'required|numeric|digits_between:1,20',

            'email' => 'required|email|max:128',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



        DB::beginTransaction();



        try {



            Retailer::create(

                [

                    'shopname' => $request->shopname,

                    'code' => $request->code,

                    'ownername' => $request->ownername,

                    'distributor_id' => $request->distributor_id,

                    'rmn' => $request->rmn,

                    'email' => $request->email,

                    'created_at' => date('Y-m-d H:i:s'),

                    'updated_at' => date('Y-m-d H:i:s'),

                    'createdbyuserid' => Auth::user()->id,

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );



            DB::commit();



            return response()->json(['success'=>'Retailer Created Successfully!']);

   

        } catch (\Exception $e) {



          DB::rollback();

          return response()->json(['error'=>array('Could not add retailer!')]);



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

        $ret = Retailer::where(['id' => $id])->first();

        return view('retailers.show', compact('ret'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $ret = Retailer::where(['id' => $id])->first();

        $distributors = Distributor::where(['deleted' => '0', 'active' => '1'])

                ->whereNotIn('id', [$ret->Distributor->id])->orderBy('distributorname', 'ASC')->get();



        return view('retailers.edit', compact('distributors','ret'));

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

            'shopname' => 'required|max:128',

            'code' => 'required|max:64|unique:retailers,code,'.$id,

            'ownername' => 'required|max:128',

            'distributor_id' => 'required',

            'rmn' => 'required|numeric|digits_between:1,20',

            'email' => 'required|email|max:128',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



        DB::beginTransaction();



        try {



            Retailer::where(['id' => $id])->update(

                [

                    'shopname' => $request->shopname,

                    'code' => $request->code,

                    'ownername' => $request->ownername,

                    'distributor_id' => $request->distributor_id,

                    'rmn' => $request->rmn,

                    'email' => $request->email,

                    'active' => $request->active,

                    'updated_at' => date('Y-m-d H:i:s'),

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );



            DB::commit();



            return response()->json(['success'=>'Retailer Updated Successfully!']);

        

        } catch (\Exception $e) {



          DB::rollback();

          return response()->json(['error'=>array('Could not update retailer!')]);



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



    public function getinfo($code){

        $retailer = Retailer::where(['code' => $code])->first();

        

        if (!empty($retailer)) {

            return [

                'retailer_id' => $retailer->id,

                'shopname' => $retailer->shopname,

                'rmn' => $retailer->Distributor->rmn,

                'hq' => $retailer->Distributor->hq,

                'dsh' => $retailer->Distributor->dsh,

                'rh' => $retailer->Distributor->rh,

                'scheme' => $retailer->Distributor->scheme,

                'district' => $retailer->Distributor->Town->District->name,

                'town' => $retailer->Distributor->Town->name

            ];

        } else {

            return [

                'retailer_id' => null,

                'shopname' => null,

                'rmn' => null,

                'hq' => null,

                'dsh' => null,

                'rh' => null,

                'scheme' => null,

                'district' => null,

                'town' => null

            ];

        }

        

    }





    /**

     * Display a the CSV import form.

     *

     * @return \Illuminate\Http\Response

     */

    public function import()

    {

        return view('retailers.import');

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

        

        $validation = new Retailerimport();



        $checkData = $validation->checkImportData($rows);



        if(count($checkData) > 0){



            $report_error = [];



            foreach ($checkData as $key => $value) {

                $report_error[$key]['shopname'] = $value['0'];

                $report_error[$key]['retailer_code'] = $value['1'];

                $report_error[$key]['distributor_code'] = $value['2'];

                $report_error[$key]['ownername'] = $value['3'];

                $report_error[$key]['rmn'] = $value['4'];

                $report_error[$key]['email'] = $value['5'];

                $report_error[$key]['address'] = $value['6'];

                $report_error[$key]['message'] = $value['message'];

		$report_error[$key]['RowNumber'] = $value['RowNumber'];

            }

            

            Session::flash('error', 'File could not be uploaded. Please check for errors.');

            return view('retailers.import', compact('report_error'));

        }



        DB::beginTransaction();



        try {



            foreach ($rows as $row) {



              $distributor_id = Distributor::where(['code' => $row[2]])->first();

                

                Retailer::create([

                    'shopname' => $row[0],

                    'code' => $row[1],

                    'distributor_id' => $distributor_id->id,

                    'ownername' => $row[3],

                    'rmn' => $row[4],

                    'email' => $row[5],

                    'address' => $row[6],

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

