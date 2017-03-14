angular.module('login-app', ['ui.router', 'session-app'])

    .config(function ($stateProvider, $urlRouterProvider) {

        $stateProvider
            .state('login', {
                controllerAs: 'loginController',
                templateUrl: "js/login/login.html",
                url: '/login',
                controller: function ($scope, $state, $http, serviceSession) {

                    var self = this;
                    self.searching = true;
                    self.loginObj = {
                        username: '',
                        userpassword: '',
                        message: ''
                    }

                    var data = serviceSession.getSession();

                    data.then(function (res) {
                        if (res.status == "true") {
                            $state.go('profiles');
                            return;
                        } else {
                            self.searching = false;
                        }

                    })
                    /*if (session == "true") {
    
                        $state.go('profiles');
    
                    }*/

                    self.login = function () {
                        //    $state.go('profiles');       
                        //   return;
                        self.searching = true;

                        var data = serviceSession.login(self.loginObj);

                        data.then(function (res) {

                            if (res.status > 200) {
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
                    self.login_keyup = function (e) {
                        if (e.keyCode == 13) {
                            self.login();
                        }


                    }
                }
            })
    })
