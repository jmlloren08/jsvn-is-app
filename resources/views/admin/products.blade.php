@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <div class="row"><!-- start page title -->
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Products</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">JSVN</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div><!-- end page title -->
        <div class="row">
            <div class="col-xl-3 justify-content-start">
                <!-- button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProduct">
                    Add new
                </button>
            </div>
        </div>
        <!-- modal show -->
        <div class="modal fade" id="modalProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Product details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formProduct" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="e.g. Vitron" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter product name.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="product_description">Product Description</label>
                                    <input type="text" class="form-control" id="product_description" name="product_description" placeholder="e.g. Vitron Syrup" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter product description.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="product_unit_price">Unit Price</label>
                                    <input type="text" class="form-control" id="product_unit_price" name="product_unit_price" placeholder="e.g. 16.2" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter unit price.
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
        </div><!-- end modal -->
        <div class="mb-3"></div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">All products</h4>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>PRODUCT_NAME</th>
                                        <th>PRODUCT_DESCRIPTION</th>
                                        <th>PRODUCT_UNIT_PRICE</th>
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
    // datatables
    $(function() {
        let table = $("#dataTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.products.getProducts') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [{
                    data: 'id',
                },
                {
                    data: 'product_name',
                },
                {
                    data: 'product_description',
                },
                {
                    data: 'product_unit_price',
                },
                {
                    data: '',
                    defaultContent: `<td class="text-right py-0 align-middle">
                <div class="btn-group btn-group-sm">
                <a class="btn btn-info" id="btnEdit" title="Edit product"><i class="fas fa-edit" style="color: white;"></i></a>
                <a class="btn btn-danger" id="btnDelete" title="Delete product"><i class="fas fa-trash" style="color: white;"></i></a>
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
        // add new product
        $("#formProduct").submit(function(event) {
            event.preventDefault();
            let form = $("#formProduct")[0];
            let formData = new FormData(form);
            let id = formData.get('id');
            if (this.checkValidity()) {
                if (!id) {
                    $.ajax({
                        url: "{{ route('admin.products.store') }}",
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
                                text: 'Product successfully added.'
                            }).then(() => {
                                table.ajax.reload(); //reload datatable
                                $("#modalProduct").modal('hide'); //hide modal
                            });
                        },
                        error: function(e) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Product not added.'
                            });
                        }
                    });
                } else {
                    let productData = {
                        product_name: formData.get('product_name'),
                        product_description: formData.get('product_description'),
                        product_unit_price: formData.get('product_unit_price')
                    };
                    $.ajax({
                        url: `/admin/products/${id}`,
                        type: "PUT",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: productData,
                        dataType: 'JSON',
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Product successfully updated.'
                            }).then(() => {
                                table.ajax.reload(); //reload datatable
                                $("#modalProduct").modal('hide'); //hide modal
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
        }); //end of adding product

        // function if modal hide
        $("#modalProduct").on('hidden.bs.modal', function(e) {
            clearForm();
        }); //end function

        // get product for updating
        $(document).on("click", "#btnEdit", function(e) {
            let row = $(this).closest("tr");
            let data = table.row(row).data();
            let id = data.id;
            $.ajax({
                url: `/admin/products/${id}`,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $("#modalProduct").modal("show");
                    $("#id").val(response.id);
                    $("#product_name").val(response.product_name);
                    $("#product_description").val(response.product_description);
                    $("#product_unit_price").val(response.product_unit_price);
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
        // delete product
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
                        url: `/admin/products/${id}`,
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Product has been deleted.'
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
        $("#product_name").val("");
        $("#product_description").val("");
        $("#product_unit_price").val("");
    }
</script>
@endsection