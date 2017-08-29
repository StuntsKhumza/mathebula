angular.module('session-app', ['ngCookies'])
    .service('serviceSession', function ($http, $cookies) {
        
        this.uploadUrl = "php/service_secured.php";
        this.roles = "";
        
        this.getSession = function () {
            var call = $http.get('php/service.php?q=getSession');

            return call.then(function (response) {
                return data = response.data;
            });

        };
        
        this.get_roles = function(){
            
            //check if roles were set
            
            if (this.roles.length === 0){
                
                var d = _getCookie('roles', $cookies);
                
                return d;
            }
            
            return this.roles;
        }
        
        this.set_roles = function(data){
            this.roles = data;
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

        //searching
        this.search_profile = function(data){

            var formData = new FormData();
            formData.append('q', "searchProfile");
            formData.append("search_key", data.search_key);
            formData.append("search_type", data.search_type);
           
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