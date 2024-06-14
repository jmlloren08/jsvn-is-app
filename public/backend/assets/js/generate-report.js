$(function () {
    'use strict';
    // button generate report
    $('#btnGenerateReport').on('click', function () {
        let traNumbers = $('#filter_tra_number').val();
        if (traNumbers.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please add tra_number(s) to generate'
            });
            return;
        }
        $.ajax({
            url: generateReportURL,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                tra_numbers: traNumbers
            },
            success: function (response) {
                populateReportTable(response.reportData, traNumbers);
            },
            error: function (e) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: e.responseJSON.errors
                });
            }
        });
    });
    // function populate report table
    function populateReportTable(data, traNumbers) {
        let tableHead = $('#dataTableGenerateReport thead')
        let tableBody = $('#dynamicRows');

        tableHead.empty();
        tableBody.empty();

        let headerRow1 = $('<tr>');
        let headerRow2 = $('<tr>');
        let headerRow3 = $('<tr>');
        let headerRow4 = $('<tr>');

        headerRow1.append('<th></th>');
        headerRow2.append('<th>DATE</th>');
        headerRow3.append('<th>TRA #</th>');
        headerRow4.append('<th>PRODUCT_NAME</th>')

        traNumbers.forEach((tra, index) => {
            headerRow1.append(`<th>RESIBO ${index + 1}</th>`);
            headerRow2.append(`<th>${data[tra].transaction_date}</th>`);
            headerRow3.append(`<th>${tra}</th>`);
            headerRow4.append(`<th></th>`)
        });

        headerRow1.append('<th>TOTAL_QTY</th><th>ON_HAND</th><th>SOLD</th><th>UNIT_PRICE</th><th>AMOUNT</th>');
        headerRow2.append('<th></th><th></th><th></th><th></th><th></th>');
        headerRow3.append('<th></th><th></th><th></th><th></th><th></th>');
        headerRow4.append('<th></th><th></th><th></th><th></th><th></th>')

        tableHead.append(headerRow1);
        tableHead.append(headerRow2);
        tableHead.append(headerRow3);
        tableHead.append(headerRow4);

        let productMap = new Map();

        traNumbers.forEach(tra => {
            data[tra].products.forEach(product => {
                if (!productMap.has(product.id)) {
                    productMap.set(product.id, {
                        product_description: product.product_description,
                        on_hand: product.on_hand,
                        sold: product.sold,
                        unit_price: product.unit_price,
                        discounted_price: product.discounted_price,
                        quantities: new Array(traNumbers.length).fill(0)
                    });
                }
            });
        });

        traNumbers.forEach((tra, traIndex) => {
            data[tra].products.forEach(product => {
                let productData = productMap.get(product.id);
                productData.quantities[traIndex] = product.quantity;
            });
        });

        let totalAmount = 0;

        productMap.forEach(productData => {
            let productRow = $('<tr>');
            productRow.append(`<td>${productData.product_description}</td>`);

            let totalQty = 0;

            productData.quantities.forEach(qty => {
                productRow.append(`<td>${qty}</td>`);
                totalQty += qty;
            });

            let onHand = productData.on_hand || 0;
            let sold = totalQty - onHand;
            let unitPrice = productData.unit_price || 0;
            let amount = sold * unitPrice;

            totalAmount += amount;

            productRow.append(`<td>${totalQty}</td><td>${onHand}</td><td>${sold}</td><td>${unitPrice}</td><td>${amount.toFixed(2)}</td>`);

            tableBody.append(productRow);

        });

        let totalRow = $('<tr>');
        totalRow.append('<td></td><td></td><td></td><td></td>');
        traNumbers.forEach(() => {
            totalRow.append('<td></td>');
        });
        totalRow.append('<td><strong>TOTAL</strong></td>');
        totalRow.append(`<td><strong>${totalAmount.toFixed(2)}</strong></td>`);
        tableBody.append(totalRow);
    }
    // get TRA_NUMBER by outlet
    $('#filter_outlet_id').on('change', function () {
        let outletId = $(this).val();
        $.ajax({
            url: getTRANoURL,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                outlet_id: outletId
            },
            success: function (response) {
                let traSelect = $('#filter_tra_number');
                traSelect.empty();
                response.tra_number.forEach(function (traNumber) {
                    traSelect.append(new Option(traNumber, traNumber));
                });
            },
            error: function (error) {
                console.log('Error fetching tra number: ', error);
            }
        });
    });
});