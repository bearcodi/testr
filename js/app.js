(function ($, angular) {
    'use strict';
    
    var testr = angular.module('testrApp', ['ngRoute', 'testrServices', 'testrControllers']);
    
    testr.config(['$routeProvider', function ($routeProvider) {
        $routeProvider.
            when('/dashboard', {
                templateUrl: 'partials/items.htm',
                controller: 'ItemsCtrl'
            }).
            when('/new', {
                templateUrl: 'partials/add-item.htm',
                controller: 'ItemCtrl'
            }).
            otherwise({
                redirectTo: '/dashboard'
            });
    }]);
    
}(jQuery, angular));
