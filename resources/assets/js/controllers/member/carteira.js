angular.module('crm.controllers')
    .filter('AgSelect', function(){
        return function(values, cod_cli) {
            if(!cod_cli) {
                // initially don't filter
                return values;
            }
            // filter when we have a selected groupId
            return values.filter(function(value){
                return value.cod_cli === cod_cli;
            })
        }
    })
    .controller('MemberCarteiraController', ['$scope', '$cookies', '$routeParams', 'Portfolio','DTOptionsBuilder',
        function ($scope, $cookies, $routeParams,  Portfolio, DTOptionsBuilder) {
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
                });


            $scope.getCarteira = function () {
                Portfolio.listAllByMember({id: $cookies.getObject('user').member.id},
                    function (response) {
                        $scope.carteira = {};
                        $scope.carteira = response[0];

                       // $scope.agendamentos = [$scope.agendamentos];
                    },
                    function (response) {
                        alert("Nenhum cliente na carteira;(");
                    });
            }

            $scope.carteira = $scope.getCarteira();





        }]);
