angular.module('session-app', [])
    .service('serviceSession', function ($http) {

        this.uploadUrl = "php/service_secured.php";

        this.getSession = function () {
            var call = $http.get('php/service.php?q=getSession');

            return call.then(function (response) {
                return data = response.data;
            })

        }

        this.login = function(data){

            var formData = new FormData();
            formData.append('q', "authenticate");
            formData.append("username", data.username);
            formData.append("password", data.password);

            return $http.post(this.uploadUrl, formData, {
                transformRequest: angular.identity
                , headers: {
                    'Content-Type': undefined
                }
            }).
            
             then(function(res){
             
               return res.data;
            })

        }

         this.getActiveProfile = function(){

            var formData = new FormData();
            formData.append('q', "getActiveProfile");
           
            return $http.post(this.uploadUrl, formData, {
                transformRequest: angular.identity
                , headers: {
                    'Content-Type': undefined
                }
            }).
            
             then(function(res){
             
               return res.data;
            })

        }

        //$_SESSION['USERID'] getActiveProfile

    }) 