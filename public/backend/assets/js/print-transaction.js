function printReport() {
    let tra = $('#tra').val();
    let filterDate = $('#filter_date').val();
    let outletName = $('#outlet_name_for_print').val();
    let term = $('#term').val();
    let outletAddress = $('#outlet_address').val();
    let transNo = $('#trans_no').val();
    
    let tableSubTotalPrice = $('#table_sub_total_price').text();
    let discountPercentage = $('#discount').val();
    let discountAmount = $('#discount_amount').val();
    let total_price = $('#total_price').text();

    // Open new window for printing
    let printWindow = window.open('', '_blank');
    printWindow.document.open();

    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    // Content for printing
    printWindow.document.write('<html><head><title>Sales Report</title></head><body>');
    printWindow.document.write('<h1>Sales Report</h1>');

    printWindow.document.write(`<p><strong>Date:</strong> ${filterDate} </p>`);
    printWindow.document.write(`<p><strong>Outlet Name:</strong> ${outletName} </p>`);
    printWindow.document.write(`<p><strong>Outlet Address:</strong> ${outletAddress} </p>`);
    printWindow.document.write(`<p><strong>TRA:</strong> ${tra} </p>`);
    printWindow.document.write(`<p><strong>Term:</strong> ${term} </p>`);
    printWindow.document.write(`<p><strong>Transaction No:</strong> ${transNo} </p>`);

    printWindow.document.write('<table>');
    printWindow.document.write('<thead><tr>');
    printWindow.document.write('<th>DATE DELIVERED</th>');
    printWindow.document.write('<th>DESCRIPTION</th>');
    printWindow.document.write('<th>QUANTITY</th>');
    printWindow.document.write('<th>ON_HAND</th>');
    printWindow.document.write('<th>SOLD</th>');
    printWindow.document.write('<th>UNIT_PRICE</th>');
    printWindow.document.write('<th>AMOUNT</th>');
    printWindow.document.write('</tr></thead><tbody>');

    $('#dataTableSubmitted tbody tr').each(function () {
        let dateDelivered = $(this).find('td:eq(1)').text();
        let description = $(this).find('td:eq(2)').text();
        let quantity = $(this).find('td:eq(3)').text();
        let onHand = $(this).find('td:eq(4)').text();
        let sold = $(this).find('td:eq(5)').text();
        let unitPrice = $(this).find('td:eq(6)').text();
        let subTotal = $(this).find('td:eq(7)').text();

        printWindow.document.write('<tr>');
        printWindow.document.write(`<td>${dateDelivered}</td>`);
        printWindow.document.write(`<td>${description}</td>`);
        printWindow.document.write(`<td>${quantity}</td>`);
        printWindow.document.write(`<td>${onHand}</td>`);
        printWindow.document.write(`<td>${sold}</td>`);
        printWindow.document.write(`<td>${unitPrice}</td>`);
        printWindow.document.write(`<td>${subTotal}</td>`);
        printWindow.document.write('</tr>');
    });
    printWindow.document.write('</tbody></table>');

    printWindow.document.write('<table>');
    printWindow.document.write('<thead><tr>');
    printWindow.document.write(`<th><p>Subtotal: ${tableSubTotalPrice}</p></th>`);
    printWindow.document.write('</tr></thead><tbody>');
    printWindow.document.write('</tbody></table>');

    printWindow.document.write('<table>');
    printWindow.document.write('<thead><tr>');
    printWindow.document.write(`<th>Discount (${discountPercentage}%): -${discountAmount}</th>`);
    printWindow.document.write('</tr></thead><tbody>');
    printWindow.document.write('</tbody></table>');

    printWindow.document.write('<table>');
    printWindow.document.write('<thead><tr>');
    printWindow.document.write(`<th>Total: ${total_price}</th>`);
    printWindow.document.write('</tr></thead><tbody>');
    printWindow.document.write('</tbody></table>');

    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.print();
}

$('#printReport').on('click', function () {
    printReport();
});
