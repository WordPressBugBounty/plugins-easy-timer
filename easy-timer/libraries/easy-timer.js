function trim(string) { return string.replace(/^\s+/g,'').replace(/\s+$/g,''); } 


function timer_string(S, format) {
var D = Math.floor(S/86400);
var H = Math.floor(S/3600);
var M = Math.floor(S/60);
var h = H - 24*D;
var m = M - 60*H;
var s = S - 60*M;

var stringD = string0day;
var stringH = string0hour;
var stringM = string0minute;
var stringS = string0second;
var stringh = string0hour;
var stringm = string0minute;
var strings = string0second;

if (D == 1) { stringD = string1day; } else if (D > 1) { stringD = stringNdays.replace('[N]', D); }
if (H == 1) { stringH = string1hour; } else if (H > 1) { stringH = stringNhours.replace('[N]', H); }
if (M == 1) { stringM = string1minute; } else if (M > 1) { stringM = stringNminutes.replace('[N]', M); }
if (S == 1) { stringS = string1second; } else if (S > 1) { stringS = stringNseconds.replace('[N]', S); }
if (h == 1) { stringh = string1hour; } else if (h > 1) { stringh = stringNhours.replace('[N]', h); }
if (m == 1) { stringm = string1minute; } else if (m > 1) { stringm = stringNminutes.replace('[N]', m); }
if (s == 1) { strings = string1second; } else if (s > 1) { strings = stringNseconds.replace('[N]', s); }

if (S >= 86400) {
var stringDhms = stringD+stringh+stringm+strings;
var stringDhm = stringD+stringh+stringm;
var stringDh = stringD+stringh;
var stringHms = stringH+stringm+strings;
var stringHm = stringH+stringm;
var stringMs = stringM+strings; }

if ((S >= 3600) && (S < 86400)) {
var stringDhms = stringH+stringm+strings;
var stringDhm = stringH+stringm;
var stringDh = stringH;
var stringD = stringH;
var stringHms = stringH+stringm+strings;
var stringHm = stringH+stringm;
var stringMs = stringM+strings; }

if ((S >= 60) && (S < 3600)) {
var stringDhms = stringM+strings;
var stringDhm = stringM;
var stringDh = stringM;
var stringD = stringM;
var stringHms = stringM+strings;
var stringHm = stringM;
var stringH = stringM;
var stringMs = stringM+strings; }

if (S < 60) {
var stringDhms = stringS;
var stringDhm = stringS;
var stringDh = stringS;
var stringD = stringS;
var stringHms = stringS;
var stringHm = stringS;
var stringH = stringS;
var stringMs = stringS;
var stringM = stringS; }

var stringhms = stringh+stringm+strings;
var stringhm = stringh+stringm;
var stringms = stringm+strings;

switch (format) {
case 'clock': return (H < 10 ? '0' : '')+H+':'+(m < 10 ? '0' : '')+m+':'+(s < 10 ? '0' : '')+s;
case 'dhms': return trim(stringDhms);
case 'dhm': return trim(stringDhm);
case 'dh': return trim(stringDh);
case 'd': return trim(stringD);
case 'hms': return trim(stringHms);
case 'hm': return trim(stringHm);
case 'h': return trim(stringH);
case 'ms': return trim(stringMs);
case 'm': return trim(stringM);
case 's': return trim(stringS);
case 'hmsr': return trim(stringhms);
case 'hmr': return trim(stringhm);
case 'hr': return trim(stringh);
case 'msr': return trim(stringms);
case 'mr': return trim(stringm);
case 'sr': return trim(strings);
default: return trim(stringDhms); } }


function timer_decrease(el, key) {
var S = easy_timer[key+'countdown'][el].getAttribute('data-time') - 1;
if (S <= 0) { window.location.reload(); }
easy_timer[key+'countdown'][el].setAttribute('data-time', S);
easy_timer[key+'countdown'][el].innerHTML = timer_string(S, key); }


