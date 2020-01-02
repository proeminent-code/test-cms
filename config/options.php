<?php


// Default options
$locals = array();
// Basic
$locals['SITE_NAME']              = 'CMS';
$locals['SITE_SUB_FOLDER']        = '/cms';
$locals['URL']                    = 'http://localhost' . $locals['SITE_SUB_FOLDER'];
// Mail
$locals['SERVER_MAIL_NAME']       = '';
$locals['SERVER_MAIL_ENCRYPTION'] = 'ssl';
$locals['SERVER_MAIL_PASS']       = '';
$locals['SERVER_MAIL_USER']       = '';
$locals['SERVER_MAIL_PORT']       = '290';
$locals['SERVER_EMAIL_ADDRESS']   = '';
// Links
$locals['URL_IMAGES']             = $locals['URL'] . '/public/assets/images';
$locals['URL_JS']                 = $locals['URL'] . '/public/assets/js';
$locals['URL_CSS']                = $locals['URL'] . '/public/assets/css';


// Define OPTIONS array as global
define('OPTIONS', $locals);


?>