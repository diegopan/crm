angular.module('crm.services')
    .service('Attendance',['$resource','appConfig', function($resource, appConfig){
        return $resource(appConfig.baseUrl + '/attendance/:id',{id:'@id'}, {
            update: {
                method: 'PUT'
            }

        });
    }]);