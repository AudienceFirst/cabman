<?php
/**
 * Template Name: RMA DE Page
 * Description: Page template with the DE RMA form and other functions.
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


wp_register_script( 'rma', get_stylesheet_directory_uri().'/assets/rmaDEform.js' );
wp_enqueue_script('rma');

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
        <div class="<?php echo esc_attr($page_content_class); ?>">
            
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'parts/part', 'page' ); ?>
                <?php comments_template( '', true ); ?>
            <?php endwhile; ?>

            <div class="clearfix"></div>
            <div id="notify">
            </div>
            <div class="contact-form-wrapper" id="loginContainer">
                <h3><?php _e('Einloggen bei Ihrem Zendeskkonto'); ?></h3>
                <p>
                    <?php _e('Haben Sie noch kein KundenKonto? Füllen Sie dann bitte <a href="https://cabman.de/kundenservice/#Zendesk" target="_blank">dieses Formular</a> aus, um ein Kundenkonto anzufragen.'); ?>
                </p>

                <form id="login_form" action="<?php the_permalink(); ?>" class="form-inline" method="post">
                    <div class="form-group">
                        <label class="sr-only" for="zd_username">
                            <?php _e( 'Benutzername', 'okthemes' ); ?>
                        </label>
                        <input placeholder="<?php _e( 'Benutzername', 'okthemes' ); ?>" type="text" name="zd_username" id="zd_username" class="required form-control" />
                    </div>    
                    <div class="form-group">    
                        <label class="sr-only" for="zd_password"><?php _e( 'Passwort', 'okthemes' ); ?></label>
                        <input placeholder="<?php _e( 'Passwort', 'okthemes' ); ?>" type="password" name="zd_password" id="zd_password" class="required email form-control" />
                    </div>

                    <button type="button" name="cabman_login" id="cabman_login" class="btn btn-primary"><?php _e( 'Einloggen', 'okthemes' ); ?></button>
                </form>

            </div><!--Close .contact-form-wrapper -->

            <div class="contact-form-wrapper" id="formContainer" style="display: none;">
                <p>
                    <?php _e('Sie sind eingelogt als <a href="https://cabman.zendesk.com" id="loggedUsername" target="_blank"></a>'); ?>
                </p>
                <h3><?php _e('Kontaktinformationen'); ?></h3>
                <p class="bigText">
                    <span id="loggedCompany"></span> <br />
                    <?php _e('z.H.'); ?> <span id="loggedName"></span><br />
                    <span id="loggedAddress"></span><br />
                    <span id="loggedZip"></span><span id="loggedTown"></span><br />
					<span id="loggedCountry"></span><br />
                </p> 
                <form id="rma_form" enctype="text/plain" action="<?php the_permalink(); ?>" class="row" method="post">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="alternative" /> <?php _e('Alternative Rücksendeadresse eingeben'); ?>
                        </label>
                    </div>
                    <div id="alt_address" style="display: none;">
					  <div class="form-group col-md-6">
						  <label class="sr-only" for="off_vest" id="loff_vest">
							  <?php _e( 'Name des Unternehmens', 'okthemes' ); ?>
						  </label>
						  <input placeholder="<?php _e( 'Name des Unternehmens', 'okthemes' ); ?>" type="text" name="off_vest" id="off_vest" class="required form-control" />
					  </div>    
					  <div class="form-group col-md-6">    
						  <label class="sr-only" for="off_cont" id="loff_cont"><?php _e( 'Ansprechpartner', 'okthemes' ); ?></label>
						  <input placeholder="<?php _e( 'Ansprechpartner', 'okthemes' ); ?>" type="text" name="off_cont" id="off_cont" class="required form-control" />
					  </div>
					  <div class="form-group col-md-6">    
						  <label class="sr-only" for="off_strn" id="loff_strn"><?php _e( 'Straße', 'okthemes' ); ?></label>
						  <input placeholder="<?php _e( 'Straße', 'okthemes' ); ?>" type="text" name="off_strn" id="off_strn" class="required form-control" />
					  </div>
					  <div class="form-group col-md-6">    
						  <label class="sr-only" for="off_huisn" id="loff_huisn"><?php _e( 'Hausnummer', 'okthemes' ); ?></label>
						  <input placeholder="<?php _e( 'Hausnummer', 'okthemes' ); ?>" type="text" name="off_huisn" id="off_huisn" class="required form-control" />
					  </div>
					  <div class="form-group col-md-6">    
						  <label class="sr-only" for="off_postc" id="loff_postc"><?php _e( 'PLZ', 'okthemes' ); ?></label>
						  <input placeholder="<?php _e( 'PLZ', 'okthemes' ); ?>" type="text" name="off_postc" id="off_postc" class="required form-control" />
					  </div>
					  <div class="form-group col-md-6">    
						  <label class="sr-only" for="off_stad" id="loff_stad"><?php _e( 'Ort', 'okthemes' ); ?></label>
						  <input placeholder="<?php _e( 'Ort', 'okthemes' ); ?>" type="text" name="off_stad" id="off_stad" class="required form-control" />
					  </div>
					  <div class="form-group col-md-12">    
						  <label class="sr-only" for="off_land" id="loff_land"><?php _e( 'Land', 'okthemes' ); ?></label>
						  <input placeholder="<?php _e( 'Land', 'okthemes' ); ?>" type="text" name="off_land" id="off_land" class="required form-control" />
					  </div>
					</div>
										
                    <div class="rmaContainer" id="rmaContainer">
                    	<h3><?php _e('Produkte'); ?></h3>
                        <div class="product-fieldset">
                            <div class="form-group col-md-6">    
                                <label class="sr-only" for="prod_selector_1" id="lprod1"><?php _e( 'Anders', 'okthemes' ); ?></label>
                                <select class="form-control" id="prod_selector_1" name="prod1">
									<option value="" selected="selected" style="display:none">Produktauswahl</option>
									<option value="BCT">Cabman BCT</option>
									<option value="Printer">Cabman printer</option>
									<option value="GRPSModem">GSM/GPRS Modem</option>
									<option value="Audioboard">Audioboard</option>
									<option value="Com_X">Com-X</option>
									<option value="MyPos">MyPOS</option>
									<option value="Other">Weitere, nämlich:</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="other1" style="display: none;">
                                <label class="sr-only" for="other1" id="lother1"><?php _e( 'Produkt', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Produkt', 'okthemes' ); ?>" type="text" name="other1" id="other1" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6" id="serial1">    
                                <label class="sr-only" for="serial1" id="lserial1"><?php _e( 'Seriennummer', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Seriennummer', 'okthemes' ); ?>" type="text" name="serial1" id="serial1" class="required form-control" />
                            </div>
                            <div class="form-group col-md-6" id="complaint1">    
                                <label class="sr-only" for="complaint1" id="lcomplaint1"><?php _e( 'Beschreibung der Problems', 'okthemes' ); ?></label>
                                <input placeholder="<?php _e( 'Beschreibung der Problems', 'okthemes' ); ?>" type="text" name="complaint1" id="complaint1" class="required form-control" />
                            </div>
                        </div>
                    </div>
                    <button type="button" name="cabman_add_row" id="cabman_add_row" class="btn"><?php _e( 'Produkt hinzufügen', 'okthemes' ); ?></button>
                
                    <div class="checkbox terms rmaChechbox">
                        <label>
                      		<input type="checkbox" id="termsofagreement" />
                          <?php _e('Ich stimme den <a href="/wp-content/uploads/2015/04/Nederland-ICT-Voorwaarden-2014-ENGELS.pdf" target="_blank">Allgemeinen Geschäftsbedingungen zu.</a>'); ?>
                        </label>
                    </div>
                    <button type="button" name="cabman_send_rma" id="cabman_send_rma" class="btn btn-primary"><?php _e( 'Senden', 'okthemes' ); ?></button>
                </form>

            </div><!--Close .contact-form-wrapper -->


            <div class="contact-form-wrapper" id="successText" style="display:none;">
                <p>
                    Danke für Ihr Rücksendeformular.<br />
                    Sie empfangen eine Bestätigungsemail. Drucken Sie bitte das Rücksendeetikett  im Anhang dieser Emai aus und bringen Sie auf dem Paket an.
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
