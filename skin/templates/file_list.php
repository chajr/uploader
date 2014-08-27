<div class="alert alert-dismissable" data-auto-close="5000">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">
        ×
    </button>
    <div class="alert-body">
        <div class="error_block">
            <b></b>
            <br/>
            <span></span>
        </div>
    </div>
</div>

<div class="panel panel-default" id="file_list">
    <div class="panel-heading">List of available files</div>
    <div class="panel-body">
        <p>Download or remove files from server.</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="30%">File</th>
                <th width="20%">Size</th>
                <th width="20%">Upload time</th>
                <th width="25%">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($fileList as $file): ?>
            <tr>
                <td><?php echo $file['lp'];?></td>
                <td><?php echo $file['name'];?></td>
                <td><?php echo $file['size'];?></td>
                <td><?php echo $file['creation'];?></td>
                <td data-path="<?php echo $file['name'];?>">
                    <a class="btn btn-primary download"
                       href="/file_handler/download?file=<?php echo $file['encoded'];?>"
                       rel="nofollow">
                        <i class="icon-download"></i>
                        Download
                    </a>

                    <button type="button" class="btn btn-danger remove-file"
                            data-target="modal_remove"
                            data-toggle="modal">
                        <i class="icon-remove-circle"></i>
                        Remove
                    </button>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modal_remove">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Remove file</h4>
            </div>

            <div class="modal-body">
                <p>
                    Do you really want to remove file:
                    <span></span>?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-danger remove-file-execute">
                    Remove file
                </button>
            </div>
        </div>
    </div>
</div>