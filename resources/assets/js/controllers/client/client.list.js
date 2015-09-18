angular.module('crm.controllers')
    .controller('ClientListController', ['$scope','Client', function($scope, Client){

        $scope.clients = Client.query();


    }]);
