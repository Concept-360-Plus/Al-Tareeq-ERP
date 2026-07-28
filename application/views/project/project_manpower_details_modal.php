<style>
/* Popup Header */
.popup-title{
    font-size:16px;
    font-weight:600;
    margin:10px 0;
}

/* Project Info */
.popup-info th,
.popup-info td{
    padding:8px 10px;
    font-size:13px;
    vertical-align:middle;
}

.popup-info th{
    width:160px;
    background:#f7f7f7;
    font-weight:600;
    white-space:nowrap;
}

/* Assigned Table */
.popup-table{
    font-size:13px;
    margin-bottom:0;
}

.popup-table th{
    background:#f5f5f5;
    font-size:13px;
    font-weight:600;
    text-align:center;
    vertical-align:middle;
    padding:8px 6px;
    white-space:nowrap;
}

.popup-table td{
    padding:8px 6px;
    text-align:center;
    vertical-align:middle;
    white-space:nowrap;
}

/* Keep only Remarks expandable */
.popup-table td:last-child{
    white-space:normal;
    text-align:left;
    min-width:120px;
}

.badge-active{
    background:#28a745;
    color:#fff;
    padding:3px 10px;
    border-radius:3px;
    font-size:12px;
}

.badge-inactive{
    background:#dc3545;
    color:#fff;
    padding:3px 10px;
    border-radius:3px;
    font-size:12px;
}

.modal-body{
    font-size:13px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered popup-info">
    <tr>
        <th width="20%">Project</th>
        <td width="30%">
            <?= htmlspecialchars(($resource['project']['project_code'] ?? '').' - '.($resource['project']['project_name'] ?? '')) ?>
        </td>

        <th width="20%">Approved By</th>
        <td width="30%">
            <?= htmlspecialchars($resource['project']['user_name'] ?? '') ?>
        </td>
    </tr>

    <tr>
        <th>Remarks</th>
        <td>
            <?= nl2br(htmlspecialchars($resource['remarks'] ?? '')) ?>
        </td>

        <th>Status</th>
        <td>
            <?php if(!empty($resource['bit_active'])){ ?>
                <span class="badge-active">Active</span>
            <?php }else{ ?>
                <span class="badge-inactive">Inactive</span>
            <?php } ?>
        </td>
    </tr>
</table>
    </div>
</div>

<?php if (!empty($resource['items'])) { ?>
    <h4 class="popup-title">Assigned Manpower</h4>

<div class="table-responsive">

<table class="table table-bordered table-striped popup-table">

<thead>

<tr>
    <th width="15%">Designation</th>
    <th width="15%">Employee</th>
    <th width="12%">Role</th>
    <th width="10%">Allocation %</th>
    <th width="10%">Daily Hours</th>
    <th width="10%">From</th>
    <th width="10%">To</th>
    <th width="10%">Status</th>
    <th width="18%">Remarks</th>
</tr>

</thead>

<tbody>

<?php foreach($resource['items'] as $item){ ?>

<tr>

    <td><?= htmlspecialchars($item['designation_name']) ?></td>

    <td><?= htmlspecialchars($item['employee_name']) ?></td>

    <td><?= htmlspecialchars($item['role']) ?></td>

    <td class="text-center"><?= number_format($item['allocation_percentage'],2) ?>%</td>

    <td class="text-center"><?= number_format($item['daily_hours'],2) ?></td>

    <td><?= date('d-m-Y',strtotime($item['from_date'])) ?></td>

    <td><?= date('d-m-Y',strtotime($item['to_date'])) ?></td>

    <td class="text-center"><?= htmlspecialchars($item['status']) ?></td>

    <td><?= htmlspecialchars($item['remarks']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
<?php } else { ?>
    <p class="text-muted">No manpower items found.</p>
<?php } ?>
