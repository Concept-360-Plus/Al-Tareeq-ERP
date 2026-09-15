 <script src="<?php echo base_url()."public/assets/chart.js"; ?>"></script>
 
<!--<script src="<?php echo base_url()."public/assets/Chart2_9.min.js"; ?>"></script>-->
 <link href="<?= base_url('public/assets/dashboard.css') ?>" rel="stylesheet">

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

           <!-- <a href="<?= base_url('index.php/Project/material_outsource_processing'); ?>" target="_blank" class="qa-btn qa-warning">
                <i class="fa fa-truck"></i> Outsource
            </a>-->

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
    <label>From Date</label>
    <input type="date"
           id="dashboard_from_date"
           class="form-control"
           value="<?= date('Y-m-01'); ?>">
</div>

<div class="col-md-3">
    <label>To Date</label>
    <input type="date"
           id="dashboard_to_date"
           class="form-control"
           value="<?= date('Y-m-d'); ?>">
</div>

<div class="col-md-2" style="padding-top:25px;">

    <button type="button"
            id="dashboard_filter"
            class="btn btn-primary">
        <i class="fa fa-search"></i> Apply
    </button>
     <button type="button"
            id="dashboard_reset"
            class="btn btn-default">
        <i class="fa fa-refresh"></i> Reset
    </button>
</div><div class="col-md-2"></div>

<div class="col-md-3">
<div class="x_panel tile">
    <a href="<?php echo base_url().'index.php/Project/get_project_list'?>" target="_blank">
        <h3 id="total_projects"><?= $total_projects ?></h3>
        <p>Total Projects</p>
    </a>
</div>
</div>

<div class="col-md-3">
<div class="x_panel tile">
<a href="<?php echo base_url().'index.php/Project/get_project_list?status=Approved'?>" target="_blank">
    <h3 id="active_projects"><?= $active_projects ?></h3>
    <p>Active Projects</p>
</a>
</div>
</div>

<div class="col-md-3">
<div class="x_panel tile">
    <a href="<?php echo base_url().'index.php/Project/get_project_list?status=Completed'?>" target="_blank">
        <h3 id="completed_projects"><?= $completed_projects ?></h3>
        <p>Completed Projects</p>
    </a>
</div>
</div>

<div class="col-md-3">
<div class="x_panel tile">
<h3 id="average_progress"><?= $average_progress ?>%</h3>
<p>Average Progress</p>
</div>
</div>

</div>
<!--cost card-->
<div class="row">

<div class="col-md-3">
<div class="x_panel">
<h3 id="estimated_cost">₹ <?= number_format($estimated_cost,2) ?></h3>
<p>Project Items Estimated Cost</p>
</div>
</div>

<div class="col-md-3">
<div class="x_panel">
<h3 id="material_request_cost">₹ <?= number_format($material_request_cost,2) ?></h3>
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
<h3 id="outsource_cost">₹ <?= number_format($outsource_cost,2) ?></h3>
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
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="dashboard-chart-box">
                    <canvas id="projectStatusChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="x_panel">

            <div class="x_title">
                <h2>Monthly Projects</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="dashboard-chart-box">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

        </div>
    </div>

</div>
<!--charts-->
<!--work order progress charts-->
<div class="row">

    <div class="col-md-6">
        <div class="x_panel">

            <div class="x_title">
                <h2>Work Order Status</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="workorder-chart-box">
                    <canvas id="workorderChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-6">
        <div class="x_panel">

            <div class="x_title">
                <h2>Progress Distribution</h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="dashboard-chart-box">
                    <canvas id="progressChart"></canvas>
                </div>
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

var base_url = "<?= base_url(); ?>";

var projectStatusChart = null;
var monthlyChart        = null;
var workorderChart      = null;
var progressChart       = null;

var dashboardChartRequest = 0;


/* =========================================================
   DESTROY CHART
   ========================================================= */

function destroyChart(canvasId)
{
    var canvas = document.getElementById(canvasId);

    if (!canvas) {
        return;
    }

    var chart = Chart.getChart(canvas);

    if (chart) {
        chart.destroy();
    }
}


