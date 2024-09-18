var myTabContent = document.getElementById('myTabContent');
renderTomtatdonhang();
myTabContent.addEventListener('change', function (e) {
    renderTomtatdonhang();
})




function tang_cpu () {
    var cpu = document.getElementById('cpu');
    cpu.value = parseInt(cpu.value) + 1;
    if (cpu.value > data_req_for_js.max_core_up) {
        cpu.value = data_req_for_js.max_core_up;
    }
    renderTomtatdonhang();
}

function giam_cpu () {
    var cpu = document.getElementById('cpu');
    if(parseInt(cpu.value) >= 1) {
        cpu.value = parseInt(cpu.value) - 1;
        if (cpu.value > data_req_for_js.max_core_up) {
            cpu.value = data_req_for_js.max_core_up;
        }
        renderTomtatdonhang();
    }
}  

function tang_ram () {
    var ram = document.getElementById('ram');
    ram.value = parseInt(ram.value) + 1;
    if (ram.value > data_req_for_js.max_ram_up) {
        ram.value = data_req_for_js.max_ram_up;
    }
    renderTomtatdonhang();
}

function giam_ram () {
    var ram = document.getElementById('ram');
    if(parseInt(ram.value) >= 1) {
        ram.value = parseInt(ram.value) - 1;
        if (ram.value > data_req_for_js.max_ram_up) {
            ram.value = data_req_for_js.max_ram_up;
        }
        renderTomtatdonhang();
    }
}


function tang_disk () {
    var disk = document.getElementById('disk');
    var disk_value = parseInt(disk.value);
    if(disk_value % 10 == 0) {
        disk.value = disk_value + 10;
    } else {
        disk.value = 0;
       
    }
    if (disk.value > data_req_for_js.max_disk_up) {
        disk.value = data_req_for_js.max_disk_up;
    }
    renderTomtatdonhang();
}


function create_don_hang () {
    var cpu = document.getElementById('cpu').value;
    var ram = document.getElementById('ram').value;
    var disk = document.getElementById('disk').value;
    

    var id_vps = data_req_for_js.id_vps;

    if (parseInt(cpu) == 0 && parseInt(ram) == 0 && parseInt(disk) == 0) {
        alert('Vui lòng chọn ít nhất 1 thông số để gia hạn');
        return;
    }




    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', '../action/nang_cap_vps_vietnam.php');
    
    var hiddenField = document.createElement('input');
    hiddenField.setAttribute('type', 'hidden');
    hiddenField.setAttribute('name', 'vps_id');
    hiddenField.setAttribute('value', id_vps);
    form.appendChild(hiddenField);

    hiddenField = document.createElement('input');
    hiddenField.setAttribute('type', 'hidden');
    hiddenField.setAttribute('name', 'cpu');
    hiddenField.setAttribute('value', cpu);

    form.appendChild(hiddenField);

    hiddenField = document.createElement('input');
    hiddenField.setAttribute('type', 'hidden');
    hiddenField.setAttribute('name', 'ram');
    hiddenField.setAttribute('value', ram);


    form.appendChild(hiddenField);

    hiddenField = document.createElement('input');
    hiddenField.setAttribute('type', 'hidden');
    hiddenField.setAttribute('name', 'disk');
    hiddenField.setAttribute('value', disk);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();

}

function giam_disk () {
    var disk = document.getElementById('disk');
    var disk_value = parseInt(disk.value);
    if(disk_value > 10) {
        disk.value = disk_value - 10;
    } else {
        disk.value = 0;
    }

    if(disk.value > data_req_for_js.max_disk_up) {
        disk.value = data_req_for_js.max_disk_up;
    }
    renderTomtatdonhang();
}


function renderTomtatdonhang() {

    var tomtatdonhang = document.getElementById('tomtatdonhang');
    tomtatdonhang.innerHTML = '';

    var currencyFormat = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    });


    var cpu = document.getElementById('cpu').value;
    var ram = document.getElementById('ram').value;
    var disk = document.getElementById('disk').value;


    var price_total_cpu = data_req_for_js.priceCPU * parseInt(cpu);
    var price_total_ram = data_req_for_js.priceRAM * parseInt(ram);
    
    var price_total_disk = 0;
    if(parseInt(disk) % 10 != 0) {
        price_total_disk = 0;
    } else {
        price_total_disk = (data_req_for_js.priceDISK * parseInt(disk)/ 10)
    }


    var tongtien = 0;
    if(price_total_cpu > 0) {
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        td.innerHTML = 'CPU thêm';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = cpu + 'GB';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = currencyFormat.format(price_total_cpu);
       

        tongtien += price_total_cpu;
        tr.appendChild(td);
        tomtatdonhang.appendChild(tr);  
    }

    if (price_total_ram > 0) {
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        td.innerHTML = 'RAM thêm';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = ram + 'GB';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = currencyFormat.format(price_total_ram);
        tongtien += price_total_ram;
        tr.appendChild(td);
        tomtatdonhang.appendChild(tr);  
    }

    if(price_total_disk > 0) {
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        td.innerHTML = 'Disk thêm';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = disk + 'GB';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = currencyFormat.format(price_total_disk);
        tongtien += price_total_disk;
        tr.appendChild(td);
        tomtatdonhang.appendChild(tr);  
    }
    
    
    // tong tien
    document.getElementById('tongtien').innerHTML = currencyFormat.format(tongtien);
}