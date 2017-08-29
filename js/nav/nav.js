angular.module('nav-app', ['ngCookies'])
        .directive('navigationNav', function () {
            return {
                restrict: 'E',
                templateUrl: 'js/nav/nav.html',
                controllerAs: 'navCtr',
                scope: {
                    username: '=',
                    linksObj: '='
                }
                ,
                controller: function ($state, $http, $cookies) {

                    var self = this;
                    self.userName = "";
                    self.spinner = true;
                    
                    $http.get('php/service.php?q=getUserName')
                            .then(function(response){
                                self.userName = response.data.username;
                        self.spinner = false;
                            })
                    
                    self.linksObj = {
                        brand: {
                            title: "Dr's Co",
                            img: 'img/1477676379_icon-57.png'

                        },
                        links: [
                            {title: 'Home', link_state: '1', state_name: 'profiles'},
                            {title: 'New', link_state: '0'}]
                    }

                    self.logOff = function () {

                        $cookies.remove('m_userid');
                        $http.get('php/service.php?q=logOff');

                        $state.go('login');
                    }
                    
                    

                    self.addPatient = function(){
                        $state.go('adduserprofile');
                    }


                    self.openBookings = function () {

                      window.open("/mathebula/viewBookings", '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');

                    }


                }
            }
        })