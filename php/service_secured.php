<?php

session_start(); 
sleep(0);
require 'sql.php'; 

$query = "";

$sql = new sqlClass(); 

$dspErrors = true; 

if(isset($_POST['q'])){

    $query = $_POST['q'];
    
} else {
    
    die(json_encode(array(
        'status'=>500,
       'message'=>"Request type not defined",
        'date'=>$_POST
    )));
    
}

switch ($query) {

    case "getMyQueue":
        
        echo $sql -> getMyQueue($_POST); 
        
        break;

    case "loadWaitingList":
    
        echo $sql -> loadWaitingList($_POST); 

        break;
    
     case "getUsersByType":
        
        echo $sql -> getUsersByType($_POST); 
        
        break;
    
    case "addToQueue":
        echo $sql -> addToQueue($_POST); 
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
