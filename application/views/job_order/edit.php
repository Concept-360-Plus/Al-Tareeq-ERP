<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">

            <div class="x_panel">

               

                <div class="x_content">

                    <form id="jobOrderEditForm">

                        <!-- Hidden Job Order ID -->
                        <input type="hidden"
                               name="job_order_id"
                               id="job_order_id"
                               value="<?= (int)$job_order->job_order_id ?>">

                        <!-- ===================================================== -->
                        <!-- JOB ORDER HEADER -->
                        <!-- ===================================================== -->

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <strong>Job Order Information</strong>
                            </div>

                            <div class="panel-body">

                                <div class="row">

                                    <!-- Job Order No -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Job Order No</label>

                                            <input type="text"
                                                   class="form-control"
                                                   value="<?= htmlspecialchars($job_order->job_order_no) ?>"
                                                   readonly>

                                        </div>
                                    </div>

                                    <!-- Order No -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Order No</label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="order_no"
                                                   id="order_no"
                                                   value="<?= htmlspecialchars($job_order->order_no) ?>">

                                        </div>
                                    </div>

                                    <!-- Order Date -->
                                    <div class="col-md-4">
                                        <div class="form-group">

                                            <label>Order Date</label>

                                            <input type="date"
                                                   class="form-control"
                                                   name="order_date"
                                                   id="order_date"
                                                   value="<?= !empty($job_order->created_at) ? date('Y-m-d',  strtotime($job_order->created_at))  : '' ?>"
                                                   readonly>

                                        </div>
                                    </div>

                                </div>

                                <?php if (isset($job_order->job_order_type) && (int)$job_order->job_order_type === 0) : ?>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label>Sales Order</label>

                                                <input type="text"
                                                    class="form-control"
                                                    value="<?= !empty($sales_order->so_code)
                                                        ? htmlspecialchars($sales_order->so_code)
                                                        : '' ?>"
                                                    readonly>

                                                <input type="hidden"
                                                    name="sales_order_id"
                                                    value="<?= !empty($job_order->fk_sales_order_id)
                                                        ? (int)$job_order->fk_sales_order_id
                                                        : '' ?>">

                                            </div>

                                        </div>

                                    </div>

                                <?php endif; ?>
                                <!-- ================================================= -->
                                <!-- PROJECT INFORMATION -->
                                <!-- ================================================= -->

                               <?php if (isset($job_order->job_order_type) && (int)$job_order->job_order_type === 1
                                    && !empty($job_order->fk_project_id)
                                ) : ?>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="alert alert-info">

                                                <strong>Project Job Order</strong>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <!-- Project -->
                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label>Project</label>

                                                <?php
                                                if (is_array($project) && isset($project[0])) {
                                                    $projectData = $project[0];
                                                } elseif (is_object($project)) {
                                                    $projectData = $project;
                                                } else {
                                                    $projectData = array();
                                                }
                                                ?>

                                                <input type="text"
                                                       class="form-control"
                                                       value="<?= isset($projectData->project_name)
                                                           ? htmlspecialchars($projectData->project_name)
                                                           : (isset($projectData['project_name'])
                                                               ? htmlspecialchars($projectData['project_name'])
                                                               : '') ?>"
                                                       readonly>

                                                <input type="hidden"
                                                       name="fk_project_id"
                                                       value="<?= (int)$job_order->fk_project_id ?>">

                                            </div>

                                        </div>


                                        <!-- Project Code -->
                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label>Project Code</label>

                                                <input type="text"
                                                       class="form-control"
                                                       value="<?= isset($projectData->project_code)
                                                           ? htmlspecialchars($projectData->project_code)
                                                           : (isset($projectData['project_code'])
                                                               ? htmlspecialchars($projectData['project_code'])
                                                               : '') ?>"
                                                       readonly>

                                            </div>

                                        </div>


                                        <!-- Customer -->
                                        <div class="col-md-4">

                                            <div class="form-group">

                                                <label>Customer</label>

                                                <input type="text"
                                                       class="form-control"
                                                       value="<?= isset($projectData->customer_name)
                                                           ? htmlspecialchars($projectData->customer_name)
                                                           : (isset($projectData['customer_name'])
                                                               ? htmlspecialchars($projectData['customer_name'])
                                                               : '') ?>"
                                                       readonly>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- ================================================= -->
                                    <!-- SALES ORDERS -->
                                    <!-- ================================================= -->

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="form-group">

                                                <label>
                                                    Sales Orders
                                                </label>

                                                <div class="well"
                                                     style="max-height:180px; overflow-y:auto; margin-bottom:10px;">

                                                    <?php if (!empty($sales_orders)) : ?>

                                                        <?php foreach ($sales_orders as $so) : ?>

                                                            <div class="checkbox">

                                                                <label>
                                                                    <?php
                                                                        $selected = false;

                                                                        if (!empty($job_order_sales_orders)) {
                                                                            $selected = in_array(
                                                                                (int)$so->so_id,
                                                                                array_map('intval', $job_order_sales_orders),
                                                                                true
                                                                            );
                                                                        }
                                                                        ?>
                                                                    <input type="checkbox"
                                                                           class="sales-order-checkbox"
                                                                           name="sales_order_ids[]"
                                                                           value="<?= (int)$so->so_id ?>"
                                                                           <?= $selected ? 'checked' : '' ?>>

                                                                    <?= htmlspecialchars($so->so_code) ?>

                                                                    <?php if (!empty($so->order_date)) : ?>

                                                                        <small class="text-muted">
                                                                            (<?= htmlspecialchars($so->order_date) ?>)
                                                                        </small>

                                                                    <?php endif; ?>

                                                                </label>

                                                            </div>

                                                        <?php endforeach; ?>

                                                    <?php else : ?>

                                                        <span class="text-muted">
                                                            No Sales Orders found.
                                                        </span>

                                                    <?php endif; ?>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                <?php endif; ?>


                                <!-- ================================================= -->
                                <!-- CONTACT / REPRESENTATIVE -->
                                <!-- ================================================= -->

                                <div class="row">

                                    <!-- Contact Person -->
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Contact Person
                                            </label>

                                            <select class="form-control"
                                                    id="contact_person"
                                                    name="contact_person">

                                                <option value="">
                                                    Select Contact Person
                                                </option>

                                                <?php if (!empty($user_records)) : ?>

                                                    <?php foreach ($user_records as $s) : ?>

                                                        <option value="<?= (int)$s['user_id'] ?>"
                                                            <?= (
                                                                isset($job_order->contact_person)
                                                                && $job_order->contact_person == $s['user_id']
                                                            )
                                                                ? 'selected'
                                                                : '' ?>>

                                                            <?= htmlspecialchars($s['user_name']) ?>

                                                        </option>

                                                    <?php endforeach; ?>

                                                <?php endif; ?>

                                            </select>

                                        </div>

                                    </div>


                                    <!-- Representative -->
                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Representative
                                            </label>

                                            <select class="form-control"
                                                    id="rep_name"
                                                    name="rep_name">

                                                <option value="">
                                                    Select Representative
                                                </option>

                                                <?php if (!empty($user_records)) : ?>

                                                    <?php foreach ($user_records as $s) : ?>

                                                        <option value="<?= (int)$s['user_id'] ?>"
                                                            <?= (
                                                                isset($job_order->rep_name)
                                                                && $job_order->rep_name == $s['user_id']
                                                            )
                                                                ? 'selected'
                                                                : '' ?>>

                                                            <?= htmlspecialchars($s['user_name']) ?>

                                                        </option>

                                                    <?php endforeach; ?>

                                                <?php endif; ?>

                                            </select>

                                        </div>

                                    </div>

                                </div>


                                <!-- ================================================= -->
                                <!-- DATES -->
                                <!-- ================================================= -->

                                <div class="row">

                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Start Date
                                            </label>

                                            <input type="date"
                                                   class="form-control"
                                                   name="start_date"
                                                   id="start_date"
                                                   value="<?= !empty($job_order->start_date) ? date('Y-m-d',  strtotime($job_order->start_date))  : '' ?>">

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Finish Date
                                            </label>

                                            <input type="date"
                                                   class="form-control"
                                                   name="finish_date"
                                                   id="finish_date"
                                                   value="<?= !empty($job_order->finish_date) ? date('Y-m-d',  strtotime($job_order->finish_date))  : '' ?>">

                                        </div>

                                    </div>


                                    <div class="col-md-4">

                                        <div class="form-group">

                                            <label>
                                                Status
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   value="<?= htmlspecialchars(
                                                       isset($job_order->status)
                                                           ? $job_order->status
                                                           : ''
                                                   ) ?>"
                                                   readonly>

                                        </div>

                                    </div>

                                </div>


                                <!-- ================================================= -->
                                <!-- REMARKS -->
                                <!-- ================================================= -->

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group">

                                            <label>
                                                Remarks
                                            </label>

                                            <textarea class="form-control"
                                                      name="remarks"
                                                      id="remarks"
                                                      rows="3"><?= htmlspecialchars($job_order->remarks) ?></textarea>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================================= -->
                        <!-- JOB ORDER ITEMS -->
                        <!-- ========================================================= -->

                        <div class="panel panel-default">

                            <div class="panel-heading">

                                <strong>
                                    Job Order Items
                                </strong>

                            </div>

                            <div class="panel-body">

                                <div class="table-responsive">

                                    <table id="jobOrderItemsTable"
                                           class="table table-bordered table-striped">

                                        <thead>

                                            <tr>

                                                <th width="30">
                                                    #
                                                </th>
                                                <th>SO Code</th>
                                                <th>
                                                    Item Name
                                                </th>

                                                <th width="70">
                                                    Quantity
                                                </th>

                                                <th width="70">
                                                    Unit
                                                </th>

                                                <th>
                                                    Cost
                                                </th>

                                                <th width="130">
                                                    Materials
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php  if (!empty($job_order_items)) : ?>

                                                <?php $sl = 1; ?>

                                                <?php foreach ($job_order_items as $item) : ?>

                                                   <tr data-so-id="<?= (int)$item->so_id ?>" data-project-item-id="<?= (int)$item->project_item_id ?>">
                                                        <td>
                                                            <?= $sl++ ?>
                                                        </td>
                                                        <td>
                                                            
                                                            <?= htmlspecialchars(
                                                                isset($item->sales_order_code)
                                                                    ? $item->sales_order_code
                                                                    : ''
                                                            ) ?>

                                                        </td>
                                                        <!-- Item Description -->
                                                        <td>

                                                            <?= htmlspecialchars(
                                                                isset($item->product_name)
                                                                    ? $item->product_name
                                                                    : (
                                                                        isset($item->item_description)
                                                                            ? $item->item_description
                                                                            : ''
                                                                    )
                                                            ) ?>  - <?= htmlspecialchars(
                                                                isset($item->item_code)
                                                                    ? $item->item_code
                                                                    : ''
                                                            ) ?>

                                                        </td>


                                                        <!-- Quantity -->
                                                        <td>

                                                            <?= number_format(
                                                                (float)$item->quantity,
                                                                2
                                                            ) ?>

                                                        </td>


                                                        <!-- Unit -->
                                                        <td>
                                                            
                                                            <?= htmlspecialchars(
                                                                isset($item->unit)
                                                                    ? $item->unit
                                                                    : ''
                                                            ) ?>

                                                        </td>


                                                        <!-- Cost -->
                                                        <td>

                                                            <?= number_format(
                                                                (float)$item->cost,
                                                                2
                                                            ) ?>

                                                        </td>


                                                        <!-- Materials -->
                                                        <td class="text-center">

                                                            <button type="button"
                                                                    class="btn btn-xs btn-info material-btn"
                                                                    data-job-order-item-id="<?= (int)$item->job_order_item_id ?>"
                                                                    data-project-item-id="<?= (int)$item->project_item_id ?>"
                                                                    data-item-master="<?= (int)$item->item_master_id ?>"
                                                                    data-item-name="<?= htmlspecialchars(
                                                                        isset($item->product_name)
                                                                            ? $item->product_name
                                                                            : $item->item_description,
                                                                        ENT_QUOTES
                                                                    ) ?>">

                                                                <i class="fa fa-cubes"></i>
                                                                Materials

                                                            </button>

                                                        </td>

                                                    </tr>

                                                <?php endforeach; ?>

                                            <?php else : ?>

                                                <tr>

                                                    <td colspan="7" class="text-center">

                                                        No items found.

                                                    </td>

                                                </tr>

                                            <?php endif; ?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>


                        <!-- ========================================================= -->
                        <!-- FORM BUTTONS -->
                        <!-- ========================================================= -->

                        <div class="row">

                            <div class="col-md-12 text-right">

                                <a href="<?= base_url('index.php/Production/job_order') ?>"
                                   class="btn btn-default">

                                    Cancel

                                </a>

                                <button type="submit"
                                        class="btn btn-success">

                                    <i class="fa fa-save"></i>
                                    Update Job Order

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>


