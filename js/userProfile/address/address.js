angular.module('userProfile-Address-app', [])

    .directive('addressTab', function () {

        return {
            restrict: "E",
            templateUrl: "js/userProfile/address/address.html",
            controllerAs: 'addressCtr',
            controller: function ($scope) {
                var self = this;
                self.examining = "";
                self.setClick = function(c){
                    self.examining = c;
                }

            }

        }

    })