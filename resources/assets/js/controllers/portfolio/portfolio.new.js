(function () {
    "use strict";


    angular.module('crm.controllers')
        .controller('PortfolioNewController', ['$scope', '$location', 'Client', 'Team', 'Member', 'Portfolio',
            function ($scope, $location, Client, Team, Member, Portfolio) {

                var vm = this;


                vm.portfolio = {};
                vm.selectedClient = {};

                vm.selectedTeam;

                vm.selectedMember;


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


                vm.portfolio = new Portfolio();
                vm.save = function(){
                    vm.portfolio.$save().then(function(resp){
                        $location.path('/carteiras');
                    }, function(resp){
                        console.log(resp);
                    });
                };


            }]);

})();