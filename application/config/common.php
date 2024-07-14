<?php

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