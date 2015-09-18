angular.module('crm.controllers')
    .controller('MemberRemoveController', ['$scope', '$location', '$routeParams', 'Member',
        function ($scope, $location, $routeParams, Member) {

        $scope.member = Member.get({id: $routeParams.id});

        $scope.remove = function () {

            if ($scope.form.$valid) {
                $scope.member.$delete().then(function(){
                    $location.path('/members');
                });
            }

        };

    }]);
