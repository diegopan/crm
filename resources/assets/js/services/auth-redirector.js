(function () {
    'use strict';


    angular.module('crm.services')
        .factory('AuthRedirector', ['$location',
            function ($location) {


                var authRedirector = {};


                authRedirector.loginRedirector = function(userRole){

                    if(userRole === 'CCMZ_Admin'){

                       return $location.path('home');
                    }
                    else if( userRole === 'CCMZ_Operador'){

                        return  $location.path('agendamentos');

                    }
                    else if( userRole === 'CCMZ_Lider'){

                        return $location.path('home');
                    }
                    else if( userRole === 'guest'){

                        return $location.path('home');
                    }


                    return false;

                };





                return authRedirector;

            }]);

})();