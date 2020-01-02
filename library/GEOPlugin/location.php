<?php


// Get geoPlugin class
require_once 'geoplugin.php';


// Get location info
$geoPlugin = new geoPlugin();
$geoPlugin->locate();


// Variables
$locationIP      = getenv('REMOTE_ADDR');
$locationCountry = $geoPlugin->countryName;
$locationCode    = $geoPlugin->countryCode;
$locationState   = $geoPlugin->regionName;
$locationCity    = $geoPlugin->city;
$locationAgent   = $_SERVER['HTTP_USER_AGENT'];
$locationBrowser = '';
$locationOS      = '';


// Browser array
$browserArray = array(
    'Windows Mobile' => 'IEMobile',
    'Android Mobile' => 'Android',
    'iPhone Mobile' => 'iPhone',
    'Firefox' => 'Firefox',
    'Google Chrome' => 'Chrome',
    'Internet Explorer' => 'MSIE',
    'Opera' => 'Opera',
    'Safari' => 'Safari'
);


foreach ($browserArray as $key => $value) {
    if (preg_match("/$value/", $locationAgent)) {
        break;
    } else {
        $key = 'Unknown browser';
    }
}


$locationBrowser = $key;


// OS array
$OSArray = array(
    'iPhone' => 'iphone',
    'Android' => 'android',
    'Windows 98' => '(Win98)|(Windows 98)',
    'Windows 2000' => '(Windows 2000)|(Windows NT 5.0)',
    'Windows ME' => 'Windows ME',
    'Windows XP' => '(Windows XP)|(Windows NT 5.1)',
    'Windows Vista' => 'Windows NT 6.0',
    'Windows 7' => 'Windows NT 6.1',
    'Windows 8' => 'Windows NT 6.2',
    'Windows 10' => 'Windows NT 10.0',
    'Linux' => '(X11)|(Linux)',
    'Mac OS' => '(Mac_PowerPC)|(Macintosh)|(Mac OS)'
);


foreach ($OSArray as $key => $value) {
    if (preg_match("/$value/", $locationAgent)) {
        break;
    } else {
        $key = "Unknown OS";
    }
}


$locationOS = $key;


// Sanitize values
$locationIP      = filter_var($locationIP, FILTER_VALIDATE_IP);
$locationCountry = filter_var($locationCountry, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$locationCode    = filter_var($locationCode, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$locationState   = filter_var($locationState, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$locationCity    = filter_var($locationCity, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$locationBrowser = filter_var($locationBrowser, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
$locationOS      = filter_var($locationOS, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);


// Put values in array
$locationArray = array(
    'IP'      => $locationIP,
    'country' => $locationCountry,
    'code'    => $locationCode,
    'state'   => $locationState,
    'city'    => $locationCity,
    'browser' => $locationBrowser,
    'OS'      => $locationOS
);


?>