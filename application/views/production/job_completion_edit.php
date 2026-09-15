<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12">

        <div class="x_panel">

            <div class="x_title">

                <h3 class="box-title">
                    Job Completion Details
                </h3>

                <div class="clearfix"></div>

            </div>


            <div class="x_content">

                <input
                    type="hidden"
                    id="job_completion_id"
                    value="<?= $completion->job_completion_id ?>"
                >


                <!-- ===================================================== -->
                <!-- HEADER -->
                <!-- ===================================================== -->

                <div class="row">

                    <div class="col-md-3">

                        <label>
                            Job Completion No
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars(
                                $completion->job_completion_no
                            ) ?>"
                            readonly
                        >

                    </div>


                    <div class="col-md-3">

                        <label>
                            Job Order No
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars(
                                $completion->job_order_no
                            ) ?>"
                            readonly
                        >

                    </div>


                    <div class="col-md-3">

                        <label>
                            Project
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars(
                                $completion->project_name ?? ''
                            ) ?>"
                            readonly
                        >

                    </div>


                    <div class="col-md-3">

                        <label>
                            Completion Date
                        </label>

                        <input
                            type="date"
                            id="completion_date"
                            class="form-control"
                            value="<?=
                                !empty($completion->completion_date)
                                ? date(
                                    'Y-m-d',
                                    strtotime(
                                        $completion->completion_date
                                    )
                                )
                                : ''
                            ?>"
                        >

                    </div>

                </div>


                <br>


                <!-- ===================================================== -->
                <!-- REMARKS -->
                <!-- ===================================================== -->

                <div class="form-group">

                    <label>
                        Remarks
                    </label>

                    <textarea
                        id="remarks"
                        class="form-control"
                        rows="3"
                    ><?= htmlspecialchars(
                        $completion->remarks ?? ''
                    ) ?></textarea>

                </div>


                <hr>


                <!-- ===================================================== -->
                <!-- COMPLETED ITEMS HEADER -->
                <!-- ===================================================== -->

                <div class="row">

                    <div class="col-md-6">

                        <h4>
                            Completed Items
                        </h4>

                    </div>


                    <div class="col-md-6 text-right">

                        <button
                            type="button"
                            class="btn btn-primary btn-sm"
                            id="addRemainingItemsBtn"
                        >

                            <i class="fa fa-plus"></i>

                            Add Completed Item

                        </button>

                    </div>

                </div>


                <br>


                <!-- ===================================================== -->
                <!-- COMPLETION ITEMS TABLE -->
                <!-- ===================================================== -->

                <div class="table-responsive">

                    <table
                        class="table table-bordered"
                        id="completionItemsTable"
                    >

                        <thead>

                            <tr>

                                <th width="50">
                                    #
                                </th>

                                <th>
                                    Item
                                </th>

                                <th>
                                    Ordered Qty
                                </th>

                                <th>
                                    Previous Completed Qty
                                </th>

                                <th width="150">
                                    Completed Qty
                                </th>

                                <th>
                                    Remaining Qty
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php if (!empty($items)): ?>

                            <?php foreach (
                                $items as $index => $item
                            ): ?>

                                <?php

                                /*
                                 * -------------------------------------------------
                                 * IMPORTANT EDIT LOGIC
                                 * -------------------------------------------------
                                 *
                                 * ordered_quantity
                                 *     = Job Order quantity
                                 *
                                 * previously_completed
                                 *     = Completed quantity BEFORE this
                                 *       current Job Completion
                                 *
                                 * completed_quantity
                                 *     = Quantity saved in THIS Job Completion
                                 *
                                 * For edit:
                                 *
                                 * Displayed Previous Completed =
                                 *     previously_completed
                                 *     +
                                 *     completed_quantity
                                 *
                                 * New textbox =
                                 *     0
                                 *
                                 * New available quantity =
                                 *     ordered
                                 *     -
                                 *     displayed previous completed
                                 *
                                 */

                                $orderedQty =
                                    (float) $item->ordered_quantity;

                                $oldPreviousCompleted =
                                    (float) $item->previously_completed;

                                $oldCurrentCompleted =
                                    (float) $item->completed_quantity;


                                /*
                                 * Existing current completion is moved
                                 * into Previous Completed Qty for display.
                                 */
                                $displayPreviousCompleted =
                                    $oldPreviousCompleted
                                    +
                                    $oldCurrentCompleted;


                                /*
                                 * Quantity still available for a NEW
                                 * completion quantity during this edit.
                                 */
                                $availableQty =
                                    max(
                                        0,
                                        $orderedQty
                                        -
                                        $displayPreviousCompleted
                                    );


                                /*
                                 * New completion quantity starts at ZERO.
                                 */
                                $newCompletedQty = 0;


                                /*
                                 * Remaining initially equals available.
                                 */
                                $remainingQty =
                                    $availableQty;

                                ?>

                                <tr
                                    data-job-order-item-id="<?= $item->job_order_item_id ?>"
                                    data-existing="1"
                                >

                                    <!-- ================================================= -->
                                    <!-- # -->
                                    <!-- ================================================= -->

                                    <td class="text-center row-number">

                                        <?= $index + 1 ?>

                                    </td>


                                    <!-- ================================================= -->
                                    <!-- ITEM -->
                                    <!-- ================================================= -->

                                    <td>

                                        <?= htmlspecialchars(
                                            $item->product_name ??
                                            $item->item_description ??
                                            ''
                                        ) ?>


                                        <!-- Existing completion item ID -->

                                        <input
                                            type="hidden"
                                            name="items[<?= $index ?>][job_completion_item_id]"
                                            value="<?= $item->job_completion_item_id ?>"
                                        >


                                        <!-- Job Order Item ID -->

                                        <input
                                            type="hidden"
                                            name="items[<?= $index ?>][job_order_item_id]"
                                            value="<?= $item->job_order_item_id ?>"
                                        >


                                        <!-- Project Item ID -->

                                        <input
                                            type="hidden"
                                            name="items[<?= $index ?>][project_item_id]"
                                            value="<?= $item->project_item_id ?>"
                                        >


                                        <!-- Ordered Quantity -->

                                        <input
                                            type="hidden"
                                            name="items[<?= $index ?>][ordered_quantity]"
                                            value="<?= $orderedQty ?>"
                                        >


                                        <!--
                                            IMPORTANT:

                                            Send the ORIGINAL previous
                                            completed quantity here.

                                            Do NOT send the displayed
                                            previous completed quantity.

                                            The model will use this to
                                            calculate/update correctly.
                                        -->

                                        <input
                                            type="hidden"
                                            name="items[<?= $index ?>][previously_completed]"
                                            value="<?= $oldPreviousCompleted ?>"
                                        >


                                    </td>


                                    <!-- ================================================= -->
                                    <!-- ORDERED QTY -->
                                    <!-- ================================================= -->

                                    <td class="text-right ordered-qty">

                                        <?= number_format(
                                            $orderedQty,
                                            2
                                        ) ?>

                                    </td>


                                    <!-- ================================================= -->
                                    <!-- PREVIOUS COMPLETED QTY -->
                                    <!-- ================================================= -->

                                    <td class="text-right previous-completed-qty">

                                        <?= number_format(
                                            $displayPreviousCompleted,
                                            2
                                        ) ?>

                                    </td>


                                    <!-- ================================================= -->
                                    <!-- NEW COMPLETED QTY -->
                                    <!-- ================================================= -->

                                    <td>

                                        <input
                                            type="number"
                                            class="form-control completed-qty text-right"
                                            name="items[<?= $index ?>][completed_quantity]"
                                            value="0"
                                            min="0"
                                            max="<?= $availableQty ?>"
                                            step="0.01"
                                            data-available="<?= $availableQty ?>"
                                        >

                                    </td>


                                    <!-- ================================================= -->
                                    <!-- REMAINING QTY -->
                                    <!-- ================================================= -->

                                    <td class="text-right remaining-qty">

                                        <?= number_format(
                                            $remainingQty,
                                            2
                                        ) ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center"
                                >

                                    No completed items found.

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- ========================================================= -->
            <!-- FOOTER -->
            <!-- ========================================================= -->

            <div class="box-footer">

                <button
                    type="button"
                    id="updateJobCompletion"
                    class="btn btn-primary"
                >

                    <i class="fa fa-save"></i>

                    Update Job Completion

                </button>

            </div>

        </div>

    </div>

