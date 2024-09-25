<?php if (!defined('ABSPATH')) { exit(); }
$timer = easy_timer_timer_string($S);

$strings = array(
'YMWD',
'YMW',
'YMD',
'YM',
'YWD',
'YW',
'YD',
'Y',
'MWD',
'MW',
'MD',
'M',
'WD',
'W',
'D');
if ($S < 604800) { foreach ($strings as $string) { $content = str_replace('['.$prefix.$string.'timer]', '['.$prefix.'dtimer]', $content); } }

$content = str_replace('['.$prefix.'timer]', '['.$prefix.easy_timer_data('default_timer_prefix').'timer]', $content);
$content = str_replace('['.$prefix.'clocktimer]', '<span class="clockcount'.$way.'" data-time="'.$S.'">'.$timer['clock'].'</span>', $content);
$content = str_replace('['.$prefix.'dhmstimer]', '<span class="dhmscount'.$way.'" data-time="'.$S.'">'.$timer['Dhms'].'</span>', $content);
$content = str_replace('['.$prefix.'dhmtimer]', '<span class="dhmcount'.$way.'" data-time="'.$S.'">'.$timer['Dhm'].'</span>', $content);
$content = str_replace('['.$prefix.'dhtimer]', '<span class="dhcount'.$way.'" data-time="'.$S.'">'.$timer['Dh'].'</span>', $content);
$content = str_replace('['.$prefix.'dtimer]', '<span class="dcount'.$way.'" data-time="'.$S.'">'.$timer['D'].'</span>', $content);
$content = str_replace('['.$prefix.'hmstimer]', '<span class="hmscount'.$way.'" data-time="'.$S.'">'.$timer['Hms'].'</span>', $content);
$content = str_replace('['.$prefix.'hmtimer]', '<span class="hmcount'.$way.'" data-time="'.$S.'">'.$timer['Hm'].'</span>', $content);
$content = str_replace('['.$prefix.'htimer]', '<span class="hcount'.$way.'" data-time="'.$S.'">'.$timer['H'].'</span>', $content);
$content = str_replace('['.$prefix.'mstimer]', '<span class="mscount'.$way.'" data-time="'.$S.'">'.$timer['Ms'].'</span>', $content);
$content = str_replace('['.$prefix.'mtimer]', '<span class="mcount'.$way.'" data-time="'.$S.'">'.$timer['M'].'</span>', $content);
$content = str_replace('['.$prefix.'stimer]', '<span class="scount'.$way.'" data-time="'.$S.'">'.$timer['S'].'</span>', $content);

$content = str_replace('['.$prefix.'rtimer]', '['.$prefix.easy_timer_data('default_timer_prefix').'rtimer]', $content);
$content = str_replace('['.$prefix.'clockrtimer]', '<span class="clockcount'.$way.'" data-time="'.$S.'">'.$timer['clock'].'</span>', $content);
$content = str_replace('['.$prefix.'dhmsrtimer]', '<span class="dhmscount'.$way.'" data-time="'.$S.'">'.$timer['Dhms'].'</span>', $content);
$content = str_replace('['.$prefix.'dhmrtimer]', '<span class="dhmcount'.$way.'" data-time="'.$S.'">'.$timer['Dhm'].'</span>', $content);
$content = str_replace('['.$prefix.'dhrtimer]', '<span class="dhcount'.$way.'" data-time="'.$S.'">'.$timer['Dh'].'</span>', $content);
$content = str_replace('['.$prefix.'drtimer]', '<span class="dcount'.$way.'" data-time="'.$S.'">'.$timer['D'].'</span>', $content);
$content = str_replace('['.$prefix.'hmsrtimer]', '<span class="hmsrcount'.$way.'" data-time="'.$S.'">'.$timer['hms'].'</span>', $content);
$content = str_replace('['.$prefix.'hmrtimer]', '<span class="hmrcount'.$way.'" data-time="'.$S.'">'.$timer['hm'].'</span>', $content);
$content = str_replace('['.$prefix.'hrtimer]', '<span class="hrcount'.$way.'" data-time="'.$S.'">'.$timer['h'].'</span>', $content);
$content = str_replace('['.$prefix.'msrtimer]', '<span class="msrcount'.$way.'" data-time="'.$S.'">'.$timer['ms'].'</span>', $content);
$content = str_replace('['.$prefix.'mrtimer]', '<span class="mrcount'.$way.'" data-time="'.$S.'">'.$timer['m'].'</span>', $content);
$content = str_replace('['.$prefix.'srtimer]', '<span class="srcount'.$way.'" data-time="'.$S.'">'.$timer['s'].'</span>', $content);

