<?php


// Functions
function debug($code, $status = 'default') {
    if ($status == 'default') {
        // Default (gray)
        return '<pre style="color: #333; padding: 15px; background: #F1F1F1; border-radius: .25rem; border: 1px solid #DDD; margin: 10px;">' . print_r($code, true) . '</pre>';
    } else if ($status == 'success') {
        // Success (green)
        return '<pre style="color: #155724; padding: 15px; background: #d4edda; border-radius: .25rem; border: 1px solid #c3e6cb; margin: 10px;"><i class="fas fa-check"></i>&nbsp;&nbsp;' . print_r($code, true) . '</pre>';
    } else if ($status == 'warning') {
        // Warning (yellow)
        return '
            <pre style="color: #856404; padding: 15px; background: #fff3cd; border-radius: .25rem; border: 1px solid #ffeeba; margin: 10px;"><i class="fas fa-exclamation-circle"></i>&nbsp;&nbsp;' . print_r($code, true) . '</pre>';
    } else if ($status == 'danger') {
        // Danger (red)
        return '<pre style="color: #721c24; padding: 15px; background: #f8d7da; border-radius: .25rem; border: 1px solid #f5c6cb; margin: 10px;"><i class="fas fa-times-circle"></i>&nbsp;&nbsp;' . print_r($code, true) . '</pre>';
    } else {
        // Return back code without style
        return $code;
    }
}


// Crypt password
function cryptPassword($password) {
    // Crypt password using md5
    $password = md5($password);

    // Salts
    $sal1 = '30EHehwr9349Bb4gu39gu3u9g39gj3g9GRWGWGw49';
    $salt2 = 'DFvsijfbSEg2397427t79vdGWRHWHWRh4ug38g38';

    // Cut password
    $part1 = substr($password, 0, 10);
    $part2 = substr($password, 10, 12);
    $part3 = substr($password, 22, 10);

    // Mix password
    $passwordMixed = $part2 . $sal1 . $part3 . $salt2 . $part1;

    // Crypt password
    $passwordCrypted = md5($passwordMixed);

    return $passwordCrypted;
}


// Clean url
function cleanUrl($url) {
    return str_replace(['%20', ' '], '-', $url);
}


?>