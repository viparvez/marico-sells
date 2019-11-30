<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Validator;

use Auth;

use App\Distributor;

use App\Town;

use Session;

use App\Services\Distributor\Distributorimport;



class DistributorController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $distributors = Distributor::where(['deleted' => '0'])->orderBy('distributorname', 'ASC')->get();

        $towns = Town::where(['deleted' => '0'])->orderBy('name', 'ASC')->get();

        return view('distributors.index', compact('distributors', 'towns'));

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

            'distributorname' => 'required|max:128',

            'code' => 'required|max:64|unique:retailers',

            'ownername' => 'required|max:128',

            'town_id' => 'required',

            'rmn' => 'required|numeric|digits_between:1,20',

            'email' => 'required|email|max:128',

            'hq' => 'required|max:64',

            'dsh' => 'required|max:64',

            'rh' => 'required|max:64',

            'scheme' => 'required|max:128',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



        DB::beginTransaction();



        try {



            Distributor::create(

                [

                    'distributorname' => $request->distributorname,

                    'code' => $request->code,

                    'ownername' => $request->ownername,

                    'town_id' => $request->town_id,

                    'rmn' => $request->rmn,

                    'email' => $request->email,

                    'hq' => $request->hq,

                    'dsh' => $request->dsh,

                    'rh' => $request->rh,

                    'scheme' => $request->scheme,

                    'created_at' => date('Y-m-d H:i:s'),

                    'updated_at' => date('Y-m-d H:i:s'),

                    'createdbyuserid' => Auth::user()->id,

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );



            DB::commit();



            return response()->json(['success'=>'Distributor Created Successfully!']);

   

        } catch (\Exception $e) {



          DB::rollback();

          return response()->json(['error'=>array('Could not add distributor')]);



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

        $dist = Distributor::where(['id' => $id])->first();

        return view('distributors.show', compact('dist'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $dist = Distributor::where(['id' => $id])->first();

        $towns = Town::where(['deleted' => '0', 'active' => '1'])

                ->whereNotIn('id', [$dist->town_id])->orderBy('name', 'ASC')->get();



        return view('distributors.edit', compact('towns','dist'));

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

            'distributorname' => 'required|max:128',

            'code' => 'required|max:64|unique:retailers,code,'.$id,

            'ownername' => 'required|max:128',

            'town_id' => 'required',

            'rmn' => 'required|numeric|digits_between:1,20',

            'email' => 'required|email|max:128',

            'hq' => 'required|max:64',

            'dsh' => 'required|max:64',

            'rh' => 'required|max:64',

            'scheme' => 'required|max:128',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



        DB::beginTransaction();



        try {



            Distributor::where(['id' => $id])->update(

                [

                    'distributorname' => $request->distributorname,

                    'code' => $request->code,

                    'ownername' => $request->ownername,

                    'town_id' => $request->town_id,

                    'rmn' => $request->rmn,

                    'email' => $request->email,

                    'hq' => $request->hq,

                    'dsh' => $request->dsh,

                    'rh' => $request->rh,

                    'scheme' => $request->scheme,

                    'active' => $request->active,

                    'updated_at' => date('Y-m-d H:i:s'),

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );



            DB::commit();



            return response()->json(['success'=>'Distributor Updated Successfully!']);

        

        } catch (\Exception $e) {



          DB::rollback();

          return response()->json(['error'=>array('Could not update distributor!')]);



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

        return view('distributors.import');

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

        

        $validation = new Distributorimport();



        $checkData = $validation->checkImportData($rows);



        if(count($checkData) > 0){



            $report_error = [];



            foreach ($checkData as $key => $value) {

                $report_error[$key]['code'] = $value['0'];

                $report_error[$key]['town_code'] = $value['1'];

                $report_error[$key]['ownername'] = $value['2'];

                $report_error[$key]['distributorname'] = $value['3'];

                $report_error[$key]['rmn'] = $value['4'];

                $report_error[$key]['email'] = $value['5'];

                $report_error[$key]['hq'] = $value['6'];

                $report_error[$key]['dsh'] = $value['7'];

                $report_error[$key]['rh'] = $value['8'];

                $report_error[$key]['scheme'] = $value['9'];

                $report_error[$key]['message'] = $value['message'];

				$report_error[$key]['RowNumber'] = $value['RowNumber'];

            }

            

            Session::flash('error', 'File could not be uploaded. Please check for errors.');

            return view('distributors.import', compact('report_error'));

        }



        DB::beginTransaction();



        try {



            foreach ($rows as $row) {



              $town_id = Town::where(['code' => $row[1]])->first();

                DB::table('distributors')->insert([

                    'code' => $row[0],

                    'town_id' => $town_id->id,

                    'ownername' => $row[2],

                    'distributorname' => $row[3],

                    'rmn' => $row[4],

                    'email' => $row[5],

                    'hq' => $row[6],

                    'dsh' => $row[7],

                    'rh' => $row[8],

                    'scheme' => $row[9],

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

