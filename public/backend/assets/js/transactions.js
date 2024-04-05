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
            data: function (d) {
                d.outlet_id = $('#filter_outlet_id').val();
            }
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
            render: $.fn.DataTable.render.number(',', '.', 2, '₱')
        },
        {
            data: 'total',
            render: $.fn.DataTable.render.number(',', '.', 2, '₱')
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
        lengthMenu: [30, 40, 50, 60, 100],
        scrollX: true,
        // calculate and display total_price
        drawCallback: function () {
            let api = this.api();
            let total = api.column(7, {
                page: 'current'
            }).data().reduce(function (a, b) {
                return a + parseFloat(b);
            }, 0);
            $('#table_sub_total_price').text(total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#hidden_sub_total').val(total.toFixed(2));
        }
    }); // end of table
    // // // load datatables by outlet and date
    $('#filter_outlet_id').on('change', function () {
        table.ajax.reload();
    });
    // get transaction number by outlet and date
    $('#filter_outlet_id').on('change', function () {
        let outletId = $('#filter_outlet_id').val();
        // let date = $('#filter_date').val();
        $.ajax({
            url: getTransactionNoURL,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                outlet_id: outletId
                // transaction_date: date
            },
            success: function (response) {
                $('#trans_no').val(response.transaction_no);
            },
            error: function (error) {
                console.log('Error fetching transaction number: ', error);
            }
        });
    });
    // get address from outlet select
    $('#filter_outlet_id').on('change', function () {
        let id = $(this).val();
        $.ajax({
            url: `${getOutletNameAddressURL}/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#outlet_name_for_print').val(response.outlet_name);
                $('#outlet_address').val(response.full_address);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    // get unit_price from product select
    $('#product_id').on('change', function () {
        let id = $(this).val();
        $.ajax({
            url: `${getUnitPriceAndDescriptionURL}/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#product_description').val(response.product_description);
                $('#unit_price').val(response.product_unit_price);
            },
            error: function (error) {
                console.log(error.message);
            }
        });
    });
    // end
    // run random if modal is close
    function generateRandom() {
        let $randomTransactionNo = Math.floor(10000 + Math.random() * 900000);
        $("#transaction_no").val($randomTransactionNo);
    }
    // function if modal hide
    $("#btnTransact").on('click', function (e) {
        $('#btnSubmit').prop('disabled', true);
        generateRandom();
    }); //end function

    $('#btnAdd').click(function () {
        let outlet_id = $('#outlet_id').val();
        let product_id = $('#product_id').val();
        let unit_price = parseFloat($('#unit_price').val());
        let quantity = parseInt($('#quantity').val());
        let total = unit_price * quantity;

        if (!outlet_name || !product_description || !unit_price || !quantity) {
            Swal.fire({
                icon: 'error',
                title: 'Fields required',
                text: 'Please fill in all required fields.'
            });
            return;
        }

        let productAlreadyAdded = false;
        $('#dataTableDraft tbody tr').each(function () {
            let existingProductId = $(this).find('input[name="product_ids[]"]').val();
            if (existingProductId === product_id) {
                productAlreadyAdded = true;
                return false;
            }
        });

        if (productAlreadyAdded) {
            Swal.fire({
                icon: 'error',
                title: 'Product already added',
                text: 'This product is already added for the selected outlet. You can modify the quantity of the existing entry later. Please choose a new/other product.'
            });
            return;
        }

        let newRow = $('<tr>').append(
            $('<td>').text($('#outlet_name').val()),
            $('<td>').text($('#product_description').val()),
            $('<td>').text(unit_price.toFixed(2)),
            $('<td>').text(quantity),
            $('<td>').text(total.toFixed(2))
        );

        newRow.append('<input type="hidden" name="outlet_ids[]" value="' + outlet_id + '">');
        newRow.append('<input type="hidden" name="product_ids[]" value="' + product_id + '">');
        $('#dataTableDraft tbody').prepend(newRow);
        $('#outlet_name').prop('disabled', true);
        $('#btnSubmit').prop('disabled', false);
    });
    // submit form
    $('#formTransaction').submit(function (e) {
        e.preventDefault();
        let transaction_no = $('#transaction_no').val();
        let transaction_date = $('#transaction_date').val();
        let rowsData = [];
        $('#dataTableDraft tbody tr').each(function () {
            let rowData = {
                outlet_id: $(this).find('input[name="outlet_ids[]"]').val(),
                product_id: $(this).find('input[name="product_ids[]"]').val(),
                unit_price: parseFloat($(this).find('td:eq(2)').text()),
                quantity: parseInt($(this).find('td:eq(3)').text()),
                total: parseFloat($(this).find('td:eq(4)').text())
            };
            rowsData.push(rowData);
        });
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to revert this.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
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
                    dataType: 'JSON',
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
                });
            }
        });
    });
    // get product for updating
    $('#dataTableSubmitted tbody').on("click", "#btnEdit", function (e) {
        let rowData = table.row($(this).closest('tr')).data();
        let id = rowData.id;
        let product_description = rowData.product_description;
        let quantity = rowData.quantity;
        let on_hand = rowData.on_hand;
        let sold = rowData.sold;
        let unit_price = rowData.unit_price;
        let sub_total = rowData.total;
        $("#modalEdit").modal("show");
        $('#idForUpdating').val(id);
        $('#prod_desc').val(product_description);
        $('#u_price').val(unit_price);
        $('#qtty').val(quantity);
        $('#on_hand').val(on_hand);
        $('#sold').val(sold);
        $('#modal_sub_total').text(sub_total);
    });
    //  submit form edit
    $('#formEdit').submit(function (event) {
        event.preventDefault();
        let form = $("#formEdit")[0];
        let formData = new FormData(form);
        let total = $('#modal_sub_total').text();
        let id = formData.get('idForUpdating');
        if (this.checkValidity()) {
            let updateData = {
                quantity: formData.get('qtty'),
                on_hand: formData.get('on_hand'),
                sold: formData.get('sold'),
                total: total
            };
            $.ajax({
                url: `${updateOnhandURL}/${id}`,
                type: "PUT",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: updateData,
                dataType: 'JSON',
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Transaction successfully updated.'
                    }).then(() => {
                        table.ajax.reload(); //reload datatable
                        $("#modalEdit").modal('hide'); //hide modal
                    });
                },
                error: function (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: e.responseJSON.message
                    });
                }
            });
        }
    });
});
$("#modalEdit").on('hidden.bs.modal', function (e) {
    $('#idForUpdating').val("");
    $('#prod_desc').val("");
    $('#u_price').val("");
    $('#qtty').val("");
    $('#on_hand').val("");
    $('#sold').val("");
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
    function clearFormAndTable() {
        $("#transaction_no").val("");
        $("#outlet_name").val("");
        $("#product_id").val("Choose");
        $("#unit_price").val("");
        $("#quantity").val("");
        $('#dataTableDraft tbody').empty();
        $('#outlet_name').prop('disabled', false);
    }
    // function if modal hide
    $("#modalTransact").on('hidden.bs.modal', function (e) {
        clearFormAndTable();
    }); //end function
    // select outlet on change
    $('#outlet_name').on('change', function () {
        let selectedId = $("#datalistOptions option[value='" + $(this).val() + "']");
        let outletId = selectedId.data('id');
        $('#outlet_id').val(outletId);
    });
    // end
    $('#qtty').on('input', function() {
        let qtty = $(this).val();
        let uprice = parseFloat($('#u_price').val()) || 0;
        let subtotal = uprice * qtty;
        $('#modal_sub_total').text(subtotal);
    })
    $('#on_hand').on('input', function () {
        let u_price = parseFloat($('#u_price').val()) || 0;
        let quantity = parseInt($('#qtty').val()) || 0;
        let on_hand = parseInt($('#on_hand').val()) || 0;
        let sold = quantity - on_hand;
        $('#sold').val(sold);
        let sub_total = u_price * sold;
        $('#modal_sub_total').text(sub_total);
    });
    $('#discount').on('input', function () {
        let tableSubTotalPrice = parseFloat($('#hidden_sub_total').val()) || 0;
        let discountPercentage = parseInt($(this).val()) || 0;
        let discountAmount = (tableSubTotalPrice * discountPercentage) / 100;
        let total = tableSubTotalPrice - discountAmount;
        $('#total_price').html(`<strong>${total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</strong>`);
        $('#discount_amount').val(discountAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    });
});