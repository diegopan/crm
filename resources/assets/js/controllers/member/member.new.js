(function () {


    angular.module('crm.controllers')
        .controller('MemberNewController', ['$scope', '$location', 'User', 'Member', 'Team',
            function ($scope, $location, User, Member, Team) {

                var vm = this;

                vm.users = User.query();
                vm.selectedUser = {};

                vm.teams = Team.query();
                vm.selectedTeam = {};



                vm.getUsers = function (param) {
                    return User.query({
                        search: param,
                        searchFields: 'username:like'
                    }).$promise;
                };


                vm.formatUser = function (id) {

                    if (id) {
                        for (var i in vm.users) {
                            if (vm.users[i].id == id) {
                                return vm.users[i].name;
                            }
                        }

                    }

                    return '';
                };


                vm.getTeams = function (param) {
                    return Team.query({
                        search: param,
                        searchFields: 'name:like'
                    }).$promise;
                };


                vm.formatTeam = function (id) {

                    if (id) {
                        for (var i in vm.teams) {
                            if (vm.teams[i].id == id) {
                                return vm.teams[i].name + '-' + vm.teams[i].slug;
                            }
                        }
                    }

                    return '';
                };



                vm.member = {
                    user_id: vm.selectedUser,
                    team_id: vm.selectedTeam
                };



                vm.member = new Member();

                vm.save = function () {

                    if ($scope.form.$valid) {
                        console.log('valido');
                        vm.member.$save().then(function () {
                            $location.path('/members');
                        }, function (response) {
                            console.log(response);
                        });
                    }

                };


            }]);


})();