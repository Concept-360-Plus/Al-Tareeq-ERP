<style>
 .dataTables_wrapper .dataTables_length select.form-control,
.dataTables_wrapper .dataTables_filter input.form-control {
    display: inline-block !important;
    width: auto !important;
    height: 34px;
    padding: 6px 12px;
    vertical-align: middle;
}

.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
}

.dataTables_wrapper .dataTables_length {
    float: left;
}

.dataTables_wrapper .dataTables_filter label,
.dataTables_wrapper .dataTables_length label {
    font-weight: normal;
}
.buttons-excel{
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}
.buttons-print{
    padding-left: 18px !important;
    margin-right: auto;
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
    margin-left:10px !important;
}
.left{
    margin-left:14px !important;
}
</style>
<link rel="stylesheet" href="<?= base_url('assets/datatables/buttons.dataTables.min.css');?>">
<script src="<?= base_url('assets/datatables/dataTables.buttons.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/jszip.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/buttons.html5.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/buttons.print.min.js');?>"></script>
<div class="x_panel">
    <div class="row">
    <div class="col-md-4 left">
        <label>Project</label>
        <select id="project_filter" class="form-control">
            <option value="">All Projects</option>
            <?php foreach($project_list as $project){ ?>
                <option value="<?= $project->project_name; ?>">
                    <?= $project->project_code.' - '.$project->project_name; ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

<br>
    <table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead><tr><th>#<th>Code</th><th>Project</th><th>Customer</th><th>Approver</th><th>Start</th><th>End</th><th>Status</th><th>Progress</th><th>Current Status</th><th>Created</th></tr></thead>
        <tbody>
            <?php 
            if(!empty($projects)):
                foreach($projects  as $i =>$p){ ?>
                <tr>
                <td><?= $i+1 ?></td><td><a href="<?= base_url('index.php/Project/project_dashboard/'. $p->project_id) ?>" title="View Project dashboard"><?= $p->project_code ?></a></td><td><?= $p->project_name ?></td><td><?= $p->customer_name ?></td><td><?= $p->manager ?></td><td><?php echo date('d-m-Y', strtotime($p->start_date)); ?></td><td><?php echo date('d-m-Y',strtotime($p->end_date)) ?></td><td><?= $p->status ?></td>
                <td><div style="background:#ddd;width:100px"><div style="background:green;color:#fff;width:<?= (int)$p->progress_percentage ?>%"><?= (int)$p->progress_percentage ?>%</div></div></td>
                <td><?= $p->current_status ?></td><td  data-order="<?php echo strtotime($p->created_on); ?>"><?php echo date('d-m-Y H:i:s', strtotime($p->created_on)); ?></td>
                </tr><?php 
                } 
            else: 
                echo '<tr><td colspan="10">No records found</td></tr>';
            endif; ?>
       </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>//$('#tbl').DataTable();
    /*$(document).ready(function(){
        $('#datatable-responsive1').DataTable({
                order: [[0, 'desc']],
                initComplete: function () {
                    $('.dataTables_filter input')
                        .addClass('form-control');

                    $('.dataTables_length select')
                        .addClass('form-control');
                }
            });

            $('#project_filter').on('change',function(){
                alert($(this).val());
                table.column(2).search($(this).val()).draw();

            });
     }); 
     */
    $(document).ready(function(){

        var table=$('#datatable-responsive1').DataTable({
            order:[[10,'desc']],
            dom:'lBfrtip',
            buttons:[
                {
                    extend:'excelHtml5',
                    title:'Project Progress Report'
                },
                {
                    extend:'print',
                    title:'Project Progress Report'
                }
            ]

        });

        $('#project_filter').on('change',function(){

            table.column(1).search($(this).val()).draw();

        });

    });  
    </script>
</div>