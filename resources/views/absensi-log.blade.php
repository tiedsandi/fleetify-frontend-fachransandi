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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Waktu</th>
                            <th>Jenis</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="absence-body">
                        <tr><td colspan="7">Loading...</td></tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const absenceUrl = "http://localhost:8080/absence";
    const departmentUrl = "http://localhost:8080/departments";

    let absenceTable;

    function fetchDepartments() {
        $.get(departmentUrl, function (data) {
            const options = ['<option value="">-- Semua Departemen --</option>']
                .concat(data.map(dept => `<option value="${dept.ID}">${dept.department_name.toUpperCase()}</option>`));
            $('#filter-department').html(options.join(''));
        });
    }

    function fetchAbsences() {
        const date = $('#filter-date').val();
        const deptId = $('#filter-department').val();
        let url = absenceUrl;

        const params = [];
        if (date) params.push(`tanggal=${date}`);
        if (deptId) params.push(`department_id=${deptId}`);
        if (params.length > 0) url += '?' + params.join('&');

        $.get(url, function (res) {
            absenceTable.clear();

            const data = res?.data || [];

            if (data.length === 0) {
                absenceTable.row.add(['-', '-', 'Tidak ada data', '-', '-', '-']).draw();
                return;
            }

            const rows = data.map(item => [
                item.employee_id,
                item.name,
                item.department?.toUpperCase() || '-',
                item.date,
                item.type,
                item.status
            ]);

            absenceTable.rows.add(rows).draw();
        }).fail(() => {
            absenceTable.clear().draw();
            absenceTable.row.add(['-', '-', 'Gagal mengambil data', '-', '-', '-']).draw();
        });
    }

    $(function () {
        absenceTable = $('#absence-table').DataTable({
            destroy: true,
            data: [],
            columns: [
                { title: "NIP" },
                { title: "Nama" },
                { title: "Departemen" },
                { title: "Waktu" },
                { title: "Jenis" },
                { title: "Status" }
            ]
        });

        fetchDepartments();
        fetchAbsences();

        $('#reload-logs').click(fetchAbsences);
        $('#reset-filters').click(() => {
            $('#filter-date').val('');
            $('#filter-department').val('');
            fetchAbsences();
        });
    });
</script>
@endsection


