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

        <table id="warehouseTable"
            class="table table-hover">

            <thead>
                <tr>
                    <th>Sl. No</th>
                    <th>Warehouse</th>
                    <th>Branch</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1;
                foreach ($warehouses as $row) {
                ?>

                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row->warehouse_name; ?></td>
                        <td><?php echo $row->branch_name; ?></td>
                        <td><?php echo $row->warehouse_address; ?></td>
                        <td>
                            <?php
                            if ($row->status == 1) {
                            ?>
                                <span class="badge badge-success">
                                    Active
                                </span>
                            <?php
                            } else {
                            ?>
                                <span class="badge badge-danger">
                                    Inactive
                                </span>
                            <?php
                            }
                            ?>
                        </td>

                        <td>
                            <a
                                href="<?php echo base_url('index.php/Setup/edit_warehouse/' . $row->warehouse_id); ?>"
                                class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="deleteWarehouse(<?php echo $row->warehouse_id; ?>)">
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
    function deleteWarehouse(id) {
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "<?php echo base_url('index.php/Setup/delete_warehouse'); ?>",
                type: "POST",
                data: {
                    id: id
                },
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
        $('#warehouseTable').DataTable({
            pageLength: 10
        });
    });
</script>