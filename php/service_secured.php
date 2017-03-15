<?php

session_start(); 
sleep(1);
require 'sql.php'; 

$query = "";

$sql = new sqlClass(); 

$dspErrors = true; 

$query = $_POST['q'];

switch ($query) {

    case "test":
       
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
