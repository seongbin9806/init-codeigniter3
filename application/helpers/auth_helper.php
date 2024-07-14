<?php

function AdminAuth() {
    $CI = &get_instance();
    
    $currentUrl = current_url();
    $path = parse_url($currentUrl, PHP_URL_PATH);
    
    if($path != '/admin/login' && (empty($CI->user) || $CI->user['id'] != 'admin')){
        header('Location: /admin/login');
        exit;
    } else if($path == '/admin/login' && isset($CI->user) && $CI->user['id'] == 'admin'){
        header('Location: /admin');
        exit;
    }
}