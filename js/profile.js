
getLogs(false, true);
// listen change avater event
document.getElementById('input-file').addEventListener('change', function(e) {
    var file = e.target.files[0];
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avtImg').src = e.target.result;
    };
    reader.readAsDataURL(file);
});

// listen upload image 
document.getElementById('actionUploadImage').addEventListener('click', function() {
    // check file is selected
    var file = document.getElementById('input-file').files[0];
    if (file) {
        var urlPost = '../action/change_avatar.php';
        // create form element
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', urlPost);
        form.setAttribute('enctype', 'multipart/form-data');
        // create input element
        var input = document.createElement('input');
        input.setAttribute('type', 'text');
        input.setAttribute('name', 'base64Img');
        input.setAttribute('value', document.getElementById('avtImg').src);
        // append input to form 
        form.appendChild(input);
        // append form to body
        document.body.appendChild(form);
        // submit form
        form.submit();
    }

});

// listen edit profile
document.getElementById('actionEditInfo').addEventListener('click', function() {
    var username = document.getElementById('username').value;
    var phoneNumber = document.getElementById('phoneNumber').value;
    var address = document.getElementById('address').value;

    var urlPost = '../action/change_profile.php';

    if(username == '' || phoneNumber == '' || address == '') {
        alert('Vui lòng nhập đầy đủ thông tin');
        return;
    }

    if(username.length <= 3) {
       alert('Tên không hợp lệ')
        return;
    }
    if(phoneNumber.length <= 9) {
        alert('Số điện thoại không hợp lệ')
        return;
    }

    if(address.length <= 10) {
        alert('Địa chỉ không hợp lệ')
        return;
    }

    // create form element
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', urlPost);
    // create input element
    var inputUsername = document.createElement('input');
    inputUsername.setAttribute('type', 'text');
    inputUsername.setAttribute('name', 'username');
    inputUsername.setAttribute('value', username);
    // create input element
    var inputPhoneNumber = document.createElement('input');
    inputPhoneNumber.setAttribute('type', 'text');
    inputPhoneNumber.setAttribute('name', 'phoneNumber');
    inputPhoneNumber.setAttribute('value', phoneNumber);
    // create input element
    var inputAddress = document.createElement('input');
    inputAddress.setAttribute('type', 'text');
    inputAddress.setAttribute('name', 'address');
    inputAddress.setAttribute('value', address);
    // append input to form
    form.appendChild(inputUsername);
    form.appendChild(inputPhoneNumber);
    form.appendChild(inputAddress);
    // append form to body
    document.body.appendChild(form);
    // submit form
    form.submit();

});

// listen submitNewPassword
document.getElementById('submitNewPassword').addEventListener('click', function() {
    var newPassword = document.getElementById('newPassword').value;
    var reInputNewPassword = document.getElementById('reInputNewPassword').value;

    if (newPassword == '' || reInputNewPassword == '') {
        alert('Vui lòng nhập đầy đủ thông tin');
        return;
    }

    if(newPassword.length <= 5) {
        alert('Mật khẩu không hợp lệ');
        return;
    }

    if(newPassword != reInputNewPassword) {
        alert('Mật khẩu không khớp');
        return;
    }

    var urlPost = '../action/change_password.php';
    // create form element
    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', urlPost);
    // create input element
    var inputNewPassword = document.createElement('input');
    inputNewPassword.setAttribute('type', 'text');
    inputNewPassword.setAttribute('name', 'password');
    inputNewPassword.setAttribute('value', newPassword);
    // append input to form
    form.appendChild(inputNewPassword);
    // append form to body
    document.body.appendChild(form);
    // submit form
    form.submit();


});



function getLogs (viewAll=false, today=false, week=false, last_week=false) {
    const domLog = document.getElementById('renderLogs');
    if (viewAll) {

        domLog.innerHTML = '';
        for(var log of logs) {
            var info_log = log.info_log;
            var cat_log = log.cat_log;
            var time_log = log.dateCreated;
            domLog.innerHTML += `<li class="crm-recent-activity-content">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar avatar-xs bg-primary-transparent avatar-rounded">
                        <i class="bi bi-circle-fill fs-8"></i>
                    </span>
                </div>
                <div class="crm-timeline-content">
                    <span class="fw-semibold">[${cat_log}] ${info_log}</a></span>
                </div>
                <div class="flex-fill text-end">
                    <span class="d-block text-muted fs-11 op-7">${time_log}</span>
                </div>
            </div>
        </li>`;
        }
    }


    if (today) {
        domLog.innerHTML = '';
        // 2024-05-02 YYYY-MM-DD
        var objDate = new Date();
        var year = objDate.getFullYear();
        var month = objDate.getMonth() + 1;
        var day = objDate.getDate();


        if(month < 10) {
            month = '0' + month;
        }

        if(day < 10) {
            day = '0' + day;
        }


        var today = year + '-' + month + '-' + day;
       
        for(var log of logs) {
            var info_log = log.info_log;
            var cat_log = log.cat_log;
            var time_log = log.dateCreated;

            var time_logClone = time_log.split(' ')[0];

            if(today == time_logClone) {
                domLog.innerHTML += `<li class="crm-recent-activity-content">
                <div class="d-flex align-items-top">
                    <div class="me-3">
                        <span class="avatar avatar-xs bg-primary-transparent avatar-rounded">
                            <i class="bi bi-circle-fill fs-8"></i>
                        </span>
                    </div>
                    <div class="crm-timeline-content">
                        <span class="fw-semibold">[${cat_log}] ${info_log}</a></span>
                    </div>
                    <div class="flex-fill text-end">
                        <span class="d-block text-muted fs-11 op-7">${time_log}</span>
                    </div>
                </div>
            </li>`;
            }
        }
    }

  
}