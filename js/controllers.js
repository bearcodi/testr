(function ($, angular) {
    'use strict';

    var testrControllers = angular.module('testrControllers', ['testrServices']);

    testrControllers.controller('ItemsCtrl', ['$scope', '$http', 'testItems', function ($scope, $http, testItems) {
        $scope.tests = testItems.get();
    }]);
    
    testrControllers.controller('ItemCtrl', ['$scope', '$routeParams', 'testItems', 'uuid', function ($scope, $routeParams, testItems, uuid) {
        $scope.defaults = {
            'id' : uuid.get()
        };
        $scope.itemId = $routeParams.itemId;
        $scope.audiences = ['internal', 'external'];
        //$scope.test = testItems.query($routeParams.itemId);
        $scope.update = function ($item) {
            console.log(angular.extend($scope.defaults, angular.copy($item)));
        };
    }]);
    
}(jQuery, angular));
