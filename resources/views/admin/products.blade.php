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
                        <form class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <input type="hidden" id="product_id" name="product_id">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter name of product" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter product name.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="product_description">Product Description</label>
                                    <input type="text" class="form-control" id="product_description" name="product_description" placeholder="Enter description of product" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter product description.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="product_unit_price">Unit Price</label>
                                    <input type="number" class="form-control" id="product_unit_price" name="product_unit_price" placeholder="Enter unit price" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter unit price.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                            <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>PRODUCT_NAME</th>
                                        <th>PRODUCT_DESCRIPTION</th>
                                        <th>PRODUCT_UNIT_PRICE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td class="text-right py-0 align-middle">
                                            <div class="btn-group btn-group-sm">
                                                <a class="btn btn-info" id="btnEdit" title="Edit product"><i class="fas fa-edit" style="color: white;"></i></a>
                                                <a class="btn btn-danger" id="btnDelete" title="Delete product"><i class="fas fa-trash" style="color: white;"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody><!-- end tbody -->
                            </table> <!-- end table -->
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div>
</div>
<script>
    // add new user
    $(function() {
        $("form").submit(function(event) {
            event.preventDefault();
            let formData = $(this).serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            let jsonData = JSON.stringify(formData);
            if (this.checkValidity()) {
                // new user
                if (!formData.product_id) {
                    $.ajax({
                        url: "{{ route('admin.products.store') }}",
                        type: "POST",
                        data: {
                            ...jsonData,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Product successfully added.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                clearForm();
                                $("#modalProduct").modal("hide");
                                table.ajax.reload();
                            });
                        },
                        error: function(result) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Product not updated.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log(jsonData);
                        }
                    });
                } else {
                    // update existing user
                    $.ajax({
                        url: "#" + formData.product_id,
                        type: "PUT",
                        data: jsonData,
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Record successfully updated.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                clearForm();
                                table.ajax.reload();
                                $("#modalProduct").modal("hide");
                            });
                        },
                        error: function(result) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Record not updated.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            }
        });
    });
    // clear form after event
    function clearForm() {
        $("#product_id").val("");
        $("#product_name").val("");
        $("#product_description").val("");
        $("#product_unit_price").val("");
    }
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
</script>
@endsection