/* =========================================================
   DESTROY ALL DASHBOARD CHARTS
   ========================================================= */

function destroyDashboardCharts()
{
    destroyChart('projectStatusChart');
    destroyChart('monthlyChart');
    destroyChart('workorderChart');
    destroyChart('progressChart');

    projectStatusChart = null;
    monthlyChart       = null;
    workorderChart     = null;
    progressChart      = null;
}


/* =========================================================
   GET CHART CANVAS
   ========================================================= */

function getCanvas(id)
{
    return document.getElementById(id);
}


/* =========================================================
   LOAD DASHBOARD CHARTS
   ========================================================= */

function loadDashboardCharts(from_date, to_date)
{
    from_date = from_date || '';
    to_date   = to_date || '';

    dashboardChartRequest++;

    var currentRequest = dashboardChartRequest;

    /*
     * Destroy previous charts
     */
    destroyDashboardCharts();


    /* =====================================================
       PROJECT STATUS
       ===================================================== */

    $.ajax({

        url: base_url +
             'index.php/Project_dashboard/chart_project_status',

        type: 'GET',

        dataType: 'json',

        data: {
            from_date: from_date,
            to_date: to_date
        },

        success: function(res)
        {
            if (currentRequest !== dashboardChartRequest) {
                return;
            }

            var canvas = getCanvas('projectStatusChart');

            if (!canvas) {
                return;
            }

            destroyChart('projectStatusChart');

            projectStatusChart = new Chart(
                canvas,
                {
                    type: 'doughnut',

                    data: {

                        labels: res.labels || [],

                        datasets: [{
                            data: res.values || [],

                            backgroundColor: [
                                '#3498db',
                                '#2ecc71',
                                '#f39c12',
                                '#e74c3c',
                                '#9b59b6'
                            ],

                            borderWidth: 1
                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                position: 'bottom'
                            }

                        },

                        onClick: function(event, elements)
                        {
                            if (
                                !elements ||
                                elements.length === 0
                            ) {
                                return;
                            }

                            var index =
                                elements[0].index;

                            var status =
                                this.data.labels[index];

                            if (!status) {
                                return;
                            }

                            var url =
                                base_url +
                                'index.php/Project/get_project_list' +
                                '?status=' +
                                encodeURIComponent(status) +
                                '&from_date=' +
                                encodeURIComponent(from_date) +
                                '&to_date=' +
                                encodeURIComponent(to_date);

                            console.log(
                                'Project Status:',
                                status
                            );

                            console.log(
                                'Opening:',
                                url
                            );

                            window.open(
                                url,
                                '_blank'
                            );
                        },

                        onHover: function(event, elements)
                        {
                            var canvas =
                                this.canvas;

                            if (!canvas) {
                                return;
                            }

                            canvas.style.cursor =
                                elements &&
                                elements.length
                                    ? 'pointer'
                                    : 'default';
                        }

                    }

                }
            );

        },

        error: function(xhr)
        {
            console.log(
                'Project Status Error:',
                xhr.responseText
            );
        }

    });


    /* =====================================================
       MONTHLY PROJECTS
       ===================================================== */

    $.ajax({

        url: base_url +
             'index.php/Project_dashboard/chart_monthly_projects',

        type: 'GET',

        dataType: 'json',

        data: {
            from_date: from_date,
            to_date: to_date
        },

        success: function(res)
        {
            if (currentRequest !== dashboardChartRequest) {
                return;
            }

            var canvas =
                getCanvas('monthlyChart');

            if (!canvas) {
                return;
            }

            destroyChart('monthlyChart');

            monthlyChart = new Chart(
                canvas,
                {
                    type: 'line',

                    data: {

                        labels: res.labels || [],

                        datasets: [{

                            label: 'Projects',

                            data: res.values || [],

                            fill: false,

                            borderColor: '#3498db',

                            backgroundColor: '#3498db',

                            borderWidth: 2,

                            tension: 0.3,

                            pointRadius: 5,

                            pointHoverRadius: 8

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {

                            mode: 'nearest',

                            intersect: true

                        },

                        plugins: {

                            legend: {
                                display: true
                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: true,

                                ticks: {

                                    precision: 0

                                }

                            }

                        },

                        onClick: function(event, elements)
                        {
                            if (
                                !elements ||
                                elements.length === 0
                            ) {
                                return;
                            }

                            var index =
                                elements[0].index;

                            var selectedMonth =
                                this.data.labels[index];

                            if (!selectedMonth) {
                                return;
                            }

                            console.log(
                                'Clicked month:',
                                selectedMonth
                            );


                            var monthNames = [

                                'Jan',
                                'Feb',
                                'Mar',
                                'Apr',
                                'May',
                                'Jun',
                                'Jul',
                                'Aug',
                                'Sep',
                                'Oct',
                                'Nov',
                                'Dec'

                            ];


                            var month =
                                monthNames.indexOf(
                                    selectedMonth
                                );


                            if (month === -1) {
                                return;
                            }


                            /*
                             * If your monthly chart is
                             * filtered, use selected year.
                             */

                            var year =
                                new Date().getFullYear();


                            var firstDay =
                                new Date(
                                    year,
                                    month,
                                    1
                                );


                            var lastDay =
                                new Date(
                                    year,
                                    month + 1,
                                    0
                                );


                            function formatDate(date)
                            {
                                var m =
                                    String(
                                        date.getMonth() + 1
                                    ).padStart(
                                        2,
                                        '0'
                                    );

                                var d =
                                    String(
                                        date.getDate()
                                    ).padStart(
                                        2,
                                        '0'
                                    );

                                return (
                                    date.getFullYear() +
                                    '-' +
                                    m +
                                    '-' +
                                    d
                                );
                            }


                            var selectedFromDate =
                                formatDate(firstDay);

                            var selectedToDate =
                                formatDate(lastDay);


                            var url =
                                base_url +
                                'index.php/Project/get_project_list' +
                                '?from_date=' +
                                encodeURIComponent(
                                    selectedFromDate
                                ) +
                                '&to_date=' +
                                encodeURIComponent(
                                    selectedToDate
                                );


                            console.log(
                                'Opening:',
                                url
                            );


                            window.open(
                                url,
                                '_blank'
                            );
                        },

                        onHover: function(event, elements)
                        {
                            var canvas =
                                this.canvas;

                            if (!canvas) {
                                return;
                            }

                            canvas.style.cursor =
                                elements &&
                                elements.length
                                    ? 'pointer'
                                    : 'default';
                        }

                    }

                }
            );

        },

        error: function(xhr)
        {
            console.log(
                'Monthly Chart Error:',
                xhr.responseText
            );
        }

    });


    /* =====================================================
       WORK ORDER STATUS
       ===================================================== */

    $.ajax({

        url: base_url +
             'index.php/Project_dashboard/chart_workorder_status',

        type: 'GET',

        dataType: 'json',

        data: {
            from_date: from_date,
            to_date: to_date
        },

        success: function(res)
        {
            if (currentRequest !== dashboardChartRequest) {
                return;
            }

            var canvas =
                getCanvas('workorderChart');

            if (!canvas) {
                return;
            }

            destroyChart('workorderChart');


            workorderChart = new Chart(
                canvas,
                {
                    type: 'bar',

                    data: {

                        labels: res.labels || [],

                        datasets: [{

                            label: 'Work Orders',

                            data: res.values || [],

                            backgroundColor: [

                                '#2ecc71',
                                '#f39c12',
                                '#3498db',
                                '#e74c3c'

                            ],

                            borderWidth: 1

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        interaction: {

                            mode: 'nearest',

                            intersect: true

                        },

                        plugins: {

                            legend: {
                                display: false
                            }

                        },

                        scales: {

                            y: {

                                beginAtZero: true,

                                ticks: {

                                    precision: 0

                                }

                            }

                        },


                        onClick: function(event, elements)
                        {
                            if (
                                !elements ||
                                elements.length === 0
                            ) {
                                return;
                            }


                            var index =
                                elements[0].index;


                            var selectedStatus =
                                this.data.labels[index];


                            if (!selectedStatus) {
                                return;
                            }


                            console.log(
                                'Clicked Work Order:',
                                selectedStatus
                            );


                            var url =
                                base_url +
                                'index.php/Project/view_work_order_list' +
                                '?status=' +
                                encodeURIComponent(
                                    selectedStatus
                                ) +
                                '&from_date=' +
                                encodeURIComponent(
                                    from_date
                                ) +
                                '&to_date=' +
                                encodeURIComponent(
                                    to_date
                                );


                            console.log(
                                'Opening:',
                                url
                            );


                            window.open(
                                url,
                                '_blank'
                            );
                        },


                        onHover: function(event, elements)
                        {
                            var canvas =
                                this.canvas;

                            if (!canvas) {
                                return;
                            }

                            canvas.style.cursor =
                                elements &&
                                elements.length
                                    ? 'pointer'
                                    : 'default';
                        }

                    }

                }
            );

        },

        error: function(xhr)
        {
            console.log(
                'Work Order Chart Error:',
                xhr.responseText
            );
        }

    });


    /* =====================================================
       PROGRESS DISTRIBUTION
       ===================================================== */

    $.ajax({

        url: base_url +
             'index.php/Project_dashboard/chart_progress_distribution',

        type: 'GET',

        dataType: 'json',

        data: {
            from_date: from_date,
            to_date: to_date
        },

        success: function(res)
        {
            if (currentRequest !== dashboardChartRequest) {
                return;
            }

            var canvas =
                getCanvas('progressChart');

            if (!canvas) {
                return;
            }

            destroyChart('progressChart');


            progressChart = new Chart(
                canvas,
                {
                    type: 'doughnut',

                    data: {

                        labels: res.labels || [],

                        datasets: [{

                            data: res.values || [],

                            backgroundColor: [

                                '#3498db',
                                '#2ecc71',
                                '#f39c12',
                                '#e74c3c'

                            ],

                            borderWidth: 1

                        }]

                    },

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {

                                position: 'bottom'

                            }

                        },

                        onClick: function(event, elements)
                        {
                            if (
                                !elements ||
                                elements.length === 0
                            ) {
                                return;
                            }


                            var index =
                                elements[0].index;


                            var selectedProgress =
                                this.data.labels[index];


                            if (!selectedProgress) {
                                return;
                            }


                            console.log(
                                'Clicked Progress:',
                                selectedProgress
                            );

                            /*
                             * Add URL here if you want
                             * progress slices clickable.
                             */
                        },


                        onHover: function(event, elements)
                        {
                            var canvas =
                                this.canvas;

                            if (!canvas) {
                                return;
                            }

                            canvas.style.cursor =
                                elements &&
                                elements.length
                                    ? 'pointer'
                                    : 'default';
                        }

                    }

                }
            );

        },

        error: function(xhr)
        {
            console.log(
                'Progress Chart Error:',
                xhr.responseText
            );
        }

    });

}


/* =========================================================
   DOCUMENT READY
   ========================================================= */

$(document).ready(function()
{

    /* =====================================================
       GO TOP
       ===================================================== */

    $(window).on('scroll', function()
    {

        if ($(this).scrollTop() > 250) {

            $('#goTop').fadeIn();

        } else {

            $('#goTop').fadeOut();

        }

    });


    $('#goTop').on('click', function()
    {

        $('html, body').animate(
            {
                scrollTop: 0
            },
            600
        );

    });


    /* =====================================================
       DATATABLES
       ===================================================== */

    if (
        $('#tbl_recent_projects').length &&
        !$.fn.DataTable.isDataTable(
            '#tbl_recent_projects'
        )
    ) {

        $('#tbl_recent_projects').DataTable({

            responsive: true,

            pageLength: 5,

            order: [
                [2, 'desc']
            ]

        });

    }


    if (
        $('#tbl_recent_workorders').length &&
        !$.fn.DataTable.isDataTable(
            '#tbl_recent_workorders'
        )
    ) {

        $('#tbl_recent_workorders').DataTable({

            responsive: true,

            pageLength: 5,

            order: [
                [2, 'desc']
            ]

        });

    }


    if (
        $('#tbl_recent_progress').length &&
        !$.fn.DataTable.isDataTable(
            '#tbl_recent_progress'
        )
    ) {

        $('#tbl_recent_progress').DataTable({

            responsive: true,

            pageLength: 5,

            order: [
                [2, 'desc']
            ]

        });

    }


    if (
        $('#tbl_delayed_projects').length &&
        !$.fn.DataTable.isDataTable(
            '#tbl_delayed_projects'
        )
    ) {

        $('#tbl_delayed_projects').DataTable({

            responsive: true,

            pageLength: 5,

            order: [
                [2, 'asc']
            ]

        });

    }


    /* =====================================================
       PENDING OUTSOURCE
       ===================================================== */

    if (
        $('#tbl_pending_outsource').length &&
        !$.fn.DataTable.isDataTable(
            '#tbl_pending_outsource'
        )
    ) {

        $('#tbl_pending_outsource').DataTable({

            responsive: true,

            pageLength: 5,

            lengthMenu: [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, 'All']
            ],

            order: [
                [0, 'desc']
            ],

            dom: 'Bfrtip',

            buttons: [

                {
                    extend: 'excelHtml5',
                    title: 'Pending Outsource'
                },

                {
                    extend: 'print',
                    title: 'Pending Outsource'
                }

            ]

        });

    }


    /* =====================================================
       INITIAL CHART LOAD
       ===================================================== */

    loadDashboardCharts();


    /* =====================================================
       APPLY DATE FILTER
       ===================================================== */

    $('#dashboard_filter').on(
        'click',
        function()
        {

            var from_date =
                $('#dashboard_from_date').val();

            var to_date =
                $('#dashboard_to_date').val();


            if (
                from_date === '' ||
                to_date === ''
            ) {

                alert(
                    'Please select From Date and To Date.'
                );

                return;
            }


            if (from_date > to_date) {

                alert(
                    'From Date cannot be greater than To Date.'
                );

                return;
            }


            var button =
                $(this);


            button
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Loading...'
                );


            $.ajax({

                url:
                    base_url +
                    'index.php/Project_dashboard/filter_dashboard_date',

                type: 'POST',

                dataType: 'json',

                data: {

                    from_date: from_date,

                    to_date: to_date

                },


                success: function(response)
                {

                    console.log(
                        'Dashboard:',
                        response
                    );


                    if (
                        response.status === true
                    ) {

                        $('#total_projects')
                            .text(
                                response.total_projects
                            );


                        $('#active_projects')
                            .text(
                                response.active_projects
                            );


                        $('#completed_projects')
                            .text(
                                response.completed_projects
                            );


                        $('#estimated_cost')
                            .text(
                                response.estimated_cost
                            );


                        $('#outsource_cost')
                            .text(
                                response.outsource_cost
                            );


                        $('#material_request_cost')
                            .text(
                                response.material_request_cost
                            );


                        /*
                         * Tables
                         */

                        filterRecentProjects(
                            from_date,
                            to_date
                        );


                        filterRecentWorkorders(
                            from_date,
                            to_date
                        );


                        filterRecentProgress(
                            from_date,
                            to_date
                        );


                        filterDelayedProjects(
                            from_date,
                            to_date
                        );

                    } else {

                        alert(
                            response.message ||
                            'Unable to load dashboard data.'
                        );

                    }

                },


                error: function(xhr)
                {

                    console.log(
                        xhr.responseText
                    );

                    alert(
                        'Error loading dashboard data.'
                    );

                },


                complete: function()
                {

                    /*
                     * Reload charts
                     */

                    loadDashboardCharts(
                        from_date,
                        to_date
                    );


                    button
                        .prop(
                            'disabled',
                            false
                        )
                        .html(
                            '<i class="fa fa-search"></i> Apply'
                        );

                }

            });

        }
    );


    /* =====================================================
       RESET
       ===================================================== */

    $('#dashboard_reset').on(
        'click',
        function()
        {

            $('#dashboard_from_date').val('');

            $('#dashboard_to_date').val('');


            /*
             * Reload all charts
             */

            loadDashboardCharts();


        }
    );

});


