function showLoadingBar() {    
        
    let mask = `<div id='mask'></div>`,
        lodingTop = window.pageYOffset,
        loadingImg = `<div id='loadingImg' style='position: absolute; top: calc(50% + ${lodingTop}px); left: 50%; transform: translate(-50%, -50%); z-index:1051'>
                            <img src='/assets/image/loading.gif?animation=spin' style='width:80px; border-radius: 30%;'>
                      </div>`;

    $('body').append(mask).append(loadingImg);
    $('#mask').css({'width': '100%', 'height': '100vh', 'opacity': '0.3', position: 'absolute', top: $(window).scrollTop(), left: 0, background: '#898989'});
}

function hideLoadingBar() {
    $('#mask, #loadingImg').remove();
}

function postJson(url, data, isLoading = true) {
    return new Promise((resolve, reject) => {
        
        if(isLoading) showLoadingBar();
        setTimeout(function(){
            $.ajax({
                type: 'post',
                url: url,
                dataType: 'json',
                contentType: "application/x-www-form-urlencoded;charset=utf-8",
                async: false,
                data: data,
                beforeSend: function(xhr) {},
                success: function(data) {                
                    resolve(data);
                },
                complete: function(){
                    if(isLoading) hideLoadingBar();
                },
                error:function(request,status,error){     
                    alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);     
                }
            });
        }, 100);
    });
}

// swal 기본 스타일
function showAlert(message, destroyEvent){
    return swal.fire({
        html: message,
        confirmButtonText: '확인',
        didDestroy: () => {
            if (destroyEvent) destroyEvent;
        }
    });
}

// confirm
const showConfirm = (message) => {
    return Swal.fire({
        html: message,
        confirmButtonText: '확인',
        denyButtonText: '취소',
        showDenyButton: true
    });
}

function formatDateFromDateString(dateString) {
    // Date 객체 생성 (주어진 날짜 문자열을 파싱)
    var date = new Date(dateString);

    // 원하는 형식으로 날짜 포맷팅
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, '0'); // 월은 0부터 시작하므로 +1 필요
    var day = String(date.getDate()).padStart(2, '0');

    // 결과 반환 (YYYY-MM-DD 형식)
    return year + "-" + month + "-" + day;
}
