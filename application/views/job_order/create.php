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

               

                    <div class="col-md-4">

                       
                        <label>
                            Job Order Type
                            <span class="text-danger">*</span>
                        </label>

                        <select name="job_order_type" id="job_order_type" class="form-control " required>
                            <option value="">
                                -- Select Type --
                            </option>
                            <option value="0">
                                Normal Sales Order
                            </option>
                            <option value="1">
                                Project
                            </option>

                        </select>

                    </div>
                    
                    <div class="col-md-4" id="normalSalesOrderSection"  style="display:none;">
                        <label>
                            Sales Order
                            <span class="text-danger">*</span>
                        </label>

                        <select name="sales_order_id"  id="sales_order_id"  class="form-control select2">
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

                    <div class="col-md-4">

                        <label>Job Order No</label>

                        <input type="text"
                               name="job_order_no"
                               class="form-control"
                               value="<?= $job_order_no; ?>"
                               readonly>

                    </div>
                    
                    <div class="col-md-4">

                        <label>Order Date</label>

                        <input type="date"
                               name="order_date"
                               class="form-control"
                               value="<?= date('Y-m-d'); ?>"  required>

                    </div>


                    <div class="col-md-4">

                        <label>Order No</label>

                        <input type="text"
                               name="order_no"
                               class="form-control"  required>

                    </div>

             

                <div class="col-md-4"  id="projectSection"  style="display:none;">

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
         
                    <div class="col-md-4">

                        <label>Contact Person</label>

                        <input type="text"
                               name="contact_person"
                               class="form-control"  required>

                    </div>


                    <div class="col-md-4">

                        <label>Representative</label>

                        <input type="text"
                               name="rep_name"
                               class="form-control">

                    </div>
                 

                    <div class="col-md-4">

                        <label>Start Date</label>

                        <input type="date"
                               name="start_date"
                               class="form-control"  required>

                    </div>


                    <div class="col-md-4">

                        <label>Finish Date</label>

                        <input type="date"
                               name="finish_date"
                               class="form-control"  required>

                    </div>
                   
 <div class="col-md-4">

                <label>Remarks</label>

                <textarea name="remarks"
                          class="form-control"
                          rows="3"></textarea>

                            </div>
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

</div></div></div></div


<!-- MATERIAL MODAL -->

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

var currentItemMasterId = null;
$(document).ready(function () {

        $('.select2').select2({
            placeholder: '-- Select Project --',
            allowClear: true,
            width: '100%'
        });

  

    /*
    * Load project items
    */
   $('#job_order_type').on('change', function () {

        var type = $(this).val();

        $('#normalSalesOrderSection').hide();
        $('#projectSection').hide();
        $('#projectSalesOrderPanel').hide();

        $('#sales_order_id').val('').trigger('change');
        $('#project_id').val('').trigger('change');

        $('#projectItemsTable tbody').html(
            '<tr>' +
            '<td colspan="9" class="text-center">' +
            'Select Sales Order' +
            '</td>' +
            '</tr>'
        );

        if (type == '0') {

            // NORMAL SALES ORDER
            $('#normalSalesOrderSection').show();

            $('#itemsPanelTitle').text(
                'Sales Order Items'
            );

        } else if (type == '1') {

            // PROJECT
            $('#projectSection').show();

            $('#itemsPanelTitle').text(
                'Project Sales Order Items'
            );
        }

    });

    //normal sales order change
    $('#sales_order_id').on('change', function () {

        var salesOrderId = $(this).val();

        if (!salesOrderId) {

            $('#projectItemsTable tbody').html(
                '<tr>' +
                '<td colspan="9" class="text-center">' +
                'Select a Sales Order' +
                '</td>' +
                '</tr>'
            );

            return;
        }

        loadSalesOrderItems(salesOrderId);

    });

  });

  function loadSalesOrderItems(salesOrderId)
{
    var tbody =
        $('#projectItemsTable tbody');

    $('#itemsLoading').show();

    $.ajax({

        url:
            base_url +
            'index.php/Production/get_sales_order_items',

        type: 'POST',

        dataType: 'json',

        data: {
            sales_order_id: salesOrderId
        },

        success: function(res) {

            tbody.empty();

            if (!res || !res.length) {

                tbody.html(
                    '<tr>' +
                    '<td colspan="9" class="text-center">' +
                    'No items found.' +
                    '</td>' +
                    '</tr>'
                );

                return;
            }

            $.each(res, function(index, item) {

                appendJobOrderItem(
                    index,
                    item
                );

            });
        },

        error: function(xhr) {

            console.log(xhr.responseText);

            tbody.html(
                '<tr>' +
                '<td colspan="9" class="text-center text-danger">' +
                'Unable to load items.' +
                '</td>' +
                '</tr>'
            );
        },

        complete: function() {
            $('#itemsLoading').hide();
        }

    });
}

