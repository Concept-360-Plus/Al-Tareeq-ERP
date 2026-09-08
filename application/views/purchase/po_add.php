<!-- Page Content -->
<form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Purchase/add_po_records"
  autocomplete="off" enctype="multipart/form-data">

  <div class="page-title"></div>
  <div class="clearfix"></div>

  <div class="x_content">
    <div class="well">

      <!-- Row 1: Quotation, PO Code, PO Date -->
      <div class="row mb-3">

        <div class="col-md-3">
          <label class="control-label">Select Quotation</label>
          <select class="form-control select2" name="quotation_id" id="quotation_id" required onchange="get_quotation_info()">
            <option value="">--Select--</option>
            <?php foreach ($records as $s) { ?>
              <option value="<?php echo $s->quotation_id; ?>"
                <?php echo (isset($selected_quotation_id) && $selected_quotation_id == $s->quotation_id) ? 'selected' : ''; ?>>
                <?php echo $s->quotation_code; ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="col-md-4">
          <label class="control-label">PO Code</label>
          <input type="text" class="form-control" name="po_code" id="po_code" readonly value="<?php echo $Code; ?>">
        </div>

        <div class="col-md-3">
          <label class="control-label">PO Date</label>
          <input type="date" class="form-control" name="po_date" id="po_date" value="<?php echo date('Y-m-d'); ?>">
        </div>

      </div>

      <!-- Row 2: Branch, Supplier, Reference -->
      <div class="row mb-3">

        <div class="col-md-3">
          <label class="control-label">Branch</label>
          <select class="form-control select2" name="Branch_id" id="Branch_id" required>
            <option value="">Select Branch</option>
            <?php foreach ($branch_records as $b) { ?>
              <option value="<?php echo $b->branch_id; ?>">
                <?php echo htmlspecialchars($b->branch_name, ENT_QUOTES, 'UTF-8'); ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="col-md-4">
          <label class="control-label">Supplier</label>
          <select class="form-control select2"
            name="supplier_id"
            id="supplier_id"
            required>
            <option value="">Select Supplier</option>
            <?php foreach ($supplier_records as $s) { ?>
              <option value="<?php echo $s->supplier_id; ?>">
                <?php echo htmlspecialchars(
                  $s->supplier_code . ' - ' . $s->supplier_name,
                  ENT_QUOTES,
                  'UTF-8'
                ); ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="col-md-3">
          <label>Purchase Type <span class="text-danger">*</span></label>
          <select name="purchase_type"
            id="purchase_type"
            class="form-control"
            required>

            <option value="Local"
              <?php echo (isset($records1[0]->purchase_type) && $records1[0]->purchase_type == 'Local') ? 'selected' : ''; ?>>
              Local
            </option>

            <option value="International"
              <?php echo (isset($records1[0]->purchase_type) && $records1[0]->purchase_type == 'International') ? 'selected' : ''; ?>>
              International
            </option>

          </select>
        </div>

      </div>

      <!-- Row 3: Subject, Freight Mode -->
      <div class="row mb-3">
        <div class="col-md-3">
          <label class="control-label">Freight Mode</label>
          <select class="form-control" name="freight_mode" id="freight_mode">
            <option value="">--Select ---</option>
            <option value="Sea">Sea</option>
            <option value="Air">Air</option>
            <option value="Road">Road</option>
            <option value="Courier">Courier</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="control-label">Freight Forwarder</label>
          <input type="text" class="form-control" name="subject" id="subject">
        </div>

        <div class="col-md-3">
          <label for="ref_no" class="form-label">Select Project</label>

          <select
            class="form-control select2"
            name="project"
            id="project">

            <option value="">Select Project</option>

            <?php if (!empty($project_records)) { ?>

              <?php foreach ($project_records as $project) { ?>

                <option value="<?= htmlspecialchars($project['project_name'], ENT_QUOTES, 'UTF-8') ?>">

                  <?= htmlspecialchars($project['project_name'], ENT_QUOTES, 'UTF-8') ?>

                  <?php if (!empty($project['project_code'])) { ?>
                    (<?= htmlspecialchars($project['project_code'], ENT_QUOTES, 'UTF-8') ?>)
                  <?php } ?>

                </option>

              <?php } ?>

            <?php } ?>

          </select>
        </div>

      </div>

      <!-- Row 4: Upload, Project -->
      <div class="row mb-3">

        <div class="col-md-3">
          <label class="control-label">Reference</label>
          <input type="text" class="form-control" name="ref_no" id="ref_no">
        </div>

        <div class="col-md-3">
          <label class="control-label">Upload Document</label>
          <input type="file" class="form-control" name="po_doc" id="po_doc">
        </div>
        <!-- <div class="col-md-3">
          <label>Prepared By</label>
          <input type="text" class="form-control" name="sales_person" id="sales_person">
        </div> -->

      </div>

      <!-- Quotation Items -->
      <div class="row">
        <div class="col-md-12" id="quote_items_list" style="overflow-x:auto;"></div>
      </div>

      <!-- Totals -->
      <div class="row mb-3">
        <div class="col-md-3">
          <label>Sub Total</label>
          <input type="text" class="form-control" name="sub_total" id="sub_total" readonly>
        </div>
        <div class="col-md-2">
          <label>Discount(%)</label>
          <input type="text" class="form-control" name="discount_per" id="discount_per">
        </div>
        <div class="col-md-3">
          <label>Discount Amt</label>
          <input type="text" class="form-control" name="discount_amt" id="discount_amt">
        </div>
        <div class="col-md-3">
          <label>Transportation Charge</label>
          <input type="number" class="form-control" name="transportation_charge" id="transportation_charge">
        </div>

      </div>


      <!-- Charges -->
      <div class="row mb-3">
        <div class="col-md-2">
          <label>Freight Charge</label>
          <input type="number" class="form-control" name="customs_charge" id="customs_charge">
        </div>
        <div class="col-md-2">
          <label>Other Charges</label>
          <input type="number" class="form-control" name="other_charge" id="other_charge">
        </div>
        <div class="col-md-3">
          <label>Total before VAT</label>
          <input type="text" class="form-control" name="total_beforvat" id="total_beforvat" readonly>
        </div>
        <div class="col-md-2">
          <label>VAT(%)</label>
          <input type="text" class="form-control" name="vat_per" id="vat_per">
        </div>
        <div class="col-md-2">
          <label>VAT Amount</label>
          <input type="text" class="form-control" name="vat_amount" id="vat_amount">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-3">
          <label>Grand Total</label>
          <input type="text" class="form-control" name="grand_total" id="grand_total" readonly>
        </div>
        <div class="col-md-3">
          <label>Currency</label>
          <input type="text" class="form-control" name="currency" id="currency" readonly>
        </div>
        <div class="col-md-2">
          <label>Conversion Rate</label>
          <input type="text" class="form-control" name="conversion_rate" id="conversion_rate">
        </div>
        <div class="col-md-3">
          <label>Grand Total(Base Currency)</label>
          <input type="text" class="form-control" name="base_currency_grand_total" id="base_currency_grand_total" readonly>
        </div>
      </div>

      <!-- Validity + Payment Terms -->
      <div class="row mb-3">

        <div class="col-md-6">
          <label>Validity</label>
          <input type="text" class="form-control" name="validity" id="validity">
        </div>

        <div class="col-md-6">

          <label for="payment_terms_select" class="form-label">
            Payment Terms
          </label>

          <select
            class="form-control term-select select2"
            id="payment_terms_select"
            name="payment_term_id">

            <option value="">
              Please select payment terms
            </option>

            <?php if (!empty($payment_terms_list)) { ?>

              <?php foreach ($payment_terms_list as $term) { ?>

                <option
                  value="<?php echo $term->terms_id; ?>"
                  data-description="<?php
                                    echo htmlspecialchars(
                                      $term->terms_description,
                                      ENT_QUOTES,
                                      'UTF-8'
                                    );
                                    ?>">
                  <?php echo htmlspecialchars(
                    $term->terms_name,
                    ENT_QUOTES,
                    'UTF-8'
                  ); ?>
                </option>

              <?php } ?>

            <?php } ?>

          </select>

          <small>
            <a href="#"
              class="add-term-link"
              data-term-type="PAYMENT">
              + Add New Payment Term
            </a>
          </small>

          <input
            type="hidden"
            name="payment_terms"
            id="payment_terms">

        </div>

      </div>

      <!-- Delivery Terms + General Terms -->
      <div class="row mb-3">

        <div class="col-md-6">

          <label for="delivery_terms_select" class="form-label">
            Delivery Terms
          </label>

          <select
            class="form-control term-select select2"
            id="delivery_terms_select"
            name="delivery_term_id">

            <option value="">
              Please select delivery terms
            </option>

            <?php if (!empty($delivery_terms_list)) { ?>

              <?php foreach ($delivery_terms_list as $term) { ?>

                <option
                  value="<?php echo $term->terms_id; ?>"
                  data-description="<?php
                                    echo htmlspecialchars(
                                      $term->terms_description,
                                      ENT_QUOTES,
                                      'UTF-8'
                                    );
                                    ?>">
                  <?php echo htmlspecialchars(
                    $term->terms_name,
                    ENT_QUOTES,
                    'UTF-8'
                  ); ?>
                </option>

              <?php } ?>

            <?php } ?>

          </select>

          <small>
            <a href="#"
              class="add-term-link"
              data-term-type="DELIVERY">
              + Add New Delivery Term
            </a>
          </small>

          <input
            type="hidden"
            name="delivery_terms"
            id="delivery_terms">

        </div>

        <div class="col-md-6">
          <label for="general_terms_select" class="form-label">
            General Terms
          </label>

          <select class="form-control term-select select2" id="general_terms_select" name="general_term_id">
            <option value="">
              Please select general terms
            </option>
            <?php if (!empty($general_terms_list)) { ?>
              <?php foreach ($general_terms_list as $term) { ?>
                <option value="<?php echo $term->terms_id; ?>" data-description="<?php echo htmlspecialchars($term->terms_description, ENT_QUOTES, 'UTF-8'); ?>">
                  <?php echo htmlspecialchars(
                    $term->terms_name,
                    ENT_QUOTES,
                    'UTF-8'
                  ); ?>
                </option>
              <?php } ?>
            <?php } ?>
          </select>
          <small>
            <a href="#"
              class="add-term-link"
              data-term-type="GENERAL">
              + Add New General Term
            </a>
          </small>
          <input type="hidden" name="general_terms" id="general_terms">
        </div>

      </div>

      <!-- Prepared / Approved -->
      <!-- <div class="row mb-3">
        <div class="col-md-3">
          <label>Approved By</label>
          <input type="text" class="form-control" name="approved_by" id="approved_by">
        </div>
      </div> -->
      <div class="row mt-3">
        <div class="col-md-4">
          <!-- Employee Name -->
          <div class="item form-group">
            <label class="col-form-label col-md-4 col-sm-4 label-align">Prepared By:</label>
            <div class="col-md-6 col-sm-6 ">
              <select class="form-control select2"
                id="employee_prepared" name="employee_prepared" required>
                <option value="">Select</option>
                <?php foreach ($employees as $s) { ?>
                  <option value="<?php echo $s->employee_id  ?>"><?php echo $s->user_code . ' ' . $s->employee_name; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <!-- Employee Name -->
          <div class="item form-group">
            <label class="col-form-label col-md-4 col-sm-4 label-align">Checked By:</label>
            <div class="col-md-6 col-sm-6 ">
              <select class="form-control select2"
                id="employee_checked" name="employee_checked" required>
                <option value="">Select</option>
                <?php foreach ($employees as $s) { ?>
                  <option value="<?php echo $s->employee_id  ?>"><?php echo $s->user_code . ' ' . $s->employee_name; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <!-- Employee Name -->
          <div class="item form-group">
            <label class="col-form-label col-md-4 col-sm-4 label-align">Approved By:</label>
            <div class="col-md-6 col-sm-6 ">
              <select class="form-control select2"
                id="employee_approved" name="employee_approved" required>
                <option value="">Select</option>
                <?php foreach ($employees as $s) { ?>
                  <option value="<?php echo $s->employee_id  ?>"><?php echo $s->user_code . ' ' . $s->employee_name; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Submit -->
      <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-success" name="action" value="save">Save PO</button>
          <!-- <button type="submit" class="btn btn-primary" name="action" value="save_and_grn">Save & Create GRN</button> -->
        </div>
      </div>

    </div><!-- /.well -->
  </div><!-- /.x_content -->
</form>

<!-- /page content -->
</form>

<div
  class="modal fade"
  id="addTermModal"
  tabindex="-1"
  role="dialog"
  aria-hidden="true">

  <div id="addTermModalContent"></div>

</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
  $(document).ready(function() {


    ////////////////////////////////////////////////////////////
    // INITIALIZE SELECT2
    ////////////////////////////////////////////////////////////

    $('.select2').select2({
      width: '100%',
      placeholder: 'Select',
      allowClear: true
    });


    //////////////////////////////// PAYMENT TERM CHANGE//////////////////////////
    $('#payment_terms_select').on('change', function() {
      var description = $(this)
        .find(':selected')
        .attr('data-description') || '';
      $('#payment_terms').val(description);

    });

    ///////////////////// DELIVERY TERM CHANGE//////////////////////
    $('#delivery_terms_select').on('change', function() {
      var description = $(this)
        .find(':selected')
        .attr('data-description') || '';
      $('#delivery_terms').val(description);

    });

    //////////////////////////////////////GENERAL TERM CHANGE/////////////////////////
    $('#general_terms_select').on('change', function() {
      var description = $(this)
        .find(':selected')
        .attr('data-description') || '';
      $('#general_terms').val(description);
    });


    /////////////////ADD NEW TERM//////////////////////////////

    $(document).on(
      'click',
      '.add-term-link',
      function(e) {
        e.preventDefault();
        var termType = $(this).data('term-type');
        $.ajax({
          url: "<?php echo base_url('index.php/Ajax/add_new_term'); ?>",
          type: "POST",
          data: {
            term_type: termType
          },


          success: function(response) {
            $('#addTermModalContent')
              .html(response);
            $('#addTermModal').modal('show');

            // Initialize CKEditor
            if (typeof CKEDITOR !== 'undefined') {

              if (CKEDITOR.instances['new_terms_description']) {
                CKEDITOR.instances['new_terms_description'].destroy(true);
              }

              CKEDITOR.replace('new_terms_description');
            }
          },

          error: function() {
            alert(
              'Unable to open Add Term form.'
            );
          }
        });
      }
    );


    //////////////////////SAVE NEW TERM////////////////////////////////

    $(document).on(
      'click',
      '#saveNewTermBtn',
      function() {

        var $button = $(this);

        var termType =
          $('#new_term_type').val();

        var termName =
          $.trim(
            $('#new_terms_name').val()
          );

        var description =
          $.trim(
            $('#new_terms_description').val()
          );


        if (termName == '') {

          alert(
            'Terms & Conditions Name is required.'
          );

          $('#new_terms_name').focus();

          return;

        }


        $button
          .prop('disabled', true)
          .html(
            '<i class="fa fa-spinner fa-spin"></i> Saving...'
          );


        $.ajax({
          url: "<?php echo base_url('index.php/Ajax/save_term_ajax'); ?>",
          type: "POST",
          dataType: "json",
          data: {
            term_type: termType,
            terms_name: termName,
            terms_description: description
          },

          success: function(response) {
            if (response.success) {
              var selectId = '';
              if (response.term_type == 'PAYMENT') {
                selectId = '#payment_terms_select';
              } else if (
                response.term_type == 'DELIVERY'
              ) {
                selectId = '#delivery_terms_select';
              } else if (
                response.term_type == 'GENERAL'
              ) {
                selectId = '#general_terms_select';
              }

              var $select = $(selectId);

              // Add new option
              var newOption =
                new Option(
                  response.terms_name,
                  response.terms_id,
                  true,
                  true
                );


              $(newOption)
                .attr(
                  'data-description',
                  response.terms_description
                );


              $select
                .append(newOption)
                .trigger('change');


              // Update hidden description
              if (
                response.term_type ==
                'PAYMENT'
              ) {

                $('#payment_terms')
                  .val(
                    response.terms_description
                  );

              } else if (
                response.term_type ==
                'DELIVERY'
              ) {
                $('#delivery_terms')
                  .val(
                    response.terms_description
                  );

              } else if (
                response.term_type ==
                'GENERAL'
              ) {
                $('#general_terms')
                  .val(
                    response.terms_description
                  );
              }

              // Close modal
              $('#addTermModal').modal('hide');

              // Reset modal
              $('#addTermModalContent').html('');

            } else {
              alert(
                response.message ||
                'Failed to save term.'
              );

              $button
                .prop('disabled', false)
                .html(
                  '<i class="fa fa-save"></i> Save'
                );
            }
          },

          error: function() {
            alert(
              'Something went wrong while saving.'
            );

            $button
              .prop('disabled', false)
              .html(
                '<i class="fa fa-save"></i> Save'
              );
          }
        });
      }
    );
  });

  function get_quotation_info() {

    var quotation_id = $('#quotation_id').val();

    if (quotation_id != '') {

      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/Ajax/ajax_get_quote_info",
        data: {
          quotation_id: quotation_id
        },
        dataType: "json",

        success: function(msg) {

          console.log("Quotation Info:", msg);

          // =========================
          // Branch
          // =========================
          $('#Branch_id')
            .val(msg.branch_id)
            .trigger('change');


          // =========================
          // Supplier
          // =========================
          $('#supplier_id')
            .val(msg.supplier_id)
            .trigger('change');


          // =========================
          // Reference
          // =========================
          $('#ref_no').val(msg.reference);


          // =========================
          // Project
          // =========================
          $('#project')
            .val(msg.project)
            .trigger('change');


          // =========================
          // Load quotation items
          // =========================
          get_quote_items_list(quotation_id);


          // =========================
          // Totals
          // =========================
          $('#sub_total').val(msg.subtotal);
          $('#discount_per').val(msg.discount_percent);
          $('#discount_amt').val(msg.discount);

          $('#vat_per').val(msg.vat_percent);
          $('#vat_amount').val(msg.vat_amt);

          $('#grand_total').val(msg.grand_total);
          $('#currency').val(msg.currency);

          $('#validity').val(msg.validity);

          $('#payment_terms').val(msg.payment_term);

        },

        error: function(xhr, status, error) {

          console.error("Quotation AJAX Error:", error);
          console.error(xhr.responseText);

          alert("Unable to load quotation details.");
        }
      });

    } else {

      $('#quote_items_list').html('');

      $('#Branch_id').val('').trigger('change');
      $('#supplier_id').val('').trigger('change');
      $('#project').val('').trigger('change');

    }
  }

  $(document).ready(function() {
    // pick up selected id passed from controller
    var selected = <?php echo json_encode(isset($selected_quotation_id) ? $selected_quotation_id : ''); ?>;

    if (selected) {
      // set the select value
      $('#quotation_id').val(selected);

      // if you're using select2, update it
      if ($('#quotation_id').hasClass('select2-hidden-accessible')) {
        $('#quotation_id').trigger('change.select2');
      } else {
        $('#quotation_id').trigger('change');
      }

      // small timeout to ensure change event settled, then fetch items
      setTimeout(function() {
        get_quotation_info();
      }, 150);
    }
  });

  function get_quote_items_list(quotation_id) {

    $.ajax({
      type: "POST",
      url: "<?php echo base_url() ?>index.php/Ajax/get_quote_items_for_po",
      data: {
        quotation_id: quotation_id
      },
      success: function(msg) {
        document.getElementById('quote_items_list').innerHTML = msg;
      }
    });

  }
  $(document).ready(function() {
    // Event listener for row-level changes
    $(document).on('input change', '.qty, .unit_price, .dis_per, .dis_amt, .dis_per2, .dis_amt2', function() {
      var $row = $(this).closest('tr');
      calculateRow($row);
      calculateAll();
    });

    // Event listener for global discount and VAT
    $('#discount_per, #discount_amt, #vat_per, #transportation_charge, #customs_charge, #other_charge, #conversion_rate')
      .on('input change', function() {
        calculateAll();
      });


    function calculateRow($row) {
      var qty = parseFloat($row.find('.qty').val()) || 0;
      var price = parseFloat($row.find('.unit_price').val()) || 0;

      var disPer1 = parseFloat($row.find('.dis_per').val()) || 0;
      var disAmt1 = parseFloat($row.find('.dis_amt').val()) || 0;

      //var disPer2 = parseFloat($row.find('.dis_per2').val()) || 0;
      // var disAmt2 = parseFloat($row.find('.dis_amt2').val()) || 0;

      var rowTotal = qty * price;

      // First Discount
      if ($row.find('.dis_per').is(':focus')) {
        disAmt1 = (rowTotal * disPer1) / 100;
        $row.find('.dis_amt').val(disAmt1.toFixed(2));
      } else if ($row.find('.dis_amt').is(':focus')) {
        disPer1 = rowTotal === 0 ? 0 : (disAmt1 / rowTotal) * 100;
        $row.find('.dis_per').val(disPer1.toFixed(2));
      } else {
        disAmt1 = (rowTotal * disPer1) / 100;
        $row.find('.dis_amt').val(disAmt1.toFixed(2));
      }

      var subtotalAfterFirst = rowTotal - disAmt1;

      /* Second Discount
      if ($row.find('.dis_per2').is(':focus')) {
          disAmt2 = (subtotalAfterFirst * disPer2) / 100;
          $row.find('.dis_amt2').val(disAmt2.toFixed(2));
      } else if ($row.find('.dis_amt2').is(':focus')) {
          disPer2 = subtotalAfterFirst === 0 ? 0 : (disAmt2 / subtotalAfterFirst) * 100;
          $row.find('.dis_per2').val(disPer2.toFixed(2));
      } else {
          disAmt2 = (subtotalAfterFirst * disPer2) / 100;
          $row.find('.dis_amt2').val(disAmt2.toFixed(2));
      }*/

      var finalRowTotal = subtotalAfterFirst;

      // Final Unit Price
      var finalUnitPrice = (qty > 0) ? finalRowTotal / qty : 0;
      $row.find('.final_unit_price').val(finalUnitPrice.toFixed(2));

      $row.find('.total_price').val(finalRowTotal.toFixed(2));
    }

    function calculateAll() {
      var subtotal = 0;

      // Calculate subtotal from all rows
      $('tbody tr').each(function() {
        subtotal += parseFloat($(this).find('.total_price').val()) || 0;
      });

      $('#sub_total').val(subtotal.toFixed(2));

      // ----- Global Discount -----
      var discountPer = parseFloat($('#discount_per').val()) || 0;
      var discountAmt = parseFloat($('#discount_amt').val()) || 0;

      if ($('#discount_per').is(':focus')) {
        discountAmt = (subtotal * discountPer) / 100;
        $('#discount_amt').val(discountAmt.toFixed(2));
      } else if ($('#discount_amt').is(':focus')) {
        discountPer = (subtotal === 0) ? 0 : (discountAmt / subtotal) * 100;
        $('#discount_per').val(discountPer.toFixed(2));
      } else {
        discountAmt = (subtotal * discountPer) / 100;
        $('#discount_amt').val(discountAmt.toFixed(2));
      }

      var afterDiscount = subtotal - discountAmt;

      // --- Charges ---
      var transcharg = parseFloat($('#transportation_charge').val()) || 0;
      var customcharg = parseFloat($('#customs_charge').val()) || 0;
      var othercharg = parseFloat($('#other_charge').val()) || 0;

      // ✅ Total before VAT
      var totalBeforeVAT = afterDiscount + transcharg + customcharg + othercharg;
      $('#total_beforvat').val(totalBeforeVAT.toFixed(2));

      // --- VAT ---
      var vatPer = parseFloat($('#vat_per').val()) || 0;
      var vatAmt = (totalBeforeVAT * vatPer) / 100;
      $('#vat_amount').val(vatAmt.toFixed(2));

      // --- Grand Total ---
      var grandTotal = totalBeforeVAT + vatAmt;
      $('#grand_total').val(grandTotal.toFixed(2));

      // --- Base Currency Grand Total ---
      var conversionRate = parseFloat($('#conversion_rate').val()) || 1;
      var baseCurrencyGrandTotal = grandTotal * conversionRate;
      $('#base_currency_grand_total').val(baseCurrencyGrandTotal.toFixed(2));
    }
  });
  $(document).ready(function() {
    $('#main').on('submit', function(e) {
      let valid = true;
      let errorMsg = '';

      // --- Validate Main Fields ---
      if ($('#quotation_id').val() === '') {
        valid = false;
        errorMsg += 'Please select a Quotation.\n';
      }
      if ($('#po_code').val().trim() === '') {
        valid = false;
        errorMsg += 'PO Code is required.\n';
      }
      if ($('#po_date').val() === '') {
        valid = false;
        errorMsg += 'PO Date is required.\n';
      }
      if ($('#Branch_id').val() === '') {
        valid = false;
        errorMsg += 'Branch is required.\n';
      }
      if ($('#supplier_id').val() === '') {
        valid = false;
        errorMsg += 'Supplier is required.\n';
      }
      if ($('#ref_no').val().trim() === '') {
        valid = false;
        errorMsg += 'Reference is required.\n';
      }
      if ($('#project').val().trim() === '') {
        valid = false;
        errorMsg += 'Project Name is required.\n';
      }

      // --- Quotation Items Validation ---
      const $rows = $('#quote_items_list table tbody tr');
      if ($rows.length === 0) {
        valid = false;
        errorMsg += 'Please add at least one quotation item.\n';
      } else {
        $rows.each(function(index, row) {
          const $row = $(row);
          const item = $row.find('select.item_select').val();
          const qty = parseFloat($row.find('input.qty').val()) || 0;
          const unitPrice = parseFloat($row.find('input.unit_price').val()) || 0;


          if (qty <= 0) {
            valid = false;
            errorMsg += `Row ${index + 1}: Quantity must be greater than 0.\n`;
          }
          if (unitPrice <= 0) {
            valid = false;
            errorMsg += `Row ${index + 1}: Price must be greater than 0.\n`;
          }
        });
      }

      // --- Stop submission if invalid ---
      if (!valid) {
        e.preventDefault();
        alert(errorMsg);
        return false;
      }
    });
  });
</script>