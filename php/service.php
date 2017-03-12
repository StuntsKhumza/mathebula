<?php

session_start(); 

require 'sql.php'; 
$query = "";

if (isset($_GET['q'])){
    $query = $_GET['q'];
} else {
    die('Request not specified.');
}
 

$sql = new sqlClass(); 

$dspErrors = true; 

switch ($query) {

    case "test":
$i = 0;

        while($i < 10000000){
            $i++;
        }

        echo $i;
    break;

    case "authenticate":
        
        echo $sql -> authenticate($_GET); 
        
        break; 
    
    case "authenticate_checkUser":
        
        echo $sql -> authenticate_checkUser($_GET); 
        
        break; 
    
    case "getProfile":
        
        echo $sql -> getProfile($_GET['userid']); 
        
        break; 

    case "getSession":

        $result = 'false'; 

        if (isset($_SESSION)) {

            if (isset($_SESSION['active'])) {
                    
                $result = $_SESSION['active']; 

            }
        }

echo json_encode(array('status' => $result)); 

        break; 
        case "logOn":

            $_SESSION['active'] = 'true';
            echo "Session set";
        break;
        case "logOff":

            $_SESSION['active'] = 'false';
            echo "Session set";
        break;
    
}


/*
 * INSERT INTO `users` VALUES (1231354, 'Nkosinathi', 'Khumalo', 26, 9003235383085);

INSERT INTO `logins` VALUES (16545, 9003235383085, 'nkosi', '123abc');
 * 
 * SELECT `PASSWORD` FROM `logins` WHERE `USERNAME` = 'NKOSI'
 */