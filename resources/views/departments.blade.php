@extends('layouts.root-layout')
@section('page-name', 'Departemen')

@section('content')
<div class="row mt-4">
    <div class="col-md-8">
        <div class="card pt-4">
            <div class="card-body">
                <h4>Daftar Departemen</h4>
                <button class="btn btn-secondary mb-3" id="reload">Reload Data</button>
                <table class="table table-bordered table-striped" id="tabelorder">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dept-body">
                        <tr><td colspan="5">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card pt-4">
            <div class="card-body">
                <h4 id="form-title">Tambah Departemen</h4>
                <form id="create-form">
                    <input type="hidden" id="department_id">
                    <div class="mb-3">
                        <label for="department_name" class="form-label">Nama Departmen</label>
                        <input type="text" class="form-control" id="department_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_clock_in_time" class="form-label">Jam Masuk</label>
                        <input type="time" class="form-control" id="max_clock_in_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_clock_out_time" class="form-label">Jam Pulang</label>
                        <input type="time" class="form-control" id="max_clock_out_time" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit-button">Tambah</button>
                    <button type="button" class="btn btn-secondary" id="cancel-edit" style="display:none;">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/pages/department.js') }}"></script>
@endsection
