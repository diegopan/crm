(function () {

    'use strict';

    var app = angular.module('crm');
    app.config(['$routeProvider', 'USER_ROLES',
        function ($routeProvider, USER_ROLES) {

            /*
             * Route Configuration...
             */
            $routeProvider

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

        }]);
})();