function timer_increase(el, key) {
var S = easy_timer[key+'countup'][el].getAttribute('data-time') - (-1);
easy_timer[key+'countup'][el].setAttribute('data-time', S);
easy_timer[key+'countup'][el].innerHTML = timer_string(S, key); }


function clock_update(offset, format) {
var T = new Date();

if (offset == 'local') {
var H = T.getHours();
var m = T.getMinutes();
var s = T.getSeconds(); }

else {
var H = T.getUTCHours();
var m = T.getUTCMinutes();
var s = T.getUTCSeconds();

if (offset != 0) {
if (offset > 0) { offset = offset%24; }
else { offset = 24 - (-offset)%24; }

var S = (3600*(H + offset) + 60*m + s)%86400;
var H = Math.floor(S/3600);
var M = Math.floor(S/60);
var m = M - 60*H;
var s = S - 60*M; } }

if (H < 10) { H = '0'+H; }
if (m < 10) { m = '0'+m; }
if (s < 10) { s = '0'+s; }

switch (format) {
case 'hm': return H+':'+m; break;
case 'hms': return H+':'+m+':'+s; break;
default: return H+':'+m; } }


function hmclock_update(el) {
var offset = easy_timer['hmclock'][el].getAttribute('data-offset');
easy_timer['hmclock'][el].innerHTML = clock_update(offset, 'hm'); }

function hmsclock_update(el) {
var offset = easy_timer['hmsclock'][el].getAttribute('data-offset');
easy_timer['hmsclock'][el].innerHTML = clock_update(offset, 'hms'); }

function localhmclock_update(el) {
easy_timer['localhmclock'][el].innerHTML = clock_update('local', 'hm'); }

function localhmsclock_update(el) {
easy_timer['localhmsclock'][el].innerHTML = clock_update('local', 'hms'); }


function localyear_update(format) {
var T = new Date();
var year4 = T.getFullYear();
var year2 = (year4)%100;

switch (format) {
case '2': return year2;
case '4': return year4;
default: return year4; } }


function local2year_update(el) {
easy_timer['local2year'][el].innerHTML = localyear_update('2'); }

function local4year_update(el) {
easy_timer['local4year'][el].innerHTML = localyear_update('4'); }


function localisoyear_update(el) {
var T = new Date();
var isoyear = T.getFullYear();
var month = T.getMonth();
var monthday = T.getDate();
var weekday = T.getDay(); if (weekday == 0) { weekday = 7; }
if ((month == 0) && (weekday - monthday >= 4)) { isoyear = isoyear - 1; }
if ((month == 11) && (monthday - weekday >= 28)) { isoyear = isoyear + 1; }
easy_timer['localisoyear'][el].innerHTML = isoyear; }


function localyearweek_update(el) {
var T = new Date();
var year = T.getFullYear();
var month = T.getMonth();
var monthday = T.getDate();
var weekday = T.getDay(); if (weekday == 0) { weekday = 7; }
var B = 0; if (((year%4 == 0) && (year%100 != 0)) || (year%400 == 0)) { B = 1; }
var array = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

if (month <= 1) { var N = 10 + array[month] + monthday - weekday; }
else { var N = B + 10 + array[month] + monthday - weekday; }
var yearweek = Math.floor(N/7);

if (yearweek == 0) {
B = 0; if ((((year - 1)%4 == 0) && ((year - 1)%100 != 0)) || ((year - 1)%400 == 0)) { B = 1; }
N = B + 375 + array[month] + monthday - weekday;
yearweek = Math.floor(N/7); }

if ((month == 11) && (monthday - weekday >= 28)) { yearweek = 1; }

easy_timer['localyearweek'][el].innerHTML = yearweek; }


function localyearday_update(el) {
var T = new Date();
var year = T.getFullYear();
var month = T.getMonth();
var monthday = T.getDate();
var B = 0; if (((year%4 == 0) && (year%100 != 0)) || (year%400 == 0)) { B = 1; }
var array = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];

if (month <= 1) { var yearday = array[month] + monthday; }
else { var yearday = B + array[month] + monthday; }

