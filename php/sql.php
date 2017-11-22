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
        } catch (PDOException $e) {


            die($e->getMessage());
        }


        return $connection;
    }

    private function query_read($q) {


        $query = "";

        switch ($q) {

            case "authenticate":

                //System users
                $query = "SELECT 
                            su.ID AS SYS_USERID, 
                            su.NAME AS SYS_USERNAME, 
                            su.SURNAME AS SYS_USERSURNAME, 
                            su.ID AS SYS_USERSESSION, 
                            su.USERNAME AS SYS_USERSYSNAME,
                            su.PASSWORD AS SYS_USERPASSWORD," .
                        //System roles

                        "sr.ID AS ROLEID,
                            sr.ROLE AS ROLE, " .
                        //system assigned roles
                        "sar.ID AS ASS_ID,
                            sar.USERID AS ASS_USERID,
                            sar.ROLEID AS ASS_USERID,
                            sar.ROLE AS ASS_ROLE 

                            FROM sysusers su, sysroles sr, sysasignedroles sar WHERE su.USERNAME = ? and sar.USERID = su.ID and sar.ROLEID = sr.ID";
                break;

            case "authenticate_getUser":
                $query = "SELECT `USERID` FROM `logins` WHERE `USERNAME` = ?";

                break;

            case "getProfile":

                $query = "SELECT * FROM `users` WHERE `LOGIN` = ?";


                break;


            case "searchProfile_card":

                $query = "SELECT * FROM `patients` WHERE (CONVERT(`PATIENTCARDNUMBER` USING utf8) LIKE ? " . " '%')";

                break;

            case "searchProfile_id":

                $query = "SELECT * FROM `patients` WHERE (CONVERT(`PATIENTIDNUMBER` USING utf8) LIKE ? " . " '%')";

                break;

            case "getMyQ":

                $query = "SELECT * FROM patients u right join myq q on u.PATIENTID = q.PATIANTID where q.DRID = ? AND DATE(q.DATE) = CURDATE()";

                break;

            case "getUsersByType":

                $query = "SELECT *, NULL AS `PASSWORD`,NULL AS `SESSIONID` FROM `sysusers` WHERE `TYPE` = ?";

                break;

            case "loadWaitingList":

                //$query = "SELECT * from users u RIGHT JOIN myq m on u.ID = m.PATIANTID WHERE STATUS =?";
                $query = "SELECT *,NULL AS PASSWORD, sysUsers.Name as DRNAME, sysUsers.SURNAME AS DIRSURNAME, 
                sysUsers.ID AS DRID, myq.ID QID FROM patients, myq, sysUsers 
                WHERE patients.PATIENTID = myq.PATIANTID AND sysUsers.ID = myq.DRID AND DATE(`DATE`) = CURDATE() ORDER BY `myq`.`DATE` AND `myq`.`DATE` ASC";

                break;

            case "getPatientCount":

                $query = "SELECT COUNT(`PATIENTID`) AS TOTAL FROM drs.patients WHERE `PATIENTTYPE` = ?";

                break;
            
            case "getfamilyfriend":
                
                $query = "SELECT * FROM `familyfriend`";
                
                break;

            case "getFamilyMember":

            $query = "SELECT * FROM `familyfriend` WHERE FFPATIENTID = ?";

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

            case "addToQueue":
                $query = "INSERT INTO `myq`  VALUES (?,?,?,?,?,?)";

                break;
            case "updatesToQueue":
                $query = "UPDATE MYQ SET DRID = ? WHERE ID = ?";

                break;
            case "deleteFromQueue":
                $query = "DELETE FROM MYQ WHERE ID = ?";

                break;
            case "addFamilyMember":
            
                $query = "INSERT INTO `familyfriend` VALUES(?,?,?,?,?)";

            break;
        }


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

        return $stmt->rowCount();
    }

    private function createID() {

        return mt_rand(1101102, 1249647);
    }

    public function getMyQueue($data) {

        if (!isset($_SESSION['USERID'])) {
            return json_encode(array(
                'status' => 500,
                'message' => 'Session variable not set.'));
        }

        $connect = $this->connectPDO();

        $userKey = $_SESSION['USERID'];

        //check connection
        if ($connect != null) {

            $query = "";

            $query = $this->query_read('getMyQ');

            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $userKey, PDO::PARAM_INT);

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

                if ($result[0]['SYS_USERPASSWORD'] == $password) {

                    $_SESSION['USERID'] = $result[0]['SYS_USERID'];
                    $_SESSION['active'] = "true";

                    for ($i = 0; $i < count($result); $i++) {

                        //$
                        $role[$i] = array("ROLEID" => $result[$i]['ROLEID'], "ROLE" => $result[$i]['ROLE']);
                    }

                    $_SESSION['roles'] = json_encode($role);
                    $_SESSION['username'] = $result[0]['SYS_USERNAME'];
                    
                    $additionalData = array('name' => $result[0]['SYS_USERNAME']);

                    echo json_encode(array("status" => 200, 'message' => 'success', 'data' => array('userid' => base64_encode($result[0]['SYS_USERSESSION']), 'roles' => $role, 'userdata' => $additionalData)));
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

    public function getUsersByType($data) {

        $connect = $this->connectPDO();

        //check connection
        if ($connect != null) {

            $query = $this->query_read('getUsersByType');

            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $data['type'], PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                //USER FOUND
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return json_encode(array('status' => 200, 'message' => 'users found', 'data' => $result));
            } else {

                //user not found
                return json_encode(array('status' => 400, 'message' => 'users not found'));
            }
        }
    }

    public function addToQueue($data) {

        try {
            $connect = $this->connectPDO();

            //check connection
            if ($connect != null) {
                
                $status = "";
                $stmt = "";
                switch ($data['action']) {

                    case "ADD":
                        $query = $this->query_insert('addToQueue');

                        $id = $this->createID();
                        $date = $this->get_Date(true, null);
                        $time = $this->get_time(true, null);
                        $stmt = $connect->prepare($query);

                        $stmt->bindParam(1, $id, PDO::PARAM_INT);
                        $stmt->bindParam(2, $data['DRID'], PDO::PARAM_INT);
                        $stmt->bindParam(3, $data['PATIENTID'], PDO::PARAM_INT);
                        $stmt->bindParam(4, $data['STATUS'], PDO::PARAM_STR);

                        $stmt->bindParam(5, $date, PDO::PARAM_STR);
                        $stmt->bindParam(6, $time, PDO::PARAM_STR);
                        
                        $status = "Added successfully";
                        
                        break;
                    case "UPDATE":
                        $query = $this->query_insert('updatesToQueue');

                        $stmt = $connect->prepare($query);

                        $stmt->bindParam(1, $data['DRID'], PDO::PARAM_INT);
                        $stmt->bindParam(2, $data['QID'], PDO::PARAM_INT);
                        $status = "Updated successfully";
                        break;
                    case "DELETE":
                        $status = "Deleted successfully";
                        
                        $query = $this->query_insert('deleteFromQueue');

                        $stmt = $connect->prepare($query);

                        $stmt->bindParam(1, $data['QID'], PDO::PARAM_INT);
                        break;
                }


                $stmt->execute();

                if ($stmt) {

                    return json_encode(array('status' => 200, 'message' => $status));
                } else {
                    http_response_code(500);
                    echo json_encode(array('status' => 500, 'message' => $stmt->errorInfo()));
                }
            }
        } catch (PDOException $e) {

            die(json_encode(array('status' => 500, 'message' => $e->getMessage())));
        }
    }

    public function getDependents($data){
        $connect = $this->connectPDO();
        
                //check connection
                if ($connect != null) {
        
                    $query = "SELECT * FROM patientsdependents JOIN PATIENTS ON PATIENTS.PATIENTID = patientsdependents.PDDEPENDENT WHERE patientsdependents.PDMAIN = ?";//$this->query_read('loadWaitingList');
        
                    $stmt = $connect->prepare($query);
        
                    $stmt->bindParam(1, $data['MAINID'], PDO::PARAM_INT);
        
                    $stmt->execute();
        
                    if ($stmt->rowCount() > 0) {
        
                        //USER FOUND
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                        return json_encode(array('status' => 200, 'message' => 'users found', 'data' => $result));
                    } else {
        
                        //user not found
        
                        return json_encode(array('status' => 400, 'message' => 'no dependents'));
                    }
                }
    }


    public function doSearch($data){

        $connect = $this->connectPDO();
        
                //check connection
                if ($connect != null) {
        
                    $query = "SELECT * FROM `PATIENTS` WHERE (CONVERT(`PATIENTSURNAME` USING utf8) LIKE ? " . " '%')"; //$this->query_read('loadWaitingList'); 
                    // $query = "SELECT * FROM `patients` WHERE (CONVERT(`PATIENTIDNUMBER` USING utf8) LIKE ? " . " '%')";
        
                    $stmt = $connect->prepare($query);
        
                    $stmt->bindParam(1, $data['query'], PDO::PARAM_STR);
        
                    $stmt->execute();
        
                    if ($stmt->rowCount() > 0) {
        
                        //USER FOUND
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                        return json_encode(array('status' => 200, 'message' => 'patients found', 'data' => $result));
                    } else {
        
                        //user not found
        
                        return json_encode(array('status' => 400, 'message' => 'Waiting list is empty'));
                    }
                }

    }

    public function loadWaitingList($data) {

        $connect = $this->connectPDO();

        //check connection
        if ($connect != null) {

            $query = $this->query_read('loadWaitingList');

            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $data['type'], PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                //USER FOUND
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return json_encode(array('status' => 200, 'message' => 'users found', 'data' => $result, 'q' => $data['q']));
            } else {

                //user not found

                return json_encode(array('status' => 400, 'message' => 'Waiting list is empty'));
            }
        }
    }

    public function createPatient($data) {
        //createPatientId

        $fileID = "";

        $fileID = $this->createPatientId($data['PATIENTTYPE']);

        try {
            $connect = $this->connectPDO();

            //check connection
            if ($connect != null) {

                $query = "INSERT INTO `patients` VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; //$this->query_insert('addPatient');
                $id = $this->createID();
                $cardid = $data['PATIENTTYPE'] . $this->createPatientId($data['PATIENTTYPE']);
                $date = $this->get_Date(true, null);
                //  $time = $this->get_time(true, null);
                $stmt = $connect->prepare($query);

                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->bindParam(2, $cardid, PDO::PARAM_STR);
                $stmt->bindParam(3, $data["PATIENTNAME"], PDO::PARAM_STR);
                $stmt->bindParam(4, $data["PATIENTSURNAME"], PDO::PARAM_STR);
                $stmt->bindParam(5, $data["PATIENTTITLE"], PDO::PARAM_STR);
                $stmt->bindParam(6, $data["PATIENTDOB"], PDO::PARAM_STR);
                $stmt->bindParam(7, $data["PATIENTIDNUMBER"], PDO::PARAM_STR);
                $stmt->bindParam(8, $data["PATIENTMARITALSTATUS"], PDO::PARAM_STR);
                $stmt->bindParam(9, $data["PATIENTHOMEADDRESS1"], PDO::PARAM_STR);
                $stmt->bindParam(10, $data["PATIENTHOMEADDRESS2"], PDO::PARAM_STR);
                $stmt->bindParam(11, $data["PATIENTHOMEADDRESS3"], PDO::PARAM_STR);
                $stmt->bindParam(12, $data["PATIENTHOMEADDRESSCODE"], PDO::PARAM_STR);
                $stmt->bindParam(13, $data["PATIENTTELL"], PDO::PARAM_STR);
                $stmt->bindParam(14, $data["PATIENTCELL"], PDO::PARAM_STR);
                $stmt->bindParam(15, $data["PATIENTPOSTALADDRESS1"], PDO::PARAM_STR);
                $stmt->bindParam(16, $data["PATIENTPOSTALADDRESS2"], PDO::PARAM_STR);
                $stmt->bindParam(17, $data["PATIENTPOSTALADDRESS3"], PDO::PARAM_STR);
                $stmt->bindParam(18, $data["PATIENTPOSTALADDRESSCODE"], PDO::PARAM_STR);
                $stmt->bindParam(19, $data["PATIENTSPOUSETELL"], PDO::PARAM_STR);
                $stmt->bindParam(20, $data["PATIENTSPOUSECELL"], PDO::PARAM_STR);
                $stmt->bindParam(21, $data["PATIENTEMPLOYER"], PDO::PARAM_STR);
                $stmt->bindParam(22, $data["PATIENTOCCUPATION"], PDO::PARAM_STR);
                $stmt->bindParam(23, $data["PATIENTOCCUPATIONADDRESS1"], PDO::PARAM_STR);
                $stmt->bindParam(24, $data["PATIENTOCCUPATIONADDRESS2"], PDO::PARAM_STR);
                $stmt->bindParam(25, $data["PATIENTOCCUPATIONADDRESS3"], PDO::PARAM_STR);
                $stmt->bindParam(26, $data["PATIENTOCCUPATIONTELL"], PDO::PARAM_STR);
                $stmt->bindParam(27, $data["PATIENTHOUSEDOCTOR"], PDO::PARAM_STR);
                $stmt->bindParam(28, $data["PATIENTMEDICALAID"], PDO::PARAM_STR);
                $stmt->bindParam(29, $data["PATIENTMEDICALAIDNAME"], PDO::PARAM_STR);
                $stmt->bindParam(30, $data["PATIENTMEDICALAIDPLAN"], PDO::PARAM_STR);
                $stmt->bindParam(31, $data["PATIENTMEDICALAIDNUMBER"], PDO::PARAM_STR);
                $stmt->bindParam(32, $data["PATIENTMEDICALAIOTHER"], PDO::PARAM_STR);
                $stmt->bindParam(33, $data["PATIENTTYPE"], PDO::PARAM_STR);
                $stmt->bindParam(34, $date, PDO::PARAM_STR);


                $stmt->execute();

                if ($stmt) {

                    return json_encode(array('status' => 200, 'message' => 'Added successfully'));
                } else {
                    //http_response_code(500);
                    echo json_encode(array('status' => 500, 'message' => $stmt->errorInfo()));
                }
            }
        } catch (PDOException $e) {

            echo json_encode(array('status' => 500, 'message' => $e->getMessage()));
        }
    }

    public function createPatientId($type) {

        try {

            //getPatientCount
            $connect = $this->connectPDO();

            //check connection
            if ($connect != null) {

                $query = $this->query_read('getPatientCount');

                $stmt = $connect->prepare($query);

                $stmt->bindParam(1, $type, PDO::PARAM_STR);

                $stmt->execute();

                if ($stmt->rowCount() > 0) {

                    //USER FOUND
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    //print_r($result)             ;
                    return $this->getCount($result[0]['TOTAL'] ); //json_encode(array('status' => 200, 'message' => 'success', 'data' => $result));
                } else {

                    //user not found

                    return json_encode(array('status' => 400, 'message' => 'Waiting list is empty'));
                }
            }
        } catch (Exception $ex) {
            return json_encode(array('status' => 500, 'message' => 'Waiting list is empty'));
        }
    }

    public function addFamilyMember($data){

        try {
            
                        //getPatientCount
                $connect = $this->connectPDO();

                $id = $this->createID();
                        //check connection
                if ($connect != null) {
            
                    $query = $this->query_insert('addFamilyMember');
            
                            $stmt = $connect->prepare($query);
            
                            $stmt->bindParam(1, $id, PDO::PARAM_INT);
                            $stmt->bindParam(2, $data['NAME'], PDO::PARAM_STR);
                            $stmt->bindParam(3, $data['PATIENTID'], PDO::PARAM_INT);
                            $stmt->bindParam(4, $data['ADDRESS'], PDO::PARAM_STR);
                            $stmt->bindParam(5, $data['RELATIONSHIP'], PDO::PARAM_STR);
            
                            $stmt->execute();
            
                            if ($stmt) {

                                return json_encode(array('status' => 200, 'message' => 'Memeber added successfully', ));

                            } else {
            
                                echo json_encode(array('status' => 501, 'message' => $stmt->errorInfo()));

                            }
                        }
                    } catch (Exception $ex) {
 
                        return json_encode(array('status' => 500, 'message' =>$ex->getMessage()));

                    }
        
        
        

    }

    public function getFamilyMember($data){

        try {

                $connect = $this->connectPDO();

                $id = $this->createID();
                        //check connection
                if ($connect != null) {
            
                    $query = $this->query_read('getFamilyMember');
            
                            $stmt = $connect->prepare($query);
            
                            $stmt->bindParam(1, $data['PATIENTID'], PDO::PARAM_INT);
            
                            $stmt->execute();
            
                            if ($stmt) {

                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                return json_encode(array('status' => 200, 'message' => 'Memeber found successfully','data'=>$result[0] ));

                            } else {
            
                                echo json_encode(array('status' => 501, 'message' => $stmt->errorInfo()));

                            }
                        }
                    } catch (Exception $ex) {
 
                        return json_encode(array('status' => 500, 'message' =>$ex->getMessage()));

                    }
        
    }

    private function getCount($ii){
        $d = "00";
        $dd = "000";
        $ddd = "0000";
        $dddd = "00000";
        
        if ($ii < 10)
        {$i = $dddd . $ii; return $i;}
        else if ($ii < 100)
        {$i = $ddd . $ii; return $i;}
        else if ($ii < 1000)
        {$i = $dd . $ii; return $i;}
        else if ($ii < 10000)
        {$i = $d . $ii; return $i;}
      
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

            if ($data['search_type'] == 'card') {
                $query = $this->query_read('searchProfile_card');
            } else {
                $query = $this->query_read('searchProfile_id');
            }

            $stmt = $connect->prepare($query);

            $stmt->bindParam(1, $userKey, PDO::PARAM_STR);

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

    //CREATE DATE
    private function get_Date($d, $dValue) {
        /*
         *  $new_time = date('G:i', strtotime($data['bookedTime']));
          $new_date = date('Y-m-d', strtotime(str_replace('/', '-', $data['bookedDate'])));
         */
        $newDate = "";

        if ($d) {
            $newDate = date("Y-m-d");
        } else {
            $newDate = date('Y-m-d', strtotime(str_replace('/', '-', $dValue)));
        }
        return $newDate;
    }

    //CREATE TIME

    private function get_time($t, $tValue) {

        $newDate = "";

        if ($t) {
            $newDate = date("h:i:s");
        } else {
            $newDate = date('G:i', strtotime($tValue));
        }
        return $newDate;
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
