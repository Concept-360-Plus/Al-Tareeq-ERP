<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Resignation Application</title>

    <style>
        body {
            margin: 20px;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .title {
            background: #ff0080;
            border: 1px solid #000;
            text-align: center;
            font-size: 24px;
            padding: 8px;
            margin-bottom: 10px;
        }

        .section-title {
            border: 1px solid #000;
            background: #f5f5f5;
            font-weight: bold;
            padding: 6px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 7px;
            vertical-align: top;
        }

        th {
            width: 20%;
            background: #f8f8f8;
            text-align: left;
        }

        .signature {
            height: 70px;
        }

        .documents th {
            width: auto;
        }

        .no-print {
            margin-bottom: 15px;
        }

        a {
            color: #000;
            text-decoration: none;
        }

        @media print {

            .no-print {
                display: none;
            }

            body {
                margin: 10px;
            }
        }
    </style>

</head>

<body onload="window.print();">

    <?php

    $row = $resignation;

    function format_date($date)
    {
        if (empty($date) || $date == '0000-00-00') {
            return '';
        }

        return date(
            'd-M-Y',
            strtotime($date)
        );
    }

    ?>

    <div class="no-print">
        <button onclick="window.print();">
            Print
        </button>
    </div>


    <!-- TITLE -->

    <div class="title">
        Resignation Application
    </div>


    <!-- GENERAL INFORMATION -->

    <div class="section-title">
        General Information
    </div>

    <table>

        <tr>

            <th>Employee Name</th>
            <td>
                <?php echo htmlspecialchars(
                    $row->employee_name ?? ''
                ); ?>
            </td>

            <th>Employee Code</th>
            <td>
                <?php echo htmlspecialchars(
                    $row->user_code ?? ''
                ); ?>
            </td>

        </tr>


        <tr>

            <th>Joining Date</th>
            <td>
                <?php echo format_date(
                    $row->joining_date ?? ''
                ); ?>
            </td>

            <th>Mobile No.</th>
            <td>
                <?php echo htmlspecialchars(
                    $row->mobile ?? ''
                ); ?>
            </td>

        </tr>


        <tr>

            <th>Designation</th>
            <td>
                <?php echo htmlspecialchars(
                    $row->designation_name ?? ''
                ); ?>
            </td>

            <th>Department / Project</th>
            <td>
                <?php echo htmlspecialchars(
                    $row->department_name ?? ''
                ); ?>
            </td>

        </tr>


        <tr>

            <th>Resignation Code</th>
            <td>
                <?php echo htmlspecialchars(
                    $row->resign_code ?? ''
                ); ?>
            </td>

            <th>Resignation Date</th>
            <td>
                <?php echo format_date(
                    $row->resignation_date ?? ''
                ); ?>
            </td>

        </tr>

    </table>


    <!-- RESIGNATION DETAILS -->

    <div class="section-title">
        Resignation Details
    </div>

    <table>

        <tr>

            <th>Resignation Reason</th>

            <td colspan="3">
                <?php echo nl2br(
                    htmlspecialchars(
                        $row->reason ?? ''
                    )
                ); ?>
            </td>

        </tr>


        <tr>

            <th>Effective Start Date</th>

            <td>
                <?php echo format_date(
                    $row->resignation_date ?? ''
                ); ?>
            </td>

            <th>Effective Last Working Date</th>

            <td>
                <?php echo format_date(
                    $row->last_working_date ?? ''
                ); ?>
            </td>

        </tr>


        <tr>

            <th>Total Notice Period Days</th>

            <td colspan="3">
                <?php echo htmlspecialchars(
                    $row->notice_days ?? ''
                ); ?>
            </td>

        </tr>

    </table>


    <!-- DOCUMENT CHECKLIST -->

    <div class="section-title">
        Resignation Document Checklist
    </div>

    <table class="documents">

        <thead>

            <tr>

                <th style="width:60px;">
                    #
                </th>

                <th>
                    Document Type
                </th>

                <th>
                    File
                </th>

            </tr>

        </thead>

        <tbody>

            <?php if (!empty($file_records)): ?>

                <?php $i = 1; ?>

                <?php foreach ($file_records as $file): ?>

                    <tr>

                        <td>
                            <?php echo $i++; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars(
                                $file->document_name ?? 'Other'
                            ); ?>
                        </td>

                        <td>

                            <?php if (!empty($file->document_path)): ?>

                                <?php
                                $file_url =
                                    base_url(
                                        'public/uploaded_documents/' .
                                            $file->document_path
                                    );
                                ?>

                                <a
                                    href="<?php echo $file_url; ?>"
                                    target="_blank">

                                    View Document

                                </a>

                            <?php else: ?>

                                Not Available

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td colspan="3">
                        No resignation documents uploaded.
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table>


    <!-- APPROVAL / SIGNATURE -->

    <div class="section-title">
        Approval / Signature
    </div>

    <table>

        <tr>

            <th>Employee Signature</th>
            <td class="signature"></td>

            <th>PM Signature</th>
            <td class="signature"></td>

        </tr>

        <tr>

            <th>HR Signature</th>
            <td class="signature"></td>

            <th>MD Signature</th>
            <td class="signature"></td>

        </tr>

    </table>


</body>

</html>