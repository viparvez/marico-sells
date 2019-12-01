<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Validator;

use Auth;

Use App\Town;

use App\District;

use Session;

use App\Services\Town\Townimport;





class TownController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $towns = Town::where(['deleted' => '0'])->orderBy('name', 'ASC')->get();

        $districts = District::where(['deleted' => '0', 'active' => '1'])->orderBy('name', 'ASC')->get();

        return view('location.towns.index', compact('towns','districts'));

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

            'name' => 'required|max:28|regex:/^[\pL\s\-]+$/u',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



                DB::beginTransaction();



        try {



            $id = DB::table('towns')->insertGetId(

                [

                    'code' => time(),

                    'name' => $request->name,

                    'district_id' => $request->district_id,

                    'created_at' => date('Y-m-d H:i:s'),

                    'updated_at' => date('Y-m-d H:i:s'),

                    'createdbyuserid' => Auth::user()->id,

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );

            

            $code = 'TWN'.sprintf('%06d', $id);



            Town::where(['id' => $id])->update(

              [

                'code' => $code,

              ]

            );



            DB::commit();



            return response()->json(['success'=>'Town Created Successfully!']);

        

        } catch (\Exception $e) {



          DB::rollback();

          return response()->json(['error'=>array('Could not add town!')]);



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

        $town = Town::where(['id' => $id])->first();

        return view('location.towns.show', compact('town'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $town = Town::where(['id' => $id])->first();

        $districts = District::where(['deleted' => '0', 'active' => '1'])

                        ->whereNotIn('id', [$town->district_id])->orderBy('name', 'ASC')->get();



        return view('location.towns.edit', compact('town','districts'));

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

            'name' => 'required|max:28|regex:/^[\pL\s\-]+$/u',

        ]);



        if ($validator->fails()) {

            return response()->json(['error'=>$validator->errors()->all()]);

        }



                DB::beginTransaction();



        try {



            Town::where(['id' => $id])->update(

                [

                    'name' => $request->name,

                    'district_id' => $request->district_id,

                    'active' => $request->active,

                    'updated_at' => date('Y-m-d H:i:s'),

                    'updatedbyuserid' => Auth::user()->id,

                ]

            );



            DB::commit();



            return response()->json(['success'=>'Town Updated Successfully!']);

        

        } catch (\Exception $e) {



          DB::rollback();

          return response()->json(['error'=>array('Could not update town!')]);



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

        return view('location.towns.import');

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

        

        $validation = new Townimport();



        $checkData = $validation->checkImportData($rows);



        if(count($checkData) > 0){



            $report_error = [];



            foreach ($checkData as $key => $value) {
	
		$report_error[$key]['RowNumber'] = $value['RowNumber'];

                $report_error[$key]['code'] = $value['0'];

                $report_error[$key]['name'] = $value['1'];

                $report_error[$key]['message'] = $value['message'];

            }

            

            Session::flash('error', 'File could not be uploaded. Please check for errors.');

            return view('location.towns.import', compact('report_error'));

        }



        DB::beginTransaction();



        try {



            foreach ($rows as $row) {



                $dist_id = District::where(['code' => $row[0]])->first();

                

                $id = DB::table('towns')->insertGetId(

                    [

                        'code' => time(),
                        'name' => $row[1],
                        'district_id' => $dist_id->id,
                        'name' => $row[0],
                        'district_id' => $dist_id->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'createdbyuserid' => Auth::user()->id,
                        'updatedbyuserid' => Auth::user()->id,

                    ]

                );

                

                $code = 'TWN'.sprintf('%06d', $id);



                Town::where(['id' => $id])->update(

                  [

                    'code' => $code,

                  ]

                );



                DB::commit();

                

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

