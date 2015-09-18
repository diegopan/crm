angular.module('crm.services')
    .service('Portfolio',['$resource','appConfig', function( $resource, appConfig){
        return $resource(appConfig.baseUrl + '/portfolio/:id', {id: '@id'}, {
            update: {
                method: 'PUT'
            },
            reschedule: {
                method: 'POST',
                url: appConfig.baseUrl + '/portfolio/:id/reschedule'
            },
            saveAll: {
                method: 'POST',
                url: appConfig.baseUrl + '/portfolio/storemany'
            },
            getAllByMember: {
                method: 'get',
                isArray: true,
                url: appConfig.baseUrl + '/portfolio/member/:id'
            },

            listAllByMember: {
                method: 'get',
                isArray: true,
                url: appConfig.baseUrl + '/portfolio/member/:id/list'
            },

            config: {
                method: 'PUT',
                url: appConfig.baseUrl + '/portfolioconfig/:id'
            },

            newConfig: {
                method: 'POST',
                url: appConfig.baseUrl + '/portfolioconfig'
            }

        });
    }]);