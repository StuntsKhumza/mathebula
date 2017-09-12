angular.module('ngSearch-app', ['session-app'])
    .directive('ngSearch', function () {

        return {
            restrict: 'E',
            templateUrl: 'js/directives/ngSearch/ngSearch.html',
            controllerAs: 'ngSearchCntr',
            scope: {
                result: '=',
                callBack:'&'
            },
            controller: function ($scope, $http, serviceSession) {

                var self = this;

                self.spinner = false;
                self.searchbar = "";
                self.searchDone = false;
                self.searchResults = [];
                self.search = function () {
                    self.spinner = true;
                    var formdata = new FormData();

                    formdata.append("q", "doSearch");
                    formdata.append("query", self.searchbar);

                    serviceSession.callService(formdata)

                        .then(function (res) {

                            self.spinner = false;
                            self.searchDone = true;
                            self.searchResults = res.data;                           

                        })

                }
                self.setResult = function(data){

                    $scope.result = data;
                    $scope.callBack(data);
                    $('#modalSearch').modal('toggle');

                }
                self.launchSearch = function () {
                    $('#modalSearch').modal('toggle');
                }

            }
        }

    })