</div>



<!-- ================================================================ -->
<!-- ADD REMAINING ITEMS MODAL -->
<!-- ================================================================ -->

<div
    class="modal fade"
    id="remainingItemsModal"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h4 class="modal-title">

                    Add Remaining Completed Items

                </h4>


                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                >

                    &times;

                </button>

            </div>


            <div class="modal-body">

                <table
                    class="table table-bordered table-striped"
                    id="editRemainingItemsTable"
                >

                    <thead>

                        <tr>

                            <th width="50">
                                #
                            </th>

                            <th>
                                Item
                            </th>

                            <th>
                                Ordered Qty
                            </th>

                            <th>
                                Previous Completed Qty
                            </th>

                            <th>
                                Remaining Qty
                            </th>

                            <th width="60">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody></tbody>

                </table>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                >

                    Close

                </button>


                <button
                    type="button"
                    class="btn btn-primary"
                    id="addEditSelectedItems"
                >

                    <i class="fa fa-plus"></i>

                    Add Selected Items

                </button>

            </div>

        </div>

    </div>

</div>



<script>

var base_url = "<?= base_url(); ?>";
var editCompletionItems = [];

$(document).ready(function () {

    $(document).on(
        'click',
        '#addRemainingItemsBtn',
        function () {

            var completionId =
                $('#job_completion_id').val();


            if (!completionId) {

                alert(
                    'Job Completion ID not found.'
                );

                return;
            }


            $.ajax({

                url:
                    base_url +
                    'index.php/Production/get_remaining_items_for_edit',

                type: 'POST',

                dataType: 'json',

                data: {

                    job_completion_id:
                        completionId

                },


                beforeSend: function () {

                    $('#addRemainingItemsBtn')
                        .prop(
                            'disabled',
                            true
                        )
                        .html(
                            '<i class="fa fa-spinner fa-spin"></i> Loading...'
                        );

                },


                success: function (response) {

                    console.log(
                        'Remaining Items Response:',
                        response
                    );


                    if (!response.status) {

                        alert(
                            response.message ||
                            'No remaining items found.'
                        );

                        return;
                    }


                    renderEditRemainingItems(
                        response.items || []
                    );


                    $('#remainingItemsModal')
                        .modal('show');

                },


                error: function (xhr) {

                    console.log(
                        xhr.responseText
                    );


                    alert(
                        'Unable to load remaining items.'
                    );

                },


                complete: function () {

                    $('#addRemainingItemsBtn')
                        .prop(
                            'disabled',
                            false
                        )
                        .html(
                            '<i class="fa fa-plus"></i> Add Completed Item'
                        );

                }

            });

        }
    );

    $(document).on(
        'input',
        '.completed-qty',
        function () {

            var input =
                $(this);

            var row =
                input.closest('tr');

            var available =
                parseFloat(
                    input.attr('data-available')
                ) || 0;


            var value =  parseFloat(      input.val()
                ) || 0;


            if (value < 0) {

                value = 0;

                input.val('0');

            }

            if (value > available) {

                alert(
                    'Completed quantity cannot exceed remaining quantity (' +
                    available.toFixed(2) +
                    ').'
                );


                value = available;


                input.val(
                    available.toFixed(2)
                );

            }

            var remaining =
                available - value;


            if (remaining < 0) {

                remaining = 0;

            }


            row
                .find('.remaining-qty')
                .text(
                    remaining.toFixed(2)
                );

        }
    );

    $(document).on(
        'click',
        '#addEditSelectedItems',
        function () {

            var selectedCount = 0;


            $('#editRemainingItemsTable tbody')
                .find(
                    '.edit-completion-item-check:checked'
                )
                .each(function () {

                    var item =
                        $(this).data('item');


                    if (!item) {

                        return;

                    }

                    var existsInTable =
                        $('#completionItemsTable tbody tr')
                            .filter(function () {

                                return String(
                                    $(this).attr(
                                        'data-job-order-item-id'
                                    )
                                ) === String(
                                    item.job_order_item_id
                                );

                            })
                            .length > 0;


                    if (existsInTable) {

                        return;

                    }

                    var existsInArray =
                        editCompletionItems.some(
                            function (existing) {

                                return String(
                                    existing.job_order_item_id
                                ) === String(
                                    item.job_order_item_id
                                );

                            }
                        );


                    if (existsInArray) {

                        return;

                    }

                    editCompletionItems.push({

                        job_order_item_id:
                            item.job_order_item_id,

                        project_item_id:
                            item.project_item_id || '',

                        item_description:
                            item.item_description || '',

                        product_name:
                            item.product_name || '',

                        ordered_quantity:
                            parseFloat(
                                item.ordered_quantity
                            ) || 0,

                        previously_completed:
                            parseFloat(
                                item.previously_completed
                            ) || 0,

                        completed_quantity:
                            0,

                        remaining_quantity:
                            parseFloat(
                                item.remaining_quantity
                            ) || 0

                    });


                    selectedCount++;

                });

            if (selectedCount === 0) {

                alert(
                    'Please select at least one item.'
                );

                return;

            }

           renderEditCompletionItems();

            $('#remainingItemsModal')
                .modal('hide');

        }
    );

    $(document).on(
        'click',
        '.remove-new-completion-item',
        function () {

            var jobOrderItemId =
                $(this).attr(
                    'data-job-order-item-id'
                );

            editCompletionItems =
                editCompletionItems.filter(
                    function (item) {

                        return String(
                            item.job_order_item_id
                        ) !== String(
                            jobOrderItemId
                        );

                    }
                );

            $('#completionItemsTable tbody')
                .find(
                    'tr[data-job-order-item-id="' +
                    jobOrderItemId +
                    '"]'
                )
                .remove();


            renumberCompletionRows();

        }
    );

    $(document).on(
        'click',
        '#updateJobCompletion',
        function () {

            var completionId =
                $('#job_completion_id').val();


            if (!completionId) {

                alert(
                    'Job Completion ID not found.'
                );

                return;

            }


            var items = [];

            var validationFailed = false;

            $('#completionItemsTable tbody tr')
                .each(function () {

                    if (validationFailed) {

                        return false;

                    }


                    var row =
                        $(this);

                    var completionItemId =
                        row.find(
                            'input[name*="[job_completion_item_id]"]'
                        ).val() || '';


                    var jobOrderItemId =
                        row.find(
                            'input[name*="[job_order_item_id]"]'
                        ).val() || '';



                    if (
                        !completionItemId &&
                        !jobOrderItemId
                    ) {

                        return;

                    }


                    var orderedQuantity =
                        parseFloat(
                            row.find(
                                'input[name*="[ordered_quantity]"]'
                            ).val()
                        ) || 0;

                    var previouslyCompleted =
                        parseFloat(
                            row.find(
                                'input[name*="[previously_completed]"]'
                            ).val()
                        ) || 0;


                    var completedQuantity =
                        parseFloat(
                            row.find(
                                '.completed-qty'
                            ).val()
                        ) || 0;


                    var availableQuantity =
                        parseFloat(
                            row.find(
                                '.completed-qty'
                            ).attr('data-available')
                        ) || 0;


                    if (
                        completedQuantity < 0
                    ) {

                        alert(
                            'Completed quantity cannot be negative.'
                        );

                        validationFailed = true;

                        return false;

                    }


                    if (
                        completedQuantity >
                        availableQuantity
                    ) {

                        alert(
                            'Completed quantity cannot exceed remaining quantity.'
                        );

                        validationFailed = true;

                        return false;

                    }

                    items.push({

                       job_completion_item_id:
                            completionItemId,

                        job_order_item_id:
                            jobOrderItemId,

                        project_item_id:
                            row.find(
                                'input[name*="[project_item_id]"]'
                            ).val() || '',

                        ordered_quantity:
                            orderedQuantity,

                        previously_completed:
                            previouslyCompleted,

                        completed_quantity:
                            completedQuantity

                    });

                });


            if (validationFailed) {

                return;

            }

            if (!items.length) {

                alert(
                    'Please add at least one completed item.'
                );

                return;

            }


            console.log(
                'Items to update:',
                items
            );


            $.ajax({

                url:
                    base_url +
                    'index.php/Production/update_job_completion',

                type: 'POST',

                dataType: 'json',

                data: {

                    job_completion_id:
                        completionId,

                    completion_date:
                        $('#completion_date').val(),

                    remarks:
                        $('#remarks').val(),

                    items:
                        items

                },


                beforeSend: function () {

                    $('#updateJobCompletion')
                        .prop(
                            'disabled',
                            true
                        )
                        .html(
                            '<i class="fa fa-spinner fa-spin"></i> Updating...'
                        );

                },


                success: function (response) {

                    console.log(
                        'Update Response:',
                        response
                    );


                    if (response.status) {

                        alert(
                            response.message ||
                            'Job Completion updated successfully.'
                        );


                        window.location.href =
                            base_url +
                            'index.php/Production/job_completions';

                    }
                    else {

                        alert(
                            response.message ||
                            'Unable to update Job Completion.'
                        );

                    }

                },


                error: function (xhr) {

                    console.log(
                        xhr.responseText
                    );


                    alert(
                        'Unable to update Job Completion.'
                    );

                },


                complete: function () {

                    $('#updateJobCompletion')
                        .prop(
                            'disabled',
                            false
                        )
                        .html(
                            '<i class="fa fa-save"></i> Update Job Completion'
                        );

                }

            });

        }
    );

});


