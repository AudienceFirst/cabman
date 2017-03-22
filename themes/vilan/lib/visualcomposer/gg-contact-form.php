<?php
class WPBakeryShortCode_gg_contact_form extends WPBakeryShortCode {

   public function __construct() {  
         add_shortcode('contact_form', array($this, 'gg_contact_form'));  
   }


   public function gg_contact_form( $atts, $content = null ) { 

         $output = $email_address = $success_message = $error_message = '';
         extract(shortcode_atts(array(
             'widget_title' => '',
             'email_address'    => '',
             'success_message'  => 'Your message was sent successfully.',
             'error_message'   => 'There was an error submitting the form.'
         ), $atts));

         wp_enqueue_script('jvalidate');

          $output = '';
          $randID = rand();
          //If the form is submitted
          if(isset($_POST['submitted'])) {
          
            //Check to see if the honeypot captcha field was filled in
            if(trim($_POST['checking']) !== '') {
              $captchaError = true;
            } else {
            
              //Check to make sure that the name field is not empty
              if(trim($_POST['contactName']) === '') {
                $nameError = __( 'You forgot to enter your name.', 'okthemes' );
                $hasError = true;
              } else {
                $name = trim($_POST['contactName']);
              }
              
              //Check to make sure sure that a valid email address is submitted
              if(trim($_POST['email']) === '')  {
                $emailError = __( 'You forgot to enter your email address.', 'okthemes' );
                $hasError = true;
              } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
                $emailError = __( 'You entered an invalid email address.', 'okthemes' );
                $hasError = true;
              } else {
                $email = trim($_POST['email']);
              }
                
              //Check to make sure comments were entered  
              if(trim($_POST['comments']) === '') {
                $commentError = __( 'You forgot to enter your comments.', 'okthemes' );
                $hasError = true;
              } else {
                if(function_exists('stripslashes')) {
                  $comments = stripslashes(trim($_POST['comments']));
                } else {
                  $comments = trim($_POST['comments']);
                }
              }
                
              //If there is no error, send the email
              if(!isset($hasError)) {
                $emailTo = $email_address;
                if (!isset($emailTo) || ($emailTo == '') ){
                  $emailTo = get_option('admin_email');
                }
                $subject = 'From '.$name;
                $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
                $headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
                
                wp_mail($emailTo, $subject, $body, $headers);
                $emailSent = true;
          
              }
            }
          }

          $output .= '<script type="text/javascript">
          var $j = jQuery.noConflict();
          $j(document).ready(function(){
            $j("#contactFormMini-'.$randID.'").validate();
          });
          </script>';

          $output .= "\n\t".wpb_widget_title(array('title' => $widget_title, 'extraclass' => 'wpb_contactform_heading'));
          
          $output .= "\n\t".'<div id="scroll-cfm"></div>';

          if(isset($emailSent) && $emailSent == true) {
            $form_finished = 'form-finished';
                  $output .= '<div class="thanks">';
                      $output .= '<h3>'. __( 'Thank you,', 'okthemes' ) .' '.$name.' !</h3>';
                      $output .= '<p>'.$success_message.'</p>';
                  $output .= '</div>';
              } else {
            $form_finished = '';
          }
                  
              if(isset($hasError) || isset($captchaError)) {
                  $output .= '<p class="error">'.$error_message.'</p>';
              }
          
          if(isset($_POST['contactName'])) $contact_name_ech = $_POST['contactName'];
            else $contact_name_ech = ''; 
          if(isset($_POST['email']))  $contact_email_ech = $_POST['email'];
            else $contact_email_ech = '';
          if(isset($_POST['comments'])) { 
            if(function_exists('stripslashes')) { 
              $contact_comments_ech = stripslashes($_POST['comments']); 
            } else { 
              $contact_comments_ech = $_POST['comments']; 
            }
          } else {
            $contact_comments_ech = '';
          }
          if(isset($_POST['checking'])){
            $contact_checking_ech = $_POST['checking'];  
          } else {
            $contact_checking_ech = '';
          }

