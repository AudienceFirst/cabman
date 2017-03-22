<?php
/*
 * Remove/modify breadcrumbs
 */
add_filter( 'bbp_get_breadcrumb', '__return_false' );

add_filter('bbp_before_get_breadcrumb_parse_args', 'gg_bbpress_custom_breadcrumb' );
 
function gg_bbpress_custom_breadcrumb() {
    // HTML
    $args['before']          = '';
    $args['after']           = '';
 
    // Separator
    $args['sep']             = is_rtl() ? __( '<i class="arrow_carrot-left"></i>', 'bbpress' ) : __( '<i class="arrow_carrot-right"></i>', 'bbpress' );
    $args['pad_sep']         = 1;
    $args['sep_before']      = '<span class="delimiter">' ;
    $args['sep_after']       = '</span>';
 
    // Crumbs
    $args['crumb_before']    = '';
    $args['crumb_after']     = '';
 
    // Home
    $args['include_home']    = false;
 
    // Forum root
    $args['include_root']    = true;
 
    // Current
    $args['include_current'] = true;
    $args['current_before']  = '<span class="current">';
    $args['current_after']   = '</span>';
 
    return $args;
}

/*
 * Deregister default styles
 */
add_action( 'wp_print_styles', 'deregister_bbpress_styles', 15 );
function deregister_bbpress_styles() {
 wp_deregister_style( 'bbp-default' );
}

add_filter( 'bbp_get_single_forum_description', '__return_false' );
add_filter( 'bbp_get_single_topic_description', '__return_false' );


function gg_forum_user_account() { ?>

    <?php if ( !is_user_logged_in() ) { ?>
    <div class="btn-group pull-right">
        <a data-toggle="dropdown" class="btn btn-info">
        <?php _e( 'Log In', 'bbpress' ); ?>
        </a>
        <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
            <span class="caret"></span>
        </button>
        <form class="bbp-login-form dropdown-menu" action="<?php bbp_wp_login_action( array( 'context' =>'login_post' ) ); ?>" method="post">
        <fieldset>
            <legend><?php _e( 'Log In', 'bbpress' ); ?></legend>
            <div class="bbp-username">
                <label for="user_login"><?php _e( 'Username', 'bbpress' ); ?></label>
                <input id="user_login" tabindex="<?php bbp_tab_index(); ?>" type="text" name="log" size="20" value="<?php bbp_sanitize_val( 'user_login', 'text' ); ?>" />
            </div>
            <div class="bbp-password">
                <label for="user_pass"><?php _e( 'Password', 'bbpress' ); ?></label>
                <input id="user_pass" tabindex="<?php bbp_tab_index(); ?>" type="password" name="pwd" size="20" value="<?php bbp_sanitize_val( 'user_pass', 'password' ); ?>" />
            </div>
            <div class="bbp-remember-me">
                <label for="rememberme">
                    <input type="checkbox" checked="checked" name="rememberme" value="forever" id="rememberme" tabindex="<?php bbp_tab_index(); ?>" />
                    <?php _e( 'Remember Me', 'bbpress' ); ?>
                </label>
            </div>
            <div class="bbp-submit-wrapper">
                <?php do_action( 'login_form' ); ?>
                <button class="btn button submit user-submit" id="user-submit" tabindex="<?php bbp_tab_index(); ?>" name="user-submit" type="submit">
                    <?php _e( 'Log In', 'bbpress' ); ?>
                </button>
                <?php bbp_user_login_fields(); ?>
            </div>

            <?php if ( !empty( $register ) || !empty( $lostpass ) ) : ?>
            <div class="bbp-login-links">
                <?php if ( !empty( $register ) ) : ?>
                <?php endif; ?>
                <?php if ( !empty( $lostpass ) ) : ?>
                <?php endif; ?>
            </div>
             <?php endif; ?>

        </fieldset>
        </form>
    </div>
    <?php } else { ?>
    <div class="btn-group">
        <span data-toggle="dropdown" class="btn btn-info">
            <?php _e( 'Welcome ', 'okthemes' ); ?><?php bbp_user_profile_link( bbp_get_current_user_id() ); ?>
        </span>
        <button href="#" data-toggle="dropdown" class="btn btn-info dropdown-toggle share">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a class="btn" href="<?php echo bbp_get_user_profile_url( bbp_get_current_user_id() ); ?>">Edit Profile</a></li>
            <li><a class="btn" href="<?php echo wp_logout_url(); ?>">Logout</a></li>
        </ul>
    </div>

    <?php } ?>


<?php }

function gg_forum_icon() {
    global $post;
    $forum_icon = rwmb_meta('gg_forum_icon',$post->ID);
    
    if ( $forum_icon ) {
        $forum_icon_html = '<i class="'.$forum_icon.' pull-left gg-forum-icon"></i>';
    } else {
        $forum_icon_html = '';
    }
    echo $forum_icon_html;
}
