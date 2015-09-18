(function(){
    'use strict';

    angular.module('crm.controllers')
        .controller('StatusController', ['$scope', '$rootScope', '$cookies', 'Status',
            function ($scope, $rootScope, $cookies, Status) {
                /* jshint validthis: true */
                var vm = this;

                vm.user = $cookies.getObject('user');

                vm.std = {
                    daily: {
                        agendamentos: 0,
                        posit: 0,
                        venda: 0,
                        tiket: 0
                    },
                    monthly: {
                        agendamentos: 0,
                        posit: 0,
                        venda: 0,
                        tiket: 0
                    },
                    projecao: {}
                };


                vm.getDaily = function () {
                    Status.dailyByMember({memberId: vm.user.member.id}, function (response) {
                        vm.std.daily.agendamentos = response.success.agendamentos;
                        vm.std.daily.posit = response.success.posit;
                        vm.std.daily.venda = response.success.venda;
                        vm.std.daily.tiket = response.success.tiket;


                    });
                };




                vm.getMonthly = function () {
                    Status.monthlyByMember({memberId: vm.user.member.id}, function (response) {
                        vm.std.monthly.agendamentos = response.success.agendamentos;
                        vm.std.monthly.posit = response.success.posit;
                        vm.std.monthly.venda = response.success.venda;
                        vm.std.monthly.tiket = response.success.tiket;


                    });
                };

            }]);


})();

