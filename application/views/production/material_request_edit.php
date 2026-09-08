<div class="row">

    <div class="col-md-12">

        <div class="x_panel">

            <div class="x_title">

                <h2>
                    Edit Material Request
                </h2>

                <a href="<?= base_url(
                    'index.php/Production/material_requests'
                ) ?>"
                   class="btn btn-default btn-sm pull-right">

                    <i class="fa fa-arrow-left"></i>
                    Back

                </a>

                <div class="clearfix"></div>

            </div>


            <div class="x_content">

                <!-- =====================================================
                     REQUEST ID
                ====================================================== -->

                <input
                    type="hidden"
                    id="request_id"
                    value="<?= (int)$request->production_material_request_id ?>"
                >


                <!-- =====================================================
                     REQUEST HEADER
                ====================================================== -->

                <div class="row">

                    <!-- Material Request No -->

                    <div class="col-md-3">

                        <label>
                            Material Request No.
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars(
                                $request->material_request_no ?? ''
                            ) ?>"
                            readonly
                        >

                    </div>


                    <!-- Job Order -->

                    <div class="col-md-3">

                        <label>
                            Job Order
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars(
                                $request->job_order_no ?? ''
                            ) ?>"
                            readonly
                        >

                    </div>


                    <!-- Project -->

                    <div class="col-md-3">

                        <label>
                            Project
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars(
                                $request->project_name ?? ''
                            ) ?>"
                            readonly
                        >

                    </div>


                    <!-- Request Date -->

                    <div class="col-md-3">

                        <label>
                            Request Date
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="request_date"
                            value="<?= !empty($request->request_date)
                                ? date(
                                    'Y-m-d',
                                    strtotime($request->request_date)
                                )
                                : '' ?>"
                        >

                    </div>

                </div>


                <br>



                <div class="panel panel-default">

                    <div class="panel-heading">

                        <strong>
                            Requested Materials
                        </strong>

                    </div>


                    <div class="panel-body">

                        <div class="table-responsive">

                            <table
                                class="table table-bordered table-striped"
                                id="materialRequestTable"
                            >

                                <thead>

                                    <tr>

                                        <th width="40">
                                            #
                                        </th>

                                        <th>
                                            Product
                                        </th>

                                        <th>
                                            Material
                                        </th>

                                        <th>
                                            Required Qty
                                        </th>

                                        <th>
                                            Already Requested
                                        </th>

                                        <th>
                                            Request Qty
                                        </th>

                                        <th>
                                            Remaining Qty
                                        </th>

                                        <th>
                                            Unit
                                        </th>

                                        <th>
                                            Unit Cost
                                        </th>

                                        <th>
                                            Total Cost
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                <?php
                                //echo "<pre>";print_r($items);
                                foreach (
                                    $items as $index => $item
                                ): ?>

                                    <?php

                                    $required_quantity =
                                        isset($item->required_quantity)
                                            ? (float)$item->required_quantity
                                            : 0;


                                    

                                    $already_requested =
                                        isset($item->previously_requested)
                                            ? (float)$item->previously_requested
                                            : 0;
                                   

                                    $current_request_quantity =
                                        isset($item->request_quantity)
                                            ? (float)$item->request_quantity
                                            : 0;



                                    $remaining_quantity =
                                        $required_quantity
                                        - $already_requested
                                        - $current_request_quantity;


                                    if ($remaining_quantity < 0) {
                                        $remaining_quantity = 0;
                                    }


                                    $available_quantity =
                                        $required_quantity
                                        - $already_requested;


                                    if ($available_quantity < 0) {
                                        $available_quantity = 0;
                                    }


                                   
                                    $unit_cost =
                                        isset($item->unit_cost)
                                            ? (float)$item->unit_cost
                                            : 0;


                                    $total_cost =
                                        $current_request_quantity
                                        * $unit_cost;

                                    $remaining_quantity1 = (float)$item->remaining_quantity1;

                                    ?>


                                    <tr>

                                        <td>

                                            <?= $index + 1 ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $item->product_name ?? ''
                                            ) ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $item->material_name ?? ''
                                            ) ?>

                                        </td>


                                        <td class="required-qty">

                                            <?= number_format(
                                                $required_quantity,
                                                2
                                            ) ?>

                                        </td>



                                        <td class="already-requested">

                                            <?= number_format(
                                                $already_requested,
                                                2
                                            ) ?>

                                        </td>


                                        <td width="140">

                                            <input
                                                type="number"
                                                class="form-control request-qty"

                                                value="<?= number_format(
                                                    $remaining_quantity1,
                                                    2,
                                                    '.',
                                                    ''
                                                ) ?>"

                                                min="0"

                                                max="<?= number_format(
                                                    $available_quantity,
                                                    2,
                                                    '.',
                                                    ''
                                                ) ?>"

                                                data-available="<?= number_format(
                                                    $available_quantity,
                                                    2,
                                                    '.',
                                                    ''
                                                ) ?>"

                                                data-already-requested="<?= number_format(
                                                    $already_requested,
                                                    2,
                                                    '.',
                                                    ''
                                                ) ?>"

                                                data-original-request="<?= number_format(
                                                    $remaining_quantity1,
                                                    2,
                                                    '.',
                                                    ''
                                                ) ?>"

                                                step="0.01"

                                                <?= (
                                                    $available_quantity <= 0
                                                )
                                                    ? 'readonly'
                                                    : '' ?>
                                            >

                                        </td>

                                        <td class="remaining-qty">

                                            <?= number_format(
                                                $remaining_quantity,
                                                2
                                            ) ?>

                                        </td>


                                        <td>

                                            <?= htmlspecialchars(
                                                $item->unit ?? ''
                                            ) ?>

                                        </td>


                                        <td>

                                            <?= number_format(
                                                $unit_cost,
                                                2
                                            ) ?>

                                            <input
                                                type="hidden"
                                                class="unit-cost"
                                                value="<?= $unit_cost ?>"
                                            >

                                        </td>


                                        <td class="total-cost">

                                            <?= number_format(
                                                $already_requested*$unit_cost,
                                                2
                                            ) ?>

                                        </td>


                                        <input
                                            type="hidden"
                                            class="request-item-id"
                                            value="<?= (int)$item->production_material_request_item_id ?>"
                                        >


                                    </tr>


                                <?php endforeach; ?>

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <th
                                            colspan="9"
                                            class="text-right"
                                        >
                                            Grand Total
                                        </th>

                                        <th id="grandTotal">
                                            0.00
                                        </th>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Remarks
                    </label>

                    <textarea
                        id="remarks"
                        class="form-control"
                        rows="3"
                    ><?= htmlspecialchars(
                        $request->remarks ?? ''
                    ) ?></textarea>

                </div>


                <div class="text-right">

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="updateMaterialRequest"
                    >

                        <i class="fa fa-save"></i>

                        Update Material Request

                    </button>

                </div>


            </div>

        </div>

    </div>

