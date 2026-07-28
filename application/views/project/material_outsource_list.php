<div class="row">
<div class="col-md-12">
<div class="x_panel">
    <div class="mb-3">
        <a href="<?php echo base_url() . 'index.php/Project/material_outsource_processing'; ?>"
            class="btn btn-primary btn-sm">
            <span class="fa fa-plus"></span> Add New
        </a>
    </div>

        <table id="datatable" class="table table-striped" data-toggle="data-table">
            <thead>
                <tr>
                    <th>Sr No</th>
                    <th>Project Name/<br>Project Code</th>
                    <th>Supplier Name/ <br>Supplier Code</th>
                    <th>Outsource Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($records as $row) { ?>
                    <tr>
                        <td>
                            <?php echo $i;
                            $i++; ?>
                        </td>
                        <td>
                        <?php echo $row->project_name; ?>/<br> <?php echo $row->project_code; ?> 
                        </td>

                        <td>
                            <?php echo $row->supplier_name; ?> /<br><?php echo $row->supplier_code; ?>
                        </td>

                        <td>
                            <?php echo date('d-M-Y', strtotime($row->outsource_date)); ?>
                        </td>


                        <td>
                                   
                            <a  title="Edit" class="btn btn-primary btn-sm" href="<?php echo base_url() . 'index.php/Project/edit_material_outsource_processing/' . $row->outsource_id; ?>"
                                title="Edit">Edit <?php //echo $this->session->userdata('edit_icon'); ?></a>
                            <a  title="Delete" class="btn btn-danger btn-sm" href="<?php echo base_url() . 'index.php/Project/delete_material_outsource_processing/' . $row->outsource_id; ?>"
                                title="Delete" onclick="return confirmcancel(<?php echo $row->outsource_id; ?>);">Delete <?php //echo $this->session->userdata('delete_icon'); ?></a>
                                <!-- <a href="<?php echo base_url() . 'index.php/Project/print_material_outsource_processing/' . $row->outsource_id; ?>" 
                            title="Print" target="_blank"><i class="fa fa-print" style="font-size:18px"></i></a> -->

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
</div></div>
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
                    table_name: 'project_outsource',
                    where_key: 'outsource_id',
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
