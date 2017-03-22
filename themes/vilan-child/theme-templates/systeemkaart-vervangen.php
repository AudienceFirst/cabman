<?php
/**
 * Template Name: Systeemkaart Vervangen Page
 * Description: Page template with RMA form and other functions.
 *
 * @package WordPress
 * @subpackage vilan
 */
get_header(); ?>
<?php vilan_page_header_slider(); ?>

<?php
$page_layout = rwmb_meta('gg_page_layout_select');

$page_content_class = 'col-xs-12 col-md-8';
$page_sidebar_class = 'col-xs-12 col-md-4';
$page_heading_position_align = 'text-align-left';
$class_html = '';


wp_register_script( 'systeemkaart-vervangen', get_stylesheet_directory_uri().'/assets/systeemkaart-vervangen.js' );
wp_enqueue_script('systeemkaart-vervangen');

switch ($page_layout) {
    case "with_right_sidebar":
        $page_content_class = 'col-xs-12 col-md-8 pull-left';
        $page_sidebar_class = 'col-xs-12 col-md-4 pull-right';
        break;
    case "with_left_sidebar":
        $page_content_class = 'col-xs-12 col-md-8 pull-right';
        $page_sidebar_class = 'col-xs-12 col-md-4 pull-left';
        break;
    case "no_sidebar":
        $page_content_class = 'col-xs-12 col-md-12';
        break;        
    case "fullscreen":
        $page_content_class = 'page-fullscreen';
        $class_html = 'page-fullscreen';
        break;    
}
?>

<?php vilan_page_header(); ?>

