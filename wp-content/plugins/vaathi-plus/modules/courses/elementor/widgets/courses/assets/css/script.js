// Search js
(function ($) {

    var dtCoursesListingWidgetHandler = function($scope, $){
        $scope.find('.wdt-courses-listing').on('hover', function(e) {
            $scope.find('.wdt-courses-listing').removeClass('active');
            $(this).addClass('active');
        });
    };
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/wdt-courses-listing.default', dtCoursesListingWidgetHandler);
    });

})(jQuery);