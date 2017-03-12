<?php
session_start();

include __DIR__ . "/php/sql.php";

$target_dir =  __DIR__ . "/img/userProfilePictures";
$target_file = $target_dir . basename($_FILES["uploadprofile"]["name"]) ;
$uploadOk = 1;

$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
print_r($_FILES);
print $_SERVER['DOCUMENT_ROOT']. $target_file;
//die('');
// Check if image file is a actual image or fake image
if (move_uploaded_file($_FILES["uploadprofile"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["uploadprofile"]["name"]). " has been uploaded.";
    
     $newcall = new SQLClass();
    
    $result = $newcall->updateUserProfilePicture($_SESSION['userID'], $target_file);
 
   $x = $_SERVER['DOCUMENT_ROOT'] . "/Userprofile";
    echo $x;
    //header('Location: ' . $x);
    } else {
        echo "Sorry, there was an error uploading your file.";
    $x = __DIR__ . "/Userprofile";
       // header('Location: ' . $x);
    }

?>
