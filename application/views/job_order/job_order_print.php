<!DOCTYPE html>
<html>
<head>

<title>Quotation</title>

<style>
    
.h2, h2
 {
    font-size: 2rem;
}
.job-order-header {
    width: 100%;
    height: 140px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 5px;
}
.header-logo {
    width: 55%;
}

.header-logo img {
    width: 380px;
    max-width: 100%;
    max-height: 130px;
    height: auto;
    object-fit: cover;
    display: block;
}

.header-qr {
    width: 45%;
    text-align: right;
}

.header-qr img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    display: block;
    margin-left: auto;
}

.header-qr .trn {
    font-size: 11px;
    font-weight: bold;
    margin-top: 3px;
}

@media print {

    .print-btn{
        display:none;
    }

}

</style>

</head>


<body>


<style type="text/css">
@media print {

    .signature-table1 {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-top: 40px;
    }

    .signature-table1 th,
    .signature-table1 td {
        /*border: 1px solid #000 !important;*/
        padding: 8px !important;
        text-align: center;
    }

    .signature-table1 th {
        height: 30px;
        font-weight: bold;
    }

    .signature-table1 td {
        height: 70px !important;
        vertical-align: bottom;
    }

}
@media print {

    body * {
        visibility: hidden;
    }

    #jobOrderPrintArea,
    #jobOrderPrintArea * {
        visibility: visible;
    }

    #jobOrderPrintArea {
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


    /* =========================
       HEADER
       ========================= */

    .job-order-header {
        width: 100%;
        height: 110px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border: none !important;
        margin-bottom: 5px;
    }

    .header-logo {
        width: 55%;
        text-align: left;
        border: none !important;
    }

    .header-logo img {
        width: 300px;
        max-height: 100px;
        object-fit: cover;
        display: block;
    }

    .header-qr {
        width: 45%;
        text-align: right;
        border: none !important;
    }

    .header-qr img {
        width: 80px;
        height: 80px;
        display: block;
        margin-left: auto;
    }

    .header-qr .trn {
        font-size: 11px;
        font-weight: bold;
        text-align: right;
        margin-top: 3px;
    }


    /* =========================
       JOB ORDER TABLES
       ========================= */

    #jobOrderPrintArea .table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    #jobOrderPrintArea .table th,
    #jobOrderPrintArea .table td {
        border: 1px solid #000 !important;
        padding: 6px !important;
        font-size: 12px;
    }


    /* =========================
       ITEM
       ========================= */

    .print-item-table {
        margin-bottom: 5px !important;
        page-break-inside: avoid;
    }

    .material-title {
        margin-top: 5px;
        margin-bottom: 5px;
        font-size: 15px;
    }


    /* =========================
       MATERIALS
       ========================= */

    .material-title + table {
        page-break-inside: avoid;
    }


    /* =========================
       REMARKS
       ========================= */

    .remarks-box,
    .remarks-box1 {
        border: 1px solid #000;
        padding: 10px;
        min-height: 50px;
    }


    /* =========================
       SIGNATURE
       ========================= */

    .signature-table {
        width: 80%;
        margin-top: 40px;
    }

    .signature-table td {
        border: 1px solid #000 !important;
        text-align: center;
        height: 70px;
    }


    /* =========================
       FOOTER
       ========================= */

    .footer {
        margin-top: 30px;
        width: 100%;
    }

    .footer img {
        width: 100%;
        max-height: 80px;
        object-fit: contain;
    }
     .job-order-header {
        height: 135px;
    }

    .header-logo img {
        width: 380px;
        max-height: 125px;
        height: auto;
        object-fit: cover;
    }

}
@media screen {
    .job-order-header {
        display: none;
    }
    .remarks-box{
        width: 80%;
        margin-bottom: 10px;
    }
}


</style>
<!-- HEADER -->

<div id="jobOrderPrintArea">

<!-- JOB ORDER HEADER -->
<div class="job-order-header">

    <!-- Company Logo -->
    <div class="header-logo">

        <?php if (!empty($company['company_logo'])) { ?>

            <img src="<?= base_url($company['company_logo']) ?>"
                 alt="Company Logo">

        <?php } ?>

    </div>


    <!-- QR / TRN -->
    <div class="header-qr">

        <img src="<?= base_url('uploads/company/barcode.png') ?>"
             alt="QR Code">

        <div class="trn">
            TRN: <?= htmlspecialchars($company['company_trn']) ?>
        </div>

    </div>

</div>
<button type="button"
        class="btn btn-default no-print"
        id="printJobOrder">

    <i class="fa fa-print"></i>
    Print

