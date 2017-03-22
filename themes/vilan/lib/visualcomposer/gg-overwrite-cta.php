<?php
vc_remove_param ('vc_cta_button2', 'h2' );
vc_remove_param ('vc_cta_button2', 'h4' );
vc_remove_param ('vc_cta_button2', 'style' );
vc_remove_param ('vc_cta_button2', 'el_width' );
vc_remove_param ('vc_cta_button2', 'txt_align' );
vc_remove_param ('vc_cta_button2', 'accent_color' );
vc_remove_param ('vc_cta_button2', 'content' );
vc_remove_param ('vc_cta_button2', 'link' );
vc_remove_param ('vc_cta_button2', 'title' );
vc_remove_param ('vc_cta_button2', 'btn_style' );
vc_remove_param ('vc_cta_button2', 'color' );
vc_remove_param ('vc_cta_button2', 'size' );
vc_remove_param ('vc_cta_button2', 'position' );
vc_remove_param ('vc_cta_button2', 'el_class' );
vc_remove_param ('vc_cta_button2', 'css_animation' );

$gg_theme_colors['Default'] = 'theme_color_default';

vc_add_param( 'vc_cta_button2', array(
      "type" => "textfield",
      "heading" => __("Heading first line", "js_composer"),
      "holder" => "h2",
      "param_name" => "h2",
      "value" => __("Hey! I am first heading line feel free to change me", "js_composer"),
      "description" => __("Text for the first heading line.", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "textarea",
      "holder" => "div",
      "heading" => __("Promotional text", "js_composer"),
      "param_name" => "content",
      "value" => __("<p>I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("CTA style", "js_composer"),
      "param_name" => "style",
      "value" => $cta_styles,
      "description" => __("Call to action style.", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("Element width", "js_composer"),
      "param_name" => "el_width",
      "value" => $el_widths,
      "description" => __("Call to action element width in percents.", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("Text align", "js_composer"),
      "param_name" => "txt_align",
      "value" => $txt_align,
      "description" => __("Text align in call to action block.", "js_composer")
    ) );
//Add theme button param (Color)
vc_add_param( 'vc_cta_button2', array(
      "type" => "colorpicker",
      "heading" => __("Background Color", "wpb"),
      "param_name" => "accent_color",
      "description" => __("Select background color for your element.", "wpb")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "colorpicker",
      "heading" => __("Custom Text Color", "wpb"),
      "param_name" => "text_accent_color",
      "description" => __("Select the text color for your element.", "wpb"),
      "dependency" => Array('element' => "block_background_color", 'value' => array('theme_custom_color'))
    ) );

vc_add_param( 'vc_cta_button2', array(
      "type" => "vc_link",
      "heading" => __("URL (Link)", "js_composer"),
      "param_name" => "link",
      "description" => __("Button link.", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "textfield",
      "heading" => __("Text on the button", "js_composer"),
      //"holder" => "button",
      //"class" => "wpb_button",
      "param_name" => "title",
      "value" => __("Text on the button", "js_composer"),
      "description" => __("Text on the button.", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("Button style", "js_composer"),
      "param_name" => "btn_style",
      "value" => $button_styles,
      "description" => __("Button style.", "js_composer")
    ) );
vc_add_param("vc_cta_button2", array(
      "type" => "colorpicker",
      "heading" => __("Button Color", "js_composer"),
      "param_name" => "color",
      "description" => __("Select custom color for your button.", "js_composer")
));
//Add theme button param (Color)
vc_add_param("vc_cta_button2", array(
      "type" => "colorpicker",
      "heading" => __("Text Color", "js_composer"),
      "param_name" => "text_color",
      "description" => __("Select custom color for your button text.", "js_composer")
));
//Add theme button param (Icon check)
vc_add_param ('vc_cta_button2', array(
       "type" => "checkbox",
       "heading" => __("Icon?", "okthemes"),
       "value" => array(__("Use an icon for your button.", "okthemes") => "use_icon" ),
       "param_name" => "add_icon"
    ) );
//Add theme button param (Icon)
vc_add_param ('vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("Icon", "js_composer"),
      "param_name" => "icon",
      "value" => $gg_icons_array,
      "description" => __("Button icon.", "js_composer"),
      "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
    ) );
//Add theme button param (Align)
vc_add_param( 'vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("Icon align", "js_composer"),
      "param_name" => "icon_align",
      "value" => $align_array,
      "description" => __("Icon align.", "js_composer"),
      "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("Size", "js_composer"),
      "param_name" => "size",
      "value" => $sizes,
      "std" => 'md',
      "description" => __("Button size.", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', array(
      "type" => "dropdown",
      "heading" => __("Button position", "js_composer"),
      "param_name" => "position",
      "value" => array(__("Align right", "js_composer") => "right", __("Align left", "js_composer") => "left", __("Align bottom", "js_composer") => "bottom"),
      "description" => __("Select button alignment.", "js_composer")
    ) );

vc_add_param( 'vc_cta_button2', array(
      "type" => "textfield",
      "heading" => __("Extra class name", "js_composer"),
      "param_name" => "el_class",
      "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
    ) );
vc_add_param( 'vc_cta_button2', $add_css_animation);

?>