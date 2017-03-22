<?php 
global $post;
$permalink = get_permalink($post->ID);
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
$featured_image = $featured_image['0'];
$post_title = rawurlencode(get_the_title($post->ID));
?>

<div class="post-social">
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-justified">                   
		    	<li><a class="symbol social-facebook" title="facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($permalink); ?>&amp;images=<?php echo esc_url($featured_image); ?>"></a></li>
		        <li><a class="symbol social-twitter" title="twitter" target="_blank" href="https://twitter.com/share?url=<?php echo esc_url($permalink); ?>&amp;text=Check out this <?php echo esc_url($permalink); ?>"></a></li>
		        <li><a class="symbol social-google" title="googleplus" target="_blank" href="https://plus.google.com/share?url=<?php echo esc_url($permalink); ?>"></a></li>
		        <li><a class="symbol social-linkedin" title="linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url($permalink); ?>"></a></li>
		        <li><a class="symbol social-send" title="email" href="mailto:?subject=<?php echo $post_title; ?>&amp;body=<?php echo esc_url($permalink); ?>"></a></li>
		    </ul>
		</div>
	
    </div>    
</div>