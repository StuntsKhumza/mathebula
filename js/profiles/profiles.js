angular.module('profiles-app', [
    'ui.router',
    'search-app',
    'userProfile-app',
    'addUserProfile-app',
    'session-app',
    'ngCookies',
    'nav-app',
    'waitingList-app', "myQ-app",
])
        .config(function ($stateProvider, $urlRouterProvider) {

            $stateProvider
                    .state('profiles', {
                    controllerAs: 'profilesController',
                            templateUrl: "js/profiles/profiles.html",
                            url: '/profiles',
                            controller: function ($scope, $state, $http, $anchorScroll, serviceSession, $cookies, getActiveSession) {
                                
                              
                              if (getActiveSession.data.status == "false"){
                                  $state.go("login");
                                  return;
                              }
                                                              
                                var self = this;
                                self.activeuser = "";
                                self.activeuser_firstname = "";
                                self.spinner = true;

                                self.navbtns = {
                                    active: 'HOME',
                                    hide: {
                                        bookings: false,
                                        queu:false,
                                    }
                                }

                                self.userRoles = serviceSession.get_roles();

                                self.access = {
                                    admin: isMember('[admin]', self.userRoles),
                                    doctor: isMember('[doctor]', self.userRoles),
                                    reception: isMember('[reception]', self.userRoles)

                                }

                                $scope.queue = {
                                    obj: []

                                };

                                self.test = function () {
                                    alert('test hello world');
                                }

                                var call = serviceSession.get_roles();

                                var user_cookie = $cookies.get('m_userid');

                                if (user_cookie === null) {

                                    $http.get('php/service.php?q=logOff');

                                    $state.go('login');
                                    return;
                                }

                                self.addToQueue = function () {

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

                            },
                            resolve: {
                            getActiveSession: function ($http) {
                                return $http.get('php/service.php?q=getSession')
                                        then(function (response) {
                                            return response.data;
                                        })
                            }

                            }
                });
                })