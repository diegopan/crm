angular.module('crm.controllers')

    .controller('CarteiraHistoryController', ['$scope', '$cookies', '$routeParams', 'Sale','DTOptionsBuilder',
        function ($scope, $cookies, $routeParams,  Sale, DTOptionsBuilder) {
            //console.log($cookies.getObject('user'));




            $scope.dtOptions = DTOptionsBuilder
                .newOptions()
                .withPaginationType('full_numbers')
                .withBootstrap()
                .withBootstrapOptions({
                    pagination: {
                        classes: {
                            ul: 'pagination pagination-sm'
                        }
                    }
                })
                .withLanguage({
                    "sEmptyTable":     "Nenhum registro disponível",
                    "sInfo":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered":   "(filtrados de _MAX_ registros no total)",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ",",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing":     "Processando...",
                    "sSearch":         "Pesquisar:",
                    "sZeroRecords":    "Nenhum registro encontrado.",
                    "oPaginate": {
                        "sFirst":    "Primeira",
                        "sLast":     "Última",
                        "sNext":     "Próxima",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": activate to sort column ascending",
                        "sSortDescending": ": activate to sort column descending"
                    }
                });;


            $scope.getHistory = function () {
                Sale.getHistory({memberId: $cookies.getObject('user').member.id,cliId:$routeParams.cliId},
                    function (response) {


                        $scope.history = {};
                        $scope.history = response.success;





                       // $scope.agendamentos = [$scope.agendamentos];
                    },
                    function (response) {
                        alert("Nenhum cliente na carteira;(");
                    });
            }

            $scope.history = $scope.getHistory();





        }]);
