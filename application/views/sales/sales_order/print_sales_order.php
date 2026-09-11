<!DOCTYPE html>
<html>
<head>

<title>Sales Order</title>

<style>

body{
    font-family: Arial, sans-serif;
    font-size:13px;
    color:#000;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #000;
    padding:8px;
}


@media print {
    .print-btn{
        display:none;
    }
}

</style>

</head>
<body>

<!-- HEADER -->
<table style="width: 100%; border-collapse: collapse; border: none;">
    <tr>
        <td width="30%" style="vertical-align: top; border: none; padding: 0;">
            <?php if (!empty($company['company_logo'])) { ?>
                <img src="<?= base_url($company['company_logo']) ?>"
                     style="width:300px; height:auto; max-height:150px; object-fit:contain; display:block;">
            <?php } ?>
        </td>
        <td width="70%" style="text-align: right; vertical-align: top; border: none; padding: 0;">
            <div style="display: inline-block; text-align: right;">
                <img src="<?= base_url('uploads/company/barcode.png') ?>"
                     alt="Barcode"
                     style="height: 70px; width: 100px; max-width: 350px; display: block; margin-left: auto;">
                <div style="font-family: Arial, sans-serif; font-size: 12px; color: #333; margin-top: 5px; font-weight: bold; text-align: right;">
                    TRN: <?= $company['company_trn'] ?>
                </div>
            </div>
        </td>
    </tr>
</table>

