angular.module('main-app', ['ui.router', 'login-app', 'profiles-app'])//['landing-app', 'search-app'])
    .config(function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/login');
    })

