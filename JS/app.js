
/***********************************************************************************************
 * Angular template - Angular example (user and Digital assets management) with a full native php REST API Angular friendly
 *   app.js Controller of Angular project
 *   Version: 0.1.2
 * Copyright 2016 Thomas DUPONT
 * MIT License
 ************************************************************************************************/

(function () {
  'use strict';

    angular.module('routeApp', [
        'ngRoute',
        'ngSanitize'
    ]).config(['$routeProvider',
        function($routeProvider, IdleProvider, KeepaliveProvider) {
            $routeProvider
            .when('/login', {
                templateUrl: 'login/login.html',
                controller: 'loginCtrl'
            })
            .when('/contact/:msg?', {
                templateUrl: 'contact.html',
                controller: 'contactCtrl'
            })
            .when('/register', {
                templateUrl: 'login/register.html',
                controller: 'loginCtrl'
            })
            .when('/home', {
                templateUrl: 'home.html'
            })
            .otherwise({
                templateUrl: 'home.html'
            });

        }
    ]);

})();