/* =========================================================
   FILTER RECENT PROJECTS
   ========================================================= */

function filterRecentProjects(
    from_date,
    to_date
)
{

    $.ajax({

        url:
            base_url +
            'index.php/Project_dashboard/filter_recent_projects',

        type: 'POST',

        dataType: 'json',

        data: {

            from_date: from_date,

            to_date: to_date

        },


        success: function(response)
        {

            if (
                response.status === true
            ) {

                var table =
                    $('#tbl_recent_projects')
                    .DataTable();


                table.clear();


                $.each(
                    response.data || [],
                    function(i, p)
                    {

                        var progress =
                            parseFloat(
                                p.progress || 0
                            );


                        var progressHtml =

                            '<div class="progress">' +

                                '<div class="progress-bar progress-bar-success" ' +

                                'style="width:' +
                                progress +
                                '%">' +

                                progress +
                                '%' +

                                '</div>' +

                            '</div>';


                        table.row.add([

                            p.project_code,

                            p.customer_name,

                            p.start_date,

                            p.end_date,

                            p.status,

                            progressHtml

                        ]);

                    }
                );


                table.draw();

            }

        },


        error: function(xhr)
        {

            console.log(
                xhr.responseText
            );

        }

    });

}


/* =========================================================
   FILTER RECENT WORK ORDERS
   ========================================================= */

