/*
 * Global Module
 */
var app = angular.module('crm', [
    'ngRoute',
    'angular-oauth2',
    'crm.controllers',
    'crm.services',

]);

/*
 * Controllers Module
 */
angular.module('crm.controllers', [
    'angular-oauth2',
    'ngMessages',
    'ngPapaParse',
    'ngSanitize',
    'ui.select',
    'crm.directives',
    'ui.slimscroll',
    'ngAnimate',
    'ui.bootstrap',
    'angular-toArrayFilter',
    'datatables',
    'datatables.bootstrap',
    "ui.bootstrap.typeahead",
    "ui.bootstrap.tooltip",
    "ui.bootstrap.tpls"

]);

/*
 * Services Module
 */
angular.module('crm.services', [
    'ngResource',

]);


/*
 * Directives Module
 */
angular.module('crm.directives', []);


app.constant('AUTH_EVENTS', {
    loginSuccess: 'auth-login-success',
    loginFailed: 'auth-login-failed',
    logoutSuccess: 'auth-logout-success',
    sessionTimeout: 'auth-session-timeout',
    notAuthenticated: 'auth-not-authenticated',
    notAuthorized: 'auth-not-authorized '
});


app.constant('USER_ROLES', {
    all: '*',
    admin: 'CCMZ_Admin',
    operador: 'CCMZ_Operador',
    lider: 'CCMZ_Lider',
    guest: 'guest'
});


/*
 * CRM DEFAULT CONFIGS
 */
app.provider('appConfig', function () {
    var config = {
        baseUrl: 'http://localhost:8000'
    };

    return {
        config: config,
        $get: function () {
            return config;
        }
    };
});

app.config(['$routeProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider', '$httpProvider', 'USER_ROLES',
    function ($routeProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider, $httpProvider, USER_ROLES) {



        /*
         * Oauth2 Configuration
         */
        OAuthProvider.configure({
            baseUrl: appConfigProvider.config.baseUrl,
            clientId: '4c4daa637907310df89f614886acd145',
            clientSecret: '76f5ef6abe770d3f0ae6d3f2d5e4a5ed',
            grantPath: '/oauth/access_token'
        });

        /*
         * Oauth2 Configuration
         */
        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false
            }
        });


        $httpProvider.interceptors.push([
            '$injector',
            function ($injector) {
                return $injector.get('AuthInterceptor');
            }
        ]);

    }]);


/*
 * Default App Initializing configuration
 */
app.run(['$rootScope', '$window', 'OAuth', '$cookies', 'AUTH_EVENTS', 'AuthService',
    function ($rootScope, $window, OAuth, $cookies, AUTH_EVENTS, AuthService) {


        $rootScope.$on('oauth:error', function (event, rejection) {
            // Ignore `invalid_grant` error - should be catched on `LoginController`.
            if ('invalid_grant' === rejection.data.error) {
                return;
            }

            // Refresh token when a `invalid_token` error occurs.
            if ('invalid_token' === rejection.data.error) {
                return OAuth.getRefreshToken();
            }

            // Redirect to `/login` with the `error_reason`.
            return $window.location.href = '/#/login';
        });



        $rootScope.$on(AUTH_EVENTS.logoutSuccess, function (event, rejection) {

            $rootScope.currentUser = null;
            $rootScope.currentGroup = null;
        });


        $rootScope.$on(AUTH_EVENTS.notAuthenticated, function (event, rejection) {

            $rootScope.currentUser = null;
            $rootScope.currentGroup = null;
        });


        $rootScope.$on('$routeChangeStart', function (event, next) {


            if( AuthService.isAuthenticated() ){

                $rootScope.currentUser = $cookies.getObject('user').name;
                $rootScope.currentGroup = $cookies.getObject('user').group.name;
            }else{
                $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
            }


            if (next.data) {

                var authorizedRoles = next.data.authorizedRoles;

                if (!AuthService.isAuthorized(authorizedRoles)) {
                    event.preventDefault();
                    if (AuthService.isAuthenticated()) {
                        // user is not allowed
                        $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
                    } else {
                        // user is not logged in
                        $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
                    }
                }
            }

        });


    }]);

