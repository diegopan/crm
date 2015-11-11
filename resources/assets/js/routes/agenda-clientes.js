(function () {

    'use strict';

    var app = angular.module('crm');
    app.config(['$routeProvider', 'USER_ROLES',
        function ($routeProvider, USER_ROLES) {

            /*
             * Route Configuration...
             */
            $routeProvider

                .when('/agendamentos', {
                    templateUrl: 'build/views/member/dashboard.html',
                    controller: 'MemberDashboardController',
                    controllerAs: 'Dashboard',
                    data: {
                        authorizedRoles: [USER_ROLES.operador]
                    }
                })

                .when('/carteira', {
                    templateUrl: 'build/views/member/carteira.html',
                    controller: 'MemberCarteiraController',
                    data: {
                        authorizedRoles: [USER_ROLES.operador]
                    }
                })
                .when('/carteira/:portfolioId/edit', {
                    templateUrl: 'build/views/carteira/edit.html',
                    controller: 'CarteiraEditController',
                    data: {
                        authorizedRoles: [USER_ROLES.operador]
                    }
                })

                .when('/carteira/:cliId/history', {
                    templateUrl: 'build/views/carteira/history.html',
                    controller: 'CarteiraHistoryController',
                    data: {
                        authorizedRoles: [USER_ROLES.operador]
                    }
                });

        }]);
})();