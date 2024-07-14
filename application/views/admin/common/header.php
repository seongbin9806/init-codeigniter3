<!DOCTYPE html>
<html>

<head>
	<title>관리자 - <?=$this->config->item('title')?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
    
    <meta property="og:title" content="관리자 - <?=$this->config->item('title')?>">
    <meta property="og:description" content="관리자 PC전용 웹사이트">
    <meta property="og:image" content="/assets/image/og_image.png">
    
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('baseUrl')?>/assets/css/reset.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('baseUrl')?>/assets/css/animation.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('baseUrl')?>/assets/css/admin/common.css<?=$this->config->item('ver')?>">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css<?=$this->config->item('ver')?>"/>
	<link rel="stylesheet" type="text/css" href="<?=$this->config->item('baseUrl')?>/assets/css/bootstrap-3.3.2.min.css"/>	
       
	<script type="text/javascript" src="<?=$this->config->item('baseUrl')?>/assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('baseUrl')?>/assets/js/bootstrap-3.3.2.min.js"></script>	
	<script type="text/javascript" src="<?=$this->config->item('baseUrl')?>/assets/js/sweetalert2.all.min.js<?=$this->config->item('ver')?>"></script>	
	<script type="text/javascript" src="<?=$this->config->item('baseUrl')?>/assets/js/util.js<?=$this->config->item('ver')?>"></script>
    <script type="text/javascript" src="<?=$this->config->item('baseUrl')?>/assets/js/admin/admin.js<?=$this->config->item('ver')?>"></script>
</head>

<body>    
    <? if(!$this->isLoginPage){ ?>
    
    <div id="header" class="header">
        <span class="menuIco" onclick="admin.toggleSideMenu()">☰</span>
        <img class="headerLogo" src="<?=$this->config->item('baseUrl')?>/assets/image/white_logo.png"/>
        <a class="logoutBtn" href="<?=$this->config->item('baseUrl')?>/adm/user/logout">로그아웃</a>
    </div>
    
    <div id="contentWrap">
        <div id="sideMenu" class="sideMenu <?=$this->input->cookie('sideMenu') == 'off' ? 'off' : ''?>">
            <div class="topBox">
                <img class="sideIco" src="<?=$this->config->item('baseUrl')?>/assets/image/ico/ico_humen.png"/>
                <p class="title">관리자</p>
            </div>

            <div class="dropdown">
                 <? foreach ($this->config->item('admMenu') as $menu): ?>
                    <a class="menuTab">
                        <span><?=$menu['title']; ?></span>
                        <i class="fas fa-arrow-up arrow"></i>
                    </a>
                    <ul class="menuTabList" style="display: none;">
                        <? foreach ($menu['children'] as $child): ?>
                            <li><a href="<?=$child['url']?>"><?=$child['title']?></a></li>
                        <? endforeach; ?>
                    </ul>
                <? endforeach; ?>
            </div>
        </div>
        <div id="mainWrap">
    
    <? } ?>
		