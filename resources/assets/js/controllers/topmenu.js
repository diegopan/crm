angular.module('crm.controllers')
    .controller('TopMenuController', ['$scope','$rootScope','$cookies','OAuth','appConfig', function($scope, $rootScope, $cookies, OAuth, appConfig){


        if( OAuth.isAuthenticated()){
            $scope.showMenu = true;
        }else{
            $scope.showMenu = false;
        }

    }]);
