<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/**
 * Description of sql
 *
 * @author Nkosinathi.Khumalo
 */

class sqlClass {
	
	
	private function connectPDO() {
		
		
		$connection = null;
		
		
		$servername = "localhost";
		
		$username = "root";
		
		$password = "";
		
		$dbname = "drs";
		
		
		
		
		$s = "";
		
		
		try {
			
			
			// 			Create connection
			$connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			
			
			// 			set the PDO error mode to exception
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		}
		catch (PDOException $e) {
			
			
			die($e->getMessage());
			
		}
		
		
		return $connection;
		
	}
	
	
	private function query_read($q) {
		
		
		$query = "";
		
		
		switch ($q) {
			
			
			case "authenticate":
			
			$query = "SELECT `PASSWORD`, `USERID`, `USERNAME` FROM `logins` WHERE `USERNAME` = ?";
			
			
			break;
			
			case "authenticate_getUser":
			$query = "SELECT `USERID` FROM `logins` WHERE `USERNAME` = ?";
			
			break;
			
			case "getProfile":
			
			$query = "SELECT * FROM `users` WHERE `LOGIN` = ?";
			
			
			break;
			
			
			case "searchProfile_card":
            
			$query = "SELECT * FROM `users` WHERE (CONVERT(`CARDNUMBER` USING utf8) LIKE ? " ." '%')";           
			
			break;
			
            case "searchProfile_id":
            
			$query = "SELECT * FROM `users` WHERE (CONVERT(`IDNUMBER` USING utf8) LIKE ? " ." '%')";           
			
			break;
		}
		
		
		return $query;
		
	}
	
	
	private function query_insert($q) {
		
		
		$query = "";
		
		
		switch ($q) {
			
			case "addProduct":
			$query = "INSERT INTO `products`(`ID`, `TITLE`, `DESCRIPTION`, `PRICE`, `IMG`, `CATEGORY`) VALUES (?,?,?,?,?,?)";
			
			case "addProduct_images":
			$query = "INSERT INTO `products_images`(`ID`, `IMG`, `PRODUCTID`, `TYPE`) VALUES (?,?,?,?)";
			
			break;
			
		}
		//"		SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax;
	//	check the manual that corresponds to your MySQL server version for the right syntax to use near '?????)' at line 1Array(    [0] => 42000    [1] => 1064    [2] => You have an error in your SQL syntax;
	//	check the manual that corresponds to your MySQL server version for the right syntax to use near '?????)' at line 1)null"

        return $query;
    }

    public function getProducts_app($data) {

        $connect = $this->connectPDO();
        $limit_from = 0;
        $limit_to = 5;

        //total row count
        // $count = $this->countArticles($connect, $this->query_read('getCount'));

        $query = $this->query_read('getProducts');

        $stmt = $connect->prepare($query);

        $stmt->bindParam(1, $data['category'], PDO::PARAM_STR);
        //  $stmt->bindParam(2, $limit_to, PDO::PARAM_INT);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;

        $connect = null;

        echo (json_encode(array('data' => $result)));
    }

    private function countArticles($db, $query) {

        $stmt = $db->prepare($query);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // $stmt = null;

        return $stmt->rowCount();
    }

