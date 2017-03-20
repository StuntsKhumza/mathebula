angular.module('waitingList-app', [])
    .directive('waitingList', function () {
        return {
            restrict: 'E',
            controllerAs: 'waitinglistController',
            templateUrl: 'js/waitinglist/waitinglist.html',
            controller: function ($scope) {

            /*    $scope.queue = {
                    obj: [
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' },
                        { FIRSTNAME: 'Nkosinathi', LASTNAME: 'Khumalo' }
                    ]
                };*/
            }

        }
    })