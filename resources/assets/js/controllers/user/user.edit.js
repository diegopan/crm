(function () {

    "use strict";


    angular.module('crm.controllers')
        .controller('UserEditController', ['$scope', '$location', '$routeParams', 'User', 'Group',
            function ($scope, $location, $routeParams, User, Group) {


                var vm = this;


                vm.user = User.get({id: $routeParams.id},
                    function (response) {
                         Group.get({id: response.group_id}, function(resp){
                             vm.selectedGroup = resp;
                        });


                    });

                /**
                 * @description Mostra o nome do grupo selecionado no campo de busca.
                 * @param group
                 */
                vm.formatGroup = function (group) {
                    if(group){
                        return group.name;
                    }
                };


                /**
                 * @description Pesquisa um grupo usando o parametro passado.
                 * @param param
                 * @returns {object}
                 */
                vm.getGroups = function(param){
                    return Group.query({
                        search: param,
                        searchFields: 'name:like'
                    }).$promise;
                };



                /**
                 * Evento disparado quando um grupo é selecionado no campo de busca.
                 * @param group {object}
                 * @returns {string}
                 */
                vm.changeGroup = function (group) {

                    if (group) {
                        vm.user.group_id = group.id;
                    }
                    return '';
                };



                vm.update = function () {

                        User.update({id: vm.user.id}, vm.user, function () {
                            $location.path('/users');
                        });

                };


                vm.updatePwd = function () {

                        User.update({id: vm.user.id}, vm.user, function () {
                            $location.path('/users');
                        });

                };



            }]);

})();