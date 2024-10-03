import { _executeRequest, hostname, ExcelValidation } from "./functions.js";
$(() => {
    forms();
})

const forms = () => {
    $("#frm-login").submit((e) => {
        e.preventDefault();
        const data = {
            "username": $("#username").val(),
            "password": $("#password").val(),
        }
        if (!data.username || !data.password) {
            swal.fire({
                title: "Error",
                text: "Please fill in all fields",
                icon: "error",
            })
            return;
        }

        _executeRequest("login/login", "POST", data, (res) => {

            if (!res.Error && res.result.Error) {
                swal.fire({
                    title: "Warning",
                    text: res.result.msg,
                    icon: "warning",
                })
                return;
            }

            if (!res.Error && !res.result.Error) {
                if (res.result.isValid) {
                    window.location.href = hostname() + "dashboard";
                } else {
                    swal.fire({
                        title: "Error",
                        text: "Incorrect Credentials",
                        icon: "error",
                    })
                }
            } else {
                swal.fire({
                    title: "Error",
                    text: "Internal Server Error",
                    icon: "error",
                })
            }
        })
    })


    $("#uploadFrm").submit((e) => {
        e.preventDefault();
        const sheetName = $("#sheetName").val()
        const file = $("#importFile")[0].files[0]
        if (!sheetName || !file) {
            swal.fire({
                title: "warning",
                text: "Please fill in all fields",
                icon: "error",
            })
            return;
        }




        const reader = new FileReader();
        reader.onload = (e) => {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            let sheet;

            //validate  excel sheetname
            if (!workbook.Sheets[sheetName]) {
                swal.fire({
                    icon: "warning",
                    title: "Sheet  not found",
                    text: "Please select a valid sheet.",
                })

                return;
            }

            sheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            console.log(jsonData);

            return;
            //validate excel data
            if (jsonData.length === 0) {
                swal.fire({
                    icon: "warning",
                    title: "Data not  found",
                    text: "Please select a valid sheet with data.",
                });

                return;
            }
            console.log(ExcelValidation(jsonData));
            // return;
            const employee = {
                "employees": JSON.stringify(ExcelValidation(jsonData))

            };
            _executeRequest("dashboard/import", "POST", employee, (res) => {
                if (!res.Error && !res.result.Error) {
                    swal.fire({
                        title: "Success",
                        text: "Import Success",
                        icon: "success",
                    }).then((res) => {
                        window.location.reload();
                    })

                } else {
                    swal.fire({
                        title: "Error",
                        text: "Internal Server Error",
                        icon: "error",
                    })
                }
            })
        };
        reader.readAsArrayBuffer(file);





    })


}