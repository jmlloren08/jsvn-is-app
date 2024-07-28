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
    let getOutletsURL = "{{ route('admin.outlets.getOutlets') }}";
    let storeOutletURL = "{{ route('admin.outlets.store') }}";
    let editOutletURL = "/admin/outlets";
    let updateOutletURL = editOutletURL;
    let deleteOutletURL = editOutletURL;
</script>
<script src="{{ url('backend/assets/js/outlet.min.js') }}"></script>
@endsection