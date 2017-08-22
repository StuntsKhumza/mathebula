<?php

$data = json_decode(file_get_contents('php://input'), true);

require "php/PHPMailer-master/PHPMailerAutoload.php";
require "bookingsSQL.php";

$mailObj = new Mailer();
if(!$mailObj->validateInput($data)){
  die('');  
}
switch($data['q'])
{
    case "getBookings":
        echo $mailObj->getBookings();
        break;
    case "makeBooking":
        $mailObj->makeBooking($data);
        break;
    case "actionBooking":
        $mailObj->actionBooking($data);
        break;
}

class Mailer {

    private $post_request = null;
    private $PHPMailer;
    private $bookingsSQL;

   function __construct(){
       $this->PHPMailer = new PHPMailer();
       $this->bookingsSQL = new bookingsSQL();
   }
    
    private function returnReposne($status, $message) {
        echo json_encode(array('status' => $status, 'message' => $message));
    }

    public function validateInput($request) {
        $result = true;
        //check request type
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $result = false;
            $this->returnReposne(
                    500, "Request type not valid"
            );
        }

        //request is available
        if (!isset($request['q'])) {
            $result = false;
            $this->returnReposne(
                    501, "Request not set"
            );
        }

        return $result;
    }
    
    public function getBookings(){
         return $this->bookingsSQL->getBookings();
    }
    
 
    public function actionBooking($data){
       
       //update row in sql
        $response = json_decode($this->bookingsSQL->actionBooking($data), true);
        
        //compose mail
        if($response['status'] == 200){
           
            $fieldMappers = array(
                '__name__'=>$data['object']['FIRSTNAME'],
                '__status__'=>$data['actionToTake'],
                '__bookedtime__'=>$data['object']['TIME'] . " " . $data['object']['DATE']
            );
             $body = "";
            if($data['actionToTake'] === 'ACCEPTED'){
                $body = file_get_contents('bookingApproved.html');
            }
            else if ($data['actionToTake'] === 'DECLINED'){
                $body = file_get_contents('bookingDeclined.html');
            } else {
                $this->returnReposne(502, "Unable to determine template");
            }
            
             $body = $this->doStrReplacement($body, $fieldMappers);
              file_put_contents("contents2.html", $body);

            //$this->sendMail("bookingApproved.html", $fieldMappers); 
            if($this->composeMail($body, "Dr's Appointment", null)){
                 $this->returnReposne(200, "Notification sent");
            } else {
                $this->returnReposne(500, "Internal server error when composing notification");
            }
           
            
        }
    }

private function composeMail($body, $subject, $addresses){

return true;

$this->PHPMailer->Subject = $subject;
//Set who the message is to be sent to

       

$this->PHPMailer->IsHTML(true);
        $this->PHPMailer->MsgHTML($body, dirname(__FILE__));

           if (!$this->PHPMailer->send()) {
           echo "Mailer Error: " . dirname(__FILE__) . " " . $this->PHPMailer->ErrorInfo;
        } else {
            echo "Message sent!";
        }
}

   public function makeBooking($data){
          $this->post_request = $data;

           //  if (!$this->validateInput()) {
        //     return;
        // }
        //get html contents for mail
        $body = file_get_contents('bookingRequest.html');

        $mappers = $this->post_request; 

        $body = $this->doStrReplacement($body, $mappers);

        file_put_contents("contents2.html", $body);

        $response = json_decode($this->bookingsSQL->makeBooking($data));

        if($response->status == 200){
            echo json_encode($response);
        } else
        {
            echo json_encode($response);
        }
    
    }

    public function sendMail($template,$data) {

        $this->post_request = $data;

        //  if (!$this->validateInput()) {
        //     return;
        // }
        //get html contents for mail
        $body = file_get_contents('contents.html');

        $mappers = $this->post_request; 

        $body = $this->doStrReplacement($body, $mappers);

        file_put_contents("contents2.html", $body);
        
        //$this->returnReposne(200, "booking placed successfully");
        
        echo $this->bookingsSQL->makeBooking($data);
        return;
        $mail = new PHPMailer;
        $mail->IsSMTP();

        $mail->Host = "mail.web-demos.co.za";
        $mail->Port = 25;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "Nkosinathi.Khumalo@web-demos.co.za";
        $mail->Password = "Bhung@ne002";
        $mail->setFrom('Nkosinathi.Khumalo@web-demos.co.za', 'Nkosinathi Khumalo');
        $mail->addReplyTo('Nkosinathi.Khumalo@web-demos.co.za', 'Nkosinathi Khumalo');
        $mail->Subject = 'Dr Mathebula - Booking';
//Set who the message is to be sent to
        $mail->addAddress($this->post_request['email'], 'Nkosinathi Khumalo');
//Set the subject line
        
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
        $mail->IsHTML(true);
        $mail->MsgHTML($body, dirname(__FILE__));
        //$mail->msgHTML(file_get_contents('contents2.html'), dirname(__FILE__));
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
