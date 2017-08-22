<?php

require "php/PHPMailer-master/PHPMailerAutoload.php";

$REQUEST = $_POST;

$mailObj = new Mailer();

$mailObj->sendMail($REQUEST);

class Mailer {

    private $post_request = null;
    private $PHPMailer;

    private function returnReposne($status, $message) {
        echo json_encode(array('status' => $status, 'message' => $message));
    }

    private function validateInput() {
        $result = true;
        //check request type
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $result = false;
            $this->returnReposne(
                    500, "Request type not valid"
            );
        }

        //request is available
        if (!isset($this->post_request['q'])) {
            $result = false;
            $this->returnReposne(
                    501, "Request not set"
            );
        }

        return $result;
    }

    public function sendMail($data) {

        $this->post_request = $data;

        if (!$this->validateInput()) {
            return;
        }
        //get html contents for mail
        $body = file_get_contents('contents.html');

        $mappers = array(
            "##name##" => "Nkosinathi Khumalo",
            "##drname##" => "Mathebula",
            "##bookedtime##" => "16:00 12/12/2017"
        );

        $body = $this->doStrReplacement($body, $mappers);

        //file_put_contents("contents2.html", $body);

        $this->PHPMailer = new PHPMailer();

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->IsHTML(true);
        $mail->Host = "mail.web-demos.co.za";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "Nkosinathi.Khumalo@web-demos.co.za";
        $mail->Password = "Bhung@ne002";

//Set who the message is to be sent from
        $mail->setFrom('Nkosinathi.Khumalo@web-demos.co.za', 'Nkosinathi Khumalo');
//Set an alternative reply-to address
        $mail->addReplyTo('Nkosinathi.Khumalo@web-demos.co.za', 'Nkosinathi Khumalo');
//Set who the message is to be sent to
        $mail->addAddress('Nkosinathi.K@outlook.com', 'Nkosinathi Khumalo');
//Set the subject line
        $mail->Subject = 'Dr Mathebula - Booking';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        
        //$mail->Body = $body;
        //$mail->msgHTML($body);
        $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
        //$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
        //  $mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . dirname(__FILE__) . " " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    private function doStrReplacement($body, $mappers) {

        foreach ($mappers as $element) {

            $key = (string) key($mappers);

            $body = str_replace($key, $mappers[$key], $body);

            next($mappers);
        }

        return $body;
    }

}
