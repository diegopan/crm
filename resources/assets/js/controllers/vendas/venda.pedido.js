(function () {
    'use strict';


    angular.module('crm.controllers')

        .controller('PedidoController', ['$scope', '$cookies', 'Sale', 'Cip', 'Client',
            function ($scope, $cookies, Sale, Cip, Client) {


                var vm = this;



                /**
                 * Armazena o usuário que está atualmente logado.
                 */
                vm.user = $cookies.getObject('user');



                /**
                 * Armazena os dados do atendimento selecionado.
                 */
                vm.atendimento;


                /**
                 * Armazena os pedidos realizados no dia corrente para o cliente selecionado.
                 */
                vm.sales;


                /**
                 * Instancia o recurso para a criação de um novo pedido.
                 */
                vm.pedido = new Sale();


                /**
                 * Função que funciona como gatilho para mostrar o formulário de cadastro de pedidos.
                 * @param atendimento
                 */
                vm.initSales = function(atendimento){

                    console.log(atendimento);

                    vm.atendimento =atendimento;
                    $scope.agenda.showStats = false;
                    $scope.salesFormViewOnly.show = true;
                    $scope.salesFormViewOnly.setFocus = true;

                    $scope.cipData = $scope.getTrimestralCnpj(portfolio)
                    $scope.showCip = true;

                    $('#saleNumber').focus();


                    Sale.getSales({cliId: vm.atendimento.client_id, memberId: $cookies.getObject('user').member.id},
                        function (response) {
                            vm.sales = response.success;
                        });
                };


                /*
                 |@function endSales
                 |Função que cancela a inserção de pedidos para um agendamento.
                 */
                vm.endSales = function () {
                    $scope.agSelected = '';
                    $scope.search = '';
                    $scope.salesFormViewOnly.show = false;
                    $scope.agenda.showStats = true;
                    $scope.salesFormViewOnly.setFocus = false;
                    $scope.salesFormViewOnly.client = '';
                    $scope.salesFormViewOnly.time = '';

                    $scope.pedido.client_id = '';
                    $scope.sales = '';
                    $scope.showCip = false;
                }





                vm.save = function () {

                    vm.pedido.client_id = vm.atendimento.client_id;
                    vm.pedido.member_id = $cookies.getObject('user').member.id;
                    vm.pedido.team_id = $cookies.getObject('user').member.team_id;

                    if ($scope.form.$valid) {
                        vm.pedido.tags = angular.toJson(vm.pedido.tags);
                        vm.pedido.$save().then(
                            function () {
                                vm.pedido = {};
                                vm.pedido = new Sale();

                                Sale.getSales({
                                        cliId: vm.atendimento.client_id,
                                        memberId: $cookies.getObject('user').member.id
                                    }, {},
                                    function (response) {
                                        vm.sales = response.success;
                                    });

                                $('#saleNumber').focus();
                            });


                    }
                };

            }]);


})();


