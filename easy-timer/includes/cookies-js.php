<?php if (!defined('ABSPATH')) { exit(); }
global $easy_timer_cookies;
$T = time();
$U = $T + 86400*easy_timer_data('cookies_lifetime');
$expiration_date = date('D', $U).', '.date('d', $U).' '.date('M', $U).' '.date('Y', $U).' '.date('H:i:s', $U).' UTC';
if (!empty($easy_timer_cookies)) { echo '<script>'."\n"; }
foreach ($easy_timer_cookies as $id) { echo 'document.cookie="first-visit-'.$id.'='.$T.'; expires='.$expiration_date.'";'."\n"; }
if (!empty($easy_timer_cookies)) { echo '</script>'."\n"; }