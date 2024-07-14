const util = {
    baseUrl: '',
    getBaseUrl: function(){
        // 현재 URL 가져오기
        let currentUrl = window.location.href;

        // URL을 파싱하여 경로 구성 요소 추출
        let urlParts = new URL(currentUrl);
        let path = urlParts.pathname;

        // 경로를 구성 요소로 분할
        let pathComponents = path.split('/');

        // 원하는 부분 찾기 ('~'로 시작하는 부분)
        let desiredPart = '';
        for (let i = 1; i < pathComponents.length; i++) {
            if (pathComponents[i].startsWith('~')) {
                desiredPart = '/' + pathComponents[i];
                break;
            }
        }        
        return desiredPart;
    },
    locationReplace: function(url) {
        location.replace(`${this.baseUrl + url}`);
    },
    locationhref: function(url) {
        location.href = this.baseUrl + url;
    },
    showLoadingBar: function() {
        const loadingTop = window.pageYOffset;
        
        document.getElementById('loadingImg').style.top = `calc(50% + ${loadingTop}px)`;
        document.getElementById('mask').style.display = 'block';
        document.getElementById('loadingImg').style.display = 'block';
    },
    hideLoadingBar: function() {
        document.getElementById('mask').style.display = 'none';
        document.getElementById('loadingImg').style.display = 'none';
    },
    fetchJsonData: function(url, data, method = 'POST', isLoading = false) {
        return new Promise((resolve, reject) => {
            if (isLoading) this.showLoadingBar();
            
            fullUrl = this.baseUrl + url;
            
            fetch(fullUrl, {
                method: method,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
                },
                body: new URLSearchParams(data).toString()
            })
            .then(response => response.json())
            .then(data => {
                resolve(data);
                if (isLoading) this.hideLoadingBar();
            })
            .catch(error => {
                alert("Error: " + error.message);
                if (isLoading) this.hideLoadingBar();
                reject(error);
            });
        });
    },
    showAlert: function(message, destroyEvent = '') {
        return swal.fire({
            html: message,
            confirmButtonText: '확인',
            didDestroy: () => {
                if (typeof destroyEvent === 'function') { // Check if destroyEvent is a function
                    destroyEvent();
                }
            }
        });
    },
    showConfirm: function(message) {
        return Swal.fire({
            html: message,
            confirmButtonText: '확인',
            denyButtonText: '취소',
            showDenyButton: true
        });
    },
    setCookie: function(name, value, days = 30) {
        let expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    },
    deleteCookie: function(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    },
    getCookie: function(name) {
        var nameEQ = name + "=";
        var cookies = document.cookie.split(';');
        for(var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) === ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    },
    addComma: function(number) {
        return number.toLocaleString();
    },
    removeComma: function(str) {
        return str.replace(/,/g, '');
    }
}

$(function(){
    util.baseUrl = util.getBaseUrl();
});