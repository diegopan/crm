angular.module('crm.controllers')
    .controller('MemberAddManyController', ['$scope', '$location', 'Member', 'Papa',
        function ($scope, $location, Member, Papa) {
            $scope.fileHasError = false;
            $scope.uploadedData = [];
            $scope.fileErrors = [];


            $scope.errors = {
                hasError: false,
                file: [],

                pre: [],

                val: [],
            };


            $scope.upload = function () {
                $('input[type=file]').parse({
                    config: {
                        header: true,
                        step: function (results, parser) {

                            if (results.errors.length > 0) {
                                $scope.errors.file.push({
                                    "line": results.errors[0].row,
                                    "type": results.errors[0].type,
                                    "code": results.errors[0].code,
                                    "message": results.errors[0].message
                                });
                            } else {
                                $scope.uploadedData.push(results.data[0]);
                            }
                        }
                    },
                    complete: function () {

                        if ($scope.errors.file.length < 2) {
                            $scope.save();
                        } else {
                            $scope.fileHasError = true;
                        }

                    }

                });
            };

            $scope.save = function () {
                Member.saveAll({}, $scope.uploadedData,
                    function (response) {

                        $scope.errors = [];
                        $scope.errors.hasError = false;
                        $location.path('members');

                    }, function (response) {

                        if (response.data.val) {
                            console.log(response.data.val);
                            $scope.errors.hasError = true;
                            $scope.errors.val = response.data.val
                        }
                        ;

                        if (response.data.pre) {
                            console.log(response.data.pre);
                            $scope.errors.hasError = true;
                            $scope.errors.pre = response.data.pre
                        }
                        ;
                    })
            };

        }]);
