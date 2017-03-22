jQuery(document).ready(function($) {

	//Logo section
	var logo_trigger 					= $('#customize-control-logo_check input');
	var admin_logo_trigger 				= $('#customize-control-admin_logo_check input');
	var logo_control_options  			= $('#customize-control-main_logo, #customize-control-main_logo_retina, #customize-control-logo_width, #customize-control-logo_height, #customize-control-logo_margin_top');
	var admin_logo_control_options  	= $('#customize-control-admin_logo, #customize-control-admin_logo_width, #customize-control-admin_logo_height');

	if (!logo_trigger.is(':checked')) {
		logo_control_options.css('display', 'none');
	}
	if (!admin_logo_trigger.is(':checked')) {
		admin_logo_control_options.css('display', 'none');
	}

	logo_trigger.change( function() {
		if (logo_trigger.is(':checked')) {
			logo_control_options.css('display', 'block');
		} else {
			logo_control_options.css('display', 'none');
		}
	});
	admin_logo_trigger.change( function() {
		if (admin_logo_trigger.is(':checked')) {
			admin_logo_control_options.css('display', 'block');
		} else {
			admin_logo_control_options.css('display', 'none');
		}
	});

	//Header section
	var top_header_trigger 					= $('#customize-control-top_header_bar input');
	var header_search_trigger 				= $('#customize-control-header_search_form input');
	var top_header_control_options  		= $('#customize-control-header_text_line_check, #customize-control-header_text_line, #customize-control-header_social_icons');
	var header_search_control_options  		= $('#customize-control-header_search_form_display');

	if (!top_header_trigger.is(':checked')) {
		top_header_control_options.css('display', 'none');
	}
	if (!header_search_trigger.is(':checked')) {
		header_search_control_options.css('display', 'none');
	}

	top_header_trigger.change( function() {
		if (top_header_trigger.is(':checked')) {
			top_header_control_options.css('display', 'block');
		} else {
			top_header_control_options.css('display', 'none');
		}
	});
	header_search_trigger.change( function() {
		if (header_search_trigger.is(':checked')) {
			header_search_control_options.css('display', 'block');
		} else {
			header_search_control_options.css('display', 'none');
		}
	});

	//Footer section
	var footer_extras_trigger 						= $('#customize-control-footer_extras input');
	var footer_extras_control_options 				= $('#customize-control-footer_extras_copyright, #customize-control-footer_extras_menu');

	if (!footer_extras_trigger.is(':checked')) {
		footer_extras_control_options.css('display', 'none');
	}
	
	footer_extras_trigger.change( function() {
		if (footer_extras_trigger.is(':checked')) {
			footer_extras_control_options.css('display', 'block');
		} else {
			footer_extras_control_options.css('display', 'none');
		}
	});

	//Background section

	var background_type_select 					= $('#accordion-section-background_image select');
	var background_type_control_patterns  		= $('#customize-control-background_type_patterns');
	var background_type_control_image  			= $('#customize-control-background_image');
	
	background_type_select.change( function() {
		
		if($(this).val() == 'none') {
			background_type_control_patterns.css('display', 'none');
			background_type_control_image.css('display', 'none');
			
		} else if($(this).val() == 'image') {
			background_type_control_image.css('display', 'block');
			background_type_control_patterns.css('display', 'none');
		
		} else if($(this).val() == 'pattern') {
			background_type_control_image.css('display', 'none');
			background_type_control_patterns.css('display', 'block');
			
		} else {
			background_type_control_patterns.css('display', 'none');
			background_type_control_image.css('display', 'none');

		}
		
	});

	if ($("#accordion-section-background_image select option[value='none']").attr('selected')) { 
		background_type_control_patterns.css('display', 'none');
		background_type_control_image.css('display', 'none');
	}
		
	if ($("#accordion-section-background_image select option[value='image']").attr('selected')) { 
		background_type_control_patterns.css('display', 'none');
		background_type_control_image.css('display', 'block');
	}

	if ($("#accordion-section-background_image select option[value='pattern']").attr('selected')) { 
		background_type_control_patterns.css('display', 'block');
		background_type_control_image.css('display', 'none');
	}
	
});