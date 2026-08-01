 <script src="<?php echo base_url()."public/assets/chart.js"; ?>"></script>
 <link href="<?php echo base_url()."public/assets/dashboard.css"; ?>" rel="stylesheet"/>
<div class="row">
<div class="x_panel" style="margin-bottom:15px;">
    <div class="x_title">
        <h2><i class="fa fa-bolt"></i> Quick Actions</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <div class="quick-actions">

            <a href="<?php echo base_url().'index.php/Project/add_project' ?>" target="_blank" class="qa-btn qa-primary">
                <i class="fa fa-plus"></i> New Project
            </a>

            <a href="<?= base_url('index.php/Project/work_order'); ?>" target="_blank" class="qa-btn qa-success">
                <i class="fa fa-file-text"></i> Work Order
            </a>

            <a href="<?= base_url('index.php/Project/material_outsource_processing'); ?>" target="_blank" class="qa-btn qa-warning">
                <i class="fa fa-truck"></i> Outsource
            </a>

            <a href="<?php echo base_url().'index.php/Project/create_material_request' ?>" target="_blank" class="qa-btn qa-purple">
                <i class="fa fa-cubes"></i> Material Request
            </a>

            <a href="<?= base_url('index.php/Project/project_progress_list'); ?>" target="_blank" class="qa-btn qa-info">
                <i class="fa fa-line-chart"></i> Progress
            </a>

            <a href="<?= base_url('index.php/Project/project_progress_report'); ?>" target="_blank" class="qa-btn qa-dark">
                <i class="fa fa-bar-chart"></i> Reports
            </a>

        </div>

    </div>
</div>
<div class="col-md-3">
<div class="x_panel tile">
<h3><?= $total_projects ?></h3>
<p>Total Projects</p>
</div>
</div>

<div class="col-md-3">
<div class="x_panel tile">
<h3><?= $active_projects ?></h3>
<p>Active Projects</p>
</div>
</div>

<div class="col-md-3">
<div class="x_panel tile">
<h3><?= $completed_projects ?></h3>
<p>Completed Projects</p>
</div>
</div>

<div class="col-md-3">
<div class="x_panel tile">
<h3><?= $average_progress ?>%</h3>
<p>Average Progress</p>
</div>
</div>

</div>
<!--cost card-->
<div class="row">

<div class="col-md-3">
<div class="x_panel">
<h3>₹ <?= number_format($estimated_cost,2) ?></h3>
<p>Estimated Cost</p>
</div>
</div>

<div class="col-md-3">
<div class="x_panel">
<h3>₹ <?= number_format($material_request_cost,2) ?></h3>
<p>Material Request Cost</p>
</div>
</div>

<!--<div class="col-md-3">
<div class="x_panel">
<h3>₹ <?= number_format($labour_cost,2) ?></h3>
<p>Labour Cost</p>
</div>
</div>-->

<div class="col-md-3">
<div class="x_panel">
<h3>₹ <?= number_format($outsource_cost,2) ?></h3>
<p>Outsource Cost</p>
</div>
</div>

</div>
<!--cost card-->
<!--charts-->
<div class="row">

<div class="col-md-6">
<div class="x_panel">

<div class="x_title">
<h2>Project Status</h2>
</div>

<div class="x_content">
<canvas id="projectStatusChart"></canvas>
</div>

</div>
</div>

<div class="col-md-6">

<div class="x_panel">

<div class="x_title">
<h2>Monthly Projects</h2>
</div>

<div class="x_content">
<canvas id="monthlyChart"></canvas>
</div>

</div>

</div>

</div>
<!--charts-->
<!--work order progress charts-->
<div class="row">

<div class="col-md-6">
<div class="x_panel">
<h2>Work Order Status</h2>
<canvas id="workorderChart"></canvas>
</div>
</div>

<div class="col-md-6">
<div class="x_panel">
<h2>Progress Distribution</h2>
<canvas id="progressChart"></canvas>
</div>
</div>

</div>
<!--work order progress charts-->
<!-- recent projects table -->
 <div class="x_title">
    <h2><i class="fa fa-folder-open"></i> Recent Projects</h2>
    <div class="clearfix"></div>
