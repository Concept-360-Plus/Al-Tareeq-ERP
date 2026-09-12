<?php
$this->load->helper('menu_helper.php');

// Company details
$company = $comapny_records; 

// Quotation details
$record = $records1[0] ?? null;
$amc_discount = $record->amc_discount ?? 0;
$quotation_date = !empty($record->revision_date) 
    ? date('d-M-Y', strtotime($record->revision_date)) 
    : date('d-M-Y', strtotime($record->quotation_date));
?>

<html>
<head>
    <title>AMC Quotation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 0 25px;   /* left right space */
            padding: 0;
            color: #333;
            margin-top: 0px;
        }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #BFC9CA; }
        .text-right { text-align: right; }
        .no-border,
        .no-border th,
        .no-border td {
            border: none !important;
        }

        .page-break {
            page-break-before: always;
            clear: both;
        }

        /* Prevent orphan headings and section splits */
        .keep-together {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
        
        .no-break-after {
            page-break-after: avoid !important;
            break-after: avoid !important;
        }

        .footer {
            position: fixed;
            bottom: -100px;
            left: 0;
            right: 0;
        }
        .footer img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Running Header Setup */
        .header {
            position: fixed;
            top: -120px;
            left: 0;
            right: 0;
            height: 120px;
        }

        .cover-page {
            page-break-after: always;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box;
        }

        .cover-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .cover-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .cover-logo {
            position: absolute;
            top: 20px;
            right: 30px;
            z-index: 10;
            text-align: right;
        }

        .cover-logo img {
            max-height: 100px;
            width: auto;
            display: block;
        }
        
        .cover-details {
            position: absolute;
            top: 200px;
            left: 45px;
            right: 45px;
            z-index: 2;
            color: #000;
            line-height: 1.8;
        }
        
        @page {
            margin-top: 140px;
            margin-right: 20px;
            margin-bottom: 110px;
            margin-left: 20px;
        }

        @page :first {
            margin: 0 !important;
            .header {
                display: none !important;
                opacity: 0 !important;
                top: -1000px !important; 
            }
        }

        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
            }
            .main-content {
                margin-top: 0;
            }
        } 
    </style>
</head>
<body>

<!-- <div class="cover-page">
    <div class="cover-img">
        <?php if (!empty($cover_page)) { ?>
            <img src="<?= base_url($cover_page) ?>" alt="Cover Page">
        <?php } ?>
    </div>
    <div class="cover-details">
        <h3><?= $branch_name ?></h3>
        <?php
        $address = trim($branch_address);
        if (!empty($branch_location)) {
            $address .= (!empty($address) ? ', ' : '') ;
        }

        if (!empty($address)) {
            echo nl2br($address) . '<br>';
        }
        if (!empty($branch_location)) {
            echo nl2br($branch_location) . ', UNITED ARAB EMIRATES'.'<br>';
        }
        ?>
        
        <?php if (!empty($branch_contact)) { ?>
            <?= $branch_contact; ?><br>
        <?php } ?>
            
        <a href="mailto:<?= $branch_email ?>" style="color: #0066cc; text-decoration: underline; font-weight: normal;"><?= $company['company_email_id'] ?></a><br>
        <a href="https://<?= str_replace(['http://', 'https://'], '', $company['company_website']) ?>" target="_blank" style="color: #0066cc; text-decoration: underline; font-weight: normal;"><?= $company['company_website'] ?></a>
    </div>
</div> -->

<div class="header">
    <table class="no-border" style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:60%; padding:0 10px;">
                <img src="<?= $headerPath ?>" style="max-height:120px;">
            </td>
            <td style="width:40%; text-align:right; font-size:13px; font-family: Arial, sans-serif; padding-right:10px;">
                <b>Ref No:</b> <?= $record->quotation_code ?><br>
                <b>Date:</b> <?= $quotation_date ?>
            </td>
        </tr>
    </table>
</div>

