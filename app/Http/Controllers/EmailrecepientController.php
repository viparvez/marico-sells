<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use App\Emailtemplate;
use App\Emailrecepient;
use Session;

class EmailrecepientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recs = Emailrecepient::where(['deleted' => '0'])->orderBy('address', 'ASC')->get();
        $templates = Emailtemplate::where(['deleted' => '0'])->first();
        return view('email_recepients.index', compact('recs', 'templates'));
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
            'address' => 'required|email',
            'rectype' => 'required',
            'template_id' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            Emailrecepient::create(
                [
                    'address' => $request->address,
                    'rectype' => $request->rectype,
                    'template_id' => $request->template_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'createdbyuserid' => Auth::user()->id,
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );
            

            DB::commit();

            return response()->json(['success'=>'Recepient Added Successfully!']);
   
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['error'=>array('Could not add recepient!')]);

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
        return view('email_recepients.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        Emailrecepient::where(['id' => $id])->update(
            [
                'deleted' => '1',
                'updated_at' => date('Y-m-d H:i:s'),
                'updatedbyuserid' => Auth::user()->id,
            ]
        );

        return response()->json(['success'=>'Recepient Deleted!']);
    }
}
