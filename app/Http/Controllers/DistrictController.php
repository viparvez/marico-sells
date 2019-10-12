<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
Use App\District;
use Session;
use App\Services\District\Districtimport;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $districts = District::where(['deleted' => '0'])->orderBy('name', 'ASC')->get();
        return view('location.districts.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'name' => 'required|max:28|regex:/^[\pL\s\-]+$/u|unique:districts,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            $id = DB::table('districts')->insertGetId(
                [
                    'code' => time(),
                    'name' => $request->name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'createdbyuserid' => Auth::user()->id,
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );
            
            $code = 'DIS'.sprintf('%06d', $id);

            District::where(['id' => $id])->update(
              [
                'code' => $code,
              ]
            );

            DB::commit();

            return response()->json(['success'=>'District Created Successfully!']);
   
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['error'=>array('Could not add district!')]);

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
        $district = District::where(['id' => $id])->first();
        return view('location.districts.show', compact('district'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $district = District::where(['id' => $id])->first();
        return view('location.districts.edit', compact('district'));
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
            'name' => 'required|max:28|regex:/^[\pL\s\-]+$/u|unique:districts,name,'.$id,
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

            DB::beginTransaction();

        try {

            District::where(['id' => $id])->update(
                [
                    'name' => $request->name,
                    'active' => $request->active,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            return response()->json(['success'=>'District Updated Successfully!']);
   
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['error'=>array('Could not update district!')]);

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
        return view('location.districts.import');
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
        
        $validation = new Districtimport();

        $checkData = $validation->checkImportData($rows);

        if(count($checkData) > 0){

            $report_error = [];

            foreach ($checkData as $key => $value) {
                $report_error[$key]['name'] = $value['0'];
            }
            
            Session::flash('error', 'File could not be uploaded. Please check for errors.');
            return view('districts.import', compact('report_error'));
        }

        DB::beginTransaction();

        try {

            foreach ($rows as $row) {
                
                $id = DB::table('districts')->insertGetId(
                    [
                        'code' => time(),
                        'name' => $row[0],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'createdbyuserid' => Auth::user()->id,
                        'updatedbyuserid' => Auth::user()->id,
                    ]
                );
                
                $code = 'DIS'.sprintf('%06d', $id);

                District::where(['id' => $id])->update(
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
