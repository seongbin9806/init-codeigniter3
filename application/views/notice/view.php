<link rel="stylesheet" type="text/css" href="<?=$this->config->item('baseUrl')?>/assets/css/view/notice.css<?=$this->config->item('ver')?>"/>

<div id="<?=$noticeInfo['noticeType']?>"
     class="titleBanner" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(<?=$this->config->item('baseUrl')?>/assets/image/contact_banner.png);">
    <p class="title"><?=$this->title?></p>
</div>

<div id="noticeView">
    <div class="inputBox">
        <div class="tobBox">
            <p class="title"><?=$noticeInfo['title']?></p>

            <span class="sub"><span class="bold">작성자</span> <?=$noticeInfo['mbName']?></span> 
            <span class="sub"><span class="bold">작성일</span> <?=$noticeInfo['regDate']?></span>
        </div>
        
        <p class="viewText"><?=$noticeInfo['content']?></p>
    </div>
</div>

<? 
/* 답변 뷰 */
if(!empty($this->user) && $this->user['role'] == 'admin' && $noticeInfo['reNoticeId'] == 0){     
    if($noticeInfo['isAnswer']){
        echo '<p class="answerF">답변을 완료한 문의입니다.😀</p>';
    }else{
        $this->load->view('/notice/answer');   
    }    
}
?>