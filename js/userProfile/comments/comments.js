angular.module('comments-app', [])
        .directive('comments', function () {
            return {
                restrict: 'E',
                templateUrl: 'js/userProfile/comments/comments.html',
                scope: {
                    //chatsObj: '='
                },
                controller: function ($scope, $http) {

                    $scope.chatsObj = [{firstname: 'Nathi', imgsrc: 'img/Albert-Einstein jpg.jpg', comment: 'Patient had flu'}, {firstname: 'Nathi', imgsrc: 'img/Albert-Einstein jpg.jpg', comment: 'comment here'}]

                }
            }
        })