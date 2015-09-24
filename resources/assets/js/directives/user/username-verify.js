(function () {
    'use strict';
    angular.module('crm.directives')
        .directive('userVerify',['User',function (User) {
            return {
                restrict: 'A',
                require: "ngModel",
                link: function(scope, element, attributes, ngModel) {

                    element.bind('change', function(e){
                        if(!ngModel || !element.val()) return;

                        var keyProperty = scope.$eval(attributes.userVerify);
                        var currentValue = element.val();

                        User.query({
                            search: currentValue,
                            searchFields: 'username'
                        }).$promise.then(function(resp){
                                if(currentValue == element.val()){
                                    if(resp.length > 0){
                                        ngModel.$setValidity('unique', false);
                                    }else{
                                        ngModel.$setValidity('unique', true);
                                    }
                                }
                            },
                        function(resp){
                            ngModel.$setValidity('unique', true);
                        });




                    });
                }
            }
        }]);

})();

