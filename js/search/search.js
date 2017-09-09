angular.module('search-app', ['session-app', 'ngCookies'])
        .directive(
                'search', function () {
                    return {
                        restrict: 'E',
                        templateUrl: "js/search/search.html",
                        controllerAs: 'searchCtr',
                        controller: function ($scope, $http, serviceSession, $cookies) {

                            $scope.searching = false;
                            $scope.loadDrs = true;
                            var self = this;
                            self.doctors = [];

                            //getUsersByType
                            var form = new FormData();
                            form.append("q", "getUsersByType");
                            form.append("type", "DOCTOR");

                            serviceSession.callService(form)
                                    .then(function (res) {

                                        self.doctors = res.data;
                                        $scope.loadDrs = false;
                                    })

                            self.showQueue = false;

                            self.showmsg = "";

                            self.searchObj = {
                                file_number: '',
                                id_number: ''
                            }
                          
                            self.search_complete = false;

                            $scope.results = [];

                            var getHistory = getCookie_object('dr_search_history');

                            if (getHistory != null) {
                                $scope.results = getHistory;
                            }

                            var dr_query = getCookie_object('dr_queue');//$scope.queue

                            if (dr_query != null) {}//$scope.queue.obj = dr_query;}
              
              
                            self.show_queue = function () {

                                if (self.showQueue) {
                                    self.showQueue = false;
                                } else {
                                    self.showQueue = true;
                                }

                            }
                            //load search 

                            $scope.search = function () {
                                var validate = validate_input();

                                if (!validate.status) {
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

                                var search_data = {search_key: search_key_data, "search_type": search_type}
                                var search_call = serviceSession.search_profile(search_data);

                                search_call.then(function (res) {

                                    self.showmsg2 = "Showing results for " + searchV;
                                    $scope.results = res.data;

                                    writeCookie_object(res.data, 'dr_search_history');

                                    //var str = b64EncodeUnicode(JSON.stringify(res.data));
                                    //$cookies.put('dr_search_history', str);

                                    self.searchObj.file_number = "";
                                    self.searchObj.id_number = "";
                                    self.search_complete = true;
                                    $scope.searching = false;
                                });

                            }

                            function validate_input() {

                                var result = {
                                    status: true,
                                    msg: ''
                                };

                                //check if filled in
                                if (self.searchObj.file_number.length == 0 && self.searchObj.id_number.length == 0) {
                                    result.status = false;
                                    result.msg = "Please ensure that you provide a File or ID Number below";
                                }


                                if (self.searchObj.file_number.length > 0 && result.status == true) {

                                    if (self.searchObj.file_number.length < 2) {
                                        result.status = false;
                                        result.msg = "Please ensure you provide at least 2 characters for File Search";
                                    }

                                }

                                if (self.searchObj.id_number.length > 0 && result.status == true) {

                                    if (self.searchObj.id_number.length < 6) {
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

                            self.search_key = function (evt) {

                                if (evt.keyCode == 13)
                                    $scope.search();

                            }
                            self.selectedForQ = null;
                            self.addToQue = function (id) {

                                //check if added
                                var o = find_Item($scope.queue.obj, id);

                                if (o == null) {

                                    var o = find_Item($scope.results, id);

                                    if (o != null) {
                                      //  $scope.queue.obj.push(o);
                                    }
                                }

                              
                                self.selectedForQ = find_Item($scope.results, id);
                                console.log(self.selectedForQ );
                                //writeCookie_object($scope.queue.obj, 'dr_queue');

                            }

                            function find_Item(list, query) {

                                var result = _.find(list, function (o) {
                                    return o.PATIENTID == query;
                                });

                                return result;

                            }

                            function writeCookie_object(obj, cookie_name) {
                                var str = b64EncodeUnicode(JSON.stringify(obj));
                                $cookies.put(cookie_name, str);
                            }

                            function getCookie_object(cookie_name) {

                                var cookie = $cookies.get(cookie_name);

                                if (cookie != null) {

                                    cookie = b64DecodeUnicode(cookie);

                                    cookie = JSON.parse(cookie);
                                }

                                return cookie;
                            }

                            function b64EncodeUnicode(str) {
                                return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function (match, p1) {
                                    return String.fromCharCode('0x' + p1);
                                }));
                            }

                            function b64DecodeUnicode(str) {
                                return decodeURIComponent(atob(str).split('').map(function (c) {
                                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                                }).join(''));
                            }
                            
                       
                            self.assignToDr = function(ID){
                                
                                if(self.selectedForQ !== null){
                                     $scope.loadDrs = true;
                                    var formdata = new FormData();
                                    formdata.append("q", "addToQueue");
                                    formdata.append("DRID", ID);
                                    formdata.append("PATIENTID", self.selectedForQ.PATIENTID);
                                    formdata.append("STATUS", "WAITING");
                                    
                                    serviceSession.callService(formdata)

                                            .then(function(res){
                                                //profilesController.addToQueue();
                                                //self.addToQue(ID);
                                                self.loadWaitingList();
                                                $scope.loadDrs = false;

                                            })
                                    
                                } else {
                                    console.log("its null");
                                }
                                
                            }

                            self.loadWaitingList = function(){

                                //queue.obj
                                var formdata = new FormData();
                                formdata.append("q", "loadWaitingList");
                                formdata.append("type", "WAITING");
                                
                                serviceSession.callService(formdata)

                                    .then(function(res){
                                        $scope.queue.obj = res.data;
                                        console.log(res);
                                    })
                                    
                            }

                            self.loadWaitingList();

                        }

                    }
                })