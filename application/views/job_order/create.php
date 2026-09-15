<div class="container-fluid">

    <!--<h2>Create Job Order</h2>-->

</style>
<div class="row">

    <div class="col-md-12">

        <div class="x_panel">
    <form id="jobOrderForm">
        <!-- HEADER -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Job Order Information</strong>
            </div>

    <div class="panel-body">

        <!-- ROW 1 -->
        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <label>
                        Job Order Type
                        <span class="text-danger">*</span>
                    </label>

                    <select name="job_order_type"
                            id="job_order_type"
                            class="form-control"
                            required>

                        <option value="">-- Select Type --</option>

                        <option value="0">
                            Normal Sales Order
                        </option>

                        <option value="1">
                            Project
                        </option>

                    </select>
                </div>
            </div>


            <div class="col-md-4" id="normalSalesOrderSection" style="display:none;">

                <div class="form-group">

                    <label>
                        Sales Order
                        <span class="text-danger">*</span>
                    </label>

                    <select name="sales_order_id"
                            id="sales_order_id"
                            class="form-control select2">

                        <option value="">
                            -- Select Sales Order --
                        </option>

                        <?php foreach ($sales_orders as $so): ?>

                            <option value="<?= $so->so_id ?>">
                                <?= htmlspecialchars($so->so_code) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>


            <div class="col-md-4" id="projectSection" style="display:none;">

                <div class="form-group">

                    <label>
                        Project
                        <span class="text-danger">*</span>
                    </label>

                    <select name="fk_project_id"
                            id="project_id"
                            class="form-control select2">

                        <option value="">
                            -- Select Project --
                        </option>

                        <?php foreach ($projects as $project): ?>

                            <option value="<?= $project->project_id ?>">
                                <?= htmlspecialchars($project->project_name) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>


            <div class="col-md-4">

                <div class="form-group">

                    <label>Job Order No</label>

                    <input type="text"
                           name="job_order_no"
                           class="form-control"
                           value="<?= $job_order_no; ?>"
                           readonly>

                </div>

            </div>

        </div>


        <!-- ROW 2 -->
        <div class="row">

            <div class="col-md-4">

                <div class="form-group">

                    <label>Order Date</label>

                    <input type="date"
                           name="order_date"
                           class="form-control"
                           value="<?= date('Y-m-d'); ?>"
                           required>

                </div>

            </div>


            <div class="col-md-4">

                <div class="form-group">

                    <label>Order No</label>

                    <input type="text"
                           name="order_no"
                           class="form-control"
                           required>

                </div>

            </div>


            <div class="col-md-4">

                <div class="form-group">

                    <label>Contact Person</label>
                
                    <select tabindex="10" class="form-select form-control"
                    id="contact_person" name="contact_person" required>
                             <option value="">
                                Select
                             </option>
                             <?php foreach ($user_records as $s) { ?>
                                    <option value="<?php echo $s['user_id']; ?>">
                                      <?php echo $s['user_name']; ?>
                                    </option>
                              <?php } ?>
                    </select>

                </div>

            </div>

        </div>


        <!-- ROW 3 -->
        <div class="row">

            <div class="col-md-4">

                <div class="form-group">

                    <label>Representative</label>

                <select tabindex="10" class="form-select form-control"
                    id="rep_name" name="rep_name" required>
                             <option value="">
                                Select
                             </option>
                             <?php foreach ($user_records as $s) { ?>
                                    <option value="<?php echo $s['user_id']; ?>">
                                      <?php echo $s['user_name']; ?>
                                    </option>
                              <?php } ?>
                    </select>
                </div>

            </div>


            <div class="col-md-4">

                <div class="form-group">

                    <label>Start Date</label>

                    <input type="date"
                           name="start_date"
                           class="form-control"
                           required>

                </div>

            </div>


            <div class="col-md-4">

                <div class="form-group">

                    <label>Finish Date</label>

                    <input type="date"
                           name="finish_date"
                           class="form-control"
                           required>

                </div>

            </div>

        </div>


        <!-- ROW 4 -->
        <div class="row">

            <div class="col-md-8">

                <div class="form-group">

                    <label>Remarks</label>

                    <textarea name="remarks"
                              class="form-control"
                              rows="3"></textarea>

                </div>

            </div>

        </div>

    </div>
