<?php

session_start(); 
sleep(0);
require 'sql.php'; 
$query = "";

if (isset($_GET['q'])){
    $query = $_GET['q'];
} else {
    die('Request not specified.');
}
 sDf#@r32

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

    case "getMyQueue":
        
        echo $sql -> getMyQueue($_GET); 
        
        break; 
    
    case "authenticate_checkUser":
        
        echo $sql -> authenticate_checkUser($_GET); 
        
        break; 
    
    case "getProfile":
        
        echo $sql -> getProfile($_GET['userid']); 
        
        break; 

    case "getSession":

$i = 0;

        while($i < 10050000){
            $i++;
        }

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

            $_SESSION = array();
            
            echo "Session set";
        break;
    
    case "getUserName":
        if(isset($_SESSION['username'])){
            
            echo json_encode(array("username"=>$_SESSION['username']));
        }
        
        break;
    
}


/*
 * INSERT INTO `users` VALUES (1231354, 'Nkosinathi', 'Khumalo', 26, 9003235383085);

INSERT INTO `logins` VALUES (16545, 9003235383085, 'nkosi', '123abc');
 * 
 * SELECT `PASSWORD` FROM `logins` WHERE `USERNAME` = 'NKOSI'
 */