if ($S >= 604800) {
$string0year = '';
$string0month = '';
$string0week = '';
$string0day = '';
$string1year = ' '.__('1 year', 'easy-timer');
$string1month = ' '.__('1 month', 'easy-timer');
$string1week = ' '.__('1 week', 'easy-timer');
$string1day = ' '.__('1 day', 'easy-timer');
$stringNyears = ' [N] '.__('years', 'easy-timer');
$stringNmonths = ' [N] '.__('months', 'easy-timer');
$stringNweeks = ' [N] '.__('weeks', 'easy-timer');
$stringNdays = ' [N] '.__('days', 'easy-timer');

$dates = $Y = $M = $D = array();
$offset = easy_timer_extract_offset($offset);
if ($way == 'down') { $dates[1] = date('Y-m-d', time() + $offset); $dates[4] = date('Y-m-d', time() + $offset + $S); }
else { $dates[1] = date('Y-m-d', time() + $offset - $S); $dates[4] = date('Y-m-d', time() + $offset); }
foreach (array(1, 4) as $i) {
$d = preg_split('#[^0-9]#', $dates[$i], 0, PREG_SPLIT_NO_EMPTY);
$Y[$i] = (int) $d[0]; $M[$i] = (int) $d[1]; $D[$i] = (int) $d[2]; }
$Y[2] = $Y[4] - ((($M[1] > $M[4]) || (($M[1] == $M[4]) && ($D[1] > $D[4]))) ? 1 : 0);
$M[2] = $M[1];
$D[2] = $D[1];
$Y[3] = $Y[4];
$M[3] = $M[4];
$D[3] = $D[1];
if ($D[3] > $D[4]) { $M[3] = $M[3] - 1; }
if ($M[3] == 0) { $M[3] = 12; $Y[3] = $Y[3] - 1; }

$y = $Y[2] - $Y[1];
$m1 = 12*($Y[4] - $Y[1]) + $M[3] - $M[1];
$m2 = $M[3] - $M[2];
if ($m2 < 0) { $m2 = $m2 + 12; }
for ($i = 1; $i <= 4; $i++) { $times[$i] = adodb_mktime(0, 0, 0, $M[$i], $D[$i], $Y[$i]); }
$d1 = floor(($times[4] - $times[1])/86400);
$w1 = floor($d1/7); $dw1 = $d1 - 7*$w1;
$d2 = floor(($times[4] - $times[2])/86400);
$w2 = floor($d2/7); $dw2 = $d2 - 7*$w2;
$d3 = floor(($times[4] - $times[3])/86400);
$w3 = floor($d3/7); $dw3 = $d3 - 7*$w3;

$timer['Y'] = ($y == 0 ? $string0year : ($y == 1 ? $string1year : str_replace('[N]', $y, $stringNyears)));
$timer['YM'] = $timer['Y'].($m2 == 0 ? $string0month : ($m2 == 1 ? $string1month : str_replace('[N]', $m2, $stringNmonths)));
$timer['YW'] = $timer['Y'].($w2 == 0 ? $string0week : ($w2 == 1 ? $string1week : str_replace('[N]', $w2, $stringNweeks)));
$timer['YD'] = $timer['Y'].($d2 == 0 ? $string0day : ($d2 == 1 ? $string1day : str_replace('[N]', $d2, $stringNdays)));
$timer['YMW'] = $timer['YM'].($w3 == 0 ? $string0week : ($w3 == 1 ? $string1week : str_replace('[N]', $w3, $stringNweeks)));
$timer['YMD'] = $timer['YM'].($d3 == 0 ? $string0day : ($d3 == 1 ? $string1day : str_replace('[N]', $d3, $stringNdays)));
$timer['YWD'] = $timer['YW'].($dw2 == 0 ? $string0day : ($dw2 == 1 ? $string1day : str_replace('[N]', $dw2, $stringNdays)));
$timer['YMWD'] = $timer['YMW'].($dw3 == 0 ? $string0day : ($dw3 == 1 ? $string1day : str_replace('[N]', $dw3, $stringNdays)));
$timer['M'] = ($m1 == 0 ? $string0month : ($m1 == 1 ? $string1month : str_replace('[N]', $m1, $stringNmonths)));
$timer['MW'] = $timer['M'].($w3 == 0 ? $string0week : ($w3 == 1 ? $string1week : str_replace('[N]', $w3, $stringNweeks)));
$timer['MD'] = $timer['M'].($d3 == 0 ? $string0day : ($d3 == 1 ? $string1day : str_replace('[N]', $d3, $stringNdays)));
$timer['MWD'] = $timer['MW'].($dw3 == 0 ? $string0day : ($dw3 == 1 ? $string1day : str_replace('[N]', $dw3, $stringNdays)));
$timer['W'] = ($w1 == 0 ? $string0week : ($w1 == 1 ? $string1week : str_replace('[N]', $w1, $stringNweeks)));
$timer['WD'] = $timer['W'].($dw1 == 0 ? $string0day : ($dw1 == 1 ? $string1day : str_replace('[N]', $dw1, $stringNdays)));
$timer['D'] = ($d1 == 0 ? $string0day : ($d1 == 1 ? $string1day : str_replace('[N]', $d1, $stringNdays)));

foreach ($strings as $string) { $timer[$string] = trim($timer[$string]); }
foreach (array(
'YMW',
'YM',
'YW',
'MW',
'M',
'W') as $string) {
if ($timer[$string] == '') { $timer[$string] = $timer['D']; } }
if ($timer['Y'] == '') { $timer['Y'] = $timer['M']; }

foreach ($strings as $string) { $content = str_replace('['.$prefix.$string.'timer]', $timer[$string], $content); } }