<!-- ================================================================ -->
<!-- MATERIAL MODAL -->
<!-- ================================================================ -->

<div class="modal fade"
     id="materialsModal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    <strong>
                        Item Materials
                    </strong>

                </h4>
                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <div class="modal-body">

                <!-- Hidden IDs -->
                <input type="hidden"
                       id="currentJobOrderItemId">

                <input type="hidden"
                       id="currentProjectItemId">

                <input type="hidden"
                       id="currentItemMasterId">


                <!-- Item name -->
                <div class="row">

                    <div class="col-md-12">

                        <div class="alert alert-info">

                            <strong>Item:</strong>

                            <span id="currentItemName"></span>

                        </div>

                    </div>

                </div>


                <!-- Material table -->
                <div class="table-responsive">

                    <table class="table table-bordered table-striped"
                           id="itemMaterialsTable">

                        <thead>

                            <tr>

                                <th width="40">
                                    #
                                </th>

                                <th>
                                    Material Code
                                </th>

                                <th>
                                    Material Name
                                </th>

                                <th width="120">
                                    Quantity
                                </th>

                                <th width="100">
                                    Unit
                                </th>

                                <th width="100">
                                    Cost
                                </th>

                                <th width="100">
                                    Source
                                </th>

                                <th width="70">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody id="itemMaterialsBody">

                        </tbody>

                    </table>

                </div>


                <!-- Add Raw Material -->
                <div class="row">

                    <div class="col-md-12">

                        <button type="button"
                                class="btn btn-warning"
                                id="addRawMaterialBtn">

                            <i class="fa fa-plus"></i>
                            Add Raw Material

                        </button>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">

                    Close

                </button>

                <button type="button"
                        class="btn btn-success"
                        id="saveMaterialsBtn">

                    <i class="fa fa-save"></i>
                    Save Materials

                </button>

            </div>

        </div>

    </div>

