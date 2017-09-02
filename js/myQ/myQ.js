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

                function getMyList(){

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

            }

        }

    })