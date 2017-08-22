

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

        <!--      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.2/angular-ui-router.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-cookie/4.1.0/angular-cookie.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        -->
        <link rel="stylesheet" href="configs/bootstrap.min.css" >
        <script src="configs/jquery.min.js"></script>
        <script src="configs/tether.min.js"></script>
        <script src="configs/bootstrap.min.js"></script>
        <script src="configs/angular.min.js"></script>
        <script src="configs/angular.min.js"></script>

        <style>
            .helper-text{
                font-size: 10pt;
                display: block;
                font-style: italic;
            }

            @media all and (min-width: 375px){
                label{
                    float: right;
                }
            }
        </style>

        <script>
            angular.module('main', [])
                    .controller('booking', function ($scope, $http) {

                        $scope.data = {
                            peopleMod: '',
                            time: '',
                            date: '',
                            email: '',
                            idnumber: '',
                            name: '',
                            surname: ''
                        }

                        $scope.mailSent = false;
                        $scope.sendingMail = false;

                        $scope.peopleObj = [
                            {
                                name: "Dr Nkosinathi",
                                lable: "Dr Nkosinathi",
                                id: 648646
                            },
                            {
                                name: "Dr Senzo",
                                lable: "Dr Senzo",
                                id: 232345

                            },
                            {
                                name: "Dr Thabang",
                                lable: "Dr Thabang",
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
                            $scope.sendingMail = true;
                            var d = {
                                __name__: data.name,
                                __drname__: data.peopleMod.name,
                                __bookedtime__: data.timeMod.time + " " + data.date,
                                email: data.email,
                                idnumber: data.idnumber,
                                name: data.name,
                                surname: data.surname,
                                bookedTime: data.timeMod.time,
                                bookedDate: data.date,
                                drid: data.peopleMod.id,
                                q: "makeBooking"
                            }
                            $http.defaults.headers.common['Access-Control-Allow-Origin'] = 'http://localhost/';
                            $http.post("bookingservice.php", d)

                                    .then(function (res) {

                                        if (res.data.status == 200) {
                                            $scope.mailSent = true;
                                   // alert(res.data.message);
                                        }
                                        else {
                                            alert(res.data.message);
                                        }
                                        console.log(res.data);
                                    })


                        }
                    })


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
            <div ng-if="mailSent">

                Your booking has been sent successfully.
                <br>
                Please wait to receive an email from us.

            </div>
            <div ng-if="!mailSent">
                <h4>Appointment</h4>

                <hr>

                <div class="booking-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Please fill in your appointment details below:</strong><br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">Dr:</label>

                                </div>
                                <div class="col-md-9">
                                    <select ng-model="data.peopleMod" ng-options="person as person.lable for person in peopleObj" class="form-control" placeholder="Dr's Name" ></select>
                                </div>
                            </div>           
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">Date:</label>
                                </div>
                                <div class="col-md-9">

                                    <input type="text" id="datepicker" class="form-control" ng-model="data.date" placeholder="Appointment date">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="control-label">Time:</label>
                                </div>
                                <div class="col-md-9">
                                    <select ng-model="data.timeMod" ng-options="time as time.time for time in timeObj" class="form-control" placeholder="Appointment time"></select>
                                </div>
                            </div>     
                            <br>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <strong>Please fill in your contact details below:</strong><br><br>
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-3">

                                    <label class="control-label">Name:</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="name" class="form-control" ng-model="data.name" placeholder="your name">

                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-md-3">

                                    <label class="control-label">Surname:</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="name" class="form-control" ng-model="data.surname" placeholder="your surname">

                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-md-3">

                                    <label class="control-label">ID Number:</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="number" id="idNumber" class="form-control" ng-model="data.idnumber" placeholder="your ID Number">

                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="col-md-3">

                                    <label class="control-label">Email:</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" id="email" class="form-control" ng-model="data.email" placeholder="your email address">

                                </div>
                            </div>


                        </div>
                    </div>

                    <br>


                    <hr>
                    <p>
                        You will be visiting {{data.peopleMod.name}} on {{data.date}} at {{data.timeMod.time}}
                    </p>
                    <input type="button" class="btn btn-warning" value="Click" ng-click="query()" ng-disabled="sendingMail">
                </div>
            </div>
        </div>
    </body>

</html>