</div>
        
        <!-- PROJECT SALES ORDERS -->
        <div class="panel panel-default" id="projectSalesOrderPanel" style="display:none;">

            <div class="panel-heading">
                <strong>Project Sales Orders</strong>
            </div>

            <div class="panel-body">

                <table class="table table-bordered"
                    id="projectSalesOrdersTable">

                    <thead>
                        <tr>
                            <th width="50">Select</th>
                            <th>Sales Order</th>
                            <th>SO Date</th>
                            <th>Customer</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">
                                Select a Project
                            </td>
                        </tr>
                    </tbody>

                </table>

            </div>

        </div>


        <!-- PROJECT ITEMS -->

        <div class="panel panel-default">

            <div class="panel-heading">
                <strong id="itemsPanelTitle">
                Sales Order Items
            </strong>
            </div>

            <div class="panel-body">

                <div id="itemsLoading"
                     style="display:none;">
                    Loading items...
                </div>

                <table class="table table-bordered"
                       id="projectItemsTable">

                    <thead>

                        <tr>
                            <th width="50">Select</th>
                            <th width="50">#</th>
                            <th>Sales Order</th>
                            <th>Item Code</th>
                            <th>Description</th>
                            <th>SO Qty</th>
                            <th>Job Qty</th>
                            <th>Unit</th>
                            <th>Materials</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td colspan="8"
                                class="text-center">
                                Select Sales Order
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <input type="submit" id="saveJobOrderBtn"
                class="btn btn-primary">
          

        <a href="<?= base_url('index.php/Production/job_order'); ?>"
           class="btn btn-default">
            Cancel
        </a>

    </form>

</div></div></div></div>




<div class="modal fade" id="materialModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h4 class="modal-title">
                    Raw Materials
                </h4>
                <button type="button"
                        class="close"
                        data-dismiss="modal">
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <h4 id="selectedItemName"></h4>

                <table class="table table-bordered"
                       id="materialTable">

                    <thead>

                        <tr>
                            <th>Code</th>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Source</th>
                        </tr>

                    </thead>

                    <tbody></tbody>

                </table>

                <hr>

                <button type="button"
                        class="btn btn-primary"
                        id="addMaterialBtn">

                    <i class="fa fa-plus"></i>
                    Add Raw Material

                </button>

            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary"  id="saveItemMaterialsBtn">
                    <i class="fa fa-save"></i>
                    Save Materials
                </button>

            </div>
        </div>

    </div>

</div>

<!-- ADD RAW MATERIAL MODAL -->
<div class="modal fade" id="addRawMaterialModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">
                    Add Raw Material
                </h4>
                <button type="button"
                        class="close"
                        data-dismiss="modal">
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <form id="addRawMaterialForm">

                    <div class="form-group">

                        <label>
                            Raw Material
                            <span class="text-danger">*</span>
                        </label>

                        <select id="new_material_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Raw Material
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Unit
                            <span class="text-danger">*</span>
                        </label>

                        <select id="new_material_unit"
                                class="form-control"
                                required>

                            <option value="">
                                Select Unit
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Quantity
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number"
                               id="new_material_qty"
                               class="form-control"
                               step="0.01"
                               min="0.01"
                               required>

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">
                    Cancel
                </button>

                <button type="button"
                        class="btn btn-primary"
                        id="saveRawMaterialBtn">

                    <i class="fa fa-save"></i>
                    Save Raw Material

                </button>

            </div>

        </div>

    </div>

</div>
<script>

var base_url = "<?= base_url(); ?>";

