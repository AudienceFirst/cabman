<?php
/**
 * Search Form Template
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<form role="search" method="get" id="searchform" class="<?php if (is_404()) echo 'form-horizontal'; else echo 'form-inline'; ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
	<span class="input-group-addon"><i class="icon_search"></i></span>
	<input class="form-control <?php if (is_404()) echo 'input-lg'; ?>" type="text" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search', 'okthemes' ); ?>" name="s" id="s" value="sheet" />
	<span class="input-group-btn">
		<input class="btn btn-primary <?php if (is_404()) echo 'btn-lg'; ?>" type="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'okthemes' ); ?>" />
	</span>
	</div>
</form>

