<link rel="stylesheet" type="text/css" href="<?=$this->config->item('baseUrl')?>/assets/css/view/notice.css<?=$this->config->item('ver')?>"/>
<script src="<?=$this->config->item('baseUrl')?>/assets/js/summernote-lite.js"></script>
<script src="<?=$this->config->item('baseUrl')?>/assets/js/summernote-ko-KR.js"></script>

<link rel="stylesheet" href="<?=$this->config->item('baseUrl')?>/assets/css/summernote-lite.min.css">

<div id="<?=$noticeType?>"
     class="titleBanner" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(<?=$this->config->item('baseUrl')?>/assets/image/contact_banner.png);">
    <p class="title"><?=$this->title?></p>
</div>

<div id="noticeSend">
    <div class="inputBox">
        <p class="cardName"><?=$this->title?></p>
        
        <p class="guide">작성자</p>
        <input id="mbName" type="text" value="" placeholder="작성자" maxlength="5">
        
        <p class="guide">비밀번호 (＊본인의 게시글만 확인가능)</p>
        <input id="password" type="password" value="" placeholder="비밀번호">                
        
        <p class="guide">제목</p>
        <input id="title" type="text" value="" placeholder="제목" maxlength="30">
        
        <p class="guide">내용 (＊성함 및 연락처 기재)</p>
        <textarea id="content"></textarea>
        
        <button class="btnSubmit" onclick="send.noticeSend()">작성</button>
    </div>
</div>

<script>
    
    const send = {
        defaultSetup: function(){
            $('#content').summernote({
              height: 300, // 에디터 높이
              minHeight: null, // 최소 높이
              maxHeight: null, // 최대 높이	   	  
              lang: "ko-KR", // 한글 설정              
           });  
        },
        noticeSend: async function(){
            let $mbName = $('#mbName'),
                $password = $('#password'),                
                $title = $('#title'),
                $content = $('#content');

            if(!$mbName.val()){
                util.showAlert('작성자를 입력해주세요.', $mbName.focus());
                return;
            }else if(!$password.val()){
                util.showAlert('비밀번호를 입력해주세요.', $password.focus());
                return;
            }else if(!$title.val()){
                util.showAlert('제목을 입력해주세요.', $title.focus());
                return;
            }else if(!$content.val()){
                util.showAlert('내용을 입력해주세요.', $content.focus());
                return;
            }

            const noticeSendRes = await util.fetchJsonData('/adm/notice/send', {
                noticeType : this.noticeType,
                mbName : $mbName.val(),
                password : $password.val(),
                title : $title.val(),
                content : $content.summernote('code')
            });

            if(!noticeSendRes.result){
                util.showAlert(noticeSendRes.msg);
                return;
            }

            util.showAlert("작성되었습니다.")
            .then(() => {
                util.locationReplace(`/notice?type=${this.noticeType}`);
            });
        },
        noticeType: '<?=$noticeType?>'
    };
    
    $(function(){
        send.defaultSetup();
    });
</script>