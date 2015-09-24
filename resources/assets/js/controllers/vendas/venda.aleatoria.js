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
                vm.clientInfo;

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
                        return cli.razao;
                    }

                };



                vm.getClients = function(param){
                    return Client.query({
                        search: param,
                        searchFields: 'cnpj:like'
                    }).$promise;
                };



                /**
                 * Evento disparado quando um cliente é selecionado no campo de busca.
                 * @param cli
                 * @returns {string}
                 */
                vm.changeCli = function (cli) {

                    if (cli) {

                        Cip.getTrimestralCnpj({cnpj: cli.cnpj},
                            function (response) {

                                vm.clientInfo = response.success;
                                vm.showCliStats = true;
                                vm.initAleatorySales(cli);

                            },
                            function (response) {
                                vm.showCliStats = false;
                            });


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

                }





            }]);


})();


