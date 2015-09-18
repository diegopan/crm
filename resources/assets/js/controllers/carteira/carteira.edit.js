(function () {
    'use strict';

    angular.module('crm.controllers')
        .controller('CarteiraEditController', ['$scope', '$cookies', '$routeParams', '$filter', 'Portfolio',
            function ($scope, $cookies, $routeParams, $filter, Portfolio) {
                //console.log($cookies.getObject('user'));

                $scope.scheduleCfg = {};

                $scope.alerts = [];

                $scope.portfolio = Portfolio.get({id: $routeParams.portfolioId}, function (response) {

                    if (response.phone) {
                        response.phone = response.phone.toString();
                    }


                    if (response.email) {
                        response.email = response.email.toString();
                    }


                    if (response.config) {

                        if (response.config.hasOwnProperty('seg') && response.config.seg != null) {
                            var seg = response.config.seg.split(':');
                            $scope.scheduleCfg.seg = new Date(null, null, null, seg[0], seg[1], seg[2]);
                        }

                        if (response.config.hasOwnProperty('ter') && response.config.ter != null) {
                            var ter = response.config.ter.split(':');
                            $scope.scheduleCfg.ter = new Date(null, null, null, ter[0], ter[1], ter[2]);
                        }

                        if (response.config.hasOwnProperty('qua') && response.config.qua != null) {
                            var qua = response.config.qua.split(':');
                            $scope.scheduleCfg.qua = new Date(null, null, null, qua[0], qua[1], qua[2]);
                        }

                        if (response.config.hasOwnProperty('qui') && response.config.qui != null) {
                            var qui = response.config.qui.split(':');
                            $scope.scheduleCfg.qui = new Date(null, null, null, qui[0], qui[1], qui[2]);
                        }

                        if (response.config.hasOwnProperty('sex') && response.config.sex != null) {
                            var sex = response.config.sex.split(':');
                            $scope.scheduleCfg.sex = new Date(null, null, null, sex[0], sex[1], sex[2]);
                        }


                    }

                });


                $scope.updateCarteira = function () {

                    var data = {
                        phone: angular.copy($scope.portfolio.phone),
                        responsible: angular.copy($scope.portfolio.responsible),
                        email: angular.copy($scope.portfolio.email)
                    };

                    Portfolio.update({id: $scope.portfolio.id}, angular.toJson(data), function (response) {
                        $scope.alerts =[{type: 'success', msg: 'Informações salvas com sucesso!'}];
                    }, function (response) {
                        $scope.alerts =[{type: 'danger', msg: 'As informações não foram salvas!'}];
                    });
                };


                $scope.updateScheduleConfig = function () {




                    var data = {
                        portfolio_id: $scope.portfolio.id,
                        seg: $filter('date')($scope.scheduleCfg.seg, 'HH:mm:ss'),
                        ter: $filter('date')($scope.scheduleCfg.ter, 'HH:mm:ss'),
                        qua: $filter('date')($scope.scheduleCfg.qua, 'HH:mm:ss'),
                        qui: $filter('date')($scope.scheduleCfg.qui, 'HH:mm:ss'),
                        sex: $filter('date')($scope.scheduleCfg.sex, 'HH:mm:ss')
                    };


                    if ($scope.portfolio.config) {

                        Portfolio.config({id: $scope.portfolio.config.id}, data, function (response) {


                            $scope.alerts =[{type: 'success', msg: 'Informações salvas com sucesso!'}];


                        }, function (response) {

                            $scope.alerts =[{type: 'danger', msg: 'As informações não foram salvas!'}];

                        });
                    } else {

                        Portfolio.newConfig(data, function (response) {
                            $scope.alerts =[{type: 'success', msg: 'Informações salvas com sucesso!'}];
                        })
                    }


                };


            }]);


})();

