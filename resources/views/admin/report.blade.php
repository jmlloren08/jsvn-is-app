@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <div class="row"><!-- start page title -->
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Generate Report</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">JSVN</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div><!-- end page title -->
        <!-- select outlet id -->
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">OUTLET NAME:</label>
                <div class="form-group">
                    <select class="form-control select2" name="filter_outlet_id" id="filter_outlet_id" required>
                        <option value="" selected disabled>Choose</option>
                        @foreach ($outlets as $outlet)
                        <option value="{{ $outlet->id }}">{{ $outlet->outlet_name }}, {{ $outlet->outlet_cities_municipalities }}</option>
                        @endforeach
                    </select>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                    <div class="invalid-feedback">
                        Please choose outlet.
                    </div>
                </div>
            </div>
        </div>
        <!-- end select outlet id -->
        <!-- select TRA number -->
        <div class="row mt-2">
            <div class="col-md-6">
                <label>TRA Number</label>
                <div class="form-group">
                    <select name="filter_tra_number[]" id="filter_tra_number" class="select2 @if ($errors->has('filter_tra_number')) is-invalid @endif" multiple="multiple" data-placeholder="Search TRA number" style="width: 100%;">
                    </select>
                    @if ($errors->has('filter_tra_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('filter_tra_number') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- end select TRA number -->
        <div class="row mt-3">
            <div class="col-xl-3 justify-content-start">
                <button id="btnGenerateReport" type="button" class="btn btn-secondary">
                    Generate
                </button>
            </div>
        </div>
        <!-- end add new -->
        <div class="mb-3"></div>
        <!-- datatable section -->
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
                        <h4 class="card-title mb-4">List</h4>
                        <div class="table-responsive">
                            <table id="dataTableGenerateReport" class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                <thead class="table-light">
                                    <!-- <tr id="resiboHeaders">
                                    </tr> -->
                                </thead>
                                <tbody id="dynamicRows">
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end section -->
    </div>
</div>
<script>
    let generateReportURL = "/generate-report";
    let getTRANoURL = "/getTRANo";
</script>
<script src="{{ url('backend/assets/js/generate-report.js') }}"></script>
@endsection