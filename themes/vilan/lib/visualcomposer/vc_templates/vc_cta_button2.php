<?php
extract(shortcode_atts(array(
    'h2' => '',
    'position' => '',
    'el_width' => '',
    'style' => '',
    'txt_align' => '',
    'accent_color' => '',
    'customcolor' =>'',
    'link' => '',
    'title' => __('Text on the button', "js_composer"),
    'color' => '',
    'text_color' => '',
    'icon' => '',
    'icon_align' => '',
    'add_icon' => '',
    'size' => '',
    'btn_style' => '',
    'el_class' => '',
    'text_accent_color' => '',
    'block_background_color' => '',
    'css_animation' => ''
), $atts));

$class = "vc_call_to_action wpb_content_element";

$link = ($link=='||') ? '' : $link;

$class .= ($position!='') ? ' vc_cta_btn_pos_'.$position : '';
$class .= ($el_width!='') ? ' vc_el_width_'.$el_width : '';
$class .= ($color!='') ? ' vc_cta_'.$color : '';
$class .= ($style!='') ? ' vc_cta_'.$style : '';
$class .= ($txt_align!='') ? ' vc_txt_align_'.$txt_align : '';

$inline_css = ($accent_color!='') ? ' style="background-color: '.$accent_color.'; border-color: '.$accent_color.'; color: '.$text_accent_color.'; opacity:1;"' : '';
$inline_h_css = ($text_accent_color!='') ? ' style=" color: '.$text_accent_color.'; opacity: 1;"' : ''; 


$class .= $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base']);
$css_class .= $this->getCSSAnimation($css_animation);
?>
<div<?php echo $inline_css; ?> class="<?php echo esc_attr(trim($css_class)); ?>">
    <?php if ($link!='' && $position!='bottom') echo do_shortcode('[vc_button2 add_icon="'.$add_icon.'" icon="'.$icon.'" icon_align="'.$icon_align.'" link="'.$link.'" title="'.$title.'" color="'.$color.'" text_color="'.$text_color.'" icon="'.$icon.'" size="'.$size.'" style="'.$btn_style.'" el_class="vc_cta_btn"]'); ?>
<?php if ($h2!=''): ?>
    <?php if ($h2!=''): ?><h2 <?php echo $inline_h_css; ?> class="wpb_heading"><?php echo $h2; ?></h2><?php endif; ?>
<?php endif; ?>
    <p <?php echo $inline_h_css; ?>><?php echo $content; ?></p>
    <?php if ($link!='' && $position=='bottom') echo do_shortcode('[vc_button2 add_icon="'.$add_icon.'" icon="'.$icon.'" icon_align="'.$icon_align.'" link="'.$link.'" title="'.$title.'" color="'.$color.'" text_color="'.$text_color.'" icon="'.$icon.'" size="'.$size.'" style="'.$btn_style.'" el_class="vc_cta_btn"]'); ?>
</div>
<?php $this->endBlockComment('.vc_call_to_action') . "\n";