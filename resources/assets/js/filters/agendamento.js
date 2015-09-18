(function(){
    'use strict';

    angular.module('crm.controllers')
        .filter('AgSelect', function(){
            return function(values, cod_cli) {
                if(!cod_cli) {
                    // initially don't filter
                    return values;
                }
                // filter when we have a selected groupId
                return values.filter(function(value){
                    return value.cod_cli === cod_cli;
                })
            }
        });


})();