<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use App\User;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where(['deleted' => '0'])->whereNotIn('id',['1'])->orderBy('name', 'DESC')->get();
        return view('users.index', compact('users'));
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
            'name' => 'required|max:191|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|max:191',
            'username' => 'required|max:20',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required',
            'role' => 'required',
            'active' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

                DB::beginTransaction();

        try {

            $id = DB::table('users')->insertGetId(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'gender' => $request->gender,
                    'role' => $request->role,
                    'active' => $request->active,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'createdbyuserid' => Auth::user()->id,
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            return response()->json(['success'=>'User Created Successfully!']);
        
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['error'=>array('Could not add user!')]);

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
        $user = User::where(['id' => $id])->first();
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where(['id' => $id, 'deleted' => '0'])->first();
        return view('users.edit', compact('user'));
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
            'name' => 'required|max:191|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|max:191|email|unique:users,email,'.$id,
            'username' => 'required|max:20|unique:users,username,'.$id,
            'gender' => 'required',
            'role' => 'required',
            'active' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

                DB::beginTransaction();

        try {

            User::where(['id' => $id])->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'gender' => $request->gender,
                    'role' => $request->role,
                    'active' => $request->active,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            return response()->json(['success'=>'User Updated Successfully!']);
        
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['error'=>array('Could not update user!')]);

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


    public function getChangePass($id) {
        $user = User::where(['id' => $id, 'deleted' => '0'])->first();
        return view('users.changepass', compact('user'));
    }


    public function changepass(Request $request, $userid){
        
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        DB::beginTransaction();

        try {

            DB::table('users')->where(['id' => $userid])->update(
                [
                    'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            return response()->json(['success'=>'Password Changed!']);
        
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['error'=>array('Could not change password!')]);

        }
    }

    public function getMyChangePass(){
        return view('users.mypasschange');
    }

    public function mychangepass(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }

        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->old_password, $user->password)){
            return response()->json(['error'=>array('Old password does not match')]);
        }

        DB::beginTransaction();

        try {

            DB::table('users')->where(['id' => Auth::user()->id])->update(
                [
                    'password' => Hash::make($request->password),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            return response()->json(['success'=>'Password Changed!']);
        
        } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['error'=>array('Could not change password!')]);

        }
    }
}
