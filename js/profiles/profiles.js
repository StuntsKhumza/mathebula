angular.module('profiles-app', ['ui.router', 'search-app', 'userProfile-app', 'addUserProfile-app', 'session-app'])

    .config(function ($stateProvider, $urlRouterProvider) {

        $stateProvider
            .state('profiles', {
                controllerAs: 'profilesController',
                templateUrl: "js/profiles/profiles.html",
                url: '/profiles',
                controller: function ($scope, $state, session, $http, $anchorScroll, serviceSession) {

                    var self = this;
                    self.activeuser = "";
                    self.activeuser_firstname = "";
                    var currentUser = serviceSession.getActiveProfile();

                    currentUser.then(function(res){
                        self.activeuser = res.data[0].FIRSTNAME + " " + res.data[0].LASTNAME;
                        self.activeuser_firstname = res.data[0].FIRSTNAME;
                        console.log(res.data[0]);
                    })


                    $scope.userObj = {
                        search_done: false,
                        client: {},
                        clientSet: false,
                        activeProfileTab: 1
                    }

                    if (session.status != 'true') {

                        $state.go('login');

                    }

                    $scope.logOff = function () {
                        console.log('test');
                        $http.get('php/service.php?q=logOff');

                        $state.go('login');
                    }


                    $scope.navTo = function(id){

                        $anchorScroll(id);

                    }

                    $scope.back_to_search = function () {

                        $scope.userObj.clientSet = false;
                        $scope.userObj.client = null;

                    }

                },
                resolve: {
                    session: function ($http) {
                        return $http.get('php/service.php?q=getSession')
                            .then(function (response) {
                                return response.data;
                            })
                    }
                }
            })
    })
