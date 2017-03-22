<?php
//vc_remove_param ('vc_column_inner', 'css' );

vc_add_param("vc_column_inner", array(
  "type" => "colorpicker",
  "heading" => __("Column background color", "js_composer"),
  "param_name" => "column_background_color",
  "description" => __("Select custom background color for column.", "js_composer")
));

vc_add_param("vc_column_inner", array(
  "type" => "textfield",
  "heading" => __('Padding', 'js_composer'),
  "param_name" => "padding",
  "description" => __("You can use px, em, %, etc. or enter just number and it will use pixels. ", "js_composer")
));

?>