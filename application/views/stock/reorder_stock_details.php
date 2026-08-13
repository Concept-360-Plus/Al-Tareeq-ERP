<!-- page content -->
<div class="form-group" role="main">
  <div class="">
    <div class="page-title"></div>
    <div class="clearfix"></div>
    <div class="x_content">
      <div class="well" style="overflow: auto">
        <div class="col-md-12">


          <div class="dt-responsive table-responsive">
            <table id="basic-btn" class="table table-striped table-bordered nowrap">
              <thead>
                <tr>
                  <th>
                    <input type="checkbox" id="selectall">
                  </th>
                  <th>Srn</th>
                  <th>Stock Code</th>
                  <th>Description</th>
                  <th>Inventory Qty</th>
                  <th>Pending PO Qty</th>
                  <th>Total Stock</th>
                  <th>Min Qty</th>
                  <th>Reorder Qty</th>
                </tr>
              </thead>

              <tbody>

                <?php $i = 1; ?>

                <?php foreach ($records as $row) : ?>

                  <tr>

                    <td>
                      <input
                        type="checkbox"
                        class="case"
                        name="select_checkbox[]"
                        value="<?php echo $row->item_id; ?>"
                        onclick="p_check();">
                    </td>

                    <td>
                      <?php echo $i++; ?>
                    </td>

                    <td>
                      <?php echo $row->item_code; ?>
                    </td>

                    <td>
                      <?php echo $row->item_description; ?>
                    </td>

                    <td>
                      <?php echo number_format($row->invstock, 2); ?>
                    </td>

                    <td>
                      <?php echo number_format($row->postock, 2); ?>
                    </td>

                    <td>
                      <?php echo number_format($row->total_stock, 2); ?>
                    </td>

                    <td>
                      <?php echo number_format($row->min_stock_qty, 2); ?>
                    </td>

                    <td>
                      <strong>
                        <?php echo number_format($row->reorder_qty, 2); ?>
                      </strong>
                    </td>

                  </tr>

                <?php endforeach; ?>

              </tbody>
            </table>
          </div>




        </div>
        <form
          id="reorder_po_form"
          method="post"
          action="<?php echo base_url('index.php/Purchase/add_PO_direct_from_reorder'); ?>">

          <input
            type="hidden"
            name="selected_tr"
            id="selected_tr"
            value="">

          <button
            type="submit"
            disabled
            id="convert_excel"
            class="btn btn-primary">
            <i class="fa fa-shopping-cart"></i>
            Create PO Stock
          </button>

        </form>
      </div>
    </div>
  </div>

</div>
</div>


<script>
  function p_check() {

    var checked = $('.case:checked').length;

    if (checked > 0) {
      $('#convert_excel').prop('disabled', false);
    } else {
      $('#convert_excel').prop('disabled', true);
    }

    var allVals = [];

    $('.case:checked').each(function() {
      allVals.push($(this).val());
    });

    $('#selected_tr').val(allVals.join(','));
  }


  $(document).ready(function() {

    $('#selectall').on('change', function() {

      $('.case').prop('checked', this.checked);

      p_check();

    });

  });
</script>