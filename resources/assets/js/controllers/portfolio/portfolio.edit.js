angular.module('crm.controllers')
    .controller('MemberEditController', ['$scope', '$location', '$routeParams', '$http', 'appConfig', 'Team', 'User', 'Member',
        function ($scope, $location, $routeParams, $http, appConfig, Team, User, Member) {


            $scope.team = {};
            $scope.user = {};
            $scope.member = Member.get({id: $routeParams.id},
                function (response) {
                    $scope.user.selected = User.get({id: $scope.member.user_id});
                    $scope.team.selected = Team.get({id: $scope.member.team_id});
                });


            $scope.teams = [];
            $scope.users = [];


            $http.get(appConfig.baseUrl + '/user/search')
                .then(function (response) {
                    $scope.users = response.data
                });


            $http.get(appConfig.baseUrl + '/team')
                .then(function (response) {
                    $scope.teams = response.data
                });


            $scope.resetUser = function ($item) {
                $scope.member.user_id = $item.id;
            };


            $scope.resetTeam = function ($item) {
                $scope.member.team_id = $item.id;
            };


            $scope.save = function () {

                if ($scope.form.$valid) {
                    Member.update({id: $scope.member.id}, $scope.member, function () {
                        $location.path('/members');
                    });

                }

            };

        }]);
