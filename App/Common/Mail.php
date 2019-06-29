<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
  require(PLUGIN . "PHPMailer/src/PHPMailer.php");
  require(PLUGIN . "PHPMailer/src/SMTP.php");  
  require(PLUGIN . "PHPMailer/src/Exception.php");
  require(PLUGIN . "PHPMailer/src/POP3.php");
// Load Composer's autoloader
require GPATH . '/vendor/autoload.php';

class _Mail extends _Base{
	function __construct(){

	}

	static function support(){
		$support_mail = "raptortradingnj@gmail.com";
		$from = _G("email");
		$message = _P("message");
		$subject = _P("subject");
		if(!_P("email")){exit("wrong address");}
		if(!_P("subject")){exit("empty subject");}
		if(!_P("message")){exit("empty message");}
		self::send($support_mail, $from, $subject, $message, $headers = null);

	}

	static function send($to = null, $from = null, $subject = null, $message = null, $headers = null){
				// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer\PHPMailer\PHPMailer();

		try {
			$mail->IsSMTP(); // enable SMTP
		    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
		    $mail->SMTPAuth = true; // authentication enabled
		    //$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		    $mail->Host = "mail.tempest-freezer.com";
		    $mail->Port = 587; // or 587
		    $mail->IsHTML(true);
		    $mail->Username = "info@tempest-freezer.com";
		    $mail->Password = "auto1960";
		    $mail->SetFrom($from);
		    $mail->Subject = $subject;
		    $mail->Body = $message;
		    $mail->AddAddress($to);

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
		     if(!$mail->Send()) {
		     	return true;
		        //echo "Mailer Error: " . $mail->ErrorInfo;
		     } else {
		        //echo "Message has been sent";
		     	return false;
		     }
		} catch (Exception $e) {
		    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				return false;
		}

	}
}

