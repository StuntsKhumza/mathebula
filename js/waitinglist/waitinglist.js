angular.module('waitingList-app', ['ngCookies'])
        .directive('waitingList', function () {
            return {
                restrict: 'E',
                controllerAs: 'waitinglistController',
                templateUrl: 'js/waitinglist/waitinglist.html',
                controller: function ($scope, $cookies) {

                this.cookieObject = null;

                    this.action = function (itemID) {
                        //   $scope.queue.obj.splice(index, 1);

                        var cookie = $cookies.get("dr_queue");

                        this.cookieObject = _decodeCookieObject(cookie);
                        
                       
                        var index = _find_ItemIndexByID(this.cookieObject, itemID);
                        
                       
                        this.cookieObject.splice(index,1);
                        
                        _writeCookie_object(this.cookieObject, "dr_queue", $cookies);
                       
                      
                        $scope.queue.obj.splice(index, 1);
                        
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


                }



            }
        })