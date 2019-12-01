<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrderExport; 
use App\Order;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\EmailController;
use App\Emailrecepient;
use Illuminate\Support\Facades\Storage;
use App\Emailauthentication;
use PHPMailer\PHPMailer\SMTP;
use App\Services\Email\Email;

class ReportsController extends Controller
{
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export() {
        Excel::store(new OrderExport, 'reports/orders'.date('Ymd').'.xlsx');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendEod() {

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