$('#project_id').on('change', function () {

    var projectId = $(this).val();

    if (!projectId) {

        $('#projectSalesOrderPanel').hide();

        return;
    }

    loadProjectSalesOrders(projectId);

});

function loadProjectSalesOrders(projectId)
{
    $('#projectSalesOrderPanel').show();

    var tbody =
        $('#projectSalesOrdersTable tbody');

    tbody.html(
        '<tr>' +
        '<td colspan="6" class="text-center">' +
        'Loading...' +
        '</td>' +
        '</tr>'
    );

    $.ajax({

        url:
            base_url +
            'index.php/Production/get_project_sales_orders',

        type: 'POST',

        dataType: 'json',

        data: {
            project_id: projectId
        },

        success: function(res) {

            tbody.empty();

            if (!res || !res.length) {

                tbody.html(
                    '<tr>' +
                    '<td colspan="6" class="text-center">' +
                    'No Sales Orders found for this project.' +
                    '</td>' +
                    '</tr>'
                );

                return;
            }

            $.each(res, function(index, so) {

                tbody.append(

                    '<tr>' +

                    '<td>' +
                    '<input type="checkbox" ' +
                    'class="project-so-checkbox" ' +
                    'name="sales_order_ids[]" ' +
                    'value="' +
                    so.sales_order_id +
                    '">' +
                    '</td>' +

                    '<td>' +
                    (index + 1) +
                    '</td>' +

                    '<td>' +
                    (so.sales_order_no || '') +
                    '</td>' +

                    '<td>' +
                    (so.customer_name || '') +
                    '</td>' +

                    '<td>' +
                    (so.order_date || '') +
                    '</td>' +

                    '<td>' +
                    (so.status || '') +
                    '</td>' +

                    '</tr>'
                );

            });

        },

        error: function(xhr) {

            console.log(xhr.responseText);

            tbody.html(
                '<tr>' +
                '<td colspan="6" class="text-center text-danger">' +
                'Unable to load Sales Orders.' +
                '</td>' +
                '</tr>'
            );
        }

    });
}

$(document).on('change','#selectAllSalesOrders',function() {

        $('.project-so-checkbox')
            .prop(
                'checked',
                $(this).prop('checked')
            );

        loadSelectedProjectSalesOrderItems();
    }
);

$(document).on( 'change',
    '.project-so-checkbox',
    function() {

        loadSelectedProjectSalesOrderItems();

    }
);

function loadSelectedProjectSalesOrderItems()
{
    var salesOrderIds = [];

    $('.project-so-checkbox:checked')
        .each(function() {

            salesOrderIds.push(
                $(this).val()
            );

        });

    if (salesOrderIds.length === 0) {

        $('#projectItemsTable tbody').html(
            '<tr>' +
            '<td colspan="9" class="text-center">' +
            'Select at least one Sales Order' +
            '</td>' +
            '</tr>'
        );

        return;
    }

    $.ajax({

        url:
            base_url +
            'index.php/Production/get_multiple_sales_order_items',

        type: 'POST',

        dataType: 'json',

        data: {
            sales_order_ids: salesOrderIds
        },

        success: function(res) {

            var tbody =
                $('#projectItemsTable tbody');

            tbody.empty();

            $.each(res, function(index, item) {

                appendJobOrderItem(
                    index,
                    item
                );

            });

        },

        error: function(xhr) {

            console.log(xhr.responseText);

        }

    });
}

