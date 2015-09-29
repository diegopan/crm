(function () {
    'use strict';


    angular.module('crm.controllers')

        .controller('VendaAleatoriaController', ['$scope', '$cookies', 'Sale', 'Cip', 'Client',
            function ($scope, $cookies, Sale, Cip, Client) {


                var vm = this;

                /**
                 * Armazena o usuário que está atualmente logado.
                 */
                vm.user = $cookies.getObject('user');


                /**
                 * Armazena o cliente selecionado no campo de buscas.
                 */
                vm.selectedClient;


                /**
                 * Armazena as informações obtidas do CIP para o cliente selecionado.
                 */
                vm.cipLastMonth;

                vm.cipData;

                /**
                 * Gatilho de controle para mostrar os dados trimestrais do cliente selecionado.
                 */
                vm.showCliStats = false;


                /**
                 * Clients List
                 */
               // vm.clients = Client.query();


                /**
                 * @description Mostra a razão social do cliente selecionado no campo de busca.
                 * @param cli
                 */
                vm.formatClient = function (cli) {

                    if(cli){
                        if(cli.portfolio){
                            return cli.razao + ' - Possui Carteira!';
                        }

                        return cli.razao;


                    }

                };



                vm.getClients = function(param){
                    return Client.query({
                        search: param,
                        searchFields: 'cnpj:like',
                        with: 'portfolio',
                    }).$promise;
                };



                /**
                 * Evento disparado quando um cliente é selecionado no campo de busca.
                 * @param cli
                 * @returns {string}
                 */
                vm.changeCli = function (cli) {

                    if (cli) {

                        vm.getTrimestralCnpj(cli);


                                vm.showCliStats = true;
                                vm.initAleatorySales(cli);




                    }
                    return '';
                };





                vm.initAleatorySales = function (client) {


                    $scope.salesFormViewOnly.client = client.razao;
                    $scope.salesFormViewOnly.horario = '';
                    $scope.agenda.showStats = false;
                    $scope.salesFormViewOnly.show = true;
                    $scope.salesFormViewOnly.setFocus = true;
                    $scope.initAlSales(client);

                    $('#saleNumber').focus();

                };



                /*-----------------------BEGIN CIP-----------------------------------------------------------------------*/
                vm.getTrimestralCnpj = function (portfolio) {

                    Cip.getTrimestralCnpj({cnpj: portfolio.cnpj},
                        function (response) {
                            vm.cipData = response.success;

                            Cip.getLastMonthCnpj({cnpj: portfolio.cnpj},
                                function(resp){
                                    vm.cipLastMonth = resp.success;

                                    vm.cipStatus = {

                                        tkt_med_up : vm.cipData.ticket_medio < vm.cipLastMonth.ticket_medio,
                                        tkt_med_dw : vm.cipData.ticket_medio > vm.cipLastMonth.ticket_medio,
                                        tkt_med_eq : vm.cipData.ticket_medio == vm.cipLastMonth.ticket_medio,

                                        med_sem_up : vm.cipData.media_semanal < vm.cipLastMonth.media_semanal,
                                        med_sem_dw : vm.cipData.media_semanal > vm.cipLastMonth.media_semanal,
                                        med_sem_eq : vm.cipData.media_semanal == vm.cipLastMonth.media_semanal,

                                        med_tri_up : vm.cipData.venda_bruta < vm.cipLastMonth.venda_bruta,
                                        med_tri_dw : vm.cipData.venda_bruta > vm.cipLastMonth.venda_bruta,
                                        med_tri_eq : vm.cipData.venda_bruta == vm.cipLastMonth.venda_bruta,

                                        ativo_up : vm.cipData.valor_televendas < vm.cipLastMonth.valor_televendas,
                                        ativo_dw : vm.cipData.valor_televendas > vm.cipLastMonth.valor_televendas,
                                        ativo_eq : vm.cipData.valor_televendas == vm.cipLastMonth.valor_televendas,

                                        recp_up : vm.cipData.valor_telemarketing < vm.cipLastMonth.valor_telemarketing,
                                        recp_dw : vm.cipData.valor_telemarketing > vm.cipLastMonth.valor_telemarketing,
                                        recp_eq : vm.cipData.valor_telemarketing == vm.cipLastMonth.valor_telemarketing,

                                        elet_up : vm.cipData.valor_eletronico < vm.cipLastMonth.valor_eletronico,
                                        elet_dw : vm.cipData.valor_eletronico > vm.cipLastMonth.valor_eletronico,
                                        elet_eq : vm.cipData.valor_eletronico == vm.cipLastMonth.valor_eletronico,

                                        gen_up : vm.cipData.valor_generico < vm.cipLastMonth.valor_generico,
                                        gen_dw : vm.cipData.valor_generico > vm.cipLastMonth.valor_generico,
                                        gen_eq : vm.cipData.valor_generico == vm.cipLastMonth.valor_generico,

                                        hb_up : vm.cipData.valor_hb < vm.cipLastMonth.valor_hb,
                                        hb_dw : vm.cipData.valor_hb > vm.cipLastMonth.valor_hb,
                                        hb_eq : vm.cipData.valor_hb == vm.cipLastMonth.valor_hb,

                                        otc_up : vm.cipData.valor_otc < vm.cipLastMonth.valor_otc,
                                        otc_dw : vm.cipData.valor_otc > vm.cipLastMonth.valor_otc,
                                        otc_eq : vm.cipData.valor_otc == vm.cipLastMonth.valor_otc,

                                        etc_up : vm.cipData.valor_outros < vm.cipLastMonth.valor_outros,
                                        etc_dw : vm.cipData.valor_outros > vm.cipLastMonth.valor_outros,
                                        etc_eq : vm.cipData.valor_outros == vm.cipLastMonth.valor_outros

                                    };
                                });
                        });
                };

                $scope.$watch(vm.cipLastMonth, function(){
                    return;
                });

                /*-----------------------END CIP----------------------------------------------------------------------*/





            }]);


})();


