angular.module('crm.directives')
    .directive('opCarteiraList', function () {
        return {
            restrict: 'E',
            replace: true,
            templateUrl: 'build/views/directives/operador/carteira/list.html',
        }
    });
