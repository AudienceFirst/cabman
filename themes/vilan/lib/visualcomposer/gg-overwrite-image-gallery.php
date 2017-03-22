<?php
//Remove the interval option
vc_remove_param ('vc_gallery', 'interval' );
vc_remove_param ('vc_gallery', 'type' );

vc_add_param("vc_gallery", array(
      "type" => "dropdown",
      "heading" => __("Image style", "js_composer"),
      "param_name" => "img_style",
      "value" => $img_style_arr,
      "std" => "default",
      "description" => __("Choose the image style", "js_composer")
  )
);

vc_add_param("vc_gallery", $add_css_animation);

?>