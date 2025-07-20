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
                    <tbody id="employee-body">
                        <tr><td colspan="6">Loading...</td></tr>
                    </tbody>
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
                        <label for="employee_id" class="form-label">NIP</label>
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
<script>
    var baseUrl = "http://localhost:8080/employees";

    function loadEmployees() {
        $.ajax({
            url: baseUrl,
            type: 'GET',
            success: function (data) {
                let html = '';
                data.forEach(function (emp) {
                    html += `
                        <tr>
                            <td>${emp.employee_id}</td>
                            <td>${emp.name}</td>
                            <td>${emp.department?.department_name?.toUpperCase() || '-'}</td>
                            <td>${emp.address}</td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="${emp.id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${emp.id}">Hapus</button>
                            </td>
                        </tr>`;
                });
                $('#employee-body').html(html);

                $('#tabel-karyawan').DataTable({
                    destroy: true
                });
            },
            error: function () {
                $('#employee-body').html('<tr><td colspan="6">Gagal ambil data</td></tr>');
            }
        });
    }

    function resetForm() {
        $('#create-form')[0].reset();
        $('#employee_id_hidden').val('');
        $('#form-title').text('Tambah Karyawan');
        $('#submit-button').text('Tambah');
        $('#cancel-edit').hide();
    }

    function loadDepartmentsToDropdown() {
        $.ajax({
            url: 'http://localhost:8080/departments',
            type: 'GET',
            success: function (data) {
                $('#department_id').empty()
                let options = '<option value="">-- Pilih Departemen --</option>';
                data.forEach(function (dept) {
                    options += `<option value="${dept.ID}">${dept.department_name.toUpperCase()}</option>`;
                });
                $('#department_id').html(options);
                // console.log(data);
            },
            error: function () {
                console.error("Gagal memuat daftar departemen.");
            }
        });
    }


    $(document).ready(function () {
        loadEmployees();
        loadDepartmentsToDropdown();

        $('#reload').click(loadEmployees);
        $('#cancel-edit').click(resetForm);

        $('#create-form').on('submit', function (e) {
            e.preventDefault();

            const id = $('#employee_id_hidden').val();

            const data = {
                employee_id: $('#employee_id').val(),
                name: $('#name').val(),
                department_id: parseInt($('#department_id').val()),
                address: $('#address').val()
            };

            const url = id ? `${baseUrl}/${id}` : baseUrl;
            const method = id ? 'PUT' : 'POST';
            // console.log(method);

            $.ajax({
                url: url,
                type: method,
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: id ? 'Karyawan berhasil diupdate!' : 'Karyawan berhasil ditambahkan!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    resetForm();
                    loadEmployees();
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON.error || 'Terjadi kesalahan.'
                    });
                }
            });
        });

        $(document).on('click', '.edit-btn', function () {
            const id = $(this).data('id');
            $.ajax({
                url: `${baseUrl}/${id}`,
                type: 'GET',
                success: function (emp) {
                    $('#employee_id_hidden').val(emp.id);
                    $('#employee_id').val(emp.employee_id);
                    $('#name').val(emp.name);
                    $('#department_id').val(emp.department_id);
                    $('#address').val(emp.address);
                    $('#form-title').text('Edit Karyawan');
                    $('#submit-button').text('Update');
                    $('#cancel-edit').show();
                }
            });
        });

        // Delete
        $(document).on('click', '.delete-btn', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data tidak bisa dikembalikan setelah dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/${id}`,
                        type: 'DELETE',
                        success: function () {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Karyawan berhasil dihapus!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadEmployees();
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON.error || 'Gagal menghapus karyawan.'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
