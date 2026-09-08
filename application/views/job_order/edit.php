<link href="<?php echo base_url()."public/build/css/popup.css"; ?>" rel="stylesheet">
<style>
.center {
  display: flex;
  justify-content: center;
  align-items: center;
}
#materialTable{
    width:100% !important;
}
</style>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">


                <form id="jobOrderEditForm">

                    <input type="hidden" id="job_order_id" name="job_order_id" value="<?= $job_order->job_order_id ?>">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                   <label>
                                        Job Order No
                                    </label>
                                    <input type="text" class="form-control" value="<?= $job_order->job_order_no ?>" readonly>

                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                   <label>
                                        Order No
                                    </label>
                                    <input type="text" class="form-control" value="<?= $job_order->order_no ?>" readonly>

                                </div>

                            </div>
                            <div class="col-md-3">

                                <div class="form-group">

                                    <label>
                                       Job Order Date
                                    </label>

                                    <input type="text"
                                           class="form-control" id="order_date"
                                           value="<?= date('Y-m-d', strtotime($job_order->order_date)) ?>"
                                           readonly>

                                </div>

                            </div>
                            <div class="col-md-3">
                                <a href="<?= base_url('index.php/Production/print_job_order/' .$job_order->job_order_id) ?>" target="_blank" class="btn btn-default center">
                                <i class="fa fa-print"></i> Print</a>
                            </div>

<div class="col-md-8">
<div class="project-info-card">

    <div class="project-info-header">
        <i class="fa fa-folder-open"></i>
        <span>Project Information</span><br>
    </div>

    <div class="project-info-body">

        <div class="row">

            <div class="col-md-3">
                <div class="project-info-item"> 
                    <label>Project Name</label>
                    <div id="manager_id" class="project-info-value"><?php echo $project[0]['project_name'] ?? ''; ?> <?php echo $project['project_code'] ??'';?></div>
                </div></div>
            <div class="col-md-3">
                <div class="project-info-item">
                    <label>Project Start Date</label>
                    <div id="sdate" class="project-info-value"><?=$project[0]['start_date']?? ''?></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="project-info-item">
                    <label>Project End Date</label>
                    <div id="edate" class="project-info-value"><?=$project[0]['end_date']?? '';?></div>
                </div>
            </div>

            
            
                <div class="col-md-3">
                <div class="project-info-item">
                    <label>Customer</label>
                    <div id="customer_id" class="project-info-value"><?=$project[0]['customer_name']?? '';?></div>
                </div>
            </div>

        </div>

        </div>
</div>

</div><div class="col-md-4"></div>
                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>
                                        Contact Person
                                    </label>

                                    <input type="text"class="form-control" value="<?= htmlspecialchars($job_order->contact_person) ?>" id="conatct_person"  name="conatct_person">

                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="form-group">

                                    <label>
                                        Representative
                                    </label>

                                    <input type="text"  class="form-control" id="rep_name"  value="<?= htmlspecialchars($job_order->rep_name) ?>">

                                </div>

                            </div>
                            <div class="col-md-4"></div>
                             <div class="col-md-4">

                        <label>Start Date</label>

                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($job_order->start_date)) ?>" required>

                    </div>


                    <div class="col-md-4">

                        <label>Finish Date</label>

                        <input type="date" name="finish_date" id="finish_date" class="form-control"  value="<?= date('Y-m-d', strtotime($job_order->finish_date)) ?>" required>

                    </div><div class="col-md-4"></div>
                    <div class="col-md-8">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control" id="remarks" rows="3"><?= htmlspecialchars($job_order->remarks) ?></textarea>
                    </div>
                        </div>


                        <hr>


                        <h5>
                            Job Order Items
                        </h5>


                        <div class="table-responsive">

                            <table class="table table-bordered table-hover">

                                <thead>

                                    <tr>

                                        <th width="50">
                                            #
                                        </th>

                                        <th width="200">
                                            Item
                                        </th>

                                        <th width="100">
                                            Quantity
                                        </th>

                                        <th width="120">
                                            Unit Price
                                        </th>

                                        <th width="120">
                                            Total
                                        </th>

                                        <th width="130">
                                            Materials
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                <?php if (!empty($job_order_items)): ?>

                                    <?php foreach (
                                        $job_order_items
                                        as $index => $item
                                    ): ?>

                                        <tr>

                                            <td>
                                                <?= $index + 1 ?>
                                            </td>


                                            <td>

                                                <?= htmlspecialchars(
                                                    $item->product_name
                                                ) ?>

                                            </td>


                                            <td>

                                                <?= (int)$item->quantity ?>

                                            </td>


                                            <td>

                                                <?= $item->cost ?>

                                            </td>


                                            <td>

                                                <?php echo $item->cost*(int)$item->quantity; ?>

                                            </td>


                                            <td>

                                                <button
                                                    type="button"
                                                    class="btn btn-xs btn-info material-btn"

                                                    data-job-order-item-id="<?= $item->job_order_item_id ?>"

                                                    data-project-item-id="<?= $item->project_item_id ?>"

                                                    data-item-master="<?= $item->product_id ?>"

                                                    data-item-name="<?= htmlspecialchars($item->product_name) ?>">

                                                    <i class="fa fa-cubes"></i>

                                                    Materials

                                                </button>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>

                                        <td colspan="6"
                                            class="text-center">

                                            No items found.

                                        </td>

                                    </tr>

                                <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    <div class="box-footer">

                        <button type="button"
                                class="btn btn-primary"
                                id="saveJobOrder">

                            <i class="fa fa-save"></i>

                            Save Job Order

                        </button>

                        <a href="<?= base_url('index.php/Production/job_order') ?>"
                           class="btn btn-default">

                            Cancel

                        </a>

                    </div>

                </form>

          </div>

    </div>

