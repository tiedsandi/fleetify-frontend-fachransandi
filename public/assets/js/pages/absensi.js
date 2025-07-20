document.addEventListener("DOMContentLoaded", function () {
    const root_url =
        document.querySelector('meta[name="api-base-url"]')?.content ||
        "http://localhost:8080/";

    const select = document.getElementById("employee-select");
    const btnIn = document.getElementById("btn-clock-in");
    const btnOut = document.getElementById("btn-clock-out");

    axios
        .get(`${root_url}employees`)
        .then((response) => {
            select.innerHTML = `<option disabled selected>Pilih karyawan</option>`;
            response.data.forEach((emp) => {
                const option = document.createElement("option");
                option.value = emp.employee_id;
                option.textContent = `${emp.name} (${emp.employee_id}) - ${
                    emp.department?.department_name || "-"
                }`;
                select.appendChild(option);
            });
        })
        .catch((error) => {
            select.innerHTML = `<option disabled selected>Gagal memuat data</option>`;
            Swal.fire("Gagal memuat karyawan", error.message, "error");
        });

    function resetDropdown() {
        select.selectedIndex = 0;
    }

    btnIn.addEventListener("click", function () {
        const id = select.value;
        if (!id) return Swal.fire("Pilih karyawan dulu", "", "warning");

        axios
            .post(`${root_url}absence`, { employee_id: id })
            .then((res) => {
                Swal.fire("Berhasil!", res.data.message, "success");
                resetDropdown();
            })
            .catch((err) => {
                const msg =
                    err.response?.data?.error ||
                    "Terjadi kesalahan saat absen masuk.";
                Swal.fire("Gagal", msg, "error");
            });
    });

    btnOut.addEventListener("click", function () {
        const id = select.value;
        if (!id) return Swal.fire("Pilih karyawan dulu", "", "warning");

        axios
            .put(`${root_url}absence`, { employee_id: id })
            .then((res) => {
                Swal.fire("Berhasil!", res.data.message, "success");
                resetDropdown();
            })
            .catch((err) => {
                const msg =
                    err.response?.data?.error ||
                    "Terjadi kesalahan saat absen keluar.";
                Swal.fire("Gagal", msg, "error");
            });
    });
});
