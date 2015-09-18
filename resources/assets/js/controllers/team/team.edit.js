angular.module('crm.controllers')
    .controller('TeamEditController', ['$scope', '$location', '$routeParams', 'Team',
        function ($scope, $location, $routeParams, Team) {

        $scope.team = Team.get({id: $routeParams.id});

        $scope.save = function () {

            if ($scope.form.$valid) {
                Team.update({id: $scope.team.id},$scope.team, function(){
                    $location.path('/teams');
                });

            }

        };

    }]);
