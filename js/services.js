(function ($, angular) {
    'use strict';
    
    var testrServices = angular.module('testrServices', ['ngResource']);
    
    testrServices.factory('testItems', ['$resource', function testItemsFactory($resource) {
        return $resource('api/tests', {}, {
        });
    }]);
    
    testrServices.factory('uuid', function uuidFactory() {
        var s4 = function () {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        };
        
        return {
            'get' : function () {
                return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                    s4() + '-' + s4() + s4() + s4();
            }
        };
    });
    
}(jQuery, angular));
