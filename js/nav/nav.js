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
            controller: function ($scope, $state, $http, $cookies) {

                var self = this;

                self.linksObj = {
                    brand: {
                        title: "Dr's Co",
                        img:'img/1477676379_icon-57.png'

                    },
                    links: [
                        { title: 'Home', link_state: '1', state_name: 'profiles' },
                        { title: 'New', link_state: '0' }]
                }

                self.logOff = function () {
                        console.log('test');
                        $cookies.remove('m_userid');
                        $http.get('php/service.php?q=logOff');

                        $state.go('login');
                    }

                console.log('2');


                function getName() {

                    //    return mySession.UserObj;

                }
                self.logout = function () {


                    $state.go('login');
                }

            }
        }
    })