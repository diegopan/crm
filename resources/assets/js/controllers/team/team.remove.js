angular.module('crm.controllers')
    .controller('TeamRemoveController', ['$scope', '$location', '$routeParams', 'Team',
        function ($scope, $location, $routeParams, Team) {

        $scope.team = Team.get({id: $routeParams.id});

        $scope.remove = function () {

            if ($scope.form.$valid) {
                $scope.team.$delete().then(function(){
                    $location.path('/teams');
                });
            }

        };

    }]);
