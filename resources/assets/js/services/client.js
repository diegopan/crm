angular.module('crm.services')
    .service('Client',['$resource','appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/client/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            },
            saveAll: {
                method: 'POST',
                url: appConfig.baseUrl + '/client/addmany'
            },

        });
    }]);