<header class="site-header default" role="banner">

<nav role="navigation">
    <div class="navbar navbar-default navbar-static-top">
        <div class="container">

            <?php
                $navbar_header_class = 'col-xs-12 col-md-2';
                $navbar_collapse_class = 'col-xs-12 col-md-10';

                if ( 1 == get_theme_mod( 'logo_check') ) {
                    $logo_width = get_theme_mod('logo_width');
                    if ( $logo_width <= '190' ) {
                        $navbar_header_class = 'col-xs-12 col-md-2';
                        $navbar_collapse_class = 'col-xs-12 col-md-10';
                    } elseif ($logo_width <= '285') {
                        $navbar_header_class = 'col-xs-12 col-md-3';
                        $navbar_collapse_class = 'col-xs-12 col-md-9';
                    } elseif ($logo_width <= '500') {
                        $navbar_header_class = 'col-xs-12 col-md-4';
                        $navbar_collapse_class = 'col-xs-12 col-md-8';
                    }
                }
            ?>

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header <?php echo $navbar_header_class; ?>">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

                <!-- Begin logo -->
                <?php include PARENT_DIR . '/lib/headers/logo.php';?>    
                <!-- End logo -->
            </div>

            <div class="navbar-collapse collapse <?php echo $navbar_collapse_class; ?>" id="main-navbar-collapse">

                <div class="header-toolbar-wrapper">
                <!-- Begin Toolbar Navigation -->
                <?php
                global $is_nav_mobile; 
                wp_nav_menu(
                    array(
                        'theme_location'    => 'header-toolbar',
                        'menu_class'        => 'nav '.$is_nav_mobile.' navbar-nav navbar-right',
                        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                        'menu_id'           => 'header-toolbar',
                        'depth'             => -1,
                        'walker'            => new wp_bootstrap_navwalker()
                    )
                ); ?>
                <!-- End Toolbar Navigation -->

                <!-- Header: Currency switcher -->
                <div class="gg-currency-switcher">
                    <?php do_action('currency_switcher', array('format' => '%symbol%', 'switcher_style' => 'list', 'orientation' => 'horizontal')); ?>
                </div>
                <!-- End Header: Currency switcher -->

                <!-- Header: Language selector -->
                <?php if ( 1 == get_theme_mod( 'header_wpml_box' ) && is_wpml_activated() ) { ?>
                    <div id="flags_language_selector"><?php language_selector_flags(); ?></div>
                <?php } ?>
                <!-- End Header: Language selector -->

                </div>

                <div class="main-menu-wrapper">
                    <!-- Begin Main Navigation -->
                    <?php
                    global $is_nav_mobile; 
                    wp_nav_menu(
                        array(
                            'theme_location'    => 'main-menu',
                            'menu_class'        => 'nav '.$is_nav_mobile.' navbar-nav',
                            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                            'menu_id'           => 'main-menu',
                            'walker'            => new wp_bootstrap_navwalker()
                        )
                    ); ?>


                    <!-- Header: Cart -->
                    <?php if( 1 == get_theme_mod( 'header_cart', 1 ) ) { ?>
                    <div class="navbar-nav navbar-right wc-gg-header-minicart">
                        <?php 
                        if (is_woocommerce_activated()) { 
                            if (function_exists('header_mini_cart')) { 
                                echo header_mini_cart();
                            }
                        }
                        ?>
                    </div>
                    <?php } ?>
                    <!-- End Header: Cart -->

                    <!-- Header: Search form-->
                    <?php if( 1 == get_theme_mod( 'header_search', 1 ) ) { ?>
                    <ul class="navbar-form navbar-right gg-header-minisearch hidden-xs hidden-sm">
                        <li class="icn-preview">
                            <i class="icon_search"></i>
                            <ul>
                                <li>
                                    <form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
                                        <div class="input-group">
                                          <input class="search-field" placeholder="<?php _e('Enter your search term...', 'okthemes'); ?>" type="text" value="" name="s" id="s">
                                          <span class="input-group-btn">
                                            <input class="header-search-submit" type="submit" value="Go">
                                          </span>
                                        </div><!-- /input-group -->
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <?php } ?>
                    <!-- End Header: Search form-->
                </div>

            </div>
        </div>
    </div>
</nav>

</header>
<!-- End Header. Begin Template Content -->