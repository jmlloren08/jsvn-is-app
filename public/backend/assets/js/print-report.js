function printReport() {
    let printWindow = window.open('', '_blank');
    printWindow.document.open();

    let reportContent = document.getElementById('dataTableGenerateReport').outerHTML;

    printWindow.document.write('<style>');
    printWindow.document.write('table { width: 100%; border-collapse: collapse; }');
    printWindow.document.write('th, td { padding: 8px; text-align: center; border: 1px solid #ddd; }');
    printWindow.document.write('</style>');
    printWindow.document.write('</head><body>');

    printWindow.document.write('<html><head><title>Print Report</title></head><body>');

    printWindow.document.write('</head><body>');
    printWindow.document.write(reportContent);
    printWindow.document.write('</body></html');

    printWindow.document.close();
    printWindow.print();

}

$('#printReport').on('click', function () {
    printReport();
});
