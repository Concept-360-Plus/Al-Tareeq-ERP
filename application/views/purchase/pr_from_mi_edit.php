<!-- page content -->
<form id="main" method="post" action="<?= base_url('index.php/Purchase/update_pr_from_mi/' . $pr->pr_id) ?>" autocomplete="off" enctype="multipart/form-data">
    <div class="form-group" role="main">
        <div class="page-title"></div>
        <div class="clearfix"></div>

        <div class="x_content">
            <div class="well" style="overflow: auto">

                <!-- Branch -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">Select Branch</label>
                    <div class="col-md-9">
                        <select name="branch_id" id="branch_id" class="form-control select2" disabled>
                            <option value="">Please select branch</option>
                            <?php foreach ($branch_records as $b) { ?>
                                <option value="<?= $b->branch_id ?>" <?= ($b->branch_id == $pr->branch_id) ? 'selected' : '' ?>><?= $b->branch_name ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="branch_id" value="<?= $pr->branch_id ?>">
                    </div>
                </div>

                <!-- PR Code -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">PR Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="pr_code" readonly value="<?= $pr->pr_code ?>">
                    </div>
                </div>

                <br><br><br>

                <!-- PR Date -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">PR Date</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control" name="pr_date" value="<?= $pr->pr_date ?>" required>
                    </div>
                </div>

                <!-- Material Issue -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">Select Material Issue</label>
                    <div class="col-md-9">
                        <select name="mi_id" id="mi_id" class="form-control select2" disabled>
                            <option value="">-- Select MI --</option>
                            <?php foreach ($material_issues as $mi) { ?>
                                <option value="<?= $mi->mi_id ?>" <?= ($mi->mi_id == $pr->mi_id) ? 'selected' : '' ?>><?= $mi->mi_code ?></option>
                            <?php } ?>
                        </select>
                        <input type="hidden" name="mi_id" value="<?= $pr->mi_id ?>">
                    </div>
                </div>

                <!-- Supplier -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">Select Supplier</label>
                    <div class="col-md-9">
                        <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                            <option value="">Please select supplier</option>
                            <?php foreach ($supplier_records as $s) { ?>
                                <option value="<?= $s->supplier_id ?>" <?= ($s->supplier_id == $pr->supplier_id) ? 'selected' : '' ?>><?= $s->supplier_name . ' (' . $s->supplier_code . ')' ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <br><br><br>

                <!-- Subject -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">Subject</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="subject" value="<?= $pr->subject ?? '' ?>">
                    </div>
                </div>
                <br><br><br>

                <!-- Project Name -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">Project Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" readonly name="project" value="<?= $pr->project ?? '' ?>">
                    </div>
                </div>

                <!-- Reference -->
                <div class="col-md-6">
                    <label class="control-label col-md-3">Reference</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="ref" value="<?= $pr->ref ?? '' ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="row col-md-12" style="overflow-x:auto; margin-top:20px;">
            <div class="x_content">
                <table id="pr_items_table" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pr_items_body">
                        <?php if (!empty($pr_items)) {
                            foreach ($pr_items as $item) { ?>
                                <tr>
                                    <td>
                                        <!-- use product_id instead of id -->
                                        <input type="hidden" name="item_id[]" value="<?= $item->product_id ?>">
                                        <?= $item->item_name ?? '' ?>
                                    </td>
                                    <td><?= $item->item_description ?? '' ?></td>
                                    <td>
                                        <select name="unit[]" class="form-control" required>
                                            <?php foreach ($active_units as $u) { ?>
                                                <option value="<?= $u->unit_id ?>" <?= ($u->unit_id == $item->unit_id) ? 'selected' : '' ?>><?= $u->unit_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="quantity[]" value="<?= $item->quantity ?>" min="0" class="form-control" required>
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-success addRow">
                                            <i class="fa fa-plus"></i>
                                        </button>

                                        <button type="button"
                                            class="btn btn-danger deleteRow">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Remarks -->
        <div class="x_content well" style="margin-top:20px;">
            <div class="row col-md-12">
                <label class="control-label col-md-2">Remarks</label>
                <div class="col-md-10">
                    <textarea class="form-control" name="remarks"><?= $pr->remarks ?? '' ?></textarea>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="row col-md-12" style="margin-top:20px;">
                <button type="submit" class="btn btn-success">Update PR</button>
            </div>
        </div>
    </div>
</form>


<script>
    $(document).ready(function() {
        ///////// INITIALIZE SELECT2/////////
        $('.select2').select2({
            width: '100%',
            placeholder: 'Select an option',
            allowClear: true
        });

        ///////// DELETE ROW /////////
        $(document).on('click', '.deleteRow', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        ///////// ADD NEW PRODUCT ROW /////////
        let rowIndex = 1000;
        $(document).on('click', '.addRow', function(e) {
            e.preventDefault();
            let newRow = `
            <tr>
                <!-- Product -->
                <td>
                    <select class="form-control product-select" name="item_id[]" id="product_${rowIndex}" required>
                        <option value="">Select Product</option>
                        <?php foreach ($active_items as $item) { ?>
                            <option value="<?= $item->product_id ?>">
                                <?= htmlspecialchars($item->product_name, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>

                <!-- Description -->
                <td>
                    <input type="text" class="form-control" name="description[]" placeholder="Description">
                </td>

                <!-- Unit -->
                <td>
                    <select class="form-control" name="unit[]" required>
                        <option value="">Select Unit</option>
                        <?php foreach ($active_units as $unit) { ?>
                            <option value="<?= $unit->unit_id ?>">
                                <?= htmlspecialchars($unit->unit_name, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>

                <!-- Quantity -->
                <td>
                    <input type="number" class="form-control" name="quantity[]" value="1" min="0" step="0.01" required>
                </td>

                <!-- Actions -->
                <td>
                    <button type="button" class="btn btn-success addRow">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-danger deleteRow">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
        `;

            $('#pr_items_body').append(newRow);

            // Initialize Select2 for the newly added product
            $('#product_' + rowIndex).select2({
                width: '100%',
                placeholder: 'Select Product',
                allowClear: true
            });
            rowIndex++;
        });

        ////// QUANTITY VALIDATION ////// 
        $(document).on('input', 'input[name="quantity[]"]', function() {
            const val = $(this).val();
            if (val <= 0) {
                $(this).css('border', '1px solid red');
            } else {
                $(this).css('border', '');
            }
        });
    });
</script>