    public function authenticate($data) {

        $connect = $this->connectPDO();

        $username = $data['username'];
        $password = $data['password'];
        //check connection
        if ($connect != null) {

            $query = $this->query_read('authenticate');

            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $data['username'], PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result[0]['PASSWORD'] == $password) {

                    $_SESSION['USERID'] = $result[0]['USERID'];
                    $_SESSION['active'] = "true";
                    
                    echo json_encode(array("status" => 200, 'message' => 'success', 'data' => array('userid'=>$result[0]['USERID'])));
                } else {

                    echo json_encode(array("status" => 404, 'message' => 'Incorrect username/password. Please try again'));
                }
            } else {

                echo json_encode(array("status" => 404, 'message' => 'No users found with name: ' . $username));
            }
        } else {

            return reportError();
        }
    }

    public function authenticate_checkUser($data) {

        $connect = $this->connectPDO();

        $username = $this->clean($data['username']);

        //check connection
        if ($connect != null) {

            $query = $this->query_read('authenticate_getUser');

            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $data['username'], PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                //USER FOUND
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return json_encode(array('status' => 200, 'message' => 'User found', 'encryptedI' => 'id', 'data' => str_replace("=", "##", $this->encryptIt($result[0]['USERID']))));
            } else {

                //user not found
                return json_encode(array('status' => 400, 'message' => 'User not found, pleaswe try again'));
            }
        }
    }

    

    public function reset_user_password($user_id) {

        try {

            $connect = $this->connectPDO();

            $userid = $this->clean($this->decryptIt(str_replace("##", "=", $user_id))); // 
           
            $id = md5(mt_rand(1101102, 1249647));

            //check connection
            if ($connect != null) {

                $query = "UPDATE `logins` SET `PASSWORD` = '" . $id . "' WHERE `USERID` =" . $userid; //$this->query_read('authenticate_getUser');

                $stmt = $connect->prepare($query);

                $stmt->execute();

                if ($stmt) {

                    return array('status' => 200, 'message' => 'Password updated successfully', 'data' => $id);
                } else {

                    return array('status' => 500, 'message' => $stmt->errorInfo()); // print_r($stmt->errorInfo());
                }
            }
        } catch (PDOException $e) {

            echo $e->getMessage();

            print_r($stmt->errorInfo());
        }
    }

    public function getProfile() {

        $connect = $this->connectPDO();
        $userID = $_SESSION['USERID'];
        //check connection
        if ($connect != null) {

            $query = $this->query_read('getProfile');

            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $userID, PDO::PARAM_INT);
     
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {

                echo json_encode(array("status" => 200, 'message' => 'success', 'data' => $result));
            };
        } else {

            return reportError();
        }
    }

    public function searchProfile($data) {

        $connect = $this->connectPDO();
        $userKey = $data['search_key'];
       
        
        //check connection
        if ($connect != null) {
            $query = "";
            
            if($data['search_type'] == 'card'){
                $query = $this->query_read('searchProfile_card');
            } else {
                $query = $this->query_read('searchProfile_id');
            }
            
            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $userKey , PDO::PARAM_STR);
            
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
    
                return json_encode(array("status" => 200, 'message' => 'success', 'data' => $result));

            } else {

                    return json_encode(array("status" => 400, 'message' => 'fail', 'data' => null));
            }
        } else {

            return reportError();
        }
    }

    private function reportError() {

        return json_encode(array('status' => 500, 'message' => 'Unable to connect to the database'));
    }

    public function getAllProducts() {

        $connect = $this->connectPDO();
        $data_girls = null;
        $data_boys = null;
        $data_adults = null;

        $query_v = $this->query_read('getAllProducts');
        $query = $query_v;

        $stmt = $connect->prepare($query);
        $cat = "Girls";
        $stmt->bindParam(1, $cat, PDO::PARAM_STR);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $data_girls = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* boys */
        $query = $query_v;

        $stmt = $connect->prepare($query);
        $cat = "Boys";
        $stmt->bindParam(1, $cat, PDO::PARAM_STR);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $data_boys = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /* adults */
        $query = $query_v;

        $stmt = $connect->prepare($query);
        $cat = "Adults";
        $stmt->bindParam(1, $cat, PDO::PARAM_STR);

        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $data_adults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = null;

        $connect = null;

        echo (json_encode(array('status' => 200, 'data' => array('girls' => $data_girls, 'boys' => $data_boys, 'adults' => $data_adults))));
    }

    public function addProduct($file, $data) {

        try {

            $connect = $this->connectPDO();

            $query = $this->query_insert('addProduct');

            $stmt = $connect->prepare($query);

            //get generate userid
            $id = mt_rand(1101102, 1249647);
            // die(json_encode($data));
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['price'], PDO::PARAM_INT);
            $stmt->bindParam(5, $file, PDO::PARAM_STR);
            $stmt->bindParam(6, $data['category'], PDO::PARAM_STR);

            $stmt->execute();
            //"SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax;
	//

            if ($stmt) {

                return array('status' => 200, 'message' => 'Product added successfully', 'path' => $file);
            } else {

                echo array('status' => 500, 'message' => $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            print_r($stmt->errorInfo());
        }
    }

    public function addArticle($data) {

        try {

            $connect = $this->connectPDO();

            $query = $this->query_insert('addArticles');

            $stmt = $connect->prepare($query);

            //get generate userid
            $id = mt_rand(1101102, 1249647);
            // die(json_encode($data));
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $data['title'], PDO::PARAM_STR);
            $stmt->bindParam(3, $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(4, $data['fix'], PDO::PARAM_STR);
            $stmt->bindParam(5, $data['system'], PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt) {

                echo json_encode(array('status' => 200, 'statusMessage' => 'Article added successfully'));
            } else {

                echo json_encode(array('status' => 500, 'statusMessage' => $stmt->errorInfo())); // print_r($stmt->errorInfo());
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            print_r($stmt->errorInfo());
        }
    }

    private function response($status, $statusMessage) {

        return json_encode(array('status' => $status, 'statusMessage' => $statusMessage));
    }

    private function clean($string) {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }  
    
    private function encryptIt($q) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
        return( $qEncoded );
    }

    private function decryptIt($q) {
        $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        return( $qDecoded );
    }

   

}
