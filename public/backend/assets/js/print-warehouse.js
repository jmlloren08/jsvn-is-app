function printSlip() {
    let withdrawal_date = $('#withdrawal_slip_date').val();

    // Open new window for printing
    let printWindow = window.open('', '_blank');
    printWindow.document.open();

    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    // Content for printing
    printWindow.document.write('<html><head><title>Warehouse Withdrawal Slip</title></head><body>');
    printWindow.document.write('<h1>Warehouse Withdrawal Slip</h1>');

    printWindow.document.write(`<p><strong>Date:</strong> ${withdrawal_date} </p>`);

    printWindow.document.write('<table>');
    printWindow.document.write('<thead><tr>');
    printWindow.document.write('<th>PRODUCTS</th>');
    printWindow.document.write('<th>OUT</th>');
    printWindow.document.write('<th>RETURN</th>');
    printWindow.document.write('<th>TOTAL_STOCK_DELIVERED</th>');
    printWindow.document.write('</tr></thead><tbody>');

    $('#dataTable tbody tr').each(function () {
        let products = $(this).find('td:eq(1)').text();
        let qty_out = $(this).find('td:eq(3)').text();
        let qty_return = $(this).find('td:eq(4)').text();
        let totalStockDelivered = $(this).find('td:eq(5)').text();

        printWindow.document.write('<tr>');
        printWindow.document.write(`<td>${products}</td>`);
        printWindow.document.write(`<td>${qty_out}</td>`);
        printWindow.document.write(`<td>${qty_return}</td>`);
        printWindow.document.write(`<td>${totalStockDelivered}</td>`);
        printWindow.document.write('</tr>');
    });
    printWindow.document.write('</tbody></table>');

    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.print();
}

$('#printSlip').on('click', function () {
    printSlip();
});
