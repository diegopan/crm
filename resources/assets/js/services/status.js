angular.module('crm.services')
    .service('Status',['$resource','appConfig', function( $resource, appConfig){
        return $resource(appConfig.baseUrl + '/status', {}, {

            dailyByMember: {
                method: 'get',
                url: appConfig.baseUrl + '/status/member/:memberId/daily'
            },

            monthlyByMember: {
                method: 'get',
                url: appConfig.baseUrl + '/status/member/:memberId/monthly'
            },


        });
    }]);