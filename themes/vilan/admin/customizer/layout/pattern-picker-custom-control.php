<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom layout control
 */
class Pattern_Picker_Custom_Control extends WP_Customize_Control
{
      private $patterns = false;

      public function __construct($manager, $id, $args = array(), $options = array())
      {
          global $paternArray;
          $this->patterns = $paternArray;
          parent::__construct( $manager, $id, $args );
      }
      /**
       * Render the content on the theme customizer page
       */
      public function render_content() { ?>
          <?php
            if ( empty( $this->patterns ) )
            return;

            $name = '_customize-radio-' . $this->id;
            ?>

            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php
            foreach ( $this->patterns as $value => $label ) :
              ?>
              <label style="background:url(<?php echo $label; ?>) left top repeat;">
                <input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
              </label>
              <?php
            endforeach;
          ?>

          <?php
       }
}
?>