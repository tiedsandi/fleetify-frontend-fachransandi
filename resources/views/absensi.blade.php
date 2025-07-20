@extends('layouts.root-layout')
@section('page-name', 'Absensi')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card pt-4">
            <div class="card-body">
                <h4 class="text-center">Absensi Karyawan</h4>

                <div class="mb-3">
                    <label for="employee-select" class="form-label">Pilih Karyawan</label>
                    <select id="employee-select" class="form-select text-center">
                        <option disabled selected>Loading...</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center gap-2">
                    <button id="btn-clock-in" class="btn btn-success">Absen Masuk</button>
                    <button id="btn-clock-out" class="btn btn-danger">Absen Keluar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/pages/absensi.js') }}"></script>
@endsection

