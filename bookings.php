

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <head>
        <title>TODO supply a title</title>
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

                        $http.get("bookingsservice.php?q=get")

                                .then(function (response) {

                                    $scope.data = response.data;

                                    console.log(response.data);

                                })

                    }
                    )


        </script>

    </head>

    <body ng-app="main">

        <div class="container" ng-controller="booking">
            <br>

            <h4>Today's appointments:</h4>

            <br>

            <div class="row">

                <div class="col-md-12">

                    <table class="table">

                        <thead>

                        <th>Date:</th>
                        <th>Time:</th>

                        <th>Name:</th>
 <th></th>
                        </thead>

                        <tr ng-repeat="booking in data">

                            <td><b>{{booking.DATE}}</b></td>
                            <td>{{booking.TIME}}</td>

                            <td>{{booking.FIRSTNAME + " " + booking.LASTNAME}}</td>
                            <td>
                                <input type="button" class="btn btn-success btn-sm" value="Approve">
                                <input type="button" class="btn btn-danger btn-sm" value="Decline">
                            </td>

                        </tr>

                    </table>

                </div>

            </div>           

        </div>

    </body>

</html>