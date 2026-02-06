<?php if (!defined('ABSPATH')) { exit(); }
$filters = array('easy_timer_i18n', 'htmlspecialchars', 'md5', 'ucfirst');
if (defined('KLEOR_FILTERS')) { $filters = array_merge($filters, preg_split('#[^a-zA-Z0-9_]#', KLEOR_FILTERS, 0, PREG_SPLIT_NO_EMPTY)); }
if (is_string($filter)) { $filter = preg_split('#[^a-zA-Z0-9_]#', str_replace('-', '_', kleor_do_shortcode_in_attribute($filter)), 0, PREG_SPLIT_NO_EMPTY); }
if (is_array($filter)) { foreach ($filter as $function) {
if (!function_exists($function)) { $function = 'easy_timer_'.$function; }
if ((function_exists($function)) && (in_array($function, $filters))) { $data = @$function($data); } } }