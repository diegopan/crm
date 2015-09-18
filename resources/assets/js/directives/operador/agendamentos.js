(function () {
    'use strict';
    angular.module('crm.directives')
        .directive('opAgendaList', function () {
            return {
                restrict: 'E',
                replace: true,
                templateUrl: 'build/views/directives/operador/agendamentos/list.html',
            }
        });

})();

(function () {
    'use strict';

    angular.module('crm.directives').directive('focusMe', ['$timeout', function ($timeout) {
        return {
            scope: {trigger: '@focusMe'},
            link: function (scope, element) {
                scope.$watch('trigger', function (value) {
                    if (value === "true") {
                        // console.log('trigger',value);
                        $timeout(function () {
                            element[0].focus();
                        });
                    }
                });
            }
        };
    }]);

})();

