@extends('layouts.root-layout')
@section('page-name', 'Karyawan')

@section('content')
<div class="row mt-4">
    <div class="col-md-8">
        <div class="card pt-4">
            <div class="card-body">
                <h4>Daftar Karyawan</h4>
                <button class="btn btn-secondary mb-3" id="reload">Reload Data</button>
                <table class="table table-bordered table-striped" id="tabel-karyawan">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card pt-4">
            <div class="card-body">
                <h4 id="form-title">Tambah Karyawan</h4>
                <form id="create-form">
                    <input type="hidden" id="employee_id_hidden">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">ID</label>
                        <input type="text" class="form-control" id="employee_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Departemen</label>
                        <select class="form-select" id="department_id" required>
                            <option value="">-- Pilih Departemen --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" rows="2" required></textarea>
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
<script src="{{ asset('assets/js/pages/employee.js') }}"></script>
@endsection
