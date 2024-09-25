<?php if (!defined('ABSPATH')) { exit(); }
$atts = array_map('kleor_do_shortcode_in_attribute', (array) $atts);
extract(shortcode_atts(array('filter' => '', 'offset' => ''), $atts));
$T = easy_timer_extract_timestamp($offset);
$isoyear = easy_timer_filter_data($filter, date('o', $T));
if (strtolower($offset) == 'local') {
if (easy_timer_data('javascript_enabled') == 'yes') { add_action('wp_footer', 'easy_timer_js'); }
$isoyear = '<span class="localisoyear">'.$isoyear.'</span>'; }