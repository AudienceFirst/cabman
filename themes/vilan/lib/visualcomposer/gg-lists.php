<?php
class WPBakeryShortCode_gg_lists extends WPBakeryShortCode {

    public function __construct() {  
        add_shortcode('lists', array($this, 'gg_lists'));  
    }


    public function gg_lists( $atts, $content = null ) { 

    $output = $title = $subtitle = '';
    extract(shortcode_atts(array(
        'title'            => '',
        'css_animation'    => '',
        'icon'             => '',
        'add_icon'         => '',
        'list_li'          => '',
        'icon_color'       => '',
        'add_list_group'   => '' 
        ), 
    $atts));

    //Use icon
    if ($add_icon == 'use_icon') {
        
        if ($icon_color != "") {
            $icon_color = 'style="color:'.$icon_color.'"';  
        }

        $icon = '<i '.$icon_color.' class="'.$icon.'"></i>';
        $unstyled = 'list-unstyled';
    } else {
        $icon = '';
        $unstyled = '';
    }

    //Use list group
    if ($add_list_group == 'use_list_group') {
        $list_group_ul = 'list-group';
        $list_group_li = 'list-group-item';
    } else {
        $list_group_ul = '';
        $list_group_li = '';
    }

    //Split the lists    
    $list_lis = explode(",", $list_li);

    $output = '';
    //Title
    $output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_lists_heading'));

    $output .= "\n\t".'<ul class="lists-module '.$unstyled.' '.$list_group_ul.'">';
    foreach ($list_lis as $line) {
        $output .= "\n\t".'<li class="'.$list_group_li.'">'.$icon.' '.$line.'</li>';
    }
    $output .= "\n\t".'</ul>';

    return $output;
         
    }
}

$WPBakeryShortCode_gg_lists = new WPBakeryShortCode_gg_lists();  

vc_map( array(
   "name" => __("Lists", "okthemes"),
   "description" => __('An ordered/unordered list with icon', 'okthemes'),
   "base" => "lists",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_lists",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title", "okthemes"),
         "param_name" => "title",
         "admin_label" => true,
         "description" => __("Insert the list title here", "okthemes")
      ),
      array(
        "type" => "exploded_textarea",
        "heading" => __("Lists values", "okthemes"),
        "param_name" => "list_li",
        "description" => __('Input list items here. Divide list items with linebreaks (Enter), one list item per line.', 'okthemes'),
        "value" => "First list item,Second list item,Third list item"
      ),
      array(
         "type" => "checkbox",
         "heading" => __("Icon?", "okthemes"),
         "value" => array(__("Use an icon for your list items.", "okthemes") => "use_icon" ),
         "param_name" => "add_icon"
      ),
      array(
         "type" => "dropdown",
         "heading" => __("Icon", "okthemes"),
         "param_name" => "icon",
         "value" => $gg_icons_array,
         "description" => __("Choose your icon.", "okthemes"),
         "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
      ),
      array(
        "type" => "colorpicker",
        "heading" => __("Icon color", "okthemes"),
        "param_name" => "icon_color",
        "dependency" => Array('element' => "add_icon", 'value' => array('use_icon'))
      ),
      array(
         "type" => "checkbox",
         "heading" => __("List group?", "okthemes"),
         "value" => array(__("Display as a list group", "okthemes") => "use_list_group" ),
         "param_name" => "add_list_group"
      ),

      $add_css_animation,

   )
) );

?>