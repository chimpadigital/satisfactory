<?php
header('Access-Control-Allow-Origin: *');
// check if fields passed are empty
date_default_timezone_set('America/Argentina/Buenos_Aires');

require 'include/php-mailer/PHPMailerAutoload.php';

		if(empty($_REQUEST['name'])  ||
				empty($_REQUEST['message']) ||
				empty($_REQUEST['email']) ||
				!filter_var($_REQUEST['email'],FILTER_VALIDATE_EMAIL))
		{
			echo "No arguments Provided!";
			return false;
		}
		
		$name = $_REQUEST['name'];
		$email_address = $_REQUEST['email'];
		$phone = $_REQUEST['phone'];
		$mensaje = $_REQUEST['message'];
		
		//inicio script grabar datos en csv
		$fichero = 'formularios.csv';//nombre archivo ya creado
		//crear linea de datos separado por coma
		$fecha=date("Y-m-d H:i:s");
		$linea = $fecha.",".$name.",".$email_address.",".$phone.",".$mensaje."\n";
		// Escribir la linea en el fichero
		file_put_contents($fichero, $linea, FILE_APPEND | LOCK_EX);
		//fin grabar datos
		
		
		// create email body and send it
		
		$to = 'contacto@chimpancedigital.com.ar'; // put your email cfaerman@freiberg.com.ar
		//$to='aolamas@gmail.com';
		$email_subject = "Campaña, portfolio web ";
		$email_body = "<h4>Consulta campaña portfolio web. </h4><hr>".		
				"<p>Nombre: $name </p>".
				"<p>Email: $email_address</p>".
				"<p>Teléfono: $phone</p>".
				"<p>Consulta: $mensaje</p>";
		
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = "html";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;
		$mail->CharSet="UTF-8";
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		//$mail->SMTPOptions = array (
		//    'ssl' => array (
		//        'verify_peer' => false,
		//        'verify_peer_name' => false,
		//        'allow_self_signed' => true
		//    )
		//);
		$mail->Username = "sprados@chimpancedigital.com.ar";
		$mail->Password = "Chimpance951#$";
		$mail->setFrom('contacto@chimpancedigital.com.ar', 'chimpancedigital.com.ar');
		$mail->addReplyTo('contacto@chimpancedigital.com.ar', 'chimpancedigital.com.ar');
		// $mail->AddCC('freiberg@chimpancedigital.com.ar', 'chimpancedigital');
		// $mail->AddCC('web@freiberg.com.ar', 'freiberg');
		$mail->addAddress($to, $to);
		$mail->Subject = $email_subject;
		$mail->msgHTML($email_body);
		$mail->AltBody = $email_body;
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}else{
			header("Location: /desarrolloweb/gracias.html");exit;
		}
		return true;
}