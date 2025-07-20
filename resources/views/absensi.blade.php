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
<script>
    const root_url = "http://localhost:8080/"
    document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("employee-select");
    const btnIn = document.getElementById("btn-clock-in");
    const btnOut = document.getElementById("btn-clock-out");

    axios.get(`${root_url}employees`)
        .then(response => {
            select.innerHTML = `<option disabled selected>Pilih karyawan</option>`;
            response.data.forEach(emp => {
                const option = document.createElement("option");
                option.value = emp.employee_id;
                option.textContent = `${emp.name} (${emp.employee_id}) - ${emp.department.department_name}`;
                select.appendChild(option);
            });
        })
        .catch(error => {
            Swal.fire("Gagal memuat karyawan", error.message, "error");
        });

    function resetDropdown() {
        select.selectedIndex = 0;
    }

    btnIn.addEventListener("click", function () {
        const id = select.value;
        if (!id) return Swal.fire("Pilih karyawan dulu", "", "warning");

        axios.post(`${root_url}absence`, { employee_id: id })
            .then(res => {
                Swal.fire("Berhasil!", res.data.message, "success");
                resetDropdown();
            })
            .catch(err => {
                const msg = err.response?.data?.error || "Terjadi kesalahan saat absen masuk.";
                Swal.fire("Gagal", msg, "error");
            });
    });

    btnOut.addEventListener("click", function () {
        const id = select.value;
        if (!id) return Swal.fire("Pilih karyawan dulu", "", "warning");

        axios.put(`${root_url}absence`, { employee_id: id })
            .then(res => {
                Swal.fire("Berhasil!", res.data.message, "success");
                resetDropdown();
            })
            .catch(err => {
                const msg = err.response?.data?.error || "Terjadi kesalahan saat absen keluar.";
                Swal.fire("Gagal", msg, "error");
            });
    });
});
</script>

@endsection

