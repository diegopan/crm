angular.module('crm.controllers')
    .controller('TeamNewController', ['$scope', '$location', 'Team', function ($scope, $location, Team) {

        $scope.team = new Team();

        $scope.save = function () {

            if ($scope.form.$valid) {
                $scope.team.$save().then(function () {
                    $location.path('/teams');
                }, function (response) {
                    console.log(response);
                });
            }

        };

    }]);
