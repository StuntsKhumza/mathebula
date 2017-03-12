<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="../configs/bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <script src="../configs/bootstrap-3.3.6-dist/js/jquery-2.2.4.min.js"></script>
        <script src="../configs/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        <script src="../configs/bootstrap-3.3.6-dist/js/angular1.5.6.js"></script>
    </head>
    <body>

        <div class="container">
            <br>
            <div class="alert alert-warning">
                <?php
                require "/php/reset.php";

                if (isset($_GET)) {

                    if (isset($_GET['q'])) {

                        echo reset_password($_GET);
                    }
                }
                ?>
            </div>

            <br>

        </div>
    </body>
</html>
