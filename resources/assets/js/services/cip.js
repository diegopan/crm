angular.module('crm.services')
    .service('Cip',['$resource','appConfig', function( $resource, appConfig){
        return $resource(appConfig.baseUrl + '/cip/:cnpj', {cnpj:'@cnpj'}, {

            getTrimestralCnpj: {
                method: 'get',
                url: appConfig.baseUrl + '/cip/cnpj/:cnpj/tri'
            },

            getLastMonthCnpj: {
                method: 'get',
                url: appConfig.baseUrl + '/cip/cnpj/:cnpj/month'
            },

            getTrimestralCarteira: {
                method: 'get',
                url: appConfig.baseUrl + '/cip/carteira/:id/tri'
            }

        });
    }]);