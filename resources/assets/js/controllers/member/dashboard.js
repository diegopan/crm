(function () {
    'use strict';


    angular.module('crm.controllers')

        .controller('MemberDashboardController', ['$scope', '$cookies', '$routeParams', 'Portfolio', 'Sale', 'Cip', 'Attendance',
            function ($scope, $cookies, $routeParams, Portfolio, Sale, Cip, Attendance) {

                var vm = this;


                $scope.vendaAleatoria = false;

                /*
                 @var agendamentos
                 @descritiption: Armazena os agendamentos do dia.
                 */
                $scope.agendamentos = {};

                /*
                 @var sales
                 @description: Armazena os pedidos do dia realizaddos por um cliente.
                 */
                $scope.sales = [];

                /*
                 @var portfolio
                 @description: Armazena os dados do formulario de pedidos.
                 */
                $scope.portfolio = {};


                $scope.cipData = {};
                $scope.cipLastMonth = {};
                $scope.showCip = false;


                $scope.agSelected = '';
                $scope.setAg = function (ag) {

                    $scope.agSelected = ag.cod_cli;

                };


                /**
                 * Retorna todos os atendimentos agendados para o dia corrente.
                 */
                $scope.getAtendimentos = function () {
                    Portfolio.getAllByMember({id: $cookies.getObject('user').member.id},
                        function (response) {
                            $scope.agendamentos = {};
                            $scope.agendamentos = response[0];

                            angular.forEach(response[0], function (value, idx) {

                                Sale.getTags({cliId: value.client_id, memberId: $cookies.getObject('user').member.id},
                                    function (response) {

                                        $scope.agendamentos[idx].tags = response.success;

                                    });
                            });

                        },
                        function (response) {
                            alert("Nenhum atendimento agendado para hoje ;(");
                        });
                };


                /* --------------------------------------BEGIN AGENDA STATS ------------------------------------------------*/

                $scope.agenda = {
                    showStats: true
                };


                /*
                 * ------------------------------- BEGIN RESCHEDULING ------------------------------------------------------
                 */

                $scope.rescheduleForm = {
                    show: false
                };

                $scope.portfolioRescheduling = {};

                $scope.initRescheduling = function () {
                    $scope.rescheduleForm.show = true;
                    $scope.salesFormViewOnly.show = false;
                    $('#reschTime').focus();


                };

                $scope.endRescheduling = function () {
                    $scope.showCip = false;
                    $scope.agSelected = '';
                    $scope.search = '';
                    $scope.portfolioRescheduling = {};
                    $scope.rescheduleForm.show = false;

                    $scope.salesFormViewOnly.show = false;
                    $scope.agenda.showStats = true;
                    $scope.salesFormViewOnly.setFocus = false;
                    $scope.salesFormViewOnly.client = '';
                    $scope.salesFormViewOnly.time = '';
                    $scope.pedido.client_id = '';
                    $scope.sales = '';

                };

                $scope.reschedule = function () {

                    $scope.portfolioRescheduling.portfolio_id = $scope.portfolio.portfolio_id;

                    if ($scope.formReschedule.$valid) {
                        Portfolio.reschedule({id: $scope.portfolio.portfolio_id}, $scope.portfolioRescheduling,
                            function (response) {
                                $scope.getAtendimentos();
                                $scope.endRescheduling();
                            });
                    }

                };

                /*
                 * -------------------------------END RESCHEDULING -----------------------------------------------------
                 */


                /*
                 | @var salesFormViewOnly
                 | Armazena informações "read only do formulario de pedidos, e variaveis de escopo.
                 */
                $scope.salesFormViewOnly = {
                    client: '',
                    time: '',
                    show: false,
                    setFocus: false
                };


                /**
                 * Função que funciona como gatilho para mostrar o formulário de cadastro de pedidos.
                 * @param portfolio
                 */
                $scope.initSales = function (portfolio) {


                    $scope.cipData = $scope.getTrimestralCnpj(portfolio);
                    $scope.showCip = true;

                    $scope.portfolio = portfolio;

                    $scope.salesFormViewOnly.client = portfolio.razao;
                    $scope.salesFormViewOnly.horario = portfolio.horario;
                    $scope.agenda.showStats = false;
                    $scope.salesFormViewOnly.show = true;
                    $scope.salesFormViewOnly.setFocus = true;

                    $('#saleNumber').focus();


                    Sale.getSales({cliId: portfolio.client_id, memberId: $cookies.getObject('user').member.id},
                        function (response) {

                            $scope.sales = response.success;

                        });


                };


                /**
                 * Função que funciona como gatilho para mostrar o formulário de cadastro de pedidos.
                 * @param portfolio
                 */
                $scope.initAlSales = function (portfolio) {

                    $scope.portfolio = portfolio;
                    $scope.portfolio.client_id = portfolio.id;

                    $scope.salesFormViewOnly.client = portfolio.razao;
                    $scope.salesFormViewOnly.horario = portfolio.horario;
                    $scope.agenda.showStats = false;
                    $scope.salesFormViewOnly.show = true;
                    $scope.salesFormViewOnly.setFocus = true;


                    $scope.cipData = $scope.getTrimestralCnpj(portfolio)
                    $scope.showCip = true;


                    $('#saleNumber').focus();


                    Sale.getSales({cliId: portfolio.id, memberId: $cookies.getObject('user').member.id},
                        function (response) {
                            $scope.sales = response.success;
                        });
                };


                $scope.endSales = function () {


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

                    $scope.Status.getDaily();
                    $scope.Status.getMonthly();
                };


                $scope.pedido = new Sale();


                $scope.saveSale = function () {

                    $scope.pedido.client_id = $scope.portfolio.client_id;
                    $scope.pedido.member_id = $cookies.getObject('user').member.id;
                    $scope.pedido.team_id = $cookies.getObject('user').member.team_id;

                    if ($scope.form.$valid) {
                        $scope.pedido.tags = angular.toJson($scope.pedido.tags);
                        $scope.pedido.$save().then(
                            function () {
                                $scope.pedido = {};
                                $scope.pedido = new Sale();

                                Sale.getSales({
                                        cliId: $scope.portfolio.client_id,
                                        memberId: $cookies.getObject('user').member.id
                                    }, {},
                                    function (response) {
                                        $scope.sales = response.success;
                                    });

                                $('#saleNumber').focus();
                            });


                    }
                };


                $scope.salesEditForm = {
                    client: '',
                    time: '',
                    show: false
                };

                /*
                 |@function editSale
                 | Função que altera o formulario de pedidos para o modo de edição de pedidos.
                 */
                $scope.editSale = function (sale) {

                    $scope.sale = sale;
                    $scope.sale.tags = $scope.sale.tags.toString();
                    $scope.salesFormViewOnly.show = false;
                    $scope.salesEditForm.show = true;
                    $('#sale_number').focus();
                };


                /*
                 |@function endEdit
                 | Função que finaliza o modo de edição de pedidos.
                 */
                $scope.endEdit = function () {
                    $scope.salesEditForm.show = false;
                    $scope.salesFormViewOnly.show = true;
                };


                /*
                 |@function updateSale
                 | Função para salvar alterações nos dados dos pedidos de venda.
                 */
                $scope.updateSale = function () {

                    if ($scope.formEdit.$valid) {

                        Sale.update({id: $scope.sale.id}, $scope.sale, function () {
                            $scope.salesEditForm.show = false;
                            $scope.salesFormViewOnly.show = true;
                            $scope.initSales($scope.portfolio);
                        });
                    }
                };


                /*
                 | @var salesFormViewOnly
                 | Armazena informações "read only do formulario de edição de pedidos, e variaveis de escopo.
                 */
                $scope.salesRemoveForm = {
                    client: '',
                    time: '',
                    show: false
                };


                $scope.endRemove = function () {


                    $scope.salesEditForm.show = false;
                    $scope.salesRemoveForm.show = false;
                    $scope.salesFormViewOnly.show = true;

                };

                /*
                 |@function editSale
                 | Função que altera o formulario de pedidos para o modo de edição de pedidos.
                 */
                $scope.removeSale = function (sale) {

                    $scope.sale = sale;
                    $scope.salesEditForm.show = false;
                    $scope.salesFormViewOnly.show = false;
                    $scope.salesRemoveForm.show = true;

                };


                /*
                 |@function updateSale
                 | Função para salvar alterações nos dados dos pedidos de venda.
                 */
                $scope.deleteSale = function (sale) {

                    if ($scope.formRemove.$valid) {
                        $scope.sale = new Sale(sale);
                        $scope.sale.$delete().then(function () {
                            $scope.sale = {};
                            $scope.salesFormViewOnly.show = true;
                            $scope.salesRemoveForm.show = false;
                            Sale.getSales({
                                    cliId: $scope.portfolio.client_id,
                                    memberId: $cookies.getObject('user').member.id
                                }, {},
                                function (response) {
                                    $scope.sales = response.success;
                                });

                        });
                    }
                };


                /*-----------------------BEGIN CIP-----------------------------------------------------------------------*/
                $scope.getTrimestralCnpj = function (portfolio) {

                    Cip.getTrimestralCnpj({cnpj: portfolio.cnpj},
                        function (response) {
                            $scope.cipData = response.success;

                            Cip.getLastMonthCnpj({cnpj: portfolio.cnpj},
                            function(resp){
                                $scope.cipLastMonth = resp.success;
                                $scope.cipStatus = {

                                    tkt_med_up : $scope.cipData.ticket_medio < $scope.cipLastMonth.ticket_medio,
                                    tkt_med_dw : $scope.cipData.ticket_medio > $scope.cipLastMonth.ticket_medio,
                                    tkt_med_eq : $scope.cipData.ticket_medio == $scope.cipLastMonth.ticket_medio,

                                    med_sem_up : $scope.cipData.media_semanal < $scope.cipLastMonth.media_semanal,
                                    med_sem_dw : $scope.cipData.media_semanal > $scope.cipLastMonth.media_semanal,
                                    med_sem_eq : $scope.cipData.media_semanal == $scope.cipLastMonth.media_semanal,

                                    med_tri_up : $scope.cipData.venda_bruta < $scope.cipLastMonth.venda_bruta,
                                    med_tri_dw : $scope.cipData.venda_bruta > $scope.cipLastMonth.venda_bruta,
                                    med_tri_eq : $scope.cipData.venda_bruta == $scope.cipLastMonth.venda_bruta,

                                    ativo_up : $scope.cipData.valor_televendas < $scope.cipLastMonth.valor_televendas,
                                    ativo_dw : $scope.cipData.valor_televendas > $scope.cipLastMonth.valor_televendas,
                                    ativo_eq : $scope.cipData.valor_televendas == $scope.cipLastMonth.valor_televendas,

                                    recp_up : $scope.cipData.valor_telemarketing < $scope.cipLastMonth.valor_telemarketing,
                                    recp_dw : $scope.cipData.valor_telemarketing > $scope.cipLastMonth.valor_telemarketing,
                                    recp_eq : $scope.cipData.valor_telemarketing == $scope.cipLastMonth.valor_telemarketing,

                                    elet_up : $scope.cipData.valor_eletronico < $scope.cipLastMonth.valor_eletronico,
                                    elet_dw : $scope.cipData.valor_eletronico > $scope.cipLastMonth.valor_eletronico,
                                    elet_eq : $scope.cipData.valor_eletronico == $scope.cipLastMonth.valor_eletronico,

                                    gen_up : $scope.cipData.valor_generico < $scope.cipLastMonth.valor_generico,
                                    gen_dw : $scope.cipData.valor_generico > $scope.cipLastMonth.valor_generico,
                                    gen_eq : $scope.cipData.valor_generico == $scope.cipLastMonth.valor_generico,

                                    hb_up : $scope.cipData.valor_hb < $scope.cipLastMonth.valor_hb,
                                    hb_dw : $scope.cipData.valor_hb > $scope.cipLastMonth.valor_hb,
                                    hb_eq : $scope.cipData.valor_hb == $scope.cipLastMonth.valor_hb,

                                    otc_up : $scope.cipData.valor_otc < $scope.cipLastMonth.valor_otc,
                                    otc_dw : $scope.cipData.valor_otc > $scope.cipLastMonth.valor_otc,
                                    otc_eq : $scope.cipData.valor_otc == $scope.cipLastMonth.valor_otc,

                                    etc_up : $scope.cipData.valor_outros < $scope.cipLastMonth.valor_outros,
                                    etc_dw : $scope.cipData.valor_outros > $scope.cipLastMonth.valor_outros,
                                    etc_eq : $scope.cipData.valor_outros == $scope.cipLastMonth.valor_outros

                                };
                            });
                    });
                };

                $scope.$watch($scope.cipLastMonth, function(){
                    return;
                });

                /*-----------------------END CIP----------------------------------------------------------------------*/


                $scope.initVendaAleatoria = function () {
                    $scope.vendaAleatoria = true;
                };


                $scope.endVendaAleatoria = function () {
                    $scope.vendaAleatoria = false;
                    $scope.endSales();
                };

                $scope.finalize = function () {

                    var portfolio_id = $scope.portfolio.portfolio_id;

                    var attendance = new Attendance();

                    attendance.portfolio_id = portfolio_id;

                    attendance.$save().then(function (resp) {
                        $scope.getAtendimentos();
                        $scope.endSales();
                    });
                };
            }]);

})();


