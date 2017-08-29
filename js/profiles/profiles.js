angular.module('profiles-app', [
    'ui.router',
    'search-app',
    'userProfile-app',
    'addUserProfile-app',
    'session-app',
    'ngCookies',
    'nav-app',
    'waitingList-app'
])
        .config(function ($stateProvider, $urlRouterProvider) {

            $stateProvider
                    .state('profiles', {
                        controllerAs: 'profilesController',
                        templateUrl: "js/profiles/profiles.html",
                        url: '/profiles',
                        controller: function ($scope, $state, $http, $anchorScroll, serviceSession, $cookies) {

                            var self = this;
                            self.activeuser = "";
                            self.activeuser_firstname = "";
                            self.userRoles = serviceSession.get_roles();
                            self.spinner = true;
                            self.access = {
                                admin: isMember('[admin]')
                            }
                            $scope.queue = {
                                obj: []
                            };
                            
                            function isMember(role){
                               
                                var str = JSON.stringify(self.userRoles);
                               
                                if (str.indexOf(role) > 0){

                                    return true;
                                    
                                }
                                
                                return false;
                            }
                            
                            var call = serviceSession.get_roles();

                            var user_cookie = $cookies.get('m_userid');

                            if (user_cookie === null) {

                                $http.get('php/service.php?q=logOff');

                                $state.go('login');
                                return;
                            }

                            /*  var currentUser = serviceSession.getActiveProfile();
                             
                             currentUser.then(function (res) {
                             self.activeuser = res.data[0].FIRSTNAME + " " + res.data[0].LASTNAME;
                             self.activeuser_firstname = res.data[0].FIRSTNAME;
                             
                             })*/



                            $scope.userObj = {
                                search_done: false,
                                client: {},
                                clientSet: false,
                                activeProfileTab: 1
                            };

                            $scope.logOff = function () {

                                $cookies.remove('m_userid');
                                $http.get('php/service.php?q=logOff');

                                $state.go('login');
                            };


                            $scope.navTo = function (id) {

                                $anchorScroll(id);

                            };

                            $scope.back_to_search = function () {

                                $scope.userObj.clientSet = false;
                                $scope.userObj.client = null;

                            };

                        }
                    });
        });
