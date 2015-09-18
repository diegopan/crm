angular.module('crm.controllers')
    .controller('ClientRemoveController', ['$scope', '$location', '$routeParams', 'Client',
        function ($scope, $location, $routeParams, Client) {

        $scope.client = Client.get({id: $routeParams.id});

        $scope.remove = function () {

            if ($scope.form.$valid) {
                $scope.client.$delete().then(function(){
                    $location.path('/clients');
                });
            }

        };

    }]);
