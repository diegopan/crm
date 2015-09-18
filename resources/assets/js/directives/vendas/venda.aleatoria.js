(function () {
    'use strict';
    angular.module('crm.directives')
        .directive('vendaAleatoria', function () {
            return {
                restrict: 'E',
                replace: true,
                templateUrl: 'build/views/directives/vendas/venda.aleatoria.html',
            }
        });

})();

