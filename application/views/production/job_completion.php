<div class="x_panel">

    <div class="x_title">
        <h2>Create Job Completion</h2>
        <div class="clearfix"></div>
    </div>
    <style>.panel-heading{margin-top:15px;}#addCompletedItemsBtn{margin-bottom:15px;}</style>

    <div class="x_content">
                
                <input type="hidden" id="job_order_id">
                <div class="row">
                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                Job Completion No.
                            </label>

                            <input type="text"
                                   class="form-control"
                                   id="job_completion_no"
                                   value="<?= $job_completion_no ?>"
                                   readonly>

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                Completion Date
                                <span class="text-danger">*</span>
                            </label>

                            <input type="date"
                                   class="form-control"
                                   id="completion_date"
                                   value="<?= date('Y-m-d') ?>">

                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="form-group">

                            <label>
                                Job Order No.
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <select name="job_order_select" id="job_order_select" class="form-control select2">
                                    <option value="">-- Select Job Order --</option>

                                    <?php if (!empty($job_orders)): ?>

                                        <?php foreach ($job_orders as $jo): ?>

                                            <option value="<?= $jo->job_order_id ?>" data-project-id="<?= $jo->fk_project_id ?>"
                                                data-project-name="<?= htmlspecialchars($jo->project_name ?? '') ?>"
                                                data-order-date="<?= $jo->order_date ?>"
                                            >
                                                <?= htmlspecialchars($jo->job_order_no) ?>
                                                <?php if (!empty($jo->project_name)): ?>
                                                    - <?= htmlspecialchars($jo->project_name) ?>
                                                <?php endif; ?>
                                            </option>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </select>



                            </div>

                        </div>

                    </div>

                </div>


                <!-- BASIC DETAILS -->

                <div id="jobOrderDetails" style="display:none;">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <strong>
                                Job Order Information
                            </strong>

                        </div>


                        <div class="panel-body">


                            <div class="row">


                                <div class="col-md-3">

                                    <label>
                                        Job Order No.
                                    </label>

                                    <input type="text"
                                           id="display_job_order_no"
                                           class="form-control"
                                           readonly>

                                </div>


                                <div class="col-md-3">

                                    <label>
                                        Project
                                    </label>

                                    <input type="text"
                                           id="project_name"
                                           class="form-control"
                                           readonly>

                                </div>


                                <div class="col-md-3">

                                    <label>
                                        Order Date
                                    </label>

                                    <input type="text"
                                           id="order_date"
                                           class="form-control"
                                           readonly>

                                </div>


                                <div class="col-md-3">

                                    <label>
                                        Contact Person
                                    </label>

                                    <input type="text"
                                           id="contact_person"
                                           class="form-control"
                                           readonly>

                                </div>

                            </div>


                        </div>

                    </div>


                    <!-- COMPLETED ITEMS -->

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <strong>
                                Completed Items
                            </strong>

                            <button
                                type="button"
                                class="btn btn-primary btn-sm pull-right"
                                id="addCompletedItemsBtn">

                                <i class="fa fa-plus"></i>
                                Add Completed Item

                            </button>

                        </div>


                        <div class="panel-body">


                            <div class="table-responsive">

                                <table
                                    class="table table-bordered"
                                    id="completedItemsTable">

                                    <thead>

                                        <tr>

                                            <th width="50">
                                                #
                                            </th>

                                            <th>
                                                Item
                                            </th>

                                            <th width="120">
                                                Ordered Qty
                                            </th>

                                            <th width="140">
                                                Previously Completed
                                            </th>

                                            <th width="120">
                                                Completed Qty
                                            </th>

                                            <th width="120">
                                                Remaining Qty
                                            </th>

                                            <th width="70">
                                                Action
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        <tr>

                                            <td colspan="7"
                                                class="text-center">

                                                No completed items added.

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>


                    <!-- REMARKS -->

                    <div class="form-group">

                        <label>
                            Remarks
                        </label>

                        <textarea
                            id="remarks"
                            class="form-control"
                            rows="3"></textarea>

                    </div>


                    <div class="text-right">

                        <button
                            type="button"
                            class="btn btn-primary"
                            id="saveJobCompletion">

                            <i class="fa fa-save"></i>
                            Save Job Completion

                        </button>

                    </div>

                </div>


            </div>

</div>


<!-- ===================================================== -->
<!-- ADD COMPLETED ITEMS MODAL -->
<!-- ===================================================== -->

