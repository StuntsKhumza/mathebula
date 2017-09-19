<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dr's Co</title>
  <!--      
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>

	    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.2/angular-ui-router.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-cookie/4.1.0/angular-cookie.js"></script>
-->


        
        <link rel="stylesheet" href="css/bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css">
        <script src="js/utils.js"></script>
        <script src="configs/jquery.min.js"></script>
        <script src="configs/tether.min.js"></script>
        <script src="css/bootstrap-4.0.0-alpha.6-dist/js/bootstrap.min.js"></script>
	<script src="configs/angular.min.js"></script>
        <script src="configs/angular-ui-router.js"></script>
        <script src="configs/angular-cookie.js"></script>
        <script src="configs/jquery.transit.min.js"></script>

        <script src="js/main.js" type="text/javascript"></script>
        <link href="css/main.css" rel="stylesheet" type="text/css"/>
        <link href="css/utils.css" rel="stylesheet" type="text/css"/>
        <link href="css/user-profile.css" rel="stylesheet" type="text/css"/>
        <link href="css/waitinglist.css" rel="stylesheet" type="text/css"/>
        <link href="css/navbar.css" rel="stylesheet" type="text/css"/>
        <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="img/1477676379_icon-57.png">

        <!--session-->
        <script src="js/session.js"></script>


        <!--LOGIN MOD-->
        <script src="js/login/login.js"></script>

        <!--User profile-->
        <script src="js/profiles/profiles.js"></script>
        
        <script src="js/userProfile/general/general.js"></script>
        <script src="js/userProfile/address/address.js"></script>
        <script src="js/userProfile/past medical history/pastMedicalHistory.js"></script>
        <!--queue-->
        <script src="js/myQ/myQ.js"></script>

        <script src="js/nav/nav.js"></script> 
        <!--nav-->
<script src="configs/navbar.js"></script>
        <!--user profile mod-->
        <script src="js/userProfile/userProfile.js" type="text/javascript"></script>

        <!--search app-->
        <script src="js/search/search.js" type="text/javascript"></script>
        
        <!--add client-->
        <script src="js/addUser/addUser.js" type="text/javascript"></script>

        <script src="js/lodash.min.js" type="text/javascript"></script>

        <script src="js/userProfile/propicv2/propicv2.js"></script>
        
        <script src="js/userProfile/proPic/proPic.js"></script>

        <!--comments-->  
        <script src="js\userProfile\comments\comments.js"></script>
               
        <!--waiting list-->
        <script src="js/waitinglist/waitinglist.js"></script>
        
        <link rel="stylesheet" href="css/sidemenu.css">
        <script src="js/waitinglist/waitinglist.js"></script>
        
        <script src="configs/slideMenu.js"></script>

        <script src="js/directives/ngSearch/ngSearch.js"></script>

        <!--clinical examination-->
        <script src="js/userProfile/clinical examination/clinicalexam.js"></script>

        <script>
        /*    window.onbeforeunload = function(){
    return "You are about to leave leave/reload this page. This will log you out. \n";
} */
        </script>
        
        
        <script src="js/directives/save/save.js"></script>
        

 <script>
        function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

      
    </script>

    </head>
    <body ng-app="main-app">
         <ui-view></ui-view>
    </body>
</html>
