<?php
vc_remove_param ('vc_button2', 'color' );
vc_remove_param ('vc_button2', 'size' );
vc_remove_param ('vc_button2', 'el_class' );

//Add theme button param (Color)
vc_add_param("vc_button2", array(
      "type" => "colorpicker",
      "heading" => __("Button Color", "js_composer"),
      "param_name" => "color",
      "description" => __("Select custom color for your button.", "js_composer")
));
//Add theme button param (Color)
vc_add_param("vc_button2", array(
      "type" => "colorpicker",
      "heading" => __("Text Color", "js_composer"),
      "param_name" => "text_color",
      "description" => __("Select custom color for your button text.", "js_composer")
));
//Add theme button param (Icon check)
vc_add_param ('vc_button2', array(
       "type" => "checkbox",
       "heading" => __("Icon?", "okthemes"),
       "value" => array(__("Use an icon for your button.", "okthemes") => "use_icon" ),
       "param_name" => "add_icon"
    ) );
//Add theme button param (Icon)
vc_add_param ('vc_button2', array(
      "type" => "dropdown",
      "heading" => __("Icon", "js_composer"),
      "param_name" => "icon",
      "value" => $gg_icons_array,
      "description" => __("Button icon.", "js_composer"),
      "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
    ) );
//Add theme button param (Align)
vc_add_param( 'vc_button2', array(
      "type" => "dropdown",
      "heading" => __("Icon align", "js_composer"),
      "param_name" => "icon_align",
      "value" => $align_array,
      "description" => __("Icon align.", "js_composer"),
      "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
    ) );
//Add theme button param (Size)
vc_add_param( 'vc_button2', array(
      "type" => "dropdown",
      "heading" => __("Size", "js_composer"),
      "param_name" => "size",
      'value' => $sizes,
      "std" => 'md',
      "description" => __("Button size.", "js_composer")
    ) );
//Add theme button param (Align)
vc_add_param ('vc_button2', array(
       "type" => "checkbox",
       "heading" => __("Block button?", "okthemes"),
       "value" => array(__("Is this a block button?", "okthemes") => "use_block_button" ),
       "param_name" => "block_button",
       "description" => __("A block button spans the full width of the parent element.", "okthemes")
    ) );
//Add theme button param (Margin)
vc_add_param( 'vc_button2', array(
      "type" => "textfield",
      "heading" => __("Margin", "js_composer"),
      "param_name" => "margin",
      "description" => __("Apply a margin to the button, in pixels. Eg. 20px 0 0 0", "js_composer")
    ) );
//Add theme button param (Class name)
vc_add_param( 'vc_button2', array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    ) );
?>