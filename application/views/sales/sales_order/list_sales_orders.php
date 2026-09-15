<?php
$page_name = $this->uri->segment(1) . '/' . $this->uri->segment(2);
$user = $this->session->userdata('user_id');
?>
<style>
  body {
    font-family: "Franklin Gothic Book", "Franklin Gothic Medium", Arial, sans-serif;
    font-size: 13px;
  }
</style>
<div class="x_panel">
  <div class="x_title">

    <ul class="nav navbar-right panel_toolbox">
      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
          <i class="fa fa-wrench"></i>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#">Export Excel</a></li>
          <li><a href="#">Export PDF</a></li>
        </ul>
      </li>
      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
    </ul>
    <div class="clearfix"></div>
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><i class="fa fa-check-circle"></i></strong>
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fa fa-exclamation-circle"></i></strong>
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php endif; ?>

  </div>

  <div class="x_content">
    <div class="row">
      <div class="col-sm-12">
        <div class="card-box table-responsive">
          <table id="datatable" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Order Code</th>
                <th>Quotation Code</th>
                <th>Enquiry Code</th>
                <th>Grand Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($active_sales_orders as $sales_order) { ?>
                <tr>
                  <th scope="row"><?= $i; ?></th>
                  <td>
                    <a href="<?= base_url('index.php/Sales/view_sales_order/' . $sales_order['so_id']); ?>" title="view">
                      <?= $sales_order['so_code'] ?><br>
                      <?= date('d-M-Y', strtotime($sales_order['so_date'])) ?>
                    </a>
                  </td>
                  <td>
                    <a href="<?= base_url('index.php/Sales/view_quotation/' . $sales_order['qtn_id']); ?>" title="view">
                      <?= $sales_order['quotation_code'] ?>
                    </a>
                  </td>
                  <td>
                    <a href="<?= base_url('index.php/Sales/view_enquiry/' . $sales_order['enquiry_id']); ?>" title="view">
                      <?= $sales_order['enquiry_code'] ?></a>

                  </td>

                  <!-- Grand Total -->
                  <td>
                    <?= number_format((float)$sales_order['grand_total'], 2) ?>
                  </td>
                  <td>
                    <?php if (has_access($user, $page_name, 'E')) { ?>
            
                      <?php } ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <?php if (has_view_access($user, $page_name)) { ?>
                        <!-- <a target='_blank' href='<?php echo base_url() . 'index.php/Sales/print_sales_order/' . $sales_order['so_id'] . '/' . $sales_order['enquiry_id']; ?>' title='print'><span class="glyphicon glyphicon-print" aria-hidden="true"></span></span></a> -->
                      <?php } ?>
                      <div class="btn-group">
                        <button type="button" class="btn btn-success">Print</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="<?php echo base_url() . 'index.php/Sales/print_sales_order/' . $sales_order['so_id'] . '/' . $sales_order['enquiry_id']; ?>" data-action="sales_return" data-invoice-id="#">sales order</a>
                          <a class="dropdown-item" href="<?php echo base_url() . 'index.php/Document_controller/print_proforma_invoice/' . $sales_order['so_id'] . '/' . $sales_order['enquiry_id']; ?>" data-action="cancel" data-invoice-id="#">Proforma invoice</a>
                        </div>
                      </div>
                  </td>
                </tr>

              <?php $i++;
              } ?>
            </tbody>

          </table>

        </div>
      </div>
    </div>
  </div>
</div>