          $output .= "\n\t".'<form action="'.get_permalink().'#scroll-cfm" id="contactFormMini-'.$randID.'" method="post">';
          $output .= "\n\t\t".'<ul class="contact-form '.$form_finished.' mini">';
          $output .= "\n\t\t\t".'<li class="form-group">';
          $output .= "\n\t\t\t\t".'<label class="sr-only" for="contactName">'. __( 'Name', 'okthemes' ) .'</label>';
          $output .= "\n\t\t\t\t".'<input data-msg-required="'. __( 'Please enter your name', 'okthemes' ) .'" placeholder="'. __( 'Name', 'okthemes' ) .'" type="text" name="contactName" id="contactName" value="'.$contact_name_ech.'" class="required" />';
          $output .= "\n\t\t\t".'</li>';    
          $output .= "\n\t\t\t".'<li class="form-group">';   
          $output .= "\n\t\t\t\t".'<label class="sr-only" for="email">'. __( 'Email', 'okthemes' ) .'</label>';
          $output .= "\n\t\t\t\t".'<input data-msg-required="'. __( 'Please enter your email address', 'okthemes' ) .'" data-msg-email="Please enter a valid email address" placeholder="'. __( 'Email', 'okthemes' ) .'" type="text" name="email" id="email" value="'.$contact_email_ech.'" class="required email" />';
          $output .= "\n\t\t\t".'</li>';
          $output .= "\n\t\t\t"."\n\t\t\t".'<li class="form-group">';
          $output .= "\n\t\t\t\t".'<label class="sr-only" for="commentsText">'. __( 'Comments', 'okthemes' ) .'</label>';
          $output .= "\n\t\t\t\t".'<textarea data-msg-required="'. __( 'Please enter your comment', 'okthemes' ) .'" rows="3" placeholder="'. __( 'Comments', 'okthemes' ) .'" name="comments" id="commentsText" class="required">'.$contact_comments_ech.'</textarea>';
          $output .= "\n\t\t\t".'</li>';
          $output .= "\n\t\t\t".'<li class="hidden">';
          $output .= "\n\t\t\t\t".'<label for="checking" class="hidden">If you want to submit this form, do not enter anything in this field</label>';
          $output .= "\n\t\t\t\t".'<input type="text" name="checking" id="checking" class="hidden" value="'.$contact_comments_ech.'" />';
          $output .= "\n\t\t\t".'</li>';
          $output .= "\n\t\t\t".'<li class="buttons">';
          $output .= "\n\t\t\t\t".'<input class="hidden" type="hidden" name="submitted" id="submitted" value="true" />';
          $output .= "\n\t\t\t\t".'<button class="btn btn-primary" type="submit">'. __( 'Send email', 'okthemes' ) .'</button>';
          $output .= "\n\t\t\t".'</li>';
          $output .= "\n\t\t".'</ul>';
          $output .= "\n\t".'</form>';

         return $output;
         
   }
}

$WPBakeryShortCode_gg_contact_form = new WPBakeryShortCode_gg_contact_form();  

vc_map( array(
   "name" => __("Contact form","okthemes"),
   "description" => __('Display a mini contact form.', 'okthemes'),
   "base" => "contact_form",
   "class" => "theme_icon_class",
   "icon" => "icon-wpb-gg_vc_contact_form",
   'admin_enqueue_css' => array(get_template_directory_uri().'/lib/visualcomposer/styles.css'),
   "category" => __('OKThemes','okthemes'),
   "params" => array(
      array(
         "type" => "textfield",
         "heading" => __("Widget title","okthemes"),
         "param_name" => "widget_title",
         "value" => '',
         "admin_label" => true,
         "description" => __("Insert widget title here","okthemes")
      ),
      array(
         "type" => "textfield",
         "heading" => __("Email","okthemes"),
         "param_name" => "email_address",
         "admin_label" => true,
         "description" => __("Insert the contact form email here.","okthemes")
      ),
      array(
          "type" => "textfield",
          "heading" => __('Success message', 'okthemes'),
          "param_name" => "success_message",
          "value" => 'Your message was sent successfully.',
          "description" => __("Insert the success message.", "okthemes")
      ),
      array(
          "type" => "textfield",
          "heading" => __('Error message', 'okthemes'),
          "param_name" => "error_message",
          "value" => 'There was an error submitting the form.',
          "description" => __("Insert the error message.", "okthemes")
      ),

      $add_css_animation,

   )
) );

?>