<?php


//namespace App\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Controller
{
    public function view(string $path, $params = [])
    {
        $fullPath = VIEWS . $path . '.phtml';

        // Check if view exists
        if (file_exists($fullPath)) {
            include_once $fullPath;
        } else {
            echo $path . ' not found';
        }
    }
}