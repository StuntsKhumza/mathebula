<?php

require "php/PHPMailer-master/PHPMailerAutoload.php";
//Create connection
        $connection = connect();


$q = $_GET;

if (isset($_GET['q'])) {
    getBookings($connection);
} else {
    makeBookings($_GET);
}

//getBookings($connection, array("date"=>$new_date, "time"=>$new_time));

function connect() {

    $servername = "localhost";

    $username = "root";

    $password = "";

    $dbname = "drs";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    //set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}

function makeBookings($data) {
    global $connection;

    //Create a new PHPMailer instance
    
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = "";
    $mail->Port = 25;
    $mail->SMTPSecure = 'tls';
    //$mail->SMTPAuth = true;
    $mail->Username = "";
    $mail->Password = "";
    
    
//Set who the message is to be sent from
    $mail->setFrom('', 'Nkosinathi Khumalo');
//Set an alternative reply-to address
    $mail->addReplyTo('', 'Nkosinathi Khumalo');
//Set who the message is to be sent to
    $mail->addAddress('', 'Nkosinathi Khumalo');
//Set the subject line
    $mail->Subject = 'PHPMailer mail() test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
   $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';
//Attach an image file
  //  $mail->addAttachment('images/phpmailer_mini.png');
//send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }


    //SELECT * FROM `bookings` WHERE (`Date` > DATE('2017-05-19') AND DIRID = 648646)
    //SELECT * FROM `bookings` WHERE (`Date` > DATE('2017-05-19') AND DRID = 2323)

    /*
      $query = "INSERT INTO `bookings` VALUES (?,?,?,?,?,?,?)";
      $id = mt_rand(1101102, 1249647);
      $new_time = date('G:i', strtotime($data['TIME']));
      $new_date = date('Y-m-d', strtotime($data['DATE']));
      $stmt = $connection->prepare($query);

      $stmt->bindParam(1, $id, PDO::PARAM_INT);
      $stmt->bindParam(2, $data['DRID'], PDO::PARAM_INT);
      $stmt->bindParam(3, $new_date, PDO::PARAM_STR);
      $stmt->bindParam(4, $data['FIRSTNAME'], PDO::PARAM_INT);
      $stmt->bindParam(5, $data['LASTNAME'], PDO::PARAM_STR);
      $stmt->bindParam(6, $data['IDNUMBER'], PDO::PARAM_INT);
      $stmt->bindParam(7, $new_time, PDO::PARAM_STR);

      $stmt->execute();

      if (!$stmt) {
      echo $stmt->errorInfo();
      } else {
      echo json_encode(array("status" => 200, "message" => "Booking made sccessfully"));
      }
      // $stmt->execute(); */
}

function getBookings($connect) {

    //get all bookings from today going forward
    //$query = "SELECT * FROM BOOKINGS WHERE (`DATE` >= CURDATE() AND `DRID` = 648646) ";
    //$query = "SELECT * FROM BOOKINGS WHERE (STR_TO_DATE(`Date`,'%Y-%m-%d') BETWEEN '2013-05-01' AND '2013-05-03' AND `DRID` = 648646 AND TIME = ?) ";
    $query = "SELECT * FROM `bookings` ORDER BY `DATE`, `TIME`";
    $stmt = $connect->prepare($query);

    /* $stmt->bindParam(1, $data['date'], PDO::PARAM_STR);
      $stmt->bindParam(2, $data['time'], PDO::PARAM_STR); */

    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        echo json_encode($result);
        /*
          if ($result[0]['PASSWORD'] == $password) {

          $_SESSION['USERID'] = $result[0]['USERID'];
          $_SESSION['active'] = "true";

          echo json_encode(array("status" => 200, 'message' => 'success', 'data' => array('userid' => base64_encode($result[0]['USERID']))));
          } else {

          echo json_encode(array("status" => 404, 'message' => 'Incorrect username/password. Please try again'));
          } */
    } else {
        echo "No bookings today";
        // echo json_encode(array("status" => 404, 'message' => 'No users found with name: ' . $username));
    }
}

?>