const util = {
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
    postJson: function(url, data, isLoading = false) {
        return new Promise((resolve, reject) => {
            if (isLoading) this.showLoadingBar();
            
            fetch(url, {
                method: 'POST',
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
    showAlert: function(message, destroyEvent) {
        return swal.fire({
            html: message,
            confirmButtonText: '확인',
            didDestroy: () => {
                if (destroyEvent) destroyEvent();
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
    addComma: function(number) {
        return number.toLocaleString();
    },
    removeComma: function(str) {
        return str.replace(/,/g, '');
    }
}