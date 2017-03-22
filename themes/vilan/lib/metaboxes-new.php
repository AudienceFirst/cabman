<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

add_filter( 'rwmb_meta_boxes', 'gg_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * @return void
 */
function gg_register_meta_boxes( $meta_boxes )
{
        /**
         * Prefix of meta keys (optional)
         * Use underscore (_) at the beginning to make keys hidden
         * Alt.: You also can make prefix empty to disable it
         */
        // Better has an underscore as last sign
        $prefix = 'gg_';

        $gg_icons_array = array(
   "Arrow up"                                      => "arrow_up",
   "Arrow down"                                    => "arrow_down",
   "Arrow left"                                    => "arrow_left",
   "Arrow right"                                   => "arrow_right",
   "Arrow left up"                                  => "arrow_left-up",
   "Arrow right up"                                => "arrow_right-up",
   "Arrow right down"                           => "arrow_right-down",
   "Arrow left down"                            => "arrow_left-down",
   "Arrow up down"                              => "arrow-up-down",
   "Arrow up down alt"                          => "arrow_up-down_alt",
   "Arrow left right alt"                       => "arrow_left-right_alt",
   "Arrow left right"                           => "arrow_left-right",
   "Arrow expand alt 2"                         => "arrow_expand_alt2",
   "Arrow exapnd alt"                           => "arrow_expand_alt",
   "Arrow condense"                                => "arrow_condense",
   "Arrow expand"                               => "arrow_expand",
   "Arrow move"                                    => "arrow_move",
   "Arrow carrot up"                            => "arrow_carrot-up",
   "Arrow carrot down"                          => "arrow_carrot-down",
   "Arrow carrot left"                          => "arrow_carrot-left",
   "Arrow carrot right"                         => "arrow_carrot-right",
   "Arrow carrot 2 up"                          => "arrow_carrot-2up",
   "Arrow carrot 2 down"                        => "arrow_carrot-2down",
   "Arrow carrot 2 left"                        => "arrow_carrot-2left",
   "Arrow carrot 2 right"                       => "arrow_carrot-2right",
   "Arrow carrot up alt 2"                  => "arrow_carrot-up_alt2",
   "Arrow carrot down alt 2"                    => "arrow_carrot-down_alt2",
   "Arrow carrot left alt 2"                    => "arrow_carrot-left_alt2",
   "Arrow carrot right alt 2"               => "arrow_carrot-right_alt2",
   "Arrow carrot 2 up alt 2"                    => "arrow_carrot-2up_alt2",
   "Arrow carrot 2 down alt 2"              => "arrow_carrot-2down_alt2",
   "Arrow carrot 2 left alt 2"              => "arrow_carrot-2left_alt2",
   "Arrow carrot 2 right alt 2"                 => "arrow_carrot-2right_alt2",
   "Arrow triangle up"                          => "arrow_triangle-up",
   "Arrow triangle down"                        => "arrow_triangle-down",
   "Arrow triangle left"                        => "arrow_triangle-left",
   "Arrow triangle right"                       => "arrow_triangle-right",
   "Arrow triangle up alt 2"                    => "arrow_triangle-up_alt2",
   "Arrow triangle down alt 2"              => "arrow_triangle-down_alt2",
   "Arrow triangle left alt 2"              => "arrow_triangle-left_alt2",
   "Arrow triangle right alt 2"                 => "arrow_triangle-right_alt2",
   "Arrow back"                                    => "arrow_back",
   "Icon minus"                                    => "icon_minus-06",
   "Icon plus"                                  => "icon_plus",
   "Icon close"                                    => "icon_close",
   "Icon check"                                    => "icon_check",
   "Icon minus alt 2"                           => "icon_minus_alt2",
   "Icon plus alt 2"                            => "icon_plus_alt2",
   "Icon close alt 2"                           => "icon_close_alt2",
   "Icon check alt 2"                           => "icon_check_alt2",
   "Icon zoom out alt"                          => "icon_zoom-out_alt",
   "Icon zoom in alt"                           => "icon_zoom-in_alt",
   "Icon search"                                   => "icon_search",
   "Icon box empty"                                => "icon_box-empty",
   "Icon box selected"                          => "icon_box-selected",
   "Icon minus box"                                => "icon_minus-box",
   "Icon plus box"                              => "icon_plus-box",
   "Icon box checked"                           => "icon_box-checked",
   "Icon circle empty"                          => "icon_circle-empty",
   "Icon circle selected"                       => "icon_circle-slelected",
   "Icon stop alt 2"                            => "icon_stop_alt2",
   "Icon stop"                                  => "icon_stop",
   "Icon pause alt 2"                           => "icon_pause_alt2",
   "Icon pause"                                    => "icon_pause",
   "Icon menu"                                  => "icon_menu",
   "Icon menu square alt 2"                     => "icon_menu-square_alt2",
   "Icon menu circle alt 2"                     => "icon_menu-circle_alt2",
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
   "Icon folder" => "icon_folder",
   "Icon folder open" => "icon_folder-open",
   "Icon folder add" => "icon_folder-add",
   "Icon folder upload" => "icon_folder_upload",
   "Icon folder download" => "icon_folder_download",
   "Icon info" => "icon_info",
   "Icon error circle" => "icon_error-circle",
   "Icon error oct" => "icon_error-oct",
   "Icon error triangle" => "icon_error-triangle",
   "Icon question alt" => "icon_question_alt",
   "Icon comment" => "icon_comment",
   "Icon chat" => "icon_chat",
   "Icon volume mute" => "icon_vol-mute",
   "Icon volume low" => "icon_volume-low",
   "Icon volume high" => "icon_volume-high",
   "Icon quotations alt" => "icon_quotations_alt",
   "Icon clock" => "icon_clock",
   "Icon lock" => "icon_lock",
   "Icon lock open" => "icon_lock-open",
   "Icon key" => "icon_key",
   "Icon cloud" => "icon_cloud",
   "Icon cloud upload" => "icon_cloud-upload",
   "Icon cloud download" => "icon_cloud-download",
   "Icon light bulb" => "icon_lightbulb",
   "Icon gift" => "icon_gift",
   "Icon house" => "icon_house",
   "Icon camera" => "icon_camera",
   "Icon mail" => "icon_mail",
   "Icon cone" => "icon_cone",
   "Icon ribbon" => "icon_ribbon",
   "Icon bag" => "icon_bag",
   "Icon cart" => "icon_cart",
   "Icon tag" => "icon_tag",
   "Icon tags" => "icon_tags",
   "Icon trash" => "icon_trash",
   "Icon cursor" => "icon_cursor",
   "Icon mic" => "icon_mic",
   "Icon compass" => "icon_compass",
   "Icon pin" => "icon_pin",
   "Icon push pin" => "icon_pushpin",
   "Icon map" => "icon_map",
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

$gg_icons_array_flipped = array_flip($gg_icons_array);

        // Forum metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'forum_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Forum Icon', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'forum' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'side',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                
                        array(
                            'name'     => __( 'Select forum icon', 'okthemes' ),
                            'id'       => "{$prefix}forum_icon",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => $gg_icons_array_flipped,
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => '',
                            'placeholder' => __( 'Select an icon', 'okthemes' ),
                        ),
                                              
                ),
                
        );

        // General page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'general_page_header_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Page Header Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Page header',
                            'id'    => "{$prefix}page_header",
                            'desc'  => 'Enable/Disable page header.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Page title',
                            'id'    => "{$prefix}page_title",
                            'desc'  => 'Enable/Disable page title.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Breadcrumbs',
                            'id'    => "{$prefix}page_breadcrumbs",
                            'desc'  => 'Enable/Disable page breadcrumbs.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Social media',
                            'id'    => "{$prefix}page_social_media",
                            'desc'  => 'Enable/Disable page social media.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Page description',
                            'id'    => "{$prefix}page_description",
                            'desc'  => 'Insert your page short description here.',
                            'type'  => 'textarea',
                            'std'   => '',
                        ),
                                              
                ),
                
        );

        // General page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'general_page_header_overlay',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Featured Image Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'side',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'low',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Apply featured image overlay',
                            'id'    => "{$prefix}page_header_image_overlay",
                            'desc'  => '',
                            'std'   => 0,
                            'type'  => 'checkbox',
                        ),
                                              
                ),
                
        );

        if (is_plugin_active('revslider/revslider.php')) {
         global $wpdb;

         $limit = 999;
         $rs_table_name = $wpdb->prefix . "revslider_sliders";
         $rs = $wpdb->get_results( $wpdb->prepare("SELECT id, title, alias FROM $rs_table_name ORDER BY id ASC LIMIT %d", $limit) );

        $revsliders = array();
        if ($rs) {
            foreach ( $rs as $slider ) {
              $revsliders[$slider->alias] = $slider->alias;
            }
        } else {
            $revsliders["No sliders found"] = 0;
        }

        // Page header slideshow metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'general_page_header_slideshow_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Page Header Slideshow', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Page header slider',
                            'id'    => "{$prefix}page_header_slider",
                            'desc'  => 'Enable/Disable page header slider.',
                            'std'   => 0,
                            'type'  => 'checkbox',
                        ),
                        
                        // SELECT BOX
                        array(
                            'name'     => __( 'Select the page header slider', 'okthemes' ),
                            'id'       => "{$prefix}page_header_slider_select",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => $revsliders,
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => '',
                            'placeholder' => __( 'Select a slider', 'okthemes' ),
                        ),
                                                                       
                ),
                
        );
        } //end check for rev slider

        // General page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'general_page_layout_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Page Layout Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        
                        // SELECT BOX
                        array(
                            'name'     => __( 'Select the page layout', 'okthemes' ),
                            'id'       => "{$prefix}page_layout_select",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'with_right_sidebar' => __( 'With right sidebar', 'okthemes' ),
                                    'with_left_sidebar' => __( 'With left sidebar', 'okthemes' ),
                                    'no_sidebar' => __( 'No sidebar', 'okthemes' ),
                                    'fullscreen' => __( 'Fullscreen', 'okthemes' ),
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'with_right_sidebar',
                            'placeholder' => __( 'Select a layout', 'okthemes' ),
                        ),
                        
                ),
                
        );

        
        // General page metabox img size
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'general_page_img_info',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Page featured image size', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'side',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'low',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        
                        // Description
                        array(
                            'type' => 'description',
                            'name' => __( 'The recommended dimension of the header page image is: 1350x150px. The image is automatically resized, but you must constrain proportions. The width of the image can be bigger but the height must remain at 150px</br>To insert a header image please use the "Set featured image" link from the right panel.', 'okthemes' ),
                            'id'   => 'page_desc_fake_id', // Not used but needed for plugin
                        ),
                ),
                
        );

        // General page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'general_page_footer_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Page Footer Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page', 'post', 'portfolio_cpt', 'product'),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Page footer message box',
                            'id'    => "{$prefix}page_footer_box",
                            'desc'  => 'Show/Hide page footer message box',
                            'std'   => 0,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Page footer heading',
                            'id'    => "{$prefix}page_footer_heading",
                            'desc'  => 'Insert your page footer heading here.',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Button name',
                            'id'    => "{$prefix}page_footer_first_button_name",
                            'desc'  => 'Insert your page footer button name here.',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Button link',
                            'id'    => "{$prefix}page_footer_first_button_link",
                            'desc'  => 'Insert your page footer button link here.',
                            'type'  => 'url',
                            'std'   => '',
                        ),
                ),
                
        );

        // Portfolio page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'portfolio_page_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Portfolio Page Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        // TAXONOMY
                        array(
                                'name'    => __( 'Portfolio Category', 'okthemes' ),
                                'id'      => "{$prefix}portfolio_tax",
                                'type'    => 'taxonomy',
                                'options' => array(
                                        // Taxonomy name
                                        'taxonomy' => 'portfolio_category',
                                        // How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
                                        'type' => 'select_advanced',
                                        // Additional arguments for get_terms() function. Optional
                                        'args' => array()
                                ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Display portfolio posts on:', 'okthemes' ),
                            'id'       => "{$prefix}portfolio_col_select",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'four_columns' => __( 'Four columns', 'okthemes' ),
                                    'three_columns' => __( 'Three columns', 'okthemes' ),
                                    'two_columns' => __( 'Two columns', 'okthemes' ),
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'three_columns',
                            'placeholder' => __( 'Select columns', 'okthemes' ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Portfolio grid layout mode:', 'okthemes' ),
                            'id'       => "{$prefix}portfolio_grid_layout_mode",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'fitRows' => __( 'Grid Fit rows', 'okthemes' ),
                                    'masonry' => __( 'Grid Masonry', 'okthemes' )
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'fitRows',
                            'placeholder' => __( 'Select grid layout mode', 'okthemes' ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Portfolio grid layout style:', 'okthemes' ),
                            'id'       => "{$prefix}portfolio_grid_layout_style",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'gap' => __( 'Gap', 'okthemes' ),
                                    'nogap' => __( 'No gap', 'okthemes' )
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'gap',
                            'placeholder' => __( 'Select grid layout style', 'okthemes' ),
                        ),
                        // CHECKBOX
                        array(
                                'name' => __( 'Display category filter', 'okthemes' ),
                                'id'   => "{$prefix}portfolio_cat_filter",
                                'type' => 'checkbox',
                                // Value can be 0 or 1
                                'std'  => 0,
                        ),
                        array(
                                'name' => __( 'Disable image resize', 'okthemes' ),
                                'id'   => "{$prefix}disable_image_resize",
                                'type' => 'checkbox',
                                'desc'  => 'If checked the images will not be resized, instead they will be displayed at full scale. Usefull if you use masonry layout mode.',
                                // Value can be 0 or 1
                                'std'  => 0,
                        ),
                        array(
                            'name'  => 'Number of posts to display',
                            'id'    => "{$prefix}portfolio_no_posts",
                            'desc'  => 'Enter the number of posts to display before the pagination kicks in. Default: 9',
                            'type'  => 'text',
                            'std'   => '9',
                        ),
                                                                       
                ),
                
        );

        // Team page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'team_page_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Team Page Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        // TAXONOMY
                        array(
                                'name'    => __( 'Team Category', 'okthemes' ),
                                'id'      => "{$prefix}team_tax",
                                'type'    => 'taxonomy',
                                'options' => array(
                                        // Taxonomy name
                                        'taxonomy' => 'team_category',
                                        // How to show taxonomy: 'checkbox_list' (default) or 'checkbox_tree', 'select_tree', select_advanced or 'select'. Optional
                                        'type' => 'select_advanced',
                                        // Additional arguments for get_terms() function. Optional
                                        'args' => array()
                                ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Display team posts on:', 'okthemes' ),
                            'id'       => "{$prefix}team_col_select",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'four_columns' => __( 'Four columns', 'okthemes' ),
                                    'three_columns' => __( 'Three columns', 'okthemes' ),
                                    'two_columns' => __( 'Two columns', 'okthemes' ),
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'four_columns',
                            'placeholder' => __( 'Select columns', 'okthemes' ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Team grid layout mode:', 'okthemes' ),
                            'id'       => "{$prefix}team_grid_layout_mode",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'fitRows' => __( 'Grid Fit rows', 'okthemes' ),
                                    'masonry' => __( 'Grid Masonry', 'okthemes' )
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'fitRows',
                            'placeholder' => __( 'Select grid layout mode', 'okthemes' ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Team grid layout style:', 'okthemes' ),
                            'id'       => "{$prefix}team_grid_layout_style",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'gap' => __( 'Gap', 'okthemes' ),
                                    'nogap' => __( 'No gap', 'okthemes' )
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'gap',
                            'placeholder' => __( 'Select grid layout style', 'okthemes' ),
                        ),
                        // CHECKBOX
                        array(
                                'name' => __( 'Display category filter', 'okthemes' ),
                                'id'   => "{$prefix}team_cat_filter",
                                'type' => 'checkbox',
                                // Value can be 0 or 1
                                'std'  => 0,
                        ),
                        array(
                                'name' => __( 'Disable image resize', 'okthemes' ),
                                'id'   => "{$prefix}disable_image_resize",
                                'type' => 'checkbox',
                                'desc'  => 'If checked the images will not be resized, instead they will be displayed at full scale. Usefull if you use masonry layout mode.',
                                // Value can be 0 or 1
                                'std'  => 0,
                        ),
                        array(
                            'name'  => 'Number of posts to display',
                            'id'    => "{$prefix}team_no_posts",
                            'desc'  => 'Enter the number of posts to display before the pagination kicks in. Default: 9',
                            'type'  => 'text',
                            'std'   => '9',
                        ),
                                                                       
                ),
                
        );

        // Testimonials page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'testimonials_page_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Testimonials Page Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'     => __( 'Display testimonials posts on:', 'okthemes' ),
                            'id'       => "{$prefix}testimonials_col_select",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'three_columns' => __( 'Three columns', 'okthemes' ),
                                    'two_columns' => __( 'Two columns', 'okthemes' ),
                                    'one_column' => __( 'One column', 'okthemes' ),
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'two_columns',
                            'placeholder' => __( 'Select columns', 'okthemes' ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Testimonials grid layout mode:', 'okthemes' ),
                            'id'       => "{$prefix}testimonials_grid_layout_mode",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'fitRows' => __( 'Grid Fit rows', 'okthemes' ),
                                    'masonry' => __( 'Grid Masonry', 'okthemes' )
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'fitRows',
                            'placeholder' => __( 'Select grid layout mode', 'okthemes' ),
                        ),
                        // SELECT BOX
                        array(
                            'name'     => __( 'Testimonials grid layout style:', 'okthemes' ),
                            'id'       => "{$prefix}testimonials_grid_layout_style",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                    'gap' => __( 'Gap', 'okthemes' ),
                                    'nogap' => __( 'No gap', 'okthemes' )
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'gap',
                            'placeholder' => __( 'Select grid layout style', 'okthemes' ),
                        ),
                        array(
                            'name'  => 'Number of posts to display',
                            'id'    => "{$prefix}testimonials_no_posts",
                            'desc'  => 'Enter the number of posts to display before the pagination kicks in. Default: 9',
                            'type'  => 'text',
                            'std'   => '9',
                        ),
                                                                       
                ),
                
        );

        
        // Contact page metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'contact_page_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Contact Page Options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'page' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Enter your email address',
                            'id'    => "{$prefix}contact_page_email",
                            'desc'  => 'Enter your email address.',
                            'type'  => 'email',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Enter success text',
                            'id'    => "{$prefix}contact_page_success_msg",
                            'desc'  => 'Enter the success text',
                            'type'  => 'text',
                            'std'   => 'Your message was sent successfully.',
                        ),
                        array(
                            'name'  => 'Enter error text',
                            'id'    => "{$prefix}contact_page_error_msg",
                            'desc'  => 'Enter the error text',
                            'type'  => 'text',
                            'std'   => 'There was an error submitting the form.',
                        ),
                        array(
                            'name'  => 'Map',
                            'id'    => "{$prefix}contact_map",
                            'desc'  => 'Enable/disable map. Default: true',
                            'std'  => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Address: Latitude value',
                            'id'    => "{$prefix}contact_map_latitude",
                            'desc'  => 'Enter the latitude value of your location in this format <pre>51.13456</pre> Latitude value is the first string (before comma) of google map address. E.G.: <strong>51.13456</strong>, -1.34333',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Address: Longitude value',
                            'id'    => "{$prefix}contact_map_longitude",
                            'desc'  => 'Enter the longitude value of your location in this format <pre>-1.34333</pre> Latitude value is the second string (after comma) of google map address. E.G.: 51.13456, <strong>-1.34333</strong>',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Zoom',
                            'id'    => "{$prefix}contact_zoom",
                            'desc'  => 'Enter the zoom level. Default: 10',
                            'type'  => 'text',
                            'std'   => '16',
                        ),
                        array(
                            'name'  => 'Map InfoWindow',
                            'id'    => "{$prefix}contact_map_infowindow",
                            'desc'  => 'Insert your address details. Will appear after you click on the marker icon. HTML supported.',
                            'type'  => 'textarea',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Map InfoWindow title',
                            'id'    => "{$prefix}contact_map_infowindow_title",
                            'desc'  => 'Insert the infoWindow title. Will appear only on marker hover.',
                            'type'  => 'text',
                            'std'   => '',
                        )
                                                                       
                ),
                
        );

        // Portfolio Item Options (Open options)
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'portfolio_cpt_meta_open',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Portfolio Item Options (Open options)', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'portfolio_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Portfolio item short description',
                            'id'    => "{$prefix}port_item_short_desc",
                            'desc'  => 'Insert a very short item description here. Will be displayed on hover.',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'     => __( 'Select what to open when you click on the portfolio item.', 'okthemes' ),
                            'id'       => "{$prefix}select_portfolio_open_type",
                            'type'     => 'select',
                            // Array of 'value' => 'Label' pairs for select box
                            'options'  => array(
                                'nothing' => __( 'Nothing', 'okthemes' ),
                                'lightbox_image' => __( 'An image in lightbox', 'okthemes' ),
                                'lightbox_video' => __( 'A video in lightbox', 'okthemes' ),
                                'custom_url' => __( 'A custom URL', 'okthemes' ),
                                'separate_page' => __( 'Portfolio item content in an <strong>separate</strong> page', 'okthemes' ),
                            ),
                            // Select multiple values, optional. Default is false.
                            'multiple'    => false,
                            'std'         => 'separate_page',
                            'placeholder' => __( 'Select an option', 'okthemes' ),
                        ),
                ),
        );

        // Portfolio Item Options (An image in lightbox)
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'portfolio_cpt_meta_lightbox_image',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Portfolio Item Options (An image in lightbox)', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'portfolio_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        
                        array(
                            'name'              => __( 'Portfolio item lightbox image','okthemes' ),
                            'id'                => "{$prefix}port_item_lightbox_image",
                            'desc'              => 'Upload the image used in lightbox.',
                            'type'              => 'image_advanced',
                            'max_file_uploads'  => 1,
                        ),

                ),
                
        );

        // Portfolio Item Options (A video in lightbox)
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'portfolio_cpt_meta_lightbox_video',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Portfolio Item Options (A video in lightbox)', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'portfolio_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        
                        array(
                            'name'  => 'Portfolio item lightbox video',
                            'id'    => "{$prefix}port_item_lightbox_video",
                            'desc'  => 'Insert the video link (Vimeo or Youtube)',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                ),
                
        );

        
        // Portfolio Item Options (Custom URL)
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'portfolio_cpt_meta_custom_url',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Portfolio Item Options (Custom URL)', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'portfolio_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        
                        array(
                            'name'  => __( 'Custom URL', 'okthemes' ),
                            'id'    => "{$prefix}port_item_custom_url",
                            'desc'  => __( 'Insert a custom URL here. The portfolio item will link to this URL instead of the default one (the one that sends you to the portfolio details page)', 'okthemes' ),
                            'type'  => 'url',
                            'std'   => '',
                        ),
                ),
                
        );

        // Portfolio Item Options (Portfolio item content in an separate page)
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'portfolio_cpt_meta_separate_page',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Portfolio Item Options (Portfolio item content in an separate/overlay page)', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'portfolio_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        // Portfolio post view slideshow
                        array(
                            'name'              => __( 'Portfolio post slideshow images','okthemes' ),
                            'id'                => "{$prefix}port_post_slideshow_image",
                            'desc'              => 'Upload the images used in slideshow.',
                            'type'              => 'image_advanced',
                            'max_file_uploads'  => 50,
                        ),

                        array(
                            'type' => 'heading',
                            'name' => __( 'Details module', 'okthemes' ),
                            'id'   => 'port_post_e_d_details_fake_id', // Not used but needed for plugin
                        ),  
                        array(
                            'name'  => 'Use details module?',
                            'id'    => "{$prefix}port_post_meta_details_use",
                            'desc'  => 'Enable/Disable details module. Uncheck to disable.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),  
                        array(
                            'name'  => 'Details title',
                            'id'    => "{$prefix}port_post_meta_details_title",
                            'desc'  => 'Put your details title here',
                            'type'  => 'text',
                            'std'   => 'Project Details',
                        ),
                        array(
                            'name'  => 'Details - Project date',
                            'id'    => "{$prefix}port_post_meta_details_date",
                            'desc'  => 'Put your project date here',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Details - Client',
                            'id'    => "{$prefix}port_post_meta_details_client",
                            'desc'  => 'Put your project client here',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Details - Skills/Tehnology',
                            'id'    => "{$prefix}port_post_meta_details_skills",
                            'desc'  => 'Enumarate your skills/tehnology here',
                            'type'  => 'text',
                            'std'   => '',
                        ),

                        // Description module
                        array(
                            'type' => 'heading',
                            'name' => __( 'Description module', 'okthemes' ),
                            'id'   => 'port_post_e_d_desc_fake_id', // Not used but needed for plugin
                        ),
                        array(
                            'name'  => 'Use description module?',
                            'id'    => "{$prefix}port_post_meta_description_use",
                            'desc'  => 'Enable/Disable description module. Uncheck to disable.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Description title',
                            'id'    => "{$prefix}port_post_meta_desc_title",
                            'desc'  => 'Put your description title here',
                            'type'  => 'text',
                            'std'   => 'Project Description',
                        ),
                        array(
                                'name' => __( 'Description text', 'okthemes' ),
                                'id'   => "{$prefix}port_post_meta_desc_text",
                                'type' => 'wysiwyg',
                                // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
                                'raw'  => false,

                                // Editor settings, see wp_editor() function: look4wp.com/wp_editor
                                'options' => array(
                                        'textarea_rows' => 4,
                                        'teeny'         => true,
                                        'media_buttons' => false,
                                ),
                        ),

                        // Share module
                        array(
                            'type' => 'heading',
                            'name' => __( 'Share module', 'okthemes' ),
                            'id'   => 'port_post_e_d_share_fake_id', // Not used but needed for plugin
                        ),
                        array(
                            'name'  => 'Use share module?',
                            'id'    => "{$prefix}port_post_meta_share_use",
                            'desc'  => 'Enable/Disable share module. Uncheck to disable.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Share title',
                            'id'    => "{$prefix}port_post_meta_share_title",
                            'desc'  => 'Put your share title here',
                            'type'  => 'text',
                            'std'   => 'Share',
                        ),
                        array(
                            'name'  => 'Post sharing',
                            'id'    => "{$prefix}port_post_e_d_share",
                            'desc'  => 'Enable/Disable post sharing. Uncheck to disable.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),
                        array(
                            'name'  => 'Project button title',
                            'id'    => "{$prefix}port_post_meta_btn_title",
                            'desc'  => 'Put your button title here.',
                            'type'  => 'text',
                            'std'   => 'Launch project',
                        ),
                        array(
                            'name'  => 'Project button URL',
                            'id'    => "{$prefix}port_post_meta_btn_url",
                            'desc'  => 'Put your button URL here.',
                            'type'  => 'url',
                            'std'   => '',
                        ),

                        // Portfolio post ena
                        array(
                            'type' => 'heading',
                            'name' => __( 'Portfolio post enable/disable modules', 'okthemes' ),
                            'id'   => 'port_post_e_d_meta_fake_id', // Not used but needed for plugin
                        ),

                        array(
                            'name'  => 'Header post meta',
                            'id'    => "{$prefix}port_post_e_d_meta",
                            'desc'  => 'Enable/Disable header post meta (post category, date, client, etc). Uncheck to disable.',
                            'std'   => 1,
                            'type'  => 'checkbox',
                        ),

                ),
                
        );

        

        // Portfolio page metabox img size
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'port_page_img_info',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Portfolio image size guidelines', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'portfolio_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'side',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'low',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        // Description
                        array(
                            'type' => 'description',
                            'name' => __( '
                                <strong>Recommended sizes:</strong> <br />
                                2 columns : 555x585px <br />
                                3 columns : 360x390px <br />
                                4 columns : 263x293px <br />
                                <em>You can upload images of any size, they will be automatically resized to these values.</em> <br />
                                <strong>For retina support, upload your images at twice the size, the script will do the rest. For example, instead of 360x390px you must upload 720x780px.</strong><br /><br />
                                <strong>Portfolio inner page slider size:</strong><br>
                                The images can be of any size, for best display use 1140px for the width and the height can be as much as you want.<br>
                                <em>This images are not resized, instead are displayed at full scale.</em>
                            ', 'okthemes' ),
                            'id'   => 'port_img_sizes_fake_id', // Not used but needed for plugin
                        ),
                ),
                
        );

        // Team post type metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'team_cpt_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Team member options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'team_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => __( 'Team member position','okthemes' ),
                            'id'    => "{$prefix}team_member_position",
                            'desc'  => __( 'Insert the team member position here. E.g.: Designer','okthemes'),
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                                'name' => __( 'Team member description','okthemes' ),
                                'id'   => "{$prefix}team_member_description",
                                'type' => 'wysiwyg',
                                // Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
                                'raw'  => false,
                                // Editor settings, see wp_editor() function: look4wp.com/wp_editor
                                'options' => array(
                                        'textarea_rows' => 4,
                                        'teeny'         => true,
                                        'media_buttons' => false,
                                ),
                        ),
                        array(
                            'name'              => __( 'Team member lightbox image','okthemes' ),
                            'id'                => "{$prefix}team_member_lightbox_image",
                            'desc'              => __( 'Upload the image used in lightbox.','okthemes'),
                            'type'              => 'image_advanced',
                            'max_file_uploads'  => 1,
                        ),
                        array(
                            'name'  => __( 'Facebook link','okthemes' ),
                            'id'    => "{$prefix}team_member_facebook_link",
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => __( 'Twitter link','okthemes' ),
                            'id'    => "{$prefix}team_member_twitter_link",
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => __( 'Linkedin link','okthemes' ),
                            'id'    => "{$prefix}team_member_linkedin_link",
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => __( 'Google Plus link','okthemes' ),
                            'id'    => "{$prefix}team_member_google_link",
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => __( 'Flickr link','okthemes' ),
                            'id'    => "{$prefix}team_member_flickr_link",
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => __( 'Dribbble link','okthemes' ),
                            'id'    => "{$prefix}team_member_dribbble_link",
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => __( 'Vimeo link','okthemes' ),
                            'id'    => "{$prefix}team_member_vimeo_link",
                            'type'  => 'text',
                            'std'   => '',
                        ),
                        array(
                            'name'  => __( 'Youtube link','okthemes' ),
                            'id'    => "{$prefix}team_member_youtube_link",
                            'type'  => 'text',
                            'std'   => '',
                        )

                ),
                
        );

        // testimonials post type metabox
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'testimonials_cpt_meta',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Testimonial options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'testimonials_cpt' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => __( 'Testimonial','okthemes' ),
                            'id'    => "{$prefix}testimonial_description",
                            'desc'  => __( 'Insert the testimonial here.','okthemes'),
                            'type'  => 'textarea',
                            'std'   => '',
                        ),

                ),
                
        );

        // Post format - Gallery
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'post_format_gallery',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Post format: Gallery options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'post' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'              => __( 'Post format gallery images','okthemes' ),
                            'id'                => "{$prefix}post_format_gallery_images",
                            'desc'              => 'Upload the images used in gallery.',
                            'type'              => 'image_advanced',
                            'max_file_uploads'  => 50,
                        ),

                ),
                
        );
         
         // Post format - audio
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'post_format_audio',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Post format: Audio options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'post' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Embedded audio',
                            'id'    => "{$prefix}post_format_audio_embedded",
                            'desc'  => 'Insert the embedded audio here',
                            'type'  => 'textarea',
                            'std'   => '',
                        ),

                        array(
                            'name'  => 'MP3 file URL (self hosted)',
                            'id'    => "{$prefix}post_format_audio_mp3",
                            'desc'  => 'Insert the url of your self hosted mp3 file',
                            'type'  => 'text',
                            'std'   => '',
                        ),

                        array(
                            'name'  => 'OGA/OGG file URL (self hosted)',
                            'id'    => "{$prefix}post_format_audio_oga",
                            'desc'  => 'Insert the url of your self hosted oga file',
                            'type'  => 'text',
                            'std'   => '',
                        ),


                ),
                
        );


         // Post format - video
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'post_format_video',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Post format: Video options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'post' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Embedded video',
                            'id'    => "{$prefix}post_format_video_embedded",
                            'desc'  => 'Insert the embedded video here',
                            'type'  => 'textarea',
                            'std'   => '',
                        ),

                        array(
                            'name'  => 'MP4/M4V file URL (self hosted)',
                            'id'    => "{$prefix}post_format_video_mp4",
                            'desc'  => 'Insert the url of your self hosted mp4/m4v file',
                            'type'  => 'text',
                            'std'   => '',
                        ),

                        array(
                            'name'  => 'OGV file URL (self hosted)',
                            'id'    => "{$prefix}post_format_video_ogv",
                            'desc'  => 'Insert the url of your self hosted ogv file',
                            'type'  => 'text',
                            'std'   => '',
                        ),

                        array(
                            'name'  => 'WEBMV file URL (self hosted)',
                            'id'    => "{$prefix}post_format_video_webmv",
                            'desc'  => 'Insert the url of your self hosted webm file',
                            'type'  => 'text',
                            'std'   => '',
                        ),


                ),
                
        );
        
       // Post format - Link
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'post_format_link',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Post format: Link options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'post' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'URL',
                            'id'    => "{$prefix}post_format_link_url",
                            'desc'  => 'Insert the URL here',
                            'type'  => 'url',
                            'std'   => '',
                        ),
                ),
                
        );

      // Post format - Quote
        $meta_boxes[] = array(
                // Meta box id, UNIQUE per meta box. Optional since 4.1.5
                'id' => 'post_format_quote',

                // Meta box title - Will appear at the drag and drop handle bar. Required.
                'title' => __( 'Post format: Quote options', 'okthemes' ),

                // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                'pages' => array( 'post' ),

                // Where the meta box appear: normal (default), advanced, side. Optional.
                'context' => 'normal',

                // Order of meta box: high (default), low. Optional.
                'priority' => 'high',

                // Auto save: true, false (default). Optional.
                'autosave' => true,

                // List of meta fields
                'fields' => array(
                        array(
                            'name'  => 'Quote',
                            'id'    => "{$prefix}post_format_blockquote",
                            'desc'  => 'Insert the quote here',
                            'type'  => 'textarea',
                            'std'   => '',
                        ),
                        array(
                            'name'  => 'Quote author',
                            'id'    => "{$prefix}post_format_blockquote_author",
                            'desc'  => 'Insert the quote author here',
                            'type'  => 'text',
                            'std'   => '',
                        ),
                ),

                
        );
            
      

        return $meta_boxes;
}