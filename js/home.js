const pageInvoice = document.getElementById('pageInvoice');
const invoicePerPage = 5;
pageInvoice.max = Math.round(infoTableForJS.count_invoice / invoicePerPage) + 1;
pageInvoice.value = 1;
renderInvoiceTable();


pageInvoice.addEventListener('change', function () {
    renderInvoiceTable();
});

function renderInvoiceTable () {
    for (var i = 0; i < infoTableForJS.count_invoice; i++) {
        var invoice = document.getElementById('invoice_' + i);
        invoice.style.display = 'none';
    }

    var start = (pageInvoice.value - 1) * invoicePerPage;
    var end = start + invoicePerPage;
    if (end > infoTableForJS.count_invoice) {
        end = infoTableForJS.count_invoice;
    }

    for (var i = start; i < end; i++) {
        var invoice = document.getElementById('invoice_' + i);
        invoice.style.display = '';
    }
}

function prevInvoicePage () {
    pageInvoice.value = parseInt(pageInvoice.value) - 1;
    if (pageInvoice.value < 1) {
        pageInvoice.value = 1;
    }
    renderInvoiceTable();
}


function nextInvoicePage () {
    pageInvoice.value = parseInt(pageInvoice.value) + 1;
    if (pageInvoice.value > pageInvoice.max) {
        pageInvoice.value = pageInvoice.max;
    }
    renderInvoiceTable();
} 