<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Ftpauthentication;
use Auth;
use Validator;
use Session;
use Illuminate\Support\Facades\DB;

class FtpController extends Controller
{

    public function setup($file_path, $file_name){

        $ftp = Ftpauthentication::first();

        $ftp_server = "117.58.241.164";
        $ftp_user = "MRC";
        $ftp_password = "SQ$59%2pQ";
        $file = "";
        $remote_file = "";


        $ftp_connection = ftp_connect($ftp_server) or die("Could not connect to the FTP server");

        $login = ftp_login($ftp_connection, $ftp_user, $ftp_password);

        //turn passive mode on
        ftp_pasv($ftp_connection , true);

        if(ftp_put($ftp_connection, $file_name, $file_path, FTP_BINARY)){
            echo "File uploaded";
        } else {
            echo "Failed";
        }

        ftp_close($ftp_connection);

    }

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
        $ftp = Ftpauthentication::first();

        if (!empty($ftp->server)) {
            return redirect()->route('ftp.edit', $ftp->id);
        } else {
            return view('ftp.create');
        }
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
            'server_name' => 'required|max:128',
            'username' => 'required|max:128',
            'password' => 'required',
            'port_number' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        try {

            DB::table('ftpauthentications')->insert(
                [
                    'server' => $request->server_name,
                    'username' => $request->username,
                    'password' => $request->password,
                    'port' => $request->port_number,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'createdbyuserid' => Auth::user()->id,
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            Session::flash('success', 'FTP updated!'); 
            return redirect()->back();
        
        } catch (\Exception $e) {

          DB::rollback();
          Session::flash('error', 'FTP update failed'); 
          return redirect()->back();

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
        $ftp = Ftpauthentication::where(['deleted' => '0', 'active' => '1', 'id' => $id])->first();
        return view('ftp.edit', compact('ftp'));
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
            'server' => 'required|max:128',
            'username' => 'required|max:128',
            'password' => 'required',
            'port' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        try {

            DB::table('ftpauthentications')->where(['id' => $id])->update(
                [
                    'server' => $request->server_name,
                    'username' => $request->username,
                    'password' => $request->password,
                    'port' => $request->port_number,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            Session::flash('success', 'FTP updated!'); 
            return redirect()->back();
        
        } catch (\Exception $e) {

          DB::rollback();
          return $e->getMessage();
          Session::flash('error', 'FTP update failed'); 
          return redirect()->back();

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


    public function ftplog_db(){

    }

    public function test(){
        $dir = "storage/reports/";
        $file_name = date('Y-m-d').".txt";

        $file_path = $dir.$file_name;
        return $this->setup($file_path, $file_name);
    }
}
