<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>Work Order</title>

<style>

body{
    font-family:Arial, Helvetica, sans-serif;
    font-size:13px;
    color:#000;
    margin:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #000;
    padding:6px;
    vertical-align:top;
}

th{
    background:#efefef;
}

.heading{
    text-align:center;
    font-size:22px;
    font-weight:bold;
}

.company{
    text-align:center;
    font-size:16px;
    font-weight:bold;
}

.section{
    background:#efefef;
    font-weight:bold;
    padding:8px;
    margin-top:15px;
    border:1px solid #000;
}

.info td{
    border:1px solid #000;
}

.signature td{
    border:none;
    text-align:center;
    padding-top:60px;
}

.no-print{
    margin-bottom:20px;
}

@media print{

.no-print{
display:none;
}

@page{
size:A4;
margin:10mm;
}

}

</style>

</head>

<body>

<div class="no-print">
    <button class="btn btn-sm btn-primary" onclick="window.print()">Print</button>
</div>

<div class="company">
<img src="<?= base_url('public/assets/images/altariq_logo.jpeg'); ?>"
             alt="Logo"
             style="height:70px; width:90px; object-fit:contain; ">

   <br>

    AL TAREEQ ENGINEERING LLC

</div>

<div class="heading">

WORK ORDER

</div>

<br>

<table class="info">

<tr>

<td width="25%"><b>WO No</b></td>
<td width="25%"><?= $workorder->wo_code;?></td>

<td width="25%"><b>Date</b></td>
<td width="25%"><?=date('d-m-Y',strtotime($workorder->work_order_date));?></td>

</tr>

<tr>

<td><b>Project</b></td>
<td><?= $workorder->project_name;?></td>

<td><b>Customer</b></td>
<td><?= $workorder->customer_name;?></td>

</tr>

<tr>

<td><b>Fabrication Start</b></td>
<td><?=date('d-m-Y',strtotime($workorder->fsdate));?></td>

<td><b>Fabrication End</b></td>
<td><?=date('d-m-Y',strtotime($workorder->fedate));?></td>

</tr>

<tr>

<td><b>Installation Start</b></td>
<td><?=date('d-m-Y',strtotime($workorder->isdate));?></td>

<td><b>Installation End</b></td>
<td><?=date('d-m-Y',strtotime($workorder->iedate));?></td>

</tr>

<tr>

<td><b>Fabrication Man Hours</b></td>
<td><?= $workorder->fabrication_manhr;?></td>

<td><b>Installation Man Hours</b></td>
<td><?= $workorder->installation_manhr;?></td>

</tr>

<tr>

<td><b>Prepared By</b></td>
<td><?= $workorder->prepared_by;?></td>

<td><b>Checked By</b></td>
<td><?= $workorder->checked_by;?></td>

</tr>

<tr>

<td><b>Approved By</b></td>
<td><?= $workorder->approved_by;?></td>

<td><b>Handed Over</b></td>
<td><?= $workorder->handed_over_to;?></td>

</tr>

</table>

<div class="section">

PRODUCT DETAILS

</div>

<table>

<tr>

<th width="5%">Sl</th>
<th width="25%">Product</th>
<th width="10%">Quantity</th>
<th>Unit</th>
<!--<th width="20%">Remarks</th>-->

</tr>

<?php
$i=1;
//print_r($items);
foreach($items as $row)
{
?>

<tr>

<td><?=$i++;?></td>

<td><?=$row->product_name;?></td>

<td><?=(int)$row->qty;?></td>

<td><?=$row->unit_abbr;?></td>

<!--<td><?=$row->remarks;?></td>-->

</tr>

<?php
}
?>

</table>

<div class="section">

PRODUCT ROUTE

</div>

<table>

<tr>

<th width="30%">Route</th>

<th>Description</th>

</tr>

<?php

foreach($routes as $row)
{

?>

<tr>

<td><?=$row->product_route;?></td>

<td><?=$row->proute_desc;?></td>

</tr>

<?php

}

?>

</table>

<div class="section">

WORK PLAN

</div>

<table>

<tr>

<th width="30%">Plan</th>

<th>Description</th>

</tr>

<?php

foreach($plans as $row)
{

?>

<tr>

<td><?=$row->wo_plan;?></td>

<td><?=$row->woplan_desc;?></td>

</tr>

<?php

}

?>

</table>

<div class="section">

ATTACHMENTS

</div>

<table>

<tr>

<th width="10%">Sl</th>

<th>Attachment</th>

</tr>

<?php

$i=1;

foreach($attachments as $row)
{

?>

<tr>

<td><?=$i++;?></td>

<td>

<a href="<?php echo base_url() . 'public/uploded_documents/' . $row->attachment_one; ?>" target="_blank">

<?=$row->attachment_one;?>

</a>

</td>

</tr>

<?php

}

?>

</table>

<div class="section">

SPECIAL INSTRUCTIONS

</div>

<table>

<tr>

<td style="height:80px;"></td>

</tr>

</table>

<br><br>

<table class="signature">

<tr>

<td>

_____________________

<br>

Prepared By

</td>

<td>

_____________________

<br>

Checked By

</td>

<td>

_____________________

<br>

Approved By

</td>

<td>

_____________________

<br>

Received By

</td>

</tr>

</table>

</body>

</html>