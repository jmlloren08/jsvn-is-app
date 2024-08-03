function printOutlet() {

    // Open new window for printing
    let printWindow = window.open('', '_blank');
    printWindow.document.open();

    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    // Content for printing
    printWindow.document.write('<html><head><title>Outlets</title></head><body>');
    printWindow.document.write('<h1>List of Outlets</h1>');

    printWindow.document.write('<table>');
    printWindow.document.write('<thead><tr>');
    printWindow.document.write('<th>#</th>');
    printWindow.document.write('<th>OUTLET_NAME</th>');
    printWindow.document.write('<th>CITIES_MUNICIPALITIES</th>');
    printWindow.document.write('<th>PROVINCES</th>');
    printWindow.document.write('</tr></thead><tbody>');

    let item_no = 1;

    $('#dataTable tbody tr').each(function () {

        let outlet_name = $(this).find('td:eq(1)').text();
        let cities_municipalities = $(this).find('td:eq(2)').text();
        let provinces = $(this).find('td:eq(3)').text();

        printWindow.document.write('<tr>');
        printWindow.document.write(`<td>${item_no}</td>`);
        printWindow.document.write(`<td>${outlet_name}</td>`);
        printWindow.document.write(`<td>${cities_municipalities}</td>`);
        printWindow.document.write(`<td>${provinces}</td>`);
        printWindow.document.write('</tr>');

        item_no++;
    });
    printWindow.document.write('</tbody></table>');

    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.print();
}

$('#printOutlet').on('click', function () {
    printOutlet();
});