function renderEditRemainingItems(items)
{

    var tbody =
        $('#editRemainingItemsTable tbody');


    tbody.empty();


    if (!items || !items.length) {

        tbody.html(

            '<tr>' +

            '<td colspan="6" class="text-center">' +

            '<strong>' +

            'All Job Order items are completed.' +

            '</strong>' +

            '</td>' +

            '</tr>'

        );

        return;

    }


    $.each( items, function (index, item) {

            var alreadyInTable =
                $('#completionItemsTable tbody tr')
                    .filter(function () {

                        return String(
                            $(this).attr(
                                'data-job-order-item-id'
                            )
                        ) === String(
                            item.job_order_item_id
                        );

                    })
                    .length > 0;


            if (alreadyInTable) {

                return;

            }

            var alreadySelected =
                editCompletionItems.some(
                    function (selected) {

                        return String(
                            selected.job_order_item_id
                        ) === String(
                            item.job_order_item_id
                        );

                    }
                );


            if (alreadySelected) {

                return;

            }

            var orderedQty =
                parseFloat(
                    item.ordered_quantity
                ) || 0;


            var previousCompleted =
                parseFloat(
                    item.previously_completed
                ) || 0;


            var remainingQty =
                parseFloat(
                    item.remaining_quantity
                ) || 0;


            var itemName =
                item.product_name ||
                item.item_description ||
                '';

            var row =
                $('<tr>');


            row.append(

                $('<td>')
                    .text(index + 1)

            );


            row.append(

                $('<td>')
                    .text(itemName)

            );


            row.append(

                $('<td>')
                    .addClass('text-right')
                    .text(
                        orderedQty.toFixed(2)
                    )

            );


            row.append(

                $('<td>')
                    .addClass('text-right')
                    .text(
                        previousCompleted.toFixed(2)
                    )

            );


            row.append(

                $('<td>')
                    .addClass('text-right')
                    .text(
                        remainingQty.toFixed(2)
                    )

            );


            var checkbox =
                $('<input>')
                    .attr({
                        type: 'checkbox',
                        class: 'edit-completion-item-check',
                        value: item.job_order_item_id
                    })
                    .data(
                        'item',
                        item
                    );


            row.append(

                $('<td>')
                    .addClass('text-center')
                    .append(checkbox)

            );


            tbody.append(row);

        }
    );

}

