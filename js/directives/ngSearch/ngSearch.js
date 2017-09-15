angular.module('ngSearch-app', ['session-app'])
    .directive('ngSearch', function () {

        return {
            restrict: 'E',
            templateUrl: 'js/directives/ngSearch/ngSearch.html',
            controllerAs: 'ngSearchCntr',
            scope: {
                result: '=',
                callBack: '&'
            },
            controller: function ($scope, $http, serviceSession) {

                var self = this;

                self.spinner = false;
                self.searchName = "";
                self.searchDone = false;
                self.searchResults = [];
                self.searchObj = {
                    name: "",
                    
                }
                function clear() {
                    self.spinner = false;
                    self.searchbar = "";
                    self.searchDone = false;
                    self.searchResults = [];
                    self.searchObj = {
                        searchID: "",
                        file: ""
                    }
                }

                self.search = function () {
                    self.spinner = true;
                    var formdata = new FormData();

                    formdata.append("q", "doSearch");
                    formdata.append("query", self.searchObj.name);

                    serviceSession.callService(formdata)

                        .then(function (res) {

                            self.spinner = false;
                            self.searchDone = true;
                            self.searchResults = res.data;

                        })

                }
                self.kSearch = function(e){

                    if (e.keyCode == 13)
                    {
                        if ( self.searchObj.name.length > 2){
                            self.search();
                        }
                        
                    }

                }
                self.setResult = function (data) {

                    $scope.result.person = data;

                    $scope.callBack();
                    clear();
                    $('#modalSearch').modal('toggle');

                }
                self.launchSearch = function () {
                    $('#modalSearch').modal('toggle');

                }

            }
        }

    })