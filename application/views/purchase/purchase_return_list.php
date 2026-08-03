<!-- page content -->

<div class="form-group" role="main">
    <div class="">
        <div class="page-title">
            <div class="clearfix"></div>

            <div class="x_content">

                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>

                        <strong>
                            <i class="fa fa-check-circle"></i>
                        </strong>

                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>


                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>

                        <strong>
                            <i class="fa fa-exclamation-triangle"></i>
                        </strong>

                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>


                <div class="well" style="overflow:auto">
                    <div class="dt-responsive table-responsive">
                        <table
                            id="datatable"
                            class="table table-striped"
                            data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Return Code</th>
                                    <th>Return Date</th>
                                    <th>GRN Code</th>
                                    <th>Supplier</th>
                                    <th>Warehouse</th>
                                    <th>Store</th>
                                    <th>Total Returned Qty</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($purchase_returns as $row) :
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td>
                                            <?= $row->return_code; ?>
                                        </td>
                                        <td>
                                            <?= date('d-M-Y', strtotime($row->return_date)); ?>
                                        </td>
                                        <td>
                                            <?= $row->grn_code; ?>
                                        </td>
                                        <td>
                                            <?= $row->supplier_name; ?>
                                        </td>
                                        <td>
                                            <?= $row->warehouse_name; ?>
                                        </td>
                                        <td>
                                            <?= $row->store_name; ?>
                                        </td>
                                        <td>
                                            <?= $row->total_return_qty; ?>
                                        </td>
                                        <td>
                                            <!-- Print -->
                                            <a
                                                target="_blank"
                                                href="<?= base_url(); ?>index.php/Purchase/print_purchase_return/<?= $row->return_id; ?>"
                                                title="Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            &nbsp;&nbsp;
                                            <!-- View -->
                                            <a
                                                href="<?= base_url(); ?>index.php/Purchase/view_purchase_return/<?= $row->return_id; ?>"
                                                title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            &nbsp;&nbsp;
                                            <!-- Delete -->
                                            <a
                                                href="#"
                                                class="delete-return"
                                                data-return-id="<?= $row->return_id; ?>"
                                                title="Delete">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.delete-return').click(function(e) {
            e.preventDefault();
            let return_id = $(this).data('return-id');
            if (confirm('Are you sure you want to delete this Purchase Return?')) {
                $.ajax({
                    url: "<?= base_url() ?>index.php/Purchase/delete_purchase_return",
                    type: "POST",
                    data: {
                        return_id: return_id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.success) {
                            alert('Purchase Return deleted successfully.');
                            location.reload();
                        } else {
                            alert(res.message);
                        }
                    },
                    error: function() {
                        alert('Something went wrong.');
                    }
                });
            }
        });
    });
</script>