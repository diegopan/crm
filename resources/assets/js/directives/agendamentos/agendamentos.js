(function () {
    'use strict';
    angular.module('crm.directives')
        .directive('atendimentosAgendados', function () {
            return {
                restrict: 'E',
                replace: true,
                templateUrl: 'build/views/directives/agendamentos/atendimentos.agendados.html',
            }
        });

})();

