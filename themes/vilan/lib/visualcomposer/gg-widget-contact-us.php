<?php
class WPBakeryShortCode_gg_Widget_Contact_Us extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('widget_contact_us', array($this, 'gg_widget_contact_us'));  
   }

   public function gg_widget_contact_us( $atts, $content = null ) { 

         $output = $title = $company = $address = $phone = $fax = $email = '';
         extract(shortcode_atts(array(
             'title'        => '',
             'address'  => '',
             'phone'  => '',
             'fax'     => '',
             'email' => '',
             'extra_class' => ''
         ), $atts));

         
         $output = '<div class="vc_widget vc_widget_contact_us '.$extra_class.'">';
         $type = 'gg_Contact_Widget';
         $args = array();

         ob_start();
         the_widget( $type, $atts, $args );
         $output .= ob_get_clean();

         $output .= '</div>';

         return $output;
   }
}

$WPBakeryShortCode_gg_Widget_Contact_Us = new WPBakeryShortCode_gg_Widget_Contact_Us();


vc_map( array(
   "name" => __("Widget: Contact us", "okthemes"),
   "description" => __('Display address, phone, fax, email', 'okthemes'),
   "base" => "widget_contact_us",
   "class" => "theme_icon_class",
   "weight" => -50,
   "icon" => "icon-wpb-gg_vc_contact_us",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes', 'okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Title", "okthemes"),
         "param_name" => "title",
         "description" => __("Insert title here", "okthemes")
      ),
      array(
         "type" => "textarea",
         "heading" => __("Address", "okthemes"),
         "param_name" => "address",
         "admin_label" => true,
         "description" => __("Insert address here", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Phone", "okthemes"),
         "param_name" => "phone",
         "description" => __("Insert phone here", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Fax", "okthemes"),
         "param_name" => "fax",
         "description" => __("Insert fax here", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Email", "okthemes"),
         "param_name" => "email",
         "description" => __("Insert email here", "okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Extra class", "okthemes"),
         "param_name" => "extra_class",
         "description" => __("Insert an extra class to style the widget differently. This widget has already a class styled for dark background: contact_widget_dark ", "okthemes")
      ),

   )
) );

?>