$(function () {
    let table = $("#dataTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: getOutletsURL,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        columns: [{
            data: 'id',
        },
        {
            data: 'outlet_name',
        },
        {
            data: 'outlet_cities_municipalities',
        },
        {
            data: 'outlet_provinces',
        },
        {
            data: '',
            defaultContent: `<td class="text-right py-0 align-middle">
            <div class="btn-group btn-group-sm">
            <a class="btn btn-info" id="btnEdit" title="Edit Outlet"><i class="fas fa-edit" style="color: white;"></i></a>
            <a class="btn btn-danger" id="btnDelete" title="Delete Outlet"><i class="fas fa-trash" style="color: white;"></i></a>
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
        lengthMenu: [
            [10, 20, 30, 40, 50, -1],
            [10, 20, 30, 40, 50, 'All']
        ],
        scrollX: true
    }); // end of table
    // add new Outlet
    $("#formOutlet").submit(function (event) {
        event.preventDefault();
        let form = $("#formOutlet")[0];
        let formData = new FormData(form);
        let id = formData.get('id');
        if (this.checkValidity()) {
            if (!id) {
                $.ajax({
                    url: storeOutletURL,
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
                            text: 'Outlet successfully added.'
                        }).then(() => {
                            table.ajax.reload(); //reload datatable
                            $("#modalOutlet").modal('hide'); //hide modal
                        });
                    },
                    error: function (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Outlet not added.'
                        });
                    }
                });
            } else {
                let outletData = {
                    outlet_name: formData.get('outlet_name'),
                    outlet_cities_municipalities: formData.get('outlet_cities_municipalities'),
                    outlet_provinces: formData.get('outlet_provinces')
                };
                $.ajax({
                    url: `${updateOutletURL}/${id}`,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: outletData,
                    dataType: 'JSON',
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Outlet successfully updated.'
                        }).then(() => {
                            table.ajax.reload(); //reload datatable
                            $("#modalOutlet").modal('hide'); //hide modal
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
    }); //end of adding Outlet

    // function if modal hide
    $("#modalOutlet").on('hidden.bs.modal', function (e) {
        clearForm();
    }); //end function

    // get Outlet for updating
    $(document).on("click", "#btnEdit", function (e) {
        let row = $(this).closest("tr");
        let data = table.row(row).data();
        let id = data.id;
        $.ajax({
            url: `${editOutletURL}/${id}`,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $("#modalOutlet").modal("show");
                $("#id").val(response.id);
                $("#outlet_name").val(response.outlet_name);
                $("#outlet_cities_municipalities").val(response.outlet_cities_municipalities);
                $("#outlet_provinces").val(response.outlet_provinces);
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
    // delete Outlet
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
                    url: `${deleteOutletURL}/${id}`,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Outlet has been deleted.'
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
    $("#outlet_name").val("");
    $("#outlet_cities_municipalities").val("");
    $("#outlet_provinces").val("");
}