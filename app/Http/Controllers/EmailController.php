<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer;
use App\Emailauthentication;
use Session;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use Illuminate\Support\Facades\Redirect;
use PHPMailer\PHPMailer\SMTP;
use App\Services\Email\Email;
use App\Emailrecepient;


class EmailController extends Controller
{

	public function create(){
		$email = Emailauthentication::first();

		if ($email->count() > 0) {
			return redirect()->route('email.edit', $email->id);
		} else {
			return view('email.create');
		}
		
	}

	

	public function store(Request $request){

		$validator = Validator::make($request->all(), [
            'email' => 'required|max:128|email',
            'alias' => 'required|max:128',
            'password' => 'required',
            'outgoing_protocol' => 'required',
            'outgoing_server' => 'required',
            'outgoing_port' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        try {

            Emailauthentication::create(
                [
                    'email' => $request->email,
                    'alias' => $request->alias,
                    'outgoing_protocol' => $request->outgoing_protocol,
                    'outgoing_server' => $request->outgoing_server,
                    'outgoing_port' => $request->outgoing_port,
                    'password' => $request->password,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'createdbyuserid' => Auth::user()->id,
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            Session::flash('success', 'Email updated!'); 
            return redirect()->back();
        
        } catch (\Exception $e) {

          DB::rollback();
          Session::flash('error', 'Email update failed'); 
          return redirect()->back();

        }

	}


	public function edit($id) {
		$email = Emailauthentication::where(['deleted' => '0', 'active' => '1', 'id' => $id])->first();
		return view('email.edit', compact('email'));
	}



	public function update(Request $request, $id){

		$validator = Validator::make($request->all(), [
            'email' => 'required|max:128|email',
            'alias' => 'required|max:128',
            'password' => 'required',
            'outgoing_protocol' => 'required',
            'outgoing_server' => 'required',
            'outgoing_port' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        try {

            Emailauthentication::where(['id' => $id])->update(
                [
                    'email' => $request->email,
                    'alias' => $request->alias,
                    'outgoing_protocol' => $request->outgoing_protocol,
                    'outgoing_server' => $request->outgoing_server,
                    'outgoing_port' => $request->outgoing_port,
                    'password' => $request->password,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updatedbyuserid' => Auth::user()->id,
                ]
            );

            DB::commit();

            Session::flash('success', 'Email updated!'); 
            return redirect()->back();
        
        } catch (\Exception $e) {

          DB::rollback();
          Session::flash('error', 'Email update failed'); 
          return redirect()->back();

        }

	}

	public function test()
	{
        $email = Emailauthentication::first();

        $address = array();

        $copy = array(); 

        $file = array(
            'storage/app/reports/orders'.date('Ymd').'.xlsx',
        );


        $body = "
            <html>
                <body>
                    <h3>Hi,</h3>
                    <p>Please find the attached Telesales report for the date ".date('d/m/Y')."</p>
                </body>
            </html>
        ";


        $primary = Emailrecepient::where(['active' => '1', 'deleted' => '0', 'rectype' => 'PRIMARY'])->get();
       
        $CC = Emailrecepient::where(['active' => '1', 'deleted' => '0', 'rectype' => 'CC'])->get();

		$mail = new Email();
        
        $mail->setCredentials($email->email, $email->password);

        $mail->setFrom($email->alias);

        $mail->setHost($email->outgoing_server);

        $mail->setBody($body);

        $mail->setSubject("Telesales Report - ".date('d/m/Y'));

        if (count($primary) > 0) {
            foreach ($primary as $key => $value) {
                array_push($address, $value->address);
            }
        }

        if (count($CC) > 0) {
            foreach ($CC as $key => $value) {
                array_push($copy, $value->address);
            }
        }

        return $mail->send($address, $copy, $file);
	}
    
}
