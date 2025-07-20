@extends('layouts.root-layout')
@section('page-name', 'Log Absensi')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card pt-4">
            <div class="card-body">
                <h4>Log Absensi</h4>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="filter-date" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="filter-date">
                    </div>
                    <div class="col-md-3">
                        <label for="filter-department" class="form-label">Departemen</label>
                        <select class="form-select" id="filter-department">
                            <option value="">-- Semua Departemen --</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-secondary me-2" id="reload-logs">Reload</button>
                        <button class="btn btn-outline-secondary" id="reset-filters">Reset</button>
                    </div>
                </div>

                <table class="table table-bordered table-striped" id="absence-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Waktu</th>
                            <th>Jenis</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/pages/absensi-log.js') }}"></script>
@endsection