function renderEditCompletionItems()
{

    var tbody =  $('#completionItemsTable tbody');

    tbody.find(
        'td[colspan="6"]'
    )
    .closest('tr')
    .remove();

    $.each( editCompletionItems, function (index, item) {

            var exists =
                tbody.find(
                    'tr[data-job-order-item-id="' +
                    item.job_order_item_id +
                    '"]'
                ).length > 0;


            if (exists) {

                return;

            }

            var orderedQuantity =
                parseFloat(
                    item.ordered_quantity
                ) || 0;


            var previouslyCompleted =
                parseFloat(
                    item.previously_completed
                ) || 0;


            var availableQuantity =
                parseFloat(
                    item.remaining_quantity
                ) || 0;


            var completedQuantity = 0;


            var remainingQuantity =
                availableQuantity;


            var rowIndex =
                tbody.find('tr').length;


            var row =
                $('<tr>')
                    .attr(
                        'data-job-order-item-id',
                        item.job_order_item_id
                    )
                    .attr(
                        'data-existing',
                        '0'
                    );
            row.append(

                $('<td>')
                    .addClass(
                        'text-center row-number'
                    )
                    .text(rowIndex + 1)

            );

            var itemCell =
                $('<td>');


            itemCell.append(
                $('<div>')
                    .text(
                        item.product_name ||
                        item.item_description ||
                        ''
                    )
            );

            itemCell.append(

                $('<input>')
                    .attr({
                        type: 'hidden',
                        name:
                            'items[' +
                            rowIndex +
                            '][job_order_item_id]',
                        value:
                            item.job_order_item_id
                    })

            );

            itemCell.append(

                $('<input>')
                    .attr({
                        type: 'hidden',
                        name:
                            'items[' +
                            rowIndex +
                            '][project_item_id]',
                        value:
                            item.project_item_id || ''
                    })

            );

            itemCell.append(

                $('<input>')
                    .attr({
                        type: 'hidden',
                        name:
                            'items[' +
                            rowIndex +
                            '][ordered_quantity]',
                        value:
                            orderedQuantity
                    })

            );
            itemCell.append(

                $('<input>')
                    .attr({
                        type: 'hidden',
                        name:
                            'items[' +
                            rowIndex +
                            '][previously_completed]',
                        value:
                            previouslyCompleted
                    })

            );


            row.append(itemCell);

            row.append(

                $('<td>')
                    .addClass('text-right')
                    .text(
                        orderedQuantity.toFixed(2)
                    )

            );

            row.append(

                $('<td>')
                    .addClass(
                        'text-right previous-completed-qty'
                    )
                    .text(
                        previouslyCompleted.toFixed(2)
                    )

            );

            var completedInput =
                $('<input>')
                    .attr({
                        type: 'number',
                        class:
                            'form-control completed-qty text-right',
                        name:
                            'items[' +
                            rowIndex +
                            '][completed_quantity]',
                        value: '0',
                        min: '0',
                        max:
                            availableQuantity,
                        step: '0.01',
                        'data-available':
                            availableQuantity
                    });


            row.append(

                $('<td>')
                    .append(
                        completedInput
                    )

            );

            row.append(

                $('<td>')
                    .addClass(
                        'text-right remaining-qty'
                    )
                    .text(
                        remainingQuantity.toFixed(2)
                    )

            );



            tbody.append(row);

        }
    );


    renumberCompletionRows();

}

function renumberCompletionRows()
{

    $('#completionItemsTable tbody tr')
        .each(function (index) {

            $(this)
                .find('.row-number')
                .text(
                    index + 1
                );

        });

}

$(document).on(
    'hidden.bs.modal',
    '#remainingItemsModal',
    function () {

        $('#editRemainingItemsTable tbody')
            .empty();

    }
);

</script>