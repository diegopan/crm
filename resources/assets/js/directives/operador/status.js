angular.module('crm.directives')
    .directive('opStatus', function () {
        return {
            restrict: 'E',
            replace: true,
            templateUrl: 'build/views/directives/operador/status/status.html',
        }
    });