var currentProjectItemId = null;
var currentItemMasterId = null;

var jobOrderMaterials = {};
var jobOrderMaterialsSaved = {};


/* =========================================================
   DOCUMENT READY
========================================================= */

$(document).ready(function () {

    /* -----------------------------------------------------
       SELECT2
    ----------------------------------------------------- */

    $('.select2').select2({
        placeholder: '-- Select --',
        allowClear: true,
        width: '100%'
    });


    /* -----------------------------------------------------
       JOB ORDER TYPE CHANGE
    ----------------------------------------------------- */

    $('#job_order_type').on('change', function () {

        var type = $(this).val();

        if (type == '1') {

            $('#normalSalesOrderSection').hide();
            $('#projectSection').show();

            $('#sales_order_id').val(null).trigger('change');

        } else {

            $('#projectSection').hide();
            $('#normalSalesOrderSection').show();

            $('#project_id').val(null).trigger('change');

            $('#projectSalesOrderPanel').hide();

            $('#projectItemsTable tbody').html(
                '<tr>' +
                    '<td colspan="9" class="text-center">' +
                        'Select Sales Order' +
                    '</td>' +
                '</tr>'
            );
        }
    });


    /* -----------------------------------------------------
       NORMAL SALES ORDER CHANGE
    ----------------------------------------------------- */

    $('#sales_order_id').on('change', function () {

        var salesOrderId = $(this).val();

        if (!salesOrderId) {

            $('#projectItemsTable tbody').html(
                '<tr>' +
                    '<td colspan="9" class="text-center">' +
                        'Select Sales Order' +
                    '</td>' +
                '</tr>'
            );

            return;
        }

        loadSalesOrderItems(salesOrderId);
    });


    /* -----------------------------------------------------
       PROJECT CHANGE
    ----------------------------------------------------- */

    $(document).on('change', '#project_id', function () {

        var projectId = $(this).val();

        console.log('Selected Project ID:', projectId);

        if (!projectId) {

            $('#projectSalesOrderPanel').hide();

            $('#projectItemsTable tbody').html(
                '<tr>' +
                    '<td colspan="9" class="text-center">' +
                        'Select a Project' +
                    '</td>' +
                '</tr>'
            );

            return;
        }

        loadProjectSalesOrders(projectId);
    });


    /* -----------------------------------------------------
       SELECT ALL PROJECT SALES ORDERS
    ----------------------------------------------------- */

    $(document).on('change', '#selectAllProjectSO', function () {

        var checked = $(this).is(':checked');

        $('.project-so-checkbox').prop('checked', checked);

        loadSelectedProjectSalesOrderItems();
    });


    /* -----------------------------------------------------
       INDIVIDUAL PROJECT SALES ORDER
    ----------------------------------------------------- */

    $(document).on('change', '.project-so-checkbox', function () {

        var total = $('.project-so-checkbox').length;

        var checked = $('.project-so-checkbox:checked').length;

        $('#selectAllProjectSO').prop(
            'checked',
            total > 0 && total === checked
        );

        loadSelectedProjectSalesOrderItems();
    });


    /* -----------------------------------------------------
       MATERIAL BUTTON
    ----------------------------------------------------- */


$(document).on('click', '.material-btn', function () {

    currentProjectItemId = $(this).data('project-item-id');
    currentItemMasterId = $(this).data('item-master');

    console.log('Project Item ID:', currentProjectItemId);
    console.log('Item Master ID:', currentItemMasterId);

    if (!currentProjectItemId) {
        alert('Project Item ID is missing.');
        return;
    }

    if (!currentItemMasterId) {
        alert('Item Master ID is missing.');
        return;
    }

    $('#selectedItemName').text(
        $(this).data('item-name') || ''
    );

    /*
     * IMPORTANT:
     * Your actual modal ID is #materialModal
     */
    $('#materialModal').modal('show');

    /*
     * Load existing/BOM materials for this item
     */
    if (!jobOrderMaterials[currentProjectItemId]) {

        jobOrderMaterials[currentProjectItemId] = [];

        loadExistingMaterials();

    } else {

        renderItemMaterials();

    }

});




    /* -----------------------------------------------------
       ADD MANUAL MATERIAL
    ----------------------------------------------------- */

$(document).on('click', '#addMaterialBtn', function () {

    loadRawMaterials();
    loadUnits();

    $('#addRawMaterialModal').modal('show');

});



    /* -----------------------------------------------------
       SAVE MANUAL MATERIAL
    ----------------------------------------------------- */

$(document).on('click', '#saveRawMaterialBtn', function () {

    var materialId =
        $('#new_material_id').val();

    var materialName =
        $('#new_material_id option:selected').text();

    var materialCode =
        $('#new_material_id option:selected').data('code') || '';

    var quantity =
        parseFloat($('#new_material_qty').val()) || 0;

    var unit =
        $('#new_material_unit').val();

    if (!materialId) {
        alert('Please select a material.');
        return;
    }

    if (quantity <= 0) {
        alert('Please enter a valid quantity.');
        return;
    }

    if (!unit) {
        alert('Please select a unit.');
        return;
    }

    if (!currentProjectItemId) {
        alert('Project item is missing.');
        return;
    }

    if (!jobOrderMaterials[currentProjectItemId]) {
        jobOrderMaterials[currentProjectItemId] = [];
    }

    jobOrderMaterials[currentProjectItemId].push({

        material_id: materialId,

        material_code: materialCode,

        material_name: materialName,

        quantity_required: quantity,

        unit: unit,

        cost: 0,

        source: 'MANUAL'

    });

    /*
     * Refresh material table
     */
    renderItemMaterials();

    /*
     * Close Add Raw Material popup
     */
    $('#addRawMaterialModal').modal('hide');

    /*
     * Clear fields
     */
    $('#new_material_id').val('');
    $('#new_material_unit').val('');
    $('#new_material_qty').val('');

});



    /* -----------------------------------------------------
       SAVE ITEM MATERIALS
    ----------------------------------------------------- */

    $('#saveItemMaterialsBtn').on('click', function () {

        if (!currentProjectItemId) {

            alert('Project item is missing.');

            return;
        }


        renderItemMaterials();

        $('#materialModal').modal('hide');
    });


    /* -----------------------------------------------------
       SAVE JOB ORDER
    ----------------------------------------------------- */

    $('#saveJobOrderBtn').on('click', function (e) {

        e.preventDefault();


        var formData = $('#jobOrderForm').serializeArray();


        formData.push({

            name: 'job_order_materials',

            value: JSON.stringify(jobOrderMaterials)

        });


        $.ajax({

            url: base_url + 'index.php/Production/save_job_order',

            type: 'POST',

            data: formData,

            dataType: 'json',

            success: function (response) {

                console.log(response);


                if (response.status) {

                    alert(response.message);

                    window.location.href = base_url + 'index.php/Production/job_order';

                } else {

                    alert(
                        response.message ||
                        'Failed to save Job Order.'
                    );
                }

            },

            error: function (xhr) {

                console.log(xhr.responseText);

                alert(
                    'Something went wrong while saving Job Order.'
                );
            }

        });

    });

});