</div>

<div class="modal fade" id="materialModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
    

                <h4 class="modal-title">

                    Raw Materials -
                    <span id="selectedItemName"></span>

                </h4>
                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    &times;

                </button>

            </div>


            <div class="modal-body">

                <input type="hidden"
                       id="currentJobOrderItemId">

                <input type="hidden"
                       id="currentProjectItemId">


                <button type="button"
                        class="btn btn-primary btn-sm"
                        id="addMaterialBtn">

                    <i class="fa fa-plus"></i>

                    Add Raw Material

                </button>


                <br><br>


                <div class="table-responsive">

                    <table class="table table-bordered"
                           id="materialTable">

                        <thead>

                            <tr>

                                <th>
                                    Material Code
                                </th>

                                <th>
                                    Material
                                </th>

                                <th width="100">
                                    Quantity
                                </th>

                                <th width="100">
                                    Unit
                                </th>

                                <th width="100">
                                    Source
                                </th>

                                <th width="80">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody></tbody>

                    </table>

                </div>

            </div>


            <div class="modal-footer">

                <button type="button"
                        class="btn btn-default"
                        data-dismiss="modal">

                    Close

                </button>


                <button type="button"
                        class="btn btn-primary"
                        id="saveItemMaterialsBtn">

                    <i class="fa fa-save"></i>

                    Save Materials

                </button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="addRawMaterialModal">

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
                        </label>

                        <select
                            id="new_material_id"
                            class="form-control">

                            <option value="">
                                Select Material
                            </option>

                            <?php foreach (
                                $raw_materials
                                as $material
                            ): ?>

                                <option
                                    value="<?= $material->material_id ?>"
                                    data-code="<?= htmlspecialchars($material->material_code) ?>"
                                    data-name="<?= htmlspecialchars($material->material_name) ?>">

                                    <?= htmlspecialchars(
                                        $material->material_name
                                    ) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Unit
                        </label>

                        <select
                            id="new_material_unit"
                            class="form-control">

                            <option value="">
                                Select Unit
                            </option>

                            <?php foreach (
                                $units
                                as $unit
                            ): ?>

                                <option
                                    value="<?= $unit->unit_id ?>"
                                    data-abbr="<?= htmlspecialchars($unit->unit_abbr) ?>">

                                    <?= htmlspecialchars(
                                        $unit->unit_name
                                    ) ?>

                                    (<?= htmlspecialchars(
                                        $unit->unit_abbr
                                    ) ?>)

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Quantity
                        </label>

                        <input type="number"
                               step="0.01"
                               min="0"
                               id="new_material_qty"
                               class="form-control">

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

                    <i class="fa fa-plus"></i>

                    Add

                </button>

            </div>

        </div>

    </div>

