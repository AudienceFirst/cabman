<?php
/**
 * Template Name: Tarief aanvraag Page
 * Description: Page template with Tarief aanvraag form and other functions.
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


wp_register_script( 'tariefrequest', get_stylesheet_directory_uri().'/assets/tariefaanvraagform.js' );
wp_enqueue_script('tariefrequest');

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
		height:400px;
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
		<div id="costSummary" class="popup">
			<div style="margin-left: 20px;margin-top: 20px;width: 90%;">
				<h3 style="font-weight: bold;font-family: Arial;">Bevestigen</h3>
				<div class="lineSeparator"></div>
				</br>
				<p style="margin-bottom: 25px;">Bedankt voor uw tariefaanvraag. Hieronder vind u een overzicht van de kosten van uw aanvraag. Indien akkoord ontvangt u van ons de update en de factuur per mail.</p>
			
				<table>
					<thead>
						<tr class="headerRow">
							<td class="borderlessCell">Omschrijving</td>
							<td class="borderlessCell">Aantal</td>
							<td class="borderlessCell">Prijs per stuk</td>
							<td class="borderlessCell">Totaal</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="borderlessCell">Aanmaakkosten</td>
							<td class="borderlessCell">1</td>
							<td class="borderlessCell">€ 20,00</td>
							<td class="borderlessCell">€ 20,00</td>
						</tr>
						<tr>
							<td class="borderlessCell">1-20 updates</td>
							<td class="borderlessCell" id="amountTillTwenty">20</td>
							<td class="borderlessCell">€ 15,00</td>
							<td class="borderlessCell" id="totalTillTwenty">€ 300,00</td>
						</tr>
						<tr id="overTwentyRow">
							<td class="borderlessCell">20+ updates</td>
							<td class="borderlessCell" id="amountOverTwenty">15</td>
							<td class="borderlessCell">€ 10,00</td>
							<td class="borderlessCell" id="totalOverTwenty">€ 150,00</td>
						</tr>
					</tbody>
				</table>
				
				<label class="boldy" style="float: right;margin-right: 55px;margin-top: 5px;">Totaal te betalen <label class="boldy" id="totalLabel">€ 470,00</label></label>
				</br>
				
				<button type="button" name="confirmBtn" id="confirmBtn" class="btn btn-primary" style="float: right;width: 100px;clear: right;margin-top: 30px;"><?php _e( 'Akkoord', 'okthemes' ); ?></button>
				<button type="button" name="cancelBtn" id="cancelBtn" class="btn btn-default" style="float: right;margin-right: 5px;width: 100px;margin-top: 30px;"><?php _e( 'Annuleren', 'okthemes' ); ?></button>
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
				
				<h3><?php _e('Bedrijfsgegevens'); ?></h3>
				<div class="form-group col-md-2">
					<label class="" for="prod_selector_1" id="lprod1"><?php _e( 'Bedrijfsnaam', 'okthemes' ); ?></label>
				</div>
				<div class="form-group col-md-10">
					<input placeholder="" type="text" name="loggedCompany" id="loggedCompany" class="required form-control" style="line-height: 1.42857143;margin-bottom: 5px;width: 250px;" readonly />
				</div>
				
				<div class="form-group col-md-2">
					<label class="" for="prod_selector_1" id="lprod1"><?php _e( 'Contactpersoon', 'okthemes' ); ?></label>  
				</div>
				<div class="form-group col-md-10">
					<input placeholder="" type="text" name="loggedName" id="loggedName" class="required form-control" style="line-height: 1.42857143;margin-bottom: 5px;width: 250px;" readonly />
				</div>
				
				<div class="form-group col-md-2">
					<label class="" for="prod_selector_1" id="lprod1"><?php _e( 'P-nummer', 'okthemes' ); ?></label>
				</div>
				<div class="form-group col-md-10" style="margin-bottom: 0px;">
					<input placeholder="P" type="text" name="pnr1" id="pnr1" class="required form-control" style="line-height: 1.42857143;width: 250px;" />
				</div>
				<label style="margin-left: 15px;margin-bottom: 15px;" class="xlf">Heeft u meerdere P-nummers, dient u per P-nummer een aparte aanvraag in te dienen.</label>
				
				<form id="tariefRequest_form" enctype="text/plain" action="<?php the_permalink(); ?>" method="post">
					<div class="vehicleContainer" id="vehicleContainer" style="margin: 0 0 10px; clear: left;">
                    	<h3><?php _e('Voertuigen'); ?></h3>
						
						<div class="form-group col-md-2">
							<label class="" for="prod_selector_1" id="lprod1" style="margin-top: 10px;"><?php _e( 'Aantal voertuigen', 'okthemes' ); ?></label>  
						</div>
						<div class="form-group col-md-10">
							<input type="text" name="amountVehicle1" id="amountVehicle1" class="required form-control numericOnly" style="width: 150px;float:left;" />
						</div>
						
						<div class="form-group col-md-2"></div>
						<div class="licenseplateContainer form-group col-md-8" id="licenseplateContainer" style="display: none;">
							<input placeholder="<?php _e( 'Kenteken 1', 'okthemes' ); ?>" type="text" name="license1" id="license1" class="required form-control licenseplateBox" style="width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 2', 'okthemes' ); ?>" type="text" name="license2" id="license2" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 3', 'okthemes' ); ?>" type="text" name="license3" id="license3" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 4', 'okthemes' ); ?>" type="text" name="license4" id="license4" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 5', 'okthemes' ); ?>" type="text" name="license5" id="license5" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 6', 'okthemes' ); ?>" type="text" name="license6" id="license6" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 7', 'okthemes' ); ?>" type="text" name="license7" id="license7" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 8', 'okthemes' ); ?>" type="text" name="license8" id="license8" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 9', 'okthemes' ); ?>" type="text" name="license9" id="license9" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input placeholder="<?php _e( 'Kenteken 10', 'okthemes' ); ?>" type="text" name="license10" id="license10" class="required form-control licenseplateBox" style="margin-top: 5px;width: 150px;" />
							<input type="file" name="fileinput" id="xlf" class="required form-control xlf" style="display: none;width: 350px;float: left;" />
							<label id="amountLicenseplateFound" style="margin-left: 15px;margin-top: 8px;display: none;font-weight: bold;color: green;">24 kentekens gevonden</label>
							<label style="margin-left: 5px;margin-top: 5px;" class="xlf">Vanaf 10 voertuigen dient u uw kentekens aan te leveren in een Excel bestand.</label>
							<label style="margin-left: 5px;" class="xlf">Een voorbeeld van dit Excel bestand: <a href="no-script.html" id="exampleLink">voorbeeld.xlsx</a></label>
						</div>
					</div><br />
					
					<div class="tariffContainer" id="tariffContainer" style="margin: 50px 0 10px;clear: left;">
						<h3><?php _e('Tarieven'); ?></h3>
					</div>
					
					<div>
						<select class="form-control" id="tariff_selector_1" name="tariff1" style="float:left; display:inline; width: 34%;">
							<option value="">Selecteer tarief</option>
							<option value="taxi">Taxi tarief</option>
							<option value="bus">Bus tarief</option>
							<option value="vast">Vast tarief</option>
						</select>
						<button type="button" name="cabman_add_tarif" id="cabman_add_tarif" class="btn" style="float:left; display:inline; line-height: 1.42857143; margin-left: 5px;" ><?php _e( 'Tarief toevoegen', 'okthemes' ); ?></button>
					</div>
					
					
					</br>
					<div class="checkbox terms tariefChechbox col-md-12" style="margin-top: 50px;clear:left;">
                        <label>
                      		<input type="checkbox" id="termsofagreement" />
                          <?php _e('Ik ga akkoord met de <a href="/wp-content/uploads/2015/04/Nederland-ICT-Voorwaarden-2014-NEDERLANDS.pdf" target="_blank">Algemene voorwaarden.</a>'); ?>
                        </label>
					</div>
					<div class="col-md-12">
						<button type="button" name="cabman_send_tarief" id="cabman_send_tarief" class="btn btn-primary"><?php _e( 'Verzenden', 'okthemes' ); ?></button>
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