<div class="card-body">
    <div class="dt-responsive table-responsive">
        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Production Code</th>
                    <th>Project Name</th>
                    <th>Project Code</th>
                    <th>WO Code</th>
                    <th>WO Date</th>
                    <th>WO Status</th>
                    <th>Completion Date</th>
                    <th>Completion Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>

                    <tr  <?php if ($row->transport_flag == 1)
                                    echo 'class=bg-soft-success'; ?>>
                        
                        <td>
                            <?php echo $i;
                            $i++; ?>
                        </td>
                        <td> <?php echo $row->p_code; ?></td>
                        <td> <?php echo $row->project_name; ?></td>
                        <td> <?php echo $row->project_code; ?></td>
                        <td> <?php echo $row->wo_code; ?></td>
                        <td> <?php echo $row->work_order_date; ?></td>


                        <td>
                            <?php echo $row->wo_status; ?>
                        </td>

                        <td>
                            <?php echo date('d-M-Y', strtotime($row->completion_date)); ?>
                        </td>
                        <td>
                            <?php if ($row->qc_approve_flag == 1) : ?>
                                <!-- <p style="color: green;">QC Done &nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d'); ?></p> -->
                                <p style="color: green;">QC Done </p>
                                <?php endif; ?>

                            <?php if ($row->packing_flag == 1) : ?>
                                <p style="color: green;">Packing Done </p>
                            <?php endif; ?>

                            <?php if ($row->transport_flag == 1) : ?>
                                <p  style="color: green;">Transportation Done </p>
                            <?php endif; ?>
                        </td>
                        <td>

                            <?php if ($row->qc_approve_flag == 0): ?>
                                <a href="<?php echo base_url() . 'index.php/Production/qc_approve_production/' . $row->production_id . '/1/'; ?>"
                                    title="QC Done" class="btn btn-sm btn-primary m-b-0" style="font-size: 12px; padding: 5px 10px;">QC Done</a>
                            <?php elseif ($row->qc_approve_flag == 1 && $row->packing_flag == 0): ?>
                                <a href="<?php echo base_url() . 'index.php/Production/packing_approve_production/' . $row->production_id . '/1/'; ?>"
                                    title="Packing Done" class="btn btn-sm btn-primary m-b-0" style="font-size: 12px; padding: 5px 10px;">Packing Done</a>
                            <?php elseif ($row->qc_approve_flag == 1 && $row->packing_flag == 1 && $row->transport_flag == 0): ?>
                                <a href="<?php echo base_url() . 'index.php/Production/transport_approve_production/' . $row->production_id . '/1/'; ?>"
                                    title="Sending To Transportation" class="btn btn-sm btn-primary m-b-0" style="font-size: 12px; padding: 5px 10px;">Send To Transportation</a>
                            <?php endif; ?>


                            <a href="<?php echo base_url() . 'index.php/Production/edit_production/' . $row->production_id; ?>"
                                title="Edit">Edit</a>
                            <!-- <a href="<?php echo base_url() . 'index.php/Project/delete_production/' . $row->production_id; ?>"
                                title="Delete" onclick="return confirmcancel(<?php echo $row->production_id; ?>);"><?php echo $this->session->userdata('delete_icon'); ?></a> -->
                                
                                <?php if ($row->qc_approve_flag != 1): ?>
                                    <a href="<?php echo base_url() . 'index.php/Production/delete_production/' . $row->production_id; ?>"
                                    title="Delete" 
                                    onclick="return confirmcancel(<?php echo $row->production_id; ?>);">
                                    Delete
                                    </a>
                                <?php endif; ?>
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

<!-- Static Table End -->



<script>
    function confirmcancel(tid) {
        var r = confirm("Are you sure you want to Delete Record?");
        if (r == true) {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
                type: "POST",
                data: {
                    table_name: 'project_production',
                    where_key: 'production_id',
                    where_val: tid
                },
                success: function(msg) {
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