</div>


<!-- ================================================================ -->
<!-- ADD RAW MATERIAL MODAL -->
<!-- ================================================================ -->

<div class="modal fade"
     id="rawMaterialModal"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">

                    Add Raw Material

                </h4>
                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <div class="modal-body">

                <div class="form-group">

                    <label>
                        Raw Material
                        <span class="text-danger">*</span>
                    </label>

                    <select class="form-control"
                            id="raw_material_id">

                        <option value="">
                            Select Raw Material
                        </option>

                        <?php if (!empty($raw_materials)) : ?>

                            <?php foreach ($raw_materials as $material) : ?>

                                <?php
                                $materialId = isset($material->material_id)
                                    ? $material->material_id
                                    : (
                                        isset($material->id)
                                            ? $material->id
                                            : ''
                                    );

                                $materialCode = isset($material->material_code)
                                    ? $material->material_code
                                    : '';

                                $materialName = isset($material->material_name)
                                    ? $material->material_name
                                    : (
                                        isset($material->name)
                                            ? $material->name
                                            : ''
                                    );
                                ?>

                                <option value="<?= htmlspecialchars($materialId) ?>"
                                        data-code="<?= htmlspecialchars($materialCode) ?>"
                                        data-name="<?= htmlspecialchars($materialName) ?>">

                                    <?= htmlspecialchars($materialCode) ?>
                                    -
                                    <?= htmlspecialchars($materialName) ?>

                                </option>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Unit
                        <span class="text-danger">*</span>
                    </label>

                    <select class="form-control"
                            id="raw_material_unit">

                        <option value="">
                            Select Unit
                        </option>

                        <?php if (!empty($units)) : ?>

                            <?php foreach ($units as $unit) : ?>

                                <?php
                                $unitId = isset($unit->unit_id)
                                    ? $unit->unit_id
                                    : (
                                        isset($unit->id)
                                            ? $unit->id
                                            : ''
                                    );

                                $unitName = isset($unit->unit)
                                    ? $unit->unit
                                    : (
                                        isset($unit->unit_name)
                                            ? $unit->unit_name
                                            : (
                                                isset($unit->name)
                                                    ? $unit->name
                                                    : ''
                                            )
                                    );
                                ?>

                                <option value="<?= htmlspecialchars($unitId) ?>">

                                    <?= htmlspecialchars($unitName) ?>

                                </option>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Quantity Required
                        <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           class="form-control"
                           id="raw_material_quantity"
                           min="0"
                           step="0.01"
                           value="1">

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">

                    Cancel

                </button>

                <button type="button"
                        class="btn btn-primary"
                        id="addRawMaterialConfirmBtn">

                    <i class="fa fa-plus"></i>
                    Add Material

                </button>

            </div>

        </div>

    </div>

