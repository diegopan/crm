angular.module('crm.controllers')
    .controller('MemberListController', ['$scope','Member', function($scope, Member){

        $scope.members = Member.query();

    }]);
