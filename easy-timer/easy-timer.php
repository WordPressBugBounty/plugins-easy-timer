<?php
/*
Plugin Name: Easy Timer
Plugin URI: https://www.kleor.com/easy-timer/
Description: Allows you to easily display a count down/up timer, the time or the current date on your website, and to schedule an automatic content modification.
Version: 4.2.1
Author: Kleor
Author URI: https://www.kleor.com
Text Domain: easy-timer
Domain Path: /languages
License: GPL2
*/

/* 
Copyright 2010 Kleor (https://www.kleor.com)

This program is a free software. You can redistribute it and/or 
modify it under the terms of the GNU General Public License as 
published by the Free Software Foundation, either version 2 of 
the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, 
but without any warranty, without even the implied warranty of 
merchantability or fitness for a particular purpose. See the 
GNU General Public License for more details.
*/


if (!defined('ABSPATH')) { exit(); }
define('EASY_TIMER_PATH', plugin_dir_path(__FILE__));
define('EASY_TIMER_URL', plugin_dir_url(__FILE__));
define('EASY_TIMER_FOLDER', substr(plugin_basename(__FILE__), 0, -strlen('/easy-timer.php')));
if (!defined('EASY_TIMER_CUSTOM_FILES_PATH')) { define('EASY_TIMER_CUSTOM_FILES_PATH', substr(EASY_TIMER_PATH, 0, -(strlen(EASY_TIMER_FOLDER) + 1)).'easy-timer-custom-files/'); }
define('EASY_TIMER_CUSTOM_FILES_URL', site_url().'/'.substr(EASY_TIMER_CUSTOM_FILES_PATH, strlen(ABSPATH)));
$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'));
define('EASY_TIMER_VERSION', $plugin_data['Version']);

function easy_timer_path($file) { return (file_exists(EASY_TIMER_CUSTOM_FILES_PATH.$file) ? EASY_TIMER_CUSTOM_FILES_PATH : EASY_TIMER_PATH).$file; }

function easy_timer_url($file) { return (file_exists(EASY_TIMER_CUSTOM_FILES_PATH.$file) ? EASY_TIMER_CUSTOM_FILES_URL : EASY_TIMER_URL).$file; }

if (!function_exists('kleor_do_shortcode')) { include_once easy_timer_path('libraries/shortcodes-functions.php'); }
if (is_admin()) { include_once easy_timer_path('admin.php'); }

function install_easy_timer() { include easy_timer_path('includes/install.php'); }

register_activation_hook(__FILE__, 'install_easy_timer');

$easy_timer_options = (array) get_option('easy_timer');
if ((!isset($easy_timer_options['version'])) || ($easy_timer_options['version'] != EASY_TIMER_VERSION)) { install_easy_timer(); }

$easy_timer_cookies = array();


function easy_timer_cookies_js() { include easy_timer_path('includes/cookies-js.php'); }

if (easy_timer_data('javascript_enabled') == 'yes') { add_action('wp_footer', 'easy_timer_cookies_js'); }


function easy_timer_data($atts) { include easy_timer_path('includes/data.php'); return $data; }


function easy_timer_filter_data($filter, $data) { include easy_timer_path('includes/filter-data.php'); return $data; }


function easy_timer_format_nice_name($string) {
$string = strtolower(easy_timer_strip_accents(trim(strip_tags($string))));
$string = str_replace(' ', '-', $string);
$string = preg_replace('/[^a-z0-9_-]/', '', $string);
return $string; }


function easy_timer_i18n($string) { load_easy_timer_textdomain(); return __(__($string), 'easy-timer'); }


function easy_timer_strip_accents($string) {
return str_replace(
explode(' ', 'á à â ä ã å ç é è ê ë í ì î ï ñ ó ò ô ö õ ø ú ù û ü ý ÿ Á À Â Ä Ã Å Ç É È Ê Ë Í Ì Î Ï Ñ Ó Ò Ô Ö Õ Ø Ú Ù Û Ü Ý Ÿ'),
explode(' ', 'a a a a a a c e e e e i i i i n o o o o o o u u u u y y A A A A A A C E E E E I I I I N O O O O O O U U U U Y Y'),
$string); }


function load_easy_timer_textdomain($domain = '') {
$domain = 'easy-timer'.($domain == '' ? '' : '-'.$domain);
$file = $domain.'-'.apply_filters('plugin_locale', get_locale(), $domain).'.mo';
if (load_textdomain($domain, easy_timer_path('languages/'.$file))) { return true; }
else { return load_textdomain($domain, WP_LANG_DIR.'/plugins/'.$file); } }


$tags = array();
foreach (array('counter', 'countdown', 'countup') as $tag) {
$function = function($atts, $content) use($tag) { include_once easy_timer_path("shortcodes.php"); $function2 = 'easy_timer_'.$tag; return @$function2($atts, $content); };
for ($i = 0; $i < 4; $i++) { $tags[] = $tag.($i == 0 ? '' : $i); add_shortcode($tag.($i == 0 ? '' : $i), $function); } }
foreach (array('clock', 'isoyear', 'monthday', 'month', 'timezone', 'weekday', 'yearday', 'yearweek', 'year') as $tag) {
$tags[] = $tag; add_shortcode($tag, function($atts) use($tag) { include_once easy_timer_path("shortcodes.php"); $function2 = 'easy_timer_'.$tag; return @$function2($atts); }); }
$tags[] = 'easy-timer'; add_shortcode('easy-timer', 'easy_timer_data');
$easy_timer_shortcodes = $tags;


function replace_easy_timer_shortcodes($data) { include easy_timer_path('includes/replace-shortcodes.php'); return $data; }

add_filter('wp_insert_post_data', 'replace_easy_timer_shortcodes', 10, 1);


foreach (array(
'get_the_excerpt',
'get_the_title',
'single_post_title',
'the_excerpt',
'the_excerpt_rss',
'the_title',
'the_title_attribute',
'the_title_rss',
'widget_text',
'widget_title') as $function) { add_filter($function, 'do_shortcode'); }