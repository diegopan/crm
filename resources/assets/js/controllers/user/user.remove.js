(function(){
    'use strict';

    angular.module('crm.controllers')
        .controller('UserRemoveController', ['$scope', '$location', '$routeParams', 'User',
            function ($scope, $location, $routeParams, User) {


                $scope.user = User.get({id: $routeParams.id});

                $scope.remove = function () {

                    if ($scope.form.$valid) {
                        $scope.user.$delete().then(function(){
                            $location.path('/users');
                        });
                    }
                };

            }]);

})();