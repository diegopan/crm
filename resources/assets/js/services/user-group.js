(function(){
    "use strict";

    angular.module('crm.services')
        .service('Group',['$resource','appConfig', function($resource, appConfig){
            return $resource(appConfig.baseUrl + '/group/:id',{id:'@id'}, {
                update: {
                    method: 'PUT'
                }
            });
        }]);
})();