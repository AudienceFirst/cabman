<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * A class to create a dropdown for all google fonts
 */
 class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control
 {
    private $fonts = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        global $googleFontArrays;
        global $systemFontArrays;

        $mixedFontArrays = array_merge($googleFontArrays, $systemFontArrays);
        asort($mixedFontArrays);

        $this->fonts = $mixedFontArrays;
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content()
    {
        if(!empty($this->fonts))
        {
            ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <select <?php $this->link(); ?>>
                    
                        <?php
                            foreach ( $this->fonts as $k => $value )
                            {
                                printf('<option value="%s" %s>%s</option>', str_replace(' ', '+', $value['family']), selected($this->value(), str_replace(' ', '+', $value['family']), false), $value['family']);
                            }
 
                        ?>

                    </select>
                </label>
            <?php
        }
    }
 }
?>