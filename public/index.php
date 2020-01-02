<?php


// Get configuration
require_once '../config/config.php';


// Auto load classes
spl_autoload_register(function ($class) {
    if (file_exists(CLASSES . $class . '.php')) {
        // Class
        require_once CLASSES . $class . '.php';
    } else if (file_exists(CONTROLLERS . $class . '.php')) {
        // Controller
        require_once CONTROLLERS . $class . '.php';
    } else if (file_exists(MODELS . $class . '.php')) {
        // Models
        require_once MODELS . $class . '.php';
    } else if (file_exists(PHP_MAILER . $class . '.php')) {
        // PHPMailer
        require_once PHP_MAILER . $class . '.php';
    }
});


// Create new Request object
$request = new Request();


// Create new Router object
$router = new Router($request->getUrl(), $request->getMethod());


// Get routes
require_once '../routes.php';


// Run
$router->run();


?>