</div>


<script>

var base_url = "<?= base_url() ?>";


function calculateMaterialRequestRow(row)
{

    /*
     * Required
     */

    var requiredQty =
        parseFloat(
            row.find('.required-qty').text()
        ) || 0;


    var alreadyRequested =
        parseFloat(
            row.find('.already-requested').text()
        ) || 0;

    var requestInput =
        row.find('.request-qty');


    var requestQty =
        parseFloat(
            requestInput.val()
        ) || 0;

    var availableQty =
        requiredQty
        - alreadyRequested;


    if (availableQty < 0) {

        availableQty = 0;

    }

    if (requestQty < 0) {

        requestQty = 0;

        requestInput.val('0.00');

    }


    if (requestQty > availableQty) {

        alert(
            'Request quantity cannot exceed '
            + availableQty.toFixed(2)
        );

        requestQty = availableQty;

        requestInput.val(
            requestQty.toFixed(2)
        );

    }


    var remainingQty =
        requiredQty
        - alreadyRequested
        - requestQty;


    if (remainingQty < 0) {

        remainingQty = 0;

    }


    /*
     * Display Remaining
     */

    row.find('.remaining-qty')
        .text(
            remainingQty.toFixed(2)
        );



    var unitCost =
        parseFloat(
            row.find('.unit-cost').val()
        ) || 0;


    

    var totalCost =
        alreadyRequested
        * unitCost;


    row.find('.total-cost')
        .text(
            totalCost.toFixed(2)
        );

}



