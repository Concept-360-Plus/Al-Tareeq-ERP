<div class="content-wrapper">

    <section class="content">
        <div class="card">
            <div class="card-body">
                <form id="main"
                    method="post"
                    action="<?php echo base_url() . 'index.php/'; ?>Reports/get_purchase_request_report"
                    autocomplete="off">
                    <div class="row">
                        <div class="col-md-3">
                            <label>From Date <span class="text-danger">*</span></label>
                            <input type="date"
                                name="from_date"
                                class="form-control"
                                value="<?php echo $from; ?>" required />
                        </div>

                        <div class="col-md-3">
                            <label>To Date <span class="text-danger">*</span></label>
                            <input type="date"
                                name="to_date"
                                class="form-control"
                                value="<?php echo $to; ?>" required />
                        </div>

                        <div class="col-md-3">
                            <label>Supplier</label>
                            <select name="supplier_id"
                                class="form-control select2">
                                <option value="">All Suppliers</option>
                                <?php foreach ($supplier_records as $supplier) { ?>
                                    <option value="<?php echo $supplier->supplier_id; ?>"
                                        <?php echo (
                                            isset($_GET['supplier_id']) &&
                                            $_GET['supplier_id'] == $supplier->supplier_id
                                        ) ? 'selected' : ''; ?>>
                                        <?php echo $supplier->supplier_code . ' ' . $supplier->supplier_name; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Created By:</label>
                            <select name="created_by" class="form-control select2">
                                <option value="">All Users</option>
                                <?php foreach ($user_list as $user) { ?>
                                    <option value="<?php echo $user->user_id; ?>"
                                        <?php
                                        echo ($created_by == $user->user_id)
                                            ? 'selected'
                                            : '';
                                        ?>>

                                        <?php
                                        if (!empty($user->employee_code)) {
                                            echo $user->employee_code . ' ' . $user->user_name;
                                        } else {
                                            echo $user->user_name;
                                        }
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">

                            <button type="submit"
                                class="btn btn-primary">
                                <i class="fa fa-search"></i>
                                Go
                            </button>

                            <a href="javascript:void(0);"
                                class="btn btn-warning"
                                onclick="printPurchaseRequestReport(event)"
                                style="color:#000;">
                                <i class="fa fa-print"></i>
                                Print
                            </a>

                            <a href="javascript:void(0);"
                                class="btn btn-success"
                                onclick="exportPurchaseRequestExcel(event)"
                                style="color:#fff;">
                                <i class="fa fa-file-excel-o"></i>
                                Export to Excel
                            </a>

                        </div>
                    </div>
                </form>
            </div>
        </div>


        <?php if (isset($records)) { ?>
            <div class="card mt-3">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>PR Code</th>
                                    <th>PR Date</th>
                                    <th>Branch</th>
                                    <th>Supplier</th>
                                    <th>Material Issue</th>
                                    <th>Project</th>
                                    <th>Created By</th>
                                    <th>Subject</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($records)) { ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($records as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><a target='blank' title="RFQ Details" href="<?php echo base_url() . 'index.php/Purchase/edit_pr_from_mi/' . $row->pr_id; ?>"><?php echo $row->pr_code; ?></a></td>
                                            <td>
                                                <?php echo date(
                                                    'd-m-Y',
                                                    strtotime($row->pr_date)
                                                ); ?>
                                            </td>
                                            <td>
                                                <?php echo $row->branch_name ?: '-'; ?>
                                            </td>
                                            <td>
                                                <?php echo $row->supplier_name ?: '-'; ?>
                                            </td>
                                            <td>
                                                <?php echo $row->mi_code ?: '-'; ?>
                                            </td>
                                            <td>
                                                <?php echo $row->project ?: '-'; ?>
                                            </td>
                                            <td>
                                                <?php echo $row->created_by_name ?: '-'; ?>
                                            </td>
                                            <td>
                                                <?php echo $row->subject ?: '-'; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="9"
                                            class="text-center">
                                            No Purchase Requests found.
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sl No</th>
                                    <th>PR Code</th>
                                    <th>PR Date</th>
                                    <th>Branch</th>
                                    <th>Supplier</th>
                                    <th>Material Issue</th>
                                    <th>Project</th>
                                    <th>Created By</th>
                                    <th>Subject</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
</div>

<script>
    function printPurchaseRequestReport(event) {
        if (event) {
            event.preventDefault();
        }

        const fromDate =
            document.querySelector('input[name="from_date"]').value;

        const toDate =
            document.querySelector('input[name="to_date"]').value;

        const supplierId =
            document.querySelector('select[name="supplier_id"]').value;

        const createdBy =
            document.querySelector('select[name="created_by"]').value;

        const baseUrl =
            "<?php echo base_url('index.php/Reports/print_purchase_request_report'); ?>";

        const params = new URLSearchParams({
            from_date: fromDate,
            to_date: toDate,
            supplier_id: supplierId,
            created_by: createdBy
        });

        window.open(
            baseUrl + "?" + params.toString(),
            '_blank'
        );

        return false;
    }


    function exportPurchaseRequestExcel(event) {
        if (event) {
            event.preventDefault();
        }

        const fromDate =
            document.querySelector('input[name="from_date"]').value;

        const toDate =
            document.querySelector('input[name="to_date"]').value;

        const supplierId =
            document.querySelector('select[name="supplier_id"]').value;

        const createdBy =
            document.querySelector('select[name="created_by"]').value;

        const baseUrl =
            "<?php echo base_url('index.php/Reports/export_purchase_request_excel'); ?>";

        const params = new URLSearchParams({
            from_date: fromDate,
            to_date: toDate,
            supplier_id: supplierId,
            created_by: createdBy
        });

        window.location.href =
            baseUrl + "?" + params.toString();

        return false;
    }
</script>