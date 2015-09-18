angular.module('crm.controllers')
    .controller('LoginController',
    [
        '$scope', '$rootScope', '$cookies', 'AUTH_EVENTS', 'AuthService', 'AuthRedirector',
        function ($scope, $rootScope, $cookies, AUTH_EVENTS, AuthService, AuthRedirector) {

            $scope.user = {
                username: '',
                password: ''
            };

            $scope.errors = {
                error: false,
                message: ''
            };


            $scope.login = function () {
                if ($scope.form.$valid) {


                    AuthService.login($scope.user).then(function (resp) {

                        if( resp.hasOwnProperty('status')){

                            if (resp.status === 401 && resp.statusText === "Unauthorized") {

                                $rootScope.$broadcast(AUTH_EVENTS.loginFailed);

                                if (resp.data.error == "invalid_credentials") {

                                    $scope.errors.message = 'As informações de acesso estão inválidas.';

                                }

                                $scope.errors.error = true;
                                return false;
                            }

                            if (resp.status === 500) {

                                $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
                                $scope.errors.message = 'Ocorreu um erro no servidor, entre em contato com o administrador do sistema.';
                                $scope.errors.error = true;

                                return false;
                            }

                        }else{

                            $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
                            $cookies.putObject('user', resp);

                            $rootScope.currentUser = resp.name;


                            if(resp.hasOwnProperty('group')){

                               return AuthRedirector.loginRedirector(resp.group.name);

                            }else{

                                return AuthRedirector.loginRedirector('guest');
                            }

                        }

                    });

                }
            }
        }]);