<!-- CUSTOMER / DOCUMENT INFO -->
<div style="width: 100%; margin-top: 20px; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.6; color: #333;">
    <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr>
            <td style="width: 50%; vertical-align: top; border: none; padding: 0;">
                <table style="width: 100%; border-collapse: collapse; border: none;">
                    <?php if (!empty($so->customer_code)) { ?>
                    <tr>
                        <td style="width: 100px; font-weight: bold; padding: 2px 0; border: none;">Cust. Code</td>
                        <td style="padding: 2px 0; border: none;">: <?= $so->customer_code ?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <td style="font-weight: bold; padding: 2px 0; border: none; width: 100px; vertical-align: top;">M/s</td>
                        <td style="padding: 2px 0; border: none; vertical-align: top;">: <?= !empty($so->customer_name) ? $so->customer_name : '' ?></td>
                    </tr>

                    <?php if (!empty($so->customer_address)) { ?>
                    <tr>
                        <td style="font-weight: bold; padding: 2px 0; border: none; vertical-align: top;">Address</td>
                        <td style="padding: 2px 0; border: none; vertical-align: top;">: <?= nl2br($so->customer_address) ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (!empty($so->office_telephone)) { ?>
                    <tr>
                        <td style="font-weight: bold; padding: 2px 0; border: none;">Tel</td>
                        <td style="padding: 2px 0; border: none;">: <?= $so->office_telephone ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (!empty($so->office_fax)) { ?>
                    <tr>
                        <td style="font-weight: bold; padding: 2px 0; border: none;">Fax</td>
                        <td style="padding: 2px 0; border: none;">: <?= $so->office_fax ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (!empty($so->tax_registration_no)) { ?>
                    <tr>
                        <td style="font-weight: bold; padding: 2px 0; border: none;">TRN</td>
                        <td style="padding: 2px 0; border: none;">: <?= $so->tax_registration_no ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (!empty($so->customer_email)) { ?>
                    <tr>
                        <td style="font-weight: bold; padding: 2px 0; border: none;">Contact</td>
                        <td style="padding: 2px 0; border: none;">: <?= $so->customer_email ?></td>
                    </tr>
                    <?php } ?>
                </table>
            </td>

            <td style="width: 50%; vertical-align: top; border: none; padding: 0;">
                <table style="width: 280px; margin-left: auto; margin-top: -15px; border-collapse: collapse; border: none;">
                    <tr>
                        <td colspan="2" style="border: none; padding-bottom: 12px;">
                            <div style="font-family: Arial, sans-serif; font-size: 22px; font-weight: bold; color: #111; letter-spacing: 2px; text-transform: uppercase; border-bottom: 2px solid #111; padding-bottom: 4px; display: inline-block; width: 100%;">
                                SALES ORDER
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 110px; font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; padding: 2px 0; border: none;">SO No</td>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; padding: 2px 0; border: none;">: <?= !empty($so->so_code) ? $so->so_code : '' ?></td>
                    </tr>
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; padding: 2px 0; border: none;">Date</td>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; padding: 2px 0; border: none;">: <?= !empty($so->so_date) ? date('d/m/Y', strtotime($so->so_date)) : '' ?></td>
                    </tr>
                    <?php if (!empty($so->quotation_code)) { ?>
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; padding: 2px 0; border: none;">Quotation Ref</td>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; padding: 2px 0; border: none;">: <?= $so->quotation_code ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; padding: 2px 0; border: none;">Validity</td>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; padding: 2px 0; border: none;">: <?= !empty($so->validity) ? $so->validity : '' ?></td>
                    </tr>
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; padding: 2px 0; border: none;">Rep.</td>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; padding: 2px 0; border: none;">: <?= !empty($so->sales_rep_name) ? $so->sales_rep_name : '' ?></td>
                    </tr>
                    <?php if (!empty($so->lpo_number)) { ?>
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; padding: 2px 0; border: none;">L.P.O Number</td>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; padding: 2px 0; border: none;">: <?= $so->lpo_number ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; padding: 2px 0; border: none;">Currency</td>
                        <td style="font-family: Arial, sans-serif; font-size: 13px; padding: 2px 0; border: none;">: AED</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<!-- ITEMS -->
<table style="width: 100%; border-collapse: collapse; margin-top: 25px; font-family: Arial, sans-serif; font-size: 13px; color: #333;">
    <thead>
        <tr style="background-color: #f7f7f7; border-top: 1px solid #ddd; border-bottom: 2px solid #ddd;">
            <th width="5%" style="padding: 8px 5px; font-weight: bold; text-align: center;">#</th>
            <th width="10%" style="padding: 8px 10px; font-weight: bold; text-align: left;">Code</th>
            <th style="padding: 8px 10px; font-weight: bold; text-align: left;">Item Description</th>
            <th width="10%" style="padding: 8px 5px; font-weight: bold; text-align: center;">Qty</th>
            <th width="10%" style="padding: 8px 5px; font-weight: bold; text-align: left;">Unit</th>
            <th width="15%" style="padding: 8px 10px; font-weight: bold; text-align: right;">Rate</th>
            <th width="15%" style="padding: 8px 10px; font-weight: bold; text-align: right;">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach ($so_products as $item) { ?>
        <tr style="border-bottom: 1px solid #eee;">
            <td style="padding: 8px 5px; text-align: center; vertical-align: top;"><?= $i++ ?></td>
            <td style="padding: 8px 10px; text-align: left; vertical-align: top;"><?= !empty($item['product_code']) ? $item['product_code'] : '' ?></td>
            <td style="padding: 8px 10px; text-align: left; vertical-align: top;">
                <span style="font-weight: bold; color: #111;"><?= $item['product_name'] ?></span>
            </td>
            <td style="padding: 8px 5px; text-align: center; vertical-align: top;"><?= number_format($item['quantity'], 2) ?></td>
            <td style="padding: 8px 5px; text-align: left; vertical-align: top;"><?= !empty($item['unit_name']) ? $item['unit_name'] : '' ?></td>
            <td style="padding: 8px 10px; text-align: right; vertical-align: top;"><?= number_format($item['unit_price'], 2) ?></td>
            <td style="padding: 8px 10px; text-align: right; vertical-align: top;"><?= number_format($item['amount'], 2) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<br>

<!-- TOTALS -->
<table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-family: Arial, sans-serif; font-size: 13px; color: #333;">
    <tr>
        <td style="width: 50%; border: none;"></td>
        <td style="width: 50%; vertical-align: top; border: none; padding: 0;">
            <table style="width: 280px; margin-left: auto; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 6px 0; font-weight: bold; text-align: left;">Sub Total</td>
                    <td style="padding: 6px 0; text-align: right;">: <?= number_format($so->sub_total, 2) ?></td>
                </tr>
                <?php if (!empty($so->discount_amount) && $so->discount_amount > 0) { ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 6px 0; font-weight: bold; text-align: left;">Discount (<?= $so->discount_percentage ?>%)</td>
                    <td style="padding: 6px 0; text-align: right;">: <?= number_format($so->discount_amount, 2) ?></td>
                </tr>
                <?php } ?>
                <?php if ($so->vat_required) { ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 6px 0; font-weight: bold; text-align: left;">VAT (<?= $so->vat_percentage ?>%)</td>
                    <td style="padding: 6px 0; text-align: right;">: <?= number_format($so->vat_amount, 2) ?></td>
                </tr>
                <?php } ?>
                <tr style="border-bottom: 2px double #111;">
                    <td style="padding: 8px 0; font-weight: bold; font-size: 15px; color: #000; text-align: left;">Grand Total</td>
                    <td style="padding: 8px 0; font-weight: bold; font-size: 15px; color: #000; text-align: right;">
                        AED : <?= number_format($so->grand_total, 2) ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<!-- TERMS & CONDITIONS SECTION -->
<div style="width: 100%; margin-top: 20px; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.7; color: #000;">
    <u style="font-weight: bold;">Sales Terms :-</u>
    <table style="width: 100%; border-collapse: collapse; border: none; margin-top: 4px;">
        <tr>
            <td style="width: 160px; border: none; padding: 1px 0; vertical-align: top;">Payment :-</td>
            <td style="border: none; padding: 1px 0;"><?= !empty($so->payment_term) ? nl2br($so->payment_term) : '---' ?></td>
        </tr>
        <tr>
            <td style="border: none; padding: 1px 0; vertical-align: top;">Validity :-</td>
            <td style="border: none; padding: 1px 0;"><?= !empty($so->validity) ? nl2br($so->validity) : '---' ?></td>
        </tr>
        <tr>
            <td style="border: none; padding: 1px 0; vertical-align: top;">Delivery :-</td>
            <td style="border: none; padding: 1px 0;"><?= !empty($so->delivery_term) ? nl2br($so->delivery_term) : '---' ?></td>
        </tr>
        <?php if (!empty($so->terms_and_condition)) { ?>
        <tr>
            <td style="border: none; padding: 1px 0; vertical-align: top;">Terms & Conditions :-</td>
            <td style="border: none; padding: 1px 0;"><?= nl2br($so->terms_and_condition) ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php if (!empty($so->remarks)) { ?>
<div style="width: 100%; margin-top: 12px; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.6; color: #000;">
    <u style="font-weight: bold;">Remarks :-</u>
    <div style="margin-top: 2px;"><?= nl2br($so->remarks) ?></div>
</div>
<?php } ?>

<br><br>

<table style="width:100%; border-collapse:collapse;">
    <tr>
        <td width="50%" style="border:none; padding:4px;">
            Prepared By:
            <br><br><br>
            ____________________<br>
            <?= !empty($so->prepared_by_name) ? $so->prepared_by_name : '' ?>
        </td>
        <td width="50%" align="right" style="border:none; padding:4px;">
            Authorized Signatory:
            <br><br><br>
            ____________________
        </td>
    </tr>
</table>

<div class="footer">
    <?php if (!empty($company['company_footer'])) { ?>
        <img src="<?= base_url($company['company_footer']) ?>">
    <?php } ?>
</div>

</body>
</html>

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            window.print();
        }, 500);
    });
</script>