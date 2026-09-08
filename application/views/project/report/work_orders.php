<div class="x_panel">

    <div class="x_title">
        <h2>Work Orders</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

<?php if(!empty($work_orders)){ ?>

<table class="table table-bordered">
<tbody>
<thead>
    <tr>
    <th width="15%">WO Code</th>
    <th width="15%">WO Date</th>
    <th width="10%">Fabrication Manhours</th>
    <th width="10%">Installation Manhour</th>
    <th width="10%">Status</th>
</thead>
</tr>

<?php foreach($work_orders as $wo){ ?>


<tr class="">

    <td width="20%"><?= $wo->wo_code; ?></td>
    <td width="20%">
        <?= date('d-m-Y',strtotime($wo->work_order_date)); ?>
    </td>
    <td width="10%">
       <?= $wo->fabrication_manhr; ?>
    </td>
    <td width="10%">
       <?= $wo->installation_manhr; ?>
    </td>
    
    <td width="10%">
        <?= $wo->status; ?>
    </td>

</tr>

</table>

<?php } ?>

<?php } else { ?>

<div class="alert alert-warning">
No Work Orders Available.
</div>

<?php } ?>

    </div>

</div>