<?php

session_start(); 
sleep(0);
require 'sql.php'; 
header('Content-Type: application/json');
$sql = new sqlClass(); 

$data = json_decode(file_get_contents('php://input'), true);

if(isset($data['q'])){
    
        $query = $data['q'];
        
    } else {
        
        die(json_encode(array(
            'status'=>500,
           'message'=>"Request type not defined",
            'data'=>$data
        )));
        
   }

   $q = $data['q'];

switch ($q){

    case "addFamilyMember":
    
        $response = $sql->addFamilyMember($data);

        echo $response;

    break;

    case "getFamilyMember":
    
        $response = $sql->getFamilyMember($data);

        echo $response;
    
    case "loadWaitingList":
        
            $response = $sql->loadWaitingList($data);
    
            echo $response;

    break;

    default:

        die(json_encode(array('status'=>'error', 'message'=>'error processing request')));

    break;

}

