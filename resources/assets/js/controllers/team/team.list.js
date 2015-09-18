angular.module('crm.controllers')
    .controller('TeamListController', ['$scope','Team', function($scope, Team){

        $scope.teams = Team.query();

    }]);
