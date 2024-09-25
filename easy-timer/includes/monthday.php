<?php if (!defined('ABSPATH')) { exit(); }
$atts = array_map('kleor_do_shortcode_in_attribute', (array) $atts);
extract(shortcode_atts(array('filter' => '', 'format' => '', 'offset' => ''), $atts));
if ($format == '') { $format = (isset($atts['form']) ? $atts['form'] : ''); }
$T = easy_timer_extract_timestamp($offset);

switch ($format) {
case '2': $monthday = date('d', $T); break;
default: $format = '1'; $monthday = date('j', $T); }
$monthday = easy_timer_filter_data($filter, $monthday);

if (strtolower($offset) == 'local') {
if (easy_timer_data('javascript_enabled') == 'yes') { add_action('wp_footer', 'easy_timer_js'); }
$monthday = '<span class="local'.$format.'monthday">'.$monthday.'</span>'; }