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
    text-align:left;
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
  @media screen {

            .st-print-area {
                background: #fff;
                padding: 10px;
            }

            .st-header {
                display: none;
            }

            .st-remarks-box {
                width: 80%;
            }
        }

        /* =========================================================
         * PRINT
         * ========================================================= */

        @media print {

           .st-print-area{
            padding:10px;
           }
           .title_left{
            display: none !important;}
           
            #stockTransferPrintArea,
            #stockTransferPrintArea * {
                visibility: visible;
            }

            #stockTransferPrintArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .st-header {
                width: 100%;
                height: 135px;
                display: flex !important;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 5px;
            }

            .st-header-logo {
                width: 55%;
            }

            .st-header-logo img {
                width: 380px;
                max-width: 100%;
                max-height: 125px;
                height: auto;
                object-fit: cover;
            }

            .st-header-right {
                width: 45%;
                text-align: right;
            }

            .st-header-right img {
                width: 80px;
                height: 80px;
                display: block;
                margin-left: auto;
            }

            .st-trn {
                font-size: 11px;
                font-weight: bold;
                text-align: right;
                margin-top: 3px;
            }
}

</style>
 <style>
    @media print {
        .menu_toggle{
            display: none !important;
        }
        .no-print {
            display: none !important;
        }

        .print-hide {
            display: none !important;
        }

        @page {
            margin: 10mm;
        }

        body {
            background: #fff !important;
        }
         .st-header {
            width: 100%;
            height: 140px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .st-header-logo {
            width: 55%;
        }

        .st-header-logo img {
            width: 380px;
            max-width: 100%;
            max-height: 130px;
            height: auto;
            object-fit: cover;
            display: block;
        }

        .st-header-right {
            width: 45%;
            text-align: right;
        }

        .st-header-right img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            display: block;
            margin-left: auto;
        }

        .st-trn {
            font-size: 11px;
            font-weight: bold;
            margin-top: 3px;
        }
        .title_left{ display: none !important; }
        .btn-group { display: none !important; }
        .nav_menu{ display: none !important; }

    }
    @media screen {
        .st-header {
            display: none !important;
        }

       
    }
</style>
</head>

<body>

<div class="no-print">
    <button class="btn btn-sm btn-primary" onclick="window.print()">Print</button>
</div>

<div class="st-header">

        <div class="st-header-logo">

            <?php if (!empty($company['company_logo'])) { ?>

                <img
                    src="<?= base_url($company['company_logo']) ?>"
                    alt="Company Logo"
                >

            <?php } ?>

        </div>

        <div class="st-header-right">

            <img
                src="<?= base_url('uploads/company/barcode.png') ?>"
                alt="QR Code"
            >

            <div class="st-trn">
                TRN:
                <?= htmlspecialchars($company['company_trn'] ?? '') ?>
            </div>

        </div>

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

<!--<tr>

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

</tr>-->

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
<?php
$file = './public/uploded_documents/' . $row->attachment_one;

if (!empty($row->attachment_one) && file_exists($file)) {

    $url = base_url('public/uploded_documents/' . $row->attachment_one);
    $ext = strtolower(pathinfo($row->attachment_one, PATHINFO_EXTENSION));

    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
        // Image
        ?>
        <a href="<?= $url ?>" target="_blank">
            <img src="<?= $url ?>" width="100" height="100" alt="Attachment">
        </a>
        <?php
    } elseif ($ext == 'pdf') {
        // PDF
        ?>
        <a href="<?= $url ?>" target="_blank">
            📄 View PDF
        </a>
        <?php
    } else {
        // Other files (Word, Excel, ZIP, etc.)
        ?>
        <a href="<?= $url ?>" target="_blank">
            📎 Download <?= htmlspecialchars($row->attachment_one) ?>
        </a>
        <?php
    }
}
?>

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