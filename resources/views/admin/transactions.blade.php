@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Transaction</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">JSVN</a></li>
                            <li class="breadcrumb-item active">Transaction</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row d-flex align-items-center">
            <div class="col-xl-3 d-flex justify-content-start">
                <button id="btnTransact" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTransact">
                    New transaction
                </button>
            </div>
        </div>
        <!-- modal transact show -->
        <div class="modal fade" id="modalTransact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formTransaction" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="transaction_no">TRANSACTION NUMBER: </label>
                                    <input type="text" class="form-control" id="transaction_no" name="transaction_no" required readonly>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="transaction_date">Transaction Date</label>
                                    <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter date.
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="outlet_id">Outlet</label>
                                    <select class="form-control custom-select" name="outlet_id" id="outlet_id" required>
                                        <option value="" selected disabled>Choose</option>
                                        @foreach ($outlets as $outlet) : ?>
                                        <option value="{{ $outlet->id }}">{{ $outlet->outlet_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please choose outlet.
                                    </div>
                                    <input type="hidden" id="outlet_name" name="outlet_name">
                                </div>
                                <div class="form-group mt-2">
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
                                    <input type="hidden" id="product_description" name="product_description">
                                </div>
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="unit_price">Unit Price</label>
                                            <input type="text" class="form-control" id="unit_price" name="unit_price" required readonly>
                                        </div>
                                        <div class="col-6">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please quantity.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3"></div>
                                <h4 class="card-title">Added list</h4>
                                <div class="table-responsive">
                                    <table id="dataTableDraft" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th>OUTLET</th>
                                                <th>DESC</th>
                                                <th>UNIT_PRICE</th>
                                                <th>QTY</th>
                                                <th>SUB_TOTAL</th>
                                            </tr>
                                        </thead><!-- end thead -->
                                        <tbody>

                                        </tbody>
                                    </table> <!-- end table -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-success" id="btnAdd" value="Add item">
                                <input type="submit" class="btn btn-primary" id="btnSubmit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
        <!-- modal edit show -->
        <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Product details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEdit" class="needs-validation" novalidate>
                            @csrf
                            <div class="card-body">
                                <input type="hidden" id="idForUpdating" name="idForUpdating">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="prod_desc">Product Description: </label>
                                            <input type="text" class="form-control" id="prod_desc" name="prod_desc" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="u_price">Unit Price: </label>
                                            <input type="number" class="form-control" id="u_price" name="u_price" step="0.01" min="0" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="qtty">Quantity: </label>
                                            <input type="number" class="form-control" id="qtty" name="qtty" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="on_hand">On hand: </label>
                                            <input type="number" class="form-control" id="on_hand" name="on_hand" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="sold">Sold: </label>
                                            <input type="number" class="form-control" id="sold" name="sold" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row d-flex align-items-center">
                                    <div class="col-6 d-flex justify-content-start">
                                        <label for="sold" style="color: red;">Sub total: <span id="sub_total" name="sub_total" style="color: red;"></span></label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <input type="submit" class="btn btn-success" value="Save">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->
        <div class="mt-3"></div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="company_name">COMPANY NAME:</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="company_name" name="company_name" readonly>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 mt-2">
                                <label for="filter_date">DATE:</label>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="filter_date" name="filter_date" value="{{ date('Y-m-d') }}">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select date.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="filter_outlet_id">OUTLET NAME:</label>
                                <select class="form-control custom-select" name="filter_outlet_id" id="filter_outlet_id" required>
                                    <option value="" selected disabled>Choose</option>
                                    @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->outlet_name }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please choose outlet.
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 mt-2">
                                <label for="outlet_address">ADDRESS:</label>
                                <div class="form-group">
                                    <input type="hidden" id="outlet_name_for_print" name="outlet_name_for_print">
                                    <input type="text" class="form-control" id="outlet_address" name="outlet_address" readonly>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select address.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="term">TERM:</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="term" name="term" readonly>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 mt-2">
                                <label for="trans_no">TRANS NO:</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="trans_no" name="trans_no" readonly>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please enter transaction number.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2"></div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item" id="printReport">Print Report</a>
                                <a href="javascript:void(0);" class="dropdown-item" id="exportReport">Export Report</a>
                            </div>
                        </div>
                        <h4 class="card-title mb-4">Latest Transactions</h4>
                        <div class="table-responsive">
                            <table id="dataTableSubmitted" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>DATE DELIVERED</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>ON_HAND</th>
                                        <th>SOLD</th>
                                        <th>UNIT_PRICE</th>
                                        <th>SUB_TOTAL</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead><!-- end thead -->
                            </table> <!-- end table -->
                        </div>
                        <div class="row card-footer mt-3 d-flex">
                            <div class="col-8 d-flex justify-content-end">
                                <h3 id="total_price"></h3>
                            </div>
                            <div class="col-4">
                            </div>
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div>
</div>
<script>
    let storeTransactionURL = "{{ route('admin.transactions.store') }}";
    let getTransactionURL = "{{ route('admin.transactions.getTransactions') }}";
    let getOutletNameAddressURL = "/get-outlet-name-address";
    let getOutletNameURL = "/get-outlet-name";
    let updateOnhandURL = "/admin/transactions";
    let getUnitPriceAndDescriptionURL = "/get-unit-price-and-description";
    let getTransactionNoURL = "/get-transaction-number";
</script>
<script src="{{ url('backend/assets/js/transactions.js') }}"></script>
<script src="{{ url('backend/assets/js/print-transaction.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#on_hand').on('input', function() {
            let u_price = parseFloat($('#u_price').val()) || 0;
            let quantity = parseInt($('#qtty').val()) || 0;
            let on_hand = parseInt($('#on_hand').val()) || 0;
            let sold = quantity - on_hand;
            $('#sold').val(sold);
            let sub_total = u_price * sold;
            $('#sub_total').text(sub_total);
        });
    });
</script>
@endsection