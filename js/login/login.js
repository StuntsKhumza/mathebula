angular.module('login-app', ['ui.router', 'session-app',  'ngCookies'])

    .config(function ($stateProvider, $urlRouterProvider) {

        $stateProvider
            .state('login', {
                controllerAs: 'loginController',
                templateUrl: "js/login/login.html",
                url: '/login',
                controller: function ($scope, $state, $http, serviceSession, $cookies) {

                    var self = this;

                    self.searching = false;

                    self.loginObj = {
                        username: '',
                        userpassword: '',
                        message: ''
                    }

                    self.btnText = "Login";

                    var user_cookie = $cookies.get('m_userid');

                    if(user_cookie != null){

                        $state.go('profiles');
                        return;
                    }
                    /*if (session == "true") {
    
                        $state.go('profiles');
    
                    }*/

                    self.login = function () {
                        //    $state.go('profiles');       
                        //   return;
                        //self.searching = true;
                        self.btnText = "please wait...";
                        var data = serviceSession.login(self.loginObj);

                        data.then(function (res) {

                            if (res.status > 200) {
                                self.loginObj.message = res.message;
                                self.loginObj.username = "";
                                self.loginObj.password = "";
                                self.btnText = "Login";
                            } else {
                             
                                $cookies.put("m_userid", res.data.userid);

                                $state.go('profiles');
                            }

                           // self.searching = false;

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
