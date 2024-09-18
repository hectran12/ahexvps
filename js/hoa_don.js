
$(document).ready(function() {
    var data = dataOrders;
    $('#example').DataTable({
        data: data,
        columns: [
            { data: 'id' },
            { data: 'info' },
            { data: 'dateCreated' },
            { data: 'status' },
         
        ]
    });
});
