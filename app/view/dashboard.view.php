<div class="container">
    <?php //print_r($_SESSION['USER'][0]) ?>
    <form id="uploadFrm">
        <!-- <input type="file" name="" id=""> -->
        <div class="row mb-3">
            <input type="text" class="form-control" id="sheetName" placeholder="Sheet name" required
                value="Janitorial Head Office">
        </div>
        <div class="row mb-3">
            <input class="form-control" id="importFile" type="file"
                accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Assignment</th>
                <th>Region</th>
                <th>Rate</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['employee']['result'] as $employee): ?>
                <tr>
                    <td><?= $employee['emp_id'] ?></td>
                    <td><?= "{$employee['emp_lname']}, {$employee['emp_fname']} {$employee['emp_mname']}" ?></td>
                    <td><?= $employee['emp_position'] ?></td>
                    <td><?= $employee['assignment'] ?></td>
                    <td><?= $employee['region'] ?></td>
                    <td><?= $employee['rate'] ?></td>
                    <td><?= $employee['emp_status'] == 1 ? "Active" : "Inactive" ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>