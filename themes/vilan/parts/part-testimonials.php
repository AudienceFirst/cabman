<?php
/**
 * The loop that displays the team posts.
 */
?>

<?php
    //Retrieve variables from the metabox
    global $post;   
    $testimonial_description = rwmb_meta('gg_testimonial_description');;
?>

<div class="testimonials-box">

<?php if ($testimonial_description != '') { ?>
<div class="testimonials-description">
  <blockquote class="bubble">
  	<i class="icon_quotations"></i>
    <?php echo $testimonial_description; ?>
    <cite><?php the_title(); ?></cite>
  </blockquote>
</div>
<?php } ?>

<?php
if ( has_post_thumbnail() ) {
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$img_src = gg_aq_resize( $thumbnail_id, 75, 75, true, true );
?>
<img class="wp-post-image" src="<?php echo $img_src; ?>" alt="<?php echo get_the_title( $thumbnail_id ); ?>" />
<?php } ?>

</div>