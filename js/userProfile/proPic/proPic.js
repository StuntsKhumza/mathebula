angular.module('profilePicture', ['profilePicturev2'])

        .directive('proPic', function () {
            return {
                restrict: 'E',
                scope: {
                    imgtwo: '=imagetwo',
                },
                link: function (scope, element, attrs, $http) {

                    scope.action = "edit"
                    scope.showEdit = "no";
                    var action = "edit";

                    scope.x = function () {
                        if (scope.showEdit == 'no') {

                            scope.showEdit = "yes";
                            scope.action = "cancel"
                        } else {
                            scope.showEdit = "no";
                            scope.action = "edit"
                        }
                    }
                },
                templateUrl: 'js/userProfile/proPic/proPic.html'
            }
        });
//js/directives/userprofile/tabs/generalTab/
//js/directives/userprofile/tabs/generalTab/propic