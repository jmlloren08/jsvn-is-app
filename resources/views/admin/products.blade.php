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
                                <input type="hidden" id="product_id" name="product_id">
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
                                <input type="submit" class="btn btn-primary" value="Submit" id="btnSubmit">
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
        let csrfToken = $('meta[name="csrf-token"]').attr('content');
        let table = $("#dataTable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                type: "POST",
                url: "{{ route('admin.products.getProducts') }}",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            },
            columns: [{
                    data: 'product_id',
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
        // function if modal hide
        $("#modalProduct").on('hidden.bs.modal', function(e) {
            clearForm();
        }); //end function
        // add new product
        $("#formProduct").submit(function(event) {
            event.preventDefault();
            let form = $("#formProduct")[0];
            let data = new FormData(form);
            if (this.checkValidity()) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.products.store') }}",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Product successfully added.',
                            timer: 1500
                        }).then(() => {
                            table.ajax.reload(); //reload datatable
                            $("#modalProduct").modal('hide'); //hide modal
                        });
                    },
                    error: function(e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Product not added.',
                            timer: 1500
                        });
                    }
                });
            }
        }); //end of adding product
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
        $("#product_id").val("");
        $("#product_name").val("");
        $("#product_description").val("");
        $("#product_unit_price").val("");
    }
</script>
@endsection