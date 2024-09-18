var domregister_btn = document.getElementById('register_btn');
domregister_btn.addEventListener('click', function() {
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var signup_password = document.getElementById('signup-password').value;
    var signup_confirmpassword = document.getElementById('signup-confirmpassword').value;
    if(username == '' || email == '' || signup_password == '' || signup_confirmpassword == '') {
        changeMessageAlert('Vui lòng nhập đầy đủ thông tin', 'danger');
        return;
    }

    if(username.length < 6 || username.length > 32) {
        changeMessageAlert('Tên đăng nhập phải từ 6 đến 32 ký tự', 'danger');
        return;
    }

    if(signup_password.length < 6) {
        changeMessageAlert('Mật khẩu phải từ 6 ký tự trở lên', 'danger');
        return;
    }

    if(signup_password != signup_confirmpassword) {
        changeMessageAlert('Mật khẩu không khớp', 'danger');
        return;
    }

    var data = {
        username: username,
        email: email,
        password: signup_password
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'register.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            if(xhr.responseText.includes('error')) {
                var parse = JSON.parse(xhr.responseText);
                changeMessageAlert(parse.error, 'danger');
            } else {
                changeMessageAlert('Đăng ký thành công', 'success');
                setTimeout(function() {
                    window.location.href = '..//auth/sign-in';
                }, 1000);
            }
        }
    };
    xhr.send(JSON.stringify(data));
});