<div class="main-content">
    <h2 align="center">ANNUAL MAINTENANCE PROPOSAL</h2>

    <table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; font-size:13px; margin-top:10px;">
        <tr>
            <td width="15%"><b>To</b></td>
            <td width="35%">
                <b><?php echo $record->customer_name ?? ''; ?></b><br>
                <b>Contact Person:</b> <?php echo $record->cp_name ?? ''; ?><br>
                <b>Phone:</b> <?php echo $record->cp_mobile ?? ''; ?><br>
                <b>Email:</b> <?php echo $record->cp_email ?? ''; ?>
            </td>
            <td width="15%"><b>From</b></td>
            <td width="35%">
                Al Adel Automatic Doors Tr. L.L.C.
            </td>
        </tr>
        <tr>
            <td><b>Location</b></td>
            <td><?php echo $record->project_location ?? ''; ?></td>
            <td><b>Subject</b></td>
            <td><?php echo $record->subject ?? ''; ?></td>
        </tr>
        <tr>
            <td><b>Start Date</b></td>
            <td>
                <?php echo !empty($record->amc_start_date) ? date('d-M-Y', strtotime($record->amc_start_date)) : ''; ?>
            </td>
            <td><b>End Date</b></td>
            <td>
                <?php echo !empty($record->amc_end_date) ? date('d-M-Y', strtotime($record->amc_end_date)) : ''; ?>
            </td>
        </tr>
    </table>

    <p style="margin-top:10px; font-size:13px; text-align:justify;">
        The maintenance contract for the above project as discussed, please read the following details:
    </p>
 <div class="keep-together">
        <p class="no-break-after" style="margin-top:10px; font-size:14px; font-weight:bold; text-decoration:underline;">
            CONRACT PERIOD:           
        </p>
        <p style="margin-top:5px; font-size:13px; text-align:justify;">
            <?= nl2br($record->contract_period); ?>
        </p>
    </div>
 <div class="keep-together">
        <p class="no-break-after" style="margin-top:10px; font-size:14px; font-weight:bold; text-decoration:underline;">
            CONTRACT VALUE:           
        </p>
        <p style="margin-top:5px; font-size:13px; text-align:justify;">
            <?= nl2br($record->contract_value); ?>
        </p>
    </div>
  <!-- <div class="keep-together">
        <p class="no-break-after" style="margin-top:10px; font-size:14px; font-weight:bold; text-decoration:underline;">
            TERMS OF PAYMENT:           
        </p>
        <p style="margin-top:5px; font-size:13px; text-align:justify;">
            <?= nl2br($record->payment_term); ?>
        </p>
    </div> -->
    <div class="keep-together">
        <p class="no-break-after" style="margin-top:10px; font-size:14px; font-weight:bold; text-decoration:underline;">
            SCOPE OF SERVICES:           
        </p>
        <p style="margin-top:5px; font-size:13px; text-align:justify;">
            <?= nl2br($record->scope_work); ?>
        </p>
    </div>
 <div class="keep-together">
        <p class="no-break-after" style="margin-top:10px; font-size:14px; font-weight:bold; text-decoration:underline;">
            TERMS AND CONDITIONS:           
        </p>
        <p style="margin-top:5px; font-size:13px; text-align:justify;">
            <?= nl2br($record->termcond); ?>
        </p>
    </div>
