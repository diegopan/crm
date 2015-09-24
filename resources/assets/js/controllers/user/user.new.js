(function () {

    "use strict";


    angular.module('crm.controllers')
        .controller('UserNewController', ['$scope', '$location', 'User', 'Group',
            function ($scope, $location, User, Group) {


                var vm = this;


                vm.user = {};
                vm.user = new User();

                vm.selectedGroup = {};


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





                vm.save = function () {

                    if ($scope.form.$valid) {

                        console.log(vm.user);
                        vm.user.$save().then(function () {
                            $location.path('/users');
                        });
                    }
                };


            }]);

})();