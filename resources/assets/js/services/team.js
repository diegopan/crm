angular.module('crm.services')
    .service('Team',['$resource','appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/team/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            },
            saveAll: {
                method: 'POST',
                url: appConfig.baseUrl + '/team/addmany'
            },

        });
    }]);