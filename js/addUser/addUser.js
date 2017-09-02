angular.module('addUserProfile-app', ['ui.router', 'profilePictureApp',])

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
                controller: function ($scope, $state, $http, $anchorScroll) {

                        var self = this;
    

                        $scope.genNumber = function(id){

                            switch(id){
                                case 1:
                                     $scope.filenumber = "C1234";
                                break;

                                case 2:
                                     $scope.filenumber = "M1234";
                                break;
                            }

                           
                        }

                } /*,
                resolve: {
                    session: function ($http) {
                        return $http.get('php/service.php?q=getSession')
                            .then(function (response) {
                                return response.data;
                            })
                    }
                } */
            })
    })