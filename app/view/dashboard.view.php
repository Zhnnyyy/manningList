<div class="container">
    <?php // print_r($data['table']) ?>
    <form id="uploadFrm">
        <!-- <input type="file" name="" id=""> -->
        <div class="row mb-3">
            <input type="text" class="form-control" id="sheetName" placeholder="Sheet name" required
                value="Janitorial Head Office">
        </div>
        <div class="row mb-3">
            <input type="text" class="form-control" id="range" placeholder="Table Range" value="114" required>
        </div>
        <div class="row mb-3">
            <input class="form-control" id="importFile" type="file"
                accept=".csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <div class="table-container">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tableFilterModal">
            Filter Column
        </button>
        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>

                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>