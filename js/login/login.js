angular.module('login-app', ['ui.router', 'session-app'])

.config(function ($stateProvider, $urlRouterProvider) {

    $stateProvider
        .state('login', {
            controllerAs: 'loginController',
            templateUrl: "js/login/login.html",
            url: '/login',
            controller: function ($scope, $state, $http, session, serviceSession) {

                var self = this;
                self.searching = false;
                self.loginObj = {
                    username: '',
                    userpassword: '',
                    message: ''
                }
                if (session == "true") {

                    $state.go('profiles');

                }

                self.login = function () {
                    //    $state.go('profiles');       
                     //   return;
                    self.searching = true;
                    
                    var data = serviceSession.login(self.loginObj);

                    data.then(function (res) {
                        
                        if(res.status > 200){
                            self.loginObj.message = res.message;
                            self.loginObj.username = "";
                            self.loginObj.password = "";
                        } else {
                            $state.go('profiles');
                        }

                        self.searching = false;

                    });


                }

                //keyboard key up buttom
                self.login_keyup = function(e){
                    if (e.keyCode == 13) {
                        self.login();
                    }
                    

                }
            },
            resolve: {

                session: function (serviceSession) {

                    var data = serviceSession.getSession();

                    return data.then(function (res) {

                        return res.status;

                    })
                }
            }
        })
})

/*

.controller('main', function ($http, $scope, $window) {

            $scope.loginObj = {
                username: "",
                password: "",
                message: "",
                loggedin: false,
                clientSelected: false,
                btn_action: "Login"
            };


            $scope.uiObj = {
                searchEnabled: true
            }

            $scope.resetPassword = false;

            $scope.login = function () {

                //reseting password
                if ($scope.resetPassword) {

                    $http.get('php/service.php?q=setSession')//'php/service.php?q=authenticate_checkUser&username=' + $scope.loginObj.username)
                            .then(function (response) {

                                var data = response.data;

                                if (data.status == 400) {

                                    //console.log(data);
                                    $scope.loginObj.message = data.message;
                                    $scope.loginObj.username = "";
                                    $scope.loginObj.password = "";

                                } else {

                                    $window.location.href = "reset.php?q=reset_pass&" + data.encryptedI + "=" + data.data;
                                    //console.log(data);
                                }



                            })



                    //  $window.location.href = "reset.php?q=reset_pass&id=" + $scope.loginObj.username;

                } else {

                    $scope.loginObj.loggedin = true;
                    $http.get('php/service.php?q=setSession');
                    return;
                    //try to login
                    $http.get('php/service.php?q=authenticate&username=' + $scope.loginObj.username + "&password=" + $scope.loginObj.password)
                            .then(
                                    function (response) {

                                        var status = response.data.status;
                                        var message = response.data.message;
                                        var data = response.data.data;

                                        if (status == 200) {
                                            $scope.loginObj.loggedin = true;
                                        } else if (status == 404) {

                                            $scope.loginObj.message = message;
                                            $scope.loginObj.username = "";
                                            $scope.loginObj.password = "";

                                        } else {
                                            console.log(response.data)
                                        }

                                    }
                            )
                }
            }

            $scope.password_reset = function () {

                $scope.loginObj.btn_action = "Reset";

                $scope.resetPassword = true;


            }

        })

*/
