<?php
/**
 * Template Name: Opzeggen Page
 * Description: Page template with Opzeggen form and other functions.
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


wp_register_script( 'opzeggen', get_stylesheet_directory_uri().'/assets/opzeggen.js' );
wp_enqueue_script('opzeggen');

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
                    <?php _e('Heeft u nog geen account? Vul dan <a href="/service/#Zendesk" target="_blank">dit formulier</a> in om een account aan te vragen.'); ?>
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
                <form id="opzeggen_form" enctype="text/plain" action="<?php the_permalink(); ?>" class="row" method="post">
                    <div class="opzeggenContainer" id="opzeggenContainer">
                    	<h3><?php _e('Abonnement opzeggen'); ?></h3>
		                	<div class="form-group">
		                    <div class="col-md-4">
		                      <label class="" for="prod_selector_1" id="lprod1"><?php _e( 'Wat wilt u graag opzeggen?*', 'okthemes' ); ?></label>
		                    </div>
		                    <div class="col-md-7">    
		                      <input type="radio" name="abotype" value="SSA" id="off_abotype" onchange="valueChanged()" /><?php _e( 'Software en Service abonnement (Cabman BCT)', 'okthemes' ); ?><br />
		                      <input type="radio" name="abotype" value="VMA" id="off_abotype" onchange="valueChanged()" /><?php _e( 'Vodafone M2M abonnement (Simkaart)', 'okthemes' ); ?><br />
		                      <input type="radio" name="abotype" value="Both" id="off_abotype" onchange="valueChanged()" /><?php _e( 'Beide abonnementen', 'okthemes' ); ?>
		                    </div>
		                  </div>
	                    <div class="form-group">
	                      <div class="col-md-4">
	                        <label class="" for="aantal" id="laantal"><?php _e( 'Aantal:*', 'okthemes' ); ?></label>
	                      </div>
	                      <div class="col-md-7">
	                        <select class="form-control" id="aantal" name="aantal" onchange="valueChanged()">
	                        	<option value="1">1</option>
	                          <option value="2">2</option>
	                          <option value="3">3</option>
	                          <option value="4">4</option>
	                          <option value="5">5</option>
	                        </select>
	                      </div>
	                    </div>
                      <div class="form-group vma formrow1" style="display: none;">
                        <div class="col-md-4">    
                        	<label class="" for="simkaartnummer" id="simkaartnummer"><?php _e( 'Simkaartnummer(s):*', 'okthemes' ); ?></label>
                        </div>
                        <div class="col-md-7">
                        	<input placeholder="" type="text" name="off_abosim" id="off_abosim" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group vma formrow2" style="display: none;">
                        <div class="col-md-4">    
                            <label class="" for="simkaartnummer" id="simkaartnummer"></label>
                        </div>
                        <div class="col-md-7">
                        	<input placeholder="" type="text" name="off_abosim" id="off_abosim" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group vma formrow3" style="display: none;">
                        <div class="col-md-4">
                        	<label class="" for="simkaartnummer" id="simkaartnummer"></label>
                        </div>
                        <div class="col-md-7">
                        	<input placeholder="" type="text" name="off_abosim" id="off_abosim" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group vma formrow4" style="display: none;">
                        <div class="col-md-4">    
                        	<label class="" for="simkaartnummer" id="simkaartnummer"></label>
                        </div>
                        <div class="col-md-7">
                        	<input placeholder="" type="text" name="off_abosim" id="off_abosim" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group vma formrow5" style="display: none;">
                        <div class="col-md-4">
                        	<label class="" for="simkaartnummer" id="simkaartnummer"></label>
                        </div>
                        <div class="col-md-7">
                        	<input placeholder="" type="text" name="off_abosim" id="off_abosim" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group ssa formrow1" style="display:none;">
                        <div class="col-md-4">
                        	<label class="" for="" id="voertuig"><?php _e( 'Voertuig:*', 'okthemes' ); ?></label>
                        </div>
                        <div class="col-md-3" id="loff_licenceplate">
                        	<input placeholder="<?php _e( 'Kenteken:*', 'okthemes' ); ?>" type="text" name="off_licenceplate" id="off_licenceplate" class="required form-control" />
                        </div>
                        <div class="col-md-4">
                        	<input placeholder="<?php _e( 'Serienummer Cabman BCT:*', 'okthemes' ); ?>" type="text" name="off_aboserial" id="off_aboserial" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group ssa formrow2" style="display:none;">
                        <div class="col-md-4">    
                        	<label class="" for=""></label>
                        </div>
                        <div class="col-md-3" id="loff_licenceplate">
                        	<input placeholder="<?php _e( 'Kenteken:*', 'okthemes' ); ?>" type="text" name="off_licenceplate" id="off_licenceplate" class="required form-control" />
                        </div>
                        <div class="col-md-4">
                        	<input placeholder="<?php _e( 'Serienummer Cabman BCT:*', 'okthemes' ); ?>" type="text" name="off_aboserial" id="off_aboserial" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group ssa formrow3" style="display:none;">
                        <div class="col-md-4">    
                        	<label class="" for=""></label>
                        </div>
                        <div class="col-md-3" id="loff_licenceplate">
                        	<input placeholder="<?php _e( 'Kenteken:*', 'okthemes' ); ?>" type="text" name="off_licenceplate" id="off_licenceplate" class="required form-control" />
                        </div>
                        <div class="col-md-4">
                        	<input placeholder="<?php _e( 'Serienummer Cabman BCT:*', 'okthemes' ); ?>" type="text" name="off_aboserial" id="off_aboserial" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group ssa formrow4" style="display:none;">
                        <div class="col-md-4">    
                        	<label class="" for=""></label>
                        </div>
                        <div class="col-md-3" id="loff_licenceplate">
                        	<input placeholder="<?php _e( 'Kenteken:*', 'okthemes' ); ?>" type="text" name="off_licenceplate" id="off_licenceplate" class="required form-control" />
                        </div>
                        <div class="col-md-4">
                        	<input placeholder="<?php _e( 'Serienummer Cabman BCT:*', 'okthemes' ); ?>" type="text" name="off_aboserial" id="off_aboserial" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group ssa formrow5" style="display:none;">
                        <div class="col-md-4">    
                        	<label class="" for=""></label>
                        </div>
                        <div class="col-md-3" id="loff_licenceplate">
                        	<input placeholder="<?php _e( 'Kenteken:*', 'okthemes' ); ?>" type="text" name="off_licenceplate" id="off_licenceplate" class="required form-control" />
                        </div>
                        <div class="col-md-4">
                        	<input placeholder="<?php _e( 'Serienummer Cabman BCT:*', 'okthemes' ); ?>" type="text" name="off_aboserial" id="off_aboserial" class="required form-control" />
                        </div>
                      </div>
                      <div class="form-group">
	                      <div class="col-md-4">
	                      	<label class="" for="off_abodate"><?php _e( 'Opzeggen per datum:*', 'okthemes' ); ?></label>
	                      </div>
	                      <div class="col-md-7">
	                      	<input placeholder="" type="date" name="off_abodate" id="off_abodate" class="required form-control" />
	                      </div>
	                    </div>
                      <div class="form-group">
			                  <div class="col-md-4">
			                  	<label class="" for="off_aboreden" id="loff_aboreden"><?php _e( 'Waarom wilt u opzeggen?*', 'okthemes' ); ?></label>
			                  </div>
	                      <div class="col-md-7" id="off_licenceplate">
	                      	<input placeholder="" type="text" name="off_aboreden" id="off_aboreden" class="required form-control" />
	                      </div>
	                    </div>
                    </div>
                    <div class="clr" style="clear: both;"></div>
                		
                    <div class="checkbox terms opzeggenChechbox">
                        <label>
                        	<input type="checkbox" id="termsofagreement"/>
                          <?php _e('Ik ga akkoord met de <a href="/wp-content/uploads/2015/04/Nederland-ICT-Voorwaarden-2014-NEDERLANDS.pdf" target="_blank">Algemene voorwaarden.</a>'); ?>
                        </label>
                    </div>
                    <button type="button" name="cabman_send_opzeggen" id="cabman_send_opzeggen" class="btn btn-primary"><?php _e( 'Verzenden', 'okthemes' ); ?></button>
                </form>

            </div><!--Close .contact-form-wrapper -->


            <div class="contact-form-wrapper" id="successText" style="display:none;">
                <p>
									Bedankt voor uw opzegging.<br />
									Wij zullen uw aanvraag verwerken. U krijgt een bevestiging zodra uw aanvraag is verwerkt.
								</p>
								<noscript>
                  <div>
                    <p style="color:red;">
                        U heeft javascript nodig!
                    </p>
                  </div>
                </noscript>
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
