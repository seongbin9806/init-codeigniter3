<div id="login">
    <div class="loginBox">
        <img class="icoLogo" src="/assets/image/logo.png?v=<?=$this->config->item('ver')?>"/>
        <p class="title"><?=$this->config->item('title')?> - 관리자 로그인</p>
        
        <input type="text" id="id" class="loginInput" placeholder="아이디"/>
        <input type="password" id="password" class="loginInput" placeholder="비밀번호"/>
        
        <button class="submitBtn" onclick="login.onLogin();">로그인</button>
    </div>
</div>

<script>
    const login = {
        onLogin: async function(){
            let $id = $('#id'),
                $password = $('#password');

            if(!$id.val()){
                util.showAlert('아이디를 입력해주세요.', $id.focus());
                return;
            }else if(!$password.val()){            
                util.showAlert('비밀번호를 입력해주세요.', $password.focus());
                return;
            }

            const loginRes = await util.fetchJsonData('/adm/user/login', {
                id : $id.val(),
                password : $password.val()
            });

            if(!loginRes.result){
                util.showAlert(loginRes.msg);
                return;
            }

            location.replace("/admin");
        }
    }
    
    $(function(){
         
        $('#id, #password').on('keyup', function(e){
            if(e.keyCode != 13) return;            
            login.onLogin();
            
            return false;
        });
    });
</script>