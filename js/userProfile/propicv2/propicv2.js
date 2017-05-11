angular.module('profilePictureApp', [])
    .directive('profilePicture', function () {
        return {
            restrict: 'E',
            templateUrl: 'js/userProfile/propicv2/propicv2.html',
            controller: function ($scope, fileUpload) {
                $scope.imgPath = "";

                $scope.uploading = false;
                $scope.submit = function () {

                     $scope.uploading = true;

                    //php/FileUpload.php
                    var file = $scope.myFile;
                    var response = fileUpload.uploadFileToUrl(file, 'php/FileUpload.php');

                    response.then(function (res) {

                        //console.log(res.data);
                         $scope.uploading = false;

                        $scope.imgPath = res.data.path;

                    })//success response

                }

            }
        }
    })
    .directive('fileModel', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;

                element.bind('change', function () {
                    scope.$apply(function () {
                        modelSetter(scope, element[0].files[0]);
                    });
                });
            }
        };
    }])
    .service('fileUpload', ['$http', function ($http) {
        this.uploadFileToUrl = function (file, uploadUrl) {
            var fd = new FormData();
            fd.append('file', file);

             return $http.post(uploadUrl, fd, {
                transformRequest: angular.identity,
                headers: { 'Content-Type': undefined }
            })

            /*  .success(function (res) {

                  return res;
              })

              .error(function (res) {

                  return res;
              }); */
        }
    }]);