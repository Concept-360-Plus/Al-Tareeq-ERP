<script src="<?php echo base_url()."public/assets/Chart2_9.min.js"; ?>"></script>
 <link href="<?php echo base_url()."public/assets/dashboard.css"; ?>" rel="stylesheet"/>
 <a href="javascript:void(0);" id="goTop" title="Go to Top">
        <i class="fa fa-chevron-up"></i>
    </a>
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
    </script>

<script>
    Chart.defaults.global.defaultFontFamily =
        "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";

    Chart.defaults.global.defaultFontSize = 12;

    Chart.defaults.global.defaultFontStyle = 'normal';

    Chart.defaults.global.defaultFontColor = '#666';
</script>
<style>

    .dashboard-container {
        padding: 10px;
    }

    .dashboard-filter {
        background: #f7f7f7;
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
    }

    .dashboard-filter label {
        font-weight: 600;
    }

    .kpi-box {
        background: #fff;
        border: 1px solid #ddd;
        min-height: 120px;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .kpi-box h2 {
        margin: 5px 0;
        font-size: 30px;
        font-weight: 600;
    }

    .kpi-box span {
        color: #777;
        font-size: 13px;
    }

    .chart-box {
        background: #fff;
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
        min-height: 350px;
    }

    .chart-box h4 {
        margin-top: 0;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .chart-container {
        position: relative;
        height: 280px;
    }

    .table th {
        white-space: nowrap;
    }

    .table td {
        vertical-align: middle !important;
    }

    .clickable-chart {
        cursor: pointer;
    }
/* DataTable top controls - single row */
.dt-top-row {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 15px;
    margin-bottom: 10px;
}

/* Show entries */
.dt-length {
    flex: 0 0 auto;
}

.dt-length .dataTables_length {
    margin: 0;
}

.dt-length .dataTables_length label {
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 0;
    white-space: nowrap;
}

.dt-length select {
    width: auto !important;
    min-width: 70px;
    display: inline-block;
}

/* Export buttons */
.dt-buttons {
    flex: 0 0 auto;
}

.dt-buttons .btn {
    margin-right: 3px;
}

/* Search - push to right */
.dt-search {
    margin-left: auto;
    flex: 0 0 auto;
}

.dt-search .dataTables_filter {
    margin: 0;
}

.dt-search .dataTables_filter label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
    white-space: nowrap;
}

.dt-search input {
    width: 215px !important;
    margin: 0 !important;
}

/* Remove Bootstrap/DataTables floating */
.dt-top-row .dataTables_length,
.dt-top-row .dt-buttons,
.dt-top-row .dataTables_filter {
    float: none !important;
}

/* Mobile */
@media (max-width: 768px) {
    .dt-top-row {
        flex-wrap: wrap;
    }

    .dt-search {
        margin-left: 0;
        width: 100%;
    }

    .dt-search input {
        width: 200px !important;
    }
}
</style>


<div class="row">

    <div class="col-md-12">

        <div class="x_panel">

           <!-- <div class="x_title">

                <h2>
                    Production Manager Dashboard
                </h2>

                <div class="clearfix"></div>

            </div>-->


            <div class="x_content dashboard-container">

                <div class="x_panel" style="margin-bottom:15px;">
    <div class="x_title">
        <h2><i class="fa fa-bolt"></i> Quick Actions</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <div class="quick-actions">

            <a href="<?php echo base_url().'index.php/Production/job_create' ?>" target="_blank" class="qa-btn qa-primary">
                <i class="fa fa-plus"></i> New Job Order
            </a>

            <a href="<?= base_url('index.php/Production/material_requests'); ?>" target="_blank"  class="qa-btn qa-purple">
               <i class="fa fa-cubes"></i> Material Request
            </a>

           <!-- <a href="<?= base_url('index.php/Project/material_outsource_processing'); ?>" target="_blank" class="qa-btn qa-warning">
                <i class="fa fa-truck"></i> Outsource
            </a>-->
            <a href="<?= base_url('index.php/production/job_completions'); ?>" target="_blank" class="qa-btn qa-info">
                <i class="fa fa-line-chart"></i>Job Completion
            </a>

            <a href="<?= base_url('index.php/Production/stock_transfers'); ?>" target="_blank" class="qa-btn qa-warning">
                <i class="fa fa-truck"></i> FMT/Stock Transfer
            </a>

            <a href="<?= base_url('index.php/Production/reports'); ?>" target="_blank" class="qa-btn qa-dark">
                <i class="fa fa-bar-chart"></i> Reports
            </a>

        </div>

    </div>
</div>
                <!-- =====================================================
                     FILTER
                ====================================================== -->

                <div class="dashboard-filter">

                    <div class="row">

                        <div class="col-md-3">

                            <label>
                                From Date
                            </label>

                            <input
                                type="date"
                                id="dashboard_from_date"
                                class="form-control">

                        </div>


                        <div class="col-md-3">

                            <label>
                                To Date
                            </label>

                            <input
                                type="date"
                                id="dashboard_to_date"
                                class="form-control">

                        </div>


                        <div class="col-md-3">

                            <label>
                                Project
                            </label>

                            <select
                                id="dashboard_project_id"
                                class="form-control">

                                <option value="">
                                    All Projects
                                </option>

                                <?php if (!empty($projects)): ?>

                                    <?php foreach ($projects as $project): ?>

                                        <option
                                            value="<?= $project['project_id']; ?>">

                                            <?= htmlspecialchars(
                                                $project['project_name']
                                            ); ?>

                                        </option>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </select>

                        </div>


                        <div class="col-md-2">

                            <label>
                                &nbsp;
                            </label>

                            <button
                                type="button"
                                id="applyDashboardFilter"
                                class="btn btn-primary form-control">

                                <i class="fa fa-search"></i>

                                Apply

                            </button>

                        </div>

                        <div class="col-md-1">

                            <label>
                                &nbsp;
                            </label>

                            <button
                                type="button"
                                id="resetDashboardFilter"
                                class="btn btn-default btn-sm">

                                <i class="fa fa-refresh"></i>

                                Reset

                            </button>

                        </div>

                    </div>


                   

                </div>


                <!-- =====================================================
                     KPI
                ====================================================== -->

                <div class="row">

                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                Total Job Orders
                            </span>

                            <h2 id="kpiJobOrders">
                                0
                            </h2>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                Ordered Quantity
                            </span>

                            <h2 id="kpiOrdered">
                                0.00
                            </h2>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                Completed Quantity
                            </span>

                            <h2 id="kpiCompleted">
                                0.00
                            </h2>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                Remaining Quantity
                            </span>

                            <h2 id="kpiRemaining">
                                0.00
                            </h2>

                        </div>

                    </div>

                </div>


                <div class="row">

                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                Pending
                            </span>

                            <h2 id="kpiPending">
                                0
                            </h2>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                In Progress
                            </span>

                            <h2 id="kpiInProgress">
                                0
                            </h2>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                Production Completed
                            </span>

                            <h2 id="kpiProductionCompleted">
                                0
                            </h2>

                        </div>

                    </div>


                    <div class="col-md-3">

                        <div class="kpi-box">

                            <span>
                                Completion %
                            </span>

                            <h2 id="kpiCompletionPercent">
                                0%
                            </h2>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     CHART ROW 1
                ====================================================== -->

                <div class="row">


                    <!-- JOB STATUS -->

                    <div class="col-md-6">

                        <div class="chart-box">

                            <h4>
                                Job Order Status

                                <small class="pull-right">
                                    Click a segment to drill down
                                </small>

                            </h4>

                            <div class="chart-container">

                                <canvas
                                    id="jobStatusChart">
                                </canvas>

                            </div>

                        </div>

                    </div>


                    <!-- QUANTITY -->

                    <div class="col-md-6">

                        <div class="chart-box">

                            <h4>
                                Production Quantity

                                <small class="pull-right">
                                    Click a bar to drill down
                                </small>

                            </h4>

                            <div class="chart-container">

                                <canvas
                                    id="productionQuantityChart">
                                </canvas>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     CHART ROW 2
                ====================================================== -->

                <div class="row">


                    <!-- MONTHLY -->

                    <div class="col-md-8">

                        <div class="chart-box">

                            <h4>
                                Monthly Production

                                <small class="pull-right">
                                    Click a month to drill down
                                </small>

                            </h4>

                            <div class="chart-container">

                                <canvas
                                    id="monthlyProductionChart">
                                </canvas>

                            </div>

                        </div>

                    </div>


                    <!-- MATERIAL REQUEST -->

                    <div class="col-md-4">

                        <div class="chart-box">

                            <h4>
                                Material Requests

                                <small class="pull-right">
                                    Click
                                </small>

                            </h4>

                            <div class="chart-container">

                                <canvas
                                    id="materialRequestChart">
                                </canvas>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     CHART ROW 3
                ====================================================== -->

                <div class="row">


                    <!-- STOCK TRANSFER -->

                    <div class="col-md-4">

                        <div class="chart-box">

                            <h4>
                                Stock Transfers
                            </h4>

                            <div class="chart-container">

                                <canvas
                                    id="stockTransferChart">
                                </canvas>

                            </div>

                        </div>

                    </div>


                    <!-- TOP PRODUCTS -->

                    <div class="col-md-8">

                        <div class="chart-box">

                            <h4>
                                Top 10 Production Products

                                

                            </h4>

                            <div class="chart-container">

                                <canvas
                                    id="topProductsChart">
                                </canvas>

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>



<!-- ================================================================
     DRILL DOWN MODAL
================================================================ -->

<div
    class="modal fade"
    id="productionDrilldownModal"
    tabindex="-1"
    role="dialog">

    <div
        class="modal-dialog modal-lg"
        style="width:90%;"
        role="document">

        <div class="modal-content">


            <div class="modal-header">
                <h4
                    class="modal-title"
                    id="drilldownTitle">

                    Production Details

                </h4>
                 <button
                    type="button"
                    class="close"
                    data-dismiss="modal">
                    &times;
                </button>

            </div>


            <div class="modal-body">

                <div
                    class="text-center"
                    id="drilldownLoading"
                    style="display:none;">

                    <i class="fa fa-spinner fa-spin fa-2x"></i>

                    <br>

                    Loading...

                </div>


                <div class="table-responsive">

                    <table
                        class="table table-bordered table-striped"
                        id="drilldownTable"
                        width="100%">

                        <thead id="drilldownHead">

                        </thead>

                        <tbody id="drilldownBody">

                        </tbody>

                    </table>

                </div>

            </div>


        </div>

    </div>

</div>

<script>

$(document).ready(function () {

    /* ============================================================
     * CHART VARIABLES
     * ============================================================ */

    var jobStatusChart = null;
    var productionQuantityChart = null;
    var monthlyProductionChart = null;
    var materialRequestChart = null;
    var stockTransferChart = null;
    var topProductsChart = null;

    var drilldownTable = null;


    /* ============================================================
     * COLORS
     * ============================================================ */

    var chartColors = [
        '#3498db',
        '#2ecc71',
        '#f39c12',
        '#e74c3c',
        '#9b59b6',
        '#1abc9c',
        '#34495e',
        '#e67e22',
        '#16a085',
        '#8e44ad'
    ];


    var statusColors = {

        'Pending': '#f39c12',
        'In Progress': '#3498db',
        'Production Completed': '#2ecc71',
        'Completed': '#27ae60',
        'Cancelled': '#e74c3c'

    };


    /* ============================================================
     * STATUS COLOR
     * ============================================================ */

    function getStatusColor(status, index)
    {

        if (statusColors[status]) {

            return statusColors[status];

        }

        return chartColors[
            index % chartColors.length
        ];

    }


    /* ============================================================
     * NUMBER FORMAT
     * ============================================================ */

    function numberFormat(value)
    {

        var number = parseFloat(value);

        if (isNaN(number)) {

            number = 0;

        }

        return number.toFixed(2);

    }


    /* ============================================================
     * HTML ESCAPE
     * ============================================================ */

    function escapeHtml(value)
    {

        if (
            value === null ||
            value === undefined
        ) {

            return '';

        }

        return $('<div>')
            .text(value)
            .html();

    }


    /* ============================================================
     * GET DASHBOARD FILTERS
     * ============================================================ */

    function getDashboardFilters()
    {

        return {

            from_date:
                $('#dashboard_from_date').val(),

            to_date:
                $('#dashboard_to_date').val(),

            project_id:
                $('#dashboard_project_id').val()

        };

    }


    /* ============================================================
     * AJAX POST
     * ============================================================ */

    function ajaxPost(url, callback)
    {

        $.ajax({

            url: url,

            type: 'POST',

            dataType: 'json',

            data: getDashboardFilters(),

            success: function(response)
            {

                console.log(
                    'Dashboard response:',
                    response
                );

                callback(
                    response || {}
                );

            },

            error: function(xhr)
            {

                console.error(
                    'Dashboard AJAX Error:',
                    xhr.status,
                    xhr.responseText
                );

                callback({
                    data: []
                });

            }

        });

    }


    /* ============================================================
     * SAFE DESTROY CHART
     * ============================================================ */

    function destroyChart(chart)
    {

        if (chart) {

            try {

                chart.destroy();

            }
            catch (e) {

                console.error(
                    'Chart destroy error:',
                    e
                );

            }

        }

        return null;

    }


    /* ============================================================
     * GET CLICK INDEX
     *
     * Supports Chart.js 2.x and 3.x+
     * ============================================================ */

    function getChartElementIndex(element)
    {

        if (!element) {

            return -1;

        }

        /*
         * Chart.js 2.x
         */

        if (
            typeof element._index !== 'undefined'
        ) {

            return element._index;

        }

        /*
         * Chart.js 3.x+
         */

        if (
            typeof element.index !== 'undefined'
        ) {

            return element.index;

        }

        return -1;

    }


    /* ============================================================
     * SUMMARY
     * ============================================================ */

    function loadSummary()
    {

        ajaxPost(

            '<?= base_url(
                "index.php/Production/get_production_dashboard_summary"
            ); ?>',

            function(response)
            {

                var data =
                    response.data || {};


                $('#kpiJobOrders').text(
                    data.job_orders || 0
                );


                $('#kpiOrdered').text(
                    (
                        data.ordered_quantity
                    )
                );


                $('#kpiCompleted').text(
                   (
                        data.completed_quantity
                    )
                );


                $('#kpiRemaining').text(
                    (
                        data.remaining_quantity
                    )
                );


                $('#kpiPending').text(
                    data.pending || 0
                );


                $('#kpiInProgress').text(
                    data.in_progress || 0
                );


                $('#kpiProductionCompleted').text(
                    data.production_completed || 0
                );


                $('#kpiCompletionPercent').text(
                    numberFormat(
                        data.completion_percent
                    ) + '%'
                );

            }

        );

    }


    /* ============================================================
     * JOB ORDER STATUS CHART
     * ============================================================ */

    function loadJobStatusChart()
    {

        ajaxPost(

            '<?= base_url(
                "index.php/Production/get_job_order_status_chart"
            ); ?>',

            function(response)
            {

                var data =
                    $.isArray(response.data)
                        ? response.data
                        : [];


                var labels = [];
                var values = [];
                var colors = [];


                $.each(
                    data,
                    function(i, row)
                    {

                        var status =
                            row.status ||
                            'Unknown';


                        labels.push(
                            status
                        );


                        values.push(
                            parseInt(
                                row.count || 0,
                                10
                            )
                        );


                        colors.push(
                            getStatusColor(
                                status,
                                i
                            )
                        );

                    }
                );


                jobStatusChart =
                    destroyChart(
                        jobStatusChart
                    );


                var canvas =
                    document.getElementById(
                        'jobStatusChart'
                    );


                if (!canvas) {

                    console.error(
                        'jobStatusChart canvas not found'
                    );

                    return;

                }


                /*
                 * No data
                 */

                if (!labels.length) {

                    return;

                }


                jobStatusChart =
                    new Chart(

                        canvas.getContext('2d'),

                        {

                            type: 'doughnut',

                            data: {

                                labels: labels,

                                datasets: [{

                                    data: values,

                                    backgroundColor:
                                        colors,

                                    borderColor:
                                        '#ffffff',

                                    borderWidth: 2

                                }]

                            },


                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                legend: {

                                    position:'bottom',
                                     labels: {
                                            fontFamily:
                                                "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

                                            fontSize: 12,

                                            fontStyle: 'normal',

                                            fontColor: '#666',

                                            boxWidth: 40,

                                            padding: 10
                                        }

                                },


                                /*
                                 * IMPORTANT:
                                 * Chart.js 2.x click event
                                 */

                                onClick:
                                    function(
                                        event,
                                        elements
                                    )
                                    {

                                        console.log(
                                            'Job status chart clicked',
                                            elements
                                        );


                                        if (
                                            !elements ||
                                            !elements.length
                                        ) {

                                            return;

                                        }


                                        var index =
                                            getChartElementIndex(
                                                elements[0]
                                            );


                                        if (
                                            index < 0 ||
                                            !labels[index]
                                        ) {

                                            return;

                                        }


                                        var status =
                                            labels[index];


                                        console.log(
                                            'Opening job status drilldown:',
                                            status
                                        );


                                        openDrilldown(
                                            'job_status',
                                            status
                                        );

                                    }

                            }

                        }

                    );

            }

        );

    }


    /* ============================================================
     * PRODUCTION QUANTITY CHART
     * ============================================================ */

    function loadProductionQuantityChart()
    {

        ajaxPost(

            '<?= base_url(
                "index.php/Production/get_production_quantity_chart"
            ); ?>',

            function(response)
            {

                var data =
                    $.isArray(response.data)
                        ? response.data
                        : [];


                var labels = [];
                var values = [];


                $.each(
                    data,
                    function(i, row)
                    {

                        labels.push(
                            row.label || ''
                        );


                        values.push(
                            parseFloat(
                                row.quantity || 0
                            )
                        );

                    }
                );


                productionQuantityChart =
                    destroyChart(
                        productionQuantityChart
                    );


                var canvas =
                    document.getElementById(
                        'productionQuantityChart'
                    );


                if (!canvas) {

                    return;

                }


                if (!labels.length) {

                    return;

                }


                productionQuantityChart =
                    new Chart(

                        canvas.getContext('2d'),

                        {

                            type: 'bar',

                            data: {

                                labels: labels,

                                datasets: [{

                                    label:
                                        'Quantity',

                                    data:
                                        values,

                                    backgroundColor:
                                        chartColors.slice(
                                            0,
                                            values.length
                                        ),

                                    borderColor:
                                        chartColors.slice(
                                            0,
                                            values.length
                                        ),

                                    borderWidth: 1

                                }]

                            },


                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                legend: {

                                    display:true,
                                     labels: {
                                            fontFamily:
                                                "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

                                            fontSize: 12,

                                            fontStyle: 'normal',

                                            fontColor: '#666',

                                            boxWidth: 40,

                                            padding: 10
                                        }

                                },


                                scales: {

                                    yAxes: [{

                                        ticks: {

                                            beginAtZero:
                                                true

                                        }

                                    }]

                                },


                                onClick:
                                    function(
                                        event,
                                        elements
                                    )
                                    {

                                        if (
                                            !elements ||
                                            !elements.length
                                        ) {

                                            return;

                                        }


                                        var index =
                                            getChartElementIndex(
                                                elements[0]
                                            );


                                        if (
                                            index < 0
                                        ) {

                                            return;

                                        }


                                        openDrilldown(

                                            'production_quantity',

                                            labels[index]

                                        );

                                    }

                            }

                        }

                    );

            }

        );

    }


    /* ============================================================
     * MONTHLY PRODUCTION
     * ============================================================ */

    function loadMonthlyProductionChart()
    {

        ajaxPost(

            '<?= base_url(
                "index.php/Production/get_monthly_production_chart"
            ); ?>',

            function(response)
            {

                var data =
                    $.isArray(response.data)
                        ? response.data
                        : [];


                var labels = [];
                var values = [];
                var months = [];


                $.each(
                    data,
                    function(i, row)
                    {

                        labels.push(
                            row.month_label || ''
                        );


                        months.push(
                            row.month || ''
                        );


                        values.push(
                            parseFloat(
                                row.completed_quantity || 0
                            )
                        );

                    }
                );


                monthlyProductionChart =
                    destroyChart(
                        monthlyProductionChart
                    );


                var canvas =
                    document.getElementById(
                        'monthlyProductionChart'
                    );


                if (!canvas) {

                    return;

                }


                if (!labels.length) {

                    return;

                }


                monthlyProductionChart =
                    new Chart(

                        canvas.getContext('2d'),

                        {

                            type: 'line',

                            data: {

                                labels: labels,

                                datasets: [{

                                    label:
                                        'Completed Quantity',

                                    data:
                                        values,

                                    fill:
                                        false,

                                    lineTension:
                                        0.2,

                                    borderColor:
                                        '#3498db',

                                    backgroundColor:
                                        '#3498db',

                                    pointBackgroundColor:
                                        '#e74c3c',

                                    pointBorderColor:
                                        '#ffffff',

                                    pointBorderWidth:
                                        2,

                                    pointRadius:
                                        5,

                                    pointHoverRadius:
                                        7

                                }]

                            },


                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                legend: {

                                    display: true,
                                     labels: {
                                            fontFamily:
                                                "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

                                            fontSize: 12,

                                            fontStyle: 'normal',

                                            fontColor: '#666',

                                            boxWidth: 40,

                                            padding: 10
                                        }

                                },


                                scales: {

                                    yAxes: [{

                                        ticks: {

                                            beginAtZero:
                                                true

                                        }

                                    }]

                                },


                                onClick:
                                    function(
                                        event,
                                        elements
                                    )
                                    {

                                        if (
                                            !elements ||
                                            !elements.length
                                        ) {

                                            return;

                                        }


                                        var index =
                                            getChartElementIndex(
                                                elements[0]
                                            );


                                        if (
                                            index < 0 ||
                                            !months[index]
                                        ) {

                                            return;

                                        }


                                        openDrilldown(

                                            'production_month',

                                            months[index]

                                        );

                                    }

                            }

                        }

                    );

            }

        );

    }


    /* ============================================================
     * MATERIAL REQUEST
     * ============================================================ */

    function loadMaterialRequestChart()
    {

        ajaxPost(

            '<?= base_url(
                "index.php/Production/get_material_request_chart"
            ); ?>',

            function(response)
            {

                var data =
                    $.isArray(response.data)
                        ? response.data
                        : [];


                var labels = [];
                var values = [];
                var colors = [];


                $.each(
                    data,
                    function(i, row)
                    {

                        var status =
                            row.status ||
                            'Unknown';


                        labels.push(
                            status
                        );


                        values.push(
                            parseInt(
                                row.total || 0,
                                10
                            )
                        );


                        var statusLower =
                            status.toLowerCase();


                        if (
                            statusLower ===
                            'pending'
                        ) {

                            colors.push(
                                '#f39c12'
                            );

                        }
                        else if (
                            statusLower ===
                            'approved'
                        ) {

                            colors.push(
                                '#2ecc71'
                            );

                        }
                        else if (
                            statusLower ===
                            'rejected'
                        ) {

                            colors.push(
                                '#e74c3c'
                            );

                        }
                        else if (
                            statusLower ===
                            'completed'
                        ) {

                            colors.push(
                                '#3498db'
                            );

                        }
                        else {

                            colors.push(
                                chartColors[
                                    i %
                                    chartColors.length
                                ]
                            );

                        }

                    }
                );


                materialRequestChart =
                    destroyChart(
                        materialRequestChart
                    );


                var canvas =
                    document.getElementById(
                        'materialRequestChart'
                    );


                if (!canvas) {

                    return;

                }


                if (!labels.length) {

                    return;

                }


                materialRequestChart =
                    new Chart(

                        canvas.getContext('2d'),

                        {

                            type: 'pie',

                            data: {

                                labels: labels,

                                datasets: [{

                                    data:
                                        values,

                                    backgroundColor:
                                        colors,

                                    borderColor:
                                        '#ffffff',

                                    borderWidth:
                                        2

                                }]

                            },


                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                legend: {

                                    position:'bottom',
                                     labels: {
                                            fontFamily:
                                                "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

                                            fontSize: 12,

                                            fontStyle: 'normal',

                                            fontColor: '#666',

                                            boxWidth: 40,

                                            padding: 10
                                        }

                                },


                                onClick:
                                    function(
                                        event,
                                        elements
                                    )
                                    {

                                        if (
                                            !elements ||
                                            !elements.length
                                        ) {

                                            return;

                                        }


                                        var index =
                                            getChartElementIndex(
                                                elements[0]
                                            );


                                        if (
                                            index < 0
                                        ) {

                                            return;

                                        }


                                        openDrilldown(

                                            'material_status',

                                            labels[index]

                                        );

                                    }

                            }

                        }

                    );

            }

        );

    }


    /* ============================================================
     * STOCK TRANSFER
     * ============================================================ */

    function loadStockTransferChart()
    {

        ajaxPost(

            '<?= base_url(
                "index.php/Production/get_stock_transfer_chart"
            ); ?>',

            function(response)
            {

                var data =
                    $.isArray(response.data)
                        ? response.data
                        : [];


                var labels = [];
                var values = [];
                var colors = [];


                $.each(
                    data,
                    function(i, row)
                    {

                        var status =
                            row.status ||
                            'Unknown';


                        labels.push(
                            status
                        );


                        values.push(
                            parseInt(
                                row.total || 0,
                                10
                            )
                        );


                        var statusLower =
                            status.toLowerCase();


                        if (
                            statusLower ===
                            'pending'
                        ) {

                            colors.push(
                                '#f39c12'
                            );

                        }
                        else if (
                            statusLower ===
                            'approved'
                        ) {

                            colors.push(
                                '#3498db'
                            );

                        }
                        else if (
                            statusLower ===
                            'completed'
                        ) {

                            colors.push(
                                '#2ecc71'
                            );

                        }
                        else if (
                            statusLower ===
                            'cancelled'
                        ) {

                            colors.push(
                                '#e74c3c'
                            );

                        }
                        else {

                            colors.push(
                                chartColors[
                                    i %
                                    chartColors.length
                                ]
                            );

                        }

                    }
                );


                stockTransferChart =
                    destroyChart(
                        stockTransferChart
                    );


                var canvas =
                    document.getElementById(
                        'stockTransferChart'
                    );


                if (!canvas) {

                    return;

                }


                if (!labels.length) {

                    return;

                }


                stockTransferChart =
                    new Chart(

                        canvas.getContext('2d'),

                        {

                            type: 'doughnut',

                            data: {

                                labels: labels,

                                datasets: [{

                                    data:
                                        values,

                                    backgroundColor:
                                        colors,

                                    borderColor:
                                        '#ffffff',

                                    borderWidth:
                                        2

                                }]

                            },


                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                legend: {

                                    position:'bottom',
                                     labels: {
                                        fontFamily:
                                            "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

                                        fontSize: 12,

                                        fontStyle: 'normal',

                                        fontColor: '#666',

                                        boxWidth: 40,

                                        padding: 10
                                    }

                                },


                                onClick:
                                    function(
                                        event,
                                        elements
                                    )
                                    {

                                        if (
                                            !elements ||
                                            !elements.length
                                        ) {

                                            return;

                                        }


                                        var index =
                                            getChartElementIndex(
                                                elements[0]
                                            );


                                        if (
                                            index < 0
                                        ) {

                                            return;

                                        }


                                        openDrilldown(

                                            'transfer_status',

                                            labels[index]

                                        );

                                    }

                            }

                        }

                    );

            }

        );

    }


    /* ============================================================
     * TOP PRODUCTS
     * ============================================================ */

    function loadTopProducts()
    {

        ajaxPost(

            '<?= base_url(
                "index.php/Production/get_top_production_products"
            ); ?>',

            function(response)
            {

                var data =
                    $.isArray(response.data)
                        ? response.data
                        : [];


                var labels = [];
                var values = [];


                $.each(
                    data,
                    function(i, row)
                    {

                        labels.push(
                            row.product_name || ''
                        );


                        values.push(
                            parseFloat(
                                row.completed_quantity || 0
                            )
                        );

                    }
                );


                topProductsChart =
                    destroyChart(
                        topProductsChart
                    );


                var canvas =
                    document.getElementById(
                        'topProductsChart'
                    );


                if (!canvas) {

                    return;

                }


                if (!labels.length) {

                    return;

                }


                topProductsChart =
                    new Chart(

                        canvas.getContext('2d'),

                        {

                            type: 'horizontalBar',

                            data: {

                                labels: labels,

                                datasets: [{

                                    label:
                                        'Completed Quantity',

                                    data:
                                        values,

                                    backgroundColor:
                                        chartColors.slice(
                                            0,
                                            values.length
                                        ),

                                    borderColor:
                                        chartColors.slice(
                                            0,
                                            values.length
                                        ),

                                    borderWidth:
                                        1

                                }]

                            },


                            options: {

                                responsive: true,

                                maintainAspectRatio: false,

                                legend: {

                                    display:true,
                                     labels: {
                                        fontFamily:
                                            "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",

                                        fontSize: 12,

                                        fontStyle: 'normal',

                                        fontColor: '#666',

                                        boxWidth: 40,

                                        padding: 10
                                    }

                                },


                                scales: {

                                    xAxes: [{

                                        ticks: {

                                            beginAtZero:
                                                true

                                        }

                                    }]

                                },


                                onClick:
                                    function(
                                        event,
                                        elements
                                    )
                                    {

                                        if (
                                            !elements ||
                                            !elements.length
                                        ) {

                                            return;

                                        }


                                        var index =
                                            getChartElementIndex(
                                                elements[0]
                                            );


                                        if (
                                            index < 0
                                        ) {

                                            return;

                                        }

                                        /*
                                        openDrilldown(

                                            'production_product',

                                            labels[index]

                                        );*/

                                    }

                            }

                        }

                    );

            }

        );

    }


    /* ============================================================
     * DESTROY DRILLDOWN DATATABLE
     * ============================================================ */

    function destroyDrilldownTable()
    {

        if (
            $.fn.DataTable &&
            $.fn.DataTable.isDataTable(
                '#drilldownTable'
            )
        ) {

            try {

                $('#drilldownTable')
                    .DataTable()
                    .clear()
                    .destroy();

            }
            catch (e) {

                console.error(
                    'DataTable destroy error:',
                    e
                );

            }

        }


        drilldownTable = null;


        /*
         * Completely reset table HTML.
         * This is important after DataTables destroy.
         */

        $('#drilldownTable')
            .find('thead')
            .html('');


        $('#drilldownTable')
            .find('tbody')
            .html('');

    }


    /* ============================================================
     * OPEN DRILLDOWN
     * ============================================================ */

    function openDrilldown(type, value)
    {

        console.log(
            'OPEN DRILLDOWN:',
            type,
            value
        );


        var $modal =
            $('#productionDrilldownModal');


        /*
         * Destroy previous DataTable
         */

        if (
            $.fn.DataTable &&
            $.fn.DataTable.isDataTable(
                '#drilldownTable'
            )
        ) {

            try {

                $('#drilldownTable')
                    .DataTable()
                    .clear()
                    .destroy();

            }
            catch (e) {

                console.error(e);

            }

        }


        drilldownTable = null;


        /*
         * Clear table
         */

        $('#drilldownHead').html('');
        $('#drilldownBody').html('');


        /*
         * Show loading
         */

        $('#drilldownLoading').show();


        /*
         * Title
         */

        var title =
            'Production Details';


        if (
            type === 'job_status'
        ) {

            title =
                'Job Order Status - ' +
                value;

        }
        else if (
            type === 'production_quantity'
        ) {

            title =
                'Production Quantity - ' +
                value;

        }
        else if (
            type === 'production_month'
        ) {

            title =
                'Monthly Production - ' +
                value;

        }
        else if (
            type === 'material_status'
        ) {

            title =
                'Material Requests - ' +
                value;

        }
        else if (
            type === 'transfer_status'
        ) {

            title =
                'Stock Transfers - ' +
                value;

        }
        else if (
            type === 'production_product'
        ) {

            title =
                'Production Product - ' +
                value;

        }


        $('#drilldownTitle')
            .text(title);


        /*
         * Show modal
         */

        $modal.modal('show');


        /*
         * AJAX
         */

        $.ajax({

            url:
                '<?= base_url(
                    "index.php/Production/get_production_drilldown"
                ); ?>',

            type:
                'POST',

            dataType:
                'json',

            data:
                $.extend(
                    {},
                    getDashboardFilters(),
                    {
                        type:
                            type,

                        value:
                            value
                    }
                ),


            success:
                function(response)
                {

                    console.log(
                        'Drilldown response:',
                        response
                    );


                    var data =
                        $.isArray(
                            response.data
                        )
                        ? response.data
                        : [];


                    /*
                     * Render table
                     */

                    renderDrilldown(
                        type,
                        data
                    );


                    /*
                     * IMPORTANT:
                     *
                     * Only initialize DataTables
                     * when there are actual rows.
                     */

                    if (
                        data.length > 0
                    ) {

                        initializeDrilldownDataTable();

                    }
                    else {

                        $('#drilldownLoading')
                            .hide();

                    }

                },


            error:
                function(xhr)
                {

                    console.error(
                        'Drilldown AJAX Error:',
                        xhr.responseText
                    );


                    $('#drilldownLoading')
                        .hide();


                    /*
                     * Do NOT create a colspan row
                     * and initialize DataTables.
                     */

                    $('#drilldownHead').html(
                        '<tr>' +
                            '<th>#</th>' +
                            '<th>Message</th>' +
                        '</tr>'
                    );


                    $('#drilldownBody').html(
                        '<tr>' +
                            '<td>1</td>' +
                            '<td class="text-danger">' +
                                'Unable to load details.' +
                            '</td>' +
                        '</tr>'
                    );

                }

        });

    }


    /* ============================================================
     * INITIALIZE DRILLDOWN DATATABLE
     * ============================================================ */

    function initializeDrilldownDataTable()
    {

        var $table =
            $('#drilldownTable');


        if (!$table.length) {

            console.error(
                'drilldownTable not found'
            );

            return;

        }


        /*
         * Make sure there is at least
         * one real data row.
         */

        var rowCount =
            $('#drilldownTable tbody tr')
                .length;


        if (!rowCount) {

            $('#drilldownLoading')
                .hide();

            return;

        }


        /*
         * Header count
         */

        var headerCount =
            $('#drilldownTable thead tr:first th')
                .length;


        /*
         * Validate every row
         */

        var valid =
            true;


        $('#drilldownTable tbody tr')
            .each(
                function()
                {

                    var cellCount =
                        $(this)
                            .children('td')
                            .length;


                    if (
                        cellCount !==
                        headerCount
                    ) {

                        console.error(
                            'DataTable column mismatch',
                            {
                                header:
                                    headerCount,

                                body:
                                    cellCount
                            }
                        );


                        valid = false;

                    }

                }
            );


        if (!valid) {

            $('#drilldownLoading')
                .hide();

            return;

        }


        /*
         * Initialize
         */

        try {

            drilldownTable =
                $table.DataTable({

                    destroy:
                        true,

                    responsive:
                        false,

                    autoWidth:
                        false,

                    pageLength:
                        10,

                    lengthMenu: [

                        [
                            10,
                            20,
                            50,
                            100,
                            -1
                        ],

                        [
                            10,
                            20,
                            50,
                            100,
                            'All'
                        ]

                    ],


                    dom:
                        '<"dt-top-row"' +

                            '<"dt-length"l>' +

                            '<"dt-buttons"B>' +

                            '<"dt-search"f>' +

                        '>' +

                        'rtip',


                    buttons: [

                        {
                            extend:
                                'excelHtml5',

                            title:
                                'Production Details'
                        },

                        {
                            extend:
                                'csvHtml5',

                            title:
                                'Production Details'
                        },

                        {
                            extend:
                                'pdfHtml5',

                            title:
                                'Production Details'
                        },

                        {
                            extend:
                                'print',

                            title:
                                'Production Details'
                        }

                    ],


                    order: [
                        [0, 'asc']
                    ]

                });


        }
        catch (e) {

            console.error(
                'DataTable initialization error:',
                e
            );

        }


        $('#drilldownLoading')
            .hide();

    }


    /* ============================================================
     * RENDER DRILLDOWN
     * ============================================================ */

    function renderDrilldown(type, data)
    {

        var head = '';
        var body = '';


        /*
         * ========================================================
         * JOB STATUS
         * ========================================================
         */

        if (
            type === 'job_status'
        ) {

            head =
                '<tr>' +

                    '<th>#</th>' +

                    '<th>Job Order</th>' +

                    '<th>Project</th>' +

                    '<th>Order Date</th>' +

                    '<th>Status</th>' +

                    '<th>Ordered</th>' +

                    '<th>Completed</th>' +

                    '<th>Remaining</th>' +

                '</tr>';


            $.each(
                data,
                function(i, row)
                {

                    body +=

                        '<tr>' +

                            '<td>' +
                                (i + 1) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_order_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.project_name
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.order_date
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.status
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.ordered_quantity
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.completed_quantity
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.remaining_quantity
                                ) +
                            '</td>' +

                        '</tr>';

                }
            );

        }


        /*
         * ========================================================
         * PRODUCTION QUANTITY
         * ========================================================
         */

        else if (
            type === 'production_quantity'
        ) {

            head =
                '<tr>' +

                    '<th>#</th>' +

                    '<th>Job Order</th>' +

                    '<th>Project</th>' +

                    '<th>Order Date</th>' +

                    '<th>Status</th>' +

                    '<th>Ordered</th>' +

                    '<th>Completed</th>' +

                    '<th>Remaining</th>' +

                '</tr>';


            $.each(
                data,
                function(i, row)
                {

                    body +=

                        '<tr>' +

                            '<td>' +
                                (i + 1) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_order_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.project_name
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.order_date
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.status
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.ordered_quantity
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.completed_quantity
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.remaining_quantity
                                ) +
                            '</td>' +

                        '</tr>';

                }
            );

        }


        /*
         * ========================================================
         * MONTHLY PRODUCTION
         * ========================================================
         */

        else if (
            type === 'production_month'
        ) {

            head =
                '<tr>' +

                    '<th>#</th>' +

                    '<th>Completion No</th>' +

                    '<th>Date</th>' +

                    '<th>Job Order</th>' +

                    '<th>Project</th>' +

                    '<th>Product</th>' +

                    '<th>Completed</th>' +

                    '<th>Unit</th>' +

                '</tr>';


            $.each(
                data,
                function(i, row)
                {

                    body +=

                        '<tr>' +

                            '<td>' +
                                (i + 1) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_completion_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.completion_date
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_order_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.project_name
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.product_name
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.completed_quantity
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.unit
                                ) +
                            '</td>' +

                        '</tr>';

                }
            );

        }


        /*
         * ========================================================
         * MATERIAL REQUEST
         * ========================================================
         */

        else if (
            type === 'material_status'
        ) {

            head =
                '<tr>' +

                    '<th>#</th>' +

                    '<th>Request No</th>' +

                    '<th>Date</th>' +

                    '<th>Job Order</th>' +

                    '<th>Project</th>' +

                    '<th>Status</th>' +

                '</tr>';


            $.each(
                data,
                function(i, row)
                {

                    body +=

                        '<tr>' +

                            '<td>' +
                                (i + 1) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.material_request_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.request_date
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_order_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.project_name
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.status
                                ) +
                            '</td>' +

                        '</tr>';

                }
            );

        }


        /*
         * ========================================================
         * STOCK TRANSFER
         * ========================================================
         */

        else if (
            type === 'transfer_status'
        ) {

            head =
                '<tr>' +

                    '<th>#</th>' +

                    '<th>Transfer No</th>' +

                    '<th>Reference</th>' +

                    '<th>Date</th>' +

                    '<th>Job Order</th>' +

                    '<th>Project</th>' +

                    '<th>Status</th>' +

                '</tr>';


            $.each(
                data,
                function(i, row)
                {

                    body +=

                        '<tr>' +

                            '<td>' +
                                (i + 1) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.stock_transfer_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.ref_number
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.ref_date
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_order_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.project_name
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.status
                                ) +
                            '</td>' +

                        '</tr>';

                }
            );

        }


        /*
         * ========================================================
         * TOP PRODUCTS
         * ========================================================
         */

        else if (
            type === 'production_product'
        ) {

            head =
                '<tr>' +

                    '<th>#</th>' +

                    '<th>Product</th>' +

                    '<th>Job Order</th>' +

                    '<th>Project</th>' +

                    '<th>Completion No</th>' +

                    '<th>Date</th>' +

                    '<th>Completed</th>' +

                    '<th>Unit</th>' +

                '</tr>';


            $.each(
                data,
                function(i, row)
                {

                    body +=

                        '<tr>' +

                            '<td>' +
                                (i + 1) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.product_name
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_order_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.project_name
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.job_completion_no
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.completion_date
                                ) +
                            '</td>' +

                            '<td class="text-right">' +
                                numberFormat(
                                    row.completed_quantity
                                ) +
                            '</td>' +

                            '<td>' +
                                escapeHtml(
                                    row.unit
                                ) +
                            '</td>' +

                        '</tr>';

                }
            );

        }


        /*
         * ========================================================
         * NO DATA
         *
         * IMPORTANT:
         * DO NOT PUT COLSPAN IN TBODY IF DATATABLES WILL
         * BE INITIALIZED.
         * ========================================================
         */

        if (!body) {

            /*
             * Header still displayed.
             */

            $('#drilldownHead')
                .html(head);


            /*
             * Do NOT create colspan row.
             */

            var columnCount =
                $(head)
                    .filter('tr')
                    .find('th')
                    .length;


            if (!columnCount) {

                columnCount = 1;

            }


            /*
             * Create a normal row with
             * exactly the same number of TDs.
             */

            var emptyCells = '';


            for (
                var i = 0;
                i < columnCount;
                i++
            ) {

                if (i === 0) {

                    emptyCells +=
                        '<td class="text-center text-muted">' +
                            'No records found.' +
                        '</td>';

                }
                else {

                    emptyCells +=
                        '<td></td>';

                }

            }


            $('#drilldownBody')
                .html(
                    '<tr>' +
                        emptyCells +
                    '</tr>'
                );


            $('#drilldownLoading')
                .hide();


            return;

        }


        /*
         * Put table HTML
         */

        $('#drilldownHead')
            .html(head);


        $('#drilldownBody')
            .html(body);

    }


    /* ============================================================
     * LOAD DASHBOARD
     * ============================================================ */

    function loadDashboard()
    {

        loadSummary();

        loadJobStatusChart();

        loadProductionQuantityChart();

        loadMonthlyProductionChart();

        loadMaterialRequestChart();

        loadStockTransferChart();

        loadTopProducts();

    }


    /* ============================================================
     * APPLY FILTER
     * ============================================================ */

    $('#applyDashboardFilter')
        .off('click.dashboard')
        .on(
            'click.dashboard',
            function()
            {

                loadDashboard();

            }
        );


    /* ============================================================
     * RESET FILTER
     * ============================================================ */

    $('#resetDashboardFilter')
        .off('click.dashboard')
        .on(
            'click.dashboard',
            function()
            {

                $('#dashboard_from_date')
                    .val('');


                $('#dashboard_to_date')
                    .val('');


                $('#dashboard_project_id')
                    .val('')
                    .trigger('change');


                loadDashboard();

            }
        );


    /* ============================================================
     * MODAL CLOSE
     * ============================================================ */

    $('#productionDrilldownModal')
        .off('hidden.bs.modal.dashboard')
        .on(
            'hidden.bs.modal.dashboard',
            function()
            {

                /*
                 * Destroy DataTable only if it exists.
                 */

                if (
                    $.fn.DataTable &&
                    $.fn.DataTable.isDataTable(
                        '#drilldownTable'
                    )
                ) {

                    try {

                        $('#drilldownTable')
                            .DataTable()
                            .clear()
                            .destroy();

                    }
                    catch (e) {

                        console.error(e);

                    }

                }


                drilldownTable = null;


                /*
                 * Clear table
                 */

                $('#drilldownHead')
                    .html('');


                $('#drilldownBody')
                    .html('');


                $('#drilldownLoading')
                    .hide();

            }
        );


    /* ============================================================
     * INITIAL LOAD
     * ============================================================ */

    loadDashboard();

});

</script>