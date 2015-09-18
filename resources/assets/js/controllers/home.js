angular.module('crm.controllers')
    .controller('HomeController', ['$scope','$rootScope','$cookies', function($scope, $rootScope, $cookies){



        $scope.groupname = $cookies.getObject('user').group.name;
    }]);
