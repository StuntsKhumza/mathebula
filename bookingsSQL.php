<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bookingsSQL
 *
 * @author Nkosinathi.Khumalo
 */
class bookingsSQL {

    //put your code here
    private $sqlConnection;

    function __construct() {

        $servername = "localhost";

        $username = "root";

        $password = "";

        $dbname = "drs";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        //set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->sqlConnection = $conn;
    }

    public function makeBooking($data) {
        
        $query = "INSERT INTO `bookings` VALUES (?,?,?,?,?,?,?,?,?)";
        
        $id = mt_rand(1101102, 1249647);
        $new_time = date('G:i', strtotime($data['bookedTime']));
        $new_date = date('Y-m-d', strtotime(str_replace('/','-',$data['bookedDate'])));
       
        $stmt = $this->sqlConnection->prepare($query);
        $status = "NEW";
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $data['drid'], PDO::PARAM_INT);
        $stmt->bindParam(3, $new_date, PDO::PARAM_STR);
        $stmt->bindParam(4, $data['name'], PDO::PARAM_INT);
        $stmt->bindParam(5, $data['surname'], PDO::PARAM_STR);
        $stmt->bindParam(6, $data['idnumber'], PDO::PARAM_INT);
        $stmt->bindParam(7, $new_time, PDO::PARAM_STR);
        $stmt->bindParam(8, $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(9, $status, PDO::PARAM_STR);

        $stmt->execute();

        if (!$stmt) {
            return json_encode(array('status'=>501, 'message'=> $stmt->errorInfo()));
        } else {
            return json_encode(array("status" => 200, "message" => "Booking made sccessfully"));
        }
    }
    
    public function getBookings() {

    //get all bookings from today going forward
    //$query = "SELECT * FROM BOOKINGS WHERE (`DATE` >= CURDATE() AND `DRID` = 648646) ";
    //$query = "SELECT * FROM BOOKINGS WHERE (STR_TO_DATE(`Date`,'%Y-%m-%d') BETWEEN '2013-05-01' AND '2013-05-03' AND `DRID` = 648646 AND TIME = ?) ";
    $query = "SELECT * FROM `bookings` ORDER BY `DATE`, `TIME`";
    $stmt = $this->sqlConnection->prepare($query);

    /* $stmt->bindParam(1, $data['date'], PDO::PARAM_STR);
      $stmt->bindParam(2, $data['time'], PDO::PARAM_STR); */

    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        return json_encode($result);
       
    } else {
        
        echo json_encode(array("status" => 201, 'message' => 'No bookings made yet..'));
    }
}

public function actionBooking($data){
        
        $query = "UPDATE `bookings` SET `STATUS`=? WHERE `ID` = ?";
        
        $stmt = $this->sqlConnection->prepare($query);

        $stmt->bindParam(1, $data['actionToTake'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['id'], PDO::PARAM_INT);

        $stmt->execute();

        if (!$stmt) {
            return json_encode(array("status"=>500, "message"=>$stmt->errorInfo()));
        } else {
            return json_encode(array("status" => 200, "message" => "Booking " .$data['actionToTake']. " sccessfully"));
        }
}

}
