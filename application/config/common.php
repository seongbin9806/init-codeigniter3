<?php

/* baseUrl */
$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$urlParts = parse_url($currentUrl);
$path = trim($urlParts['path'], '/');
$pathComponents = explode('/', $path);
$firstPathComponent = isset($pathComponents[0]) ? $pathComponents[0] : '';
$desiredPart = (strpos($firstPathComponent, '~') === 0) ? $firstPathComponent : '';

$config['baseUrl'] = "/{$desiredPart}";

/* 타이틀 */
$config['title'] = "타이틀을 설정해주세요.";

/* 파일버전 */
$config['ver'] = "?v=".strtotime(date('Y-m-d H:i:s'));

/* 관리자 메뉴탭 */
$config['admMenu'] = [
    [
        'title' => '회원',
        'children' => [
            ['title' => '접속관리', 'url' => '/admin/'],
            ['title' => '리뷰관리', 'url' => '/admin/'],
            ['title' => '로그인관리', 'url' => '/admin/'],
        ]
    ],
];

?>