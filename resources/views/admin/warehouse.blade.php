@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Warehouse</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">JSVN</a></li>
                            <li class="breadcrumb-item active">Warehouse</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-3 justify-content-start">
                <!-- button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalStock">
                    Add stocks
                </button>
            </div>
        </div>
        <!-- end add stocks -->
        <!-- modal show -->
        <div class="modal fade" id="modalStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Stock details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formStock" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="product_id">Product</label>
                                    <select class="form-control custom-select" name="product_id" id="product_id" required>
                                        <option value="" selected disabled>Choose</option>
                                        <?php foreach ($products as $product) : ?>
                                            <option value="<?= $product['id']; ?>"><?= $product['product_description']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please choose product.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="stocks">Numbers of stock</label>
                                            <input type="number" class="form-control" id="stocks" name="stocks" placeholder="e.g. 2" required readonly>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label for="bxs">Boxes/Bottles</label>
                                            <input type="number" class="form-control" id="bxs" name="bxs" placeholder="e.g. 225" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label for="pcs">Pcs per box/bottle</label>
                                            <input type="number" class="form-control" id="pcs" name="pcs" placeholder="e.g. 30" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
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
                        <h4 class="card-title mb-4">All Stocks</h4>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>PRODUCT</th>
                                        <th>REMAINING STOCKS</th>
                                        <th>SOLD</th>
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
    let getStockURL = "{{ route('admin.warehouse.getStocks') }}";
    let storeStockURL = "{{ route('admin.warehouse.store') }}";
    let editStockURL = "/admin/warehouse";
    let updateStockURL = editStockURL;
    let deleteStockURL = editStockURL;
</script>
<script src="{{ url('backend/assets/js/crud-warehouse.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#bxs, #pcs').on('input', function() {
            let bxs = parseInt($('#bxs').val()) || 0;
            let pcsPerBox = parseInt($('#pcs').val()) || 0;
            let stocks = bxs * pcsPerBox;
            $('#stocks').val(stocks);
        });
    });
</script>
@endsection