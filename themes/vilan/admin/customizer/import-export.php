<?php 

function gg_add_customizer_menu() {
  add_theme_page( 'Customizer Import', 'Import theme options', 'edit_theme_options', 'import', 'gg_customizer_import_option_page' );
  add_theme_page( 'Customizer Export', 'Export theme options', 'edit_theme_options', 'export', 'gg_customizer_export_option_page' );
  add_theme_page( 'Load Demo Content', 'Load Demo content', 'edit_theme_options', 'import_content', 'gg_customizer_import_content_page' );
}

add_action( 'admin_menu', 'gg_add_customizer_menu' );


//Output buffering

ob_start();

//Import
function gg_customizer_import_option_page() {
?>
  <div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    <h2>Customizer Import</h2>
    <?php
    if ( isset( $_FILES['import'] ) && check_admin_referer( 'gg-customizer-import' ) ) {
      if ( $_FILES['import']['error'] > 0 ) {
        wp_die( 'An error occured.' );
      } else {
        $file_name = $_FILES['import']['name'];
        $file_ext  = strtolower( end( explode( '.', $file_name ) ) );
        $file_size = $_FILES['import']['size'];
        if ( ( $file_ext == 'json' ) && ( $file_size < 500000 ) ) {
          $encode_options = file_get_contents( $_FILES['import']['tmp_name'] );
          $options        = json_decode( $encode_options, true );
          foreach ( $options as $key => $value ) {
            set_theme_mod( $key, $value );
          }
          echo '<div class="updated"><p>All options were restored successfully!</p></div>';
        } else {
          echo '<div class="error"><p>Invalid file or file size too big.</p></div>';
        }
      }
    }
    ?>
    <form method="post" enctype="multipart/form-data">
      <?php wp_nonce_field( 'gg-customizer-import' ); ?>
      <p>If you have settings in a backup file (json) on your computer, the Import system can import it into this site. To get started, upload your backup file using the form below.</p>
      <p>Choose a file (json) from your computer: <input type="file" id="customizer-upload" name="import"></p>
      <p class="submit">
        <input type="submit" name="submit" id="customizer-submit" class="button" value="Upload file and import">
      </p>
    </form>
  </div>
<?php
}



//Export Page
function gg_customizer_export_option_page() {
  if ( ! isset( $_POST['export'] ) ) {
  ?>
    <div class="wrap">
      <div id="icon-tools" class="icon32"><br></div>
      <h2>Customizer Export</h2>
      <form method="post">
        <?php wp_nonce_field( 'gg-customizer-export' ); ?>
        <p>When you click the button below, the Export system will create a backup file (json) for you to save to your computer.</p>
        <p>This text file can be used to restore your settings here on "Smarty", or to easily setup another website with the same theme settings.</p>
        <p><em>Please note that this export manager backs up only your theme settings and not your content. To backup your content, please use the WordPress Export Tool.</em></p>
        <p class="submit"><input type="submit" name="export" class="button button-primary" value="Download Backup File"></p>
      </form>
    </div>

  <?php
    $options   = get_theme_mods();

  } elseif ( check_admin_referer( 'gg-customizer-export' ) ) {

    $blogname  = strtolower( str_replace(' ', '', get_option( 'blogname' ) ) );
    $date      = date( 'm-d-Y' );
    $json_name = $blogname . '-customizer-' . $date;
    $options   = get_theme_mods();

    unset( $options['nav_menu_locations'] );

    foreach ( $options as $key => $value ) {
      $value              = maybe_unserialize( $value );
      $need_options[$key] = $value;
    }

    $json_file = json_encode( $need_options );

    ob_clean();

    echo $json_file;

    header( 'Content-Type: text/json; charset=' . get_option( 'blog_charset' ) );
    header( 'Content-Disposition: attachment; filename=' . $json_name . '.json' );

    exit();

  }
}

