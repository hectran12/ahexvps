
$(document).ready(function() {
    var data = dataOrders;
    $('#example').DataTable({
        data: data,
        columns: [
            { data: 'id' },
            { data: 'info' },
            { data: 'amount' },
            { data: 'isCong' },
         
        ]
    });
});
