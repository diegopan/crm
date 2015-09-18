angular.module('crm.controllers')
    .controller('ClientNewController', ['$scope', '$location', 'Client', function ($scope, $location, Client) {

        $scope.client = new Client();

        $scope.save = function () {

            if ($scope.form.$valid) {
                $scope.client.$save().then(function () {
                    $location.path('/clients');
                }, function (response) {
                    console.log(response);
                });
            }

        };

    }]);
