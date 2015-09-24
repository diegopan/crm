(function () {
    'use strict';
    var REGEXP = /^(?!.*(.)\1{1})(?=(.*[\d]){1,})(?=(.*[a-z]){1,})(?=(.*[A-Z]){1,})(?=(.*[@#$%!]){1,})(?:[\da-zA-Z@#$%!]){6,12}$/;
    angular.module('crm.directives')
        .directive('pwdEsp', function () {
            return {
                require: "ngModel",
                link: function(scope, element, attributes, ngModel) {

                    ngModel.$validators.pwdEsp = function(modelValue) {
                        if(REGEXP.test(modelValue)){
                            return true;
                        }

                        return false;
                    };
                }
            }
        });

})();

