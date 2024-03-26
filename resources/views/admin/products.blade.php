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
                    Add product
                </button>
            </div>
        </div>
        <!-- end add new -->
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
                                    <input type="number" class="form-control" id="product_unit_price" name="product_unit_price" step="0.01" min="0" placeholder="e.g. 16.2" required>
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
            <div class="col-xl-8">
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
    let getProductsURL = "{{ route('admin.products.getProducts') }}";
    let storeProductURL = "{{ route('admin.products.store') }}";
    let editProductURL = "/admin/products";
    let updateProductURL = editProductURL;
    let deleteProductURL = editProductURL;
</script>
<script src="{{ url('backend/assets/js/crud-products.js') }}"></script>
@endsection