

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <head>
        <title>View Bookings</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <link rel="stylesheet" href="configs/bootstrap.min.css" >
        <script src="configs/jquery.min.js"></script>
        <script src="configs/tether.min.js"></script>
        <script src="configs/bootstrap.min.js"></script>
        <script src="configs/angular.min.js"></script>
       
        <script>
            angular.module('main', [])

                    .controller('addUser', function ($scope, $http) {
                        
                    }
                    )


        </script>
        <style>
            
        </style>

    </head>

    <body ng-app="main">
        
        <div class="container" ng-controller="addUser">
            
           <?php

            if (isset($_GET['password'])){

                try{

               $dbname = "drs";

               $servername = "localhost";

                $db = new PDO("mysql:host=$servername;dbname=$dbname", 'nathi', 'hSv4YZmZjNcbQCLN');
                
                $statement = $db->prepare("SELECT * FROM bookings");
                
                $statement->execute();
                
                 $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                 reply(200, $result);
                
                } catch(Exception $e){
                    
                    //
                    reply(500, $e->getMessage());
                    
                }
            } else {
               
                echo "2";

            }

            function reply($code, $message){

               // echo array("status"=>$code, "message"=>$message);
                echo json_encode(array("status"=>$code, "message"=>$message));

            }
            

            ?> 

        </div>

    </body>

</html>