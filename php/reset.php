<?php

session_start();

require __DIR__ . '\sql.php';
require __DIR__ . '\PHPMailer-master\PHPMailerAutoload.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$mailObj = new PHPMailer;
$sql = new sqlClass;

function reset_password($data) {

    $reset_p = "";
    $path = "login";
    $id = 'id';
    
    if ($data['q'] === 'reset_pass') {
        
        $resetpass = get_user($data[$id]);
        
        //print_r($_REQUEST);
        //return;
        if (isset($resetpass)){
            
            if ($resetpass['status'] == 200){
                
                  $reset_p = "New password: " . $resetpass['data'] . " - please login <a href='" .$path. "' class='btn btn-md btn-success'>here</a>";
                
           /* } else {
                
                $reset_p = "No user with that name exists, please <a href='#' class='btn btn-md btn-default'>sign-up</a>"; */
                
            }
            
        }
        
       
    }

    return $reset_p;
}

function get_user($id) {
    
    global $sql;
       
    $idSearch = $sql->reset_user_password($id);
    
    return $idSearch;
        
}

function sendMailToUser() {

    global $mailObj;

    $mail = $mailObj;

    $mail = new PHPMailer;

    $mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->Debugoutput = 'html';
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp-mail.outlook.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'Nkosinathi.k@outlook.com';                 // SMTP username
    $mail->Password = 'lklkjll';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('Nkosinathi.k@outlook.com', 'Mailer');
    $mail->addAddress('Nkosinathi.Khumalo@investec.co.za', 'Joe User'); // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Here is the subject';
//    $mail->Body = 'This is the HTML message body <b>in bold!</b>';
    $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
}