<section id="content" class="<?php echo esc_attr($class_html); ?>">

		<div id="loaderContainer" style="display:none;">
        <div id="loader" style="display:none;">Loading...</div>
    </div>
    
    <?php if ($page_layout != 'fullscreen') echo '<div class="container"><div class="row">'; ?>
				<!--
        <div id="loaderContainer" style="display:none;">
            <div id="loader" style="display:none;">Loading...</div>
        </div>
        -->

        <div class="<?php echo esc_attr($page_content_class); ?>">
            
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'parts/part', 'page' ); ?>
                <?php comments_template( '', true ); ?>
            <?php endwhile; ?>

            <div class="clearfix"></div>
            <div id="notify">
                <!-- <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Success!</strong><span class="desc">Formulier is verzonden.</span>
                </div> -->
            </div>
            <div class="contact-form-wrapper" id="loginContainer">
                <h3><?php _e('Inloggen met uw Zendesk account'); ?></h3>
                <p>
                    <?php _e('Heeft u nog geen account? Vul dan <a href="/service/" target="_blank">dit formulier</a> in om een account aan te vragen.'); ?>
                </p>

                <form id="login_form" action="<?php the_permalink(); ?>" class="form-inline" method="post">
                    <div class="form-group">
                        <label class="sr-only" for="zd_username">
                            <?php _e( 'Gebruikersnaam', 'okthemes' ); ?>
                        </label>
                        <input placeholder="<?php _e( 'Gebruikersnaam', 'okthemes' ); ?>" type="text" name="zd_username" id="zd_username" class="required form-control" />
                    </div>    
                    <div class="form-group">    
                        <label class="sr-only" for="zd_password"><?php _e( 'Wachtwoord', 'okthemes' ); ?></label>
                        <input placeholder="<?php _e( 'Wachtwoord', 'okthemes' ); ?>" type="password" name="zd_password" id="zd_password" class="required email form-control" />
                    </div>

                    <button type="button" name="cabman_login" id="cabman_login" class="btn btn-primary"><?php _e( 'Inloggen', 'okthemes' ); ?></button>
                </form>

            </div><!--Close .contact-form-wrapper -->

            <div class="contact-form-wrapper" id="formContainer" style="display: none;">
                <p>
                    <?php _e('U bent ingelogd als <a href="https://cabman.zendesk.com" id="loggedUsername" target="_blank"></a>'); ?>
                </p>
                <h3><?php _e('Contactgegevens'); ?></h3>
                <p class="bigText">
                    <span id="loggedCompany"></span> <br />
                    <?php _e('t.a.v.'); ?> <span id="loggedName"></span><br />
                    <span id="loggedAddress"></span><br />
                    <span id="loggedZip"></span><span id="loggedTown"></span><br />
                </p> 
                <form id="systeemkaart_vervangen_form" enctype="multipart/form-data" action="<?php the_permalink(); ?>" class="row" method="post">
                    <div id="alt_address" style="display: none;">
		                  <div class="form-group col-md-6">
		                      <label class="sr-only" for="off_vest" id="loff_vest">
		                          <?php _e( 'Bedrijfsnaam', 'okthemes' ); ?>
		                      </label>
		                      <input placeholder="<?php _e( 'Bedrijfsnaam', 'okthemes' ); ?>" type="text" name="off_vest" id="off_vest" class="required form-control" />
		                  </div>    
		                  <div class="form-group col-md-6">    
		                      <label class="sr-only" for="off_cont" id="loff_cont"><?php _e( 'Contactpersoon', 'okthemes' ); ?></label>
		                      <input placeholder="<?php _e( 'Contactpersoon', 'okthemes' ); ?>" type="text" name="off_cont" id="off_cont" class="required form-control" />
		                  </div>
		                  <div class="form-group col-md-6">    
		                      <label class="sr-only" for="off_strn" id="loff_strn"><?php _e( 'Straatnaam', 'okthemes' ); ?></label>
		                      <input placeholder="<?php _e( 'Straatnaam', 'okthemes' ); ?>" type="text" name="off_strn" id="off_strn" class="required form-control" />
		                  </div>
		                  <div class="form-group col-md-6">    
		                      <label class="sr-only" for="off_huisn" id="loff_huisn"><?php _e( 'Huisnummer', 'okthemes' ); ?></label>
		                      <input placeholder="<?php _e( 'Huisnummer', 'okthemes' ); ?>" type="text" name="off_strn" id="off_strn" class="required form-control" />
		                  </div>
		                  <div class="form-group col-md-6">    
		                      <label class="sr-only" for="off_postc" id="loff_postc"><?php _e( 'Postcode', 'okthemes' ); ?></label>
		                      <input placeholder="<?php _e( 'Postcode', 'okthemes' ); ?>" type="text" name="off_postc" id="off_postc" class="required form-control" />
		                  </div>
		                  <div class="form-group col-md-6">    
		                      <label class="sr-only" for="off_stad" id="loff_stad"><?php _e( 'Plaats', 'okthemes' ); ?></label>
		                      <input placeholder="<?php _e( 'Plaats', 'okthemes' ); ?>" type="text" name="off_stad" id="off_stad" class="required form-control" />
		                  </div>
		                </div>

                    <h3><?#=_e('Producten');?></h3>
                    <div class="systeemkaartContainer" id="systeemkaartContainer">
                        <div class="product-fieldset">
                            <div class="form-group col-md-6">
                                <label class="sr-only" for="klantnaam" id="lklantnaam"><?php _e( 'Klantnaam*', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Klantnaam*', 'okthemes' ); ?>" type="text" name="klantnaam" id="klantnaam" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="sr-only" for="vestiging" id="lvestiging"><?php _e( 'Serienummer', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Vestiging', 'okthemes' ); ?>" type="text" name="vestiging" id="vestiging" class="form-control" />
                            </div>
                            <div class="form-group col-md-6" id="serienummer_bct">    
                                <label class="sr-only" for="serienummer_bct" id="lserienummer_bct"><?php _e( 'Serienummer Cabman BCT*', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Serienummer Cabman BCT*', 'okthemes' ); ?>" type="text" name="seriesnummer_bct" id="seriesnummer_bct" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6">    
                                <label class="sr-only" for="serienummer_systeemkaart" id="lserienummer_systeemkaart"><?php _e( 'Serienummer Systeemkaart*', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Serienummer Systeemkaart*', 'okthemes' ); ?>" type="text" name="serienummer_systeemkaart" id="serienummer_systeemkaart" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="sr-only" for="serienummer_zegel" id="lserienummer_zegel"><?php _e( 'Serienummer zegel*', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Serienummer zegel*', 'okthemes' ); ?>" type="text" name="serienummer_zegel" id="serienummer_zegel" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="sr-only" for="kenteken" id="lkenteken"><?php _e( 'Kenteken*', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Kenteken*', 'okthemes' ); ?>" type="text" name="kenteken" id="kenteken" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="sr-only" for="voertuigtype" id="lvoertuigtype"><?php _e( 'Voertuigtype*', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Voertuigtype*', 'okthemes' ); ?>" type="text" name="voertuigtype" id="voertuigtype" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6">
                                <label class="sr-only" for="foto" id="lfoto"><?php _e( 'Foto*', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Serienummer zegel*', 'okthemes' ); ?>" type="file" name="foto" id="foto" class="required form-control" />
                            </div>
                        </div>
                    </div>
                
                    <div class="checkbox terms systeemkaartCheckbox">
                        <label>
                      		<input type="checkbox" id="termsofagreement" />
                          <?php _e('Ik ga akkoord met de <a href="/wp-content/uploads/2015/04/Nederland-ICT-Voorwaarden-2014-NEDERLANDS.pdf" target="_blank">Algemene voorwaarden.</a>'); ?>
                        </label>
                    </div>
                    <button type="button" name="cabman_send_syskaart_vervangen" id="cabman_send_syskaart_vervangen" class="btn btn-primary"><?php _e( 'Verzenden', 'okthemes' ); ?></button>
                </form>

            </div><!--Close .contact-form-wrapper -->


            <div class="contact-form-wrapper" id="successText" style="display:none;">
                <p>
                    Bedankt voor uw Systeemkaart ervangen aanvraag.<br />
                    U ontvangt een bevestigingsmail. U dient de bijlage van deze mail af te drukken en toe te voegen aan uw pakket.
                    <br /><br />
                    <strong>Let op! Ons adres is gewijzigd:</strong>
                    <br />
                    Euphoria Software<br />
                    Wilhelminapark 36<br />
                    5041 EC Tilburg
                </p> 
            </div><!--Close .contact-form-wrapper -->

        </div><!-- /.col-8 col-sm-8 col-lg-8 -->

        <?php if (($page_layout !== 'no_sidebar') && ($page_layout !== 'fullscreen')) { ?>
        <div class="<?php echo esc_attr($page_sidebar_class); ?>">
            <aside class="sidebar-nav">
                <?php get_sidebar(); ?>
            </aside>
            <!--/aside .sidebar-nav -->
        </div><!-- /.col-4 col-sm-4 col-lg-4 -->
        <?php } ?>

    <?php if ($page_layout != 'fullscreen') echo '</div></div>'; ?>
</section>
<?php get_footer(); ?>
