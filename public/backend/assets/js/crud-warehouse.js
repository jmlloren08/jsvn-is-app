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
            } else {
                let warehouseData = {
                    product_id: formData.get('product_id'),
                    stocks: formData.get('stocks')
                };
                $.ajax({
                    url: `${updateStockURL}/${id}`,
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
                            $("#modalStock").modal('hide'); //hide modal
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
    }); //end of adding/updating product
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
                $("#modalStock").modal("show");
                $("#id").val(response.id);
                $("#product_id").val(response.product_id);
                $("#stocks").val(response.stocks);
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
    // delete product
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
                    url: `${editStockURL}/${id}`,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Stock has been deleted.'
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
        $("#id").val("");
        $("#product_id").val("Choose");
        $("#stocks").val("");
        $("#pcs").val("");
        $("#bxs").val("");
    }
    // function if modal hide
    $("#modalStock").on('hidden.bs.modal', function (e) {
        clearForm();
    }); //end function
});