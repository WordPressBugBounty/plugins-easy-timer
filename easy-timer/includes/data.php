<?php if (!defined('ABSPATH')) { exit(); }
global $easy_timer_options;
if ((empty($easy_timer_options)) || (!is_array($easy_timer_options)) || (!isset($easy_timer_options['version']))) {
$easy_timer_options = (array) get_option('easy_timer');
$GLOBALS['easy_timer_options'] = $easy_timer_options; }
if (is_string($atts)) { $field = $atts; $default = ''; $filter = ''; $formatting = 'yes'; }
else {
$atts = array_map('kleor_do_shortcode_in_attribute', (array) $atts);
$field = (isset($atts[0]) ? $atts[0] : '');
foreach (array('default', 'filter') as $key) { $$key = (isset($atts[$key]) ? $atts[$key] : ''); }
$formatting = (((isset($atts['formatting'])) && ($atts['formatting'] == 'no')) ? 'no' : 'yes'); }
$field = str_replace('-', '_', easy_timer_format_nice_name($field));
$data = (isset($easy_timer_options[$field]) ? $easy_timer_options[$field] : '');
$data = (string) ($formatting == 'yes' ? kleor_do_shortcode($data) : $data);
if ($data === '') { $data = $default; }
$data = easy_timer_filter_data($filter, $data);