easy_timer['localyearday'][el].innerHTML = yearday; }


function month_update(format) {
var T = new Date();
var month1 = T.getMonth() + 1;
var month2 = month1;
if (month1 < 10) { month2 = '0'+month1; }
var month = stringmonth[month1].substr(0, 1)+stringmonth[month1].substr(1).toLowerCase();
var lowermonth = stringmonth[month1].toLowerCase();
var uppermonth = stringmonth[month1];

switch (format) {
case '1': return month1;
case '2': return month2;
case '': return month;
case 'lower': return lowermonth;
case 'upper': return uppermonth;
default: return month; } }


function localmonth_update(el) {
easy_timer['localmonth'][el].innerHTML = month_update(''); }

function local1month_update(el) {
easy_timer['local1month'][el].innerHTML = month_update('1'); }

function local2month_update(el) {
easy_timer['local2month'][el].innerHTML = month_update('2'); }

function locallowermonth_update(el) {
easy_timer['locallowermonth'][el].innerHTML = month_update('lower'); }

function localuppermonth_update(el) {
easy_timer['localuppermonth'][el].innerHTML = month_update('upper'); }


function localmonthday_update(format) {
var T = new Date();
var monthday1 = T.getDate();
var monthday2 = monthday1;
if (monthday1 < 10) { monthday2 = '0'+monthday1; }

switch (format) {
case '1': return monthday1;
case '2': return monthday2;
default: return monthday1; } }


function local1monthday_update(el) {
easy_timer['local1monthday'][el].innerHTML = localmonthday_update('1'); }

function local2monthday_update(el) {
easy_timer['local2monthday'][el].innerHTML = localmonthday_update('2'); }


function weekday_update(format) {
var T = new Date();
var weekday1 = T.getDay();
var weekday = stringweekday[weekday1].substr(0, 1)+stringweekday[weekday1].substr(1).toLowerCase();
var lowerweekday = stringweekday[weekday1].toLowerCase();
var upperweekday = stringweekday[weekday1];

switch (format) {
case '': return weekday;
case 'lower': return lowerweekday;
case 'upper': return upperweekday;
default: return weekday; } }


function localweekday_update(el) {
easy_timer['localweekday'][el].innerHTML = weekday_update(''); }

function locallowerweekday_update(el) {
easy_timer['locallowerweekday'][el].innerHTML = weekday_update('lower'); }

function localupperweekday_update(el) {
easy_timer['localupperweekday'][el].innerHTML = weekday_update('upper'); }


function localtimezone_update(el) {
var offset = -((new Date()).getTimezoneOffset())/60;
if (offset == 0) { var timezone = 'UTC'; }
if (offset > 0) { var timezone = 'UTC+'+offset; }
if (offset < 0) { var timezone = 'UTC'+offset; }
easy_timer['localtimezone'][el].innerHTML = timezone; }


easy_timer = [];
array = ['clock','dhms','dhm','dh','d','hms','hm','h','ms','m','s','hmsr','hmr','hr','msr','mr','sr'];
array.forEach((key) => {
easy_timer[key+'countdown'] = document.getElementsByClassName(key+'countdown');
for (el in easy_timer[key+'countdown']) { if (parseInt(el) + 1) { setInterval('timer_decrease('+el+', "'+key+'")', 1000); } }
easy_timer[key+'countup'] = document.getElementsByClassName(key+'countup');
for (el in easy_timer[key+'countup']) { if (parseInt(el) + 1) { setInterval('timer_increase('+el+', "'+key+'")', 1000); } } });

array = ['hmclock','hmsclock','localhmclock','localhmsclock','local2year','local4year','localisoyear','localyearweek','localyearday','localmonth','local1month','local2month','locallowermonth','localuppermonth','local1monthday','local2monthday','localweekday','locallowerweekday','localupperweekday','localtimezone'];
array.forEach((key) => {
easy_timer[key] = document.getElementsByClassName(key);
for (el in easy_timer[key]) { if (parseInt(el) + 1) { setInterval(key+'_update('+el+')', 1000); } } });