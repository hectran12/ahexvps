const tableVPS = document.getElementById('tableVPS');

let currentID_VPS_selected = "";

cronStatusVPS();
updateCountSelectedVPS(); // update count selected VPS

document.getElementById('tableVPS').addEventListener('click', function (e) {
    updateCountSelectedVPS();
});


function updateCountSelectedVPS () {
    var table = document.getElementById('tableVPS')
    var totalTr = table.getElementsByTagName('tr').length;
    var totalSelected = getAllVPSSelected().length;
    document.getElementById('infoSelected').textContent = 'Đã chọn ' + totalSelected + ' / ' + (totalTr) + ' VPS';
}


async function xoa_vps () {
    var allVPSSelected = getAllVPSSelected();
    if(allVPSSelected.length > 1) {
        alert('Chỉ chọn 1 VPS để thực hiện hành động này!');
        return;
    
    }
    var success = 0;
    for (var vps_id of allVPSSelected) {
        var url = '../api/removeVPSVietNam.php';
        var body = 'vps_id=' + vps_id;
        var response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: body
        });
        var result = await response.json();
        if(result.error == 0) {
            success++;
        }
        
    }

    if(success == allVPSSelected.length) {
        alert('Đã gửi yêu cầu xóa ' + success + ' VPS.');
        window.location.reload();
    } else {
        alert('Có lỗi xảy ra trong quá trình xóa ' + success + ' VPS. Vui lòng thử lại sau!');
        window.location.reload();
    }

}


function nang_cap_vps () {
    var allVPSSelected = getAllVPSSelected();
    if(allVPSSelected.length > 1) {
        alert('Chỉ chọn 1 VPS để thực hiện hành động này!');
        return;
    
    }

    if(allVPSSelected.length < 1) {
        alert('Vui lòng chọn ít nhất 1 VPS');
        return;
    }
    var firstVPS = allVPSSelected[0];

    window.location.href = '../upgrade_vps_vietnam?id=' + firstVPS;
}

function findItem () {
    const inputFind = document.getElementById('inputFind');
    if (inputFind.value != '') {
        var trs = tableVPS.getElementsByTagName('tr');
        for (var tr of trs) {
            if(tr.textContent.includes(inputFind.value)) {
                tr.style.display = '';
            } else {
                tr.style.display = 'none';
            }
        }
    }
}

function filterStatus (status_content) {
    var trs = tableVPS.getElementsByTagName('tr');
    for (var tr of trs) {
        tr.style.display = '';
        var status = tr.getElementsByTagName('td');
        // find td has id vps_status_id_
        for (var td of status) {
            if(td.id.includes('vps_status_id_')) {
                if(td.textContent != status_content) {
                    tr.style.display = 'none';
                }
            }
        }
    }

}


function resetFilter () {

    var trs = tableVPS.getElementsByTagName('tr');
    for (var tr of trs) {
        tr.style.display = '';
    }
}

function getAllVPSSelected () {
    // get all element tr in table
    const trs = tableVPS.getElementsByTagName('tr');
    var list_id_selected = [];
    for (let i = 0; i < trs.length; i++) {
        const tr = trs[i];
        // tr -> th -> input
        const checkbox = tr.getElementsByTagName('th')[0].getElementsByTagName('input')[0];
        if (checkbox.checked) {
            list_id_selected.push(checkbox.value);
        }
    }   
    return list_id_selected;
}


async function outLog (message) {
    var currentTime = new Date();
    var log = currentTime + ' - ' + message;
    console.log(log);
}