</div>
<script>
var base_url = "<?= base_url(); ?>";
var jobOrderMaterials = {};

var currentJobOrderItemId = null;

var currentProjectItemId = null;

var currentItemMasterId = null;


<?php foreach ($job_order_items as $item): ?>

jobOrderMaterials[
    <?= $item->project_item_id ?>
] = <?= json_encode($item->materials) ?>;

<?php endforeach; ?>
$(document).on( 'click', '.material-btn',function () {

        currentJobOrderItemId =
            $(this).attr(
                'data-job-order-item-id'
            );

        currentProjectItemId =
            $(this).attr(
                'data-project-item-id'
            );

        currentItemMasterId =
            $(this).attr(
                'data-item-master'
            );


        var itemName =
            $(this).attr(
                'data-item-name'
            );


        console.log(
            'Job Order Item:',
            currentJobOrderItemId
        );

        console.log(
            'Project Item:',
            currentProjectItemId
        );


        $('#selectedItemName')
            .text(itemName);


        $('#currentJobOrderItemId')
            .val(currentJobOrderItemId);


        $('#currentProjectItemId')
            .val(currentProjectItemId);


        renderItemMaterials();


        $('#materialModal')
            .modal('show');

    }
);

function renderItemMaterials()
{
    var tbody =
        $('#materialTable tbody');

    tbody.empty();


    var materials =
        jobOrderMaterials[
            currentProjectItemId
        ] || [];


    if (materials.length === 0) {

        tbody.html(

            '<tr>' +

                '<td colspan="6" ' +
                    'class="text-center">' +

                    'No raw materials found.' +

                '</td>' +

            '</tr>'

        );

        return;
    }


    $.each(
        materials,
        function(index, material) {

            tbody.append(

                '<tr>' +

                    '<td>' +

                        $('<div>')
                            .text(
                                material.material_code || ''
                            )
                            .html() +

                    '</td>' +


                    '<td>' +

                        $('<div>')
                            .text(
                                material.material_name || ''
                            )
                            .html() +

                    '</td>' +


                    '<td>' +

                        '<input type="number" ' +

                        'class="form-control input-sm material-qty" ' +

                        'data-index="' +
                        index +
                        '" ' +

                        'value="' +
                        (
                            material.quantity_required || 0
                        ) +
                        '">' +

                    '</td>' +


                    '<td>' +

                        $('<div>')
                            .text(
                                material.unit || ''
                            )
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

                            (
                                material.source || 'BOM'
                            ) +

                        '</span>' +

                    '</td>' +


                    '<td>' +

                        '<button type="button" ' +

                        'class="btn btn-xs btn-danger delete-material" ' +

                        'data-index="' +
                        index +
                        '">' +

                            '<i class="fa fa-trash"></i>' +

                        '</button>' +

                    '</td>' +

                '</tr>'

            );

        }
    );
}
$(document).on('click','#addMaterialBtn', function () {

        $('#addRawMaterialForm')[0]
            .reset();

        $('#addRawMaterialModal')
            .modal('show');

    }
);

$(document).on('click', '#saveRawMaterialBtn',function () {

        var materialOption =
            $('#new_material_id')
                .find(':selected');

        var unitOption =
            $('#new_material_unit')
                .find(':selected');


        var materialId =
            $('#new_material_id').val();

        var unitId =
            $('#new_material_unit').val();

        var quantity =
            $('#new_material_qty').val();


        if (!materialId) {

            alert(
                'Please select raw material.'
            );

            return;
        }


        if (!unitId) {

            alert(
                'Please select unit.'
            );

            return;
        }


        if (
            !quantity ||
            parseFloat(quantity) <= 0
        ) {

            alert(
                'Please enter quantity.'
            );

            return;
        }


        var material = {

            job_order_material_id:
                null,

            job_order_item_id:
                currentJobOrderItemId,

            project_item_id:
                currentProjectItemId,

            material_id:
                materialId,

            material_code:
                materialOption.data('code'),

            material_name:
                materialOption.data('name'),

            quantity_required:
                quantity,

            unit:
                unitOption.data('abbr'),

            cost:
                0,

            source:
                'MANUAL'

        };


        /*
         * Append new material
         */

        if (
            !jobOrderMaterials[
                currentProjectItemId
            ]
        ) {

            jobOrderMaterials[
                currentProjectItemId
            ] = [];

        }


        jobOrderMaterials[
            currentProjectItemId
        ].push(material);


        /*
         * Close second popup
         */

        $('#addRawMaterialModal')
            .modal('hide');


        /*
         * Refresh first popup
         */

        renderItemMaterials();

    }
);
$(document).on('change','.material-qty',function () {

        var index =
            $(this).data('index');

        var quantity =
            $(this).val();


        jobOrderMaterials[
            currentProjectItemId
        ][index].quantity_required =
            quantity;

    }
);
$(document).on( 'click','.delete-material',function () {

        var index =
            $(this).data('index');


        if (
            !confirm(
                'Remove this raw material?'
            )
        ) {

            return;
        }


        jobOrderMaterials[
            currentProjectItemId
        ].splice(index, 1);


        renderItemMaterials();

    }
);

