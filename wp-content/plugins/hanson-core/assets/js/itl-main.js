(function ($) {

    // testimonial carousel start
    var WidgetITLTestimonialsCarouselHandler = function(){
        $(".testimonial-carousel").each(function(){
            var getTesCarID = $(this).attr("id");
            var testimonial = $("#"+getTesCarID);
            var testimonialCount = testimonial.data('count');
            var testimonialAutoPlay = testimonial.data('autoplay');
            var testimonialLoop = testimonial.data('loop');
            var testimonialNav = testimonial.data('nav');
            var testimonialDots = testimonial.data('dots');
            var testimonialSpeed = testimonial.data('speed');
            var testimonialTimeout = testimonial.data('timeout');
            testimonial.owlCarousel({
                items:1,
                autoplay: testimonialAutoPlay,
                dots: testimonialDots,
                dotsEach: false,
                autoplaySpeed: testimonialSpeed,
                autoplayTimeout:testimonialTimeout,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                responsive:{
                    0:{
                        items:1,
                        nav:testimonialNav,
                    },
                    600:{
                        items:1,
                        nav:testimonialNav,
                    },
                    769:{
                        items:testimonialCount,
                        nav:testimonialNav,
                        loop:testimonialLoop,
                    }
                }
            });
        });
    };
    // testimonial carousel end

    // clients carousel start
    var WidgetITLClientCarouselHandler = function(){
        $(".clients-carousel").each(function(){
            var getCliCarID = $(this).attr("id");
            var clients = $("#"+getCliCarID);
            var clientCount = clients.data('count');
            var clientAutoPlay = clients.data('autoplay');
            var clientLoop = clients.data('loop');
            var clientNav = clients.data('nav');
            var clientDots = clients.data('dots');
            var clientSpeed = clients.data('speed');
            var clientTimeout = clients.data('timeout');
            clients.owlCarousel({
                autoplay: clientAutoPlay,
                dots: clientDots,
                dotsEach: false,
                autoplaySpeed: clientSpeed,
                autoplayTimeout:clientTimeout,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                responsive:{
                    0:{
                        items:1,
                        nav:clientNav,
                    },
                    600:{
                        items:3,
                        nav:clientNav,
                    },
                    769:{
                        items:clientCount,
                        nav:clientNav,
                        loop:clientLoop
                    }
                }
            });
        });
    };
    // clients carousel end

    //pie chart start
    var WidgetITLPieChartHandler = function(){
        $('.chart').each(function(){
            var piechartBarColor = $(this).data('barcolor');
            var piechartTrackColor = $(this).data('trackcolor');
            var piechartLineCap = $(this).data('linecap');
            var piechartLineWidth = $(this).data('linewidth');
            var piechartSize = $(this).data('chartsize');
            var piechartAnimation = $(this).data('chartanimation');
           $(this).easyPieChart({
               barColor: piechartBarColor,
               trackColor: piechartTrackColor,
               scaleColor: '',
               lineCap: piechartLineCap,
               lineWidth: piechartLineWidth,
               size: piechartSize,
               animate: piechartAnimation,
               onStep: function(from, to, percent) {
                   $(this.el).find('.percent').text(Math.round(percent));
               },
           });
        });
    };
    var WidgetITLPieChartHandlerOnScroll = function ($scope, $) {
        $scope.waypoint(function (direction) {
            WidgetITLPieChartHandler($(this), $);
        }, {
            offset: $.waypoints('viewportHeight') - 100,
            triggerOnce: true
        });
    };
    //pie chart end

    //venobox lightbox start
    $('.portfolio-popup').venobox({
        titleattr: 'data-title',
        spinner: 'rotating-plane',
        titlePosition: 'bottom',
    });
    //venobox lightbox end

    // portfolio start
    $(window).on("load",function() {
        var $container = $('.itl-portfolio');
        $container.isotope({
            filter: '*',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });
        $('.itl-portfolio-nav ul li').on("click", function() {
            $('.itl-portfolio-nav ul li.active').removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $container.isotope({
                filter: selector,
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });
            return false;
        });
    });
    //portfolio end

    //elementor front start
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/itl-testimonial.default', WidgetITLTestimonialsCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/itl-clients.default', WidgetITLClientCarouselHandler);
        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction('frontend/element_ready/itl-pie-chart.default', WidgetITLPieChartHandler);
        } else {
            elementorFrontend.hooks.addAction('frontend/element_ready/itl-pie-chart.default', WidgetITLPieChartHandlerOnScroll);
        }
    });
    //elementor front start

})(jQuery);