</div>


<script>
/* ============================================================
 * PROJECT SALES ORDER CHECKBOX
 * ============================================================ */
var base_url = "<?= base_url() ?>";
$(document).on('change', '.sales-order-checkbox', function () {

    var salesOrderId = $(this).val();

    if (!salesOrderId) {
        return;
    }

    if (!$(this).is(':checked')) {

        /*
         * Remove rows belonging to this Sales Order
         */
        $('#jobOrderItemsTable tbody tr[data-so-id="' + salesOrderId + '"]')
            .remove();


        /*
         * Re-number rows
         */
        renumberJobOrderItems();

        return;
    }


    /*
     * =========================================================
     * SALES ORDER CHECKED
     * Load its items
     * =========================================================
     */

    $.ajax({

        url:
            base_url +
            'index.php/Production/get_sales_order_items',

        type: 'POST',

        dataType: 'json',

        data: {
            so_id: salesOrderId
        },

        success: function (response) {

            if (!response || !response.length) {

                alert(
                    'No items found for this Sales Order.'
                );

                return;
            }


            $.each(response, function (index, item) {

                /*
                 * Prevent duplicate item
                 */
                if (
                    $('#jobOrderItemsTable tbody')
                        .find(
                            'tr[data-so-id="' +
                            salesOrderId +
                            '"][data-project-item-id="' +
                            item.product_table_id +
                            '"]'
                        )
                        .length
                ) {
                    return;
                }


                var row =
                    '<tr ' +
                        'data-so-id="' +
                            salesOrderId +
                        '" ' +
                        'data-project-item-id="' +
                            item.product_table_id +
                        '">' +

                        '<td></td>' +

                        '<td>' +
                            $('<div>')
                                .text(item.so_code || item.sales_order_code || '')
                                .html() +
                        '</td>' +

                        '<td>' +
                            $('<div>')
                                .text(
                                    (item.product_name || '') +
                                    ' - ' +
                                    (item.product_code || '')
                                )
                                .html() +
                        '</td>' +

                        '<td>' +
                            parseFloat(
                                item.quantity || 0
                            ).toFixed(2) +
                        '</td>' +

                        '<td>' +
                            $('<div>')
                                .text(item.unit || item.unit_abbr || '')
                                .html() +
                        '</td>' +

                        '<td>' +
                            parseFloat(
                                item.amount || 0
                            ).toFixed(2) +
                        '</td>' +

                        '<td class="text-center">' +

                            '<span class="text-muted">' +
                                'Save first to add materials' +
                            '</span>' +

                        '</td>' +

                    '</tr>';


                $('#jobOrderItemsTable tbody')
                    .append(row);

            });


            renumberJobOrderItems();
        },

        error: function (xhr) {

            console.log(
                xhr.responseText
            );

            alert(
                'Unable to load Sales Order items.'
            );

            /*
             * If loading fails, restore checkbox
             */
            $('.sales-order-checkbox[value="' +
                salesOrderId +
            '"]').prop(
                'checked',
                false
            );
        }

    });

});