</button>
   <h2 class="title">
    JOB ORDER
</h2>
    <table class="table table-bordered">

        <tr>
            <th width="150">Job Order No</th>
            <td><?= htmlspecialchars($job_order->job_order_no ?? "") ?></td>

            <th width="150">Order Date</th>
            <td><?= htmlspecialchars(date('m-d-Y', strtotime($job_order->order_date))) ?>
</td>
        </tr>

        <tr>
            <th>Order No</th>
            <td><?= htmlspecialchars($job_order->order_no ?? "") ?></td>

            <th>Representative</th>
            <td><?= htmlspecialchars($job_order->rep_name ?? "") ?></td>
        </tr>

        <tr>
            <th>Contact Person</th>
            <td><?= htmlspecialchars($job_order->contact_person) ?></td>

            <th>Start Date</th>
            <td><?= htmlspecialchars(date('m-d-Y', strtotime($job_order->start_date))) ?>
            </td>
        </tr>

        <tr>
            <th>Finish Date</th>
            <td><?= htmlspecialchars(date('m-d-Y', strtotime($job_order->finish_date))) ?>
            </td>

            <th>Project</th>
            <td>
                <?= htmlspecialchars($job_order->project_name ?? '') ?>
            </td>
        </tr>

    </table>


    <h4>Job Order Items</h4>


    <?php foreach ($job_order_items as $index => $item): ?>

        <table class="table table-bordered print-item-table">

            <thead>

                <tr>
                    <th colspan="5" style="font-size: 16px;">
                        Item <?= $index + 1 ?> :
                        <?= htmlspecialchars($item->product_name) ?>
                    </th>
                </tr>

                <tr>
                    <th width="50">#</th>
                    <th>Item</th>
                    <th width="100">Quantity</th>
                    <th width="120">Unit Price</th>
                    <th width="120">Total</th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>
                        <?= $index + 1 ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($item->product_name) ?>
                    </td>

                    <td>
                        <?= $item->quantity ?>
                    </td>

                    <td>
                        <?= $item->cost ?>
                    </td>

                    <td>
                        <?= number_format($item->cost * $item->quantity, 2) ?>

                    </td>

                </tr>

            </tbody>

        </table>


        <!-- RAW MATERIALS -->

        <h5 class="material-title">
            Raw Materials
        </h5>

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th width="50">#</th>
                    <th>Material Code</th>
                    <th>Material</th>
                    <th width="100">Unit</th>
                    <th width="100">Quantity</th>
                     <th width="100">Unit Cost</th>
                    <th width="100">Total</th>
                    <th width="100">Source</th>
                </tr>

            </thead>

            <tbody>

                <?php if (!empty($item->materials)): ?>

                    <?php foreach (
                        $item->materials
                        as $materialIndex => $material
                    ): ?>

                        <tr>

                            <td>
                                <?= $materialIndex + 1 ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $material->material_code ?? ''
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $material->material_name
                                ) ?>
                            </td>
                             <td>
                                <?= htmlspecialchars(
                                    $material->unit ?? ''
                                ) ?>
                            </td>
                            <td>
                                <?= $material->quantity_required ?>
                            </td>
                            
                            <td>
                                <?= $material->cost ?>
                            </td>
                            <td>
                                <?= number_format((float)$material->cost * $material->quantity_required, 2) ?>

                            </td>
                           

                            <td>
                                <?= htmlspecialchars(
                                    $material->source ?? 'BOM'
                                ) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="6"
                            class="text-center">

                            No raw materials

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

        <br>

    <?php endforeach; ?>


    <?php if (!empty($job_order->remarks)): ?>

        <h4>Remarks</h4>
         <br> 
        <h6>Job Order</h4>
        
        <div class="remarks-box">

            <?= nl2br(
                htmlspecialchars($job_order->remarks)
            ) ?>

        </div>

    <?php endif; ?>
    <?php if (!empty($job_order->remarks)): ?>

        <h6 style="margin-top:10px;">Project</h4>
        
        <div class="remarks-box">

            <?= nl2br(
                htmlspecialchars($job_order->premarks)
            ) ?>

        </div>

    <?php endif; ?>


    <br><br>

    <table class="signature-table1" style="width:100%" border="0">

        <tr>

            <td>
                Prepared By
            </td>

            <td>
                Checked By
            </td>

            <td>
                Approved By
            </td>

        </tr>

        <tr>

            <td height="70"></td>

            <td></td>

            <td></td>

        </tr>

    </table>



</div>

<script>
$(document).on('click', '#printJobOrder', function () {

    window.print();

});
</script>