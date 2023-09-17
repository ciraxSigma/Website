<?php

    namespace App\Controllers;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class EmailController {

        public function index($props) {

            $props = validate($props, [
                "text" => "notEmpty",
                "email" => "notEmpty"
            ]);

            $mail = new PHPMailer(true);

            $text = $props["text"];

            $userEmail = $props["email"];

    
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.lazarciric.com ';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'no-reply@lazarciric.com';                     //SMTP username
                $mail->Password   = 'Noreply12345.,';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('no-reply@lazarciric.com', 'bot');
                $mail->addAddress("skypename13@gmail.com");     //Add a recipient               //Name is optional
               
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = "From: $userEmail </br> Text: $text";
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                $mail->send();
                $data = ['message' => "Message has been sent"];
            } catch (Exception $e) {
                $data = ["message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
            }

            view("home-page", $data);

        }

    }
    
?>