/* ============================================================
 * RE-NUMBER JOB ORDER ITEMS
 * ============================================================ */

function renumberJobOrderItems() {

    $('#jobOrderItemsTable tbody tr').each(
        function (index) {

            $(this)
                .find('td:first')
                .text(index + 1);

        }
    );

}
$(document).ready(function () {

    /*
     * ============================================================
     * VARIABLES
     * ============================================================
     */

    var base_url = "<?= base_url() ?>";

    var currentJobOrderItemId = null;
    var currentProjectItemId = null;
    var currentItemMasterId = null;

    /*
     * IMPORTANT:
     * Materials are stored using job_order_item_id.
     *
     * This is safer than using project_item_id because
     * job_order_item_id is unique for every Job Order item.
     */

    var jobOrderMaterials = {};


    /*
     * ============================================================
     * LOAD EXISTING MATERIALS FROM PHP
     * ============================================================
     */

    <?php if (!empty($job_order_items)) : ?>

        <?php foreach ($job_order_items as $item) : ?>

            jobOrderMaterials[
                <?= (int)$item->job_order_item_id ?>
            ] = <?= json_encode(
                !empty($item->materials)
                    ? $item->materials
                    : array()
            ) ?>;

        <?php endforeach; ?>

    <?php endif; ?>


    /*
     * ============================================================
     * JOB ORDER ITEMS DATATABLE
     * ============================================================
     */

    if ($('#jobOrderItemsTable').length) {

        $('#jobOrderItemsTable').DataTable({

            destroy: true,

            responsive: true,

            pageLength: 25,

            order: [
                [0, 'asc']
            ]

        });

    }


    /*
     * ============================================================
     * OPEN MATERIAL MODAL
     * ============================================================
     */

    $(document).on('click', '.material-btn', function () {

        currentJobOrderItemId =
            $(this).data('job-order-item-id');

        currentProjectItemId =
            $(this).data('project-item-id');

        currentItemMasterId =
            $(this).data('item-master');

        var itemName =
            $(this).data('item-name');


        /*
         * Store hidden values
         */

        $('#currentJobOrderItemId')
            .val(currentJobOrderItemId);

        $('#currentProjectItemId')
            .val(currentProjectItemId);

        $('#currentItemMasterId')
            .val(currentItemMasterId);

        $('#currentItemName')
            .text(itemName);


        /*
         * Render materials
         */

        renderItemMaterials();


        /*
         * Open modal
         */

        $('#materialsModal').modal('show');

    });


    /*
     * ============================================================
     * RENDER MATERIALS
     * ============================================================
     */

    function renderItemMaterials() {

        var materials =
            jobOrderMaterials[currentJobOrderItemId] || [];

        var tbody =
            $('#itemMaterialsBody');

        tbody.empty();


        if (!materials.length) {

            tbody.append(
                '<tr>' +
                    '<td colspan="8" class="text-center text-muted">' +
                        'No materials added.' +
                    '</td>' +
                '</tr>'
            );

            return;
        }


        $.each(materials, function (index, material) {

            var materialCode =
                material.material_code || '';

            var materialName =
                material.material_name || '';

            var quantity =
                parseFloat(material.quantity_required || 0);

            var unit =
                material.unit || '';

            var cost =
                parseFloat(material.cost || 0);

            var source =
                material.source || 'BOM';


            var row =
                '<tr>' +

                    '<td>' +
                        (index + 1) +
                    '</td>' +

                    '<td>' +
                        $('<div>').text(materialCode).html() +
                    '</td>' +

                    '<td>' +
                        $('<div>').text(materialName).html() +
                    '</td>' +

                    '<td>' +

                        '<input type="number"' +
                               ' class="form-control input-sm material-qty"' +
                               ' data-index="' + index + '"' +
                               ' min="0"' +
                               ' step="0.01"' +
                               ' value="' + quantity + '">' +

                    '</td>' +

                    '<td>' +
                        $('<div>').text(unit).html() +
                    '</td>' +

                    '<td>' +
                        cost.toFixed(2) +
                    '</td>' +

                    '<td>' +

                        '<span class="label ' +
                            (source === 'MANUAL'
                                ? 'label-warning'
                                : 'label-info') +
                        '">' +

                            $('<div>').text(source).html() +

                        '</span>' +

                    '</td>' +

                    '<td class="text-center">' +

                        '<button type="button"' +
                                ' class="btn btn-xs btn-danger delete-material"' +
                                ' data-index="' + index + '">' +

                            '<i class="fa fa-trash"></i>' +

                        '</button>' +

                    '</td>' +

                '</tr>';


            tbody.append(row);

        });

    }


    /*
     * ============================================================
     * MATERIAL QUANTITY CHANGE
     * ============================================================
     */

    $(document).on('input', '.material-qty', function () {

        var index =
            parseInt($(this).data('index'), 10);

        var quantity =
            parseFloat($(this).val());

        if (isNaN(quantity) || quantity < 0) {

            quantity = 0;

            $(this).val(0);
        }


        if (!jobOrderMaterials[currentJobOrderItemId]) {

            jobOrderMaterials[currentJobOrderItemId] = [];

        }


        jobOrderMaterials[
            currentJobOrderItemId
        ][index].quantity_required = quantity;

    });


    /*
     * ============================================================
     * DELETE MATERIAL
     * ============================================================
     */

    $(document).on('click', '.delete-material', function () {

        var index =
            parseInt($(this).data('index'), 10);


        if (!jobOrderMaterials[currentJobOrderItemId]) {

            return;

        }


        if (!confirm('Are you sure you want to remove this material?')) {

            return;

        }


        jobOrderMaterials[
            currentJobOrderItemId
        ].splice(index, 1);


        renderItemMaterials();

    });


    /*
     * ============================================================
     * OPEN ADD RAW MATERIAL MODAL
     * ============================================================
     */

    $('#addRawMaterialBtn').on('click', function () {

        $('#raw_material_id').val('');

        $('#raw_material_unit').val('');

        $('#raw_material_quantity').val('1');


        $('#rawMaterialModal').modal('show');

    });


    /*
     * ============================================================
     * ADD RAW MATERIAL
     * ============================================================
     */

    $('#addRawMaterialConfirmBtn').on('click', function () {

        var materialSelect =
            $('#raw_material_id');

        var materialId =
            materialSelect.val();

        var selectedOption =
            materialSelect.find('option:selected');


        var materialCode =
            selectedOption.data('code') || '';

        var materialName =
            selectedOption.data('name') || '';


        var unitId =
            $('#raw_material_unit').val();

        var unitName =
            $('#raw_material_unit option:selected').text().trim();


        var quantity =
            parseFloat(
                $('#raw_material_quantity').val()
            );


        /*
         * Validation
         */

        if (!materialId) {

            alert('Please select a raw material.');

            return;

        }


        if (!unitId) {

            alert('Please select a unit.');

            return;

        }


        if (isNaN(quantity) || quantity <= 0) {

            alert('Please enter a valid quantity.');

            return;

        }


        /*
         * Initialize array
         */

        if (!jobOrderMaterials[currentJobOrderItemId]) {

            jobOrderMaterials[currentJobOrderItemId] = [];

        }


        /*
         * Add MANUAL material
         */

        jobOrderMaterials[
            currentJobOrderItemId
        ].push({

            job_order_material_id: null,

            job_order_item_id:
                currentJobOrderItemId,

            project_item_id:
                currentProjectItemId,

            material_id:
                materialId,

            material_code:
                materialCode,

            material_name:
                materialName,

            quantity_required:
                quantity,

            unit:
                unitName,

            unit_id:
                unitId,

            cost:
                0,

            source:
                'MANUAL'

        });


        /*
         * Close raw material modal
         */

        $('#rawMaterialModal').modal('hide');


        /*
         * Refresh materials table
         */

        renderItemMaterials();

    });


    /*
     * ============================================================
     * SAVE MATERIALS
     * ============================================================
     */

    $('#saveMaterialsBtn').on('click', function () {

        if (!currentJobOrderItemId) {

            alert('Job Order item not selected.');

            return;

        }


        var materials =
            jobOrderMaterials[currentJobOrderItemId] || [];


        var $button =
            $(this);


        $button.prop('disabled', true);

        $button.html(
            '<i class="fa fa-spinner fa-spin"></i> Saving...'
        );


        $.ajax({

            url:
                base_url +
                'index.php/Production/save_job_order_item_materials',

            type: 'POST',

            dataType: 'json',

            data: {

                job_order_id: $('#job_order_id').val(),

                job_order_item_id: currentJobOrderItemId,

                project_item_id:
                    currentProjectItemId,

                item_master_id:
                    currentItemMasterId,

                materials:
                    JSON.stringify(materials)

            },

            success: function (response) {

                if (response.status) {

                    alert(
                        response.message ||
                        'Materials saved successfully.'
                    );

                    $('#materialsModal').modal('hide');

                } else {

                    alert(
                        response.message ||
                        'Unable to save materials.'
                    );

                }

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                alert(
                    'Error while saving materials.'
                );

            },

            complete: function () {

                $button.prop('disabled', false);

                $button.html(
                    '<i class="fa fa-save"></i> Save Materials'
                );

            }

        });

    });


    /*
     * ============================================================
     * UPDATE JOB ORDER
     * ============================================================
     */

   $('#jobOrderEditForm').on('submit', function (e) {

    e.preventDefault();

    var form = $(this);

    var $button = form.find('button[type="submit"]');

    /*
     * =========================================================
     * VALIDATION
     * =========================================================
     */

    var projectId =
        $('input[name="fk_project_id"]').val();

    /*
     * PROJECT JOB ORDER
     * At least one Sales Order must be selected
     */
    if (projectId) {

        var selectedSalesOrders =
            $('.sales-order-checkbox:checked')
                .map(function () {
                    return $(this).val();
                })
                .get();

        if (selectedSalesOrders.length === 0) {

            alert(
                'Please select at least one Sales Order before updating the Job Order.'
            );

            return false;
        }

    }


    /*
     * =========================================================
     * START UPDATE
     * =========================================================
     */

    $button.prop('disabled', true);

    $button.html(
        '<i class="fa fa-spinner fa-spin"></i> Updating...'
    );


    $.ajax({

        url:
            base_url +
            'index.php/Production/update',

        type: 'POST',

        dataType: 'json',

        data: {

            job_order_id:
                $('#job_order_id').val(),

            sales_order_ids:
                $('.sales-order-checkbox:checked')
                    .map(function () {
                        return $(this).val();
                    })
                    .get(),

            order_no:
                $('#order_no').val(),

            order_date:
                $('#order_date').val(),

            fk_project_id:
                $('input[name="fk_project_id"]').val(),

            contact_person:
                $('#contact_person').val(),

            rep_name:
                $('#rep_name').val(),

            start_date:
                $('#start_date').val(),

            finish_date:
                $('#finish_date').val(),

            remarks:
                $('#remarks').val()

        },

        success: function (response) {

            if (response.status) {

                alert(
                    response.message ||
                    'Job Order updated successfully.'
                );

                window.location.href =
                    base_url +
                    'index.php/Production/job_order';

            } else {

                alert(
                    response.message ||
                    'Unable to update Job Order.'
                );

            }

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert(
                'Error while updating Job Order.'
            );

        },

        complete: function () {

            $button.prop('disabled', false);

            $button.html(
                '<i class="fa fa-save"></i> Update Job Order'
            );

        }

    });

});

    /*
     * ============================================================
     * SELECT2
     * ============================================================
     */

    if ($.fn.select2) {

        $('#contact_person').select2({

            width: '100%',

            placeholder: 'Select Contact Person',

            allowClear: true

        });


        $('#rep_name').select2({

            width: '100%',

            placeholder: 'Select Representative',

            allowClear: true

        });


        $('#raw_material_id').select2({

            width: '100%',

            dropdownParent: $('#rawMaterialModal'),

            placeholder: 'Select Raw Material',

            allowClear: true

        });


        $('#raw_material_unit').select2({

            width: '100%',

            dropdownParent: $('#rawMaterialModal'),

            placeholder: 'Select Unit',

            allowClear: true

        });

    }

});

</script>


<style>

    /*
     * Job Order Edit
     */

    #jobOrderItemsTable th,
    #jobOrderItemsTable td {

        vertical-align: middle;

    }


    #itemMaterialsTable th,
    #itemMaterialsTable td {

        vertical-align: middle;

    }


    .material-btn {

        min-width: 90px;

    }


    .material-qty {

        width: 100px;

    }


    .well {

        background: #f7f7f7;

        border: 1px solid #ddd;

    }


    .modal-lg {

        width: 90%;

        max-width: 1200px;

    }


    .alert {

        margin-bottom: 15px;

    }

</style>

