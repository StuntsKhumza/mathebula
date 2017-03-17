angular.module('search-app', ['session-app', 'ngCookies'])
    .directive(
    'search', function () {
        return {
            restrict: 'E',
            templateUrl: "js/search/search.html",
            controllerAs: 'searchCtr',
            controller: function ($scope, $http, serviceSession, $cookies) {

                $scope.searching = false;
                var self = this;

                self.showmsg = "";

                self.searchObj = {
                    file_number: '',
                    id_number: ''
                }

                self.search_complete = false;

                $scope.results = [
                ]

                var getHistory = $cookies.get('dr_search_history');

                if(getHistory != null){

                    getHistory = b64DecodeUnicode(getHistory);

                    $scope.results = JSON.parse(getHistory);
                }

                //load search 

                $scope.search = function () {
                    var validate = validate_input();

                    if (!validate.status){
                        self.showmsg = validate.msg;
                        return;
                    } else {
                        self.showmsg = "";
                    }
                   
                    var searchV = "";
                    var search_key_data;
                    var search_type = '';
                  
                        if (self.searchObj.file_number.length > 0) {

                            searchV = "file number: '" + self.searchObj.file_number + "'";
                            search_key_data = self.searchObj.file_number;
                            search_type = "card";
                        } else if (self.searchObj.id_number.length > 0) {

                            searchV = "id number: '" + self.searchObj.id_number + "'";
                            search_key_data = self.searchObj.id_number;
                            search_type = "id";
                        }

                        $scope.searching = true;
                        self.search_complete = false;

                        var search_data = { search_key: search_key_data, "search_type": search_type }
                        var search_call = serviceSession.search_profile(search_data);

                        search_call.then(function (res) {

                            self.showmsg2 = "Showing results for " + searchV;
                            $scope.results = res.data;
                      
                            var str = b64EncodeUnicode(JSON.stringify(res.data));
                            $cookies.put('dr_search_history', str);
                         
                            self.searchObj.file_number = "";
                            self.searchObj.id_number = "";
                            self.search_complete = true;
                            $scope.searching = false;
                        });

                    


                    return;
                   

                }

                function validate_input(){

                    var result = {
                        status: true,
                        msg: ''
                    };

                    //check if filled in
                    if(self.searchObj.file_number.length == 0 && self.searchObj.id_number.length == 0){
                            result.status = false;
                            result.msg = "Please ensure that you provide a File or ID Number below";
                    }

                    
                    if (self.searchObj.file_number.length > 0 && result.status == true){

                        if(self.searchObj.file_number.length < 2){
                            result.status = false;
                            result.msg = "Please ensure you provide at least 2 characters for File Search";
                        }

                    }

                    if (self.searchObj.id_number.length > 0 && result.status == true){

                        if(self.searchObj.id_number.length < 6){
                            result.status = false;
                            result.msg = "Please ensure you provide 6 digit ID Number";
                        }

                    }


                    return result;

                }

                self.clear_search = function () {
                    self.search_complete = false;
                    self.showmsg2 = "";
                    self.showmsg = "";
                    $scope.results = {};
                }

                $scope.setClient = function (id) {

                    var o = find_Item($scope.results, id);

                    //$scope.loginObj.clientSelected = true;

                    if (o != null) {
                        $scope.userObj.client = o;
                        $scope.userObj.clientSet = true;
                    }
                

                }

                function find_Item(list, query) {

                    var result = _.find(list, function (o) {
                        return o.ID == query;
                    });

                    return result;

                }

                function b64EncodeUnicode(str) {
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function(match, p1) {
        return String.fromCharCode('0x' + p1);
    }));
}

function b64DecodeUnicode(str) {
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}

            }

        }
    })