<div class="x_panel">
    <div class="x_title">
        <h2>Project Manpower</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="row mb-3">
            <div class="col-md-12 text-right">
                <a href="<?= base_url('index.php/Project/add_project_manpower/'.$project_id) ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Add Manpower
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Manpower Code</th>
                        <th>Project</th>
                        <th>Designation</th>
                        <th>Employee</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resources)) { foreach ($resources as $index => $row) { ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($row['manpower_code'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['project_code'] ?? '') . ' - ' . htmlspecialchars($row['project_name'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['designation_name'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['employee_name'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['status'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['remarks'] ?? ''); ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#manpowerDetailsModal" data-id="<?= $row['manpower_id']; ?>">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="<?= base_url('index.php/Project/edit_project_manpower/'.$project_id.'/'.$row['manpower_id']) ?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?= base_url('index.php/Project/delete_project_manpower/'.$project_id.'/'.$row['manpower_id']) ?>"
                                               onclick="return confirm('Are you sure you want to delete this manpower record?');">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php } } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">No manpower found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="manpowerDetailsModal" tabindex="-1" role="dialog" aria-labelledby="manpowerDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manpowerDetailsModalLabel">Manpower Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="manpowerDetailsBody">
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    $('#manpowerDetailsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);

        if (!id) {
            modal.find('#manpowerDetailsBody').html('<div class="text-danger">No manpower selected.</div>');
            return;
        }

        modal.find('#manpowerDetailsBody').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');

        $.ajax({
            url: '<?= base_url("index.php/Project/view_project_manpower_details") ?>/' + id,
            type: 'GET',
            dataType: 'html',
            cache: false,
            success: function (response) {
                modal.find('#manpowerDetailsBody').html(response);
            },
            error: function () {
                modal.find('#manpowerDetailsBody').html('<div class="text-danger">Unable to load manpower details.</div>');
            }
        });
    });
});
</script>
