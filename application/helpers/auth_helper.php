<?php

function AdminAuth() {
    $CI = &get_instance();
    
    $currentUrl = current_url();
    $path = parse_url($currentUrl, PHP_URL_PATH);        
    
    $baseUrl = $CI->config->item('baseUrl');
    
    if($path != $baseUrl.'/admin/login' && (empty($CI->user) || $CI->user['id'] != 'admin')){
        header("Location: {$baseUrl}/admin/login");
        exit;
    } else if($path == $baseUrl.'/admin/login' && isset($CI->user) && $CI->user['id'] == 'admin'){
        header("Location: {$baseUrl}/admin");
        exit;
    }
}