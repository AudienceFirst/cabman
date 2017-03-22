<?php
//vc_remove_param ('vc_row', 'css' );
vc_remove_param ('vc_row', 'el_class' );
vc_remove_param ('vc_row', 'el_id' );
vc_remove_param ('vc_row', 'full_height' );
vc_remove_param ('vc_row', 'full_width' );
vc_remove_param ('vc_row', 'content_placement' );
vc_remove_param ('vc_row', 'video_bg' );
vc_remove_param ('vc_row', 'video_bg_url' );
vc_remove_param ('vc_row', 'video_bg_parallax' );
vc_remove_param ('vc_row', 'gap' );
vc_remove_param ('vc_row', 'columns_placement' );
vc_remove_param ('vc_row', 'equal_height' );
vc_remove_param ('vc_row', 'parallax_image' );
vc_remove_param ('vc_row', 'parallax_speed_video' );



vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"show_settings_on_create"=>true,
	"heading" => __("Row Type", "okthemes"),
	"param_name" => "row_type",
	"value" => array(
		"Row" => "row",
		"Section" => "section"
	)
	
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Type", "okthemes"),
	"param_name" => "type",
	"value" => array(
		"In Container" => "in_container",
		"Full Width" => "fullwidth"	
	),
	"dependency" => Array('element' => "row_type", 'value' => array('section'))
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Parallax effect", "okthemes"),
	"value" => array(__("Use parallax effect?", "okthemes") => "use_parallax" ),
	"param_name" => "parallax"
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Add overlay effect", "okthemes"),
	"value" => array(__("Use overlay effect?", "okthemes") => "use_parallax_overlay" ),
	"param_name" => "parallax_overlay",
	"dependency" => Array('element' => "parallax", 'value' => array('use_parallax'))
));
vc_add_param("vc_row", array(
        'type' => 'colorpicker',
        'heading' => __( 'Parallax overlay background color', 'wpb' ),
        'param_name' => 'parallax_overlay_bg_color',
        'description' => __( 'Select backgound color for your overlay. Use the alpha slider to set the opacity.', 'wpb' ),
        
        "dependency" => Array('element' => "parallax_overlay", 'value' => array('use_parallax_overlay'))
      ));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Parallax section height", "okthemes"),
	"value" => "",
	"param_name" => "parallax_height",
	"description" => __("Insert the section height in pixels. Eg: 200", "okthemes"),
	"dependency" => Array('element' => "parallax", 'value' => array('use_parallax'))
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Video background", "okthemes"),
	"value" => array(__("Use video background?", "okthemes") => "use_video" ),
	"param_name" => "video"
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Video section height", "okthemes"),
	"value" => "",
	"param_name" => "video_height",
	"description" => __("Insert the video section height in pixels. Eg: 200", "okthemes"),
	"dependency" => Array('element' => "video", 'value' => array('use_video'))
));

vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Video overlay", "okthemes"),
	"value" => array(__("Use transparent overlay over video?", "okthemes") => "use_video_overlay" ),
	"param_name" => "video_overlay",
	"dependency" => Array('element' => "video", 'value' => array('use_video'))
));
vc_add_param("vc_row", array(
        'type' => 'colorpicker',
        'heading' => __( 'Video overlay background color', 'wpb' ),
        'param_name' => 'video_overlay_bg_color',
        'description' => __( 'Select backgound color for your overlay. Use the alpha slider to set the opacity.', 'wpb' ),
        
        "dependency" => Array('element' => "video_overlay", 'value' => array('use_video_overlay'))
      ));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Video background (webm) file url", "okthemes"),
	"value" => "",
	"param_name" => "video_webm",
	"dependency" => Array('element' => "video", 'value' => array('use_video'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Video background (mp4) file url", "okthemes"),
	"value" => "",
	"param_name" => "video_mp4",
	"dependency" => Array('element' => "video", 'value' => array('use_video'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Video background (ogv) file url", "okthemes"),
	"value" => "",
	"param_name" => "video_ogv",
	"dependency" => Array('element' => "video", 'value' => array('use_video'))
));

vc_add_param("vc_row", array(
        'type' => 'textfield',
        'heading' => __( 'Extra class name', 'js_composer' ),
        'param_name' => 'el_class',
        'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
      ));

vc_add_param("vc_row",  array(
  "type" => "dropdown",
  "heading" => __("CSS Animation", "okthemes"),
  "param_name" => "css_animation",
  "admin_label" => true,
  "value" => array(__("No", "okthemes") => '', __("Top to bottom", "okthemes") => "top-to-bottom", __("Bottom to top", "okthemes") => "bottom-to-top", __("Left to right", "okthemes") => "left-to-right", __("Right to left", "okthemes") => "right-to-left", __("Appear from center", "okthemes") => "appear"),
  "description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "okthemes"),
  "dependency" => Array('element' => "row_type", 'value' => array('row', 'section'))
  
));
?>