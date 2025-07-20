const root_url =
    $('meta[name="employee-api"]').attr("content") ||
    "http://localhost:8080/employees";
const department_url =
    $('meta[name="department-api"]').attr("content") ||
    "http://localhost:8080/departments";

let dataTable;

function loadEmployees() {
    $.ajax({
        url: root_url,
        type: "GET",
        success: function (data) {
            let rows = data.map((emp) => [
                emp.employee_id,
                emp.name,
                emp.department?.department_name?.toUpperCase() || "-",
                emp.address,
                `
                <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="${emp.id}">Edit</button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="${emp.id}">Hapus</button>
                `,
            ]);

            if (!dataTable) {
                dataTable = $("#tabel-karyawan").DataTable({
                    data: rows,
                    columns: [
                        { title: "ID" },
                        { title: "Nama" },
                        { title: "Departemen" },
                        { title: "Alamat" },
                        { title: "Aksi", orderable: false },
                    ],
                });
            } else {
                dataTable.clear().rows.add(rows).draw();
            }
        },
        error: function () {
            if (dataTable) dataTable.clear().draw();
            $("#employee-body").html(
                '<tr><td colspan="6">Gagal ambil data</td></tr>'
            );
        },
    });
}

function resetForm() {
    $("#create-form")[0].reset();
    $("#employee_id_hidden").val("");
    $("#form-title").text("Tambah Karyawan");
    $("#submit-button").text("Tambah");
    $("#cancel-edit").hide();
}

function loadDepartmentsToDropdown() {
    $.ajax({
        url: department_url,
        type: "GET",
        success: function (data) {
            let options = '<option value="">-- Pilih Departemen --</option>';
            data.forEach(function (dept) {
                options += `<option value="${
                    dept.ID
                }">${dept.department_name.toUpperCase()}</option>`;
            });
            $("#department_id").html(options);
        },
        error: function () {
            console.error("Gagal memuat daftar departemen.");
        },
    });
}

function handleFormSubmit() {
    $("#create-form").on("submit", function (e) {
        e.preventDefault();

        const id = $("#employee_id_hidden").val();
        const data = {
            employee_id: $("#employee_id").val(),
            name: $("#name").val(),
            department_id: parseInt($("#department_id").val()),
            address: $("#address").val(),
        };

        const url = id ? `${root_url}/${id}` : root_url;
        const method = id ? "PUT" : "POST";

        $.ajax({
            url,
            type: method,
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function () {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: id
                        ? "Karyawan berhasil diupdate!"
                        : "Karyawan berhasil ditambahkan!",
                    timer: 2000,
                    showConfirmButton: false,
                });
                resetForm();
                loadEmployees();
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: xhr.responseJSON?.error || "Terjadi kesalahan.",
                });
            },
        });
    });
}

function handleEditClick() {
    $(document).on("click", ".edit-btn", function () {
        const id = $(this).data("id");
        $.ajax({
            url: `${root_url}/${id}`,
            type: "GET",
            success: function (emp) {
                $("#employee_id_hidden").val(emp.id);
                $("#employee_id").val(emp.employee_id);
                $("#name").val(emp.name);
                $("#department_id").val(emp.department_id);
                $("#address").val(emp.address);
                $("#form-title").text("Edit Karyawan");
                $("#submit-button").text("Update");
                $("#cancel-edit").show();
            },
        });
    });
}

function handleDeleteClick() {
    $(document).on("click", ".delete-btn", function () {
        const id = $(this).data("id");
        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data tidak bisa dikembalikan setelah dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${root_url}/${id}`,
                    type: "DELETE",
                    success: function () {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Karyawan berhasil dihapus!",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                        loadEmployees();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text:
                                xhr.responseJSON?.error ||
                                "Gagal menghapus karyawan.",
                        });
                    },
                });
            }
        });
    });
}

$(document).ready(function () {
    loadEmployees();
    loadDepartmentsToDropdown();
    $("#reload").click(loadEmployees);
    $("#cancel-edit").click(resetForm);
    handleFormSubmit();
    handleEditClick();
    handleDeleteClick();
});
