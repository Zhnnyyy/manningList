import { _executeRequest, hostname, sanitizeHeader, _splitName } from "./functions.js";
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
        const range = $("#range").val()
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
            const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1, defval: "", range: range });
            // console.log(jsonData);
            // return;
            //validate excel data
            if (jsonData.length === 0) {
                swal.fire({
                    icon: "warning",
                    title: "Data not  found",
                    text: "Please select a valid sheet with data.",
                });

                return;
            }

            const keys = jsonData[0];
            const values = jsonData.slice(1);
            let newData = []
            for (let i = 0; i < values.length; i++) {
                let obj = {}
                for (let j = 0; j < keys.length; j++) {
                    if (keys[j] != 'No.') {
                        if (keys[j] != "Employee Name") {
                            obj[sanitizeHeader(keys[j])] = values[i][j]
                        } else {
                            const customName = _splitName(values[i][j])
                            obj["FirstName"] = customName.FirstName
                            obj["MiddleName"] = customName.MiddleName
                            obj["LastName"] = customName.LastName

                        }
                    }
                }
                newData.push(obj)
            }


            let newkeys = ["FirstName", "MiddleName", "Lastname"];
            keys.forEach(oldKeys => {
                if (oldKeys != "No." && oldKeys != "Employee Name") {

                    newkeys.push(sanitizeHeader(oldKeys))
                }
            });

            // console.log(ExcelValidation(jsonData));
            // console.log(newData);
            // return;

            const employees = {
                "employees": newData,
                "keys": newkeys,
            };
            // console.log(newData.length);
            // return;

            _executeRequest("dashboard/import", "POST", employees, (res) => {
                console.log(res);
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