angular.module('waitingList-app', [])
    .directive('waitingList', function () {
        return {
            restrict: 'E',
            controllerAs: 'waitinglistController',
            templateUrl: 'js/waitinglist/waitinglist.html',
            controller: function ($scope) {

                this.action = function(index){
                    $scope.queue.obj.splice(index,1);
                     console.log($scope.queue.obj);
                }
                
            }

        }
    })