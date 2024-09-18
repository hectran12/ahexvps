const dombtnSubmitVerify = document.getElementById('btnSubmitVerify');
dombtnSubmitVerify.addEventListener('click', function() {
    var one = document.getElementById('one').value;
    var two = document.getElementById('two').value;
    var three = document.getElementById('three').value;
    var four = document.getElementById('four').value;

    if(one == '' || two == '' || three == '' || four == '') {
        changeMessageAlert('Vui lòng nhập đầy đủ mã xác thực', 'danger');
        return;
    }

    // check number
    if(isNaN(one) || isNaN(two) || isNaN(three) || isNaN(four)) {
        changeMessageAlert('Mã xác thực phải là số', 'danger');
        return;
    }

    window.location.href = '?code=' + one + two + three + four;
});