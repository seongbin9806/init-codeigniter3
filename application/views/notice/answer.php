<div id="noticeSend">
    <div class="inputBox">
        <p class="cardName">답변작성</p>            

        <p class="guide">제목</p>
        <input id="title" type="text" value="" placeholder="제목">

        <p class="guide">내용</p>
        <textarea id="content"></textarea>

        <button class="btnSubmit" onclick="send.noticeSend()">작성</button>
    </div>
</div>

<script src="<?=$this->config->item('baseUrl')?>/assets/js/summernote-lite.js"></script>
<script src="<?=$this->config->item('baseUrl')?>/assets/js/summernote-ko-KR.js"></script>

<link rel="stylesheet" href="<?=$this->config->item('baseUrl')?>/assets/css/summernote-lite.min.css">
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
            let $title = $('#title'),
                $content = $('#content');

            if(!$title.val()){
                util.showAlert('제목을 입력해주세요.', $title.focus());
                return;
            }else if(!$content.val()){
                util.showAlert('내용을 입력해주세요.', $content.focus());
                return;
            }

            const noticeSendRes = await util.fetchJsonData('/adm/notice/sendAnswer', {                
                noticeId: '<?=$noticeInfo['noticeId']?>',
                title : $title.val(),
                content : $content.summernote('code')
            });

            if(!noticeSendRes.result){
                util.showAlert(noticeSendRes.msg);
                return;
            }

            util.showAlert("답변이 작성되었습니다.")
            .then(() => {
                util.locationReplace(`/notice?type=${noticeSendRes.noticeInfo.noticeType}`);
            });
        }        
    };
    
    $(function(){
        send.defaultSetup();
    });
</script>