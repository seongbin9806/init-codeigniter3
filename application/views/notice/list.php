<link rel="stylesheet" type="text/css" href="<?=$this->config->item('baseUrl')?>/assets/css/view/notice.css<?=$this->config->item('ver')?>"/>

<div id="<?=$pageData['noticeType']?>"
     class="titleBanner" style="background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(<?=$this->config->item('baseUrl')?>/assets/image/contact_banner.png);">
    <p class="title"><?=$this->title?></p>
</div>

<div id="notice">
    <p class="title"><span class="point">피에로마케팅</span>을 방문해주셔서 감사합니다.</p>
    <p class="title">문의를 남겨주시면 최대한 <span class="point">빠른 시간내로 답변 드리겠습니다.</span></p>
    
    
     <form id="searchForm" method="get">
        <div class="filter wow fadeInUp">        
            <input type="hidden" name="page" value="1"/>

            <?
                $searchTypeArr = [
                    "title" => '제목',
                    "mbName" => '작성자',                    
                ];
            ?>

            <select id="searchType" name="searchType" class="searchType">
                <? foreach($searchTypeArr as $data => $name){ ?>
                    <option value="<?=$data?>" <?=$data == $searchData['searchType']? 'selected' : ''?>><?=$name?></option>
                <? } ?>
            </select>
            
            <input type="text" id="searchTxt" name="searchTxt" class="searchTxt" value="<?=$searchData['searchTxt']?>"/>
            <i class="fas fa-search" onclick="list.searchTeacher()"></i>        
        </div>
    </form>
    
    <div class="btnBox">
        <a href="<?=$this->config->item('baseUrl')?>/notice/send/<?=$pageData['noticeType']?>" class="btnMove">글작성</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>번호</th>
                <th class="left content">제목</th>
                <th>작성자</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>                        
            <? if(!count($list)){ ?>
                <tr>
                    <td colspan="4" class="empty">문의내역이 존재하지 않습니다.</td>
                </tr>
            <? } ?>
            
            <? foreach($list as $key => $data){ ?>
                <tr
                    <? if(empty($this->user)){ ?>
                        onclick="list.checkNoticePwd(<?=$data['noticeId']?>)"
                    <? }else if(!empty($this->user) && $this->user['role'] == 'admin'){ ?>
                        onclick="list.goDirectView(<?=$data['noticeId']?>)"
                    <? } ?>
                >
                    <? if($data['reNoticeId'] != 0){ ?>
                        <td></td>
                        <td class="left">😀 <?=$data['title']?></td>
                    <? }else{ ?>
                        <td><?=getTableNumber($pageData['page'], $pageData['pagingCount'], $key)?></td>
                        <td class="left"><?=$data['title']?></td>
                    <? } ?>
                    <td><?=$data['mbName']?></td>
                    <td><?=$data['regDate']?></td>
                </tr>
            <? } ?>
            
            
        </tbody>
    </table>    
    
    <? $this->load->view('/common/page', $pageData); ?>
</div>

<script>
 
    const list = {
        searchTeacher: function(){
            $('#searchForm').submit();
        },                 
        checkNoticePwd: async function(noticeId){
            let password = prompt('비밀번호를 입력해주세요.', '');

            if(!password) return;

            const checkNoticePwdRes = await util.fetchJsonData('/adm/notice/checkNoticePwd', {
                noticeId : noticeId,
                password : password
            });

            if(!checkNoticePwdRes.result){
                util.showAlert(checkNoticePwdRes.msg);
                return;
            }

            util.postLocation(`/notice/view/${noticeId}`, {
                noticeId : noticeId,
                password : password
            });
        },
        goDirectView: function(noticeId){
            util.postLocation(`/notice/view/${noticeId}`, {
                noticeId : noticeId,
                password : ''
            });    
        }
    };
    
</script>