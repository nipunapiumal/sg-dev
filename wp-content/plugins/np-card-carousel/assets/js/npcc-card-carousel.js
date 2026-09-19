( function () {
	'use strict';

	function initCarousel( $scope ) {
		var $swiper = $scope.find( '.npcc-swiper' ).first();

		if ( ! $swiper.length || ! window.Swiper ) {
			return;
		}

		var config = {};
		try {
			config = JSON.parse( $swiper.attr( 'data-npcc-settings' ) || '{}' );
		} catch ( e ) {
			config = {};
		}

		var baseSpaceBetween = config.spaceBetweenMobile != null ? config.spaceBetweenMobile : ( config.spaceBetween || 0 );
		var tabletSpaceBetween = config.spaceBetweenTablet != null ? config.spaceBetweenTablet : ( config.spaceBetween || 0 );
		var desktopSpaceBetween = config.spaceBetween || 0;

		var swiperOptions = {
			slidesPerView: 1,
			spaceBetween: baseSpaceBetween,
			loop: !! config.loop,
			speed: config.speed || 500,
			autoplay: config.autoplay || false,
			breakpoints: {
				768: {
					slidesPerView: config.slidesPerViewTablet || 2,
					spaceBetween: tabletSpaceBetween,
				},
				1025: {
					slidesPerView: config.slidesPerView || 3,
					spaceBetween: desktopSpaceBetween,
				},
			},
		};

		if ( config.showArrows ) {
			swiperOptions.navigation = {
				nextEl: $scope.find( '.npcc-nav--next' ).get( 0 ),
				prevEl: $scope.find( '.npcc-nav--prev' ).get( 0 ),
			};
		}

		if ( config.showDots ) {
			swiperOptions.pagination = {
				el: $swiper.find( '.npcc-pagination' ).get( 0 ),
				clickable: true,
			};
		}

		if ( $swiper.data( 'npcc-swiper-instance' ) ) {
			$swiper.data( 'npcc-swiper-instance' ).destroy( true, true );
		}

		var instance = new window.Swiper( $swiper.get( 0 ), swiperOptions );
		$swiper.data( 'npcc-swiper-instance', instance );
	}

	window.addEventListener( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/npcc-card-carousel.default', initCarousel );
	} );
}() );
