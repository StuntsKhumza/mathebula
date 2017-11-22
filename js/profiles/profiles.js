angular.module('profiles-app', [
    'ui.router',
    'search-app',
    'userProfile-app',
    'addUserProfile-app',
    'session-app',
    'ngCookies',
    'nav-app',
    'waitingList-app', "myQ-app","ngSearch-app",
])
    .config(function ($stateProvider, $urlRouterProvider) {

        $stateProvider
            .state('profiles', {
                controllerAs: 'profilesController',
                templateUrl: "js/profiles/profiles.html",
                url: '/profiles',
                controller: function ($scope, $state, $http, $anchorScroll, serviceSession, $cookies, getActiveSession) {


                    if (getActiveSession.data.status == "false") {
                        $state.go("login");
                        return;
                    }

                    var self = this;
                    self.testF = {}
                    self.activeuser = "";
                    self.activeuser_firstname = "";
                    self.spinner = true;


                    $scope.selectedForQ = {
                        patient: "",
                        action: ''
                    };

                    $scope.watingListObj = {
                        action: "queueAdd"
                    }

                    self.doctors = [];

                    self.loadDrs = false;

                    self.navbtns = {
                        active: 'HOME',
                        hide: {
                            bookings: false,
                            queu: false,
                        }
                    }

                    self.userRoles = serviceSession.get_roles();

                    self.access = {
                        admin: isMember('[admin]', self.userRoles),
                        doctor: isMember('[doctor]', self.userRoles),
                        reception: isMember('[reception]', self.userRoles)

                    }

                    loadDoctors();

                    $scope.queue = {
                        obj: []

                    };

           

                    var call = serviceSession.get_roles();

                    var user_cookie = $cookies.get('m_userid');

                    if (user_cookie === null) {

                        $http.get('php/service.php?q=logOff');

                        $state.go('login');
                        return;
                    }


                    self.assignToDr = function (ID) {

                        if ($scope.selectedForQ.patient !== null) {
                            self.loadDrs = true;
                            var formdata = new FormData();
                            formdata.append("q", "addToQueue");
                            formdata.append("DRID", ID);
                            formdata.append("action", $scope.selectedForQ.action);
                            formdata.append("PATIENTID", $scope.selectedForQ.patient.PATIENTID);

                            if ($scope.selectedForQ.action !== "ADD") {

                                formdata.append("QID", $scope.selectedForQ.patient.QID);
                            }

                            formdata.append("STATUS", "WAITING");

                            serviceSession.callService(formdata)

                                .then(function (res) {

                                    self.loadWaitingList();
                                    self.loadDrs = false;
                                    $('#openEditQueModal').modal('toggle');

                                })

                        } else {
                            console.log("its null");

                        }

                    }

                    self.loadWaitingList = function () {

                        //queue.obj
                        var formdata = {

                            q: "loadWaitingList",
                            type: 'WAITING'

                        }

                        serviceSession.callRest(formdata)

                            .then(function (res) {

                                $scope.queue.obj = res.data;

                            })

                    }

                    self.loadWaitingList();

                    function loadDoctors() {
                        //getUsersByType
                        var form = new FormData();
                        form.append("q", "getUsersByType");
                        form.append("type", "DOCTOR");

                        //load 
                        serviceSession.callService(form)
                            .then(function (res) {

                                self.doctors = res.data;
                                $scope.loadDrs = false;
                            })
                    }

                    $scope.userObj = {
                        search_done: false,
                        client: {},
                        clientSet: false,
                        activeProfileTab: 1
                    };

                    $scope.logOff = function () {

                        $cookies.remove('m_userid');
                        $http.get('php/service.php?q=logOff');

                        $state.go('login');
                    };


                    $scope.navTo = function (id) {

                        $anchorScroll(id);

                    };

                    $scope.back_to_search = function () {

                        $scope.userObj.clientSet = false;
                        $scope.userObj.client = null;

                    };

                },
                resolve: {
                    getActiveSession: function ($http) {
                        return $http.get('php/service.php?q=getSession')
                        then(function (response) {
                            return response.data;
                        })
                    }

                }
            });
    })