<div class="modal fade"
     id="completedItemsModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">
                <h4 class="modal-title">
                    Select Completed Items
                </h4>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>

            </div>


            <div class="modal-body">


                <table
                    class="table table-bordered table-striped" id="remainingItemsTable">

                    <thead>

                        <tr>

                            <th width="40">
                                #
                            </th>

                            <th>
                                Item
                            </th>

                            <th width="100">
                                Ordered
                            </th>

                            <th width="100">
                                Remaining
                            </th>

                            <th width="70">
                                Select
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
                    data-dismiss="modal">

                    Close

                </button>


                <button
                    type="button"
                    class="btn btn-primary"
                    id="addSelectedCompletedItems">

                    <i class="fa fa-plus"></i>
                    Add Selected Items

                </button>

            </div>


        </div>

    </div>

</div>


<script>
var selectedCompletionItems = [];
var base_url = "<?= base_url(); ?>";
$( document ).ready(function() { 

    $('.select2').select2({
        placeholder: '--  Select Job Order --',
        allowClear: true,
        width: '100%'
    });


$(document).on('change', '#job_order_select', function () {

    var jobOrderId = $(this).val();

    console.log('Job Order ID:', jobOrderId);

    if (!jobOrderId) {

        $('#job_order_id').val('');

        $('#jobOrderDetails').hide();

        $('#project_name').val('');
        $('#order_date').val('');
        $('#contact_person').val('');
        $('#display_job_order_no').val('');

        return;
    }

    // Store selected ID
    $('#job_order_id').val(jobOrderId);

    $.ajax({

        url: base_url +
             'index.php/Production/get_job_order_details',

        type: 'POST',

        dataType: 'json',

        data: {
            job_order_id: jobOrderId
        },

        success: function (response) {

            console.log('Response:', response);

            if (response.status) {

                var job = response.job_order;

                /*
                 * Assign values
                 */
                $('#display_job_order_no')
                    .val(job.job_order_no || '');

                $('#project_name')
                    .val(job.project_name || '');

                $('#order_date')
                    .val(job.order_date || '');

                $('#contact_person')
                    .val(job.contact_person || '');


                /*
                 * IMPORTANT
                 * Show the details DIV
                 */
                $('#jobOrderDetails')
                    .removeClass('hidden')
                    .css('display', 'block')
                    .hide()
                    .fadeIn(200);


                console.log(
                    'jobOrderDetails visible:',
                    $('#jobOrderDetails').is(':visible')
                );

            } else {

                alert(
                    response.message ||
                    'Job Order not found.'
                );

                $('#jobOrderDetails').hide();
            }

        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert('Unable to load Job Order.');

        }

    });

});});
/*
 * Add Completed Item button
 */
$(document).on('click', '#addCompletedItemsBtn',function () {
        var jobOrderId =  $('#job_order_select').val();
        if (!jobOrderId) {
            alert('Please load a Job Order first.' );
            return;
        }
      $.ajax({
    url: base_url +
        'index.php/Production/get_remaining_job_order_items',

    type: 'POST',

    dataType: 'json',

    data: {
        job_order_id: $('#job_order_id').val()
    },

    success: function(response) {

        if (response.status) {

            renderRemainingItems(
                response.items
            );

            $('#completedItemsModal').modal('show');

        } else {

            alert(
                response.message ||
                'No remaining items found.'
            );
        }
    },

    error: function(xhr) {

        console.log(xhr.responseText);

        alert(
            'Unable to load remaining items.'
        );
    }
});
    }
);


/*
 * Render remaining items
 */