<div class="keep-together">
        <p class="no-break-after" style="margin-top:10px; font-size:14px; font-weight:bold; text-decoration:underline;">
            EXCLUSIONS:           
        </p>
        <p style="margin-top:5px; font-size:13px; text-align:justify;">
            <?= nl2br($record->exclusions); ?>
        </p>
    </div>
   

    <div class="keep-together">
        <p class="no-break-after" style="margin-top:10px; font-size:14px; font-weight:bold; text-decoration:underline;">
            NUMBER OF VISITS
        </p>
        <p style="margin-top:5px; font-size:13px; text-align:justify;">
            <?= nl2br($record->ppm_details); ?>
        </p>
    </div>

    <?php if(!empty($sla_records)) { ?>
    <div class="keep-together" style="margin-top:15px;">
        <b>SLA Response Time</b>
        <table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; font-size:13px; margin-top:5px;">
            <tr style="background:#2e6da4; color:#fff; font-weight:bold; text-align:center;">
                <td>SERVICE ITEM</td>
                <td>SERVICE AVAILABILITY</td>
                <td>RESPONSE TIME</td>
                <td>RESTORATION TIME</td>
                <td>RESOLUTION TIME</td>
            </tr>
            <?php foreach($sla_records as $s) { ?>
            <tr>
                <td><?php echo $s->service_item; ?></td>
                <td><?php echo $s->service_availability_period; ?></td>
                <td><?php echo $s->response_time; ?></td>
                <td><?php echo $s->restoration_time; ?></td>
                <td><?php echo $s->resolution_time; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <?php } ?>

    <br><br>
    Our offer for Annual maintenance is as follows:
    <br>

    <div class="keep-together" style="margin-top:15px;">
        <p class="no-break-after" style="font-size:14px; font-weight:bold; text-decoration:underline; margin-bottom:5px;">
            AMC COST DETAILS
        </p>

        <table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; font-size:13px;">
            <tr style="background:#2e6da4; color:#000; text-align:center; font-weight:bold;">
                <th>DESCRIPTION</th>
                  <th>BRAND</th>
                <th>PRICE (AED)</th>
                <th>QTY</th>
                <?php
                $period_count = 0;
                if ($quotation_info->contract_type == 'Yearly') {
                    $period_count = $quotation_info->no_of_years;
                    for ($i = 1; $i <= $period_count; $i++) {
                        echo "<th>Total Price {$i} Year</th>";
                    }
                } else {
                    $period_count = $quotation_info->no_of_quarters;
                    for ($i = 1; $i <= $period_count; $i++) {
                        echo "<th>Q{$i}</th>";
                    }
                }
                ?>
                <th>FINAL TOTAL</th>
            </tr>

            <?php
            $grand_total = 0;
            foreach ($records2 as $row2) {
                $rate = $row2->price;
                $qty  = $row2->quantity;
                $base_total = $rate * $qty;
                $row_total  = $base_total * $period_count;
                $grand_total += $row_total;
            ?>
                <tr>
                       <td><?= htmlspecialchars($row2->product_name ?? '') ?></td>
                       <td><?= htmlspecialchars($row2->brand ?? '') ?></td>
                    <td style="text-align:right;"><?= number_format($rate,2) ?></td>
                    <td style="text-align:center;"><?= $qty ?></td>
                    <?php for ($p = 1; $p <= $period_count; $p++) { ?>
                        <td style="text-align:right;">
                            <?= number_format($base_total, 2) ?>
                        </td>
                    <?php } ?>
                    <td style="text-align:right; font-weight:bold;">
                        <?= number_format($row_total, 2) ?>
                    </td>
                </tr>
            <?php } ?>
            <tr style="font-weight:bold;">
                <td colspan="<?= 4 + $period_count ?>" style="text-align:right;">Sub Total</td>
                <td style="text-align:right;">
                    <?= number_format($record->sub_total, 2) ?>
                </td>
            </tr>

            <?php if (!empty($record->amc_discount) && $record->amc_discount > 0) { ?>
            <tr style="font-weight:bold;">
                <td colspan="<?= 4 + $period_count ?>" style="text-align:right;">AMC Discount</td>
                <td style="text-align:right;">
                    - <?= number_format($record->amc_discount, 2) ?>
                </td>
            </tr>
            <?php } ?>
            <?php if (!empty($record->discount_amt) && $record->discount_amt > 0) { ?>
            <tr style="font-weight:bold;">
                <td colspan="<?= 4 + $period_count ?>" style="text-align:right;">
                    Discount (<?= $record->discount_percent ?>%)
                </td>
                <td style="text-align:right;">
                    - <?= number_format($record->discount_amt, 2) ?>
                </td>
            </tr>
            <?php } ?>
            <?php if (!empty($record->vat_amt) && $record->vat_amt > 0) { ?>
            <tr style="font-weight:bold;">
                <td colspan="<?= 4 + $period_count ?>" style="text-align:right;">
                    VAT (<?= $record->vat_percent ?>%)
                </td>
                <td style="text-align:right;">
                    <?= number_format($record->vat_amt, 2) ?>
                </td>
            </tr>
            <?php } ?>
            <tr style="background:#f2f2f2; font-weight:bold;">
                <td colspan="<?= 4 + $period_count ?>" style="text-align:right;">
                    GRAND TOTAL
                </td>
                <td style="text-align:right;">
                    <?= number_format($record->grand_total, 2) ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- WRAPPED PAYMENT TERMS IN KEEP-TOGETHER CONTAINER -->
    <div class="keep-together" style="margin-top:15px;">
        <p class="no-break-after" style="font-size:14px; font-weight:bold; text-decoration:underline; margin:0 0 5px 0;">
            TERMS OF PAYMENT:
        </p>
        <p style="font-size:13px; text-align:justify; margin:0;">
            <?= nl2br($record->payment_term); ?>
        </p>
    </div>

    <!-- WRAPPED SIGNATURE & ACCEPTANCE IN KEEP-TOGETHER CONTAINERS -->
    <div class="keep-together">
        <table width="100%" style="font-size:13px; margin-top:20px; border:none;">
            <tr>
                <td style="text-align:left; vertical-align:top; width:33%; padding-top:10px; padding-left:5px; padding-right:5px; border:none;">
    <strong>Authorized Personnel Signature:</strong><br>

   <?php if (!empty($prepared_signature)) { ?>

    <?php
    $signature_path = FCPATH . 'public/employee/' . $prepared_signature;

    if (file_exists($signature_path)) {

        $type = pathinfo($signature_path, PATHINFO_EXTENSION);
        $image = file_get_contents($signature_path);
        $signature_base64 = 'data:image/' . $type . ';base64,' . base64_encode($image);
    ?>

        <img src="<?= $signature_base64 ?>" 
             style="height:70px; margin-top:5px;"><br>

    <?php } ?>

<?php } ?>

<span><?= htmlspecialchars($prepared_by_name ?? '') ?></span>

<?php if (!empty($prepared_by_contact)) { ?>
    <br>
    <span><?= htmlspecialchars($prepared_by_contact) ?></span>
<?php } ?>

    <span><?= htmlspecialchars($authorized_name ?? '') ?></span>
</td>

            <td colspan="3" style="text-align:center; padding-top:20px; border:none;">
                            <?php if (!empty($branch_stamp)) { 
                                $path = FCPATH . ltrim($branch_stamp, './');
                                if (file_exists($path)) {
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                ?>
                                    <img src="<?= $base64 ?>" style="max-width:200px; max-height:140px;">
                                <?php } ?>
                            <?php } ?>
                        </td>

                <td style="width:50%; text-align:right;border:none;">
                    <b>Date:</b> <?= date('d-m-Y') ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="keep-together" style="margin-top:20px;">
        <p class="no-break-after" style="font-size:14px; font-weight:bold; text-decoration:underline; margin-bottom:5px;">
            ACCEPTANCE
        </p>
        The above prices, Specifications and conditions are satisfactory and here by accepted. You are
        authorized to specify the work as specified. Payment will be made as outlined above.

        <table width="100%" style="font-size:13px; margin-top:20px; border:none;">
            <tr>
                <td style="width:50%; text-align:left;border:none;">
                    _______________________<br><br>
                    <b>Customer Signature</b>
                </td>
                <td style="width:50%; text-align:right;border:none;">
                    ______________<br><br>
                    <b>Date of Acceptance</b>
                </td>
            </tr>
        </table>
    </div>

    <?php if(!empty($annexure_records)) { ?>
        <div style="page-break-before: always;"></div>

        <h3 style="text-align:center; margin-bottom:20px;">
            <?= !empty($annexure_records[0]->annexure_title) ? $annexure_records[0]->annexure_title : 'ANNEXURE'; ?>
        </h3>

        <table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse:collapse; font-size:13px;">
            <?php if(!empty($annexure_records[0]->section_title)) { ?>
            <tr>
                <td colspan="4" style="background:#e9f2fb; color:#000; font-weight:bold; text-align:center;">
                    <?= $annexure_records[0]->section_title ?>
                </td>
            </tr>
            <?php } ?>

            <tr style="background:#2e6da4; color:#fff; font-weight:bold; text-align:center;">
                <td width="10%">
                    <?= !empty($annexure_records[0]->heading_slno) ? $annexure_records[0]->heading_slno : 'Sl No'; ?>
                </td>
                <td width="35%">
                    <?= !empty($annexure_records[0]->heading_type) ? $annexure_records[0]->heading_type : 'Type'; ?>
                </td>
                <td width="35%">
                    <?= !empty($annexure_records[0]->heading_location) ? $annexure_records[0]->heading_location : 'Location'; ?>
                </td>
                <td width="20%">
                    <?= !empty($annexure_records[0]->heading_quantity) ? $annexure_records[0]->heading_quantity : 'Quantity'; ?>
                </td>
            </tr>

            <?php 
            $total_qty = 0;
            $sl = 1;
            foreach($annexure_records as $a) { 
                $total_qty += $a->quantity;
            ?>
            <tr>
                <td style="text-align:center;"><?= $sl++ ?></td>
                <td><?= $a->type ?></td>
                <td><?= $a->location ?></td>
                <td style="text-align:center;"><?= $a->quantity ?></td>
            </tr>
            <?php } ?>

            <tr style="font-weight:bold; background:#f2f2f2;">
                <td colspan="3" style="text-align:right;">
                    <?= !empty($annexure_records[0]->heading_total) ? $annexure_records[0]->heading_total : 'Total Quantity'; ?>
                </td>
                <td style="text-align:center;"><?= $total_qty ?></td>
            </tr>
        </table>
    <?php } ?>
</div>

<div class="footer">
    <img src="<?= $footerPath ?>" alt="Footer">
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        window.focus();
        window.print();
    }, 1200);
});
</script>
</body>
</html>