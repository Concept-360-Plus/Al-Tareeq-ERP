<!-- page content -->

<form id="main"
    method="post"
    action="<?php echo base_url() . 'index.php/Stock/update_min_stock_records'; ?>"
    autocomplete="off">

    <div class="form-group" role="main">
        <div>
            <div class="page-title"></div>
            <div class="clearfix"></div>

            <div class="x_content">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade in"
                        role="alert">
                        <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <strong>
                            <i class="fa fa-check-circle"></i>
                        </strong>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade in"
                        role="alert">
                        <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>
                            <i class="fa fa-exclamation-triangle"></i>
                        </strong>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($record)): ?>
                    <div class="well" style="overflow: auto">
                        <div class="col-md-12">
                            <!-- Hidden Product ID -->
                            <input type="hidden"
                                name="item"
                                id="item"
                                value="<?php echo $record->item_id; ?>">

                            <!-- Product -->
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">
                                Select Item
                            </label>

                            <div class="col-md-4 col-sm-9 col-xs-9">
                                <input type="text"
                                    class="form-control"
                                    value="<?php echo htmlspecialchars($record->product_name); ?>"
                                    readonly>
                            </div>
                        </div>

                        <br>
                        <br>
                        <br>

                        <div class="col-md-12">
                            <!-- Minimum Stock -->
                            <label class="control-label col-md-2 col-sm-3 col-xs-3">
                                Minimum Stock Qty
                            </label>

                            <div class="col-md-4 col-sm-9 col-xs-9">
                                <input type="number"
                                    name="min_stock_qty"
                                    id="min_stock_qty"
                                    class="form-control form-control-sm"
                                    value="<?php echo htmlspecialchars($record->min_stock_qty); ?>">
                            </div>
                        </div>

                        <br>
                        <br>
                        <br>

                        <div class="col-md-12">
                            <button type="submit"
                                class="btn btn-success">
                                <i class="fa fa-save"></i>
                                Update
                            </button>

                            <a href="<?php echo base_url() . 'index.php/Stock/list_min_stock'; ?>"
                                class="btn btn-default">
                                <i class="fa fa-arrow-left"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        Minimum stock record not found.
                    </div>

                    <a href="<?php echo base_url() . 'index.php/Stock/list_min_stock'; ?>"
                        class="btn btn-default">
                        Back to List
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("#main").attr("novalidate", true);
        $("#main").on("submit", function(e) {
            let isValid = true;
            let errorMsg = "";
            const minStockQty = $("#min_stock_qty").val().trim();

            if (minStockQty === "") {
                errorMsg += "• Please enter the minimum stock quantity.\n";
                isValid = false;
            } else if (
                isNaN(minStockQty) ||
                parseFloat(minStockQty) <= 0
            ) {
                errorMsg +=
                    "• Minimum stock quantity must be a valid positive number.\n";
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                alert(
                    "Please correct the following errors:\n\n" +
                    errorMsg
                );
            }
        });

        $("#min_stock_qty").on("input", function() {
            this.value = this.value.replace(/[^0-9.]/g, "");
        });
    });
</script>