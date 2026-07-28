<style>
    th {
        background: #f5f5f5;
        font-weight: bold;
    }
    td, th {
        vertical-align: middle !important;
    }
    .left{
        margin-left:9px !important;
    }
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
    #project_filter{
        margin-left:-2px;
    }
</style>
<link rel="stylesheet" href="<?= base_url('assets/datatables/buttons.dataTables.min.css');?>">
<script src="<?= base_url('assets/datatables/dataTables.buttons.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/jszip.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/buttons.html5.min.js');?>"></script> 
<script src="<?= base_url('assets/datatables/buttons.print.min.js');?>"></script>
<div class="row">
<div class="col-md-12">
<div class="x_panel">
    <div class="col-md-4 left">
        <label>Project</label>
        <select id="project_filter" class="form-control">
            <option value="">All Projects</option>
            <?php foreach($project_list as $project){ ?>
                <option value="<?= $project->project_name; ?>" data-id='<?=$project->project_id ?>'>
                    <?= $project->project_code.' - '.$project->project_name; ?>
                </option>
            <?php } ?>
        </select>
    </div>
<!-- <div class="x_title">
    <div class="text-end">
        <a href="<?= base_url('index.php/Project/create_material_request') ?>" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i> Create MR
        </a>
    </div>
    <div class="clearfix"></div>
</div> -->

<div class="x_content">

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<table id="datatable-responsive1" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
<tr>
    <th>#</th>
    <th>MR Code</th>
    <th>Project</th>
    <th>Customer</th>
    <th>Branch</th>
    <th>Requested Date</th>
    <th>Required Date</th>
    <th>Initiated By</th>
    <!-- <th>Status</th> -->
    <th width="12%">Action</th>
</tr>
</thead>

<tbody>
<?php if (!empty($material_requests)): ?>
<?php foreach ($material_requests as $i => $mr): ?>
<tr>
    <td><?= $i+1 ?></td>
    <td><?= $mr['mr_code'] ?></td>
    <td><?= $mr['project_name'] ?> (<?= $mr['project_code'] ?>)</td>
    <td><?= $mr['customer_name'] ?></td>
    <td><?= $mr['branch_name'] ?></td>
    <td><?= date('d-m-Y', strtotime($mr['requested_date'])) ?></td>
    <td><?= date('d-m-Y', strtotime($mr['required_date'])) ?></td>
    <td><?= $mr['initiated_by_name'] ?></td>
    <!-- <td>
        <?php
            $status = $mr['status'] ?? 'Pending';
            $badgeClass = 'bg-secondary';

            switch(strtolower($status)){
                case 'pending':
                    $badgeClass = 'bg-warning';
                    break;
                case 'approved':
                    $badgeClass = 'bg-success';
                    break;
                case 'rejected':
                    $badgeClass = 'bg-danger';
                    break;
            }
        ?>
        <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
    </td> -->
    <td>
    <a href="<?= base_url('index.php/Project/edit_material_request/'.$mr['mr_id']) ?>" 
       class="btn btn-info btn-sm">Edit</a>
    
    <a href="<?= base_url('index.php/Project/delete_material_request/'.$mr['mr_id']) ?>" 
       class="btn btn-danger btn-sm" 
       onclick="return confirm('Are you sure you want to delete this Material Request?');">
       Delete
    </a>
</td>

</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="10" class="text-center">No material requests found</td>
</tr>
<?php endif; ?>
</tbody>
</table>

</div>
</div>
</div>
</div>
<script>
    /*if (!$.fn.DataTable.isDataTable('#datatable-responsive')) {
        $('#datatable-responsive').DataTable({
            responsive: true
        });
    } */
     $(document).ready(function(){
        var table=$('#datatable-responsive1').DataTable({
            order:[[1,'desc']],
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
            ],
            responsive: true
        });

        $('#project_filter').on('change',function(){
            table.column(2).search($(this).val()).draw();
        });

    }); 
    $(document).ready(function(){
        var urlParams = new URLSearchParams(window.location.search);
        var project_id = urlParams.get('project_id');
        var project_name = $('#project_filter option[data-id="' + project_id + '"]').val();

        if(project_id)
        {
            // set dropdown value
            $('#project_filter')
                .val(project_name)
                .trigger('change');
        }
    }); 

</script>
