(function () {
    'use strict';


    angular.module('crm.controllers')

        .controller('AgendamentosAtendimentosController', ['$scope', '$cookies', 'Portfolio', 'Sale',
            function ($scope, $cookies, Portfolio, Sale) {
               ;


                var vm = this;


                /**
                 * Armazena os atendimentos agendados do dia corrente.
                 */
                vm.agendamentos;


                /**
                 * Armazena os dados do atendimento selecionado.
                 */
                vm.atendimento;


                /**
                 * Retorna todos os atendimentos agendados para o dia corrente.
                 */
                vm.getAtendimentos = function () {
                    Portfolio.getAllByMember({id: $cookies.getObject('user').member.id},
                        function (response) {
                            vm.agendamentos = {};
                            vm.agendamentos = response[0];

                            angular.forEach(response[0], function (value, idx) {

                                Sale.getTags({cliId: value.client_id, memberId: $cookies.getObject('user').member.id},
                                    function (response) {

                                        vm.agendamentos[idx].tags = response.success;

                                    });
                            });

                        },
                        function (response) {
                            alert("Nenhum atendimento agendado para hoje ;(");
                        });
                };

            }]);

})();


