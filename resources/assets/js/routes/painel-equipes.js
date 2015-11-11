(function () {

    'use strict';

    var app = angular.module('crm');
    app.config(['$routeProvider', 'USER_ROLES',
        function ($routeProvider, USER_ROLES) {

            /*
             * Route Configuration...
             */
            $routeProvider

                .when('/painel-equipe', {
                    templateUrl: 'build/views/painel-equipe/dashboard.html',
                    controller: 'PainelEquipeController',
                    controllerAs: 'PainelEquipe',
                    data: {
                        authorizedRoles: [USER_ROLES.lider,USER_ROLES.admin]
                    }
                })

        }]);
})();