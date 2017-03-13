angular.module('profilePicturev2', [])
        .directive('fileModel', ['$parse', function ($parse) {
                return {
                    restrict: 'E',
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

                    var call = $http.post(uploadUrl, fd, {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                    })
                    console.log(fd);
                    return call;
                }
            }]);

            