export const _executeRequest = (url, method, data, result) => {
    $.ajax({
        url: url,
        type: method,
        dataType: "json",
        data: data,
        beforeSend: () => {
            swal.fire({
                title: "Loading...",
                text: "Please wait",
                allowOutsideClick: false,
                allowEscapeKey: false,
            })
        },
        success: (response) => {
            swal.close();
            result({ "Error": false, "result": response });
        },
        error: (jqXHR, textStatus, errorThrown) => {
            swal.close();
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            result({ "Error": true, "result": errorThrown })

        }
    })
}

export const hostname = () => {
    return "http://" + window.location.hostname + "/manninglist/public/";
}

export const _splitName = (fullName, row) => {
    if (!fullName) {
        console.log("Name is missing");
        return { Error: "Name is missing" };
    }

    let name = fullName.split(', ');
    if (name.length < 2) {
        return { Error: `Invalid name format->${fullName} at row->${row + 1}. It should be (LASTNAME, FIRSTNAME MIDDLENAME)` };
    }
    let lastName = name[0];
    let otherNames = name[1].split(' ');
    let firstName, middleName;

    if (otherNames.length > 1) {
        middleName = otherNames.pop();
        firstName = otherNames.join(' ');
    } else {
        firstName = otherNames[0];
        middleName = '';
    }

    return {
        firstName: firstName.toUpperCase(),
        middleName: middleName.toUpperCase(),
        lastName: lastName.toUpperCase()
    };
}




export const ExcelValidation = (emp) => {
    let newEmp = [];
    //validate excel data if it is a table of employee
    if (!emp.some(obj => obj.__EMPTY_2 && obj.__EMPTY_2.toUpperCase() == "EMPLOYEE NAME")) {
        swal({
            icon: "warning",
            title: "Data is not valid",
            text: "Please select a valid sheet with data.",
        });
        return;
    }
    for (let i = 0; i < Object.keys(emp).length; i++) {
        if (Object.keys(emp[i]).length >= 8 && emp[i].__EMPTY_2 != "Employee Name") {
            if (emp[i].__EMPTY_2 && emp[i].__EMPTY_2 != "Employee Name") {
                const empName = _splitName(emp[i]?.__EMPTY_2, emp[i].__rowNum__);
                if (empName) {
                    if (empName.Error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: `${empName.Error}. Please fix the issue before proceeding`,
                        });
                        break;
                    }
                }
                newEmp.push({ emp_Id: emp[i]['__EMPTY_1'], ..._splitName(emp[i]?.__EMPTY_2, emp[i].__rowNum__), position: emp[i]['__EMPTY_3'], assignment: emp[i]['__EMPTY_4'], region: emp[i]['__EMPTY_5'], rate: emp[i]['__EMPTY_6'], row: emp[i].__rowNum__ + 1 })
            }
        }
    }
    const filteredEmp = newEmp.filter((item, index, self) => {
        return self.findIndex((t) => t.emp_Id === item.emp_Id) === index;
    });
    // console.log(filteredEmp);
    return filteredEmp;
}


