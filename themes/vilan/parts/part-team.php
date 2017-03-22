<?php
/**
 * The loop that displays the team posts.
 */
?>

<?php
    //Retrieve variables from the metabox
    global $post, $team_img_width, $team_img_height, $disable_image_resize;   
    $team_member_position = rwmb_meta('gg_team_member_position');
    $team_member_description = rwmb_meta( 'gg_team_member_description');
    $team_member_lightbox_image = rwmb_meta('gg_team_member_lightbox_image', 'type=image_advanced');

    $team_member_facebook_link = rwmb_meta('gg_team_member_facebook_link');
    $team_member_twitter_link = rwmb_meta('gg_team_member_twitter_link');
    $team_member_linkedin_link = rwmb_meta('gg_team_member_linkedin_link');
    $team_member_google_link = rwmb_meta('gg_team_member_google_link');
    $team_member_flickr_link = rwmb_meta('gg_team_member_flickr_link');
    $team_member_dribbble_link = rwmb_meta('gg_team_member_dribbble_link');
    $team_member_vimeo_link = rwmb_meta('gg_team_member_vimeo_link');
    $team_member_skype_link = rwmb_meta('gg_team_member_skype_link');
    $team_member_youtube_link = rwmb_meta('gg_team_member_youtube_link');
?>
<div class="team-box">
<div class="thumbnail">
  <?php if ( has_post_thumbnail() ) { ?>
  <?php if (!empty($team_member_lightbox_image)) { //check if array is empty

    wp_enqueue_script( 'magnific' );
    wp_enqueue_style( 'magnific' );

    $team_member_lightbox_image_values = array_values($team_member_lightbox_image);
    $team_member_lightbox_image_key = array_shift($team_member_lightbox_image_values);
    $link_html = '<a class="lightbox-el link-wrapper" title="'.esc_attr($team_member_lightbox_image_key["title"]).'" href="'.esc_url($team_member_lightbox_image_key["full_url"]).'"></a>';
  } ?>

  <figure class="effect-sadie">
  <?php if (!$disable_image_resize) {
    $thumbnail_id = get_post_thumbnail_id( $post->ID );
    $img_src = gg_aq_resize( $thumbnail_id, $team_img_width, $team_img_height, true, true );
    echo '<img class="wp-post-image" src="'.esc_url($img_src).'" alt="'.get_the_title( $thumbnail_id ).'" />';
  } else {
    echo get_the_post_thumbnail($post->ID, 'full');
  } ?>
    <figcaption>
      <?php echo $link_html; ?>
      
      <?php if ($team_member_description != '') { ?>
      <div class="team-member-description"><?php echo $team_member_description; ?></div>
      <?php } ?>
      
      <div class="social-icons-widget">
        <ul class="list-inline">
        <?php if($team_member_facebook_link !=''){ ?>
        <li><a class="symbol social-facebook" title="facebook" href="<?php echo esc_url($team_member_facebook_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_twitter_link !=''){ ?>
        <li><a class="symbol social-twitter" title="twitter" href="<?php echo esc_url($team_member_twitter_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_skype_link !=''){ ?>
        <li><a class="symbol social-skype" title="skype" href="<?php echo esc_url($team_member_skype_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_vimeo_link !=''){ ?>
        <li><a class="symbol social-vimeo" title="vimeo" href="<?php echo esc_url($team_member_vimeo_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_linkedin_link !=''){ ?>
        <li><a class="symbol social-linkedin" title="linkedin" href="<?php echo esc_url($team_member_linkedin_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_dribbble_link !=''){ ?>
        <li><a class="symbol social-dribble" title="dribble" href="<?php echo esc_url($team_member_dribbble_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_flickr_link !=''){ ?>
        <li><a class="symbol social-flickr" title="flickr" href="<?php echo esc_url($team_member_flickr_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_google_link !=''){ ?>
        <li><a class="symbol social-google" title="googleplus" href="<?php echo esc_url($team_member_google_link); ?>" target="_blank"></a></li>
        <?php } ?>
        <?php if($team_member_youtube_link !=''){ ?>
        <li><a class="symbol social-youtube" title="youtube" href="<?php echo esc_url($team_member_youtube_link); ?>" target="_blank"></a></li>
        <?php } ?>
        </ul>
      </div>
    </figcaption>
  </figure>

  <?php } ?>

    <div class="caption">
      <h4><?php the_title(); ?></h4>
      <?php if ($team_member_position != '') { ?>
      <p class="team-member-position"><?php echo $team_member_position; ?></p>
      <?php } ?>
    </div>
</div>
</div>