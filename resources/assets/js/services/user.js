angular.module('crm.services')
    .service('User',['$resource','appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/user/:id',{id:'@id'}, {
            update: {
                method: 'PUT'
            },
            saveAll: {
                method: 'POST',
                url: appConfig.baseUrl + '/user/addmany'
            },
            authenticated: {
                method: 'GET',
                url: appConfig.baseUrl + '/user/authenticated'
            }

        });
    }]);