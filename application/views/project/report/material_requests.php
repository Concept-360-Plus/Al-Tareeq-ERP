<div class="x_panel">

    <div class="x_title">
        <h2>Material Requests</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

<?php
//echo "<pre>";print_r($material_requests);
if(!empty($material_requests))
{
    foreach($material_requests as $mr)
    {
?>

        <table class="table table-bordered">

            <tr class="">

                <th width="15%">MR Code</th>

                <td width="20%">
                     <?= $mr->mr_code; ?> -  <?= $mr->mr_id; ?>
                </td>

                <th width="15%">Request Date</th>

                <td width="20%">
                    <?= date('d-m-Y',strtotime($mr->requested_date)); ?>
                </td>
                <th width="15%">Required Date</th>

                <td width="20%">
                    <?= date('d-m-Y',strtotime($mr->required_date)); ?>
                </td>
                <th width="10%">Status</th>

                <td width="20%">
                    <?= $mr->status; ?>
                </td>

            </tr>

        </table>

        <table class="table table-bordered table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Item Code</th>
    <th>Item Name</th>
    <th class="text-right">Qty</th>
    <th>Unit</th>
    <th>Remarks</th>
</tr>
</thead>

<tbody>

<?php

$items = $this->Project_model->get_material_request_products_repo($mr->mr_id);

if(!empty($items))
{
    $i = 1;

    foreach($items as $item)
    {
?>

<tr>
    <td><?= $i++; ?></td>
    <td><?= $item->product_code; ?></td>
    <td><?= $item->product_name; ?></td>
    <td class="text-right"><?= number_format($item->quantity,2); ?></td>
    <td><?= !empty($item->unit_abbr) ? $item->unit_abbr : $item->unit; ?></td>
    <td><?= $item->item_remarks; ?></td>
</tr>

<?php
    }
}
else
{
?>

<tr>
    <td colspan="6" class="text-center text-danger">
        <strong>No Material Items Found</strong>
    </td>
</tr>

<?php
}
?>

</tbody>

</table>

<br>

<?php
    } // End foreach($material_requests)
}
else
{
?>

<div class="alert alert-warning">
    No Material Requests Available.
</div>

<?php
}
?>

</div>
</div>
