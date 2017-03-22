<?php
/**
 * Template Name: Update aanvraag Page
 * Description: Page template with Update aanvraag form and other functions.
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


wp_register_script( 'updaterequest', get_stylesheet_directory_uri().'/assets/updateaanvraagform.js' );
wp_enqueue_script('updaterequest');

wp_register_script( 'shim', get_stylesheet_directory_uri().'/assets/excelreader/shim.js' );
wp_enqueue_script('shim');

wp_register_script( 'jszip', get_stylesheet_directory_uri().'/assets/excelreader/jszip.js' );
wp_enqueue_script('jszip');

wp_register_script( 'xlsx', get_stylesheet_directory_uri().'/assets/excelreader/xlsx.js' );
wp_enqueue_script('xlsx');

wp_register_script( 'ods', get_stylesheet_directory_uri().'/assets/excelreader/ods.js' );
wp_enqueue_script('ods');

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

<style>
	.borderlessCell 
	{
		border-top: 0px solid #ddd !important;
		padding: 2px !important;
	}
	
	.lineSeparator
	{
		height:1px;
		background:
		Black;border-bottom:
		1px solid #313030;
	}
	
	.popup
	{
		display:none;
		width:600px;
		height:500px;
		position:absolute;
		left:45%;
		top:30%;
		margin: -100px 0px 0px -200px;
		background-color: White;
	}
	
	.boldy
	{
		font-weight: bold;
		font-size: 20px;
		color: black;
		font-family: Arial;
	}
	
	.headerRow
	{
		color: #008fb7;
		font-weight: bold;
	}
</style>

<section id="content" class="<?php echo esc_attr($class_html); ?>">
    <div id="loaderContainer" style="display:none;position: absolute;">
		<div id="loader" style="display:none;">Loading...</div>
		<div id="updateSummary" class="popup">
			<div style="margin-left: 20px;margin-top: 20px;width: 90%;">
				<h3 style="font-weight: bold;font-family: Arial;">Bevestigen</h3>
				<div class="lineSeparator"></div>
				</br>
				<p style="margin-bottom: 25px;">Bedankt voor uw update aanvraag. Hieronder vind u een kort overzicht van uw aanvraag. Indien akkoord ontvangt u van ons de update en de factuur per mail.</p>
				<label id="summaryText"></label>
				</br>
				<div style="height:180px;overflow:auto;" id="tableDiv">
					<table>
						<thead>
							<tr class="headerRow">
								<td class="borderlessCell" id="headerInfo">Kenteken</td>
								<td class="borderlessCell" id="headerInfo">Serienummer</td>
							</tr>
						</thead>
						<tbody id="deviceOverview"></tbody>
					</table>
				</div>
				</br>
				<button type="button" name="confirmBtn" id="confirmBtn" class="btn btn-primary" style="float: right;width: 100px;clear: right;margin-bottom: 30px;"><?php _e( 'Akkoord', 'okthemes' ); ?></button>
				<button type="button" name="cancelBtn" id="cancelBtn" class="btn btn-default" style="float: right;margin-right: 5px;width: 100px;margin-bottom: 30px;"><?php _e( 'Annuleren', 'okthemes' ); ?></button>
			</div>
		</div>
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
				
				<h3><?php _e('Bedrijfsgegevens'); ?></h3>
				<div class="form-group col-md-2">
					<label class="" for="prod_selector_1" id="lprod1"><?php _e( 'Bedrijfsnaam', 'okthemes' ); ?></label>
				</div>
				<div class="form-group col-md-10">
					<input placeholder="" type="text" name="loggedCompany" id="loggedCompany" class="required form-control" style="line-height: 1.42857143;margin-bottom: 5px;width: 250px;" readonly />
				</div>
				
				<div class="form-group col-md-2">
					<label class="" for="prod_selector_1" id="lprod2"><?php _e( 'Contactpersoon', 'okthemes' ); ?></label>  
				</div>
				<div class="form-group col-md-10">
					<input placeholder="" type="text" name="loggedName" id="loggedName" class="required form-control" style="line-height: 1.42857143;margin-bottom: 5px;width: 250px;" readonly />
				</div>
				
				<h3><?php _e('Voertuigen'); ?></h3>
				<div class="form-group col-md-2">
					<label style="margin-top: 10px;"><?php _e( 'Aantal voertuigen', 'okthemes' ); ?></label>  
				</div>
				<div class="form-group col-md-10">
					<input type="text" name="amountVehicle1" id="amountVehicle1" class="required form-control numericOnly" style="width: 250px;float:left;" />
				</div>
				
				<div id="pnrInput" style="display:none;margin: 0 0 10px; clear: left;">
					<div class="form-group col-md-2">
						<label class="" for="prod_selector_1"><?php _e( 'P-nummer', 'okthemes' ); ?></label>
					</div>
					<div class="form-group col-md-10" style="margin-bottom: 5px;">
						<input placeholder="P" type="text" name="pnr1" class="required form-control pnr1" style="line-height: 1.42857143;width: 250px;margin-bottom: 5px;" />
					</div>
					<div class="form-group col-md-2"></div>
					<div class="form-group col-md-10" style="margin-bottom: 5px;">
						<label style="margin-bottom: 10px;">Heeft u meerdere P-nummers, dient u per P-nummer een aparte aanvraag in te dienen.</label>
					</div>
				</div>
				
				<div class="externalInput" style="display=none;">
					<div class="form-group col-md-2"></div>
					<div class="form-group col-md-8">
						<input type="file" name="fileinput" id="xlf" class="required form-control xlf" style="display: none;width: 350px;float: left;" />
						<label id="amountFound" style="margin-left: 15px;margin-top: 8px;display: none;font-weight: bold;color: green;">24 serie nummers gevonden</label>
						<label style="margin-left: 5px;margin-top: 5px;" id="fileInputInfo">Vanaf 10 voertuigen dient u uw kentekens aan te leveren in een Excel bestand.</label>
						<label style="margin-left: 5px;">Een voorbeeld van dit Excel bestand: <a href="no-script.html" id="exampleLink">voorbeeld</a></label>
					</div>
				</div>
				
				<div class="pnrContainer" id="pnrContainer" style="margin: 0 0 10px; clear: left;">
					<div class="form-group col-md-2"></div>
					<div class="licenseplateContainer form-group col-md-8" id="licenseplateContainer" style="display:none;">
						<input placeholder="<?php _e( 'Kenteken 1', 'okthemes' ); ?>" type="text" name="license1" id="license1" class="required form-control licenseplateBox" style="width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 1', 'okthemes' ); ?>" type="text" name="cereal1" id="cereal1" class="required form-control cerealBox numericOnly" style="width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 2', 'okthemes' ); ?>" type="text" name="license2" id="license2" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 2', 'okthemes' ); ?>" type="text" name="cereal2" id="cereal2" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 3', 'okthemes' ); ?>" type="text" name="license3" id="license3" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 3', 'okthemes' ); ?>" type="text" name="cereal3" id="cereal3" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 4', 'okthemes' ); ?>" type="text" name="license4" id="license4" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 4', 'okthemes' ); ?>" type="text" name="cereal4" id="cereal4" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 5', 'okthemes' ); ?>" type="text" name="license5" id="license5" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 5', 'okthemes' ); ?>" type="text" name="cereal5" id="cereal5" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 6', 'okthemes' ); ?>" type="text" name="license6" id="license6" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 6', 'okthemes' ); ?>" type="text" name="cereal6" id="cereal6" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 7', 'okthemes' ); ?>" type="text" name="license7" id="license7" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 7', 'okthemes' ); ?>" type="text" name="cereal7" id="cereal7" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 8', 'okthemes' ); ?>" type="text" name="license8" id="license8" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 8', 'okthemes' ); ?>" type="text" name="cereal8" id="cereal8" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 9', 'okthemes' ); ?>" type="text" name="license9" id="license9" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 9', 'okthemes' ); ?>" type="text" name="cereal9" id="cereal9" class="required form-control cerealBox numericOnly" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
						
						<input placeholder="<?php _e( 'Kenteken 10', 'okthemes' ); ?>" type="text" name="license10" id="license10" class="required form-control licenseplateBox" style="margin-top: 5px;width: 250px;display: inline-block;" />
						<input placeholder="<?php _e( 'Serienummer 10', 'okthemes' ); ?>" type="text" name="cereal10" id="cereal10" class="required form-control cerealBox" style="margin-top: 5px;width: 250px;display: inline-block;" maxlength="13" />
					</div>
				</div>
			
				<form id="updateRequest_form" enctype="text/plain" action="<?php the_permalink(); ?>" method="post">
					<div class="contact-form-wrapper" id="updateContainer" style="display:none;">
						<div class="col-md-12" style="margin-top: 50px;clear:left;">
							<label><?php _e('De software-update voor de Cabman BCT wordt u gratis aangeboden indien u gebruik maakt van een BCT Software & Service abonnement.
							Heeft u geen BCT Software & Service abonnement, dan bedragen de kosten voor de update € 39,- excl. BTW per voertuig.'); ?></label>
							<label><b>Let op! U kunt hier alleen een update aanvragen als u zelf beschikt over een <u>keuringskaart</u>. Heeft u geen keuringskaart, kunt u contact opnemen met één van onze <a href="http://cabman.nl/diensten/installatie-service/">aangesloten inbouwstations.</a></b></label>
						</div>
						<div class="checkbox terms updateChechbox col-md-12" style="clear:left;">
								<label>
									<input type="checkbox" id="termsofagreement" />
								  <?php _e('Ik ga akkoord met de <a href="/wp-content/uploads/2015/04/Nederland-ICT-Voorwaarden-2014-NEDERLANDS.pdf" target="_blank">Algemene voorwaarden.</a>'); ?>
								</label>
							</div>
							<div class="col-md-12">
								<button type="button" name="cabman_send_update" id="cabman_send_update" class="btn btn-primary"><?php _e( 'Verzenden', 'okthemes' ); ?></button>
							</div>
					</div>
				</form>
			</div><!--Close .contact-form-wrapper -->
			
			<div class="contact-form-wrapper" id="successText" style="display:none;">
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