/* =========================================================
   LOAD NORMAL SALES ORDER ITEMS
========================================================= */

function loadSalesOrderItems(salesOrderId) {

    $.ajax({

        url: base_url + 'index.php/Production/get_sales_order_items',

        type: 'POST',

        data: {

            so_id: salesOrderId

        },

        dataType: 'json',

        success: function (response) {

            var tbody = $('#projectItemsTable tbody');

            tbody.empty();


            if (!response || response.length === 0) {

                tbody.append(
                    '<tr>' +
                        '<td colspan="9" class="text-center">' +
                            'No items found.' +
                        '</td>' +
                    '</tr>'
                );

                return;
            }


            $.each(response, function (index, item) {

                appendJobOrderItem(
                    index,
                    item
                );

            });

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert(
                'Unable to load Sales Order items.'
            );
        }

    });

}


/* =========================================================
   LOAD PROJECT SALES ORDERS
========================================================= */

function loadProjectSalesOrders(projectId) {

    $('#projectSalesOrderPanel').show();


    $.ajax({

        url: base_url + 'index.php/Production/get_project_sales_orders',

        type: 'POST',

        data: {

            project_id: projectId

        },

        dataType: 'json',

        success: function (response) {

            var tbody =
                $('#projectSalesOrdersTable tbody');


            tbody.empty();


            if (!response || response.length === 0) {

                tbody.append(
                    '<tr>' +
                        '<td colspan="4" class="text-center">' +
                            'No Sales Orders found.' +
                        '</td>' +
                    '</tr>'
                );

                return;
            }


            tbody.append(

                '<tr>' +

                    '<td colspan="5">' +

                        '<label>' +

                            '<input type="checkbox" ' +
                            'id="selectAllProjectSO">' +

                            ' Select All Sales Orders' +

                        '</label>' +

                    '</td>' +

                '</tr>'

            );


            $.each(response, function (index, so) {

                tbody.append(

                    '<tr>' +

                        '<td>' +

                            '<input type="checkbox" ' +
                            'class="project-so-checkbox" '  +
'name="sales_order_ids[]" ' +
                            'value="' +
                            so.so_id +
                            '">' +

                        '</td>' +

                        '<td>' +

                            (so.so_code || '') +

                        '</td>' +

                        '<td>' +

                            (so.so_date || '') +

                        '</td>' +

                        '<td>' +

                            (so.customer_name || '') +

                        '</td>' +

                    '</tr>'

                );

            });

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert(
                'Unable to load Project Sales Orders.'
            );
        }

    });

}


