$(function () {
    let table = $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getStockURL,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [{
            data: 'id',
        },
        {
            data: 'product_description',
        },
        {
            data: 'stocks',
        },
        {
            data: 'quantity_out',
        },
        {
            data: 'quantity_return',
        },
        {
            data: 'sold',
        },
        {
            data: '',
            defaultContent: `<td class="text-right py-0 align-middle">
            <div class="btn-group btn-group-sm">
            <a class="btn btn-info" id="btnEdit" title="Edit stock?"><i class="fas fa-edit" style="color: white;"></i></a>
            <a class="btn btn-danger" id="btnDelete" title="Delete stock?"><i class="fas fa-trash" style="color: white;"></i></a>
            <a class="btn btn-warning" id="btnClear" title="Clear stock?"><i class="fas fa-recycle" style="color: white;"></i></a>
            <a class="btn btn-primary" id="btnAdd" title="Add stock?"><i class="fas fa-plus" style="color: white;"></i></a>
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
        scrollX: true
    }); // end of table
    // form stock submission
    $("#formStock").submit(function (event) {
        event.preventDefault();
        let form = $("#formStock")[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        if (this.checkValidity()) {
            if (!id) {
                $.ajax({
                    url: storeStockURL,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Stock successfully added.'
                        }).then(() => {
                            table.ajax.reload(); //reload datatable
                            $("#modalStock").modal('hide'); //hide modal
                        });
                    },
                    error: function (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Stock not added.'
                        });
                    }
                });
            }
        }
    }); //end of adding stock
    //  form slip submission
    $("#formSlip").submit(function (e) {
        e.preventDefault();
        let form = $("#formSlip")[0];
        let formData = new FormData(form);
        let id = formData.get('id_for_slip');
        let warehouseData = {
            product_id_for_slip: formData.get('product_id_for_slip_for_saving'),
            remaining_stock_for_slip: formData.get('remaining_stock_for_slip'),
            quantity_out: formData.get('quantity_out'),
            quantity_return: formData.get('quantity_return'),
            sold: formData.get('total_stock_delivered')
        };
        if (this.checkValidity()) {
            if (id) {
                $.ajax({
                    url: `${updateStockURL}/${id}/update`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: warehouseData,
                    dataType: 'JSON',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Stock successfully updated.'
                        }).then(() => {
                            table.ajax.reload(); //reload datatable
                            $("#modalSlip").modal('hide'); //hide modal
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
        }
    }); // end of form slip
    //  form slip submission
    $("#formAddNewStock").submit(function (e) {
        e.preventDefault();
        let form = $("#formAddNewStock")[0];
        let formData = new FormData(form);
        let id = formData.get('id_for_add_new_stock');
        let warehouseNewStockData = {
            product_id_for_new_stock: formData.get('product_id_for_add_new_stock_for_saving'),
            total_stock: formData.get('total_stock')
        };
        if (this.checkValidity()) {
            if (id) {
                $.ajax({
                    url: `${addNewStockURL}/${id}/storeNewStock`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: warehouseNewStockData,
                    dataType: 'JSON',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Stock successfully added.'
                        }).then(() => {
                            table.ajax.reload(); //reload datatable
                            $("#modalAddNewStock").modal('hide'); //hide modal
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
        }
    }); // end of form slip
    // get product for updating
    $(document).on("click", "#btnEdit", function (e) {
        let row = $(this).closest("tr");
        let data = table.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editStockURL}/${id}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("#modalSlip").modal("show");
                $("#id_for_slip").val(response.id);
                $("#product_id_for_slip").val(response.product_id);
                $("#product_id_for_slip_for_saving").val(response.product_id);
                $("#stocks_for_slip").val(response.stocks);
                $("#remaining_stock_for_slip").val(response.stocks);
                $("#quantity_out").val(response.quantity_out);
                $("#quantity_return").val(response.quantity_return);
                $("#total_stock_delivered").val(response.sold);
            },
            error: function (result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.response
                });
            }
        });
    });
    // get product for adding new stock
    $(document).on("click", "#btnAdd", function (e) {
        let row = $(this).closest("tr");
        let data = table.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editStockURL}/${id}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("#modalAddNewStock").modal("show");
                $("#id_for_add_new_stock").val(response.id);
                $("#product_id_for_add_new_stock").val(response.product_id);
                $("#product_id_for_add_new_stock_for_saving").val(response.product_id);
                $("#old_stock").val(response.stocks);
            },
            error: function (result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.response
                });
            }
        });
    });
    // clear stock
    $(document).on("click", "#btnClear", function (e) {
        let row = $(this).closest("tr");
        let data = table.row(row).data();
        let id = data.id;
        Swal.fire({
            title: 'Are you sure?',
            text: 'Out, Return and Total Stock Delivered will be cleared.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, clear it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${clearStockURL}/${id}`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Stock has been cleared successfully.'
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function (result) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong.'
                        });
                    }
                });
            }
        });
    });
    // delete stock
    $(document).on("click", "#btnDelete", function (e) {
        let row = $(this).closest("tr");
        let data = table.row(row).data();
        let id = data.id;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to revert this.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${deleteStockURL}/${id}`,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Stock has been deleted successfully.'
                        }).then(() => {
                            table.ajax.reload();
                        });
                    },
                    error: function (result) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong.'
                        });
                    }
                });
            }
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
    });
    // clear form after event
    function clearForm() {
        // modal stocks
        $("#id").val("");
        $("#product_id").val("Choose");
        $("#stocks").val("");
        $("#pcs").val("");
        $("#bxs").val("");
        // modal slip
        $("#id_for_slip").val("");
        $("#product_id_for_slip").val("Choose");
        $("#stocks_for_slip").val("");
        $("#quantity_out").val("");
        $("#quantity_return").val("");
        $("#total_stock_delivered").val("");
        $("#remaining_stock_for_slip").val("");
        // modal add new stock
        $("#id_for_add_new_stock").val("");
        $("#product_id_for_add_new_stock_for_saving").val("");
        $("#product_id_for_add_new_stock").val("Choose");
        $("#old_stock").val("");
        $("#new_bxs").val("");
        $("#new_pcs").val("");
        $("#new_remainder").val("");
        $("#total_stock").val("");
    }
    // function if modal hide
    $("#modalStock").on('hidden.bs.modal', function (e) {
        clearForm();
    });
    $("#modalSlip").on('hidden.bs.modal', function (e) {
        clearForm();
    });
    $("#modalAddNewStock").on('hidden.bs.modal', function (e) {
        clearForm();
    });
    //end function
    // add stock function
    $('#bxs, #pcs, #remainder').on('input', function() {
        let bxs = parseInt($('#bxs').val()) || 0;
        let pcsPerBox = parseInt($('#pcs').val()) || 0;
        let remainder = parseInt($('#remainder').val()) || 0;
        let stocks = (bxs * pcsPerBox) + remainder;
        $('#stocks').val(stocks);
    });
    // new stock
    $('#new_bxs, #new_pcs, #new_remainder').on('input', function() {
        let old_stock = parseInt($('#old_stock').val()) || 0;
        let bxs = parseInt($('#new_bxs').val()) || 0;
        let pcsPerBox = parseInt($('#new_pcs').val()) || 0;
        let remainder = parseInt($('#new_remainder').val()) || 0;
        let stocks = (bxs * pcsPerBox) + old_stock;
        let new_stock = stocks + remainder;
        $('#total_stock').val(new_stock);
    });
    // end of function
    // quantity return function
    $('#quantity_return').on('input', function() {
        let stocks = parseInt($('#stocks_for_slip').val()) || 0;
        let quantity_out = parseInt($('#quantity_out').val()) || 0;
        let quantity_return = parseInt($('#quantity_return').val()) || 0;
        let totalStockDelivered = quantity_out - quantity_return;
        let remainingStocks = stocks - totalStockDelivered;
        $('#total_stock_delivered').val(totalStockDelivered);
        $('#remaining_stock_for_slip').val(remainingStocks);
    });
    // end of function
});