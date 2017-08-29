angular.module('main-app', ['ui.router', 'login-app', 'profiles-app','session-app'])//['landing-app', 'search-app'])
        .config(function ($stateProvider, $urlRouterProvider) {
            $urlRouterProvider.otherwise('/login');
        })

//