/* =========================================================
   LOAD SELECTED PROJECT SALES ORDER ITEMS
========================================================= */

function loadSelectedProjectSalesOrderItems() {

    var selectedSalesOrders = [];


    $('.project-so-checkbox:checked').each(
        function () {

            selectedSalesOrders.push(
                $(this).val()
            );

        }
    );


    if (selectedSalesOrders.length === 0) {

        $('#projectItemsTable tbody').html(

            '<tr>' +

                '<td colspan="9" class="text-center">' +

                    'Select Sales Order' +

                '</td>' +

            '</tr>'

        );

        return;
    }


    $.ajax({

        url: base_url +'index.php/Production/get_multiple_sales_order_items',

        type: 'POST',

        data: {

            so_ids: selectedSalesOrders

        },

        dataType: 'json',

        success: function (response) {

            var tbody =
                $('#projectItemsTable tbody');


            tbody.empty();


            if (!response || response.length === 0) {

                tbody.append(

                    '<tr>' +

                        '<td colspan="9" class="text-center">' +

                            'No items found.' +

                        '</td>' +

                    '</tr>'

                );

                return;
            }


            $.each(response, function (index, item) {

                appendJobOrderItem(
                    index,
                    item
                );

            });

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert(
                'Unable to load Sales Order items.'
            );
        }

    });

}


/* =========================================================
   APPEND JOB ORDER ITEM
========================================================= */


