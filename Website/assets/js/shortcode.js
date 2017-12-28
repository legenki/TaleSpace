jQuery( function( $ ){

	var javo_directory_shortcode_js = function(){
		this.init();
	}

	javo_directory_shortcode_js.prototype = {

		constructor : javo_directory_shortcode_js,

		init : function(){

			var obj = this;
			obj.inlineblock();

		},

		inlineblock : function() {
			var
				obj = this,
				container = $( '.jv-inline-category-slider' );

			container.each( function() {

				var element = $( '.owl-carousel', this );

				element.owlCarousel({
					items				: parseInt( element.data( 'max' ) ), //10 items above 1000px browser width
					itemsDesktop		: [1000,5], //5 items between 1000px and 901px
					itemsDesktopSmall	: [900,3], // 3 items betweem 900px and 601px
					itemsTablet			: [600,2], //2 items between 600 and 0;
					itemsMobile			: false // itemsMobile disabled - inherit from itemsTablet option
				});

				$( this )
					.on( 'click', '.next', function(){ element.trigger( 'owl.next' ); } )
					.on( 'click', '.prev', function(){ element.trigger( 'owl.prev' ); } )
					.on( 'click', '.play', function(){ element.trigger( 'owl.play', 1000 ); } )
					.on( 'click', '.stop', function(){ element.trigger( 'owl.stop' ); } );

			} );

			 return obj;
		 }

	}

	new javo_directory_shortcode_js;

} );