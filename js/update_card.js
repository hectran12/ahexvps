const btnCharge = document.getElementById('btnCharge');
btnCharge.addEventListener('click', function() {
    var telco = document.getElementById('telco').value;
    var price = document.getElementById('price').value;
    var code = document.getElementById('code').value;
    var seri = document.getElementById('seri').value;

    if (telco == '' || price == '' || code == '' || seri == '') {
        alert('Vui lòng nhập đầy đủ thông tin');
        return;
    }

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', '../action/napthe.php');
    form.style.display = 'none';

    var inputTelco = document.createElement('input');
    inputTelco.setAttribute('name', 'telco');
    inputTelco.setAttribute('value', telco);
    form.appendChild(inputTelco);

    var inputPrice = document.createElement('input');
    inputPrice.setAttribute('name', 'price');
    inputPrice.setAttribute('value', price);
    form.appendChild(inputPrice);

    var inputCode = document.createElement('input');
    inputCode.setAttribute('name', 'code');
    inputCode.setAttribute('value', code);
    form.appendChild(inputCode);

    var inputSeri = document.createElement('input');
    inputSeri.setAttribute('name', 'seri');
    inputSeri.setAttribute('value', seri);
    form.appendChild(inputSeri);

    document.body.appendChild(form);
    form.submit();



});

const page = document.getElementById('page');
const listcard = document.getElementById('listcard');
var totalPage = infoAllCard.length / 5;
page.max = Math.round(totalPage)+1;
renderPage(1);
page.addEventListener('change', function() {
    var id = page.value;
    renderPage(parseInt(id));
    
});


function renderPage (id) {
    if(id < 1 || id > parseInt(page.max)) {
        return;
    }
    var start = (id - 1) * 5;
    var end = id * 5;
    var html = '';
    listcard.innerHTML = '';
    for (var i = start; i < end; i++) {
        var card = infoAllCard[i];
      
        if (card == undefined) {
            break;
        }
        // <tr>
        //                                           <th scope="row">ABCXYZ</th>
        //                                           <td>VIETTEL</td>
        //                                           <td>123</td>
        //                                           <td>123</td>
        //                                           <td>10000</td>
        //                                           <td>10000</td>
        //                                           <td>2021-09-09 12:00:00</td>
        //                                           <td><span class="badge bg-outline-primary">Completed</span></td>
        //                                       </tr>
        var status = '';

        if(card.status == 0) {
            // pending
            status = '<span class="badge bg-outline-primary">Đang chờ</span>';
        }
        if(card.status == 1) {
            // success
            status = '<span class="badge bg-outline-success">Thành công</span>';
        }
        
        if(status == '') {
            status = '<span class="badge bg-outline-danger">Thất bại</span>'
        }


        html += `
            <tr>
                <td scope="row">${card.trans_id}</td>
                <td>${card.telco}</td>
                <td>${card.pin}</td>
                <td>${card.serial}</td>
                <td>${card.amount}</td>
                <td>${card.price}</td>
                <td>${card.update_date}</td>
                <td>${
                    status
                }</td>
            </tr>
        `;
        


    }
    listcard.innerHTML = html;

}