$(document).on(
    'input',
    '.request-qty',
    function () {

        calculateMaterialRequestRow(
            $(this).closest('tr')
        );

        calculateMaterialRequestTotal();

    }
);


/*
 * ============================================================
 * Grand Total
 * ============================================================
 */

function calculateMaterialRequestTotal()
{

    var grandTotal = 0;


    $('#materialRequestTable tbody tr')
        .each(function () {

            var row = $(this);


            var requestQty =
                parseFloat(
                    row.find('.request-qty').val()
                ) || 0;


            var unitCost =
                parseFloat(
                    row.find('.unit-cost').val()
                ) || 0;


            var totalCost =
                requestQty
                * unitCost;


            row.find('.total-cost')
                .text(
                    totalCost.toFixed(2)
                );


            grandTotal += totalCost;

        });


    $('#grandTotal')
        .text(
            grandTotal.toFixed(2)
        );

}


/*
 * ============================================================
 * Update Material Request
 * ============================================================
 */

$(document).on(
    'click',
    '#updateMaterialRequest',
    function () {

        var requestId =
            $('#request_id').val();


        var items = [];


        var invalid = false;


        /*
         * =====================================================
         * Read table rows
         * =====================================================
         */

        $('#materialRequestTable tbody tr')
            .each(function () {

                var row = $(this);


                /*
                 * Request item ID
                 */

                var itemId =
                    row.find(
                        '.request-item-id'
                    ).val();


                if (!itemId) {

                    return;

                }


                /*
                 * Request quantity
                 */

                var requestInput =
                    row.find(
                        '.request-qty'
                    );


                var requestQty =
                    parseFloat(
                        requestInput.val()
                    ) || 0;


                /*
                 * Available quantity
                 */

                var availableQty =
                    parseFloat(
                        requestInput.attr(
                            'data-available'
                        )
                    ) || 0;


                /*
                 * Unit cost
                 */

                var unitCost =
                    parseFloat(
                        row.find(
                            '.unit-cost'
                        ).val()
                    ) || 0;


                /*
                 * =================================================
                 * Validation
                 * =================================================
                 */

                if (
                    requestQty < 0 ||
                    requestQty > availableQty
                ) {

                    invalid = true;

                    return false;

                }


                /*
                 * =================================================
                 * Add item
                 * =================================================
                 */

                items.push({

                    production_material_request_item_id:
                        itemId,

                    request_quantity:
                        requestQty,

                    unit_cost:
                        unitCost

                });

            });


        /*
         * =====================================================
         * Invalid quantity
         * =====================================================
         */

        if (invalid) {

            alert(
                'Please check the requested quantities.'
            );

            return;

        }


        /*
         * =====================================================
         * AJAX
         * =====================================================
         */

        $.ajax({

            url:
                base_url +
                'index.php/Production/update_material_request',

            type:
                'POST',

            dataType:
                'json',

            data: {

                request_id:
                    requestId,

                request_date:
                    $('#request_date').val(),

                remarks:
                    $('#remarks').val(),

                items:
                    JSON.stringify(items)

            },


            beforeSend: function () {

                $('#updateMaterialRequest')
                    .prop(
                        'disabled',
                        true
                    )
                    .html(
                        '<i class="fa fa-spinner fa-spin"></i> Updating...'
                    );

            },


            success: function (response) {

                if (response.status) {

                    alert(
                        response.message
                    );


                    window.location.href =
                        base_url +
                        'index.php/Production/material_requests';

                }
                else {

                    alert(
                        response.message ||
                        'Unable to update Material Request.'
                    );

                }

            },


            error: function (xhr) {

                console.log(
                    xhr.responseText
                );


                alert(
                    'Unable to update Material Request.'
                );

            },


            complete: function () {

                $('#updateMaterialRequest')
                    .prop(
                        'disabled',
                        false
                    )
                    .html(
                        '<i class="fa fa-save"></i> Update Material Request'
                    );

            }

        });

    }
);


/*
 * ============================================================
 * Initial Total
 * ============================================================
 */

$(document).ready(function () {

    /*
     * Calculate each row first
     */

    $('#materialRequestTable tbody tr')
        .each(function () {

            calculateMaterialRequestRow(
                $(this)
            );

        });


    /*
     * Calculate grand total
     */

    calculateMaterialRequestTotal();

});

</script>