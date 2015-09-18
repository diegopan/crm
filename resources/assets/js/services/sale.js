angular.module('crm.services')
    .service('Sale',['$resource','appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/sale/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            },
            getSales: {
                url: appConfig.baseUrl + '/sale/client/:cliId/member/:memberId',
                method: 'GET'
            },
            getTags: {
                url: appConfig.baseUrl + '/sale/client/:cliId/member/:memberId/tags',
                method: 'GET'
            },
            getHistory: {
                url: appConfig.baseUrl + '/sale/member/:memberId/client/:cliId/history',
                method: 'GET'
            }


        });
    }]);