</div>
 <table class="table table-bordered table-striped"  id="tbl_recent_projects">

<thead>

<tr>

<th>Project</th>

<th>Customer</th>

<th>Start</th>

<th>End</th>

<th>Status</th>

<th>Progress</th>

</tr>

</thead>

<tbody>

<?php foreach($recent_projects as $p){ ?>

<tr>

<td><?= $p->project_code ?></td>

<td><?= $p->customer_name ?></td>

<td><?= date('d-m-Y',strtotime($p->start_date)) ?></td>

<td><?= date('d-m-Y',strtotime($p->end_date)) ?></td>

<td><?= $p->status ?></td>

<td>

<div class="progress">

<div class="progress-bar progress-bar-success"

style="width:<?= $p->progress ?>%">

<?= $p->progress ?>%

</div>

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>
<!-- recent projects table -->
<!-- recent work orders table -->
 <div class="x_title">
    <h2><i class="fa fa-file-text"></i> Recent Work Orders</h2>
    <div class="clearfix"></div>
</div>
<table class="table table-bordered" id="tbl_recent_workorders">

<thead>

<tr>

<th>WO</th>

<th>Project</th>

<th>Date</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php foreach($recent_workorders as $w){ ?>

<tr>

<td><?= $w->wo_code ?></td>

<td><?= $w->project_name ?></td>

<td><?= date('d-m-Y',strtotime($w->work_order_date)) ?></td>

<td>

<?= $w->approve_flag
?'<span class="label label-success">Approved</span>'
:'<span class="label label-warning">Pending</span>' ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>
<!-- recent work orders table -->
 <!--recent progress table-->
 <div class="x_title">
    <h2><i class="fa fa-line-chart"></i> Project Progress Updates</h2>
    <div class="clearfix"></div>
</div>
 <table class="table table-striped" id="tbl_recent_progress">

<thead>

<tr>

<th>Project</th>

<th>Progress</th>

<th>Updated</th>

</tr>

</thead>

<tbody>

<?php foreach($recent_progress as $p){ ?>

<tr>

<td><?= $p->project_name ?></td>

<td><?= $p->progress_percentage ?>%</td>

<td><?= date('d-m-Y',strtotime($p->last_updated)) ?></td>

</tr>

<?php } ?>

</tbody>

</table>
 <!--recent progress table-->
 <!--Delayed Projects table-->
 <div class="x_title">
    <h2><i class="fa fa-warning text-danger"></i> Delayed Projects</h2>
    <div class="clearfix"></div>
</div>
 <table class="table table-hover" id="tbl_delayed_projects">

<thead>

<tr>

<th>Project</th>

<th>End Date</th>

<th>Delay</th>

</tr>

</thead>

<tbody>

<?php foreach($delayed_project_list as $d){ ?>

<tr>

<td><?= $d->project_name ?></td>

<td><?= date('d-m-Y',strtotime($d->end_date)) ?></td>

<td>

<span class="label label-danger">

<?= $d->delay_days ?> Days

</span>

</td>

</tr>

<?php } ?>

</tbody>

</table>
<!--Delayed Projects table-->
<!--pending outsourcetable
<table class="table table-bordered" id="tbl_pending_outsource" >

<thead>

<tr>

<th>Project</th>

<th>Supplier</th>

<th>Finish Date</th>

</tr>

</thead>

<tbody>

<?php foreach($pending_outsource_list as $o){ ?>

<tr>

<td><?= $o->project_name ?></td>

<td><?= $o->supplier_id ?></td>

<td><?= date('d-m-Y',strtotime($o->outsource_finish_date)) ?></td>

</tr>

<?php } ?>

</tbody>

</table>-->
<!--pending outsourcetable-->
<div style="clear:both;margin-bottom:20px;"></div>
<!--QUICK ACTION BUTTONS-->
<a href="<?php echo base_url().'index.php/Project/add_project' ?>" class="btn btn-primary"  target="_blank" >
New Project
</a>

<a href="<?php echo base_url().'index.php/Project/work_order' ?>"  target="_blank" class="btn btn-success">
Work Order
</a>

<a href="<?php echo base_url().'index.php/Project/material_outsource_processing' ?>" target="_blank" class="btn btn-warning">
Outsource
</a>

<a href="<?php echo base_url().'index.php/Project/project_progress_list' ?>" class="btn btn-info"  target="_blank" >
Update Progress
</a>

<a href="<?php echo base_url().'index.php/Project/project_progress_report' ?>" class="btn btn-dark" target="_blank" >
Reports
</a>

<a href="javascript:void(0);" id="goTop" title="Go to Top">
    <i class="fa fa-chevron-up"></i>
</a>
<!--QUICK ACTION BUTTONS-->
<link rel="stylesheet" href="<?= base_url('assets/datatables/datatables.min.css'); ?>">
<link rel="stylesheet" href="<?= base_url('assets/datatables/buttons.dataTables.min.css'); ?>">

<script src="<?= base_url('assets/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatables/dataTables.bootstrap.min.js'); ?>"></script>

<script src="<?= base_url('assets/datatables/dataTables.buttons.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatables/buttons.html5.min.js'); ?>"></script>
<script src="<?= base_url('assets/datatables/buttons.print.min.js'); ?>"></script>

<script src="<?= base_url('assets/datatables/jszip.min.js'); ?>"></script>
<script>
    $(document).ready(function(){

        $(window).scroll(function(){

            if($(this).scrollTop() > 250){

                $('#goTop').fadeIn();

            }else{

                $('#goTop').fadeOut();

            }

        });

        $('#goTop').click(function(){

            $('html, body').animate({

                scrollTop:0

            },600);

        });

    });
    $(document).ready(function () {

    function initTable(tableId) {

        $('#' + tableId).DataTable({

            destroy: true,
            responsive: true,
            pageLength: 5,
            lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],

            order: [[0, 'desc']],

            dom: 'Bfrtip',

            buttons: [
                {
                    extend: 'excelHtml5',
                    title: tableId
                },
                {
                    extend: 'print',
                    title: tableId
                }
            ]

        });

    }

    initTable('tbl_recent_projects');
    initTable('tbl_recent_workorders');
    initTable('tbl_recent_progress');
    initTable('tbl_delayed_projects');
    initTable('tbl_pending_outsource');

});
    var base_url = "<?php echo base_url(); ?>";
    // Project Status Chart
    $.getJSON(base_url+'index.php/Project_dashboard/chart_project_status', function(res){

    new Chart(document.getElementById("projectStatusChart"),{

        type:'pie',

        data:{

            labels:res.labels,

            datasets:[{

                data:res.values,

                backgroundColor:[
                    '#3498db',
                    '#2ecc71',
                    '#f39c12',
                    '#e74c3c',
                    '#9b59b6'
                ]

            }]

        },

        options:{
            responsive:true,
            plugins:{
                legend:{
                    position:'bottom'
                }
            }
        }

    });

});
//monthly projects chart
$.getJSON(base_url+'index.php/Project_dashboard/chart_monthly_projects', function(res){

new Chart(document.getElementById('monthlyChart'),{

type:'line',

data:{

labels:res.labels,

datasets:[{

label:'Projects',

data:res.values,

fill:false,

borderColor:'#3498db',

backgroundColor:'#3498db',

tension:.3

}]

},

options:{
responsive:true
}

});

});
//work order status chart
$.getJSON(base_url+'index.php/Project_dashboard/chart_workorder_status', function(res){

new Chart(document.getElementById('workorderChart'),{

type:'bar',

data:{

labels:res.labels,

datasets:[{

label:'Work Orders',

data:res.values,

backgroundColor:[
'#2ecc71',
'#f39c12'
]

}]

},

options:{

responsive:true,

scales:{
y:{
beginAtZero:true
}
}

}

});

});
//progress distribution chart
$.getJSON(base_url+'index.php/Project_dashboard/chart_progress_distribution',function(res){

new Chart(document.getElementById('progressChart'),{

type:'doughnut',

data:{

labels:res.labels,

datasets:[{

data:res.values,

backgroundColor:[

'#3498db',
'#2ecc71',
'#f39c12',
'#e74c3c'

]

}]

},

options:{
responsive:true
}

});

});
//refresh dashboard every 60 seconds
setInterval(function(){

location.reload();

},60000);

</script>
