function changePrice (e, id) {
    var dom = document.getElementById('pricing_title_' + id);
    var selectContent = e.options[e.selectedIndex].text;
    var price = selectContent.split('(')[1].split(')')[0].replace(' ', '');
    var per = selectContent.split(' ')[0];
    dom.innerHTML = price + '<sub class="text-muted fw-semibold fs-11 ms-1">/' + per + ' tháng</sub>';
    
}


function checkout (id) {
    const selectPrice = document.getElementById('selectPrice_' + id);
    window.location.href = '/checkout?id=' + id + '&package=' + selectPrice.value;
}