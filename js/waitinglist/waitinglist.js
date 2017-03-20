angular.module('waitingList-app', [])
    .directive('waitingList', function () {
        return {
            restrict: 'E',
            controllerAs: 'waitinglistController',
            templateUrl: 'js/waitinglist/waitinglist.html',
            controller: function ($scope) {
 
                this.reloadObj = function(){
                    console.log('test');
                   // $scope.listdt = $scope.queue;
                    
                }

               // $scope.listdt = [
                    //  { title: 'Nkosinathi Khumalo'}
                    //  { title: 'Zama Gumede'},
                    //  { title: 'Sindi Hlao'},
                    //  { title: 'Thandi Tlalo'}
                //]
            }
        }
    })