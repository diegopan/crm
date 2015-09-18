angular.module('crm.controllers')
    .controller('PortfolioAddManyController', ['$scope', '$location', 'Portfolio', 'Papa',
        function ($scope, $location, Portfolio, Papa) {

            $scope.results = {
                success: 0,
                error: {
                    count: 0,
                    rows: []
                }
            };

            $scope.upload = function () {
                $('input[type=file]').parse({
                    config: {

                        header: true,
                        step: function (row, parser) {

                            if (row.errors.length > 0) {

                                console.log({error: row.errors[0], data: row.data[0]});

                            } else {
                                var reg = new Portfolio(row.data[0]);

                                parser.pause();

                                reg.$save().then(
                                    function(response){

                                        $scope.results.success += 1;
                                        parser.resume();
                                    },
                                    function(response){

                                        $scope.results.error.rows.push({
                                            data:response.config.data,
                                            msg: response.data.message
                                        }) ;

                                        $scope.results.error.count += 1;
                                        parser.resume();
                                    }
                                );
                            }
                        }
                    },
                    complete: function (results, file) {

                        console.log("Parsing complete:");
                        console.log($scope.results.error);

                    }

                });
            };

        }]);
