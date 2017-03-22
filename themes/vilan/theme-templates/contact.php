<?php
/**
 * Template Name: Contact Page
 * Description: Page template with a content container and right sidebar.
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

$contact_form_headline = rwmb_meta( 'gg_contact_form_headline' );
$contact_page_email = rwmb_meta( 'gg_contact_page_email' );
$contact_page_success = rwmb_meta( 'gg_contact_page_success_msg' );
$contact_page_error = rwmb_meta( 'gg_contact_page_error_msg' );

$contact_map = rwmb_meta( 'gg_contact_map' );
$contact_map_latitude = rwmb_meta( 'gg_contact_map_latitude' );
$contact_map_longitude = rwmb_meta( 'gg_contact_map_longitude' );
$contact_zoom = rwmb_meta( 'gg_contact_zoom' );
$contact_map_infowindow = rwmb_meta( 'gg_contact_map_infowindow' );
$contact_map_infowindow_title = rwmb_meta( 'gg_contact_map_infowindow_title' );

if ($contact_map) {
    wp_enqueue_script('gmaps');
    wp_enqueue_script('google-map');
}

wp_enqueue_script('jvalidate');

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

//Contact form
$commentError ='';
$emailError ='';
$nameError ='';
$subjectError ='';

//If the form is submitted
if(isset($_POST['submitted'])) {

    $name           = sanitize_text_field($_POST['contactName']);
    $subject        = sanitize_text_field($_POST['subjectName']);
    $email          = sanitize_email($_POST['email']);
    $comments       = esc_textarea($_POST['comments']);

     
    //Check to make sure that the name field is not empty
    if($name == '') {
        $nameError = 'You forgot to enter your name.';
        $hasError = true;
    }

    //Check to make sure that the name field is not empty
    if($subject == '') {
        $subjectError = 'You forgot to enter your subject.';
        $hasError = true;
    } 
    
    //Check to make sure sure that a valid email address is submitted
    if($email == '')  {
        $emailError = 'You forgot to enter your email address.';
        $hasError = true;
    } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", $email)) {
        $emailError = 'You entered an invalid email address.';
        $hasError = true;
    }
        
    //Check to make sure comments were entered  
    if($comments== '') {
        $commentError = 'You forgot to enter your comments.';
        $hasError = true;
    } 
        
    //If there is no error, send the email
    if(!isset($hasError)) {
        $emailTo = $contact_page_email;
        if (!isset($emailTo) || ($emailTo == '') ){
            $emailTo = get_option('admin_email');
        }
        $subject_send = $subject;
        $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
        $headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
        
        wp_mail($emailTo, $subject_send, $body, $headers);
        $emailSent = true;
    }
}

?>

<?php if ($contact_map) { ?>
<script type="text/javascript">
  var image = '<?php echo esc_js(get_template_directory_uri()); ?>/images/map-marker.png';
  var $j = jQuery.noConflict();
  
  $j(document).ready(function(){

      $j("#map").gMap({
        controls: {
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            overviewMapControl: true
        },
        scrollwheel: false,
        maptype: 'ROADMAP',
        useCustomStyle: true,
        styleList: [
            {
                "stylers": [
                  { "saturation": -1 },
                  { "hue": "#d9e2e9" }
                ]
            },
        ],
        markers: [
            {
                latitude: <?php echo esc_js($contact_map_latitude); ?>,
                longitude: <?php echo esc_js($contact_map_longitude); ?>,
                <?php $contact_map_infowindow = str_replace(array("\r\n", "\r", "\n"), "", $contact_map_infowindow); ?>
                html: "<?php echo html_entity_decode($contact_map_infowindow); ?>",
                popup: true
            }
            
        ],
        icon: {
            image: image, 
            iconsize: [26, 46],
            iconanchor: [12, 46]
        },
        latitude: <?php echo esc_js($contact_map_latitude); ?>,
        longitude: <?php echo esc_js($contact_map_longitude); ?>,
        zoom: <?php echo esc_js($contact_zoom); ?>
    });

  });
</script>
<?php } ?>

<?php vilan_page_header(); ?>

<section id="content" class="<?php echo esc_attr($class_html); ?>">
    <?php if ($page_layout != 'fullscreen') echo '<div class="container"><div class="row">'; ?>

        <div class="<?php echo esc_attr($page_content_class); ?>">
            
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'parts/part', 'page' ); ?>
                <?php comments_template( '', true ); ?>
            <?php endwhile; ?>

            <div class="clearfix"></div>

            <div class="contact-form-wrapper">
            <?php if(isset($emailSent) && $emailSent == true) { ?>
                <div class="thanks">
                    <p><?php echo esc_html($contact_page_success); ?></p>
                </div>
            <?php } ?>
                
            <?php if(isset($hasError)) { ?>
                <p class="error"><?php echo esc_html($contact_page_error); ?></p>
            <?php } ?>

            <h3><?php _e('Send us a message!'); ?></h3>

            <form action="<?php the_permalink(); ?>" class="row <?php if(isset($emailSent) && $emailSent == true) { ?> form-finished <?php } ?>" id="contactForm" method="post">
                <div class="form-group col-md-6">
                    <label class="sr-only" for="contactName">
                        <?php _e( 'Name (required)', 'okthemes' ); ?>
                    </label>
                    <input placeholder="<?php _e( 'Name (required)', 'okthemes' ); ?>" type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo esc_attr($_POST['contactName']);?>" class="required form-control" />
                </div>    
                <div class="form-group col-md-6">    
                    <label class="sr-only" for="email"><?php _e( 'Email (required)', 'okthemes' ); ?></label>
                    <input placeholder="<?php _e( 'Email (required)', 'okthemes' ); ?>" type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo esc_attr($_POST['email']);?>" class="required email form-control" />
                </div>
                <div class="form-group col-md-12">
                    <label class="sr-only" for="subjectName"><?php _e( 'Subject (required)', 'okthemes' ); ?></label>
                    <input placeholder="<?php _e( 'Subject (required)', 'okthemes' ); ?>" type="text" name="subjectName" id="subjectName" value="<?php if(isset($_POST['subjectName'])) echo esc_attr($_POST['subjectName']);?>" class="required form-control" />
                </div>
                <div class="form-group col-md-12">    
                    <label class="sr-only" for="commentsText"><?php _e( 'Comments (required)', 'okthemes' ); ?></label>
                    <textarea name="comments" id="commentsText" rows="3" placeholder="<?php _e( 'Comments (required)', 'okthemes' ); ?>" class="required form-control"><?php if(isset($_POST['comments'])) echo esc_attr($_POST['comments']); ?></textarea>
                </div>

                    <label for="checking" class="hidden"><?php _e( 'Empty field', 'okthemes' ); ?></label>
                    <input type="text" name="checking" id="checking" class="hidden" value="<?php if(isset($_POST['checking']))  echo esc_attr($_POST['checking']);?>" />
                    
                    <input type="hidden" name="submitted" id="submitted" value="true" />
                    <button type="submit" class="btn btn-primary"><?php _e( 'Send email', 'okthemes' ); ?></button>
            </form>

            </div><!--Close .contact-form-wrapper -->

            <script type="text/javascript">
            var $j = jQuery.noConflict();
            $j(document).ready(function(){
                $j("#contactForm").validate();
            });
            </script>

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

<!-- Begin - Map -->
<?php if ($contact_map) { ?>
<div class="contact-map">
    <div id="map"></div>
</div>
<?php } ?>
<!-- End - Map -->

<?php gg_page_footer_message_box(); ?>
<?php get_footer(); ?>