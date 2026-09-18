( function () {
	'use strict';

	function initCarousel( $scope ) {
		var $swiper = $scope.find( '.sgcc-swiper' ).first();

		if ( ! $swiper.length || ! window.Swiper ) {
			return;
		}

		var config = {};
		try {
			config = JSON.parse( $swiper.attr( 'data-sgcc-settings' ) || '{}' );
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
				nextEl: $scope.find( '.sgcc-nav--next' ).get( 0 ),
				prevEl: $scope.find( '.sgcc-nav--prev' ).get( 0 ),
			};
		}

		if ( config.showDots ) {
			swiperOptions.pagination = {
				el: $swiper.find( '.sgcc-pagination' ).get( 0 ),
				clickable: true,
			};
		}

		if ( $swiper.data( 'sgcc-swiper-instance' ) ) {
			$swiper.data( 'sgcc-swiper-instance' ).destroy( true, true );
		}

		var instance = new window.Swiper( $swiper.get( 0 ), swiperOptions );
		$swiper.data( 'sgcc-swiper-instance', instance );
	}

	window.addEventListener( 'elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/sgcc-card-carousel.default', initCarousel );
	} );
}() );
