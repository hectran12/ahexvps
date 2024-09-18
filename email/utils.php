<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


function sendEmail ($to, $subject, $content) {
    global $smtpHost, $smtpPort, $smtpUser, $smtpPass, $smtpSecure, $site_name;
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    // proxy 
    
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $smtpHost;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $smtpUser;                     //SMTP username
        $mail->Password   = $smtpPass;                               //SMTP password
        $mail->SMTPSecure = $smtpSecure;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = $smtpPort;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom($smtpUser, $site_name);
        $mail->addAddress($to);     //Add a recipient

        //Content
        $mail->isHTML(true);  
                                        //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        // set utf-8
        $mail->CharSet = 'UTF-8';
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}