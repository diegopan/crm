angular.module('crm.controllers')
    .controller('LogoutController', ['$window', '$cookies', '$rootScope', 'AUTH_EVENTS', 'AuthService',
        function ( $window, $cookies, $rootScope, AUTH_EVENTS, AuthService) {

            AuthService.logout();

            $rootScope.$broadcast(AUTH_EVENTS.logoutSuccess);


            $window.location.href = '/#/login';

        }]);
