<?php
/**
 * The loop that displays a single portfolio post.
 *
 */
?>
<?php
	$port_post_meta_details_use = rwmb_meta( 'gg_port_post_meta_details_use');
	$port_post_meta_details_title = rwmb_meta( 'gg_port_post_meta_details_title');
	$port_post_meta_details_date = rwmb_meta( 'gg_port_post_meta_details_date');
	$port_post_meta_details_client = rwmb_meta( 'gg_port_post_meta_details_client');
	$port_post_meta_details_skills = rwmb_meta( 'gg_port_post_meta_details_skills');

	$port_post_meta_description_use = rwmb_meta( 'gg_port_post_meta_description_use');
	$port_post_meta_desc_title = rwmb_meta( 'gg_port_post_meta_desc_title');
	$port_post_meta_desc_text = rwmb_meta( 'gg_port_post_meta_desc_text');

	$port_post_meta_share_use = rwmb_meta( 'gg_port_post_meta_share_use');
	$port_post_meta_share_title = rwmb_meta( 'gg_port_post_meta_share_title');
	$port_post_e_d_share = rwmb_meta( 'gg_port_post_e_d_share');
	$port_post_meta_btn_title = rwmb_meta( 'gg_port_post_meta_btn_title');
	$port_post_meta_btn_url = rwmb_meta( 'gg_port_post_meta_btn_url');
?>

<div class="col-xs-12 col-md-12">
	
    <?php 
    $port_post_slideshow_image = rwmb_meta( 'gg_port_post_slideshow_image', 'type=plupload_image&size=full');

	//Load carousel
	wp_enqueue_script('owlcarousel');
	wp_enqueue_script('magnific');

    if($port_post_slideshow_image){ ?>
		<div id="single-project-gallery" 
            class="owl-carousel"
            data-slides-per-view = "1"
            data-single-item = "true"
            data-transition-slide = "fade"
            data-navigation-owl = "false"
            data-pagination-owl = "true"
            data-lazyload = "true"
            data-autoplay = "false"
            data-rewind = "true"
            data-speed = "5000"
            data-height = "true"
            data-afterinit = "thumbNavigation"
            >

			<?php foreach ( $port_post_slideshow_image as $portfolio_slideshow_image ) { ?>
			
			<div class="post-image">			
				<?php echo "<img class='img-rounded lazyOwl' data-src='{$portfolio_slideshow_image['full_url']}' alt='{$portfolio_slideshow_image['alt']}' />"; ?>
			</div>

			<?php } ?>
		</div><!-- /.carousel .slide -->
	<?php } ?>

</div><!-- /.col-xs-12 .col-md-12 -->


<div class="project-description-holder">

<?php
// count the active widgets to determine column sizes
$no_of_boxes = $port_post_meta_details_use + $port_post_meta_description_use + $port_post_meta_share_use;
// default
$port_extra_grid = "col-xs-12 col-sm-6 col-md-4";
// if only one
if ($no_of_boxes == "1") {
$port_extra_grid = "project-box col-xs-12 col-md-12";
// if two, split in half
} elseif ($no_of_boxes == "2") {
$port_extra_grid = "project-box col-xs-12 col-md-6";
// if three, divide in thirds
} elseif ($no_of_boxes == "3") {
$port_extra_grid = "project-box col-xs-12 col-md-4";
}
?>

<?php if ($port_post_meta_details_use == '1') : ?>
<div class="<?php echo $port_extra_grid; ?>">

	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">
	  	<?php if (!empty($port_post_meta_details_title)) : ?>
		<h4 class="entry-title"><?php echo $port_post_meta_details_title; ?></h4>
		<?php endif; ?>
	  </div>
	  <!-- List group -->
	  <ul class="list-group">
	    <?php if (!empty($port_post_meta_details_date)) : ?>
	    <li class="list-group-item line-sep">
	    	<span class="project-meta-type"><?php _e('Date', 'okthemes'); ?></span>
	    	<span class="project-meta-type-content"><?php echo $port_post_meta_details_date; ?></span>
	    </li>
	    <?php endif; ?>
	    <?php if (portfolio_taxonomies_terms_links()) : ?>
	    <li class="list-group-item line-sep">
	    	<span class="project-meta-type"><?php _e('Category', 'okthemes'); ?></span>
	    	<span class="project-meta-type-content"><?php echo portfolio_taxonomies_terms_links(); ?></span>
	    </li>
	    <?php endif; ?>
	    <?php if (!empty($port_post_meta_details_client)) : ?>
	    <li class="list-group-item line-sep">
	    	<span class="project-meta-type"><?php _e('Client', 'okthemes'); ?></span>
	    	<span class="project-meta-type-content"><?php echo $port_post_meta_details_client; ?></span>
	    </li>
	    <?php endif; ?>
	    <?php if (!empty($port_post_meta_details_skills)) : ?>
	    <li class="list-group-item line-sep">
	    	<span class="project-meta-type"><?php _e('Skills', 'okthemes'); ?></span>
	    	<span class="project-meta-type-content"><?php echo $port_post_meta_details_skills; ?></span>
	    </li>
	    <?php endif; ?>
	  </ul>
	</div>

</div>
<?php endif; ?>

<?php if ($port_post_meta_description_use == '1') : ?>
<div class="<?php echo $port_extra_grid; ?>">
<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">
		<?php if (!empty($port_post_meta_desc_title)) : ?>
		<h4 class="entry-title"><?php echo $port_post_meta_desc_title; ?></h4>
		<?php endif; ?>
	</div>

	<div class="panel-body">
		<?php echo $port_post_meta_desc_text; ?>
	</div>
</div>
</div><!-- /.col-xs-12 .col-md-4 -->
<?php endif; ?>

<?php if ($port_post_meta_share_use == '1') : ?>
<div class="<?php echo $port_extra_grid; ?>">

<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">
		<?php if (!empty($port_post_meta_details_title)) : ?>
		<h4 class="entry-title"><?php echo $port_post_meta_details_title; ?></h4>
		<?php endif; ?>
	</div>

	<div class="panel-body">
		<?php if ($port_post_e_d_share) : ?>
		<?php get_template_part( 'parts/part', 'socialshare' ); ?>
		<?php endif; ?>

		<?php if ((!empty($port_post_meta_btn_url)) || (!empty($port_post_meta_btn_title))) : ?>
		<p class="btn-group btn-group-justified launch-project"><a class="btn btn-primary" href="<?php echo esc_url($port_post_meta_btn_url); ?>"><?php echo $port_post_meta_btn_title; ?></a></p>
		<?php endif; ?>
	</div>
</div>

</div>
<?php endif; ?>

</div><!-- /.project-description-holder -->


<div class="col-xs-12 col-md-12 portfolio-single-fullwidth-content <?php if(trim($post->post_content) == '' ) echo 'entry-no-content'; ?>">
<div class="entry-content">	
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'okthemes' ), 'after' => '</div>' ) ); ?>
</div>
</div>
