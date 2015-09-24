(function () {
    'use strict';
    angular.module('crm.directives')
        .directive('passwordCompare', function () {
            return {
                require: "ngModel",
                scope: {
                    otherModelValue: "=passwordCompare"
                },
                link: function(scope, element, attributes, ngModel) {

                    ngModel.$validators.passwordCompare = function(modelValue) {
                        return modelValue === scope.otherModelValue;
                    };

                    scope.$watch("otherModelValue", function() {
                        ngModel.$validate();
                    });
                }
            }
        });

})();

