<div class="container mt-5">
        <h2 class="text-center">Upload File</h2>
        <form class="file-upload-form">
            <div class="form-group">
                <label for="file" class="file-label">Choose File</label>
                <input type="file" id="file" class="form-control-file" onchange="showFileName()">
                <small class="form-text text-muted" id="file-name">No file chosen</small>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Upload</button>
        </form>

        <div class="table-container mt-4">
            <h3 class="text-center">Uploaded Files</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Size</th>
                        <th>Date Uploaded</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>example-file.pdf</td>
                        <td>2 MB</td>
                        <td>October 1, 2024</td>
                        <td><button class="btn btn-danger btn-sm">Delete</button></td>
                    </tr>
                    <!-- More rows can be added here -->
                </tbody>
            </table>
        </div>
    </div>