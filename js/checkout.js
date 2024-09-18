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


function create_don_hang() {
    var package = document.getElementById('package').value;
    if(package == '') {
        alert('Vui lòng chọn gói cần mua');
        return false;
    }

    var os = document.getElementById('os').value;
    if(os == '' || os == '0') {
        alert('Vui lòng chọn hệ điều hành');
        return false;
    }

    var quantity = document.getElementById('quantity').value;   
    if(quantity == '' || parseInt(quantity) <= 0){
        alert('Vui lòng chọn số lượng');
        return false;
    }

    var cpu = document.getElementById('cpu').value;
    var ram = document.getElementById('ram').value;
    var disk = document.getElementById('disk').value;


    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', '../action/tao_don_hang.php');
    form.setAttribute('id', 'form_don_hang');

    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'product_id');
    input.setAttribute('value', data_req_for_js.product_id);

    var inputBillingcycle = document.createElement('input');
    inputBillingcycle.setAttribute('type', 'hidden');
    inputBillingcycle.setAttribute('name', 'billing_cycle');
    inputBillingcycle.setAttribute('value', package);

    var inputOs = document.createElement('input');
    inputOs.setAttribute('type', 'hidden');
    inputOs.setAttribute('name', 'os');
    inputOs.setAttribute('value', os);

    var inputQuantity = document.createElement('input');
    inputQuantity.setAttribute('type', 'hidden');
    inputQuantity.setAttribute('name', 'quantity');
    inputQuantity.setAttribute('value', quantity);



    var inputCpu = document.createElement('input');
    inputCpu.setAttribute('type', 'hidden');
    inputCpu.setAttribute('name', 'cpu');
    inputCpu.setAttribute('value', cpu);
    form.appendChild(inputCpu);
    

 
    var inputRam = document.createElement('input');
    inputRam.setAttribute('type', 'hidden');
    inputRam.setAttribute('name', 'ram');
    inputRam.setAttribute('value', ram);
    form.appendChild(inputRam);
    
    
    if(parseInt(disk) % 10 != 0) {
        disk = 0;
    }

    var inputDisk = document.createElement('input');
    inputDisk.setAttribute('type', 'hidden');
    inputDisk.setAttribute('name', 'disk');
    inputDisk.setAttribute('value', disk);
    form.appendChild(inputDisk);
    
    

    form.appendChild(input);
    form.appendChild(inputBillingcycle);
    form.appendChild(inputOs);
    form.appendChild(inputQuantity);

    document.body.appendChild(form);
    form.submit();
}



function renderTomtatdonhang () {
    var tomtatdonhang = document.getElementById('tomtatdonhang');
    tomtatdonhang.innerHTML = '';
    var currencyFormat = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    });
    var tongtien = 0;

    // san pham vps 
    var name_product_vps = data_req_for_js.name;
    var amount_product_vps = document.getElementById('quantity').value; 
    // lay gia vps 
    var package = document.getElementById('package').options[document.getElementById('package').selectedIndex].getAttribute('gia');
    var price_product_vps = package * amount_product_vps;

    // create tr 
    var tr = document.createElement('tr');
    var td = document.createElement('td');
    td.innerHTML = name_product_vps;
    tr.appendChild(td);

    td = document.createElement('td');
    td.innerHTML = amount_product_vps;
    tr.appendChild(td);

    td = document.createElement('td');
    td.innerHTML = currencyFormat.format(price_product_vps);

    tongtien += price_product_vps;
    tr.appendChild(td);
    tomtatdonhang.appendChild(tr);  


    // cpu
    var cpu = document.getElementById('cpu').value;
    var ram = document.getElementById('ram').value;
    var disk = document.getElementById('disk').value;

 
    var price_cpu = data_req_for_js.pricing_cpu[document.getElementById('package').options[document.getElementById('package').selectedIndex].getAttribute('value')].amount;
    var price_ram = data_req_for_js.pricing_ram[document.getElementById('package').options[document.getElementById('package').selectedIndex].getAttribute('value')].amount;
    var price_disk = data_req_for_js.pricing_disk[document.getElementById('package').options[document.getElementById('package').selectedIndex].getAttribute('value')].amount;

    

    var price_product_cpu = (price_cpu * parseInt(cpu)) * parseInt(amount_product_vps);
    var price_product_ram = (price_ram * parseInt(ram)) * parseInt(amount_product_vps);


    var price_product_disk = 0;
    if(parseInt(disk) % 10 != 0) {
        price_product_disk = 0;
    } else {
        price_product_disk = (price_disk * parseInt(disk)/ 10) * parseInt(amount_product_vps);
    }




    if(price_product_cpu > 0) {
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        td.innerHTML = 'CPU thêm';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = cpu + 'GB';
        if (parseInt(amount_product_vps) > 1) {
            td.innerHTML += ' x ' + amount_product_vps;
        }
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = currencyFormat.format(price_product_cpu);
       

        tongtien += price_product_cpu;
        tr.appendChild(td);
        tomtatdonhang.appendChild(tr);  
    }

    if(price_product_ram > 0) {
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        td.innerHTML = 'RAM thêm';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = ram + 'GB';
        if (parseInt(amount_product_vps) > 1) {
            td.innerHTML += ' x ' + amount_product_vps;
        }

        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = currencyFormat.format(price_product_ram);
        
        tongtien += price_product_ram;
        tr.appendChild(td);
        tomtatdonhang.appendChild(tr);  
    }

    if(price_product_disk > 0) {
        var tr = document.createElement('tr');
        var td = document.createElement('td');
        td.innerHTML = 'Disk thêm';
        tr.appendChild(td);

        td = document.createElement('td');
        td.innerHTML = disk + 'GB';
        if (parseInt(amount_product_vps) > 1) {
            td.innerHTML += ' x ' + amount_product_vps;
        }
        tr.appendChild(td);
        
        td = document.createElement('td');
        td.innerHTML = currencyFormat.format(price_product_disk);

        

        tongtien += price_product_disk;
        tr.appendChild(td);
        tomtatdonhang.appendChild(tr);  
    }

    // tong tien
    document.getElementById('tongtien').innerHTML = currencyFormat.format(tongtien);
}