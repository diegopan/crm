(function () {

    'use strict';

    var app = angular.module('crm');
    app.config(['$routeProvider', 'USER_ROLES',
        function ($routeProvider, USER_ROLES) {

            /*
             * Route Configuration...
             */
            $routeProvider
                .otherwise({redirectTo: '/login'})

                .when('/login', {
                    templateUrl: 'build/views/login.html',
                    controller: 'LoginController'

                })

                .when('/logout', {
                    templateUrl: 'build/views/login.html',
                    controller: 'LogoutController'

                });

        }]);
})();