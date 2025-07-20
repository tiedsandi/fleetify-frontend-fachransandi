document.addEventListener("DOMContentLoaded", function () {
    const absenceUrl =
        document.querySelector('meta[name="absence-api"]')?.content ||
        "http://localhost:8080/absence";
    const departmentUrl =
        document.querySelector('meta[name="department-api"]')?.content ||
        "http://localhost:8080/departments";

    let absenceTable;

    function fetchDepartments() {
        $.get(departmentUrl, function (data) {
            const options = [
                '<option value="">-- Semua Departemen --</option>',
            ].concat(
                data.map(
                    (dept) =>
                        `<option value="${
                            dept.ID
                        }">${dept.department_name.toUpperCase()}</option>`
                )
            );
            $("#filter-department").html(options.join(""));
        });
    }

    function fetchAbsences() {
        const date = $("#filter-date").val();
        const deptId = $("#filter-department").val();
        let url = absenceUrl;

        const params = [];
        if (date) params.push(`tanggal=${date}`);
        if (deptId) params.push(`department_id=${deptId}`);
        if (params.length > 0) url += "?" + params.join("&");

        $.get(url, function (res) {
            absenceTable.clear();

            const data = res?.data || [];

            if (data.length === 0) {
                absenceTable.row
                    .add(["-", "-", "Tidak ada data", "-", "-", "-"])
                    .draw();
                return;
            }

            const rows = data.map((item) => [
                item.employee_id,
                item.name,
                item.department?.toUpperCase() || "-",
                item.date,
                item.type,
                item.status,
            ]);

            absenceTable.rows.add(rows).draw();
        }).fail(() => {
            absenceTable.clear().draw();
            absenceTable.row
                .add(["-", "-", "Gagal mengambil data", "-", "-", "-"])
                .draw();
        });
    }

    absenceTable = $("#absence-table").DataTable({
        destroy: true,
        data: [],
        columns: [
            { title: "ID" },
            { title: "Nama" },
            { title: "Departemen" },
            { title: "Waktu" },
            { title: "Jenis" },
            { title: "Status" },
        ],
    });

    fetchDepartments();
    fetchAbsences();

    $("#reload-logs").click(fetchAbsences);
    $("#reset-filters").click(() => {
        $("#filter-date").val("");
        $("#filter-department").val("");
        fetchAbsences();
    });
});
