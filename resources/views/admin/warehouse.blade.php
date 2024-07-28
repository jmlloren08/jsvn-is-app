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
        <div class="mb-3"></div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="withdrawal_slip_date">Date: </label>
                                    <input type="date" class="form-control" id="withdrawal_slip_date" name="withdrawal_slip_date" value="{{ date('Y-m-d') }}" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal stock show -->
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_id">Product</label>
                                            <select class="form-control custom-select" name="product_id" id="product_id" required>
                                                <option value="" selected disabled>Choose</option>
                                                @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_description }}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please choose product.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bxs">Boxes/Cases</label>
                                            <input type="number" class="form-control" id="bxs" name="bxs" placeholder="e.g. 225" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pcs">Pcs/box or Bottle/cases</label>
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
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remainder">Remainder (optional)</label>
                                            <input type="number" class="form-control" id="remainder" name="remainder" placeholder="optional">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="stocks">Numbers of stock</label>
                                            <input type="number" class="form-control" id="stocks" name="stocks" placeholder="e.g. 2" required readonly>
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
        <!-- modal slip show -->
        <div class="modal fade" id="modalSlip" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Stock details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formSlip" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <input type="hidden" id="id_for_slip" name="id_for_slip">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_id_for_slip">Product</label>
                                            <input type="hidden" id="product_id_for_slip_for_saving" name="product_id_for_slip_for_saving">
                                            <select class="form-control custom-select" name="product_id_for_slip" id="product_id_for_slip" disabled>
                                                <option value="" selected disabled>Choose</option>
                                                @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_description }}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please choose product.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="stocks_for_slip">Stocks</label>
                                            <input type="number" class="form-control" id="stocks_for_slip" name="stocks_for_slip" readonly>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="quantity_out">Out</label>
                                            <input type="number" class="form-control" id="quantity_out" name="quantity_out" placeholder="e.g. 10" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="quantity_return">Return</label>
                                            <input type="number" class="form-control" id="quantity_return" name="quantity_return" placeholder="e.g. 5">
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_stock_delivered">Total Stock Delivered</label>
                                            <input type="number" class="form-control" id="total_stock_delivered" name="total_stock_delivered" readonly>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remaining_stock_for_slip">Remaining Stocks</label>
                                            <input type="number" class="form-control" id="remaining_stock_for_slip" name="remaining_stock_for_slip" style="color: red;" readonly>
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
        <!-- modal add new stock show -->
        <div class="modal fade" id="modalAddNewStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Stock details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAddNewStock" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <input type="hidden" id="id_for_add_new_stock" name="id_for_add_new_stock">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_id_for_add_new_stock">Product</label>
                                            <input type="hidden" id="product_id_for_add_new_stock_for_saving" name="product_id_for_add_new_stock_for_saving">
                                            <select class="form-control custom-select" name="product_id_for_add_new_stock" id="product_id_for_add_new_stock" disabled>
                                                <option value="" selected disabled>Choose</option>
                                                @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->product_description }}</option>
                                                @endforeach
                                            </select>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please choose product.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="old_stock">Old Stock</label>
                                            <input type="number" class="form-control" id="old_stock" name="old_stock" readonly>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new_bxs">New (Boxes/Cases)</label>
                                            <input type="number" class="form-control" id="new_bxs" name="new_bxs" placeholder="e.g. 225" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new_pcs">New (Pcs/box or Btl/cases)</label>
                                            <input type="number" class="form-control" id="new_pcs" name="new_pcs" placeholder="e.g. 30" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter valid number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new_remainder">Remainder (optional)</label>
                                            <input type="number" class="form-control" id="new_remainder" name="new_remainder" placeholder="optional">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_stock">Total stock</label>
                                            <input type="number" class="form-control" id="total_stock" name="total_stock" readonly>
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
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item" id="printSlip">Print Slip</a>
                                <a href="javascript:void(0);" class="dropdown-item" id="exportReport">Export Report</a>
                            </div>
                        </div>
                        <h4 class="card-title mb-4">All Stocks</h4>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>PRODUCT</th>
                                        <th>STOCKS</th>
                                        <th>OUT</th>
                                        <th>RETURN</th>
                                        <th>TOTAL_STOCK_DELIVERED</th>
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
    let deleteStockURL = editStockURL;
    let updateStockURL = editStockURL;
    let clearStockURL = editStockURL;
    let addNewStockURL = "/admin/warehouse";
</script>
<script src="{{ url('backend/assets/js/warehouse.min.js') }}"></script>
<script src="{{ url('backend/assets/js/print-warehouse.min.js') }}"></script>
@endsection