function appendJobOrderItem(index, item) {

    var productTableId = item.product_table_id || '';
    var soId           = item.so_id || '';
    var soCode         = item.sales_order_code || item.so_code || '';

    var itemMasterId   = item.item_master_id || item.product_id || '';
    var itemCode       = item.item_code || item.product_code || '';
    var itemName       = item.item_description || item.product_name || '';

    var soQty          = parseFloat(item.quantity || 0);
    var jobQty         = '';
    var unit           = item.unit || '';
    var unitId         = item.unit_id || '';

    var price           = item.unit_price || 0;

    var row = '<tr>';

    // SELECT
    row += '<td class="text-center">';

    row += '<input type="checkbox" ' +
        'class="job-item-checkbox" ' +
        'name="selected_items[]" ' +
        'value="' + productTableId + '">';

    row += '</td>';

    // #
    row += '<td>' + (index + 1) + '</td>';

    // SALES ORDER
    row += '<td>';

    row += '<strong>' + escapeHtml(soCode) + '</strong>';

    row += '<input type="hidden" ' +
        'name="items[' + index + '][product_table_id]" ' +
        'value="' + productTableId + '">';

    row += '<input type="hidden" ' +
        'name="items[' + index + '][so_id]" ' +
        'value="' + soId + '">';

    row += '</td>';

    // ITEM CODE
    row += '<td>';

    row += escapeHtml(itemCode);

    row += '<input type="hidden" ' +
        'name="items[' + index + '][item_master_id]" ' +
        'value="' + itemMasterId + '">';

    row += '<input type="hidden" ' +
        'name="items[' + index + '][item_code]" ' +
        'value="' + escapeHtml(itemCode) + '">';

    row += '</td>';

    // DESCRIPTION
    row += '<td>';

    row += escapeHtml(itemName);

    row += '<input type="hidden" ' +
        'name="items[' + index + '][item_description]" ' +
        'value="' + escapeHtml(itemName) + '">';

    row += '</td>';

    // SO QTY
    row += '<td class="text-right">';

    row += soQty;

    row += '</td>';

    // JOB QTY
    row += '<td>';

    row += '<input type="number" ' +
        'class="form-control input-sm job-qty" ' +
        'name="items[' + index + '][job_quantity]" ' +
        'value="' + jobQty + '" ' +
        'min="0" ' +
        'max="' + soQty + '" ' +
        'step="0.01">';

    row += '</td>';

    // UNIT
    row += '<td>';

    row += escapeHtml(unit);

    row += '<input type="hidden" ' +
        'name="items[' + index + '][unit_id]" ' +
        'value="' + unitId + '">';

    row += '<input type="hidden" ' +
        'name="items[' + index + '][unit]" ' +
        'value="' + escapeHtml(unit) + '">';

    row += '</td>';

    // MATERIALS
    row += '<td>';

    row += '<button type="button" ' +
        'class="btn btn-info btn-sm material-btn" ' +
        'data-project-item-id="' + productTableId + '" ' +
        'data-item-master="' + itemMasterId + '" ' +
        'data-item-name="' + escapeHtml(itemName) + '">' +
        '<i class="fa fa-cubes"></i>'+' Materials' +
        '</button>';

    row += '</td>';

    row += '</tr>';

    $('#projectItemsTable tbody').append(row);
}


/**
 * Prevent special characters from breaking the HTML.
 */
function escapeHtml(value) {

    if (value === null || value === undefined) {
        return '';
    }

    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}


/* =========================================================
   LOAD RAW MATERIALS
========================================================= */


function loadRawMaterials() {

    $.ajax({

        url: base_url + 'index.php/Production/get_raw_materials',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            var select = $('#new_material_id');

            select.empty();

            select.append(
                '<option value="">-- Select Material --</option>'
            );

            $.each(response, function (index, material) {

                select.append(
                    '<option value="' +
                    material.material_id +
                    '" data-code="' +
                    (material.material_code || '') +
                    '">' +
                    escapeHtml(material.material_name) +
                    '</option>'
                );

            });

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert('Unable to load raw materials.');

        }

    });

}




/* =========================================================
   LOAD UNITS
========================================================= */

