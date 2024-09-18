var firstDataReqBank = [];
var lastDataReqBank = [];
(async () => {
    firstDataReqBank = await getBankHistory();

    setInterval(async () => {
        lastDataReqBank = await getBankHistory();
        if(lastDataReqBank.length > firstDataReqBank.length) {
            firstDataReqBank = lastDataReqBank;
            var invoice = lastDataReqBank[lastDataReqBank.length - 1];
            var amount = invoice.amount;
            var format_currency = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            var amount_currency = format_currency.format(amount);
            alert('Bạn đã được cộng thêm ' + amount_currency + ' vào tài khoản');
        }
    }, 10000);
})();
// setInterval(async () => {
//     var lastDataReqBank = await getBankHistory();
   
//     if(lastDataReqBank.length > firstDataReqBank.length) {
//         firstDataReqBank = lastDataReqBank;
//         var invoice = lastDataReqBank[lastDataReqBank.length - 1];
//         var amount = invoice.amount;
//         var format_currency = new Intl.NumberFormat('vi-VN', {
//             style: 'currency',
//             currency: 'VND'
//         });
//         var amount_currency = format_currency.format(amount);
//         alert('Bạn đã được cộng thêm ' + amount_currency + ' vào tài khoản');
//     }
// },10000);

async function getBankHistory () {
    var url = '../api/getBankHistory.php';
    var response = await fetch(url);
    var data = await response.json();
    return data;
}