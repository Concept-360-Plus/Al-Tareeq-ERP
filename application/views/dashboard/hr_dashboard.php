<style>
    .hr-dashboard {
        padding: 10px 0;
    }

    .hr-kpi {
        position: relative;
        padding: 20px;
        border-radius: 8px;
        background: #fff;
        min-height: 135px;
        margin-bottom: 20px;
        border: 1px solid #e8e8e8;
        border-top: 4px solid #5b7c99;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
        cursor: pointer;
        transition: .2s;
    }

    .hr-kpi:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, .10);
    }

    .hr-kpi h4 {
        margin: 0 0 10px;
        font-size: 14px;
        color: #555;
    }

    .hr-kpi h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
        color: #4f6f8f;
    }

    .hr-kpi small {
        color: #888;
    }

    .hr-kpi-icon {
        position: absolute;
        right: 18px;
        top: 20px;
        font-size: 28px;
        opacity: .25;
        color: #5b7c99;
    }

    .hr-panel {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 18px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .hr-panel h4 {
        margin-top: 0;
        margin-bottom: 18px;
        font-size: 16px;
        font-weight: 600;
    }

    .hr-table {
        font-size: 12px;
    }

    .hr-table th {
        background: #f7f7f7;
    }

    .hr-quick-action {
        display: block;
        padding: 15px;
        text-align: center;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 15px;
        color: #555;
        transition: .2s;
    }

    .hr-quick-action:hover {
        text-decoration: none;
        background: #f8f8f8;
        transform: translateY(-2px);
    }

    .hr-quick-action i {
        display: block;
        font-size: 22px;
        margin-bottom: 8px;
    }
</style>


<div class="hr-dashboard">

    <!-- =====================================================
         KPI ROW 1
    ===================================================== -->

    <div class="row">

        <div class="col-lg-3 col-md-6">
            <a href="<?= site_url('Users/view_employee_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-users hr-kpi-icon"></i>

                    <h4>Employees</h4>

                    <h2>
                        <?= number_format($employee_count); ?>
                    </h2>

                    <small>Total employees</small>

                </div>

            </a>
        </div>


        <div class="col-lg-3 col-md-6">
            <a href="<?= site_url('Hr/view_emp_attendance_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-calendar-check-o hr-kpi-icon"></i>

                    <h4>Attendance Today</h4>

                    <h2>
                        <?= number_format(
                            $today_present
                                + $today_absent
                                + $today_leave
                        ); ?>
                    </h2>

                    <small>
                        P:
                        <?= $today_present; ?>
                        &nbsp;
                        A:
                        <?= $today_absent; ?>
                        &nbsp;
                        L:
                        <?= $today_leave; ?>
                    </small>

                </div>

            </a>
        </div>


        <div class="col-lg-3 col-md-6">

            <a href="<?= site_url('Hr/view_leave_application_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-calendar-minus-o hr-kpi-icon"></i>

                    <h4>Leave Requests</h4>

                    <h2>
                        <?= number_format($leave_request_count); ?>
                    </h2>

                    <small>This month</small>

                </div>

            </a>

        </div>


        <div class="col-lg-3 col-md-6">

            <a href="<?= site_url('Hr/view_emp_monthly_salary_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-money hr-kpi-icon"></i>

                    <h4>Payroll Cost</h4>

                    <h2 style="font-size:23px;">
                        <?= number_format($payroll_cost, 2); ?>
                    </h2>

                    <small>Current month</small>

                </div>

            </a>

        </div>

    </div>


    <!-- =====================================================
         KPI ROW 2
    ===================================================== -->

    <div class="row">

        <div class="col-lg-3 col-md-6">

            <a href="<?= site_url('Hr/view_joining_application_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-user-plus hr-kpi-icon"></i>

                    <h4>New Hires</h4>

                    <h2>
                        <?= number_format($new_hires); ?>
                    </h2>

                    <small>This month</small>

                </div>

            </a>

        </div>


        <div class="col-lg-3 col-md-6">

            <a href="<?= site_url('Hr/view_emp_resignation_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-user-times hr-kpi-icon"></i>

                    <h4>Resignations</h4>

                    <h2>
                        <?= number_format($resignations); ?>
                    </h2>

                    <small>This month</small>

                </div>

            </a>

        </div>


        <div class="col-lg-3 col-md-6">

            <a href="<?= site_url('Hr/view_leave_application_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-clock-o hr-kpi-icon"></i>

                    <h4>Pending Leave</h4>

                    <h2>
                        <?= number_format($pending_leave); ?>
                    </h2>

                    <small>Awaiting approval</small>

                </div>

            </a>

        </div>


        <div class="col-lg-3 col-md-6">

            <a href="<?= site_url('Hr/view_emp_monthly_salary_list'); ?>"
                style="text-decoration:none;color:inherit;">

                <div class="hr-kpi">

                    <i class="fa fa-exclamation-circle hr-kpi-icon"></i>

                    <h4>Payroll Pending</h4>

                    <h2>
                        <?= number_format($payroll_pending); ?>
                    </h2>

                    <small>Salary not generated</small>

                </div>

            </a>

        </div>

    </div>

    <!-- =====================================================
         ATTENDANCE + EMPLOYEE MOVEMENT
    ===================================================== -->

    <div class="row">

        <div class="col-md-6">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-line-chart"></i>
                    Attendance Trend
                    <small style="font-size:11px;color:#999;">
                        Last 7 Days
                    </small>
                </h4>

                <canvas id="attendanceTrendChart"
                    height="120"></canvas>

            </div>

        </div>


        <div class="col-md-6">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-bar-chart"></i>
                    Employee Movement
                    <small style="font-size:11px;color:#999;">
                        Current Year
                    </small>
                </h4>

                <canvas id="employeeMovementChart"
                    height="120"></canvas>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-5">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-pie-chart"></i>
                    Leave Analysis
                </h4>

                <canvas id="leaveAnalysisChart"
                    height="180"></canvas>

            </div>

        </div>


        <div class="col-md-7">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-money"></i>
                    Monthly Payroll Cost
                </h4>

                <canvas id="payrollTrendChart"
                    height="180"></canvas>

            </div>

        </div>

    </div>

    <!-- =====================================================
         PENDING LEAVE + TODAY ATTENDANCE
    ===================================================== -->

    <div class="row">

        <div class="col-md-7">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-clock-o"></i>
                    Pending Leave Applications

                    <a href="<?= site_url('Hr/view_leave_application_list'); ?>"
                        class="pull-right"
                        style="font-size:12px;">
                        View All
                    </a>
                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered table-striped hr-table">

                        <thead>

                            <tr>
                                <th>Employee</th>
                                <th>Leave</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($pending_leave_list)) { ?>

                                <?php foreach ($pending_leave_list as $row) { ?>

                                    <tr>

                                        <td>
                                            <?= html_escape(
                                                $row->employee_name
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= html_escape(
                                                $row->leave_type
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= date(
                                                'd-m-Y',
                                                strtotime($row->start_date)
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= date(
                                                'd-m-Y',
                                                strtotime($row->end_date)
                                            ); ?>
                                        </td>

                                        <td>
                                            <span class="label label-warning">
                                                Pending
                                            </span>
                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="5"
                                        class="text-center text-muted">

                                        No pending leave applications

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-md-5">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-calendar-check-o"></i>
                    Today's Attendance

                    <a href="<?= site_url('Hr/view_emp_attendance_list'); ?>"
                        class="pull-right"
                        style="font-size:12px;">
                        View All
                    </a>
                </h4>


                <div class="table-responsive">

                    <table class="table table-bordered table-striped hr-table">

                        <thead>

                            <tr>
                                <th>Employee</th>
                                <th>Status</th>
                                <th>In</th>
                                <th>Out</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($today_attendance_list)) { ?>

                                <?php foreach ($today_attendance_list as $row) { ?>

                                    <tr>

                                        <td>
                                            <?= html_escape(
                                                $row->employee_name
                                            ); ?>
                                        </td>

                                        <td>

                                            <?php
                                            $status =
                                                strtolower(
                                                    $row->attendence
                                                );

                                            if ($status == 'present') {
                                                $class = 'success';
                                            } elseif ($status == 'absent') {
                                                $class = 'danger';
                                            } else {
                                                $class = 'warning';
                                            }
                                            ?>

                                            <span class="label label-<?= $class; ?>">
                                                <?= ucfirst($status); ?>
                                            </span>

                                        </td>

                                        <td>
                                            <?= !empty($row->in_time)
                                                ? date(
                                                    'H:i',
                                                    strtotime($row->in_time)
                                                )
                                                : '-'; ?>
                                        </td>

                                        <td>
                                            <?= !empty($row->out_time)
                                                ? date(
                                                    'H:i',
                                                    strtotime($row->out_time)
                                                )
                                                : '-'; ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="4"
                                        class="text-center text-muted">

                                        No attendance recorded today

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-user-plus"></i>
                    Recent Joining
                </h4>

                <table class="table table-bordered table-striped hr-table">

                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Joining Date</th>
                            <th>Type</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($recent_joinings as $row) { ?>

                            <tr>

                                <td>
                                    <?= html_escape(
                                        $row->employee_name
                                    ); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($row->joining_date)
                                    ); ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $row->joining_type
                                    ); ?>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>


        <div class="col-md-6">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-user-times"></i>
                    Recent Resignations
                </h4>

                <table class="table table-bordered table-striped hr-table">

                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Resignation</th>
                            <th>Last Working</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($recent_resignations as $row) { ?>

                            <tr>

                                <td>
                                    <?= html_escape(
                                        $row->employee_name
                                    ); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($row->resignation_date)
                                    ); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($row->last_working_date)
                                    ); ?>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-user-plus"></i>
                    Recent Joining
                </h4>

                <table class="table table-bordered table-striped hr-table">

                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Joining Date</th>
                            <th>Type</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($recent_joinings as $row) { ?>

                            <tr>

                                <td>
                                    <?= html_escape(
                                        $row->employee_name
                                    ); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($row->joining_date)
                                    ); ?>
                                </td>

                                <td>
                                    <?= html_escape(
                                        $row->joining_type
                                    ); ?>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>


        <div class="col-md-6">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-user-times"></i>
                    Recent Resignations
                </h4>

                <table class="table table-bordered table-striped hr-table">

                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Resignation</th>
                            <th>Last Working</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($recent_resignations as $row) { ?>

                            <tr>

                                <td>
                                    <?= html_escape(
                                        $row->employee_name
                                    ); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($row->resignation_date)
                                    ); ?>
                                </td>

                                <td>
                                    <?= date(
                                        'd-m-Y',
                                        strtotime($row->last_working_date)
                                    ); ?>
                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- =====================================================
         QUICK ACTIONS
    ===================================================== -->

    <div class="row">

        <div class="col-md-12">

            <div class="hr-panel">

                <h4>
                    <i class="fa fa-bolt"></i>
                    Quick Actions
                </h4>

                <div class="row">

                    <div class="col-md-2">
                        <a href="<?= site_url('Hr/add_leave_application'); ?>"
                            class="hr-quick-action">
                            <i class="fa fa-calendar-plus-o"></i>
                            Leave Application
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a href="<?= site_url('Hr/add_emp_attendance'); ?>"
                            class="hr-quick-action">
                            <i class="fa fa-calendar-check-o"></i>
                            Attendance
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a href="<?= site_url('Hr/add_joining_application'); ?>"
                            class="hr-quick-action">
                            <i class="fa fa-user-plus"></i>
                            Joining
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a href="<?= site_url('Hr/add_emp_overtime'); ?>"
                            class="hr-quick-action">
                            <i class="fa fa-clock-o"></i>
                            Overtime
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a href="<?= site_url('Hr/add_monthly_salary'); ?>"
                            class="hr-quick-action">
                            <i class="fa fa-money"></i>
                            Generate Salary
                        </a>
                    </div>

                    <div class="col-md-2">
                        <a href="<?= site_url('Hr/add_resignation'); ?>"
                            class="hr-quick-action">
                            <i class="fa fa-user-times"></i>
                            Resignation
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function() {

            /* ==========================================
               ATTENDANCE TREND
            ========================================== */

            const attendanceData =
                <?= json_encode($attendance_trend); ?>;

            new Chart(
                document.getElementById(
                    'attendanceTrendChart'
                ), {
                    type: 'line',

                    data: {

                        labels: attendanceData.map(
                            x => x.attendance_date
                        ),

                        datasets: [

                            {
                                label: 'Present',
                                data: attendanceData.map(
                                    x => x.present
                                ),
                                tension: 0.3
                            },

                            {
                                label: 'Absent',
                                data: attendanceData.map(
                                    x => x.absent
                                ),
                                tension: 0.3
                            },

                            {
                                label: 'Leave',
                                data: attendanceData.map(
                                    x => x.leave_count
                                ),
                                tension: 0.3
                            }

                        ]

                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }

                }
            );


            /* ==========================================
               EMPLOYEE MOVEMENT
            ========================================== */

            const movement =
                <?= json_encode($employee_movement); ?>;

            new Chart(
                document.getElementById(
                    'employeeMovementChart'
                ), {
                    type: 'bar',

                    data: {

                        labels: [
                            'Jan', 'Feb', 'Mar', 'Apr',
                            'May', 'Jun', 'Jul', 'Aug',
                            'Sep', 'Oct', 'Nov', 'Dec'
                        ],

                        datasets: [

                            {
                                label: 'New Hires',

                                data: movement.map(
                                    x => x.new_hires
                                )
                            },

                            {
                                label: 'Resignations',

                                data: movement.map(
                                    x => x.resignations
                                )
                            }

                        ]

                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }

                }
            );


            /* ==========================================
               LEAVE ANALYSIS
            ========================================== */

            const leaveData =
                <?= json_encode($leave_analysis); ?>;

            new Chart(
                document.getElementById(
                    'leaveAnalysisChart'
                ), {
                    type: 'doughnut',

                    data: {

                        labels: leaveData.map(
                            x => x.leave_type
                        ),

                        datasets: [{
                            data: leaveData.map(
                                x => x.total
                            )
                        }]

                    },

                    options: {
                        responsive: true
                    }

                }
            );


            /* ==========================================
               PAYROLL TREND
            ========================================== */

            const payroll =
                <?= json_encode($payroll_trend); ?>;

            new Chart(
                document.getElementById(
                    'payrollTrendChart'
                ), {
                    type: 'line',

                    data: {

                        labels: payroll.map(
                            x => x.month
                        ),

                        datasets: [

                            {
                                label: 'Gross Payroll',

                                data: payroll.map(
                                    x => x.gross_salary
                                ),

                                tension: 0.3
                            }

                        ]

                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }

                }
            );

        }
    );
</script>