<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

        <footer class="site-footer">
            <?php if( 1 == get_theme_mod( 'footer_widgets' , 1) ) { ?>
                <div class="container">
                    <?php get_sidebar("footer"); ?>
                </div><!-- /container -->
            <?php } ?>

            <?php if( 1 == get_theme_mod( 'footer_extras', 1 ) ) { ?>
            <div class="footer-extras">
                <div class="container">
                    <div class="row footer-line">

                        <?php if (get_theme_mod( 'footer_extras_copyright','Copyright 2014 - All rights reserved Vilan') != '') { ?>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <p class="copyright"><?php echo esc_html(get_theme_mod('footer_extras_copyright','Copyright 2014 - All rights reserved Vilan')); ?></p>
                        </div>
                        <?php } ?>

                    </div><!-- /row -->
                </div><!-- /container -->
            </div><!-- /footer-extras -->
            <?php } ?>
        </footer>
        </div><!-- /layout-width -->

        <?php if (get_theme_mod('custom_js') != '') { ?>
            <script type="text/javascript">
                //<![CDATA[
                    <?php echo stripslashes(get_theme_mod('custom_js')); ?>
                //]]>
            </script>
        <?php } ?>

        <?php wp_footer(); ?>
    </body>
</html>