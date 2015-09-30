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
    notAuthorized: 'auth-not-authorized ',
});


app.constant('USER_ROLES', {
    all: '*',
    admin: 'CCMZ_Admin',
    operador: 'CCMZ_Operador',
    lider: 'CCMZ_lider',
    guest: 'guest'
});


/*
 * CRM DEFAULT CONFIGS
 */
app.provider('appConfig', function () {
    var config = {
        baseUrl: 'http://localhost:8001'
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
         * Route Configuration...
         */
        $routeProvider
            .otherwise({redirectTo: '/login'})

            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController',

            })

            .when('/logout', {
                templateUrl: 'build/views/login.html',
                controller: 'LogoutController',

            })

            .when('/users', {
                templateUrl: 'build/views/user/list.html',
                controller: 'UserListController',
                controllerAs: 'UserList',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })

            .when('/users/new', {
                templateUrl: 'build/views/user/new.html',
                controller: 'UserNewController',
                controllerAs: 'UserNew',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })

            .when('/users/:id/edit', {
                templateUrl: 'build/views/user/edit.html',
                controller: 'UserEditController',
                controllerAs: 'UserEdit',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })


            .when('/users/:id/remove', {
                templateUrl: 'build/views/user/remove.html',
                controller: 'UserRemoveController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })

            .when('/home', {
                templateUrl: 'build/views/home.html',
                data: {
                    authorizedRoles: [USER_ROLES.admin, USER_ROLES.guest]
                }
            })

            .when('/clients', {
                templateUrl: 'build/views/client/list.html',
                controller: 'ClientListController',
                controllerAs: 'ClientList',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/clients/new', {
                templateUrl: 'build/views/client/new.html',
                controller: 'ClientNewController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/clients/:id/edit', {
                templateUrl: 'build/views/client/edit.html',
                controller: 'ClientEditController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/clients/:id/remove', {
                templateUrl: 'build/views/client/remove.html',
                controller: 'ClientRemoveController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/clients/addmany', {
                templateUrl: 'build/views/client/bulkAdd.html',
                controller: 'ClientBulkAddController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/teams', {
                templateUrl: 'build/views/team/list.html',
                controller: 'TeamListController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/teams/new', {
                templateUrl: 'build/views/team/new.html',
                controller: 'TeamNewController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }

            })
            .when('/teams/:id/edit', {
                templateUrl: 'build/views/team/edit.html',
                controller: 'TeamEditController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }

            })
            .when('/teams/:id/remove', {
                templateUrl: 'build/views/team/remove.html',
                controller: 'TeamRemoveController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }

            })
            .when('/members', {
                templateUrl: 'build/views/member/list.html',
                controller: 'MemberListController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/members/new', {
                templateUrl: 'build/views/member/new.html',
                controller: 'MemberNewController',
                controllerAs: 'MemberNew',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/members/:id/edit', {
                templateUrl: 'build/views/member/edit.html',
                controller: 'MemberEditController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/members/:id/remove', {
                templateUrl: 'build/views/member/remove.html',
                controller: 'MemberRemoveController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }

            })
            .when('/members/addmany', {
                templateUrl: 'build/views/member/addmany.html',
                controller: 'MemberAddManyController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }

            })
            .when('/agendamentos', {
                templateUrl: 'build/views/member/dashboard.html',
                controller: 'MemberDashboardController',
                controllerAs: 'Dashboard',
                data: {
                    authorizedRoles: [USER_ROLES.operador]
                }
            })
            .when('/carteiras/addmany', {
                templateUrl: 'build/views/portfolio/addmany.html',
                controller: 'PortfolioAddManyController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/carteiras/new', {
                templateUrl: 'build/views/portfolio/new.html',
                controller: 'PortfolioNewController',
                controllerAs: 'PortfolioNew',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })

            .when('/carteiras/:id/edit', {
                templateUrl: 'build/views/portfolio/edit.html',
                controller: 'PortfolioEditController',
                controllerAs: 'PortfolioEdit',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/carteiras/:id/remove', {
                templateUrl: 'build/views/portfolio/remove.html',
                controller: 'PortfolioRemoveController',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
                }
            })
            .when('/carteiras', {
                templateUrl: 'build/views/portfolio/list.html',
                controller: 'PortfolioListController',
                controllerAs: 'PortfolioList',
                data: {
                    authorizedRoles: [USER_ROLES.admin]
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

