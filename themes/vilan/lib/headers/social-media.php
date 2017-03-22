<?php if( 1 == get_theme_mod( 'header_social_icns', 1 ) ) { ?>    
<!-- Header: Social icons-->
    <div class="social-icons-widget pull-right">

      <ul class="list-inline" id="main-social-list">
            <?php if(get_theme_mod('rss_link') && get_theme_mod('rss_link_header', 1)): ?>
            <li><a class="symbol social-rss" title="circlerss" href="<?php echo esc_url(get_theme_mod('rss_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('facebook_link') && get_theme_mod('facebook_link_header', 1)): ?>
            <li><a class="symbol social-facebook" title="circlefacebook" href="<?php echo esc_url(get_theme_mod('facebook_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('twitter_link','okwpthemes') && get_theme_mod('twitter_link_header', 1)): ?>
            <li><a class="symbol social-twitter" title="circletwitter" href="<?php echo esc_url(get_theme_mod('twitter_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('pinterest_link') && get_theme_mod('pinterest_link_header', 1)): ?>
            <li><a class="symbol social-pinterest" title="circlepinterest" href="<?php echo esc_url(get_theme_mod('pinterest_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('instagram_link') && get_theme_mod('instagram_link_header', 1)): ?>
            <li><a class="symbol social-instagram" title="circleinstagram" href="<?php echo esc_url(get_theme_mod('instagram_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('skype_link') && get_theme_mod('skype_link_header', 1)): ?>
            <li><a class="symbol social-skype" title="circleskype" href="<?php echo esc_url(get_theme_mod('skype_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('vimeo_link') && get_theme_mod('vimeo_link_header', 1)): ?>
            <li><a class="symbol social-vimeo" title="circlevimeo" href="<?php echo esc_url(get_theme_mod('vimeo_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('linkedin_link') && get_theme_mod('linkedin_link_header', 1)): ?>
            <li><a class="symbol social-linkedin" title="circlelinkedin" href="<?php echo esc_url(get_theme_mod('linkedin_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('dribble_link') && get_theme_mod('dribble_link_header', 1)): ?>
            <li><a class="symbol social-dribble" title="circledribble" href="<?php echo esc_url(get_theme_mod('dribble_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('flickr_link') && get_theme_mod('flickr_link_header', 1)): ?>
            <li><a class="symbol social-flickr" title="circleflickr" href="<?php echo esc_url(get_theme_mod('flickr_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('google_link') && get_theme_mod('google_link_header', 1)): ?>
            <li><a class="symbol social-google" title="circlegoogleplus" href="<?php echo esc_url(get_theme_mod('google_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('youtube_link') && get_theme_mod('youtube_link_header', 1)): ?>
            <li><a class="symbol social-youtube" title="circleyoutube" href="<?php echo esc_url(get_theme_mod('youtube_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('deviantart_link') && get_theme_mod('deviantart_link_header', 1)): ?>
            <li><a class="symbol social-deviantart" title="circledeviantart" href="<?php echo esc_url(get_theme_mod('deviantart_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('foursquare_link') && get_theme_mod('foursquare_link_header', 1)): ?>
            <li><a class="symbol social-foursquare" title="circlefoursquare" href="<?php echo esc_url(get_theme_mod('foursquare_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('github_link') && get_theme_mod('github_link_header', 1)): ?>
            <li><a class="symbol social-github" title="circlegithub" href="<?php echo esc_url(get_theme_mod('github_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
            <?php if(get_theme_mod('tumblr_link') && get_theme_mod('tumblr_link_header', 1)): ?>
            <li><a class="symbol social-tumblr" title="circletumblr" href="<?php echo esc_url(get_theme_mod('tumblr_link')); ?>" target="_blank"></a></li>
            <?php endif; ?>
      </ul>
    </div>
<!-- End Header: Social icons-->
<?php } ?> 