function appendJobOrderItem(index, item)
{
    var tbody =
        $('#projectItemsTable tbody');

    var projectItemId =
        item.product_table_id || '';

    var salesOrderId =
        item.sales_order_id || '';

    var salesOrderNo =
        item.sales_order_code || '';

    var itemMasterId =
        item.item_master_id ||
        item.product_id ||
        '';

    var itemCode =
        item.item_code ||
        item.product_code ||
        '';

    var description =
        item.item_description ||
        item.product_name ||
        '';

    var qty =
        parseFloat(
            item.quantity || 0
        );

    var unit =
        item.unit_name ||
        item.unit_abbr ||
        '';

    var price =
        item.retail_price || 0;

    var row =
        '<tr>' +

        '<td>' +

        '<input type="checkbox" ' +
        'name="items[' + index + '][selected]" ' +
        'value="1">' +

        '<input type="hidden" ' +
        'name="items[' + index + '][product_table_id]" ' +
        'value="' + projectItemId + '">' +

        '<input type="hidden" ' +
        'name="items[' + index + '][so_id]" ' +
        'value="' + salesOrderId + '">' +

        '<input type="hidden" ' +
        'name="items[' + index + '][item_master_id]" ' +
        'value="' + itemMasterId + '">' +

        '<input type="hidden" ' +
        'name="items[' + index + '][item_code]" ' +
        'value="' + itemCode + '">' +

        '<input type="hidden" ' +
        'name="items[' + index + '][item_description]" ' +
        'value="' + description + '">' +

        '<input type="hidden" ' +
        'name="items[' + index + '][retail_price]" ' +
        'value="' + price + '">' +

        '<input type="hidden" ' +
        'name="items[' + index + '][unit]" ' +
        'value="' + unit + '">' +

        '</td>' +

        '<td>' +
        (index + 1) +
        '</td>' +

        '<td>' +
        salesOrderNo +
        '</td>' +

        '<td>' +
        itemCode +
        '</td>' +

        '<td>' +
        description +
        '</td>' +

        '<td>' +
        qty +
        '</td>' +

        '<td>' +

        '<input type="number" ' +
        'step="1" ' +
        'min="0" ' +
        'class="form-control" ' +
        'name="items[' + index + '][quantity]" ' +
        'value="' + qty + '">' +

        '</td>' +

        '<td>' +
        unit +
        '</td>' +
 '<td>' +

                    '<button type="button" ' +
                    'class="btn btn-xs btn-info material-btn" ' +

                    'data-project-item-id="' +
                    (item.product_table_id || '') +
                    '" ' +

                    'data-item-master="' +
                    (item.product_id || '') +
                    '" ' +

                    'data-item-name="' +
                    (item.product_name || '') +
                    '">' +

                    '<i class="fa fa-cubes"></i> Materials' +

                    '</button>' +'</td>' +

        '</tr>';

    tbody.append(row);
}

/*
 * Open materials
 */
$(document).on(
    'click',
    '.material-btn',
    function () {

        currentItemMasterId =
            $(this).data('item-master');

        var itemName =
            $(this).data('item-name');


        $('#selectedItemName').text(
            itemName
        );


        $('#materialTable tbody').html(
            '<tr>' +
            '<td colspan="5" class="text-center">' +
            'Loading...' +
            '</td>' +
            '</tr>'
        );


        $('#materialModal').modal('show');


        $.ajax({
            url: base_url +'index.php/Production/get_item_materials',
            type: 'POST',
            dataType: 'json',
            data: {
                item_master_id:
                    currentItemMasterId
            },

            success: function (materials) {
                var tbody = $('#materialTable tbody');
                tbody.empty();
                if (!materials.length) {

                    tbody.html(
                        '<tr>' +
                        '<td colspan="5" class="text-center">' +
                        'No standard raw materials found.' +
                        '</td>' +
                        '</tr>'
                    );

                    return;
                }
                $.each(materials, function (i, material) {
                    tbody.append(
                        '<tr>' +

                        '<td>' +
                        (material.material_code || '') +
                        '</td>' +

                        '<td>' +
                        material.material_name +
                        '</td>' +

                        '<td>' +
                        material.quantity_required +
                        '</td>' +

                        '<td>' +
                        (material.unit_abbr || '') +
                        '</td>' +

                        '<td>' +
                        '<span class="label label-info">' +
                        'BOM' +
                        '</span>' +
                        '</td>' +

                        '</tr>'
                    );

                });

            }

        });

    }
);


