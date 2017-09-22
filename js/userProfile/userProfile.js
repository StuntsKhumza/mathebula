angular.module('userProfile-app', ['comments-app',
    'profilePictureApp',
    'userProfile-General-app',
    'userProfile-Address-app',
    'userProfile-pastMedicalHistory-app',
    'userProfile-ClinicalExam-app',
    'save-app',
    'session-app'
])

    .directive('userProfile', function () {

        return {
            restrict: "E",
            templateUrl: "js/userProfile/userProfile.html",
            controllerAs: 'userProfileController',
            controller: function ($scope, serviceSession, $http, $window) {

                var self = this;
                self.activeTab = 1;
                self.setUser = $scope.userObj.client;
                self.setUser;
                self.dependents = [];
                self.familyfreind = {};
                $scope.tab_count = 1;
                //  console.log(self.setUser);
                loadDependents();
                getFamilyFriend();
                function loadDependents() {

                    var formData = new FormData();

                    formData.append("q", "getDependents");
                    formData.append("MAINID", self.setUser.PATIENTID);

                    serviceSession.callService(formData)
                        .then(function (res) {
                            self.dependents = res;


                        })
                }

                self.generateDrNote = function () {

                    var myd = {
                        q: 'drNote',
                        mappers: {
                            __name__: self.setUser.PATIENTNAME + " " + self.setUser.PATIENTSURNAME,
                            __examfrom__: "15/09/2017",
                            __examto__: "19/09/2017",
                            __fromdate__: "15/09/2017",
                            __todate__: "19/09/2017",
                            __backdate__: "20/09/2017",
                            __illness__: "Patient show severe case of the munchies",
                            __reviewdate__: "14/09/2017"
                        }
                    }

                    $http.post("php/template.php", myd)
                        .then(function (res) {
                            if (res.data.status == 200) {

                                $window.open(res.data.path, '_blank');
                            }
                        })

                }

                function getFamilyFriend() {

                    var data = {
                            q   : 'getFamilyMember',
                            PATIENTID: self.setUser.PATIENTID
                    }

                    serviceSession.callRest(data).

                        then(function (res) {
                            console.log("family friend");
                            console.log(res);
                            if (res.status == 200) {

                                self.familyfreind = res.data;

                            }

                        })

                }

                self.generateDrRefNote = function () {

                    var myd = {
                        q: 'drRefNote',
                        mappers: {

                        }
                    }

                    $http.post("php/template.php", myd)
                        .then(function (res) {
                            if (res.data.status == 200) {

                                $window.open(res.data.path, '_blank');
                            }
                        })

                }

               
                self.return_to_search = function () {
                    $scope.userObj.client = null;
                    $scope.userObj.clientSet = false;
                }

                self.setTab = function (id) {

                    self.activeTab = id;

                }




            }

        }

    })