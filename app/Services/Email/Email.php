<?php

namespace App\Services\Email;
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

/**
 * 
 */
class Email
{

    protected $username; 
    protected $password;
    protected $host;
    protected $setfrom;
    protected $subject;
    protected $body;
    
    public function send($address, $cc = null, $attachment = null){
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $this->host;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $this->username;                     // SMTP username
            $mail->Password   = $this->password;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );                               // TCP port to connect to

            //Credentials
            $mail->setFrom($this->username, $this->from);

            //Recepients

            if(!is_array($address)) {
                return 'Hello';
            } else{
                foreach ($address as $key => $value) {
                    $mail->addAddress($value);
                }
            }

            if($cc == null) {

            } else {
                foreach ($cc as $key => $value) {
                    $mail->addCc($value);
                }
            }

            //Attachments
            

            if ($attachment !== null) {
                if(!is_array($attachment)) {
                    return 'Hello';
                } else {
                    foreach ($attachment as $key => $value) {
                        $mail->addAttachment($value);
                    }
                } 
            }


            $mail->addReplyTo($this->username, $this->from);      

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

        } catch (Exception $e) {
            dd($e);
        }
    }

    public function setCredentials($username, $password){
        
        if (!empty($username)) {
            $this->username = $username;
        } else {
            return false;
        }

        if (!empty($password)) {
            $this->password = $password;
        } else {
            return false;
        }

    }


    public function setFrom($from) {
        if (!empty($from)) {
            $this->from = $from;
        } else {
            return false;
        }
    }


    public function setHost($host) {
        if (!empty($host)) {
            $this->host = $host;
        } else {
            return false;
        }
    }


    public function setSubject($subject) {
        if (!empty($subject)) {
            $this->subject = $subject;
        } else {
            return false;
        }
    }


    public function setBody($body) {
        if (!empty($body)) {
            $this->body = $body;
        } else {
            return false;
        }
    }


}