function loadUnits() {

    $.ajax({

        url: base_url + 'index.php/Production/get_units',

        type: 'GET',

        dataType: 'json',

        success: function (response) {

            console.log('UNIT RESPONSE:', response);

            var select = $('#new_material_unit');

            select.empty();

            select.append(
                '<option value="">-- Select Unit --</option>'
            );

            $.each(response, function (index, unit) {

                select.append(
                    '<option value="' + unit.unit_name + '">' +
                        escapeHtml(unit.unit_name) +
                    '</option>'
                );

            });

        },

        error: function (xhr) {

            console.log('GET UNITS ERROR:', xhr.responseText);

            alert('Unable to load units.');

        }

    });

}




/* =========================================================
   LOAD EXISTING MATERIALS
========================================================= */

function loadExistingMaterials() {

    if (!currentProjectItemId) {

        return;
    }


    loadBOMMaterials();

}


/* =========================================================
   LOAD BOM MATERIALS
========================================================= */

function loadBOMMaterials() {

    if (!currentProjectItemId) {

        return;
    }


    if (!currentItemMasterId) {

        return;
    }


    $.ajax({

        url: base_url +
            'index.php/Production/get_item_materials',

        type: 'POST',

        data: {

            item_master_id: currentItemMasterId

        },

        dataType: 'json',

        success: function (response) {

            if (!jobOrderMaterials[currentProjectItemId]) {

                jobOrderMaterials[currentProjectItemId] = [];

            }


            if (response && response.length > 0) {

                $.each(response, function (index, material) {

                    var exists =
                        jobOrderMaterials[
                            currentProjectItemId
                        ].some(function (existing) {

                            return (
                                existing.material_id ==
                                material.material_id
                            );

                        });


                    if (!exists) {

                        jobOrderMaterials[
                            currentProjectItemId
                        ].push({

                            material_id:
                                material.material_id,

                            material_code:
                                material.material_code || '',

                            material_name:
                                material.material_name,

                            quantity_required:
                                parseFloat(
                                    material.quantity_required
                                ) || 0,

                            unit:
                                material.unit || '',

                            cost:
                                parseFloat(
                                    material.cost
                                ) || 0,

                            source:
                                'BOM'

                        });

                    }

                });

            }


            renderItemMaterials();

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            renderItemMaterials();

        }

    });

}


/* =========================================================
   RENDER ITEM MATERIALS
========================================================= */


function renderItemMaterials() {

    var materials = jobOrderMaterials[currentProjectItemId] || [];

    var tbody =
        $('#materialTable tbody');

    tbody.empty();

    if (materials.length === 0) {

        tbody.append(
            '<tr>' +
                '<td colspan="5" class="text-center">' +
                    'No materials added.' +
                '</td>' +
            '</tr>'
        );

        return;
    }

    $.each(materials, function (index, material) {

        tbody.append(

            '<tr>' +

                '<td>' +
                    escapeHtml(material.material_code || '') +
                '</td>' +

                '<td>' +
                    escapeHtml(material.material_name || '') +
                '</td>' +

                '<td>' +
                    (material.quantity_required || 0) +
                '</td>' +

                '<td>' +
                    escapeHtml(material.unit || '') +
                '</td>' +

                '<td>' +
                    escapeHtml(material.source || 'BOM') +
                '</td>' +

            '</tr>'

        );

    });

}



/* =========================================================
   RENDER MANUAL MATERIALS
========================================================= */

function renderManualMaterials() {

    renderItemMaterials();

}


/* =========================================================
   APPEND MATERIAL ROW
========================================================= */

function appendMaterialRow(
    tbody,
    material,
    index
) {

    tbody.append(

        '<tr>' +

            '<td>' +

                (index + 1) +

            '</td>' +

            '<td>' +

                (material.material_code || '') +

            '</td>' +

            '<td>' +

                (material.material_name || '') +

            '</td>' +

            '<td>' +

                (material.quantity_required || 0) +

            '</td>' +

            '<td>' +

                (material.unit || '') +

            '</td>' +

            '<td>' +

                (material.cost || 0) +

            '</td>' +

            '<td>' +

                (material.source || 'BOM') +

            '</td>' +

        '</tr>'

    );

}

</script>