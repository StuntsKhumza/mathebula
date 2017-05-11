<?php


//require __DIR__ . '/img-resize.php';
sleep(5);
$connection = 1;//connectPDO();
//check request

if ($connection != null) {

    $target_dir = "img/uploaded/";
    $target_dir_temp = "img/temp/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $target_temp_file = $target_dir_temp . basename($_FILES["file"]["name"]);
    
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);


//check file
    if (!isset($_FILES["file"]["name"])) {
        echo json_encode(array(
            'status' => '500',
            'message' => 'There was an error uploading your photo. Please ensure you '
        ));
    } else {


        // Check if image file is a actual image or fake image
  /*      if (file_exists("../".$target_file)) {
            echo json_encode(array(
                'status' => '500',
                'message' => 'Photo already exists. Please choose something else.',
                'path' => $target_file
            ));
        }
*/
        // Allow certain file formats
    
         if (strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "gif") {

            echo json_encode(array(
                'status' => '500',
                'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.',
                'path' => $target_file
            ));
        }
        else {


            //move file
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "../" . $target_temp_file)){
                //captureImage("../" . $target_temp_file);
                $path =  $target_temp_file;
                return encodeJson(array('status'=>200, 'path'=>$path));
            }
           
        }
    }


   // captureImage();
} else {

    encodeJson(array('status' => 500));
}



//echo "Found";

function encodeJson($data) {

    echo json_encode($data);
}

function connectPDO() {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lee cakes";
    $s = "";

    try {

        // Create connection
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // set the PDO error mode to exception
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {

        echo $e->getMessage();
    }

    return $con;
}

function captureImage($file) {

            $id = mt_rand(1102, 9647);

            $con = $GLOBALS['connection'];

            $con->beginTransaction();

            $result = process_sql("img/uploaded/" . $id . "_photo", $file);

            $con->commit();

            echo json_encode($result);
    
}

function process_sql($output_file,$tempFilePath) {

    $return = "";

    $file = $output_file . "_lg" . '.png';
    $file2 = $output_file . "_sm" . '.png';

    
    $con = $GLOBALS['connection'];


        //scale large image
        smart_resize_image($tempFilePath, null, 640, 640, false, "../" .$file, false, false, 100);

        //scale smaller image
        smart_resize_image($tempFilePath, null, 320, 320, false, "../" . $file2, false, false, 100);

        //add object data
        $stmt = $con->prepare('INSERT INTO `products` VALUES(?,?,?,?,?)');

        $product_id = mt_rand(1101102, 1249647);

        $stmt->bindParam(1, $product_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $_POST['title'], PDO::PARAM_STR);
        $stmt->bindParam(3, $_POST['description'], PDO::PARAM_STR);
        $stmt->bindParam(4, $_POST['price'], PDO::PARAM_INT);
        $stmt->bindParam(5, $_POST['type'], PDO::PARAM_STR);

        $stmt->execute();

        //add images  -LARGE
        $stmt = null;

        $stmt = $con->prepare('INSERT INTO `products_images` VALUES (?,?,?,?)');

        $id = mt_rand(1101102, 1249647);
        $type = "lg";
        $stmt->bindParam(1, $id, PDO::PARAM_INT); //row id
        $stmt->bindParam(2, $product_id, PDO::PARAM_INT); //PRODUCT ID
        $stmt->bindParam(3, $file, PDO::PARAM_STR); //IMG
        $stmt->bindParam(4, $type, PDO::PARAM_STR); //type

        $stmt->execute();

        //add images  -LARGE
        $stmt = null;

        $stmt = $con->prepare('INSERT INTO `products_images` VALUES (?,?,?,?)');

        $id = mt_rand(1101102, 1249647);

        $type = "sm";

        $stmt->bindParam(1, $id, PDO::PARAM_INT); //row id
        $stmt->bindParam(2, $product_id, PDO::PARAM_INT); //PRODUCT ID
        $stmt->bindParam(3, $file2, PDO::PARAM_STR); //IMG
        $stmt->bindParam(4, $type, PDO::PARAM_STR); //type

        $stmt->execute();
        unlink($tempFilePath);
        $return = array('status' => 200, 'message' => 'Product added successfully', 'path'=>$file2);


    return $return;
}

 