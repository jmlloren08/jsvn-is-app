@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Outlets</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">JSVN</a></li>
                            <li class="breadcrumb-item active">Outlets</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-3 justify-content-start">
                <!-- button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalOutlet">
                    Add outlet
                </button>
            </div>
        </div>
        <!-- end add new button -->
        <!-- modal show -->
        <div class="modal fade" id="modalOutlet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Outlet details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formOutlet" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="outlet_name">Outlet Name</label>
                                    <input type="text" class="form-control" id="outlet_name" name="outlet_name" placeholder="e.g. Julmar Agrivet" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter Outlet name.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="outlet_cities_municipalities">Cities/Municipalities</label>
                                    <input type="text" class="form-control" id="outlet_cities_municipalities" name="outlet_cities_municipalities" placeholder="e.g. Minaog, Dipolog City" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter Outlet description.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="outlet_provinces">Provinces</label>
                                    <input type="text" class="form-control" id="outlet_provinces" name="outlet_provinces" placeholder="e.g. Zamboanga del Norte" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter unit provinces.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
        <div class="mb-3"></div>
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">All outlets</h4>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>OUTLET_NAME</th>
                                        <th>CITIES/MUNICIPALITIES</th>
                                        <th>PROVINCES</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead><!-- end thead -->
                            </table> <!-- end table -->
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div>
</div>
<script>
    $(function() {
        let table = $("#dataTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.outlets.getOutlets') }}",
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
            lengthMenu: [10, 20, 30, 40, 50],
            scrollX: true
        }); // end of table
        // add new Outlet
        $("#formOutlet").submit(function(event) {
            event.preventDefault();
            let form = $("#formOutlet")[0];
            let formData = new FormData(form);
            let id = formData.get('id');
            if (this.checkValidity()) {
                if (!id) {
                    $.ajax({
                        url: "{{ route('admin.outlets.store') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Outlet successfully added.'
                            }).then(() => {
                                table.ajax.reload(); //reload datatable
                                $("#modalOutlet").modal('hide'); //hide modal
                            });
                        },
                        error: function(e) {
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
                        url: `/admin/outlets/${id}`,
                        type: "PUT",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: outletData,
                        dataType: 'JSON',
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Outlet successfully updated.'
                            }).then(() => {
                                table.ajax.reload(); //reload datatable
                                $("#modalOutlet").modal('hide'); //hide modal
                            });
                        },
                        error: function(e) {
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
        $("#modalOutlet").on('hidden.bs.modal', function(e) {
            clearForm();
        }); //end function

        // get Outlet for updating
        $(document).on("click", "#btnEdit", function(e) {
            let row = $(this).closest("tr");
            let data = table.row(row).data();
            let id = data.id;
            $.ajax({
                url: `/admin/outlets/${id}`,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#modalOutlet").modal("show");
                    $("#id").val(response.id);
                    $("#outlet_name").val(response.outlet_name);
                    $("#outlet_cities_municipalities").val(response.outlet_cities_municipalities);
                    $("#outlet_provinces").val(response.outlet_provinces);
                },
                error: function(result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.response
                    });
                }
            });
        });
        // delete Outlet
        $(document).on("click", "#btnDelete", function(e) {
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
                        url: `/admin/outlets/${id}`,
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Outlet has been deleted.'
                            }).then(() => {
                                table.ajax.reload();
                            });
                        },
                        error: function(result) {
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
    $(document).ready(function() {
        'use strict';
        let form = $(".needs-validation");
        form.each(function() {
            $(this).on('submit', function(event) {
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
</script>
@endsection