$(document).on('click', '.delete-material', function () {

        var index =
            $(this).data('index');


        if (
            !confirm(
                'Remove this raw material?'
            )
        ) {

            return;
        }


        jobOrderMaterials[
            currentProjectItemId
        ].splice(index, 1);


        renderItemMaterials();

    }
);

$(document).on('click', '#saveItemMaterialsBtn',function () {

        var projectItemId =
            currentProjectItemId;

        var jobOrderItemId =
            currentJobOrderItemId;


        if (!projectItemId) {

            alert(
                'Project Item ID is missing.'
            );

            return;
        }


        var materials =
            jobOrderMaterials[
                projectItemId
            ] || [];


        if (materials.length === 0) {

            alert(
                'Please add at least one raw material.'
            );

            return;
        }


        $.ajax({

            url:
                base_url +
                'index.php/Production/save_job_order_item_materialse',

            type: 'POST',

            dataType: 'json',

            data: {

                job_order_item_id:
                    jobOrderItemId,

                project_item_id:
                    projectItemId,

                materials:
                    JSON.stringify(materials)

            },

            beforeSend: function () {

                $('#saveItemMaterialsBtn')
                    .prop(
                        'disabled',
                        true
                    )
                    .html(
                        '<i class="fa fa-spinner fa-spin"></i> Saving...'
                    );

            },

            success: function (response) {

                if (response.status) {

                    alert(
                        'Raw materials saved successfully.'
                    );

                    $('#materialModal')
                        .modal('hide');

                }
                else {

                    alert(
                        response.message
                    );

                }

            },

            error: function (xhr) {

                console.log(
                    xhr.responseText
                );

                alert(
                    'Unable to save raw materials.'
                );

            },

            complete: function () {

                $('#saveItemMaterialsBtn')
                    .prop(
                        'disabled',
                        false
                    )
                    .html(
                        '<i class="fa fa-save"></i> Save Materials'
                    );

            }

        });

    }
);

$(document).on('click', '#saveJobOrder', function () {

    var jobOrderId = $('#job_order_id').val();

    if (!jobOrderId) {
        alert('Job Order ID is missing.');
        return;
    }

    var data = {

        job_order_id: jobOrderId,

        order_date:
            $('#order_date').val(),

        rep_name:
            $('#rep_name').val(),

        contact_person:$('#conatct_person').val(),

        start_date:
            $('#start_date').val(),

        finish_date:
            $('#finish_date').val(),

        remarks:
            $('#remarks').val()
    };


    $.ajax({

        url: base_url +'index.php/Production/update',

        type: 'POST',

        dataType: 'json',

        data: data,

        beforeSend: function () {

            $('#saveJobOrder')
                .prop('disabled', true)
                .html(
                    '<i class="fa fa-spinner fa-spin"></i> Saving...'
                );
        },

        success: function (response) {

            if (response.status) {

                alert(
                    response.message ||
                    'Job Order updated successfully.'
                );

                /*
                 * Optional:
                 * redirect to listing
                 */

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
                'Unable to update Job Order.'
            );
        },

        complete: function () {

            $('#saveJobOrder')
                .prop('disabled', false)
                .html(
                    '<i class="fa fa-save"></i> Save Job Order'
                );
        }

    });

});
</script>