angular.module('crm.services')
    .service('Member',['$resource','appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/member/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            },
            saveAll: {
                method: 'POST',
                url: appConfig.baseUrl + '/member/storemany'
            },

        });
    }]);