angular.module('save-app', [])
.directive('save', function(){

    return {
        restrict: 'E',
        templateUrl: 'js/directives/save/save.html',
        controllerAs: 'saveContr',
        controller: function($scope){

        }
    }

})