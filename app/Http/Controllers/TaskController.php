<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Emailrecepient;
use App\Http\Controllers\EmailController;

class TaskController extends Controller
{
    public function runeod() {
    	$primary = Emailrecepient::where(['active' => '1', 'deleted' => '0', 'rectype' => 'PRIMARY'])->pluck('address')->toArray();

    	$cc = Emailrecepient::where(['active' => '1', 'deleted' => '0', 'rectype' => 'CC'])->pluck('address')->toArray();

    	$body = view('task.runeod');

    	(new EmailController)->sendmail($primary, $body, $cc, 'Sending Test Email');
    }
}
