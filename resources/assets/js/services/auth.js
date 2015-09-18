(function () {
    'use strict';


    angular.module('crm.services')
        .factory('AuthService', ['$resource', '$cookies', 'appConfig', 'OAuth', 'User',
            function ($resource, $cookies, appConfig, OAuth, User) {


                var authService = {};


                authService.login = function (credentials) {


                    return OAuth.getAccessToken(credentials)
                        .then(function (response) {

                            return authService.getAuthenticated();

                        }, function (response) {
                            return response;
                        });
                };


                authService.logout = function () {

                    if ($cookies.getObject('user')) {

                        $cookies.remove('user');
                    }
                    if ($cookies.getObject('token')) {

                        $cookies.remove('token');
                    }

                };


                authService.isAuthenticated = function () {
                    return !!OAuth.isAuthenticated();
                };


                authService.isAuthorized = function (authorizedRoles) {
                    if (!angular.isArray(authorizedRoles)) {
                        authorizedRoles = [authorizedRoles];
                    }


                    return (authService.isAuthenticated() && authorizedRoles.indexOf($cookies.getObject('user').group.name) !== -1);
                };


                authService.getAuthenticated = function () {

                    return User.authenticated().$promise;

                };


                return authService;

            }]);

})();

(function () {
    'use strict';

    angular.module('crm.services')

        .factory('AuthInterceptor',[ '$rootScope', '$q', 'AUTH_EVENTS', '$injector',
            function ($rootScope, $q, AUTH_EVENTS, $injector) {

                var sessionRecoverer = {
                    responseError: function (response) {
                        // If Token has expired
                        if (response.status == 401 && response.data.error == 'access_denied') {

                            $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);

                            var deferred = $q.defer();
                            var $http = $injector.get('$http');

                            // Use refresh token to generate a new token
                            // returns a promise
                            $injector.get('OAuth').getRefreshToken().then(deferred.resolve, deferred.reject);

                            // When the session recovered, make the same backend call again and chain the request
                            return deferred.promise.then(function () {
                                return $http(response.config);
                            });
                        }




                        return $q.reject(response);
                    }

                };

                return sessionRecoverer;

            }]);

})();





