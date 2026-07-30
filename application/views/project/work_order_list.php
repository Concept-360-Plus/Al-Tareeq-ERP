<div class="row">
<div class="col-md-12">
<div class="x_panel">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success') ?>
    </div>
    <?php endif; ?>
        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Project Name</th>
                    <th>Project Code</th>
                    <th>WO Code</th>

                    <!-- <th> Department</th> -->
                    <th>Work Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>

                    <tr <?php if ($row->approve_flag == 1)
                        echo 'class=bg-soft-success'; ?>     <?php if ($row->approve_flag == 0)
                                   echo 'class=bg-soft-danger'; ?>>
                        <td>
                            <?php echo $i;
                            $i++; ?>
                        </td>
                        <td>
                            <?php echo $row->project_name; ?>
                        </td>

                        <td>
                            <?php echo $row->project_code; ?>
                        </td>
                        <td>
                            <?php echo $row->wo_code; ?>
                        </td>
                        <!-- <td>
                            <?php foreach ($dep_records as $s): ?>
                                <?php if ($row->dept_id == $s->dept_id): ?>
                                    <?php echo $s->dept_name; ?>
                                    <?php break; // Exit the loop once the match is found ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td> -->

                        <td>
                            <?php echo date('d-M-Y', strtotime($row->work_order_date)); ?>
                        </td>


                        <td>
                            
                            <a href="<?php echo base_url() . 'index.php/Project/edit_work_order/' . $row->work_id; ?>"
                                title="Edit" class="btn btn-primary btn-sm"><?php //echo $this->session->userdata('edit_icon'); ?> Edit</a>
                            <a href="<?php echo base_url() . 'index.php/Project/delete_work_order/' . $row->work_id; ?>"
                                title="Delete" class="btn btn-danger btn-sm" onclick="return confirmcancel(<?php echo $row->work_id; ?>);"><?php //echo $this->session->userdata('delete_icon'); ?>Delete</a>
                            <!--<a class="btn btn-primary btn-sm" href="<?php echo base_url() . 'index.php/Project/print_work_order/' . $row->work_id; ?>"
                                title="Print" target="_blank"><i class="fa fa-print" style="font-size:18px"></i></a>-->

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Static Table End -->



<script>
    function confirmcancel(tid) {
        var r = confirm("Are you sure you want to Delete Record?");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
                type: "POST",
                data: {
                    table_name: 'project_work_order',
                    where_key: 'work_id',
                    where_val: tid
                },
                success: function (msg) {
                    if (msg == 1) {
                        // alert("Record deleted");
                        window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
                    } else {
                        alert("Can't Delete record. Data already exist!!!");
                    }
                },
            });
            return true;
        } else
            return false;

    }
</script>