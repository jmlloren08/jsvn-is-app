$(function () {
    let table = $("#dataTableSubmitted").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getTransactionURL,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [{
            data: 'id',
        },
        {
            data: 'transaction_date',
        },
        {
            data: 'product_description',
        },
        {
            data: 'quantity',
        },
        {
            data: 'on_hand',
        },
        {
            data: 'sold',
        },
        {
            data: 'unit_price',
        },
        {
            data: 'total',
        },
        {
            data: '',
            defaultContent: `<td class="text-right py-0 align-middle">
            <div class="btn-group btn-group-sm">
            <a class="btn btn-info" id="btnEdit" title="Edit stock"><i class="fas fa-edit" style="color: white;"></i></a>
            <a class="btn btn-danger" id="btnDelete" title="Delete stock"><i class="fas fa-trash" style="color: white;"></i></a>
            </div>
            </td>`
        }
        ],
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        order: [
            [0, 'desc']
        ],
        info: true,
        autoWidth: true,
        lengthMenu: [10, 20, 30, 40, 50],
        scrollX: true
    }); // end of table
    // get address from outlet select
    $('#outlet_id').on('change', function () {
        let id = $(this).val();
        $.ajax({
            url: `${getOutletAddressURL}/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#outlet_address').val(response.full_address);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    });
    // get unit_price from product select
    $('#product_id').on('change', function () {
        let id = $(this).val();
        $.ajax({
            url: `${getUnitPriceURL}/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#unit_price').val(response.product_unit_price);
            },
            error: function (error) {
                console.log(error.message);
            }
        });
    });
    // run random if modal is close
    function generateRandom() {
        let $randomTransactionNo = Math.floor(10000 + Math.random() * 900000);
        $("#transaction_no").val($randomTransactionNo);
    }
    // function if modal hide
    $("#btnTransact").on('click', function (e) {
        generateRandom();
    }); //end function

    $('#btnAdd').click(function () {
        let product_id = $('#product_id').val();
        let unit_price = parseFloat($('#unit_price').val());
        let quantity = parseInt($('#quantity').val());
        let total = unit_price * quantity;

        let newRow = $('<tr>').append(
            $('<td>').text(product_id),
            $('<td>').text(unit_price.toFixed(2)),
            $('<td>').text(quantity),
            $('<td>').text(total.toFixed(2))
        );

        $('#dataTableDraft tbody').append(newRow);
    });

    // submit form
    $('#formTransaction').submit(function (e) {
        e.preventDefault();
        let transaction_no = $('#transaction_no').val();
        let transaction_date = $('#transaction_date').val();
        let rowsData = [];
        $('#dataTableDraft tbody tr').each(function () {
            let rowData = {
                product_id: $(this).find('td:eq(0)').text(),
                unit_price: parseFloat($(this).find('td:eq(1)').text()),
                quantity: parseInt($(this).find('td:eq(2)').text()),
                total: parseFloat($(this).find('td:eq(3)').text())
            };
            rowsData.push(rowData);
        });
        $.ajax({
            url: storeTransactionURL,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                transaction_no: transaction_no,
                transaction_date: transaction_date,
                transactions: rowsData
            },
            dataType: 'json',
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Transaction complete.'
                }).then(() => {
                    table.ajax.reload(); //reload datatable
                    $("#modalTransact").modal('hide'); //hide modal
                });
            },
            error: function (error) {
                console.log(error.message);
            }
        })
    });

});

// check validation
$(document).ready(function () {
    'use strict';
    let form = $(".needs-validation");
    form.each(function () {
        $(this).on('submit', function (event) {
            if (this.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            $(this).addClass('was-validated');
        });
    });

    // clear form after event
    function clearForm() {
        $("#transaction_no").val("");
        $("#product_id").val("Choose");
        $("#product_unit_price").val("");
        $("#qty").val("");
    }

    // function if modal hide
    $("#modalTransact").on('hidden.bs.modal', function (e) {
        clearForm();
    }); //end function

});