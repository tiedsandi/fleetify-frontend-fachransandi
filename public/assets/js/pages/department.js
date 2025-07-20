const root_url =
    $('meta[name="department-api"]').attr("content") ||
    "http://localhost:8080/departments";

function loadDepartments() {
    $.ajax({
        url: root_url,
        type: "GET",
        success: function (data) {
            let html = "";
            data.forEach(function (dept) {
                html += `
                    <tr>
                        <td>${dept.ID}</td>
                        <td>${dept.department_name.toUpperCase()}</td>
                        <td>${dept.max_clock_in_time}</td>
                        <td>${dept.max_clock_out_time}</td>
                        <td>
                            <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="${
                                dept.ID
                            }">Edit</button>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="${
                                dept.ID
                            }">Hapus</button>
                        </td>
                    </tr>`;
            });
            $("#dept-body").html(html);
        },
        error: function () {
            $("#dept-body").html(
                '<tr><td colspan="5">Gagal ambil data</td></tr>'
            );
        },
    });
}

function resetForm() {
    $("#create-form")[0].reset();
    $("#department_id").val("");
    $("#form-title").text("Tambah Department");
    $("#submit-button").text("Tambah");
    $("#cancel-edit").hide();
}

function handleFormSubmit() {
    $("#create-form").on("submit", function (e) {
        e.preventDefault();

        const id = $("#department_id").val();
        const data = {
            department_name: $("#department_name").val(),
            max_clock_in_time: $("#max_clock_in_time").val(),
            max_clock_out_time: $("#max_clock_out_time").val(),
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
                        ? "Department berhasil diupdate!"
                        : "Department berhasil ditambahkan!",
                    timer: 2000,
                    showConfirmButton: false,
                });
                resetForm();
                loadDepartments();
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
            success: function (dept) {
                $("#department_id").val(dept.ID);
                $("#department_name").val(dept.department_name);
                $("#max_clock_in_time").val(dept.max_clock_in_time);
                $("#max_clock_out_time").val(dept.max_clock_out_time);
                $("#form-title").text("Edit Department");
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
                            text: "Department berhasil dihapus!",
                            timer: 1500,
                            showConfirmButton: false,
                        });
                        loadDepartments();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text:
                                xhr.responseJSON?.error ||
                                "Gagal menghapus department.",
                        });
                    },
                });
            }
        });
    });
}

$(document).ready(function () {
    loadDepartments();
    $("#reload").click(loadDepartments);
    $("#cancel-edit").click(resetForm);
    handleFormSubmit();
    handleEditClick();
    handleDeleteClick();
});
