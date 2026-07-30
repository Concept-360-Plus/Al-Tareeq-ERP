<?php
    $page_name = $this->uri->segment(1) . '/' . $this->uri->segment(2);
    $user = $this->session->userdata('user_id');
?>

<div class="x_panel">
    <div class="x_content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <table id="storeTable" class="table table-hover">

            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Branch</th>
                    <th>Warehouse</th>
                    <th>Store</th>
                    <th>Store Type</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $i = 1;
                foreach ($stores as $row) {
                ?>

                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $row->branch_name; ?></td>
                        <td><?= $row->warehouse_name; ?></td>
                        <td><?= $row->store_name; ?></td>
                        <td><?= ucfirst(strtolower($row->store_type)); ?></td>
                        <td>
                            <?php if ($row->status == 1) { ?>
                                <span class="badge badge-success">
                                    Active
                                </span>
                            <?php } else { ?>
                                <span class="badge badge-danger">
                                    Inactive
                                </span>
                            <?php } ?>
                        </td>

                        <td>
                            <a
                                href="<?= base_url('index.php/Setup/edit_store/' . $row->store_id); ?>"
                                class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="deleteStore(<?= $row->store_id; ?>)">
                                Delete
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function deleteStore(id) {
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?= base_url('index.php/Setup/delete_store'); ?>",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",

                success: function(response) {
                    if (response.status == 1) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    }

    $(document).ready(function() {
        $('#storeTable').DataTable({
            pageLength: 10
        });
    });
</script>