async function cronStatusVPS () {
    
    setInterval(async () => {
        var data = await getDataVPS();
        for (let vps of data) {
            var vps_id = vps.vps_id;
            var vps_status =  vps.vps_status;
            var note = vps.note;
            var vps_autorenew = vps.auto_renew;
            var ip = vps.ip;
            var username = vps.username;
            var password = vps.password;
            var os_name = vps.os_name;
            var noteElement = document.getElementById(`vps_note_id_${vps_id}`);
            var statusElement = document.getElementById(`vps_status_id_${vps_id}`);
            var autoRenewElement = document.getElementById(`vps_autorenew_id_${vps_id}`);
            var ipElement = document.getElementById(`vps_ip_id_${vps_id}`);
            var usernameElement = document.getElementById(`vps_username_id_${vps_id}`);
            var passwordElement = document.getElementById(`vps_password_id_${vps_id}`);
            var osElement = document.getElementById(`vps_os_name_id_${vps_id}`);
          
    
            // noteElement.innerHTML = note;
            // statusElement.innerHTML = vps_status;
            // autoRenewElement.innerHTML = vps_autorenew;
            // ipElement.innerHTML = ip;
            // usernameElement.innerHTML = username;
            // passwordElement.innerHTML = password;
            // osElement.innerHTML = os_name;

            if(noteElement.innerHTML != note) {
                noteElement.innerHTML = note;
               
            }

            if(statusElement.innerHTML != vps_status) {
                statusElement.innerHTML = vps_status;
               
            }

            if(autoRenewElement.innerHTML != vps_autorenew) {
                autoRenewElement.innerHTML = vps_autorenew;
             
            }

            if(ipElement.innerHTML != ip) {
                ipElement.innerHTML = ip;
               
            }

          

            if(passwordElement.innerHTML != password) {
                passwordElement.innerHTML = password;
              
            }

            if(osElement.innerHTML != os_name) {
                osElement.innerHTML = os_name;
              
            }


    
           


          

        }

        outLog('Cập nhật thành công các trang thái của VPS');
        
    },6000);
}


async function submit_renewVPS() {
    const titleGiaHanVPS = document.getElementById('titleGiaHanVPS');
    const selectGiaHanVPS = document.getElementById('selectGiaHanVPS');
    if (titleGiaHanVPS.id_vps == undefined) {
        titleGiaHanVPS.innerHTML = 'Vui lòng chọn VPS cần gia hạn';
        alert('Vui lòng chọn VPS cần gia hạn');
        return;
    }
    var vps_id = titleGiaHanVPS.id_vps;
    var billing_cycle = selectGiaHanVPS.value;
    if (billing_cycle == '') {
        titleGiaHanVPS.innerHTML = 'Vui lòng chọn gói cần gia hạn';
        alert('Vui lòng chọn gói cần gia hạn');
        return;
    }


    alert('Hệ thống đã tiếp nhận yêu cầu...');
    var url = '../action/action_vps_vietnam.php';
    var data = 'action=renew_vps&id_vps=' + vps_id + '&billing_cycle=' + billing_cycle;
    var response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data
    });
    var result = await response.json();
    if(result.error == 0) {
        alert('Đã gửi yêu cầu gia hạn cho VPS. Vui lòng đợi một lát cho hệ thống xử lý, số dư sẽ bị trừ khi gia hạn thành công!');
        // close modal
        document.getElementById('btnCancelGiaHanVPS').click();
        return;
    } else {
        alert('Có lỗi xảy ra trong quá trình gia hạn cho VPS');
        return;
    }

}

async function submit_editNote () {
    var messageNote = document.getElementById('messageNote');
    var note = messageNote.value;
    var allVPSSelected = getAllVPSSelected();
    if(allVPSSelected.length < 1) {
        alert('Vui lòng chọn ít nhất 1 VPS');
        return;
    }

    var url = '../api/editNoteVPSVietNam.php';
    var successCount = 0;
    for (var vps_id of allVPSSelected) {
        var data = 'id_vps=' + vps_id + '&note=' + note;
        var response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data
        });
        var result = await response.json();
        if(result.error == 0) {
            successCount++;
        }
    }

    if(successCount == allVPSSelected.length) {
        alert('Đã gửi yêu cầu chỉnh sửa ghi chú cho ' + successCount + ' VPS. Vui lòng đợi một lát cho hệ thống xử lý!');
    } else {
        alert('Có lỗi xảy ra trong quá trình chỉnh sửa ghi chú cho ' + successCount + ' VPS. Vui lòng thử lại sau!');
    }
}

