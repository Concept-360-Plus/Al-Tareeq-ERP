<style>
    .bg-light {
        background-color: #4f5250;
        }
</style>
<div class="x_panel">

    <div class="x_title">
        <h2>Outsource Details</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

<?php if(!empty($outsource)){ ?>

<?php foreach($outsource as $k=> $os){ ?>
<b>#<?= $k+1 ?></b>
<table class="table table-bordered">

<tr class="bg-light">
    <th width="15%">Supplier</th>
    <td width="20%"><?= $os->supplier_name; ?></td>

    <th width="15%">Outsource Date</th>
    <td width="15%">
        <?= date('d-m-Y',strtotime($os->outsource_date)); ?>
    </td>

    <th width="15%">Finish Date</th>
    <td width="15%">
        <?= !empty($os->outsource_finish_date) ? date('d-m-Y',strtotime($os->outsource_finish_date)) : '-'; ?>
    </td>

    <th width="10%">Status</th>
    <td width="10%">
        <?= $os->status; ?>
    </td>

</tr>

</table>

<table class="table table-bordered table-striped">

<thead>

<tr>

<th width="5%">#</th>
<th>Type</th>
<th>Nature of Work</th>
<th>Outsource Item</th>
<th>Description</th>
<th width="10%">Qty</th>
<th width="10%">Price</th>

</tr>

</thead>

<tbody>

<?php

$items=$this->Project_model->get_outsource_items_repo($os->outsource_id);

if(!empty($items))
{

$i=1;

foreach($items as $item){

?>

<tr>

<td><?= $i++; ?></td>

<td><?= $item->outsource_type; ?></td>

<td><?= $item->nature_work; ?></td>

<td><?= $item->outsource_item; ?></td>

<td><?= $item->product_desc; ?></td>

<td class="text-right">
<?= number_format($item->quantity,2); ?>
</td>

<td class="text-right">
<?= number_format($item->item_price,2); ?>
</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="7" class="text-center text-danger">
No Outsource Items Found
</td>

</tr>

<?php

}

?>

</tbody>

</table>

<br>

<?php } ?>

<?php } else { ?>

<div class="alert alert-warning">
No Outsource Records Available.
</div>

<?php } ?>

    </div>

</div>