angular.module('userProfile-General-app', [])

    .directive('generalTab', function () {

        return {
            restrict: "E",
            templateUrl: "js/userProfile/general/general.html",
            controllerAs: "generalTabCntr",
            controller: function ($scope) {

            

            }

        }

    })