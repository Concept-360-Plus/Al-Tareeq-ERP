<?php
$user = $this->session->userdata('user_id');
?>

<form id="main"
  method="post"
  action="<?php echo base_url() . 'index.php/'; ?>Reports/get_po_report"
  autocomplete="off">

  <div class="form-group" role="main">

    <div class="page-title"></div>
    <div class="clearfix"></div>

    <div class="x_content">

      <!-- =========================
                 FILTER SECTION
            ========================== -->

      <div class="well" style="overflow:auto;">

        <!-- ROW 1 -->

        <div class="row">

          <!-- Date From -->

          <div class="col-md-2 col-sm-6 col-xs-12">

            <label class="control-label">
              Date From:
            </label>

            <input type="date"
              name="from_date"
              class="form-control"
              value="<?php echo isset($from) ? $from : ''; ?>">

          </div>


          <!-- Date To -->

          <div class="col-md-2 col-sm-6 col-xs-12">

            <label class="control-label">
              Date To:
            </label>

            <input type="date"
              name="to_date"
              class="form-control"
              value="<?php echo isset($to) ? $to : ''; ?>">

          </div>


          <!-- Supplier -->

          <div class="col-md-3 col-sm-6 col-xs-12">

            <label class="control-label">
              Supplier:
            </label>

            <select name="supplier_id"
              id="supplier_id"
              class="form-control select2">

              <option value="">
                All Suppliers
              </option>

              <?php foreach ($supplier_records as $g) { ?>

                <option
                  value="<?php echo $g->supplier_id; ?>"
                  <?php
                  echo ($supplier_id == $g->supplier_id)
                    ? 'selected'
                    : '';
                  ?>>

                  <?php
                  echo $g->supplier_code . ' ' . $g->supplier_name;
                  ?>

                </option>

              <?php } ?>

            </select>

          </div>


          <!-- Created By -->

          <div class="col-md-3 col-sm-6 col-xs-12">

            <label class="control-label">
              Created By:
            </label>

            <select name="created_by"
              id="created_by"
              class="form-control select2">

              <option value="">
                All Users
              </option>

              <?php foreach ($user_list as $u) { ?>

                <option
                  value="<?php echo $u->user_id; ?>"
                  <?php
                  echo ($created_by == $u->user_id)
                    ? 'selected'
                    : '';
                  ?>>

                  <?php

                  if (!empty($u->employee_code)) {

                    echo $u->employee_code . ' ' . $u->user_name;
                  } else {

                    echo $u->user_name;
                  }

                  ?>

                </option>

              <?php } ?>

            </select>

          </div>

        </div>


        <br>


        <!-- ROW 2 -->

        <div class="row">


          <!-- Report Type -->

          <div class="col-md-3 col-sm-6 col-xs-12">

            <label class="control-label">
              Report Type:
            </label>

            <select name="report_type"
              id="report_type"
              class="form-control">

              <option value=""
                <?php echo empty($report_type) ? 'selected' : ''; ?>>
                All Purchase Orders
              </option>

              <option value="pending"
                <?php echo ($report_type == 'pending') ? 'selected' : ''; ?>>
                Pending Purchase Orders
              </option>

              <option value="awaiting_grn"
                <?php echo ($report_type == 'awaiting_grn') ? 'selected' : ''; ?>>
                PO Awaiting GRN
              </option>

              <option value="completed"
                <?php echo ($report_type == 'completed') ? 'selected' : ''; ?>>
                Completed Purchase Orders
              </option>

            </select>

          </div>


          <!-- PO Type -->

          <div class="col-md-3 col-sm-6 col-xs-12">

            <label class="control-label">
              PO Type:
            </label>

            <select name="po_type"
              id="po_type"
              class="form-control">

              <option value=""
                <?php echo empty($po_type) ? 'selected' : ''; ?>>
                All Types
              </option>

              <option value="quotation"
                <?php echo ($po_type == 'quotation') ? 'selected' : ''; ?>>
                Quotation Purchase
              </option>

              <option value="direct"
                <?php echo ($po_type == 'direct') ? 'selected' : ''; ?>>
                Direct RFQ
              </option>

            </select>

          </div>


          <!-- Buttons -->

          <div class="col-md-6 col-sm-12 col-xs-12"
            style="padding-top:25px;">

            <button type="submit"
              class="btn btn-primary">

              <i class="fa fa-search"></i>
              Go

            </button>


            <a href="javascript:void(0);"
              class="btn btn-warning"
              onclick="printPOReport(event)"
              style="color:#000;">

              <i class="fa fa-print"></i>
              Print

            </a>


            <a href="javascript:void(0);"
              class="btn btn-success"
              onclick="exportPOExcel(event)">

              <i class="fa fa-file-excel-o"></i>
              Excel

            </a>

          </div>

        </div>

      </div>


      <!-- =========================
                 REPORT TABLE
            ========================== -->

      <div class="dt-responsive table-responsive">

        <table id="basic-btn"
          class="table table-striped table-bordered nowrap">

          <thead>

            <tr>

              <th>Sl. No</th>

              <th>PO Code</th>

              <th>PO Type</th>

              <th>PO Date</th>

              <th>Supplier</th>

              <th>Grand Total</th>

              <th>Status</th>

              <th>Created By</th>

            </tr>

          </thead>


          <tbody>

            <?php

            $i = 1;

            if (!empty($records)) {

              foreach ($records as $row) :

            ?>

                <tr>

                  <td>
                    <?php echo $i++; ?>
                  </td>


                  <td>

                    <a target="_blank"
                      href="<?= base_url(
                              'index.php/Purchase/edit_po/' .
                                $row->po_id .
                                '/0/' .
                                ($row->po_type == 'direct' ? 2 : 1)
                            ); ?>">

                      <?= $row->po_code; ?>

                    </a>

                  </td>


                  <td>
                    <?php
                      if ($row->po_type == 'direct') {
                        echo 'DIRECT';
                      } elseif ($row->po_type == 'quotation') {
                        echo 'QUOTATION';
                      } else {
                        echo strtoupper($row->po_type);
                      }
                    ?>
                  </td>

                  <td>

                    <?php

                    echo date(
                      'd-M-Y',
                      strtotime($row->po_date)
                    );

                    ?>

                  </td>


                  <td>
                    <?= $row->supplier_name; ?>
                  </td>


                  <td>
                    <?= number_format(
                      (float)$row->grand_total,
                      2
                    ); ?>
                  </td>


                  <!-- STATUS -->

                  <td>

                    <?php

                    $status =
                      isset($row->report_status)
                      ? $row->report_status
                      : 'Pending';

                    if ($status == 'Completed') {

                      echo '<span class="label label-success">
                                                Completed
                                              </span>';
                    } elseif ($status == 'Awaiting GRN') {

                      echo '<span class="label label-warning"
                                                style="color:#000;">
                                                Awaiting GRN
                                              </span>';
                    } else {

                      echo '<span class="label label-danger">
                                                Pending
                                              </span>';
                    }

                    ?>

                  </td>


                  <td>
                    <?= $row->rfq_created_by; ?>
                  </td>

                </tr>

              <?php

              endforeach;
            } else {

              ?>

              <tr>

                <td colspan="8"
                  class="text-center">

                  No Purchase Orders found.

                </td>

              </tr>

            <?php } ?>

          </tbody>


          <tfoot>

            <tr>

              <th>Sl. No</th>
              <th>PO Code</th>
              <th>PO Type</th>
              <th>PO Date</th>
              <th>Supplier</th>
              <th>Grand Total</th>
              <th>Status</th>
              <th>Created By</th>

            </tr>

          </tfoot>

        </table>

      </div>

    </div>

  </div>

