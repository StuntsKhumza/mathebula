angular.module('myQ-app', ['comments-app',
    'profilePictureApp',
    'userProfile-General-app',
    'userProfile-Address-app',
    'userProfile-pastMedicalHistory-app',
    'save-app'
])

    .directive('myQ', function () {

        return {
            restrict: "E",
            templateUrl: "js/myQ/myQ.html",
            controllerAs: 'myQController',
            controller: function ($scope, $http, serviceSession) {

                var self = this;

                self.results = [];

                self.spinner = true;

                getMyList();

                function getMyList() {

                    self.btnText = "please wait...";

                    self.spinner = true;

                    var formData = new FormData();

                    formData.append("q", "getMyQueue");

                    var data = serviceSession.callService(formData);

                    data.then(function (res) {

                        if (res.status > 200) {

                        } else {

                            self.results = res.data;

                        }

                        self.spinner = false;
                        self.searching = false;

                    });
                }

                self.setClient = function (id) {


                    var o = find_Item(self.results, id);

                    //$scope.loginObj.clientSelected = true;

                    if (o != null) {
                        $scope.userObj.client = o;
                        $scope.userObj.clientSet = true;
                    }



                }

                function find_Item(list, query) {

                    var result = _.find(list, function (o) {
                        return o.PATIENTID == query;
                    });

                    return result;

                }

            }

        }

    })