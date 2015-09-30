(function () {
    "use strict";


    angular.module('crm.controllers')
        .controller('PortfolioEditController', ['$scope','$routeParams','$location', 'Client', 'Team', 'Member', 'Portfolio',
            function ($scope, $routeParams, $location, Client, Team, Member, Portfolio) {

                var vm = this;


                vm.portfolio = Portfolio.get({id: $routeParams.id});


                vm.selectedClient = vm.portfolio.client;

                vm.selectedTeam = vm.portfolio.team;

                vm.selectedMember = vm.portfolio.member;




                vm.getClients = function (param) {
                    return Client.query({
                        search: param,
                        searchFields: 'cnpj:like',
                        with: 'portfolio'
                    }).$promise;
                };


                vm.formatClient = function (cli) {
                    if (cli) {

                        return cli.razao;
                    }
                };


                vm.changeCli = function (cli) {
                    if (cli) {
                        vm.portfolio.client_id = cli.id;
                    }
                };


                vm.getTeams = function (param) {
                    return Team.query({
                        search: param,
                        searchFields: 'name:like'
                    }).$promise;
                };


                vm.formatTeam = function (team) {

                    if (team) {
                        return team.slug + '-' + team.name;
                    }

                    return '';
                };

                vm.changeTeam = function (team) {
                    if (team) {
                        vm.portfolio.team_id = team.id;
                    }
                };



                vm.getMembers = function (param) {
                    return Member.query({
                        search: param +";"+ vm.portfolio.team_id,
                        searchFields: 'sap:like;team_id'

                    }).$promise;
                };


                vm.formatMember = function (member) {
                    if (member) {

                        return member.sap + ' - ' + member.user.name;
                    }

                    return '';
                };


                vm.changeMember = function (member) {

                    if (member) {
                        vm.portfolio.member_id = member.id;
                    }
                };


                vm.isDisabled = function(model){

                    if(model){

                        return !model.hasOwnProperty('id');
                    }
                    return true;
                };


                vm.toUpdateData = {
                    client_id: vm.selectedClient.id,
                    team_id: vm.selectedTeam.id,
                    member_id: vm.selectedMember.id
                };



                vm.save = function(){
                    Portfolio.update({id: vm.portfolio.id},  vm.toUpdateData, function () {
                        $location.path('/carteiras');
                    });
                };


            }]);

})();