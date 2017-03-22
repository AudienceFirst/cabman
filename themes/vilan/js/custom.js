if (typeof(Ecwid) == 'object') {
  Ecwid.OnAPILoaded.add(function() {
    Ecwid.OnPageLoaded.add(function(page) {

    	if ( !jQuery("#subheader .ecwid-shopping-cart-search").length ) {
    		
    	
	    	jQuery(".entry-content .ecwid-SearchPanel").addClass('input-group');
	    	jQuery(".entry-content .ecwid-SearchPanel-field").addClass('form-control');
	    	jQuery("<span class='input-group-addon'><i class='icon_search'></i></span>").insertBefore(".entry-content .ecwid-SearchPanel-field");

			jQuery(".entry-content .ecwid-SearchPanel-button").wrap("<span class='input-group-btn'></span>");

			jQuery(".entry-content .ecwid-shopping-cart-search").addClass('container').insertAfter("#subheader .container");
    	}

    });
  });
}


(function ($) {
"use strict";

/* bwmap */
function gg_bwmap_init() {
	if($('#bwmap').length > 0){
		$( '#bwmap' ).each(function(){

			var $this = $(this),
			latitude = $this.attr('data-latitude'),
			longitude = $this.attr('data-longitude'),
			infow = $this.attr('data-infow'),
			infowtitle = $this.attr('data-infowtitle'),
			infowcontent = $this.attr('data-infowcontent'),
			mapzoom = $this.attr('data-zoom');

			var map;
        	var bwmap = new google.maps.LatLng(latitude, longitude);

        	function initialize() {

	            var mapOptions = {
	                zoom: 14,
	                scrollwheel: false,
	                center: bwmap,
	                mapTypeId: google.maps.MapTypeId.ROADMAP,
	          		styles : [{featureType:'all',stylers:[{saturation:-100},{gamma:0.0}]}]
	            };

	            map = new google.maps.Map(document.getElementById('bwmap'),
	                mapOptions);

	            var marker = new google.maps.Marker({
					position: bwmap,
					map: map
				});

	            if (infow =='use_infow') {
					var contentString = '<div id="content">'+
				      '<div id="siteNotice">'+
				      '</div>'+
				      '<h1 id="firstHeading" class="firstHeading">' + infowtitle + '</h1>'+
				      '<div id="bodyContent">'+
				      '<p>' + infowcontent + '</p>'+
				      '</div>'+
				      '</div>';

		            var infowindow = new google.maps.InfoWindow({
					    content: contentString
					});

		            google.maps.event.addListener(marker, 'click', function() {
						infowindow.open(map,marker);
					});
				}

	        }

        google.maps.event.addDomListener(window, 'load', initialize);

		});
	}
}

function gg_isotope_init() {
	if($('.image-grid:not(.owl-carousel), .team-grid:not(.owl-carousel), .testimonials-grid:not(.owl-carousel)').length > 0){
	    var layout_modes = {
	        fitrows: 'fitRows',
	        masonry: 'masonry'
	    }
	    jQuery('.gg_posts_grid').each(function(){
	        var $container = jQuery(this);
	        var $thumbs = $container.find('.image-grid:not(.owl-carousel), .team-grid:not(.owl-carousel), .testimonials-grid:not(.owl-carousel)');
	        var layout_mode = $thumbs.attr('data-layout-mode');
	        $thumbs.isotope({
	            // options
	            itemSelector : '.isotope-item',
	            layoutMode : (layout_modes[layout_mode]==undefined ? 'fitRows' : layout_modes[layout_mode])
	        });
	        $container.find('.categories_filter a').data('isotope', $thumbs).click(function(e){
	            e.preventDefault();
	            var $thumbs = jQuery(this).data('isotope');
	            jQuery(this).parent().parent().find('.active').removeClass('active');
	            jQuery(this).parent().addClass('active');
	            $thumbs.isotope({filter: jQuery(this).attr('data-filter')});
	        });
	        jQuery(window).bind('load resize', function() {
	            $thumbs.isotope("layout");
	        });
	    });
	}
}

/* Magnific */
// function gg_magnific_init() {
// 	if($('.image-grid, article.post figure.effect-sadie figcaption, .team-grid, .owl-carousel.has_magnific, .wpb_image_grid.has_magnific, .wpb_single_image.has_magnific').length > 0){
// 		$( '.image-grid, article.post figure.effect-sadie figcaption, .team-grid, .owl-carousel.has_magnific, .wpb_image_grid.has_magnific, .wpb_single_image.has_magnific' ).each(function(){
// 			$(this).magnificPopup({
// 				delegate: 'a.lightbox-el',
// 				type: 'image',
// 				gallery: {
// 		            enabled: true
// 		        },
// 				callbacks: {
// 				    elementParse: function(item) {
// 				      if(item.el.context.className == 'lightbox-el link-wrapper lightbox-video') {
// 				         item.type = 'iframe';
// 				      } else {
// 				         item.type = 'image';
// 				      }
// 				    }
// 				}
// 			});
// 		});
// 	}
// }

/* OwlCarousel */
function gg_owlcarousel_init() {
	if($('.owl-carousel').length > 0){
		$( '.owl-carousel' ).each(function(){

			var $this = $(this),
			slidesPerView = $this.attr('data-slides-per-view'),
			singleItemData = $this.attr('data-single-item') == "true" ? true : false,
			mouseDragData = $this.attr('data-mouse-drag') == "true" ? true : false,
			transitionSlide = $this.attr('data-transition-slide'),
			navigationData = $this.attr('data-navigation-owl') == "true" ? true : false,
			paginationData = $this.attr('data-pagination-owl') == "true" ? true : false,
			lazyloadData = $this.attr('data-lazyload') == "true" ? true : false,
			autoplayData = $this.attr('data-autoplay') == "3000" ? 3000 : false,
			rewindData = $this.attr('data-rewind') == "true" ? true : false,
			speedData = $this.attr('data-speed'),
			pagColor = $this.attr('data-pag-color'),
			cID = $this.attr('data-c-id'),
			heightData = $this.attr('data-height') == "true" ? true : false,
			afterInitData = $this.attr('data-afterinit') == "navColor" ? navColor : '';

			$this.owlCarousel({
			    items : slidesPerView,
			    navigation : navigationData,
			    pagination : paginationData,
			    lazyLoad : lazyloadData,
			    navigationText: [
					"<i class='arrow_carrot-left_alt2'></i>",
					"<i class='arrow_carrot-right_alt2'></i>"
					],
			    
			    singleItem : singleItemData,
			    mouseDrag : mouseDragData,
			    transitionStyle : transitionSlide, //fade, backSlide, goDown, scaleUp
			    autoPlay : autoplayData,
			    rewindNav : rewindData,
			    slideSpeed : speedData,
			    autoHeight : heightData,
			    addClassActive : true,
			    afterInit: navColor,
			    afterUpdate: navColor
		  	});

		  	$(".owl-controls.clickable .owl-page").click(function(){
		  	 $(".owl-item h1").removeClass("animated fadeInDown");
		     $(".owl-item.active h1").addClass("animated fadeInDown");

		     $(".owl-item p").removeClass("animated fadeInUp delay-05s");
		     $(".owl-item.active p").addClass("animated fadeInUp delay-05s");

		     $(".owl-item a.btn").removeClass("animated fadeInUp");
		     $(".owl-item.active a.btn").addClass("animated fadeInUp");

		   });

			//function for thumbnail navigation
		  	function navColor() {

			  	if ($('.owl-carousel[data-pag-color="' + pagColor + '" ]').length > 0){	
			  		$('.owl-carousel[data-pag-color="' + pagColor + '" ]').find('.owl-controls .owl-page span, .owl-controls .owl-buttons > div').css('background-color',pagColor);
			  	}

		    }

		});

	}
}

/* Counter */
function gg_counter_init(){
	if($('.counter').length > 0){
		jQuery('.counter-holder').waypoint(function() {
			$('.counter').each(function() {
				if(!$(this).hasClass('initialized')){
					$(this).addClass('initialized');
					var $this = $(this),
					countToNumber = $this.attr('data-number'),
					refreshInt = $this.attr('data-interval'),
					speedInt = $this.attr('data-speed');

					$(this).countTo({
						from: 0,
						to: countToNumber,
						speed: speedInt,
						refreshInterval: refreshInt
					});
				}
			});
		}, { offset: '85%' });
	}
}

/* Parallax */
function gg_parallax_init() {
if($('body:not(.vilan-agent-devices) .parallax-container').length){
			var $scroll = 0;
		    $(window).scroll(function() {
				"use strict";
				$scroll = $(window).scrollTop();
			});
			$('body:not(.vilan-agent-devices) .parallax-container').each(function() {
				var $self = $(this);
				var section_height = $self.attr('parallax-data-height');
				$self.height(section_height);
				var rate = (section_height / $(document).height()) * 0.7;
				
				var distance = $scroll - $self.offset().top + 104;
				var bpos = - (distance * rate);
				$self.css({'background-position': '0 0', 'background-attachment': 'fixed' });
				$(window).bind('scroll', function() {
					var distance = $scroll - $self.offset().top + 104;
					var bpos = - (distance * rate);
					$self.css({'background-position': 'center ' + bpos  + 'px', 'background-attachment': 'fixed' });
				});
			});
		return this;
	}
}

/* Video background */
function gg_video_background_init() {
if($('body:not(.vilan-agent-devices) .video-container').length){
		$('body:not(.vilan-agent-devices) .video-container').each(function() {
			var $this = $(this),
			height = $this.attr('video-data-height'),
			video_mp4 = $this.attr('video-data-mp4'),
			video_webm = $this.attr('video-data-webm'),
			video_ogv = $this.attr('video-data-ogv'),
			unique_id = 1 + Math.floor(Math.random() * 10);

			$(this).css('height', height).prepend('<div class="video-background "></div><div class="video-main-controls controls-'+unique_id+'"></div>');

			jQuery(".video-background").videobackground({
				videoSource: [
					[video_mp4, "video/mp4"],
					[video_webm, "video/webm"],
					[video_ogv, "video/ogg"]
				],
				controlPosition: ".video-main-controls.controls-"+unique_id+"", 
				resize: false, 
				loop: true,
				muted: true
			});

		});
	}
}

$(document).ready(function () {

	gg_owlcarousel_init();
    //gg_magnific_init();
    gg_counter_init();
    gg_isotope_init();
    gg_bwmap_init();
    gg_parallax_init();
    gg_video_background_init();


    //Go to link if viewport > 768, else open on click
    function bindNavbar() {
		if ($(window).width() > 768) {
			$('.dropdown-toggle').click(function() {
				if ($(this).next('.sub-menu').is(':visible')) {
					window.location = $(this).attr('href');
				}
			});
		}
	}
	
	$(window).resize(function() {
		bindNavbar();
	});
	
	bindNavbar();

	//jPlayer - Rezize the contatiner correctly
    if(jQuery().jPlayer && jQuery('.jp-interface').length){
		jQuery('.jp-interface').each(function(){ 
			var playerwidth = jQuery(this).width();	
			var newwidth = playerwidth - 220;

			if (jQuery('.col-md-4.grid-cat-post-formats').length) {
				newwidth = playerwidth - 160;
			}
			jQuery(this).find('.jp-progress-container').css({ width: newwidth+'px' });
		});
	}

	//Sticky header
	if( $('body').hasClass('gg-header-is-sticky') ) {
	    //caches a jQuery object containing the header element
	    var header = $(".navbar-default");
	    $(window).scroll(function() {
	        var scroll = $(window).scrollTop();

	        if (scroll >= 10) {
	            header.removeClass('notscrolled').addClass("scrolled");
	        } else {
	            header.removeClass("scrolled").addClass('notscrolled');
	        }
	    });
	}

   
	// here for the submit button of the comment reply form
	$( '#submit, input[type="button"], input[type="reset"], input[type="submit"]' ).addClass( 'btn btn-primary' );	
	
	$( 'table#wp-calendar' ).addClass( 'table table-striped');

	$( 'table' ).not('.variations').addClass( 'table');

	$( 'form' ).not('.header-search form, .variations_form').addClass( 'table');

	$('form').attr('role', 'form');

	var inputs = $('input, textarea')
            .not(':input[type=button], :input[type=submit], :input[type=reset]');

	$(inputs).each(function() {
	    $(this).addClass('form-control');
	});

});

})(jQuery);