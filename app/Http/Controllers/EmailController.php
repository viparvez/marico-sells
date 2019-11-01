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

class EmailController extends Controller
{
	public function sendmail(array $address, $body, array $cc = null, $subject){

		$email = Emailauthentication::first();

		if(!is_array($address)) {
			return false;
		}


		$mail= new PHPMailer\PHPMailer();

		$mail->SMTPDebug = 2;                              // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $email->outgoing_server;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $email->email;                 // SMTP username
		$mail->Password = $email->password;                       // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;
		$mail->setFrom($email->email, $email->alias);
		$mail->addReplyTo($email->email, $email->alias);
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $body;

		foreach ($address as $key => $value) {
			$mail->addAddress($value);
		}

		if(!is_array($address)) {
			return false;
		} elseif($cc == null) {
			
		} else {
			foreach ($cc as $key => $value) {
				$mail->addCc($value);
			}
		}
		

		if(!$mail->send()) {
		    return response()->json(['success'=>array('Email sent')]);
		} else {
		    return response()->json(['error'=>array('Could not send email')]);
		}   

	}


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
		$this->sendmail(['viparvez@gmail.com'], 'Testing My Dear', null, 'Sending Root');
	}
    
}