//Import default content
function gg_customizer_import_content_page() {
  if ( ! isset( $_POST['import-content'] ) ) {
?>
    <div class="wrap">
    <form enctype="multipart/form-data" method="post">
    <?php wp_nonce_field( 'gg-customizer-import-content' ); ?>
    <input type="hidden" name="gg-customizer-import-content" value="true" />

        <h2>Import demo content</h2>
        <p>This area allows you to install the demo theme content for easy management.</p>
        <p style="color:#E07B7B"><strong>Preinstall notes:</strong></p>
        <ul style="color:#E07B7B">
          <li>Make sure you run this imports on a <strong>clean WordPress installation</strong>, otherwise unpredictable errors may occure.</li>
          <li>Follow the bellow steps in the <strong>exact given order</strong>.</li>
        </ul>
        
        <h3><strong>Step 1.</strong> Import Default Content <em>(pages, posts, images)</em></h3>
        <p>Please download the <a href="<?php echo get_stylesheet_directory_uri().'/vilan_demo_content.xml';?>">demo content file (right click - save as)</a> to your desktop, then go to <a href="<?php echo admin_url('import.php');?>">Import</a> option and choose WordPress (install the plugin if needed). Once you are there, run the importer by uploading the sample content file. This will load in all the Pages, Posts and images. </p>
        <h3><strong>Step 2.</strong> Import Default Settings:</h3>
        <p>If you wish to setup other demo content, please check the options below. Do this <strong>after</strong> importing default content above (Step 1).</p>
        <ul>
            <li><input type="checkbox" name="default_content[theme]" value="1"> (1) Import Theme Settings</li>
            <li><input type="checkbox" name="default_content[menu]" value="1"> (2) Import Menu Settings</li>
            <li><input type="checkbox" name="default_content[widgets]" value="1"> (3) Import Sidebars and Widgets
            <input type="hidden" name="widget_positions" value="YToxMzp7czoxOToid3BfaW5hY3RpdmVfd2lkZ2V0cyI7YTowOnt9czoxMjoic2lkZWJhci1wYWdlIjthOjE6e2k6MDtzOjc6InBhZ2VzLTIiO31zOjEzOiJzaWRlYmFyLXBvc3RzIjthOjM6e2k6MDtzOjEyOiJjYXRlZ29yaWVzLTMiO2k6MTtzOjI0OiJnZ19yZWNlbnRfcG9zdHNfd2lkZ2V0LTIiO2k6MjtzOjE3OiJyZWNlbnQtY29tbWVudHMtMyI7fXM6MTQ6InNpZGViYXItc2VhcmNoIjthOjE6e2k6MDtzOjEwOiJhcmNoaXZlcy0zIjt9czoxNzoic2lkZWJhci1wb3J0Zm9saW8iO2E6Mjp7aTowO3M6NjoidGV4dC0yIjtpOjE7czoyNDoiZ2dfc29jaWFsX2ljb25zX3dpZGdldC0yIjt9czoxMjoic2lkZWJhci1zaG9wIjthOjQ6e2k6MDtzOjMyOiJ3b29jb21tZXJjZV9wcm9kdWN0X2NhdGVnb3JpZXMtMiI7aToxO3M6MzM6Indvb2NvbW1lcmNlX2xheWVyZWRfbmF2X2ZpbHRlcnMtMiI7aToyO3M6MjY6Indvb2NvbW1lcmNlX3ByaWNlX2ZpbHRlci0yIjtpOjM7czozMjoid29vY29tbWVyY2VfdG9wX3JhdGVkX3Byb2R1Y3RzLTIiO31zOjE1OiJzaWRlYmFyLWJicHJlc3MiO2E6Mzp7aTowO3M6MTg6ImJicF9sb2dpbl93aWRnZXQtMiI7aToxO3M6MTk6ImJicF9mb3J1bXNfd2lkZ2V0LTIiO2k6MjtzOjE5OiJiYnBfdG9waWNzX3dpZGdldC0yIjt9czoxNToic2lkZWJhci1jb250YWN0IjthOjE6e2k6MDtzOjE5OiJnZ19jb250YWN0X3dpZGdldC0yIjt9czoyMDoic2lkZWJhci1mb290ZXItZmlyc3QiO2E6MTp7aTowO3M6MTk6ImdnX2NvbnRhY3Rfd2lkZ2V0LTMiO31zOjIxOiJzaWRlYmFyLWZvb3Rlci1zZWNvbmQiO2E6MTp7aTowO3M6MTk6ImdnX3R3aXR0ZXJfd2lkZ2V0LTIiO31zOjIwOiJzaWRlYmFyLWZvb3Rlci10aGlyZCI7YToxOntpOjA7czoxODoiZ2dfZmxpY2tyX3dpZGdldC0yIjt9czoyMToic2lkZWJhci1mb290ZXItZm91cnRoIjthOjA6e31zOjEzOiJhcnJheV92ZXJzaW9uIjtpOjM7fQ==">
            <input type="hidden" name="widget_options" value="YToxNzp7czo1OiJwYWdlcyI7YToyOntpOjI7YTozOntzOjU6InRpdGxlIjtzOjU6IlBhZ2VzIjtzOjY6InNvcnRieSI7czoxMDoicG9zdF90aXRsZSI7czo3OiJleGNsdWRlIjtzOjA6IiI7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO31zOjEwOiJjYXRlZ29yaWVzIjthOjI6e2k6MzthOjQ6e3M6NToidGl0bGUiO3M6MTA6IkNhdGVnb3JpZXMiO3M6NToiY291bnQiO2k6MTtzOjEyOiJoaWVyYXJjaGljYWwiO2k6MTtzOjg6ImRyb3Bkb3duIjtpOjA7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO31zOjIyOiJnZ19yZWNlbnRfcG9zdHNfd2lkZ2V0IjthOjI6e2k6MjthOjI6e3M6NToidGl0bGUiO3M6MTI6IlJlY2VudCBwb3N0cyI7czo2OiJudW1iZXIiO2k6NTt9czoxMjoiX211bHRpd2lkZ2V0IjtpOjE7fXM6MTU6InJlY2VudC1jb21tZW50cyI7YToyOntpOjM7YToyOntzOjU6InRpdGxlIjtzOjE1OiJSZWNlbnQgY29tbWVudHMiO3M6NjoibnVtYmVyIjtpOjU7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO31zOjg6ImFyY2hpdmVzIjthOjI6e2k6MzthOjM6e3M6NToidGl0bGUiO3M6ODoiQXJjaGl2ZXMiO3M6NToiY291bnQiO2k6MTtzOjg6ImRyb3Bkb3duIjtpOjA7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO31zOjQ6InRleHQiO2E6Mjp7aToyO2E6Mzp7czo1OiJ0aXRsZSI7czo4OiJBYm91dCB1cyI7czo0OiJ0ZXh0IjtzOjIwNToiUXVpc3F1ZSBldSBleCB2ZWwgbWV0dXMgcG9ydHRpdG9yIHNhZ2l0dGlzLiBDdXJhYml0dXIgZmVybWVudHVtIGxhY3VzIG5lYyBtYXVyaXMgb3JuYXJlIGFsaXF1ZXQuIFBlbGxlbnRlc3F1ZSBtYXhpbXVzLCBlbmltIG5lYyBwb3J0dGl0b3IgYWxpcXVhbSwgZXJvcyBlc3QgYWNjdW1zYW4gYXJjdSwgdmVsIGludGVyZHVtIGp1c3RvIGVyYXQgbm9uIGxhY3VzLiI7czo2OiJmaWx0ZXIiO2I6MDt9czoxMjoiX211bHRpd2lkZ2V0IjtpOjE7fXM6MjI6ImdnX3NvY2lhbF9pY29uc193aWRnZXQiO2E6Mjp7aToyO2E6MTp7czo1OiJ0aXRsZSI7czoxMjoiU29jaWFsIEljb25zIjt9czoxMjoiX211bHRpd2lkZ2V0IjtpOjE7fXM6MzA6Indvb2NvbW1lcmNlX3Byb2R1Y3RfY2F0ZWdvcmllcyI7YToyOntpOjI7YTo2OntzOjU6InRpdGxlIjtzOjE4OiJQcm9kdWN0IENhdGVnb3JpZXMiO3M6Nzoib3JkZXJieSI7czo0OiJuYW1lIjtzOjg6ImRyb3Bkb3duIjtpOjA7czo1OiJjb3VudCI7aTowO3M6MTI6ImhpZXJhcmNoaWNhbCI7czoxOiIxIjtzOjE4OiJzaG93X2NoaWxkcmVuX29ubHkiO2k6MDt9czoxMjoiX211bHRpd2lkZ2V0IjtpOjE7fXM6MzE6Indvb2NvbW1lcmNlX2xheWVyZWRfbmF2X2ZpbHRlcnMiO2E6Mjp7aToyO2E6MTp7czo1OiJ0aXRsZSI7czoxNDoiQWN0aXZlIEZpbHRlcnMiO31zOjEyOiJfbXVsdGl3aWRnZXQiO2k6MTt9czoyNDoid29vY29tbWVyY2VfcHJpY2VfZmlsdGVyIjthOjI6e2k6MjthOjE6e3M6NToidGl0bGUiO3M6MTU6IkZpbHRlciBieSBwcmljZSI7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO31zOjMwOiJ3b29jb21tZXJjZV90b3BfcmF0ZWRfcHJvZHVjdHMiO2E6Mjp7aToyO2E6Mjp7czo1OiJ0aXRsZSI7czoxODoiVG9wIFJhdGVkIFByb2R1Y3RzIjtzOjY6Im51bWJlciI7czoxOiI1Ijt9czoxMjoiX211bHRpd2lkZ2V0IjtpOjE7fXM6MTY6ImJicF9sb2dpbl93aWRnZXQiO2E6Mjp7aToyO2E6Mzp7czo1OiJ0aXRsZSI7czo1OiJMb2dpbiI7czo4OiJyZWdpc3RlciI7czo0MjoiaHR0cDovL3d3dy5va3RoZW1lcy5jb20vdmlsYW5kZW1vL3JlZ2lzdGVyIjtzOjg6Imxvc3RwYXNzIjtzOjM4OiJodHRwOi8vd3d3Lm9rdGhlbWVzLmNvbS92aWxhbmRlbW8vbG9zdCI7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO31zOjE3OiJiYnBfZm9ydW1zX3dpZGdldCI7YToyOntpOjI7YToyOntzOjU6InRpdGxlIjtzOjY6IkZvcnVtcyI7czoxMjoicGFyZW50X2ZvcnVtIjtzOjE6IjAiO31zOjEyOiJfbXVsdGl3aWRnZXQiO2k6MTt9czoxNzoiYmJwX3RvcGljc193aWRnZXQiO2E6Mjp7aToyO2E6Njp7czo1OiJ0aXRsZSI7czoxMzoiUmVjZW50IFRvcGljcyI7czo4OiJvcmRlcl9ieSI7czo3OiJuZXduZXNzIjtzOjEyOiJwYXJlbnRfZm9ydW0iO3M6MzoiYW55IjtzOjk6InNob3dfZGF0ZSI7YjowO3M6OToic2hvd191c2VyIjtiOjA7czo5OiJtYXhfc2hvd24iO2k6Mjt9czoxMjoiX211bHRpd2lkZ2V0IjtpOjE7fXM6MTc6ImdnX2NvbnRhY3Rfd2lkZ2V0IjthOjM6e2k6MjthOjEwOntzOjU6InRpdGxlIjtzOjEzOiJRdWljayBDb250YWN0IjtzOjE1OiJjYWxsX2FyZWFfdGl0bGUiO3M6NzoiQ2FsbCB1cyI7czoxNjoid3JpdGVfYXJlYV90aXRsZSI7czoxMToiV3JpdGUgdG8gdXMiO3M6MTg6ImFkZHJlc3NfYXJlYV90aXRsZSI7czoxMToiT3VyIEFkZHJlc3MiO3M6MTg6ImFkZHJlc3NfZGlyZWN0aW9ucyI7czoyMzoiNDAuNzQwNTA4MiwgLTczLjk5MzczMjEiO3M6NzoiYWRkcmVzcyI7czoyMzoiTW91bnRhaW4gVmlldywgQ0EgOTQwNDMiO3M6NToicGhvbmUiO3M6MTE6IjQwIDI1NSA1Njg5IjtzOjM6ImZheCI7czoxMToiNDAgMjU1IDU2ODciO3M6NToiZW1haWwiO3M6MTY6Im9mZmljZUBlbWFpbC5jb20iO3M6NToic2t5cGUiO3M6MTE6ImNvbXBhbnluYW1lIjt9aTozO2E6MTA6e3M6NToidGl0bGUiO3M6MTA6IkNvbnRhY3QgdXMiO3M6MTU6ImNhbGxfYXJlYV90aXRsZSI7czo1OiJQaG9uZSI7czoxNjoid3JpdGVfYXJlYV90aXRsZSI7czo1OiJFbWFpbCI7czoxODoiYWRkcmVzc19hcmVhX3RpdGxlIjtzOjc6IkFkZHJlc3MiO3M6MTg6ImFkZHJlc3NfZGlyZWN0aW9ucyI7czowOiIiO3M6NzoiYWRkcmVzcyI7czoyMzoiTW91bnRhaW4gVmlldywgQ0EgOTQwNDMiO3M6NToicGhvbmUiO3M6MTc6Iig0MCkgNTU1IDU1NiA1NTQ4IjtzOjM6ImZheCI7czoxNzoiKDQwKSA1NTUgNTU2IDU1NDciO3M6NToiZW1haWwiO3M6MTU6ImVtYWlsQGVtYWlsLmNvbSI7czo1OiJza3lwZSI7czo4OiJwc2RfaHRtbCI7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO31zOjE3OiJnZ190d2l0dGVyX3dpZGdldCI7YToyOntpOjI7YTozOntzOjU6InRpdGxlIjtzOjc6IlR3aXR0ZXIiO3M6ODoidXNlcm5hbWUiO3M6NjoiZW52YXRvIjtzOjU6InBvc3RzIjtzOjE6IjEiO31zOjEyOiJfbXVsdGl3aWRnZXQiO2k6MTt9czoxNjoiZ2dfZmxpY2tyX3dpZGdldCI7YToyOntpOjI7YTozOntzOjU6InRpdGxlIjtzOjExOiJQaG90b3N0cmVhbSI7czo4OiJ1c2VybmFtZSI7czoxMjoiNTI2MTcxNTVATjA4IjtzOjU6ImNvdW50IjtpOjg7fXM6MTI6Il9tdWx0aXdpZGdldCI7aToxO319">
            </li>
        </ul>
        
        <h3><strong>Step 4.</strong> <a href="<?php echo admin_url('plugins.php');?>">Install WooCommerce plugin (Optional)</a></h3>
        <p>To import this settings, WooCommerce plugin must be installed.</p>
        <ul>
          <li><input type="checkbox" name="default_content[settings]" value="1"> Import WooCommerce Settings</li>
        </ul>

        <h3><strong>Step 5.</strong> <a href="<?php echo admin_url('plugins.php');?>">Install Revolution Slider plugin (Optional)</a></h3>
        <p>To import this settings, Revolution Slider plugin must be installed.</p>
        <ul>
          <li><input type="checkbox" name="default_content[revolution]" value="1"> Import Revolution Slider Settings</li>
        </ul>

        <input type="submit" class="button-primary" name="import-content" value="<?php _e('Import demo data','okthemes') ?>" />
    </form>
    </div>

    <?php
    } elseif ( check_admin_referer( 'gg-customizer-import-content' ) ) {



      // save all options:
      $data = $_POST;

      if(isset($data['default_content']) && is_array($data['default_content'])){
      
      //import theme settings
      if(isset($data['default_content']['theme'])&&$data['default_content']['theme']){

        $encode_options='{"0":false,"background_color":"d9e2e9","background_image":"","background_repeat":"repeat","background_position_x":"left","background_attachment":"fixed","preloader":"1","retina":"1","layout_style":"boxed","tagline_check":true,"logo_separator":"","logo_check":false,"main_logo":"","logo_width":"139","logo_height":"40","logo_margin_top":"40","main_logo_retina":"http:\/\/localhost:8888\/vilan\/wp-content\/uploads\/2014\/10\/vilan-logo-retina.png","admin_logo_separator":"","admin_logo_check":false,"admin_logo":"","admin_logo_width":"","admin_logo_height":"","favicon_separator":"","favicon_logo":"","header_social_icns":true,"header_fixed_animation":"1","header_wpml_box":"1","footer_extras":"1","footer_extras_copyright":"Copyright 2014 - All rights reserved Vilan","general_page_comments":"","general_post_comments":"1","custom_css":"","custom_js":"","rss_link":"","rss_link_header":false,"facebook_link":"da","facebook_link_header":false,"twitter_link":"okwpthemes","twitter_link_header":false,"skype_link":"adsad","skype_link_header":false,"vimeo_link":"asdasd","vimeo_link_header":false,"linkedin_link":"asda","linkedin_link_header":false,"dribble_link":"asdasd","dribble_link_header":false,"forrst_link":"asdasd","forrst_link_header":"1","flickr_link":"asd","flickr_link_header":"1","google_link":"adasd","google_link_header":"1","youtube_link":"asdasd","youtube_link_header":"1","tumblr_link":"ada","tumblr_link_header":"1","portfolio_cpt_slug":"portfolio-item","portfolio_inner_separator":"","portfolio_inner_nav":"1","portfolio_nav_base_link":"http:\/\/www.msn.com","portfolio_related_posts":"1","portfolio_related_posts_title":"Related posts","portfolio_related_posts_number":"4","blog_inner_separator":"","blog_inner_page_style":"right","blog_inner_nav":"1","blog_nav_base_link":"","blog_inner_image":true,"blog_share_box":true,"blog_archive_separator":"","archive_page_style":"right","search_separator":"","search_page_style":"right","not_found_separator":"","not_found_page_title":"Ooops page not found ...","not_found_page_description":"It seems we can\u2019t find what you\u2019re looking for. Perhaps searching, or one of the links below, can help.","not_found_contact_btn_link":"#","not_found_page_search":true,"primary-color":"#33c3ff","secondary-color":"#3b4044","tertiary-color":"#d9e2e9","font_colors_separator":"","text-color":"#999999","link-color":"#33c3ff","headings-color":"#000000","menu-color":"#b6bbbf","background_color_separator":"","body_font":"Arial,+sans-serif","body_font_style":"400","menu_font":"Helvetica+Neue,+Helvetica,+sans-serif","menu_font_style":"400","headings_font":"Helvetica+Neue,+Helvetica,+sans-serif","headings_font_style":"400","reset_options":"","background_type_select":"none","background_type_patterns":"pat25","logo_font":"Pacifico","logo_font_style":"400","pinterest_link":"ada","pinterest_link_header":"1","deviantart_link":"adasd","deviantart_link_header":"1","foursquare_link":"dadd","foursquare_link_header":"1","github_link":"dasasd","github_link_header":"1","general_store_separator":"","store_catalog_mode":false,"shop_product_columns":"3","product_per_page":"12","store_sale_flash":true,"store_products_price":true,"store_add_to_cart":true,"product_store_separator":"","product_page_layout":"with_right_sidebar","product_sale_flash":true,"product_products_price":true,"product_products_excerpt":true,"product_products_meta":true,"product_add_to_cart":true,"product_related_products":true,"product_upsells_products":true,"product_reviews_tab":true,"product_description_tab":true,"product_attributes_tab":true,"cart_store_separator":"","product_crosssells_products":"1","forum_page_layout":"with_right_sidebar","header_search":true,"header_cart":true,"primary-accent-color":"#ff5454","tertiary-accent-color":"#f7f8f8","special-accent-color":"#33c3ff","store_add_to_wishlist":"1","store_add_to_compare":"1"}';
          $options        = json_decode( $encode_options, true );
          foreach ( $options as $key => $value ) {
            set_theme_mod( $key, $value );
          }

        $frontpage = get_page('701');
        $blogpage = get_page('703');   
        update_option('show_on_front', 'page');    // show on front a static page
        update_option('page_on_front', $frontpage->ID);
        update_option('page_for_posts', $blogpage->ID);
        
        echo '<div class="updated"><p>Theme Settings were installed!</p></div>';
           
      }
      
      
      //import woocommerce pages and settings
      if(isset($data['default_content']['settings'])&&$data['default_content']['settings']){
        
        //Shop Page
        $shop_page = get_page_by_title('Shop');
        if($shop_page && $shop_page->ID){
          update_option('woocommerce_shop_page_id',$shop_page->ID);
        }
        
        //Cart Page
        $cart_page = get_page_by_title('Cart');
        if($cart_page && $cart_page->ID){
          update_option('woocommerce_cart_page_id',$cart_page->ID);
        }
        
        //Checkout Page
        $checkout_page = get_page_by_title('Checkout');
        if($checkout_page && $checkout_page->ID){
          update_option('woocommerce_checkout_page_id',$checkout_page->ID);
        }
        
       
        //My Account Page
        $myaccount_page = get_page_by_title('My Account');
        if($myaccount_page && $myaccount_page->ID){
          update_option('woocommerce_myaccount_page_id',$myaccount_page->ID);
        }

        //Wishlist Page
        $wishlist_page = get_page_by_title('Wishlist');
        if($wishlist_page && $wishlist_page->ID){
          update_option('yith_wcwl_wishlist_page_id',$wishlist_page->ID);
        }
        
        //Set image sizes    
        $catalog = array(
          'width'   => '360', // px
          'height'  => '360', // px
          'crop'    => 1    // true
        );
       
        $single = array(
          'width'   => '547', // px
          'height'  => '547', // px
          'crop'    => 1    // true
        );
       
        $thumbnail = array(
          'width'   => '90', // px
          'height'  => '90', // px
          'crop'    => 1    // false
        );


        // Image sizes
        update_option( 'shop_catalog_image_size', $catalog );     // Product category thumbs
        update_option( 'shop_single_image_size', $single );     // Single product image
        update_option( 'shop_thumbnail_image_size', $thumbnail );

        echo '<div class="updated"><p>WooCommerce Settings were installed!</p></div>';
        
        }
      
      
      //import menu settings
      if(isset($data['default_content']['menu'])&&$data['default_content']['menu']){
          $menus = get_terms('nav_menu');
          $save = array();
          foreach($menus as $menu){
              if($menu->name == 'All Pages'){
                  $save['main-menu'] = $menu->term_id;
              }else if($menu->name == 'Toolbar'){
                  $save['header-toolbar'] = $menu->term_id;
              }
          }
          if($save){
              set_theme_mod( 'nav_menu_locations', array_map( 'absint', $save ) );
              echo '<div class="updated"><p>Menu Settings were installed!</p></div>';
          }
      }
      
      //import revolution slider settings
      if(isset($data['default_content']['revolution'])&&$data['default_content']['revolution']){
        
        $rev_slider_data_home = '{"title":"homepage","alias":"homepage","shortcode":"[rev_slider homepage]","source_type":"gallery","post_types":"post","post_category":"category_29","post_sortby":"ID","posts_sort_direction":"DESC","max_slider_posts":"30","excerpt_limit":"55","slider_template_id":"","posts_list":"","slider_type":"fullscreen","fullscreen_offset_container":".navbar.navbar-default.navbar-static-top","fullscreen_offset_size":"35px","fullscreen_min_height":"150","full_screen_align_force":"off","auto_height":"off","force_full_width":"off","width":"960","height":"350","responsitive_w1":"940","responsitive_sw1":"770","responsitive_w2":"780","responsitive_sw2":"500","responsitive_w3":"510","responsitive_sw3":"310","responsitive_w4":"0","responsitive_sw4":"0","responsitive_w5":"0","responsitive_sw5":"0","responsitive_w6":"0","responsitive_sw6":"0","delay":"9000","shuffle":"off","lazy_load":"on","use_wpml":"off","enable_static_layers":"off","stop_slider":"on","stop_after_loops":0,"stop_at_slide":1,"position":"center","margin_top":0,"margin_bottom":0,"margin_left":0,"margin_right":0,"shadow_type":"0","show_timerbar":"bottom","padding":0,"background_color":"#f6f6f6","background_dotted_overlay":"none","show_background_image":"false","background_image":"http:\/\/www.okthemes.com\/vilandemo\/wp-content\/","bg_fit":"cover","bg_repeat":"no-repeat","bg_position":"center top","use_parallax":"off","disable_parallax_mobile":"on","parallax_type":"mouse","parallax_bg_freeze":"off","parallax_level_1":"5","parallax_level_2":"10","parallax_level_3":"15","parallax_level_4":"20","parallax_level_5":"25","parallax_level_6":"30","parallax_level_7":"35","parallax_level_8":"40","parallax_level_9":"45","parallax_level_10":"50","use_spinner":"3","spinner_color":"#33c3ff","stop_on_hover":"on","keyboard_navigation":"off","navigation_style":"preview1","navigaion_type":"bullet","navigation_arrows":"solo","navigaion_always_on":"false","hide_thumbs":200,"navigaion_align_hor":"center","navigaion_align_vert":"bottom","navigaion_offset_hor":"0","navigaion_offset_vert":20,"leftarrow_align_hor":"left","leftarrow_align_vert":"center","leftarrow_offset_hor":20,"leftarrow_offset_vert":0,"rightarrow_align_hor":"right","rightarrow_align_vert":"center","rightarrow_offset_hor":20,"rightarrow_offset_vert":0,"thumb_width":100,"thumb_height":50,"thumb_amount":5,"touchenabled":"on","swipe_velocity":0.7,"swipe_min_touches":1,"swipe_max_touches":1,"drag_block_vertical":"false","disable_on_mobile":"off","hide_slider_under":0,"hide_defined_layers_under":0,"hide_all_layers_under":0,"hide_arrows_on_mobile":"off","hide_bullets_on_mobile":"off","hide_thumbs_on_mobile":"off","hide_thumbs_under_resolution":0,"hide_thumbs_delay_mobile":1500,"loop_slide":"loop","start_with_slide":"1","first_transition_type":"fade","first_transition_duration":300,"first_transition_slot_amount":7,"reset_transitions":"","reset_transition_duration":0,"0":"Execute settings on all slides","jquery_noconflict":"on","js_to_body":"true","output_type":"none","custom_css":"","custom_javascript":"","template":"false"}';
        
        global $wpdb;
        $revslider_sliders =  $wpdb->prefix . 'revslider_sliders';
        $revslider_slides =  $wpdb->prefix . 'revslider_slides';
        $revslider_css =  $wpdb->prefix . 'revslider_css';

        $slider_id_css  = rand(2000, 3000);
        $slider_id_home = rand(100, 1000);
        $slides_id_home = rand(100, 1000);
        $insert_id = rand(1, 1000);

        //slider settings -  home
        $wpdb->insert( 
          $revslider_css ,
          array(
          'id' => $insert_id  ,
          'handle' => ".tp-caption.vilan_large_white_pacifico" ,
          'settings' => "" ,
          'hover' => "" ,
          'params' => '{"font-size":"46px","line-height":"36px","font-weight":"400","font-family":"Pacifico","color":"rgb(255, 255, 255)","text-decoration":"none","background-color":"transparent","border-width":"0px","border-color":"rgb(255, 214, 88)","border-style":"none"}'
        ));

        $wpdb->insert( 
          $revslider_css ,
          array(
          'id' => $insert_id + 1,
          'handle' => ".tp-caption.vilan_normal_white" ,
          'settings' => "" ,
          'hover' => "" ,
          'params' => '{"font-size":"18px","line-height":"32px","font-weight":"400","font-family":"Arial,Helvetica,sans-serif","color":"#ffffff","text-decoration":"none","background-color":"transparent","text-align":"center","opacity":"0.6","border-width":"0px","border-color":"rgb(255, 214, 88)","border-style":"none"}'
        ));
        
        //slider settings -  home
        $wpdb->insert( 
          $revslider_sliders , 
          array(
          'id' => $slider_id_home ,
          'title' => "homepage" ,
          'alias' => "homepage" ,
          'params' => $rev_slider_data_home
          )
        );


        //slides settings - home #1
        $wpdb->insert( 
          $revslider_slides , 
          array(
          'id' => $slides_id_home  ,
          'slider_id' => $slider_id_home ,
          'slide_order' => "1" ,
          'params' => '{"background_type":"image","image":"http:\/\/www.okthemes.com\/vilandemo\/wp-content\/uploads\/2014\/10\/slideshow-dummy-img-1.jpg","image_id":"2727","title":"Slide","state":"published","date_from":"","date_to":"","slide_transition":"fade","0":"Remove","slot_amount":1,"transition_rotation":0,"transition_duration":1500,"delay":"","save_performance":"off","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","class_attr":"","id_attr":"","attr_attr":"","data_attr":"","slide_bg_color":"#E7E7E7","slide_bg_external":"","bg_fit":"cover","bg_fit_x":"100","bg_fit_y":"100","bg_repeat":"no-repeat","bg_position":"left center","bg_position_x":"0","bg_position_y":"0","bg_end_position_x":"0","bg_end_position_y":"0","bg_end_position":"right center","kenburn_effect":"on","kb_start_fit":"100","kb_end_fit":"130","kb_duration":"14000","kb_easing":"Linear.easeNone","0":"Remove"}' ,
          'layers' => '[{"text":"Join the Vilan revolution!","type":"text","left":0,"top":-85,"loop_animation":"none","loop_easing":"Power3.easeInOut","loop_speed":"2","loop_startdeg":"-20","loop_enddeg":"20","loop_xorigin":"50","loop_yorigin":"50","loop_xstart":"0","loop_xend":"0","loop_ystart":"0","loop_yend":"0","loop_zoomstart":"1","loop_zoomend":"1","loop_angle":"0","loop_radius":"10","animation":"customin-1","easing":"Power3.easeInOut","split":"none","endsplit":"none","splitdelay":"10","endsplitdelay":"10","max_height":"auto","max_width":"auto","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","parallax_level":"-","whitespace":"nowrap","static_start":"1","static_end":"2","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":true,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"vilan_large_white_pacifico","time":500,"endtime":"8700","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","width":-1,"height":-1,"serial":"0","endTimeFinal":8700,"endSpeedFinal":300,"realEndTime":9000,"timeLast":8500,"endWithSlide":true,"alt":"","scaleX":"","scaleY":"","scaleProportional":false,"attrID":"","attrClasses":"","attrTitle":"","attrRel":""},{"text":"Quisque eu fermentum elit. Nam vitae erat congue sapien fringilla rhoncus. <br>Morbi enim turpis, lobortis nec condimentum non, accumsan non diam.","type":"text","left":0,"top":0,"loop_animation":"none","loop_easing":"Power3.easeInOut","loop_speed":"2","loop_startdeg":"-20","loop_enddeg":"20","loop_xorigin":"50","loop_yorigin":"50","loop_xstart":"0","loop_xend":"0","loop_ystart":"0","loop_yend":"0","loop_zoomstart":"1","loop_zoomend":"1","loop_angle":"0","loop_radius":"10","animation":"customin-2","easing":"Power3.easeInOut","split":"none","endsplit":"none","splitdelay":"10","endsplitdelay":"10","max_height":"auto","max_width":"auto","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","parallax_level":"-","whitespace":"nowrap","static_start":"1","static_end":"2","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":true,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"vilan_normal_white","time":600,"endtime":"8700","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","width":-1,"height":-1,"serial":"1","endTimeFinal":8700,"endSpeedFinal":300,"realEndTime":9000,"timeLast":8700,"endWithSlide":true,"alt":"","scaleX":"","scaleY":"","scaleProportional":false,"attrID":"","attrClasses":"","attrTitle":"","attrRel":""},{"text":"<a href=\"#\" class=\"btn btn-primary\">Get started now<\/a><a href=\"#\" class=\"btn btn-default\">Discover more<\/a>","type":"text","left":0,"top":90,"loop_animation":"none","loop_easing":"Power3.easeInOut","loop_speed":"2","loop_startdeg":"-20","loop_enddeg":"20","loop_xorigin":"50","loop_yorigin":"50","loop_xstart":"0","loop_xend":"0","loop_ystart":"0","loop_yend":"0","loop_zoomstart":"1","loop_zoomend":"1","loop_angle":"0","loop_radius":"10","animation":"customin-2","easing":"Power3.easeInOut","split":"none","endsplit":"none","splitdelay":"10","endsplitdelay":"10","max_height":"auto","max_width":"auto","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","parallax_level":"-","whitespace":"normal","static_start":"1","static_end":"2","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":true,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"vilan_normal_white","time":700,"endtime":"8700","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","width":160,"height":20,"serial":"2","endTimeFinal":8650,"endSpeedFinal":300,"realEndTime":9000,"timeLast":8650,"endWithSlide":true,"alt":"","scaleX":"","scaleY":"","scaleProportional":false,"attrID":"","attrClasses":"","attrTitle":"","attrRel":""}]'
          )
        );
        
        //slides settings - home #2
        $wpdb->insert( 
          $revslider_slides , 
          array(
          'id' => $slides_id_home +1 ,
          'slider_id' => $slider_id_home ,
          'slide_order' => "2" ,
          'params' => '{"background_type":"image","image":"http:\/\/www.okthemes.com\/vilandemo\/wp-content\/uploads\/2014\/10\/slideshow-dummy-img-2.jpg","image_id":"2728","title":"Slide","state":"published","date_from":"","date_to":"","slide_transition":"fade","0":"Remove","slot_amount":1,"transition_rotation":0,"transition_duration":1500,"delay":"","save_performance":"off","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","class_attr":"","id_attr":"","attr_attr":"","data_attr":"","slide_bg_color":"#E7E7E7","slide_bg_external":"","bg_fit":"cover","bg_fit_x":"100","bg_fit_y":"100","bg_repeat":"no-repeat","bg_position":"center top","bg_position_x":"0","bg_position_y":"0","bg_end_position_x":"0","bg_end_position_y":"0","bg_end_position":"center top","kenburn_effect":"off","kb_start_fit":"100","kb_end_fit":"100","kb_duration":"9000","kb_easing":"Linear.easeNone","0":"Remove"}' ,
          'layers' => '[{"text":"Stand up for your coolness!","type":"text","left":0,"top":-85,"loop_animation":"none","loop_easing":"Power3.easeInOut","loop_speed":"2","loop_startdeg":"-20","loop_enddeg":"20","loop_xorigin":"50","loop_yorigin":"50","loop_xstart":"0","loop_xend":"0","loop_ystart":"0","loop_yend":"0","loop_zoomstart":"1","loop_zoomend":"1","loop_angle":"0","loop_radius":"10","animation":"customin-1","easing":"Power3.easeInOut","split":"none","endsplit":"none","splitdelay":"10","endsplitdelay":"10","max_height":"auto","max_width":"auto","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","parallax_level":"-","whitespace":"nowrap","static_start":"1","static_end":"2","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":true,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"vilan_large_white_pacifico","time":500,"endtime":"8700","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","width":-1,"height":-1,"serial":"0","endTimeFinal":8700,"endSpeedFinal":300,"realEndTime":9000,"timeLast":8500,"endWithSlide":true,"alt":"","scaleX":"","scaleY":"","scaleProportional":false,"attrID":"","attrClasses":"","attrTitle":"","attrRel":""},{"text":"Quisque eu fermentum elit. Nam vitae erat congue sapien fringilla rhoncus. <br>Morbi enim turpis, lobortis nec condimentum non, accumsan non diam.","type":"text","left":0,"top":0,"loop_animation":"none","loop_easing":"Power3.easeInOut","loop_speed":"2","loop_startdeg":"-20","loop_enddeg":"20","loop_xorigin":"50","loop_yorigin":"50","loop_xstart":"0","loop_xend":"0","loop_ystart":"0","loop_yend":"0","loop_zoomstart":"1","loop_zoomend":"1","loop_angle":"0","loop_radius":"10","animation":"customin-2","easing":"Power3.easeInOut","split":"none","endsplit":"none","splitdelay":"10","endsplitdelay":"10","max_height":"auto","max_width":"auto","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","parallax_level":"-","whitespace":"nowrap","static_start":"1","static_end":"2","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":true,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"vilan_normal_white","time":600,"endtime":8700,"endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","width":-1,"height":-1,"serial":"1","endTimeFinal":8700,"endSpeedFinal":300,"realEndTime":9000,"timeLast":8700,"endWithSlide":true,"alt":"","scaleX":"","scaleY":"","scaleProportional":false,"attrID":"","attrClasses":"","attrTitle":"","attrRel":""},{"text":"<a href=\"#\" class=\"btn btn-primary\">Get started now<\/a><a href=\"#\" class=\"btn btn-default\">Discover more<\/a>","type":"text","left":0,"top":90,"loop_animation":"none","loop_easing":"Power3.easeInOut","loop_speed":"2","loop_startdeg":"-20","loop_enddeg":"20","loop_xorigin":"50","loop_yorigin":"50","loop_xstart":"0","loop_xend":"0","loop_ystart":"0","loop_yend":"0","loop_zoomstart":"1","loop_zoomend":"1","loop_angle":"0","loop_radius":"10","animation":"customin-2","easing":"Power3.easeInOut","split":"none","endsplit":"none","splitdelay":"10","endsplitdelay":"10","max_height":"auto","max_width":"auto","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","parallax_level":"-","whitespace":"nowrap","static_start":"1","static_end":"2","speed":600,"align_hor":"center","align_vert":"middle","hiddenunder":false,"resizeme":true,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","style":"vilan_normal_white","time":700,"endtime":"8700","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","width":-1,"height":-1,"serial":"2","endTimeFinal":8700,"endSpeedFinal":300,"realEndTime":9000,"timeLast":8500,"endWithSlide":true,"alt":"","scaleX":"","scaleY":"","scaleProportional":false,"attrID":"","attrClasses":"","attrTitle":"","attrRel":""}]'
          )
        );
        
        //slides settings - home #3
        $wpdb->insert( 
          $revslider_slides , 
          array(
          'id' => $slides_id_home + 2 ,
          'slider_id' => $slider_id_home ,
          'slide_order' => "3" ,
          'params' => '{"background_type":"trans","title":"Slide","state":"published","date_from":"","date_to":"","slide_transition":"fade","0":"Remove","slot_amount":1,"transition_rotation":0,"transition_duration":1500,"delay":"","save_performance":"off","enable_link":"false","link_type":"regular","link":"","link_open_in":"same","slide_link":"nothing","link_pos":"front","slide_thumb":"","class_attr":"","id_attr":"","attr_attr":"","data_attr":"","image_id":"","slide_bg_color":"#E7E7E7","slide_bg_external":"","bg_fit":"cover","bg_fit_x":"100","bg_fit_y":"100","bg_repeat":"no-repeat","bg_position":"center top","bg_position_x":"0","bg_position_y":"0","bg_end_position_x":"0","bg_end_position_y":"0","bg_end_position":"center top","kenburn_effect":"off","kb_start_fit":"100","kb_end_fit":"100","kb_duration":"9000","kb_easing":"Linear.easeNone","image":"http:\/\/www.okthemes.com\/vilandemo\/wp-content\/"}' ,
          'layers' => '[{"type":"video","style":"","video_type":"vimeo","video_width":958,"video_height":348,"video_data":{"video_type":"vimeo","id":"106181453","title":"Circle of Abstract Ritual","link":"http:\/\/vimeo.com\/106181453","author":"Jeff Frost","description":"This film took 300,000 photos, riots, wildfires, paintings in abandoned houses, two years and zero graphics to make. It changed my entire life. <br \/>\r\n<br \/>\r\nDigital downloads available at www.jeff-frost.com\/downloads<br \/>\r\ninstagram.com\/frostjeff | facebook.com\/frostjeff<br \/>\r\n<br \/>\r\nCircle of Abstract Ritual began as an exploration of the idea that creation and destruction might be the same thing. The destruction end of that thought began in earnest when riots broke out in my neighborhood in Anaheim, California, 2012. I immediately climbed onto my landlords roof without asking and began recording the unfolding events. The news agencies I contacted had no idea what to do with time lapse footage of riots, which was okay with me because I had been thinking about recontextualizing news as art for some time. After that I got the bug. I chased down wildfires, walked down storm drains on the L.A. River and found abandoned houses where I could set up elaborate optical illusion paintings. The illusion part of the paintings are not an end in themselves in my work. Theyre an intimation of things we cant physically detect; a way to get an ever so slight edge on the unknowable.  <br \/>\r\n<br \/>\r\nEarly in the process I mapped out a very interconnected narrative structure. It took a long time to fill that narrative structure in, and when I finished editing the film after seven solid weeks of being holed up in a dark room I had no idea if it was something anyone would want to watch. I almost cut the film into pieces before realizing that outside influences were pressuring me to make that decision, and that I was happy with it as it was. <br \/>\r\n<br \/>\r\nIt took a long time to come to the creation side of the original premise. It finally took form in a collaboration with sculptor, Steve Shigley, as well as 15 amazing volunteers who moved full sized tree sculptures 450 times over two nights to create the stop motion climax of the film (see the behind the scenes film, Story of Abstract Ritual for the tale of their monumental effort: www.vimeo.com\/frostjeff\/soar). <br \/>\r\n<br \/>\r\nThe idea I wanted to explore was the creation of culture as a conscious creative act, but without the trappings of dogma from institutions or even from ways of thinking. The circle of inverted trees became a small piece of the world with personal meaning where I could mark significant events, contemplate and reflect. That circle still stands, and I still visit it regularly. Several people who have been there have told me that its come to mean something special for them as well. They each have their own fascinating way of interpreting the power inherent in those trees.  <br \/>\r\n<br \/>\r\nThis film is art for the sake of art. It was made with much generosity, from the people who let me crash on their couches to the people who backed the Kickstarter to people who just wanted to pitch in: thank you. This would not have been possible without your help.<br \/>\r\n<br \/>\r\nEvery spare cent I make goes back into creating art. If youd like to see me keep doing what Im doing please consider purchasing a download or a print at www.jeff-frost.com, or PayPal me at jeff@jeff-frost.com<br \/>\r\n<br \/>\r\nThanks for watching!<br \/>\r\n<br \/>\r\nGEAR:<br \/>\r\nDynamic Perception provided motion control gear for this project. Theyre a great company run by an awesome dude (hi Jay!), and their product is rugged and reliable. Check them out http:\/\/www.dynamicperception.com\/?Click=4195","desc_small":"This film took 300,000 photos, riots, wildfires, paintings in abandoned houses, two years and zero graphics to make. It changed my entire life. <br \/>\r\n<br \/>\r\nDigital downloads available at www.jeff-...","thumb_large":{"url":"http:\/\/i.vimeocdn.com\/video\/489205812_640.jpg","width":640,"height":360},"thumb_medium":{"url":"http:\/\/i.vimeocdn.com\/video\/489205812_200x150.jpg","width":200,"height":150},"thumb_small":{"url":"http:\/\/i.vimeocdn.com\/video\/489205812_100x75.jpg","width":100,"height":75},"width":"320","height":"240","args":"title=0&byline=0&portrait=0;api=1","previewimage":"","autoplay":false,"autoplayonlyfirsttime":true,"nextslide":false,"forcerewind":false,"fullwidth":true,"videoloop":false,"controls":false,"mute":false,"cover":false,"dotted":"none","ratio":"16:9"},"video_id":"106181453","video_title":"Circle of Abstract Ritual","video_image_url":"http:\/\/i.vimeocdn.com\/video\/489205812_200x150.jpg","video_args":"title=0&byline=0&portrait=0;api=1","text":"Vimeo: Circle of Abstract Ritual","left":0,"top":0,"align_hor":"left","align_vert":"top","loop_animation":"none","loop_easing":"Power3.easeInOut","loop_speed":"2","loop_startdeg":"-20","loop_enddeg":"20","loop_xorigin":"50","loop_yorigin":"50","loop_xstart":"0","loop_xend":"0","loop_ystart":"0","loop_yend":"0","loop_zoomstart":"1","loop_zoomend":"1","loop_angle":"0","loop_radius":"10","animation":"tp-fade","easing":"Power3.easeInOut","split":"none","endsplit":"none","splitdelay":"10","endsplitdelay":"10","max_height":"auto","max_width":"auto","2d_rotation":"0","2d_origin_x":"50","2d_origin_y":"50","parallax_level":"-","whitespace":"nowrap","static_start":"1","static_end":"2","speed":300,"hiddenunder":false,"resizeme":true,"link":"","link_open_in":"same","link_slide":"nothing","scrollunder_offset":"","time":500,"endtime":"8700","endspeed":300,"endanimation":"auto","endeasing":"nothing","corner_left":"nothing","corner_right":"nothing","width":-1,"height":-1,"serial":"0","endTimeFinal":8700,"endSpeedFinal":300,"realEndTime":9000,"timeLast":8500,"endWithSlide":true,"alt":"","scaleX":"","scaleY":"","scaleProportional":false,"attrID":"","attrClasses":"","attrTitle":"","attrRel":""}]'
          )
        );
  
        echo '<div class="updated"><p>Revolution Slider Settings were installed!</p></div>';
        
                
        }
      
      //import widgets and widget settings
            if(isset($data['default_content']['widgets']) && $data['default_content']['widgets']){
                $export = false;
                if($export){
                    // export widgets
                    $widget_positions = get_option('sidebars_widgets');
                    $widget_options = array();
                    foreach($widget_positions as $sidebar_name => $widgets){
                        if(is_array($widgets)){
                            foreach($widgets as $widget_name){
                                $widget_name_strip = preg_replace('#-\d+$#','',$widget_name);
                                $widget_options[$widget_name_strip] = get_option('widget_'.$widget_name_strip);
                            }
                        }
                    }
                    $a = base64_encode(serialize($widget_positions));
                    $b = base64_encode(serialize($widget_options));
                    echo "widget_positions: \n\n\n$a\n\n\n widget_options \n\n\n$b\n\n\n";exit;
                }else{
                    // import widgets
                    $widget_positions = get_option('sidebars_widgets');

                    $import_widget_positions = unserialize(base64_decode($_REQUEST['widget_positions']));
                    $import_widget_options = unserialize(base64_decode($_REQUEST['widget_options']));
                    foreach($import_widget_options as $widget_name => $widget_options){
                        $existing_options = get_option('widget_'.$widget_name,array());
                        $new_options = $existing_options + $widget_options;
                        update_option('widget_'.$widget_name,$new_options);
                    }
                    update_option('sidebars_widgets',array_merge($widget_positions,$import_widget_positions));
                    echo '<div class="updated"><p>Widget Settings were installed!</p></div>';
                } 
            }
        }



    } ?>

<?php
}