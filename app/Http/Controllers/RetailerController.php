<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use App\Retailer;
use App\Town;
use Session;

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
        $towns = Town::where(['deleted' => '0'])->orderBy('name', 'ASC')->get();
        return view('retailers.index', compact('retailers', 'towns'));
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
            'code' => 'required|max:64|unique',
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

            Retailer::create(
                [
                    'shopname' => $request->shopname,
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
        $towns = Town::where(['deleted' => '0', 'active' => '1'])
                ->whereNotIn('id', [$ret->town_id])->orderBy('name', 'ASC')->get();

        return view('retailers.edit', compact('towns','ret'));
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

            Retailer::where(['id' => $id])->update(
                [
                    'shopname' => $request->shopname,
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

        if (count($retailer) > 0) {
            return [
                'retailer_id' => $retailer->id,
                'shopname' => $retailer->shopname,
                'rmn' => $retailer->rmn,
                'hq' => $retailer->hq,
                'dsh' => $retailer->dsh,
                'rh' => $retailer->rh,
                'scheme' => $retailer->scheme,
                'district' => $retailer->Town->District->name,
                'town' => $retailer->Town->name
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
}
