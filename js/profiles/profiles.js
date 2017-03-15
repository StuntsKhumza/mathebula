angular.module('profiles-app', ['ui.router', 'search-app', 'userProfile-app', 'addUserProfile-app', 'session-app', 'ngCookies', 'nav-app'])

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

                    var user_cookie = $cookies.get('m_userid');

                    if(user_cookie == null){

                        $http.get('php/service.php?q=logOff');

                        $state.go('login');
                        return;
                    }

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

                    $scope.logOff = function () {
                        console.log('test');
                        $cookies.remove('m_userid');
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

                }
            })
    })
