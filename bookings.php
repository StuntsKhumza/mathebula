

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

                    .controller('booking', function ($scope, $http) {
                        
                        $scope.data = [];
                
                        var reloadTime = 600000;
                        
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
                        
                        $scope.goHome = function(){
                            window.location = "/mathebula/home";
                        }

                        loadData();
                        myFunction();
                        
                        function loadData() {
                            //load bookings
                            $http.post("php/bookingservice.php", reqData)

                                    .then(function (response) {

                                        if (response.status == 200) {
                                            $scope.data = response.data;
                                            // console.log($scope.data);
                                        } else {
                                            $scope.message = response.data.message
                                            console.log($scope.data);
                                        }



                                    })
                        }
                        //
                        $scope.reply = function (id, action, actionToTake, object) {

                            var request = {
                                action: action,
                                id: id,
                                q: "actionBooking",
                                actionToTake: actionToTake,
                                object: object
                            }

                            $http.post("php/bookingservice.php", request)
                                    .then(function (response) {
                                        if (response.status == 200)
                                            loadData();

                                    })


                        }
                        
                        function myFunction() {
                            setInterval(function(){
                                loadData() }, reloadTime);
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
            
                <input type="button" class="btn btn-md btn-primary" value="Main App" ng-click="goHome()">
            
            
             
            <br>
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