async function renewVPS () {
    const titleGiaHanVPS = document.getElementById('titleGiaHanVPS');
    const selectGiaHanVPS = document.getElementById('selectGiaHanVPS');
    var allVPSSelected = getAllVPSSelected();
    if(allVPSSelected.length > 1) {
        alert('Chỉ chọn 1 VPS để thực hiện hành động này!');
        return;
    }


    if(allVPSSelected.length < 1) {
        alert('Vui lòng chọn ít nhất 1 VPS');
        return;
    }

    
    var vps_id = allVPSSelected[0];

    var vpsInfo = document.getElementById('vps_' + vps_id);
    if(vpsInfo == null) {
        title_reinstall_os.innerHTML = 'Không tìm thấy VPS cần cài lại';
        alert('Không tìm thấy VPS cần cài lại');
        return;

    }

    titleGiaHanVPS.textContent = 'Gia hạn VPS ' + vpsInfo.getAttribute('ip_vps');
    titleGiaHanVPS.id_vps = vps_id;
    var url = '../api/getBillingCycleVPSVietNam.php';
    var data = 'id_vps=' + vps_id;
    var response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data
    });
    var result = await response.json();
    var currencyFormat = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    });
    // reset select
    selectGiaHanVPS.innerHTML = '';
    if(result.error == 0) {
        var data = result.data;
        for (var data_package in data) {
            var package_info = data[data_package];
            var billing_cycle = package_info.billing_cycle;
            var amount = package_info.amount;
            var option = document.createElement('option');
            option.value = data_package;
            option.textContent = billing_cycle + ' tháng - ' + currencyFormat.format(amount);
            selectGiaHanVPS.appendChild(option);
        }


    }
    


}

async function autoRenewVPS (vps_id, status) {
    var url  ='../api/AutoRenewVPSVietNam.php';
    var data = 'id_vps=' + vps_id + '&status=' + status;
    var response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data
    });
    var result = await response.json();
    if(result.error == 0) {
        return true;
    } else {
        return false;
    }
}


async function autoRenewAllVPSSelected (status) {
    var list_id_selected = getAllVPSSelected();
    if(list_id_selected.length < 1) {
        alert('Vui lòng chọn ít nhất 1 VPS');
        return;
    }

    // ask 
    var ask = confirm('Bạn có chắc chắn muốn thực hiện hành động "Tự động gia hạn" cho ' + list_id_selected.length + ' VPS?');
    if(!ask) {
        return;
    }

    var count_success = 0;
    for (var vps_id of list_id_selected) {
        var result = await autoRenewVPS(vps_id, status);
        if(result) {
            count_success++;
        }
    }

    if(count_success == list_id_selected.length) {
        alert('Đã gửi yêu cầu thực hiện hành động "Tự động gia hạn" cho ' + count_success + ' VPS. Vui lòng đợi một lát cho hệ thống xử lý!');
    } else {
        alert('Có lỗi xảy ra trong quá trình thực hiện hành động "Tự động gia hạn" cho ' + count_success + ' VPS. Vui lòng thử lại sau!');
    }
}

async function sendActionVPS (action) {
    var list_id_selected = getAllVPSSelected();
    if(list_id_selected.length < 1) {
        alert('Vui lòng chọn ít nhất 1 VPS');
        return;
    }

    // ask 
    var ask = confirm('Bạn có chắc chắn muốn thực hiện hành động "' + action + '" cho ' + list_id_selected.length + ' VPS?');
    if(!ask) {
        return;
    }

    var count_success = 0;
    for (var vps_id of list_id_selected) {
        var url = `../action/action_vps_vietnam.php`;
        var data = 'action=' + action + '&id_vps=' + vps_id;
        var response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data
        });
        var result = await response.json();
        if(result.error == 0) {
            count_success++;
        }
    }

    if(count_success == list_id_selected.length) {
        alert('Đã gửi yêu cầu thực hiện hành động "' + action + '" cho ' + count_success + ' VPS. Vui lòng đợi một lát cho hệ thống xử lý!');
    } else {
        alert('Có lỗi xảy ra trong quá trình thực hiện hành động "' + action + '" cho ' + count_success + ' VPS. Vui lòng thử lại sau!');
    }
}