</form>


<script>
  function getPOFilters() {

    return {

      from_date: document.querySelector(
        'input[name="from_date"]'
      ).value,

      to_date: document.querySelector(
        'input[name="to_date"]'
      ).value,

      supplier_id: document.querySelector(
        'select[name="supplier_id"]'
      ).value,

      created_by: document.querySelector(
        'select[name="created_by"]'
      ).value,

      report_type: document.querySelector(
        'select[name="report_type"]'
      ).value,

      po_type: document.querySelector(
        'select[name="po_type"]'
      ).value

    };

  }


  /* =========================
     PRINT
  ========================== */

  function printPOReport(event) {

    if (event) {
      event.preventDefault();
    }

    const filters = getPOFilters();

    const baseUrl =
      "<?php echo base_url('index.php/Reports/print_po_report'); ?>";

    const params =
      new URLSearchParams(filters);

    window.open(
      baseUrl + "?" + params.toString(),
      '_blank'
    );

    return false;

  }


  /* =========================
     EXCEL
  ========================== */

  function exportPOExcel(event) {

    if (event) {
      event.preventDefault();
    }

    const filters = getPOFilters();

    const baseUrl =
      "<?php echo base_url('index.php/Reports/export_po_excel'); ?>";

    const params =
      new URLSearchParams(filters);

    window.location.href =
      baseUrl + "?" + params.toString();

    return false;

  }
</script>