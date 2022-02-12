;(function($){
    "use strict"
	
	
	let nav_offset_top = $('header').height() + 50;
    /*-------------------------------------------------------------------------------
	  Navbar 
	-------------------------------------------------------------------------------*/

	//* Navbar Fixed  
    function navbarFixed(){
        if ( $('.cc-header').length ){
            $(window).scroll(function() {
                let scroll = $(window).scrollTop();
                if (scroll >= nav_offset_top ) {
                    $(".cc-header").addClass("navbar_fixed");
                } else {
                    $(".cc-header").removeClass("navbar_fixed");
                }
            });
        };
    };
    navbarFixed();

	/*----------------------------------------------------*/
    /*  Rates slider
    /*----------------------------------------------------*/
    rateSlider();
    function rateSlider() {
        let slidercontainer = $('.cc-rates-slider');
        if (slidercontainer.length) {
            slidercontainer.owlCarousel({
                lazyLoad: true,
                loop: true,
                center: true,
                items: 3,
                margin: 0,
                autoplay: false,
                responsiveClass:true,
                dots: true,
                nav: false,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                smartSpeed: 800,
                responsive: {
                    0: {
                        items: 1,
                    },
                    680: {
                        items: 2,
                    },
                    1000: {
                        items: 3,
                    },
                }
            });
        }
    }

	
//	$('.cc-courses').imagesLoaded(function(){
//        $('.cc-courses-inner').isotope({
//            layoutMode: 'masonry',
//			percentPosition: true,
//			masonry: {
//				columnWidth: 1,
//			}
//        })
//    });
	
	
	
	
	/*----------------------------------------------------*/
    /*  portfolio_isotope
    /*----------------------------------------------------*/
   
//	$('.cc-courses-inner').imagesLoaded(function(){
//        $('.cc-courses-inner').isotope({
//            layoutMode: 'masonry',
//            percentPosition:true,
//            masonry: {
//                columnWidth: 1,
//            }            
//        })
//    });
	
	
	/*----------------------------------------------------*/
    /*  Clients Slider
    /*----------------------------------------------------*/
//    function clients_slider(){
//        if ( $('.clients_slider').length ){
//            $('.clients_slider').owlCarousel({
//                loop:true,
//                margin: 30,
//                items: 5,
//                nav: false,
//                autoplay: false,
//                smartSpeed: 1500,
//                dots:false, 
//                responsiveClass: true,
//                responsive: {
//                    0: {
//                        items: 1,
//                    },
//                    400: {
//                        items: 2,
//                    },
//                    575: {
//                        items: 3,
//                    },
//                    768: {
//                        items: 4,
//                    },
//                    992: {
//                        items: 5,
//                    }
//                }
//            })
//        }
//    }
//    clients_slider();
	/*----------------------------------------------------*/
    /*  MailChimp Slider
    /*----------------------------------------------------*/
    function mailChimp(){
        $('#mc_embed_signup').find('form').ajaxChimp();
    }
    mailChimp();
	
	// $('select').niceSelect();
	
	/*----------------------------------------------------*/
    /*  Simple LightBox js
    /*----------------------------------------------------*/
    // $('.imageGallery1 .light').simpleLightbox();
	
	// $('.counter').counterUp({
	// 	delay: 10,
	// 	time: 1000
	// });
	//
	
	// $(document).ready(function() {
	// 	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
	// 		disableOn: 700,
	// 		type: 'iframe',
	// 		mainClass: 'mfp-fade',
	// 		removalDelay: 160,
	// 		preloader: false,
    //
	// 		fixedContentPos: false
	// 	});
	// });
	
	/*----------------------------------------------------*/
    /*  Google map js
    /*----------------------------------------------------*/
     
    if ( $('#mapBox').length ){
        let $lat = $('#mapBox').data('lat');
        let $lon = $('#mapBox').data('lon');
        let $zoom = $('#mapBox').data('zoom');
        let $marker = $('#mapBox').data('marker');
        let $info = $('#mapBox').data('info');
        let $markerLat = $('#mapBox').data('mlat');
        let $markerLon = $('#mapBox').data('mlon');
        let map = new GMaps({
        el: '#mapBox',
        lat: $lat,
        lng: $lon,
        scrollwheel: false,
        scaleControl: true,
        streetViewControl: false,
        panControl: true,
        disableDoubleClickZoom: true,
        mapTypeControl: false,
        zoom: $zoom,
            styles: [
                {
                    "featureType": "water",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#dcdfe6"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "stylers": [
                        {
                            "color": "#808080"
                        },
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#dcdfe6"
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#ffffff"
                        },
                        {
                            "weight": 1.8
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#d7d7d7"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#ebebeb"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#a7a7a7"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#efefef"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "color": "#696969"
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#737373"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#d6d6d6"
                        }
                    ]
                },
                {
                    "featureType": "road",
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {},
                {
                    "featureType": "poi",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#dadada"
                        }
                    ]
                }
            ]
        });
    }
	

})(jQuery)