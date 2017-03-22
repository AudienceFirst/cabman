/*-----------------------------------------------------------------------------------

 	Custom JS for metabox display
 
-----------------------------------------------------------------------------------*/
 
jQuery(document).ready(function() {

	
/*----------------------------------------------------------------------------------*/
/*	Setup pages
/*----------------------------------------------------------------------------------*/

	var portfolio_page_meta = jQuery('#portfolio_page_meta');
	portfolio_page_meta.css('display', 'none');	

	var contact_page_meta = jQuery('#contact_page_meta');
	contact_page_meta.css('display', 'none');

	var team_page_meta = jQuery('#team_page_meta');
	team_page_meta.css('display', 'none');

	var testimonials_page_meta = jQuery('#testimonials_page_meta');
	testimonials_page_meta.css('display', 'none');

	var portfolio_cpt_meta_lightbox_image = jQuery('#portfolio_cpt_meta_lightbox_image');
	portfolio_cpt_meta_lightbox_image.css('display', 'none');

	var portfolio_cpt_meta_lightbox_video = jQuery('#portfolio_cpt_meta_lightbox_video');
	portfolio_cpt_meta_lightbox_video.css('display', 'none');

	var portfolio_cpt_meta_custom_url = jQuery('#portfolio_cpt_meta_custom_url');
	portfolio_cpt_meta_custom_url.css('display', 'none');

	var portfolio_cpt_meta_separate_page = jQuery('#portfolio_cpt_meta_separate_page');
	portfolio_cpt_meta_separate_page.css('display', 'none');	



/*----------------------------------------------------------------------------------*/
/*	OnChange conditions
/*----------------------------------------------------------------------------------*/

	var group = jQuery('#gg_select_portfolio_open_type');
	
	group.change( function() {
		
		if(jQuery(this).val() == '') {
			portfolio_cpt_meta_lightbox_image.css('display', 'none');
			portfolio_cpt_meta_lightbox_video.css('display', 'none');
			portfolio_cpt_meta_custom_url.css('display', 'none');
			portfolio_cpt_meta_separate_page.css('display', 'none');
			
		} else if(jQuery(this).val() == 'lightbox_image') {
			portfolio_cpt_meta_lightbox_image.css('display', 'block');
			tzHideAll(portfolio_cpt_meta_lightbox_image);

		} else if(jQuery(this).val() == 'lightbox_video') {
			portfolio_cpt_meta_lightbox_video.css('display', 'block');
			tzHideAll(portfolio_cpt_meta_lightbox_video);

		} else if(jQuery(this).val() == 'custom_url') {
			portfolio_cpt_meta_custom_url.css('display', 'block');
			tzHideAll(portfolio_cpt_meta_custom_url);
		
		} else if(jQuery(this).val() == 'overlay_page') {
			portfolio_cpt_meta_separate_page.css('display', 'block');
			tzHideAll(portfolio_cpt_meta_separate_page);

		} else if(jQuery(this).val() == 'separate_page') {
			portfolio_cpt_meta_separate_page.css('display', 'block');
			tzHideAll(portfolio_cpt_meta_separate_page);				
		
		} else {
			portfolio_cpt_meta_lightbox_image.css('display', 'none');
			portfolio_cpt_meta_lightbox_video.css('display', 'none');
			portfolio_cpt_meta_custom_url.css('display', 'none');
			portfolio_cpt_meta_separate_page.css('display', 'none');

		}
		
	});

/*----------------------------------------------------------------------------------*/
/*	OnChange conditions - Pages
/*----------------------------------------------------------------------------------*/

	var group_pages = jQuery('#page_template');
	
	group_pages.change( function() {
		
		if(jQuery(this).val() == 'default') {
			portfolio_page_meta.css('display', 'none');
			contact_page_meta.css('display', 'none');
			
		} else if(jQuery(this).val() == 'theme-templates/portfolio.php') {
			portfolio_page_meta.css('display', 'block');
			tzHideAll(portfolio_page_meta);
		
		} else if(jQuery(this).val() == 'theme-templates/contact.php') {
			contact_page_meta.css('display', 'block');
			tzHideAll(contact_page_meta);

		} else if(jQuery(this).val() == 'theme-templates/team.php') {
			team_page_meta.css('display', 'block');
			tzHideAll(team_page_meta);

		} else if(jQuery(this).val() == 'theme-templates/testimonials.php') {
			testimonials_page_meta.css('display', 'block');
			tzHideAll(testimonials_page_meta);	
			
		} else {
			portfolio_page_meta.css('display', 'none');
			contact_page_meta.css('display', 'none');
			team_page_meta.css('display', 'none');
			testimonials_page_meta.css('display', 'none');

		}
		
	});
	
/*----------------------------------------------------------------------------------*/
/*	OnLoad conditions
/*----------------------------------------------------------------------------------*/	
	
	if (jQuery("#gg_select_portfolio_open_type option[value='']").attr('selected')) 
		{ 
			portfolio_cpt_meta_lightbox_image.css('display', 'none');
			portfolio_cpt_meta_lightbox_video.css('display', 'none');
			portfolio_cpt_meta_custom_url.css('display', 'none');
			portfolio_cpt_meta_separate_page.css('display', 'none');
		}
		
	if (jQuery("#gg_select_portfolio_open_type option[value='lightbox_image']").attr('selected')) 
		{ 
			portfolio_cpt_meta_lightbox_image.css('display', 'block');
		}

	if (jQuery("#gg_select_portfolio_open_type option[value='lightbox_video']").attr('selected')) 
		{ 
			portfolio_cpt_meta_lightbox_video.css('display', 'block');
		}

	if (jQuery("#gg_select_portfolio_open_type option[value='custom_url']").attr('selected')) 
		{ 
			portfolio_cpt_meta_custom_url.css('display', 'block');
		}
	
	if (jQuery("#gg_select_portfolio_open_type option[value='overlay_page']").attr('selected')) 
		{ 
			portfolio_cpt_meta_separate_page.css('display', 'block');
		}
	if (jQuery("#gg_select_portfolio_open_type option[value='separate_page']").attr('selected')) 
		{ 
			portfolio_cpt_meta_separate_page.css('display', 'block');
		}				

/*----------------------------------------------------------------------------------*/
/*	OnLoad conditions - Pages
/*----------------------------------------------------------------------------------*/	
	
	if (jQuery("#page_template option[value='default']").attr('selected')) 
		{ 
			portfolio_page_meta.css('display', 'none');
			contact_page_meta.css('display', 'none');
		}
		
	if (jQuery("#page_template option[value='theme-templates/portfolio.php']").attr('selected')) 
		{ 
			portfolio_page_meta.css('display', 'block');
		}

	if (jQuery("#page_template option[value='theme-templates/contact.php']").attr('selected')) 
		{ 
			contact_page_meta.css('display', 'block');
		}

	if (jQuery("#page_template option[value='theme-templates/team.php']").attr('selected')) 
		{ 
			team_page_meta.css('display', 'block');
		}

	if (jQuery("#page_template option[value='theme-templates/testimonials.php']").attr('selected')) 
		{ 
			testimonials_page_meta.css('display', 'block');
		}
		
	function tzHideAll(notThisOne) {
		portfolio_cpt_meta_lightbox_image.css('display', 'none');
		portfolio_cpt_meta_lightbox_video.css('display', 'none');
		portfolio_cpt_meta_custom_url.css('display', 'none');
		portfolio_cpt_meta_separate_page.css('display', 'none');
		portfolio_page_meta.css('display', 'none');
		contact_page_meta.css('display', 'none');
		team_page_meta.css('display', 'none');
		testimonials_page_meta.css('display', 'none');
		notThisOne.css('display', 'block');
	}

		
	//Hide all children divs under the footer meta until checkbox is checked
	jQuery('#general_page_footer_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').hide();

	if(jQuery('#gg_page_footer_box').attr('checked')) {
	    jQuery('#general_page_footer_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').show();
	} else {
	    jQuery('#general_page_footer_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').hide();
	}
	
	jQuery('#gg_page_footer_box').click(function() {
	    jQuery('#general_page_footer_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').toggle(this.checked);
	});

	//Hide all children divs under the header meta until checkbox is checked
	jQuery('#general_page_header_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper:first').hide();

	if(jQuery('#gg_page_header').attr('checked')) {
	    jQuery('#general_page_header_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper:first').show();
	} else {
	    jQuery('#general_page_header_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper:first').hide();
	}
	
	jQuery('#gg_page_header').click(function() {
	    jQuery('#general_page_header_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper:first').toggle(this.checked);
	});

	//Hide all children divs under the slider meta until checkbox is checked
	jQuery('#general_page_header_slideshow_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').hide();

	if(jQuery('#gg_page_header_slider').attr('checked')) {
	    jQuery('#general_page_header_slideshow_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').show();
	} else {
	    jQuery('#general_page_header_slideshow_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').hide();
	}
	
	jQuery('#gg_page_header_slider').click(function() {
	    jQuery('#general_page_header_slideshow_meta .rwmb-meta-box > div').not('.rwmb-field.rwmb-checkbox-wrapper').toggle(this.checked);
	});

	
	//Hide portfolio category selector if filter is enabled
	jQuery('#portfolio_page_meta .rwmb-taxonomy-wrapper').show();

	if(jQuery('#gg_portfolio_cat_filter').is(':checked')) {
		jQuery('#portfolio_page_meta .rwmb-taxonomy-wrapper').hide();
	} else {
		jQuery('#portfolio_page_meta .rwmb-taxonomy-wrapper').show();
	}

	jQuery('#gg_portfolio_cat_filter').click(function() {
	    if( jQuery(this).is(':checked')) {
	        jQuery('#portfolio_page_meta .rwmb-taxonomy-wrapper').hide();
	    } else {
	        jQuery('#portfolio_page_meta .rwmb-taxonomy-wrapper').show();
	    }
	}); 

});