<!-- page content -->
<div class="form-group" role="main">
  <div class="">
    <div class="page-title"></div>
    <div class="clearfix"></div>

    <div class="x_content">

      <div class="col-md-12">

        <div class="dt-responsive table-responsive">

          <table class="table table-bordered table-hover" id="tab_logic">

            <thead>
              <tr>
                <th>Sl. No</th>
                <th>Adjustment No</th>
                <th>Item Details</th>
                <th>Warehouse</th>
                <th>Stock Date</th>
                <th>Stock Type</th>
                <th>Remark</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Approved By</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody id="mytbbody">

              <?php
              $i = 1;

              if (!empty($records)):

                foreach ($records as $row):
              ?>

                  <tr>

                    <!-- Sl No -->
                    <td>
                      <?php echo $i++; ?>
                    </td>

                    <!-- Adjustment Number -->
                    <td>
                      <strong>
                        <?php echo htmlspecialchars($row->stock_code); ?>
                      </strong>
                    </td>

                    <!-- Product -->
                    <td>
                      <?php
                      echo htmlspecialchars($row->product_code);
                      ?>
                      <br>

                      <small>
                        <?php
                        echo htmlspecialchars($row->product_name);
                        ?>
                      </small>
                    </td>

                    <!-- Warehouse -->
                    <td>
                      <?php
                      echo !empty($row->warehouse_name)
                        ? htmlspecialchars($row->warehouse_name)
                        : '-';
                      ?>
                    </td>

                    <!-- Stock Date -->
                    <td>
                      <?php
                      echo !empty($row->stock_date)
                        ? date('d-M-Y', strtotime($row->stock_date))
                        : '-';
                      ?>
                    </td>

                    <!-- Stock Type -->
                    <td>

                      <?php if ($row->stock_type == 'IN'): ?>

                        <span class="badge badge-success">
                          Stock Inward
                        </span>

                      <?php elseif ($row->stock_type == 'OUT'): ?>

                        <span class="badge badge-danger">
                          Stock Outward
                        </span>

                      <?php elseif ($row->stock_type == 'Opening'): ?>

                        <span class="badge badge-info">
                          Opening Stock
                        </span>

                      <?php else: ?>

                        <span class="badge badge-secondary">
                          <?php echo htmlspecialchars($row->stock_type); ?>
                        </span>

                      <?php endif; ?>

                    </td>

                    <!-- Remark -->
                    <td>
                      <?php
                      echo !empty($row->remark)
                        ? htmlspecialchars($row->remark)
                        : '-';
                      ?>
                    </td>

                    <!-- Status -->
                    <td>

                      <?php if ((int)$row->status === 0): ?>

                        <span class="badge badge-warning">
                          Pending Approval
                        </span>

                      <?php elseif ((int)$row->status === 1): ?>

                        <span class="badge badge-success">
                          Approved
                        </span>

                      <?php else: ?>

                        <span class="badge badge-secondary">
                          Unknown
                        </span>

                      <?php endif; ?>

                    </td>

                    <!-- Created By -->
                    <td>
                      <?php
                      echo !empty($row->created_user)
                        ? htmlspecialchars($row->created_user)
                        : '-';
                      ?>
                    </td>

                    <!-- Approved By -->
                    <td>
                      <?php
                      echo !empty($row->approved_user)
                        ? htmlspecialchars($row->approved_user)
                        : '-';
                      ?>
                    </td>

                    <!-- Actions -->
                    <td style="white-space: nowrap;">

                      <?php if ((int)$row->status === 0): ?>

                        <!-- Edit -->
                        <a href="<?php echo base_url(); ?>index.php/Stock/edit_stock_adjustment/<?php echo $row->sno; ?>"
                          title="Edit Stock Adjustment"
                          class="btn btn-sm btn-primary"
                          style="margin-right: 5px;">

                          <i class="glyphicon glyphicon-pencil"></i>
                        </a>

                        <!-- Approve -->
                        <a href="<?php echo base_url(); ?>index.php/Stock/approve_stock_adjustment/<?php echo $row->sno; ?>"
                          title="Approve Stock Adjustment"
                          class="btn btn-sm btn-success"
                          onclick="return confirm('Are you sure you want to approve this Stock Adjustment?');">

                          <i class="glyphicon glyphicon-ok"></i>
                        </a>

                      <?php elseif ((int)$row->status === 1): ?>

                        <!-- Approved -->
                        <span class="text-success"
                          title="Stock Adjustment Approved">

                          <i class="glyphicon glyphicon-ok-circle"></i>
                          Approved

                        </span>

                      <?php endif; ?>

                    </td>

                  </tr>

                <?php
                endforeach;

              else:
                ?>

                <tr>
                  <td colspan="11" class="text-center">
                    No Stock Adjustment records found.
                  </td>
                </tr>

              <?php endif; ?>

            </tbody>

          </table>

        </div>

      </div>

    </div>

  </div>
</div>

<!-- /page content -->