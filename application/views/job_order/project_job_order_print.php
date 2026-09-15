<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Safe company values
|--------------------------------------------------------------------------
*/
$company_logo = '';
$company_trn  = '';

if (is_array($company)) {
    $company_logo = isset($company['company_logo'])
        ? $company['company_logo']
        : '';

    $company_trn = isset($company['company_trn'])
        ? $company['company_trn']
        : '';
} else {
    $company_logo = isset($company->company_logo)
        ? $company->company_logo
        : '';

    $company_trn = isset($company->company_trn)
        ? $company->company_trn
        : '';
}

/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
*/
function pjod_format_date($date)
{
    if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }

    $timestamp = strtotime($date);

    if (!$timestamp || $timestamp <= 0) {
        return '';
    }

    return date('d-m-Y', $timestamp);
}

function pjod_format_datetime($date)
{
    if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
        return '';
    }

    $timestamp = strtotime($date);

    if (!$timestamp || $timestamp <= 0) {
        return '';
    }

    return date('d-m-Y H:i', $timestamp);
}

function pjod_escape($value)
{
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<style>
    .project-job-order-print {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #000;
        background: #fff;
    }

    .print-header {
        width: 100%;
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
        margin-bottom: 10px;
    }

    .print-header table {
        width: 100%;
        border-collapse: collapse;
    }

    .print-header td {
        vertical-align: middle;
        border: 0 !important;
    }

    .company-logo {
        max-width: 190px;
        max-height: 75px;
    }

    .company-trn {
        text-align: right;
        font-size: 11px;
        line-height: 18px;
    }

    .barcode {
        max-width: 90px;
        max-height: 55px;
        margin-top: 3px;
    }

    .document-title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin: 8px 0 12px;
        text-transform: uppercase;
    }

    .section-title {
        font-size: 13px;
        font-weight: bold;
        background: #f2f2f2;
        border: 1px solid #777;
        padding: 6px 8px;
        margin-top: 10px;
    }

    .info-table,
    .items-table,
    .material-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table td {
        border: 1px solid #999;
        padding: 5px 7px;
        vertical-align: top;
    }

    .info-label {
        width: 16%;
        font-weight: bold;
        background: #f7f7f7;
    }

    .sales-order-title {
        background: #e9e9e9;
        border: 1px solid #777;
        padding: 6px 8px;
        margin-top: 12px;
        font-size: 13px;
        font-weight: bold;
    }

    .items-table th,
    .items-table td,
    .material-table th,
    .material-table td {
        border: 1px solid #999;
        padding: 5px 6px;
    }

    .items-table th,
    .material-table th {
        background: #f2f2f2;
        font-weight: bold;
        text-align: center;
    }

    .items-table td {
        vertical-align: top;
    }

    .material-heading {
        font-size: 11px;
        font-weight: bold;
        background: #fafafa;
        padding: 5px;
        border-left: 1px solid #999;
        border-right: 1px solid #999;
        border-bottom: 1px solid #999;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .remarks-box {
        border: 1px solid #999;
        min-height: 45px;
        padding: 7px;
        margin-top: 8px;
    }

    .signature-table {
        width: 100%;
        margin-top: 45px;
        border-collapse: collapse;
    }

    .signature-table td {
        width: 33.33%;
        text-align: center;
        vertical-align: bottom;
        border: 0 !important;
        padding: 5px;
    }

    .signature-line {
        border-top: 1px solid #000;
        margin: 30px 25px 5px;
    }

    .print-button-area {
        margin-bottom: 15px;
        text-align: right;
    }

    @media print {

        body {
            margin: 0;
            padding: 0;
            background: #fff !important;
        }

        .no-print,
        .print-button-area,
        .left_col,
        .top_nav,
        .nav_menu,
        .menu_section,
        .footer {
            display: none !important;
        }

        .project-job-order-print {
            width: 100%;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }

        .document-title {
            font-size: 17px;
            margin: 5px 0 8px;
        }

        .section-title {
            font-size: 11px;
            padding: 4px 6px;
            margin-top: 6px;
        }

        .sales-order-title {
            font-size: 11px;
            padding: 4px 6px;
            margin-top: 7px;
        }

        .info-table td,
        .items-table th,
        .items-table td,
        .material-table th,
        .material-table td {
            padding: 3px 4px;
        }

        .material-heading {
            padding: 3px;
            font-size: 9px;
        }

        .signature-table {
            margin-top: 30px;
        }

        @page {
            size: A4;
            margin: 10mm;
        }
    }
