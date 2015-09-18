(function () {
    'use strict';


    angular.module('crm.controllers')
        .controller('GeneralController', ['$scope', '$cookies', 'USER_ROLES', 'AuthService',
            function ($scope, $cookies, USER_ROLES, AuthService) {


                var vm = this;

                vm.currentUser = null;
                vm.userRoles = USER_ROLES;
                vm.isAuthorized = AuthService.isAuthorized;




        }]);


})();