$(document).on('click', '#addMaterialBtn', function () {

    if (!currentItemMasterId) {
        alert('Please select an item first.');
        return;
    }

    $('#addRawMaterialForm')[0].reset();

    $('#new_material_id').html(
        '<option value="">Loading...</option>'
    );

    $('#new_material_unit').html(
        '<option value="">Loading...</option>'
    );

    $('#addRawMaterialModal').modal('show');


    // Load Raw Materials
    $.ajax({

        url: base_url + 'index.php/Production/get_raw_materials',

        type: 'GET',

        dataType: 'json',

        success: function (materials) {

            var html =
                '<option value="">Select Raw Material</option>';

            $.each(materials, function (i, material) {

                html +=
                    '<option value="' +
                    material.material_id +
                    '" ' +
                    'data-code="' +
                    (material.material_code || '') +
                    '">' +

                    (material.material_code
                        ? material.material_code + ' - '
                        : '') +

                    material.material_name +

                    '</option>';
            });

            $('#new_material_id').html(html);
        }

    });


    // Load Units from unit_master
    $.ajax({

        url: base_url + 'index.php/Production/get_units',

        type: 'GET',

        dataType: 'json',

        success: function (units) {

            var html =
                '<option value="">Select Unit</option>';

            $.each(units, function (i, unit) {

                html +=
                    '<option value="' +
                    unit.unit_abbr +
                    '">' +
                    unit.unit_abbr +
                    
                    '</option>';
            });

            $('#new_material_unit').html(html);
        }

    });

});

var jobOrderMaterials = {};
var jobOrderMaterialsSaved = {};
var currentProjectItemId = null;
var currentItemMasterId = null;

$(document).on('click', '.material-btn', function () {

    currentProjectItemId =
        $(this).attr('data-project-item-id');

    currentItemMasterId =
        $(this).attr('data-item-master');

    var itemName =
        $(this).attr('data-item-name');


    console.log(
        'Project Item ID:',
        currentProjectItemId
    );

    console.log(
        'Item Master ID:',
        currentItemMasterId
    );


    if (!currentProjectItemId) {

        alert('Project Item ID is missing.');

        return;
    }


    $('#selectedItemName').text(itemName);

    $('#materialModal').modal('show');


    /*
     * Initialize material array for this
     * project_items.id
     */

    if (
        !jobOrderMaterials[currentProjectItemId]
    ) {

        jobOrderMaterials[currentProjectItemId] = [];

        loadExistingMaterials();

    }
    else {

        renderItemMaterials();

    }

});
var jobOrderMaterials = {};
var currentProjectItemId = null;
var currentItemMasterId = null;
$(document).on('click', '#saveRawMaterialBtn', function () {

    var materialSelect =
        $('#new_material_id');

    var unitSelect =  $('#new_material_unit');
    var materialOption =
        materialSelect.find(':selected');

    var unitOption =
        unitSelect.find(':selected');


    var materialId =
        materialSelect.val();

    var materialName =
        materialOption.data('name') ||
        materialOption.text();

    var materialCode =
        materialOption.data('code') || '';

    var unitId =
        unitSelect.val();

    var unit =
        unitOption.data('abbr') ||
        unitOption.text();

    var quantity =
        $('#new_material_qty').val();


    if (!materialId) {
        alert('Please select raw material.');
        return;
    }

    if (!unitId) {
        alert('Please select unit.');
        return;
    }

    if (!quantity || parseFloat(quantity) <= 0) {
        alert('Please enter quantity.');
        return;
    }


    /*
     * DO NOT EMPTY THE FIRST POPUP TABLE
     *
     * DO NOT reload BOM here.
     *
     * Just append the new material
     * to the existing array.
     */

    if (!jobOrderMaterials[currentProjectItemId]) {

        jobOrderMaterials[currentProjectItemId] = [];

    }


    jobOrderMaterials[currentProjectItemId].push({

        material_id: materialId,

        material_code: materialCode,

        material_name: materialName,

        unit_id: unitId,

        unit: unitId,

        quantity_required: quantity,

        cost: 0,

        source: 'MANUAL'

    });


    /*
     * Close second popup
     */

    $('#addRawMaterialModal').modal('hide');


    /*
     * Clear second popup form only
     */

    $('#addRawMaterialForm')[0].reset();


    /*
     * Re-render first popup.
     *
     * This renders:
     * Existing BOM + Newly Added Material
     */

    renderItemMaterials();

});

function renderManualMaterials()
{
    var tbody = $('#materialTable tbody');

    var materials = jobOrderMaterials[currentProjectItemId] || [];


    /*
     * Remove previously rendered MANUAL rows
     */
    tbody.find('tr.manual-material-row').remove();


    /*
     * Add saved manual materials
     */
    $.each(materials, function (index, material) {

        var row =
            '<tr class="manual-material-row">' +

                '<td>' +
                    $('<div>')
                        .text(material.material_code || '')
                        .html() +
                '</td>' +

                '<td>' +
                    $('<div>')
                        .text(material.material_name || '')
                        .html() +
                '</td>' +

                '<td>' +
                    material.quantity_required +
                '</td>' +

                '<td>' +
                    $('<div>')
                        .text(material.unit || '')
                        .html() +
                '</td>' +

                '<td>' +
                    '<span class="label label-warning">' +
                        'MANUAL' +
                    '</span>' +
                '</td>' +

            '</tr>';


        tbody.append(row);

    });
}

