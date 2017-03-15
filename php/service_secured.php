<?php

session_start(); 
sleep(10);
require 'sql.php'; 

$query = "";

$sql = new sqlClass(); 

$dspErrors = true; 

$query = $_POST['q'];

switch ($query) {

    case "test":
        $i = 0;

        while($i < 100000){
            $i++;
        }

        echo $i;
    break;

    case "authenticate":
        
        echo $sql -> authenticate($_POST); 
        
        break; 
    
    case "authenticate_checkUser":
        
        echo $sql -> authenticate_checkUser($_POST); 
        
        break; 
    
    case "getActiveProfile":
        
        echo $sql -> getProfile(); 
        
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

        case "searchProfile":
            echo $sql->searchProfile($_POST);
        break;
    
}




/*
 * INSERT INTO `users` VALUES (1231354, 'Nkosinathi', 'Khumalo', 26, 9003235383085);

INSERT INTO `logins` VALUES (16545, 9003235383085, 'nkosi', '123abc');
 * 
 * SELECT `PASSWORD` FROM `logins` WHERE `USERNAME` = 'NKOSI'
 */