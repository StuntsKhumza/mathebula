angular.module('addUserProfile-app', ['ui.router'])

 /*       .directive('addUserProfile', function () {

            return {
                restrict: "E",
                templateUrl: "js/addUser/addUser.html",
                controller: function ($scope) {

                }

            }

        })
*/
        .config(function ($stateProvider, $urlRouterProvider) {

        $stateProvider
            .state('adduserprofile', {
                controllerAs: 'adduserprofileController',
                templateUrl: "js/addUser/addUser.html",
                url: '/adduserprofile',
                controller: function ($scope, $state, session, $http, $anchorScroll) {


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