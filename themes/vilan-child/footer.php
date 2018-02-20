<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage vilan
 */
?>

<style>
html[lang=es-ES] .wc-gg-header-minicart,
html[lang=en-US] .wc-gg-header-minicart {
  display: none;
}

/*category and product on shop page*/
html[lang="nl-NL"] body.post-type-archive-product.woocommerce-page .products .product.type-product {
  display: none;
}


html[lang="de-DE"] body.post-type-archive-product.woocommerce-page .products .product-category {
  display: none;
}
html[lang="de-DE"] body.post-type-archive-product.woocommerce-page .products .clearfix {
  display: none!important;
}
html[lang="de-DE"] .tax-total {
  display: none!important;
}
html[lang="de-DE"] .woocommerce-checkout .woocommerce-account-fields .create-account span {
    float: left;
    margin-left: 28px;
}
html[lang="de-DE"] .woocommerce-checkout .woocommerce-account-fields .create-account .input-checkbox {
  margin-top: 8px;
}

</style>

        <footer class="site-footer">
        
        <?php /*?><?php _e( 'Subtotal', 'woocommerce' ); ?><?php */?>
        
        
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






<script>
	jQuery(document).ready(function() {
  		if(jQuery('html').attr('lang') == 'nl-NL'){
  			jQuery('html').addClass("taalNL");
  		}


      jQuery( ".question" ).prepend( jQuery( "<i class='icon_question pull-left'></i>" ) );
      jQuery( ".tool" ).prepend( jQuery( "<i class='icon_tool pull-left'></i>" ) );
      jQuery( ".icon-info" ).prepend( jQuery( "<i class='icon_info pull-left'></i>" ) );
      jQuery( ".icon-cart" ).prepend( jQuery( "<i class='icon_cart pull-left'></i>" ) );
      jQuery( ".icon-mobile" ).prepend( jQuery( "<i class='icon_mobile pull-left'></i>" ) );

      jQuery( ".social-facebook" ).prepend( jQuery( "<i class='social_facebook_square'></i>" ) );
      jQuery( ".social-twitter" ).prepend( jQuery( "<i class='social_twitter_square'></i>" ) );
      jQuery( ".social-linkedin" ).prepend( jQuery( "<i class='social_linkedin_square'></i>" ) );
      jQuery( ".social-youtube" ).prepend( jQuery( "<i class='social_youtube_square'></i>" ) );

  });

</script>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47558366-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>