function loadUnits() {

    $.ajax({
        url: base_url + 'index.php/Production/get_units',
        type: 'GET',
        dataType: 'json',

        success: function (units) {

            var html = '<option value="">Select Unit</option>';

            $.each(units, function (i, unit) {

                html += '<option value="' + unit.unit_abbr + '">' +
                            unit.unit_name +
                            ' (' + unit.unit_abbr + ')' +
                        '</option>';
            });

            $('#new_material_unit').html(html);

        }
    });

}
function loadJobOrderMaterials() {

    var tbody = $('#materialTable tbody');

    tbody.html(
        '<tr>' +
        '<td colspan="5" class="text-center">' +
        'Loading...' +
        '</td>' +
        '</tr>'
    );


    // First load BOM materials
    $.ajax({

        url: base_url + 'index.php/Production/get_item_materials',

        type: 'POST',

        dataType: 'json',

        data: {
            item_master_id: currentItemMasterId
        },

        success: function (materials) {

            tbody.empty();


            // BOM materials
            if (materials && materials.length) {

                $.each(materials, function (i, material) {

                    appendMaterialRow(
                        material,
                        'BOM'
                    );

                });

            }


            // Manually added materials
            var manualMaterials =
                jobOrderMaterials[currentProjectItemId] || [];


            $.each(
                manualMaterials,
                function (i, material) {

                    appendMaterialRow(
                        material,
                        'MANUAL'
                    );

                }
            );


            // Nothing found
            if (
                (!materials || !materials.length) &&
                !manualMaterials.length
            ) {

                tbody.html(
                    '<tr>' +
                    '<td colspan="5" class="text-center">' +
                    'No raw materials added.' +
                    '</td>' +
                    '</tr>'
                );

            }

        }

    });

}
function appendMaterialRow(material, source) {

    var tbody = $('#materialTable tbody');

    var labelClass =
        source === 'BOM'
            ? 'label-info'
            : 'label-warning';


    tbody.append(

        '<tr>' +

        '<td>' +
        $('<div>')
            .text(material.material_code || '')
            .html() +
        '</td>' +

        '<td>' +
        $('<div>')
            .text(material.material_name || '')
            .html() +
        '</td>' +

        '<td>' +
        (material.quantity_required || 0) +
        '</td>' +

        '<td>' +
        $('<div>')
            .text(material.unit_abbr || '')
            .html() +
        '</td>' +

        '<td>' +

        '<span class="label ' +
        labelClass +
        '">' +

        source +

        '</span>' +

        '</td>' +

        '</tr>'

    );

}
$(document).on('click', '#saveJobOrderBtn', function () {

    var form = $('#jobOrderForm');

    var formData = form.serializeArray();

    // Add all project-item/material data
    formData.push({
        name: 'job_order_materials',
        value: JSON.stringify(jobOrderMaterials)
    });

    $.ajax({

        url: base_url + 'index.php/Production/save_job_order',

        type: 'POST',

        data: $.param(formData),

        dataType: 'json',

        beforeSend: function () {

            $('#saveJobOrderBtn')
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Saving...'
                );

        },

        success: function (response) {

            if (response.status) {

                alert(response.message);

                window.location.href =
                    base_url +
                    'index.php/Production/job_order';

            } else {

                alert(response.message);

            }

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert('Unable to save Job Order.');

        },

        complete: function () {

            $('#saveJobOrderBtn')
                .prop('disabled', false)
                .html(
                    '<i class="fa fa-save"></i> Save Job Order'
                );

        }

    });

});
function loadBOMMaterials()
{
    $.ajax({

        url: base_url + 'index.php/Production/get_item_materials',

        type: 'POST',

        data: {
            item_master_id: currentItemMasterId
        },

        dataType: 'json',

        success: function(materials) {

            if (!jobOrderMaterials[currentProjectItemId]) {

                jobOrderMaterials[currentProjectItemId] = [];

            }


            $.each(materials, function(i, material) {

                jobOrderMaterials[currentProjectItemId].push({

                    material_id:
                        material.material_id,

                    material_code:
                        material.material_code,

                    material_name:
                        material.material_name,

                    unit_id:
                        material.unit_id || null,

                    unit:
                        material.unit || '',

                    quantity_required:
                        material.quantity_required,

                    cost:
                        material.cost || 0,

                    source:
                        'BOM'

                });

            });

        }

    });
}
if (!jobOrderMaterials[currentProjectItemId]) {

    jobOrderMaterials[currentProjectItemId] = [];

    loadBOMMaterials();

}
function renderItemMaterials()
{
    var tbody = $('#materialTable tbody');

    tbody.empty();

    var materials =
        jobOrderMaterials[currentProjectItemId] || [];


    if (materials.length === 0) {

        tbody.html(
            '<tr>' +
            '<td colspan="5" class="text-center">' +
            'No raw materials found' +
            '</td>' +
            '</tr>'
        );

        return;
    }


    $.each(materials, function(index, material) {

        tbody.append(

            '<tr>' +

                '<td>' +
                    $('<div>')
                        .text(material.material_code || '')
                        .html() +
                '</td>' +

                '<td>' +
                    $('<div>')
                        .text(material.material_name || '')
                        .html() +
                '</td>' +

                '<td>' +
                    material.quantity_required +
                '</td>' +

                '<td>' +
                    $('<div>')
                        .text(material.unit || '')
                        .html() +
                '</td>' +

                '<td>' +

                    '<span class="label ' +
                    (
                        material.source === 'BOM'
                        ? 'label-info'
                        : 'label-warning'
                    ) +
                    '">' +

                    material.source +

                    '</span>' +

                '</td>' +

            '</tr>'

        );

    });
}
$(document).on('click', '#saveItemMaterialsBtn', function () {

    /*
     * Get project_item_id from popup
     */

var projectItemId = window.activeProjectItemId || currentProjectItemId;

if (!projectItemId) {
    alert('Project Item ID is missing.2');
    return;
}

                                /*
    if (!projectItemId) {

        alert('Project Item ID is missing.2');

        return;
    }

                                */
    /*
     * Make sure global variable is also updated
     */

    currentProjectItemId =  projectItemId;
    var materials = jobOrderMaterials[projectItemId] || [];
    if (materials.length === 0) {

        alert(
            'Please add at least one raw material.'
        );

        return;
    }
     $('#materialModal').modal('hide');

    /*$.ajax({

        url:
            base_url +
            'index.php/Production/save_job_order_item_materials',

        type: 'POST',

        dataType: 'json',

        data: {

            project_item_id:
                projectItemId,

            job_order_id:
                $('#job_order_id').val(),

            materials:
                JSON.stringify(materials)

        },

        beforeSend: function() {

            $('#saveItemMaterialsBtn')
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Saving...'
                );

        },

        success: function(response) {

            console.log(
                'Save response:',
                response
            );


            if (response.status) {

                alert(
                    'Raw materials saved successfully.'
                );


                jobOrderMaterialsSaved[
                    projectItemId
                ] = true;


                $('#materialModal').modal('hide');

            }
            else {

                alert(
                    response.message ||
                    'Unable to save materials.'
                );

            }

        },

        error: function(xhr) {

            console.log(
                'AJAX ERROR:',
                xhr.responseText
            );

            alert(
                'Unable to save raw materials.'
            );

        },

        complete: function() {

            $('#saveItemMaterialsBtn')
                .prop('disabled', false)
                .html(
                    '<i class="fa fa-save"></i> Save Materials'
                );

        }

    });*/

});

function loadExistingMaterials()
{
    $.ajax({

        url:
            base_url +
            'index.php/Production/get_item_materials',

        type: 'POST',

        dataType: 'json',

        data: {
            item_master_id:
                currentItemMasterId
        },

        success: function(materials) {

            var list =
                jobOrderMaterials[currentProjectItemId];


            $.each(materials, function(i, material) {

                list.push({

                    material_id:
                        material.material_id,

                    material_code:
                        material.material_code || '',

                    material_name:
                        material.material_name || '',

                    unit_id:
                        material.unit || null,

                    unit:
                        material.unit_abbr || '',

                    quantity_required:
                        material.quantity_required || 0,

                    cost:
                        material.cost || 0,

                    source: 'BOM'

                });

            });


            renderItemMaterials();

        },

        error: function(xhr) {

            console.log(
                xhr.responseText
            );

        }

    });
}

</script>