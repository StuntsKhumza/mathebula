angular.module('addUserProfile-app', ['ui.router', 'profilePictureApp'])

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
            .state('addMedcine', {
                controllerAs: 'addMedcineController',
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