async function getListOSCanReinstall (vps_id) {
    try {
        var url = '../api/getListOSCanReinstall.php';
        var data = 'id_vps=' + vps_id;
        var response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: data
        });
        var result = await response.json();
        if(result.error == 0) {
            return result.data;
        }
        return false;
    } catch {
        return false;
    }
    
}

async function submit_reinstallOS () {
    const title_reinstall_os = document.getElementById('title_reinstall_os');
    const os_id = document.getElementById('os_id'); // selected tag
    if (title_reinstall_os.id_vps == undefined) {
        title_reinstall_os.innerHTML = 'Vui lòng chọn VPS cần cài lại';
        alert('Vui lòng chọn VPS cần cài lại');
        return;
    }
    var vps_id = title_reinstall_os.id_vps;
    var os_id_selected = os_id.value;
    if (os_id_selected == '') {
        title_reinstall_os.innerHTML = 'Vui lòng chọn OS cần cài lại';
        alert('Vui lòng chọn OS cần cài lại');
        return;
    }

    var url = '../action/action_vps_vietnam.php';
    var data = 'action=confirm_rebuild_vps&id_vps=' + vps_id + '&os_id=' + os_id_selected;
    var response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data
    });
    var result = await response.json();
    if(result.error == 0) {
        alert('Đã gửi yêu cầu cài lại OS cho VPS. Vui lòng đợi một lát cho hệ thống xử lý!');
        // close modal
        document.getElementById('btnCancelReinstallVPS').click();
        return;
    } else {
        alert('Có lỗi xảy ra trong quá trình cài lại OS cho VPS');
        return;
    }
}

async function reinstallOS () {
    var allVPSSelected = getAllVPSSelected();
    const title_reinstall_os = document.getElementById('title_reinstall_os');
    const os_id = document.getElementById('os_id'); // selected tag
    const btnCancelReinstallVPS = document.getElementById('btnCancelReinstallVPS');
    if(allVPSSelected.length > 1) {
        title_reinstall_os.innerHTML = 'Chỉ chọn 1 VPS để thực hiện hành động này!';
        alert('Chỉ chọn 1 VPS để thực hiện hành động này!');
        return;
    }

    if(allVPSSelected.length < 1) {
        title_reinstall_os.innerHTML = 'Vui lòng chọn 1 VPS để thực hiện hành động này!';
        alert('Vui lòng chọn ít nhất 1 VPS');
        return;
    }

    var vpsInfo = document.getElementById('vps_' + allVPSSelected[0]);
    if(vpsInfo == null) {
        title_reinstall_os.innerHTML = 'Không tìm thấy VPS cần cài lại';
        alert('Không tìm thấy VPS cần cài lại');
        return;
    }
    title_reinstall_os.textContent = 'Cài lại OS cho VPS ' + vpsInfo.getAttribute('ip_vps');
    title_reinstall_os.id_vps = allVPSSelected[0];

    var listOS = await getListOSCanReinstall(allVPSSelected[0]);
    if(listOS == false) {
        title_reinstall_os.innerHTML = 'Có lỗi xảy ra khi lấy danh sách OS có thể cài lại';
        alert('Có lỗi xảy ra khi lấy danh sách OS có thể cài lại');
        return;
    }
    // reset select
    os_id.innerHTML = '';
    for (let os of listOS) {
        var option = document.createElement('option');
        var osId = os['os-id'];
        var osName = os['os-name'];
        option.value = osId;
        option.textContent = osName;
        os_id.appendChild(option);
    }

}

async function getDataVPS () {
    var url = '../api/getStatusVPSVietnam.php'
    var response = await fetch(url);
    var data = await response.json();
    return data;
}