angular.module('crm.controllers')
    .controller('MemberNewController', ['$scope', '$location', 'Member', 'Team', 'appConfig', '$http',
        function ($scope, $location, Member, Team, appConfig, $http) {

            $scope.user = {};
            $scope.users = [];

            $scope.team = {};
            $scope.teams = [];




            $http.get(appConfig.baseUrl + '/user/search')
                .then(function (response) {
                    $scope.users = response.data
                });


            $http.get(appConfig.baseUrl + '/team')
                .then(function (response) {
                    $scope.teams = response.data
                });


            $scope.resetUser = function($item){
                $scope.member.user_id = $item.id;
            };


            $scope.resetTeam = function($item){
                $scope.member.team_id = $item.id;
            };



            $scope.member = new Member();

            $scope.save = function () {

                if ($scope.form.$valid) {
                    $scope.member.$save().then(function () {
                        $location.path('/members');
                    }, function (response) {
                        console.log(response);
                    });
                }

            };


        }]);
