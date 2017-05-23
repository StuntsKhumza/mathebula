

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
        <script src="configs/angular.min.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <style>
            .booking-form{
                width: 550px;
                padding: 10px;
                margin: 0 auto;
            }
        </style>

        <script>
            angular.module('main', [])
                    .controller('booking', function ($scope, $http) {

                        $scope.data = {
                            peopleMod: '',
                            time: '',
                            date: ''
                        }

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
                            {time: "08:00"},
                            {time: "08:30"},
                            {time: "09:00"},
                            {time: "09:30"},
                            {time: "10:00"},
                            {time: "10:30"},
                            {time: "11:00"},
                            {time: "11:30"},
                            {time: "12:00"},
                            {time: "12:30"},
                            {time: "13:30"},
                            {time: "13:30"},
                            {time: "14:00"},
                            {time: "14:30"},
                            {time: "15:00"},
                            {time: "15:30"},
                            {time: "16:00"},
                            {time: "16:30"},
                            {time: "17:00"}

                        ]

                        $scope.query = function () {
                            var data = $scope.data;

                            $http.get("bookingsservice.php?DATE=" + data.date + "&DRID=" +
                                    data.peopleMod.id + "&TIME=" + data.timeMod.time +
                                    "&FIRSTNAME=Nathi&LASTNAME=Khumalo&" + "IDNUMBER=900323")
                                    .then(function (response) {
                                        console.log(response);
                                    })
                                    .then(function (response) {
                                        console.log(response);
                                    })

                        }
                    })//jansennonhlanhla@gmail.com / Husstling4Ricky


        </script>
        <script>
            $(function () {
                $("#datepicker").datepicker();
            });
        </script>
    </head>

    <body ng-app="main">

        <div class="container" ng-controller="booking">
            <br>

            <h4>Please complete below to make booking:</h4>

            <hr>

            <div class="booking-form">
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Person:</label>
                </div>
                <div class="col-md-6">
                    <select ng-model="data.peopleMod" ng-options="person as person.lable for person in peopleObj" class="form-control"></select>
                </div>
            </div>           
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Date:</label>
                </div>
                <div class="col-md-6">

                    <input type="text" id="datepicker" class="form-control" ng-model="data.date">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">Time:</label>
                </div>
                <div class="col-md-6">
                    <select ng-model="data.timeMod" ng-options="time as time.time for time in timeObj" class="form-control"></select>
                </div>
            </div>

            <br>
            <input type="button" class="btn btn-warning" value="Click" ng-click="query()">
        </div>
            </div>

    </body>

</html>