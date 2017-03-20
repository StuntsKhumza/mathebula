angular.module('waitingList-app', [])
        .directive('waitingList', function(){
            return {
                restrict:'E',
                controllerAs: 'waitinglistController',
                scope: {},
                templateUrl: 'js/waitinglist/waitinglist.html',
                controller:function(){

                }
            }
        })