function renderRemainingItems(items)
{
    var tbody =
        $('#remainingItemsTable tbody');


    tbody.empty();


    if (!items.length) {

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


    $.each(items, function (index, item) {


        /*
         * Don't show item already
         * added to current completion
         */
        var alreadyAdded =
            selectedCompletionItems.some(
                function (selected) {

                    return (
                        selected.job_order_item_id ==
                        item.job_order_item_id
                    );

                }
            );


        if (alreadyAdded) {

            return;

        }


        tbody.append(

            '<tr>' +

            '<td>' +
            (index + 1) +
            '</td>' +

            '<td>' +
            $('<div>')
                .text(
                    item.item_description || '' - item.item_code || ''
                )
                .html() +
            '</td>' +

            '<td>' +
            item.ordered_quantity +
            '</td>' +
            '<td>' +
            item.remaining_quantity +
            '</td>' +

            '<td class="text-center">' +

            '<input type="checkbox" ' +
            'class="completion-item-check" ' +
            'value="' +
            item.job_order_item_id +
            '" ' +
            'data-item=\'' +
            JSON.stringify(item) +
            '\'>' +

            '</td>' +

            '</tr>'

        );

    });

}


/*
 * Add selected items to main table
 */
$('#addSelectedCompletedItems')
    .on('click', function () {

        $('#remainingItemsTable tbody')
            .find(
                '.completion-item-check:checked'
            )
            .each(function () {

                var item =
                    $(this).data('item');


                selectedCompletionItems.push({

                    job_order_item_id:
                        item.job_order_item_id,

                    project_item_id:
                        item.project_item_id,

                    item_description:
                        item.item_description,

                    ordered_quantity:
                        parseFloat(
                            item.ordered_quantity
                        ),

                    previously_completed:
                        parseFloat(
                            item.previously_completed
                        ),

                    remaining_quantity:
                        parseFloat(
                            item.remaining_quantity
                        ),

                    completed_quantity:
                        parseFloat(
                            item.remaining_quantity
                        )

                });

            });


        renderCompletedItems();


        $('#completedItemsModal')
            .modal('hide');

    });


/*
 * Render selected items
 */
function renderCompletedItems()
{
    var tbody =
        $('#completedItemsTable tbody');


    tbody.empty();


    if (!selectedCompletionItems.length) {

        tbody.html(

            '<tr>' +

            '<td colspan="7" class="text-center">' +

            'No completed items added.' +

            '</td>' +

            '</tr>'

        );

        return;

    }


    $.each(
        selectedCompletionItems,
        function (index, item) {

            tbody.append(

                '<tr>' +

                '<td>' +
                (index + 1) +
                '</td>' +

                '<td>' +
                $('<div>')
                    .text(item.item_description)
                    .html() +
                '</td>' +

                '<td>' +
                item.ordered_quantity +
                '</td>' +

                '<td>' +
                item.previously_completed +
                '</td>' +

                '<td>' +

                '<input type="number" ' +
                'class="form-control input-sm completed-qty" ' +
                'data-index="' +
                index +
                '" ' +
                'min="1" ' +
                'max="' +
                item.remaining_quantity +
                '" ' +
                'step="1" ' +
                'value="' +
                item.completed_quantity +
                '">' +

                '</td>' +

                '<td class="remaining-cell">' +
                item.remaining_quantity +
                '</td>' +

                '<td>' +

                '<button type="button" ' +
                'class="btn btn-xs btn-danger remove-completion-item" ' +
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


/*
 * Quantity change
 */
$(document).on(
    'input',
    '.completed-qty',
    function () {

        var index =
            $(this).data('index');


        var qty =
            parseFloat(
                $(this).val()
            ) || 0;


        var item =
            selectedCompletionItems[index];


        if (
            qty < 0
        ) {

            qty = 0;

            $(this).val(0);

        }


        if (
            qty >
            item.remaining_quantity
        ) {

            alert(
                'Completed quantity cannot exceed remaining quantity.'
            );

            qty =
                item.remaining_quantity;

            $(this).val(qty);

        }


        item.completed_quantity =
            qty;


        var newRemaining =
            item.remaining_quantity -
            qty;


        $(this)
            .closest('tr')
            .find('.remaining-cell')
            .text(
                newRemaining.toFixed(2)
            );

    }
);


/*
 * Remove selected item
 */
$(document).on(
    'click',
    '.remove-completion-item',
    function () {

        var index =
            $(this).data('index');


        selectedCompletionItems.splice(
            index,
            1
        );


        renderCompletedItems();

    }
);


/*
 * Save Job Completion
 */
$('#saveJobCompletion').on(
    'click',
    function () {

        var jobOrderId =
            $('#job_order_id').val();


        if (!jobOrderId) {

            alert(
                'Please select a Job Order.'
            );

            return;

        }


        if (
            !selectedCompletionItems.length
        ) {

            alert(
                'Please add at least one completed item.'
            );

            return;

        }


        var invalid = false;


        $.each(
            selectedCompletionItems,
            function (index, item) {

                if (
                    !item.completed_quantity ||
                    item.completed_quantity <= 0
                ) {

                    invalid = true;

                    return false;

                }

            }
        );


        if (invalid) {

            alert(
                'Please enter completed quantity for all items.'
            );

            return;

        }


        $.ajax({

            url: base_url +
                'index.php/Production/save_job_completion',

            type: 'POST',

            dataType: 'json',

            data: {

                job_order_id:
                    jobOrderId,

                completion_date:
                    $('#completion_date').val(),

                remarks:
                    $('#remarks').val(),

                items:
                    JSON.stringify(
                        selectedCompletionItems
                    )

            },

            beforeSend: function () {

                $('#saveJobCompletion')
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
                        response.message +
                        '\nCompletion No: ' +
                        response.job_completion_no
                    );

                    // Redirect to Job Completion listing page
                    window.location.href = base_url + 'index.php/Production/job_completions';
                } else {
                    alert(
                        response.message || 'Unable to save Job Completion.'
                    );

                }

            },

            error: function (xhr) {

                console.log(
                    xhr.responseText
                );

                alert(
                    'Unable to save Job Completion.'
                );

            },

            complete: function () {

                $('#saveJobCompletion')
                    .prop(
                        'disabled',
                        false
                    )
                    .html(
                        '<i class="fa fa-save"></i> Save Job Completion'
                    );

            }

        });

    }
);

</script>

