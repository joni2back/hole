(function() {
    var HoleApp = angular.module('HoleApp', []);

    HoleApp.directive('ngEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if (event.which === 13) {
                    scope.$apply(function () {
                        scope.$eval(attrs.ngEnter);
                    });
                    event.preventDefault();
                }
            });
        };
    });

    HoleApp.directive('ngFile', function($parse) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                var model = $parse(attrs.ngFile);
                var modelSetter = model.assign;

                element.bind('change', function() {
                    scope.$apply(function() {
                        modelSetter(scope, element[0].files);
                    });
                });
            }
        };
    });
    
    HoleApp.filter('strLimit', ['$filter', function($filter) {
        return function(input, limit) {
            if (input && input.length <= limit) {
                return input;
            }
            return input && $filter('limitTo')(input, limit) + '...';
        };
    }]);

})();