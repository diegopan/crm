angular.module('crm.controllers')
    .controller('PortfolioRemoveController', ['$scope', '$location', '$routeParams', 'Portfolio',
        function ($scope, $location, $routeParams, Portfolio) {

        $scope.portfolio = Portfolio.get({id: $routeParams.id});

        $scope.remove = function () {

            if ($scope.form.$valid) {
                $scope.portfolio.$delete().then(function(){
                    $location.path('/carteiras');
                });
            }

        };

    }]);
