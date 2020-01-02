<?php


// Constants
define('DS' ,         DIRECTORY_SEPARATOR);
define('ROOT',        dirname(__DIR__) . DS);
define('APP',         ROOT . 'app' . DS);
define('CONTROLLERS', APP . 'controllers' . DS);
define('MODELS',      APP . 'models' . DS);
define('VIEWS',       APP . 'views' . DS);
define('CLASSES',     ROOT . 'classes' . DS);
define('CONFIG',      ROOT . 'config' . DS);
define('LIBRARY',     ROOT . 'library' . DS);
define('PHP_MAILER',  LIBRARY . 'PHPMailer' . DS . 'src' . DS);


?>