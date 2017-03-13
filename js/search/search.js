angular.module('search-app', ['session-app'])
    .directive(
    'search', function () {
        return {
            restrict: 'E',
            templateUrl: "js/search/search.html",
            controllerAs: 'searchCtr',
            controller: function ($scope, $http, serviceSession) {
                //searchCtr.searchObj
                //  $scope.userObj.search_done = false;
                $scope.searching = false;
                var self = this;

                self.showmsg = "";

                self.searchObj = {
                    file_number: '',
                    id_number: ''
                }

                self.search_complete = false;

                $scope.results = [
                    /*   {id:13584354, name:"Nkosinathi Khumalo"},
                     {id:13584354, name:"Nkosinathi Khumalo"},
                     {id:13584354, name:"Nkosinathi Khumalo"},
                     {id:13584354, name:"Nkosinathi Khumalo"},
                     {id:13584354, name:"Nkosinathi Khumalo"},
                     {id:13584354, name:"Nkosinathi Khumalo"}, */
                ]
                //ng-if="!loginObj.clientSelected"
                var obj = [{ id: 135823354, name: "Nkosinathi Khumalo" }, { id: 135154, name: "Zamani Gumede" }, { id: 135434354, name: "Mduduzi Memela" }/*
                    { id: 135845454, name: "Nkosinathi Khumalo" },
                    { id: 133341554, name: "Nkosinathi Khumalo" },
                    { id: 13584356734, name: "Nkosinathi Khumalo" } */,

                ];

                //load search 

                $scope.search = function (id) {
                    var searchV = "";
                    var search_key_data;
                    if (self.searchObj.file_number.length == 0 && self.searchObj.id_number.length == 0) {

                        self.showmsg = "Please ensure that you provide a File or ID Number below";

                        return;
                    } else {


                        if (self.searchObj.file_number.length > 0) {

                            searchV = "file number: '" + self.searchObj.file_number + "'";
                            search_key_data = self.searchObj.file_number;
                        } else if (self.searchObj.id_number.length > 0) {

                            searchV = "id number: '" + self.searchObj.id_number + "'";
                            search_key_data = self.searchObj.id_number;
                        }
                        
                        $scope.searching = true;
                        self.search_complete = false;

                        var search_data = { search_key: search_key_data }
                        var search_call = serviceSession.search_profile(search_data);
                        
                        search_call.then(function (res) {

                            self.showmsg2 = "Showing results for " + searchV;
                           $scope.results = res.data;
                            
                            self.searchObj.file_number = "";
                            self.searchObj.id_number = "";
                            self.search_complete = true;
                            $scope.searching = false;
                        });

                    }


return;
                    $http.get('php/service.php?q=test')
                        .then(function () {

                            $scope.searching = false;



                            self.showmsg2 = "Showing results for " + searchV;

                            self.searchObj.file_number = "";
                            self.searchObj.id_number = "";

                            self.search_complete = true;
                        })

                    $scope.results = obj;

                    var o = find_Item(obj, id);

                    if (o != null) {

                        var x = find_Item($scope.results, id);

                        if (x == null) {
                            $scope.results.push(o);

                        }


                    } else {

                        console.log("unable to find object");

                    }

                }

                self.clear_search = function () {
                    self.search_complete = false;
                    self.showmsg2 = "";
                    $scope.results = {};
                }

                $scope.setClient = function (id) {

                    var o = find_Item(obj, id);

                    //$scope.loginObj.clientSelected = true;

                    if (o != null) {
                        $scope.userObj.client = o;
                        $scope.userObj.clientSet = true;
                    }
                    console.log($scope.userObj);

                }

                function find_Item(list, query) {

                    var result = _.find(list, function (o) {
                        return o.id == query;
                    });

                    return result;

                }

            }

        }
    })