</style>


<div class="container-fluid project-job-order-print">

    <!-- PRINT BUTTON -->
    <div class="print-button-area no-print">
        <button
            type="button"
            class="btn btn-primary btn-sm"
            onclick="window.print();">
            <i class="fa fa-print"></i> Print
        </button>
    </div>


    <div id="projectJobOrderPrintArea">

        <!-- =========================================================
             COMPANY HEADER
        ========================================================== -->
        <div class="print-header">

            <table>
                <tr>

                    <td style="width:50%;">

                        <?php if (!empty($company_logo)) { ?>

                            <img
                                src="<?php echo base_url($company_logo); ?>"
                                class="company-logo"
                                alt="Company Logo">

                        <?php } ?>

                    </td>

                    <td
                        style="width:50%;"
                        class="company-trn">

                        <?php if (!empty($company_trn)) { ?>

                            <strong>TRN:</strong>
                            <?php echo pjod_escape($company_trn); ?>

                            <br>

                        <?php } ?>

                        <img
                            src="<?php echo base_url('uploads/company/barcode.png'); ?>"
                            class="barcode"
                            alt="Barcode">

                    </td>

                </tr>
            </table>

        </div>


        <!-- =========================================================
             TITLE
        ========================================================== -->

        <div class="document-title">
            JOB ORDER
        </div>


        <!-- =========================================================
             JOB ORDER / PROJECT INFORMATION
        ========================================================== -->

        <div class="section-title">
            Project Job Order Information
        </div>

        <table class="info-table">

            <tr>

                <td class="info-label">
                    Job Order No
                </td>

                <td>
                    <?php
                    echo pjod_escape(
                        isset($job_order->job_order_no)
                            ? $job_order->job_order_no
                            : ''
                    );
                    ?>
                </td>

                <td class="info-label">
                    Order Date
                </td>

                <td>
                    <?php
                    echo pjod_format_datetime(
                        isset($job_order->order_date)
                            ? $job_order->order_date
                            : ''
                    );
                    ?>
                </td>

            </tr>


            <tr>

                <td class="info-label">
                    Order No
                </td>

                <td>
                    <?php
                    echo pjod_escape(
                        isset($job_order->order_no)
                            ? $job_order->order_no
                            : ''
                    );
                    ?>
                </td>

                <td class="info-label">
                    Sales Order Type
                </td>

                <td>
                    Project
                </td>

            </tr>


            <tr>

                <td class="info-label">
                    Project
                </td>

                <td colspan="3">

                    <?php
                    echo pjod_escape(
                        isset($project->project_name)
                            ? $project->project_name
                            : (
                                isset($job_order->project_name)
                                    ? $job_order->project_name
                                    : ''
                            )
                    );
                    ?>

                </td>

            </tr>


            <tr>

                <td class="info-label">
                    Representative
                </td>

                <td>
                    <?php
                    echo pjod_escape(
                        isset($job_order->rep_name)
                            ? $job_order->rep_name
                            : ''
                    );
                    ?>
                </td>

                <td class="info-label">
                    Contact Person
                </td>

                <td>
                    <?php
                    echo pjod_escape(
                        isset($job_order->contact_person)
                            ? $job_order->contact_person
                            : ''
                    );
                    ?>
                </td>

            </tr>


            <tr>

                <td class="info-label">
                    Start Date
                </td>

                <td>
                    <?php
                    echo pjod_format_date(
                        isset($job_order->start_date)
                            ? $job_order->start_date
                            : ''
                    );
                    ?>
                </td>

                <td class="info-label">
                    Finish Date
                </td>

                <td>
                    <?php
                    echo pjod_format_date(
                        isset($job_order->finish_date)
                            ? $job_order->finish_date
                            : ''
                    );
                    ?>
                </td>

            </tr>

        </table>


        <!-- =========================================================
             SALES ORDERS
        ========================================================== -->

        <?php if (!empty($sales_orders)) { ?>

            <?php foreach ($sales_orders as $so_index => $sales_order) { ?>

                <div class="sales-order-title">

                    Sales Order <?php echo ($so_index + 1); ?>

                    &nbsp;&nbsp; | &nbsp;&nbsp;

                    SO No:
                    <strong>
                        <?php
                        echo pjod_escape(
                            isset($sales_order->so_code)
                                ? $sales_order->so_code
                                : ''
                        );
                        ?>
                    </strong>

                    &nbsp;&nbsp; | &nbsp;&nbsp;

                    SO Date:
                    <strong>
                        <?php
                        echo pjod_format_date(
                            isset($sales_order->so_date)
                                ? $sales_order->so_date
                                : ''
                        );
                        ?>
                    </strong>

                </div>


                <!-- =================================================
                     SALES ORDER ITEMS
                ================================================== -->

                <?php if (!empty($sales_order->items)) { ?>

                    <?php foreach ($sales_order->items as $item_index => $item) { ?>

                        <table class="items-table">

                            <thead>

                                <tr>
                                    <th style="width:5%;">
                                        #
                                    </th>

                                    <th style="width:20%;">
                                        Item Code
                                    </th>

                                    <th>
                                        Item Description
                                    </th>

                                    <th style="width:10%;">
                                        Qty
                                    </th>

                                    <th style="width:12%;">
                                        Unit
                                    </th>

                                    <th style="width:12%;">
                                        Cost
                                    </th>

                                    <th style="width:14%;">
                                        Total
                                    </th>
                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td class="text-center">
                                        <?php echo ($item_index + 1); ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo pjod_escape(
                                            isset($item->item_code)
                                                ? $item->item_code
                                                : ''
                                        );
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        echo pjod_escape(
                                            isset($item->item_description)
                                                ? $item->item_description
                                                : (
                                                    isset($item->product_name)
                                                        ? $item->product_name
                                                        : ''
                                                )
                                        );
                                        ?>
                                    </td>

                                    <td class="text-right">
                                        <?php
                                        echo number_format(
                                            (float)(
                                                isset($item->quantity)
                                                    ? $item->quantity
                                                    : 0
                                            ),
                                            2
                                        );
                                        ?>
                                    </td>

                                    <td class="text-center">
                                        <?php
                                        echo pjod_escape(
                                            isset($item->unit)
                                                ? $item->unit
                                                : ''
                                        );
                                        ?>
                                    </td>

                                    <td class="text-right">
                                        <?php
                                        echo number_format(
                                            (float)(
                                                isset($item->cost)
                                                    ? $item->cost
                                                    : 0
                                            ),
                                            2
                                        );
                                        ?>
                                    </td>

                                    <td class="text-right">
                                        <?php
                                        $qty =
                                            isset($item->quantity)
                                                ? (float)$item->quantity
                                                : 0;

                                        $cost =
                                            isset($item->cost)
                                                ? (float)$item->cost
                                                : 0;

                                        echo number_format(
                                            $qty * $cost,
                                            2
                                        );
                                        ?>
                                    </td>

                                </tr>

                            </tbody>

                        </table>


                        <!-- =============================================
                             RAW MATERIALS
                        ============================================== -->

                        <div class="material-heading">
                            Raw Materials
                        </div>

                        <table class="material-table">

                            <thead>

                                <tr>

                                    <th style="width:5%;">
                                        #
                                    </th>

                                    <th style="width:15%;">
                                        Material Code
                                    </th>

                                    <th>
                                        Material Name
                                    </th>

                                    <th style="width:10%;">
                                        Unit
                                    </th>

                                    <th style="width:12%;">
                                        Required Qty
                                    </th>

                                    <th style="width:12%;">
                                        Cost
                                    </th>

                                    <th style="width:14%;">
                                        Total
                                    </th>

                                    <th style="width:10%;">
                                        Source
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if (!empty($item->materials)) { ?>

                                    <?php foreach ($item->materials as $material_index => $material) { ?>

                                        <tr>

                                            <td class="text-center">
                                                <?php echo ($material_index + 1); ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo pjod_escape(
                                                    isset($material->material_code)
                                                        ? $material->material_code
                                                        : ''
                                                );
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                echo pjod_escape(
                                                    isset($material->material_name)
                                                        ? $material->material_name
                                                        : ''
                                                );
                                                ?>
                                            </td>

                                            <td class="text-center">
                                                <?php
                                                echo pjod_escape(
                                                    isset($material->unit)
                                                        ? $material->unit
                                                        : ''
                                                );
                                                ?>
                                            </td>

                                            <td class="text-right">

                                                <?php
                                                $required_qty =
                                                    isset($material->quantity_required)
                                                        ? (float)$material->quantity_required
                                                        : 0;

                                                echo number_format(
                                                    $required_qty,
                                                    2
                                                );
                                                ?>

                                            </td>

                                            <td class="text-right">

                                                <?php
                                                $material_cost =
                                                    isset($material->cost)
                                                        ? (float)$material->cost
                                                        : 0;

                                                echo number_format(
                                                    $material_cost,
                                                    2
                                                );
                                                ?>

                                            </td>

                                            <td class="text-right">

                                                <?php
                                                echo number_format(
                                                    $required_qty * $material_cost,
                                                    2
                                                );
                                                ?>

                                            </td>

                                            <td class="text-center">

                                                <?php
                                                echo pjod_escape(
                                                    isset($material->source)
                                                        ? $material->source
                                                        : 'BOM'
                                                );
                                                ?>

                                            </td>

                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>

                                        <td
                                            colspan="8"
                                            class="text-center">

                                            No raw materials added.

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                        </table>

                    <?php } ?>

                <?php } else { ?>

                    <table class="items-table">

                        <tr>

                            <td
                                colspan="7"
                                class="text-center">

                                No Job Order Items found for this Sales Order.

                            </td>

                        </tr>

                    </table>

                <?php } ?>

            <?php } ?>

        <?php } else { ?>

            <table class="items-table">

                <tr>

                    <td
                        colspan="7"
                        class="text-center">

                        No Sales Orders assigned to this Project Job Order.

                    </td>

                </tr>

            </table>

        <?php } ?>


        <!-- =========================================================
             JOB ORDER REMARKS
        ========================================================== -->

        <?php
        $job_remarks =
            isset($job_order->remarks)
                ? trim($job_order->remarks)
                : '';

        $project_remarks =
            isset($project->remarks)
                ? trim($project->remarks)
                : (
                    isset($project->premarks)
                        ? trim($project->premarks)
                        : ''
                );
        ?>

        <?php if ($job_remarks != '' || $project_remarks != '') { ?>

            <div class="section-title">
                Remarks
            </div>

            <?php if ($job_remarks != '') { ?>

                <div class="remarks-box">

                    <strong>Job Order Remarks:</strong><br>

                    <?php
                    echo nl2br(
                        pjod_escape($job_remarks)
                    );
                    ?>

                </div>

            <?php } ?>


            <?php if ($project_remarks != '') { ?>

                <div class="remarks-box">

                    <strong>Project Remarks:</strong><br>

                    <?php
                    echo nl2br(
                        pjod_escape($project_remarks)
                    );
                    ?>

                </div>

            <?php } ?>

        <?php } ?>


        <!-- =========================================================
             SIGNATURES
        ========================================================== -->

        <table class="signature-table">

            <tr>

                <td>

                    <div class="signature-line"></div>

                    Prepared By

                </td>

                <td>

                    <div class="signature-line"></div>

                    Checked By

                </td>

                <td>

                    <div class="signature-line"></div>

                    Approved By

                </td>

            </tr>

        </table>

    </div>

</div>