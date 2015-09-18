(function(){
    'use strict';

    angular.module('crm.controllers')
        .controller('CipController', ['$scope', '$rootScope', '$cookies', 'Cip',
            function ($scope, $rootScope, $cookies, Cip) {
                /* jshint validthis: true */
                var vm = this;

                vm.user = $cookies.getObject('user');

                vm.trimestral = {};



                vm.getTrimestralCarteira = function(){
                    Cip.getTrimestralCarteira({id: vm.user.member.id},function(response){
                        vm.trimestral = response.success;

                    });
                };

            }]);


})();