function filterRecentWorkorders(
    from_date,
    to_date
)
{

    $.ajax({

        url:
            base_url +
            'index.php/Project_dashboard/filter_recent_workorders',

        type: 'POST',

        dataType: 'json',

        data: {

            from_date: from_date,

            to_date: to_date

        },


        success: function(response)
        {

            if (
                response.status === true
            ) {

                var table =
                    $('#tbl_recent_workorders')
                    .DataTable();


                table.clear();


                $.each(
                    response.data || [],
                    function(i, wo)
                    {

                        table.row.add([

                            wo.wo_code,

                            wo.project_code,

                            wo.project_name,

                            wo.work_order_date,

                            wo.status

                        ]);

                    }
                );


                table.draw();

            }

        },


        error: function(xhr)
        {

            console.log(
                xhr.responseText
            );

        }

    });

}


/* =========================================================
   FILTER RECENT PROGRESS
   ========================================================= */

function filterRecentProgress(
    from_date,
    to_date
)
{

    $.ajax({

        url:
            base_url +
            'index.php/Project_dashboard/filter_recent_progress',

        type: 'POST',

        dataType: 'json',

        data: {

            from_date: from_date,

            to_date: to_date

        },


        success: function(response)
        {

            if (
                response.status === true
            ) {

                var table =
                    $('#tbl_recent_progress')
                    .DataTable();


                table.clear();


                $.each(
                    response.data || [],
                    function(i, p)
                    {

                        var progress =
                            parseFloat(
                                p.progress_percentage || 0
                            );


                        var progressHtml =

                            '<div class="progress">' +

                                '<div class="progress-bar progress-bar-success" ' +

                                'style="width:' +
                                progress +
                                '%">' +

                                progress +
                                '%' +

                                '</div>' +

                            '</div>';


                        table.row.add([

                            p.project_code,

                            p.project_name,

                            progressHtml,

                            p.current_status,

                            p.last_updated

                        ]);

                    }
                );


                table.draw();

            }

        },


        error: function(xhr)
        {

            console.log(
                xhr.responseText
            );

        }

    });

}


/* =========================================================
   FILTER DELAYED PROJECTS
   ========================================================= */

function filterDelayedProjects(
    from_date,
    to_date
)
{

    $.ajax({

        url:
            base_url +
            'index.php/Project_dashboard/filter_delayed_projects',

        type: 'POST',

        dataType: 'json',

        data: {

            from_date: from_date,

            to_date: to_date

        },


        success: function(response)
        {

            if (
                response.status === true
            ) {

                var table =
                    $('#tbl_delayed_projects')
                    .DataTable();


                table.clear();


                $.each(
                    response.data || [],
                    function(i, p)
                    {

                        table.row.add([

                            p.project_code,

                            p.project_name,

                            p.customer_name,

                            p.end_date,

                            p.delay_days +
                            ' days'

                        ]);

                    }
                );


                table.draw();

            }

        },


        error: function(xhr)
        {

            console.log(
                xhr.responseText
            );

        }

    });

}

</script>