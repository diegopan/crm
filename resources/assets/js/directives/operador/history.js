angular.module('crm.directives')
    .directive('carteiraHistory', function () {
        return {
            restrict: 'E',
            replace: true,
            templateUrl: 'build/views/directives/operador/carteira/history.html',
        }
    });
