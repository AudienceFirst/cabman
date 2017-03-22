<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
	<div class="input-group">
		<span class="input-group-addon"><i class="icon_search"></i></span>
		<input class="form-control input-lg" tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" placeholder="Search this forums" />
		<span class="input-group-btn">
			<input tabindex="<?php bbp_tab_index(); ?>" class="btn btn-primary btn-lg" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Search', 'bbpress' ); ?>" />
		</span>
	</div>
</form>
