<?php
/**
 * Customize for textarea, extend the WP customizer
 *
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

class Separator_Custom_Control extends WP_Customize_Control
{
	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overriden without having to rewrite the wrapper.
	 *
	 * @since   10/16/2012
	 * @return  void
	 */
	public function render_content() {
		?>
		<label class="customizer-separator">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<hr />
		</label>
		<?php
	}

}