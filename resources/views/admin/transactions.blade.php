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
        <!-- modal show -->
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
                                <input type="hidden" id="id" name="id">
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
                                                <th>DESCRIPTION</th>
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
                                <input type="button" class="btn btn-primary" id="btnAdd" value="Add">
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
                    <div class="card-header">
                        <div class="row mt-2 d-flex align-items-center">
                            <div class="col-2 d-flex">
                                <label for="company_name">COMPANY NAME:</label>
                            </div>
                            <div class="col-3 d-flex justify-content-start">
                                <select class="form-control custom-select" name="company_name" id="company_name">
                                    <option value="" selected disabled>Choose</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please choose company.
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-end">
                                <label for="date">DATE:</label>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select date.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center mt-2">
                            <div class="col-2 justify-content-end">
                                <label for="outlet_id">OUTLET NAME:</label>
                            </div>
                            <div class="col-3 justify-content-start">
                                <select class="form-control custom-select" name="outlet_id" id="outlet_id" required>
                                    <option value="" selected disabled>Choose</option>
                                    <?php foreach ($outlets as $outlet) : ?>
                                        <option value="<?= $outlet['id']; ?>"><?= $outlet['outlet_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please choose outlet.
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-end">
                                <label for="term">TERM:</label>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="term" name="term">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select date.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 d-flex align-items-center mt-2">
                            <div class="col-2 justify-content-end">
                                <label for="outlet_address">ADDRESS:</label>
                            </div>
                            <div class="col-3 justify-content-start">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="outlet_address" name="outlet_address" readonly>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select address.
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 d-flex justify-content-end">
                                <label for="transaction_number">TRANS NO:</label>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="transaction_number" name="transaction_number" readonly>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select transaction.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">Print Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
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
                                        <th>UNIT_PRICE</th>
                                        <th>ON_HAND</th>
                                        <th>SOLD</th>
                                        <th>QUANTIY</th>
                                        <th>SUB_TOTAL</th>
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
    let storeTransactionURL = "{{ route('admin.transactions.store') }}";
    let getTransactionURL = "{{ route('admin.transactions.getTransactions') }}";
    let getOutletAddressURL = "/get-outlet-address";
    let getUnitPriceURL = "/get-unit-price";
</script>
<script src="{{ url('backend/assets/js/transactions.js') }}"></script>
@endsection