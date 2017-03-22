<?php
//Remove the link to option
vc_remove_param ('vc_single_image', 'css' );
vc_remove_param ('vc_single_image', 'style' );
vc_remove_param ('vc_single_image', 'img_size' );
vc_remove_param ('vc_single_image', 'border_color' );
vc_remove_param ('vc_single_image', 'onclick' );
vc_remove_param ('vc_single_image', 'add_caption' );
vc_remove_param ('vc_single_image', 'img_link_target' );
vc_remove_param ('vc_single_image', 'alignment' );
vc_remove_param ('vc_single_image', 'link' );


vc_add_param("vc_single_image", array(
      "type" => "textfield",
      "heading" => __("Image link", "js_composer"),
      "param_name" => "link",
      "description" => __("Insert the image link here", "js_composer")
  )
);

//Image size
vc_add_param("vc_single_image", array(
      "type" => "dropdown",
      "heading" => __("Image size", "js_composer"),
      "param_name" => "img_size",
      "value" => array(__("Full size", "js_composer") => "fullsize", __("Custom size", "js_composer") => "customsize"),
      "description" => __("Choose the image size", "js_composer")
  )
);
vc_add_param("vc_single_image", array(
      "type" => "dropdown",
      "heading" => __("Image style", "js_composer"),
      "param_name" => "img_style",
      "value" => $img_style_arr,
      "std" => "default",
      "description" => __("Choose the image style", "js_composer")
  )
);
vc_add_param("vc_single_image", array(
      "type" => "textfield",
      "heading" => __("Custom size - width", "js_composer"),
      "param_name" => "customsize_width",
      "description" => __("Insert the width of the image", "js_composer"),
      "dependency" => Array('element' => "img_size", 'value' => array('customsize'))
  )
);
vc_add_param("vc_single_image", array(
      "type" => "textfield",
      "heading" => __("Custom size - height", "js_composer"),
      "param_name" => "customsize_height",
      "description" => __("Insert the height of the image", "js_composer"),
      "dependency" => Array('element' => "img_size", 'value' => array('customsize'))
  )
);


vc_add_param("vc_single_image", array(
  "type" => "checkbox",
  "class" => "",
  "heading" => __("Overlay effect?","okthemes"),
  "value" => array(__("Add an overlay effect?","okthemes") => "add_overlay" ),
  "param_name" => "overlay",
  "description" => __("Adds an overlay effect like the portfolio post.","okthemes")
));

vc_add_param("vc_single_image", array(
  "type" => "textfield",
  "class" => "",
  "heading" => __("Insert title","okthemes"),
  "value" => "",
  "param_name" => "lightbox_title",
  "description" => __("Adds a title to the overlay","okthemes"),
  "dependency" => Array('element' => "overlay", 'value' => array('add_overlay'))
));

vc_add_param("vc_single_image", array(
  "type" => "textfield",
  "class" => "",
  "heading" => __("Insert subtitle","okthemes"),
  "value" => "",
  "param_name" => "lightbox_subtitle",
  "description" => __("Adds a subtitle to the overlay","okthemes"),
  "dependency" => Array('element' => "overlay", 'value' => array('add_overlay'))
));

vc_add_param("vc_single_image", array(
  "type" => 'checkbox',
  "heading" => __("Link to large image?", "okthemes"),
  "param_name" => "img_link_large",
  "description" => __("If selected, image will be linked to the bigger image.", "okthemes"),
  "value" => Array(__("Yes, please", "okthemes") => 'yes')
));

?>