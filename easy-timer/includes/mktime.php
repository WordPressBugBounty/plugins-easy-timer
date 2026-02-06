<?php date_default_timezone_set('UTC');
if (($mon === false) || ($day === false) || ($year === false)) {
$now  = getdate();
if ($mon  === false) { $mon  = $now['mon']; }
if ($day  === false) { $day  = $now['mday']; }
if ($year === false) { $year = $now['year']; } }

$hr = (int) $hr; $min = (int) $min; $sec = (int) $sec;
$mon = (int) $mon; $day = (int) $day; $year = (int) $year;

$totalSec = 3600*$hr + 60*$min + $sec;
$daysAdd = intdiv($totalSec, 86400);
if (($totalSec < 0) && ($totalSec % 86400)) { $daysAdd--; }
$secOfDay = $totalSec - 86400*$daysAdd;
if ($secOfDay < 0) { $secOfDay += 86400; $daysAdd--; }
$mon--;
$yOff = intdiv($mon, 12);
if (($mon < 0) && ($mon % 12)) { $yOff--; }
$mon = $mon - 12*$yOff;
$year += $yOff;
$mon++;
$day += $daysAdd;

$isLeap = static function(int $y): bool { return (($y % 4 === 0) && (($y % 100 !== 0) || ($y % 400 === 0))); };

$monthLen = static function(int $y, int $m) use ($isLeap): int {
static $len = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
return ((($m === 2) && ($isLeap($y))) ? 29 : $len[$m-1]); };

while ($day <= 0) {
if (--$mon < 1) { $mon = 12; $year--; }
$day += $monthLen($year, $mon); }
while ($day > ($ml = $monthLen($year, $mon))) {
$day -= $ml;
if (++$mon > 12) { $mon = 1; $year++; } }

$daysFromCivil = static function(int $y, int $m, int $d): int {
$y -= (($m <= 2) ? 1 : 0);
$era = intdiv($y, 400);
if (($y < 0) && ($y % 400)) { $era--; }
$yoe = $y - 400*$era;
$mAdj = $m + (($m > 2) ? -3 : 9);
$doy = intdiv(153*$mAdj + 2, 5) + $d - 1;
$doe = 365*$yoe + intdiv($yoe, 4) - intdiv($yoe, 100) + $doy;
return (146097*$era + $doe - 719468); };
    
$days = $daysFromCivil($year, $mon, $day);
$tz = new DateTimeZone(date_default_timezone_get());
$dtStr = sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $mon, $day, (int) floor($secOfDay/3600), (int) floor(($secOfDay%3600)/60), $secOfDay%60);
$dt = new DateTimeImmutable($dtStr, $tz);
$offset = $tz->getOffset($dt);
$ts = 86400*$days + $secOfDay - $offset;

if (PHP_INT_SIZE < 8) { if (($ts > PHP_INT_MAX) || ($ts < PHP_INT_MIN)) { return (float) $ts; } }