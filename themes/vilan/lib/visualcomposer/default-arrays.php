<?php
$headings_array = array(
   __("Heading 1", "js_composer")         => "h1", 
   __("Heading 2", "js_composer")         => "h2", 
   __("Heading 3", "js_composer")         => "h3", 
   __("Heading 4", "js_composer")         => "h4",
   __("Heading 5", "js_composer")         => "h5",
   __("Heading 6", "js_composer")         => "h6"
);

$add_css_animation = array(
    "type" => "dropdown",
    "heading" => __("CSS Animation", "js_composer"),
    "param_name" => "css_animation",
    "admin_label" => true,
    "value" => array(__("No", "js_composer") => '', __("Top to bottom", "js_composer") => "top-to-bottom", __("Bottom to top", "js_composer") => "bottom-to-top", __("Left to right", "js_composer") => "left-to-right", __("Right to left", "js_composer") => "right-to-left", __("Appear from center", "js_composer") => "appear"),
    "description" => __("Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "js_composer")
  );

$align_array = array(
   __("Align left", "js_composer")         => "pull-left", 
   __("Align right", "js_composer")        => "pull-right", 
   __("Align center", "js_composer")       => "pull-center"
);

$portfolio_col_select_array = array(
   __("Two columns", "js_composer")       => "two_columns", 
   __("Three columns", "js_composer")     => "three_columns", 
   __("Four columns", "js_composer")      => "four_columns"
);

$team_col_select_array = array(
   __("Two columns", "js_composer")       => "two_columns", 
   __("Three columns", "js_composer")     => "three_columns", 
   __("Four columns", "js_composer")      => "four_columns"
);

$testimonials_col_select_array = array(
   __("One column", "js_composer")        => "one_column",
   __("Two columns", "js_composer")       => "two_columns", 
   __("Three columns", "js_composer")     => "three_columns"
);

//Default VC arrays

$colors = array(
   'Blue' => 'blue', // Why __( 'Blue', 'js_composer' ) doesn't work?
   'Turquoise' => 'turquoise',
   'Pink' => 'pink',
   'Violet' => 'violet',
   'Peacoc' => 'peacoc',
   'Chino' => 'chino',
   'Mulled Wine' => 'mulled_wine',
   'Vista Blue' => 'vista_blue',
   'Black' => 'black',
   'Grey' => 'grey',
   'Orange' => 'orange',
   'Sky' => 'sky',
   'Green' => 'green',
   'Juicy pink' => 'juicy_pink',
   'Sandy brown' => 'sandy_brown',
   'Purple' => 'purple',
   'White' => 'white'
);

$sizes = array(
   'Mini' => 'btn-mini',
   'Small' => 'btn-small',
   'Normal' => 'md',
   'Large' => 'btn-large'
);

$button_styles = array(
   'Rounded' => 'rounded',
   'Square' => 'square',
   'Round' => 'round',
   'Outlined' => 'outlined',
   //'3D' => '3d',
   'Square Outlined' => 'square_outlined'
);

$cta_styles = array(
   'Rounded' => 'rounded',
   'Square' => 'square',
   'Round' => 'round',
   'Outlined' => 'outlined',
   'Square Outlined' => 'square_outlined'
);

$txt_align = array(
   'Left' => 'left',
   'Right' => 'right',
   'Center' => 'center',
   'Justify' => 'justify'
);

$el_widths = array(
   '100%' => '',
   '90%' => '90',
   '80%' => '80',
   '70%' => '70',
   '60%' => '60',
   '50%' => '50'
);

$sep_styles = array(
   'Border' => '',
   'Dashed' => 'dashed',
   'Dotted' => 'dotted',
   'Double' => 'double'
);

$box_styles = array(
   'Default' => '',
   'Rounded' => 'vc_box_rounded',
   'Border' => 'vc_box_border',
   'Outline' => 'vc_box_outline',
   'Shadow' => 'vc_box_shadow',
   'Bordered shadow' => 'vc_box_shadow_border',
   '3D Shadow' => 'vc_box_shadow_3d',
   'Circle' => 'vc_box_circle', //new
   'Circle Border' => 'vc_box_border_circle', //new
   'Circle Outline' => 'vc_box_outline_circle', //new
   'Circle Shadow' => 'vc_box_shadow_circle', //new
   'Circle Border Shadow' => 'vc_box_shadow_border_circle' //new
);

$target_arr = array(
   __( 'Same window', 'js_composer' ) => '_self',
   __( 'New window', 'js_composer' ) => "_blank"
);

$img_style_arr = array(
   __( 'Default (Square corners)', 'okthemes' ) => "default",
   __( 'Rounded corners', 'okthemes' ) => "rounded",
   __( 'Circle', 'okthemes' ) => "circle"
);

$gg_icons_array = array(
   "Arrow up" 									   => "arrow_up",
   "Arrow down" 								   => "arrow_down",
   "Arrow left" 								   => "arrow_left",
   "Arrow right" 								   => "arrow_right",
   "Arrow left up" 								=> "arrow_left-up",
   "Arrow right up" 							   => "arrow_right-up",
   "Arrow right down" 							=> "arrow_right-down",
   "Arrow left down" 							=> "arrow_left-down",
   "Arrow up down" 								=> "arrow-up-down",
   "Arrow up down alt" 							=> "arrow_up-down_alt",
   "Arrow left right alt" 						=> "arrow_left-right_alt",
   "Arrow left right" 							=> "arrow_left-right",
   "Arrow expand alt 2" 						=> "arrow_expand_alt2",
   "Arrow exapnd alt" 							=> "arrow_expand_alt",
   "Arrow condense" 							   => "arrow_condense",
   "Arrow expand" 								=> "arrow_expand",
   "Arrow move" 								   => "arrow_move",
   "Arrow carrot up" 							=> "arrow_carrot-up",
   "Arrow carrot down" 							=> "arrow_carrot-down",
   "Arrow carrot left" 							=> "arrow_carrot-left",
   "Arrow carrot right" 						=> "arrow_carrot-right",
   "Arrow carrot 2 up" 							=> "arrow_carrot-2up",
   "Arrow carrot 2 down" 						=> "arrow_carrot-2down",
   "Arrow carrot 2 left" 						=> "arrow_carrot-2left",
   "Arrow carrot 2 right" 						=> "arrow_carrot-2right",
   "Arrow carrot up alt 2" 					=> "arrow_carrot-up_alt2",
   "Arrow carrot down alt 2" 					=> "arrow_carrot-down_alt2",
   "Arrow carrot left alt 2" 					=> "arrow_carrot-left_alt2",
   "Arrow carrot right alt 2" 				=> "arrow_carrot-right_alt2",
   "Arrow carrot 2 up alt 2" 					=> "arrow_carrot-2up_alt2",
   "Arrow carrot 2 down alt 2" 				=> "arrow_carrot-2down_alt2",
   "Arrow carrot 2 left alt 2" 				=> "arrow_carrot-2left_alt2",
   "Arrow carrot 2 right alt 2" 				=> "arrow_carrot-2right_alt2",
   "Arrow triangle up" 							=> "arrow_triangle-up",
   "Arrow triangle down" 						=> "arrow_triangle-down",
   "Arrow triangle left" 						=> "arrow_triangle-left",
   "Arrow triangle right" 						=> "arrow_triangle-right",
   "Arrow triangle up alt 2" 					=> "arrow_triangle-up_alt2",
   "Arrow triangle down alt 2" 				=> "arrow_triangle-down_alt2",
   "Arrow triangle left alt 2" 				=> "arrow_triangle-left_alt2",
   "Arrow triangle right alt 2" 				=> "arrow_triangle-right_alt2",
   "Arrow back" 								   => "arrow_back",
   "Icon minus" 								   => "icon_minus-06",
   "Icon plus" 									=> "icon_plus",
   "Icon close" 								   => "icon_close",
   "Icon check" 								   => "icon_check",
   "Icon minus alt 2" 							=> "icon_minus_alt2",
   "Icon plus alt 2" 							=> "icon_plus_alt2",
   "Icon close alt 2" 							=> "icon_close_alt2",
   "Icon check alt 2" 							=> "icon_check_alt2",
   "Icon zoom out alt" 							=> "icon_zoom-out_alt",
   "Icon zoom in alt" 							=> "icon_zoom-in_alt",
   "Icon search" 								   => "icon_search",
   "Icon box empty" 							   => "icon_box-empty",
   "Icon box selected" 							=> "icon_box-selected",
   "Icon minus box" 							   => "icon_minus-box",
   "Icon plus box" 								=> "icon_plus-box",
   "Icon box checked" 							=> "icon_box-checked",
   "Icon circle empty" 							=> "icon_circle-empty",
   "Icon circle selected" 						=> "icon_circle-slelected",
   "Icon stop alt 2" 							=> "icon_stop_alt2",
   "Icon stop" 									=> "icon_stop",
   "Icon pause alt 2" 							=> "icon_pause_alt2",
   "Icon pause" 								   => "icon_pause",
   "Icon menu" 									=> "icon_menu",
   "Icon menu square alt 2" 					=> "icon_menu-square_alt2",
   "Icon menu circle alt 2" 					=> "icon_menu-circle_alt2",
   "Icon ul"                              => "icon_ul",
   "Icon ol"                              => "icon_ol",
   "Icon adjust horizontal"               => "icon_adjust-horiz",
   "Icon adjust vertical"                 => "icon_adjust-vert",
   "Icon document alt"                    => "icon_document_alt",
   "Icon documents alt"                   => "icon_documents_alt",
   "Icon pencil"                          => "icon_pencil",
   "Icon pencil edit alt"                 => "icon_pencil-edit_alt",
   "Icon pencil edit"                     => "icon_pencil-edit",
   "Icon folder alt"                      => "icon_folder-alt",
   "Icon folder open alt"                 => "icon_folder-open_alt",
   "Icon folder add alt"                  => "icon_folder-add_alt",
   "Icon info alt"                        => "icon_info_alt",
   "Icon error oct alt"                   => "icon_error-oct_alt",
   "Icon error circle alt"                => "icon_error-circle_alt",
   "Icon error triangle alt"              => "icon_error-triangle_alt",
   "Icon question alt 2"                  => "icon_question_alt2",
   "Icon question"                        => "icon_question",
   "Icon comment alt"                     => "icon_comment_alt",
   "Icon chat alt"                        => "icon_chat_alt",
   "Icon volume mute alt"                 => "icon_vol-mute_alt",
   "Icon volume low alt"                  => "icon_volume-low_alt",
   "Icon volume high alt"                 => "icon_volume-high_alt",
   "Icon quotantions"                     => "icon_quotations",
   "Icon quotantions alt 2"               => "icon_quotations_alt2",
   "Icon clock alt"                       => "icon_clock_alt",
   "Icon lock alt"                        => "icon_lock_alt",
   "Icon lock open alt"                   => "icon_lock-open_alt",
   "Icon key alt"                         => "icon_key_alt",
   "Icon cloud alt"                       => "icon_cloud_alt",
   "Icon cloud upload alt"                => "icon_cloud-upload_alt",
   "Icon cloud download alt"              => "icon_cloud-download_alt",
   "Icon image"                           => "icon_image",
   "Icon images"                          => "icon_images",
   "Icon lightbulb alt"                   => "icon_lightbulb_alt",
   "Icon gift alt"                        => "icon_gift_alt",
   "Icon house alt"                       => "icon_house_alt",
   "Icon genius"                          => "icon_genius",
   "Icon mobile"                          => "icon_mobile",
   "Icon tablet"                          => "icon_tablet",
   "Icon laptop"                          => "icon_laptop",
   "Icon desktop"                         => "icon_desktop",
   "Icon camera alt"                      => "icon_camera_alt",
   "Icon mail alt"                        => "icon_mail_alt",
   "Icon cone alt"                        => "icon_cone_alt",
   "Icon ribbon alt"                      => "icon_ribbon_alt",
   "Icon bag alt"                         => "icon_bag_alt",
   "Icon credit card"                     => "icon_creditcard",
   "Icon credit card alt"                 => "icon_cart_alt",
   "Icon paper clip"                      => "icon_paperclip",
   "Icon tag alt"                         => "icon_tag_alt",
   "Icon tags alt"                        => "icon_tags_alt",
   "Icon trash alt"                       => "icon_trash_alt",
   "Icon cursor alt"                      => "icon_cursor_alt",
   "Icon mic alt"                         => "icon_mic_alt",
   "Icon compass alt"                     => "icon_compass_alt",
   "Icon pin alt"                         => "icon_pin_alt",
   "Icon push pin alt"                    => "icon_pushpin_alt",
   "Icon map alt"                         => "icon_map_alt",
   "Icon drawer alt"                      => "icon_drawer_alt",
   "Icon toolbox alt"                     => "icon_toolbox_alt",
   "Icon book alt"                        => "icon_book_alt",
   "Icon calendar"                        => "icon_calendar",
   "Icon film"                            => "icon_film",
   "Icon table"                           => "icon_table",
   "Icon contacts alt"                    => "icon_contacts_alt",
   "Icon headphones"                      => "icon_headphones",
   "Icon lifesaver"                       => "icon_lifesaver",
   "Icon piechart"                        => "icon_piechart",
   "Icon refresh"                         => "icon_refresh",
   "Icon link alt"                        => "icon_link_alt",
   "Icon link"                            => "icon_link",
   "Icon loading"                         => "icon_loading",
   "Icon blocked"                         => "icon_blocked",
   "Icon archive alt"                     => "icon_archive_alt",
   "Icon heart alt"                       => "icon_heart_alt",
   "Icon star alt"                        => "icon_star_alt",
   "Icon star half alt"                   => "icon_star-half_alt",
   "Icon star"                            => "icon_star",
   "Icon star half"                       => "icon_star-half",
   "Icon tools"                           => "icon_tools",
   "Icon tool"                            => "icon_tool",
   "Icon cog"                             => "icon_cog",
   "Icon cogs"                            => "icon_cogs",
   "Arrow up alt"                         => "arrow_up_alt",
   "Arrow down alt"                       => "arrow_down_alt",
   "Arrow left alt"                       => "arrow_left_alt",
   "Arrow right alt"                      => "arrow_right_alt",
   "Arrow left up alt"                    => "arrow_left-up_alt",
   "Arrow right up alt"                   => "arrow_right-up_alt",
   "Arrow right down alt"                 => "arrow_right-down_alt",
   "Arrow left down alt"                  => "arrow_left-down_alt",
   "Arrow condense alt"                   => "arrow_condense_alt",
   "Arrow expand alt 3"                   => "arrow_expand_alt3",
   "Arrow carrot up alt"                  => "arrow_carrot_up_alt",
   "Arrow carrot down alt"                => "arrow_carrot-down_alt",
   "Arrow carrot left alt"                => "arrow_carrot-left_alt",
   "Arrow carrot right alt"               => "arrow_carrot-right_alt",
   "Arrow carrot 2 up alt"                => "arrow_carrot-2up_alt",
   "Arrow carrot 2 down alt"              => "arrow_carrot-2dwnn_alt",
   "Arrow carrot 2 left alt"              => "arrow_carrot-2left_alt",
   "Arrow carrot 2 right alt"             => "arrow_carrot-2right_alt",
   "Arrow triangle up alt"                => "arrow_triangle-up_alt",
   "Arrow triangle down alt"              => "arrow_triangle-down_alt",
   "Arrow triangle left alt"              => "arrow_triangle-left_alt",
   "Arrow triangle right alt"             => "arrow_triangle-right_alt",
   "Icon minus alt"                       => "icon_minus_alt",
   "Icon plus alt"                        => "icon_plus_alt",
   "Icon close alt"                       => "icon_close_alt",
   "Icon check alt"                       => "icon_check_alt",
   "Icon zoom out"                        => "icon_zoom-out",
   "Icon zoom in"                         => "icon_zoom-in",
   "Icon stop alt"                        => "icon_stop_alt",
   "Icon menu square alt"                 => "icon_menu-square_alt",
   "Icon menu circle alt"                 => "icon_menu-circle_alt",
   "Icon document"                        => "icon_document",
   "Icon documents"                       => "icon_documents",
   "Icon pencil alt"                      => "icon_pencil_alt",
   "Icon folder"                          => "icon_folder",
   "Icon folder open"                     => "icon_folder-open",
   "Icon folder add"                      => "icon_folder-add",
   "Icon folder upload"                   => "icon_folder_upload",
   "Icon folder download"                 => "icon_folder_download",
   "Icon info"                            => "icon_info",
   "Icon error circle"                    => "icon_error-circle",
   "Icon error oct"                       => "icon_error-oct",
   "Icon error triangle"                  => "icon_error-triangle",
   "Icon question alt"                    => "icon_question_alt",
   "Icon comment"                         => "icon_comment",
   "Icon chat"                            => "icon_chat",
   "Icon volume mute"                     => "icon_vol-mute",
   "Icon volume low"                      => "icon_volume-low",
   "Icon volume high"                     => "icon_volume-high",
   "Icon quotations alt"                  => "icon_quotations_alt",
   "Icon clock"                           => "icon_clock",
   "Icon lock"                            => "icon_lock",
   "Icon lock open"                       => "icon_lock-open",
   "Icon key"                             => "icon_key",
   "Icon cloud"                           => "icon_cloud",
   "Icon cloud upload"                    => "icon_cloud-upload",
   "Icon cloud download"                  => "icon_cloud-download",
   "Icon light bulb"                      => "icon_lightbulb",
   "Icon gift"                            => "icon_gift",
   "Icon house"                           => "icon_house",
   "Icon camera"                          => "icon_camera",
   "Icon mail"                            => "icon_mail",
   "Icon cone"                            => "icon_cone",
   "Icon ribbon"                          => "icon_ribbon",
   "Icon bag"                             => "icon_bag",
   "Icon cart"                            => "icon_cart",
   "Icon tag"                             => "icon_tag",
   "Icon tags"                            => "icon_tags",
   "Icon trash"                           => "icon_trash",
   "Icon cursor"                          => "icon_cursor",
   "Icon mic"                             => "icon_mic",
   "Icon compass"                         => "icon_compass",
   "Icon pin"                             => "icon_pin",
   "Icon push pin"                        => "icon_pushpin",
   "Icon map"                             => "icon_map",
   "Icon drawer" => "icon_drawer",
   "Icon toolbox" => "icon_toolbox",
   "Icon book" => "icon_book",
   "Icon contacts" => "icon_contacts",
   "Icon archive" => "icon_archive",
   "Icon heart" => "icon_heart",
   "Icon profile" => "icon_profile",
   "Icon group" => "icon_group",
   "Icon grid 2x2" => "icon_grid-2x2",
   "Icon grid 3x3" => "icon_grid-3x3",
   "Icon music" => "icon_music",
   "Icon pause alt" => "icon_pause_alt",
   "Icon phone" => "icon_phone",
   "Icon upload" => "icon_upload",
   "Icon download" => "icon_download",
   "Social facebook" => "social_facebook",
   "Social twitter" => "social_twitter",
   "Social pinterest" => "social_pinterest",
   "Social google plus" => "social_googleplus",
   "Social tumblr" => "social_tumblr",
   "Social tumbleupon" => "social_tumbleupon",
   "Social wordpress" => "social_wordpress",
   "Social instagram" => "social_instagram",
   "Social dribbble" => "social_dribbble",
   "Social vimeo" => "social_vimeo",
   "Social linkedin" => "social_linkedin",
   "Social rss" => "social_rss",
   "Social deviantart" => "social_deviantart",
   "Social share" => "social_share",
   "Social myspace" => "social_myspace",
   "Social skype" => "social_skype",
   "Social youtube" => "social_youtube",
   "Social picassa" => "social_picassa",
   "Social googledrive" => "social_googledrive",
   "Social flickr" => "social_flickr",
   "Social blogger" => "social_blogger",
   "Social spotify" => "social_spotify",
   "Social delicious" => "social_delicious",
   "Social facebook circle" => "social_facebook_circle",
   "Social twitter circle" => "social_twitter_circle",
   "Social pinterest circle" => "social_pinterest_circle",
   "Social googleplus circle" => "social_googleplus_circle",
   "Social tumblr circle" => "social_tumblr_circle",
   "Social stumbleupon circle" => "social_stumbleupon_circle",
   "Social wordpress circle" => "social_wordpress_circle",
   "Social instagram circle" => "social_instagram_circle",
   "Social dribbble circle" => "social_dribbble_circle",
   "Social vimeo circle" => "social_vimeo_circle",
   "Social linkedin circle" => "social_linkedin_circle",
   "Social rss circle" => "social_rss_circle",
   "Social deviantart circle" => "social_deviantart_circle",
   "Social share circle" => "social_share_circle",
   "Social myspace circle" => "social_myspace_circle",
   "Social skype circle" => "social_skype_circle",
   "Social youtube circle" => "social_youtube_circle",
   "Social picassa circle" => "social_picassa_circle",
   "Social googledrive alt 2" => "social_googledrive_alt2",
   "Social flickr circle" => "social_flickr_circle",
   "Social blogger circle" => "social_blogger_circle",
   "Social spotify circle" => "social_spotify_circle",
   "Social delicious circle" => "social_delicious_circle",
   "Social facebook square" => "social_facebook_square",
   "Social twitter square" => "social_twitter_square",
   "Social pinterest square" => "social_pinterest_square",
   "Social googleplus square" => "social_googleplus_square",
   "Social tumblr square" => "social_tumblr_square",
   "Social stumbleupon square" => "social_stumbleupon_square",
   "Social wordpress square" => "social_wordpress_square",
   "Social instagram square" => "social_instagram_square",
   "Social dribbble square" => "social_dribbble_square",
   "Social vimeo square" => "social_vimeo_square",
   "Social linkedin square" => "social_linkedin_square",
   "Social rss square" => "social_rss_square",
   "Social deviantart square" => "social_deviantart_square",
   "Social share square" => "social_share_square",
   "Social myspace square" => "social_myspace_square",
   "Social skype square" => "social_skype_square",
   "Social youtube square" => "social_youtube_square",
   "Social picassa square" => "social_picassa_square",
   "Social googledrive square" => "social_googledrive_square",
   "Social flickr square" => "social_flickr_square",
   "Social blogger square" => "social_blogger_square",
   "Social spotify square" => "social_spotify_square",
   "Icon printer" => "icon_printer",
   "Icon calculator" => "icon_calulator",
   "Icon building" => "icon_building",
   "Icon Floppy" => "icon_floppy",
   "Icon drive" => "icon_drive",
   "Icon search 2" => "icon_search-2",
   "Icon id" => "icon_id",
   "Icon id 2" => "icon_id-2",
   "Icon puzzle" => "icon_puzzle",
   "Icon like" => "icon_like",
   "Icon dislike" => "icon_dislike",
   "Icon mug" => "icon_mug",
   "Icon currency" => "icon_currency",
   "Icon wallet" => "icon_wallet",
   "Icon pens" => "icon_pens",
   "Icon easel" => "icon_easel",
   "Icon flowchart" => "icon_flowchart",
   "Icon data report" => "icon_datareport",
   "Icon briefcase" => "icon_briefcase",
   "Icon shield" => "icon_shield",
   "Icon percent" => "icon_percent",
   "Icon globe" => "icon_globe",
   "Icon globe 2" => "icon_globe-2",
   "Icon target" => "icon_target",
   "Icon hour glass" => "icon_hourglass",
   "Icon balance" => "icon_balance",
   "Icon rook" => "icon_rook",
   "Icon printer alt" => "icon_printer-alt",
   "Icon calculator alt" => "icon_calculator_alt",
   "Icon building alt" => "icon_building_alt",
   "Icon floppy alt" => "icon_floppy_alt",
   "Icon drive alt" => "icon_drive_alt",
   "Icon search alt" => "icon_search_alt",
   "Icon id alt" => "icon_id_alt",
   "Icon id 2 alt" => "icon_id-2_alt",
   "Icon puzzle alt" => "icon_puzzle_alt",
   "Icon like alt" => "icon_like_alt",
   "Icon dislike alt" => "icon_dislike_alt",
   "Icon mug alt" => "icon_mug_alt",
   "Icon currency alt" => "icon_currency_alt",
   "Icon wallet alt" => "icon_wallet_alt",
   "Icon pens alt" => "icon_pens_alt",
   "Icon easel alt" => "icon_easel_alt",
   "Icon flowchart alt" => "icon_flowchart_alt",
   "Icon data report alt" => "icon_datareport_alt",
   "Icon briefcase alt" => "icon_briefcase_alt",
   "Icon shield alt" => "icon_shield_alt",
   "Icon percent alt" => "icon_percent_alt",
   "Icon globe alt" => "icon_globe_alt",
   "Icon clipboard" => "icon_clipboard",
);

// Initialising Shortcodes
if (class_exists('WPBakeryVisualComposerAbstract')) {

   /**
    * Taxonomy checkbox list field.
    *
    */
   function gg_taxonomy_settings_field($settings, $value) {
      $dependency = vc_generate_dependencies_attributes($settings);

      $terms_fields = array();
      $terms_slugs = array();

      $value_arr = $value;
      if ( !is_array($value_arr) ) {
         $value_arr = array_map( 'trim', explode(',', $value_arr) );
      }

      if ( !empty($settings['taxonomy']) ) {

         $terms = get_terms( $settings['taxonomy'] );
         if ( $terms && !is_wp_error($terms) ) {

            foreach( $terms as $term ) {
               $terms_slugs[] = $term->slug;

               $terms_fields[] = sprintf(
                  '<label><input id="%s" class="%s" type="checkbox" name="%s" value="%s" %s/>%s</label>',
                  $settings['param_name'] . '-' . $term->slug,
                  $settings['param_name'].' '.$settings['type'],
                  $settings['param_name'],
                  $term->slug,
                  checked( in_array( $term->slug, $value_arr ), true, false ),
                  $term->name
               );
            }
         }
      }

      return '<div class="gg_taxonomy_block">'
            .'<input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-checkboxes '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />'
             .'<div class="gg_taxonomy_terms">'
             .implode( $terms_fields )
             .'</div>'
          .'</div>';
   }
   vc_add_shortcode_param('gg_taxonomy', 'gg_taxonomy_settings_field', get_template_directory_uri() . '/lib/visualcomposer/gg-taxonomy.js' );

   /**
    * Posts checkbox list field.
    *
    */
   function gg_posttype_settings_field($settings, $value) {
      $dependency = vc_generate_dependencies_attributes($settings);

      $posts_fields = array();
      $terms_slugs = array();

      $value_arr = $value;
      if ( !is_array($value_arr) ) {
         $value_arr = array_map( 'trim', explode(',', $value_arr) );
      }

      if ( !empty($settings['posttype']) ) {

         $args = array(
            'no_found_rows' => 1,
            'ignore_sticky_posts' => 1,
            'posts_per_page' => -1,
            'post_type' => $settings['posttype'],
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
         );

         $gg_query = new WP_Query( $args );
         if ( $gg_query->have_posts() ) {

            foreach( $gg_query->posts as $p ) {

               $posts_fields[] = sprintf(
                  '<label><input id="%s" class="%s" type="checkbox" name="%s" value="%s" %s/>%s</label>',
                  $settings['param_name'] . '-' . $p->post_name,
                  $settings['param_name'] . ' ' . $settings['type'],
                  $settings['param_name'],
                  $p->post_name,
                  checked( in_array( $p->post_name, $value_arr ), true, false ),
                  $p->post_title
               );
            }
         }
      }

      return '<div class="gg_posttype_block">'
            .'<input type="hidden" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-checkboxes '.$settings['param_name'].' '.$settings['type'].'_field" value="'.$value.'" '.$dependency.' />'
             .'<div class="gg_posttype_post">'
             .implode( $posts_fields )
             .'</div>'
          .'</div>';
   }
   vc_add_shortcode_param('gg_posttype', 'gg_posttype_settings_field', get_template_directory_uri() . '/lib/visualcomposer/gg-posttype.js' );
}

?>