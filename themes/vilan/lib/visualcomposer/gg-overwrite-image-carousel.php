<?php
//Remove the horizontal/vertical option
vc_remove_param ('vc_images_carousel', 'mode' );
vc_remove_param ('vc_images_carousel', 'img_size' );
vc_remove_param ('vc_images_carousel', 'hide_prev_next_buttons' );

//Remove the horizontal/vertical option
vc_remove_param ('vc_images_carousel', 'partial_view' );

//Image style
vc_add_param("vc_images_carousel", array(
      "type" => "dropdown",
      "heading" => __("Image style", "js_composer"),
      "param_name" => "img_style",
      "value" => $img_style_arr,
      "std" => "default",
      "description" => __("Choose the image style", "js_composer")
  )
);

//Image size
vc_add_param("vc_images_carousel", array(
      "type" => "dropdown",
      "heading" => __("Image size", "js_composer"),
      "param_name" => "img_size",
      "value" => array(__("Full size", "js_composer") => "fullsize", __("Custom size", "js_composer") => "customsize"),
      "description" => __("Choose the image size", "js_composer")
  )
);
vc_add_param("vc_images_carousel", array(
      "type" => "textfield",
      "heading" => __("Custom size - width", "js_composer"),
      "param_name" => "customsize_width",
      "description" => __("Insert the width of the image", "js_composer"),
      "dependency" => Array('element' => "img_size", 'value' => array('customsize'))
  )
);
vc_add_param("vc_images_carousel", array(
      "type" => "textfield",
      "heading" => __("Custom size - height", "js_composer"),
      "param_name" => "customsize_height",
      "description" => __("Insert the height of the image", "js_composer"),
      "dependency" => Array('element' => "img_size", 'value' => array('customsize'))
  )
);

//Modify speed value with 200
vc_add_param("vc_images_carousel", array(
      "type" => "textfield",
      "heading" => __("Slider speed", "js_composer"),
      "param_name" => "speed",
      "value" => "200",
      "description" => __("Duration of animation between slides (in ms)", "js_composer")
  )
);

//Modify slides per view with select box
vc_add_param("vc_images_carousel", array(
      "type" => "dropdown",
      "heading" => __("Slides per view", "js_composer"),
      "param_name" => "slides_per_view",
      "value" => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
      "description" => __("Set numbers of slides you want to display at the same time on slider's container for carousel mode.", "js_composer")
  )
);



//Add transition style
vc_add_param("vc_images_carousel", array(
      "type" => "dropdown",
      "heading" => __("Transition style", "js_composer"),
      "param_name" => "transition_style",
      "value" => array(__("Fade", "js_composer") => "fade", __("Back Slide", "js_composer") => "backSlide", __("Go Down", "js_composer") => "goDown", __("Scale Up", "js_composer") => "scaleUp"),
      "description" => __("Set the transition style if slides per view = 1", "js_composer"),
      "dependency" => Array('element' => "slides_per_view", 'value' => array('1'))
  )
);

vc_add_param("vc_images_carousel", $add_css_animation);

?>