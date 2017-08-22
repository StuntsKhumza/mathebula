

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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi"
              crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7"
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8"
        crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK"
        crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <link rel="stylesheet" href="configs/bootstrap.min.css" >
        <script src="configs/jquery.min.js"></script>
        <script src="configs/tether.min.js"></script>
        <script src="configs/bootstrap.min.js"></script>
        <script src="configs/angular.min.js"></script>
        <script src="configs/angular.min.js"></script>
        <script>
            angular.module('main', [])

                    .controller('booking', function ($scope, $http) {
                        $scope.data = [];
                        $scope.peopleObj = [
                            {
                                name: "Nkosinathi",
                                lable: "Nkosinathi",
                                id: 648646
                            },
                            {
                                name: "Senzo",
                                lable: "Senzo",
                                id: 232345
                            },
                            {
                                name: "Thabang",
                                lable: "Thabang",
                                id: 232345
                            }
                        ];

                        $scope.timeObj = [
                            {time: "08:00 am"},
                            {time: "08:30 am"},
                            {time: "09:00 am"},
                            {time: "09:30 am"},
                            {time: "10:00 am"},
                            {time: "10:30 am"},
                            {time: "11:00 am"},
                            {time: "11:30 am"},
                            {time: "12:00 pm"},
                            {time: "12:30 pm"},
                            {time: "01:30 pm"},
                            {time: "01:30 pm"},
                            {time: "02:00 pm"},
                            {time: "02:30 pm"},
                            {time: "03:00 pm"},
                            {time: "03:30 pm"},
                            {time: "04:00 pm"},
                            {time: "04:30 pm"},
                            {time: "05:00 pm"}

                        ]
                        var reqData = {
                            q: "getBookings"
                        }
                        
                       loadData();
                                
                                function loadData(){
                                     //load bookings
                        $http.post("bookingservice.php", reqData)

                                .then(function (response) {
                                    
                                    if (response.status == 200){
                                        $scope.data = response.data;
                               // console.log($scope.data);
                                    } else {
                                        $scope.message = response.data.message
                                        console.log($scope.data);
                                    }
                                    
                                    

                                })
                                }
                                //
                                $scope.reply = function(id, action, actionToTake, object){
                                    
                                    var request = {
                                        action: action,
                                        id: id,
                                        q: "actionBooking",
                                        actionToTake: actionToTake,
                                        object: object
                                    }
                                    
                                  $http.post("bookingservice.php", request)
                                          .then(function(response){
                                              if(response.status == 200)
                                                   loadData();
                                           
                                          })
                                    
                                    
                                }
                                
                              

                    }
                    )


        </script>
        <style>
            .declined {
                color:red;
            }
        </style>

    </head>

    <body ng-app="main">

        <div class="container" ng-controller="booking">
            <br>

            <h4>Today's appointments ({{data.length}}):</h4>

            <br>

            <div class="row">

                <div class="col-md-12">

                    <table class="table">

                        <thead>

                        <th>Date:</th>
                        <th>Time:</th>

                        <th>Name:</th>
                        <th>Status:</th>
 <th></th>
                        </thead>

                        <tr ng-repeat="booking in data" ng-if="data.length > 0">

                            <td>{{booking.DATE}}</td>
                            <td>{{booking.TIME}}</td>

                            <td>{{booking.FIRSTNAME + " " + booking.LASTNAME}}</td>
                            <td>
                                <span ng-class="{'declined':booking.STATUS == 'DECLINED'}">{{booking.STATUS}}</span>
                                </td>
                            <td>
                                <input type="button" ng-hide="booking.STATUS != 'NEW'" class="btn btn-success btn-sm" value="Approve" ng-click="reply(booking.ID, 'accept', 'ACCEPTED', booking)">
                                <input type="button" ng-hide="booking.STATUS != 'NEW'" class="btn btn-danger btn-sm" value="Decline" ng-click="reply(booking.ID, 'decline', 'DECLINED', booking)">
                            </td>

                        </tr>

                    </table>

                </div>

            </div>           

        </div>

    </body>

</html>