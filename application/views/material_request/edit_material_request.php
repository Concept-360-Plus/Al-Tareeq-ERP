<link href="<?php echo base_url()."public/build/css/popup.css"; ?>" rel="stylesheet">

<div class="clearfix"></div>

<div class="row">

    <div class="col-md-12 col-sm-12">

        <div class="x_panel">

            <form id="mr_form"
                  action="<?= base_url('index.php/Project/update_material_request') ?>"
                  method="post">

                <!-- =====================================================
                     HIDDEN MR ID
                ====================================================== -->

                <input type="hidden"
                       name="mr_id"
                       value="<?= $mr['mr_id'] ?>">


                <!-- =====================================================
                     PROJECT
                ====================================================== -->

                <div class="col-md-3">

                    <label for="project_id" class="form-label">
                        Approved Project
                    </label>

                    <select name="project_id"
                            id="project_id"
                            class="form-control select2"
                            required>

                        <option value="">
                            -- Select Project --
                        </option>

                        <?php foreach ($approved_projects as $proj): ?>

                            <option value="<?= $proj['project_id'] ?>"
                                <?= ($proj['project_id'] == $mr['project_id'])
                                    ? 'selected'
                                    : '' ?>>

                                <?= htmlspecialchars($proj['project_name']) ?>
                                (<?= htmlspecialchars($proj['project_code']) ?>)

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- =====================================================
                     INITIATED BY
                ====================================================== -->

                <div class="col-md-3">

                    <label for="initiated_by" class="form-label">
                        Initiated By
                    </label>

                    <select name="initiated_by"
                            id="initiated_by"
                            class="form-control"
                            required>

                        <option value="">
                            -- Select User --
                        </option>

                        <?php foreach ($users as $user): ?>

                            <option value="<?= $user['user_id'] ?>"
                                <?= ($user['user_id'] == $mr['initiated_by'])
                                    ? 'selected'
                                    : '' ?>>

                                <?= htmlspecialchars($user['user_name']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <div class="col-md-12"></div>


                <!-- =====================================================
                     PROJECT INFORMATION
                ====================================================== -->

                <div class="col-md-6">

                    <div class="project-info-card">

                        <div class="project-info-header">

                            <i class="fa fa-folder-open"></i>

                            <span>
                                Project Information
                            </span>

                        </div>


                        <div class="project-info-body">

                            <div class="row">


                                <!-- Project Name -->

                                <div class="col-md-5">

                                    <div class="project-info-item">

                                        <label>
                                            Project Name
                                        </label>

                                        <div id="project_name"
                                             class="project-info-value">

                                            <?= htmlspecialchars($mr['project_name']) ?>

                                        </div>

                                    </div>

                                </div>


                                <!-- Customer -->

                                <div class="col-md-3">

                                    <div class="project-info-item">

                                        <label>
                                            Customer
                                        </label>

                                        <div id="customer_name"
                                             class="project-info-value">

                                            <?= htmlspecialchars($mr['customer_name']) ?>

                                        </div>

                                    </div>

                                </div>


                                <!-- Branch -->

                                <div class="col-md-4">

                                    <div class="project-info-item">

                                        <label>
                                            Branch
                                        </label>

                                        <div id="branch_name"
                                             class="project-info-value">

                                            <?= htmlspecialchars($mr['branch_name']) ?>

                                        </div>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-md-12"></div>


                <!-- =====================================================
                     REQUESTED DATE
                ====================================================== -->

                <div class="col-md-3">

                    <label class="form-label">
                        Requested Date
                    </label>

                    <input type="date"
                           name="requested_date"
                           class="form-control"
                           value="<?= $mr['requested_date'] ?>"
                           required>

                </div>


                <!-- =====================================================
                     REQUIRED DATE
                ====================================================== -->

                <div class="col-md-3">

                    <label class="form-label">
                        Required Date
                    </label>

                    <input type="date"
                           name="required_date"
                           class="form-control"
                           value="<?= $mr['required_date'] ?>"
                           required>

                </div>


                <div class="col-md-12 mt-2">

                    <label>
                        <strong>Items</strong>
                    </label>

                </div>


                <!-- =====================================================
                     MATERIAL ITEMS TABLE
                ====================================================== -->

                <div class="col-md-12 mt-2">

                    <table class="table table-bordered table-hover"
                           id="tab_logic">

                        <thead>

                            <tr>

                                <th>
                                    Item Name
                                </th>

                                <th width="120">
                                    Quantity
                                </th>

                                <th>
                                    Unit
                                </th>

                                <th>
                                    Description
                                </th>

                                <th>
                                    Remarks
                                </th>

                                <th width="50">

                                    <a href="javascript:void(0);"
                                       id="add_row"
                                       class="btn btn-xs bg-orange"
                                       title="Add">

                                        <span class="fa fa-plus"></span>

                                    </a>

                                </th>

                            </tr>

                        </thead>


                        <tbody id="mytbbody">


                        <?php if (!empty($mitems)): ?>


                            <?php foreach ($mitems as $i => $r): ?>

                                <tr id="addr<?= $i ?>">

                                    <!-- =================================
                                         ITEM NAME
                                    ================================== -->

                                    <td>

                                        <input type="hidden"
                                               name="m_id[]"
                                               value="<?= $r['pjt_material_id'] ?>">

                                        <select name="product[]"
                                                class="form-control select2-product">

                                            <option value="">
                                                -- Select Product --
                                            </option>

                                            <?php foreach ($pitems as $itm): ?>

                                                <option value="<?= $itm['product_id'] ?>"
                                                    <?= ($itm['product_id'] == $r['fk_item_id'])
                                                        ? 'selected'
                                                        : '' ?>>

                                                    <?= htmlspecialchars($itm['product_name']) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </td>


                                    <!-- =================================
                                         QUANTITY
                                    ================================== -->

                                    <td>

                                        <input type="number"
                                               name="pdt_qty[]"
                                               class="form-control"
                                               value="<?= htmlspecialchars($r['item_qty']) ?>"
                                               step="any">

                                    </td>


                                    <!-- =================================
                                         UNIT
                                    ================================== -->

                                    <td>

                                        <select name="unit[]"
                                                class="form-control">

                                            <option value="">
                                                -- Select Unit --
                                            </option>

                                            <?php foreach ($units as $ut): ?>

                                                <option value="<?= $ut['unit_id'] ?>"
                                                    <?= ($r['item_unit'] == $ut['unit_id'])
                                                        ? 'selected'
                                                        : '' ?>>

                                                    <?= htmlspecialchars($ut['unit_abbr']) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </td>


                                    <!-- =================================
                                         DESCRIPTION
                                    ================================== -->

                                    <td>

                                        <textarea name="desc[]"
                                                  id="desc<?= $i ?>"
                                                  rows="4"
                                                  class="form-control"><?= htmlspecialchars($r['item_desc']) ?></textarea>

                                    </td>


                                    <!-- =================================
                                         REMARKS
                                    ================================== -->

                                    <td>

                                        <textarea name="item_remark[]"
                                                  id="item_remark<?= $i ?>"
                                                  rows="4"
                                                  class="form-control"><?= htmlspecialchars($r['item_remarks']) ?></textarea>

                                    </td>


                                    <!-- =================================
                                         DELETE
                                    ================================== -->

                                    <td>

                                        <a href="javascript:void(0);"
                                           onclick="remove_row(<?= $i ?>);"
                                           class="btn btn-xs bg-orange">

                                            <span class="fa fa-trash"></span>

                                        </a>

                                    </td>

                                </tr>


                            <?php endforeach; ?>


                        <?php else: ?>


                            <!-- =========================================
                                 FIRST EMPTY ROW
                            ========================================== -->

                            <tr id="addr0">

                                <td>

                                    <input type="hidden"
                                           name="m_id[]"
                                           value="">

                                    <select name="product[]"
                                            class="form-control select2-product">

                                        <option value="">
                                            -- Select Product --
                                        </option>

                                        <?php foreach ($pitems as $itm): ?>

                                            <option value="<?= $itm['product_id'] ?>">

                                                <?= htmlspecialchars($itm['product_name']) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </td>


                                <td>

                                    <input type="number"
                                           name="pdt_qty[]"
                                           class="form-control"
                                           step="any">

                                </td>


                                <td>

                                    <select name="unit[]"
                                            class="form-control">

                                        <option value="">
                                            -- Select Unit --
                                        </option>

                                        <?php foreach ($units as $ut): ?>

                                            <option value="<?= $ut['unit_id'] ?>">

                                                <?= htmlspecialchars($ut['unit_abbr']) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </td>


                                <td>

                                    <textarea name="desc[]"
                                              id="desc0"
                                              rows="4"
                                              class="form-control"></textarea>

                                </td>


                                <td>

                                    <textarea name="item_remark[]"
                                              id="item_remark0"
                                              rows="4"
                                              class="form-control"></textarea>

                                </td>


                                <td>

                                    <a href="javascript:void(0);"
                                       onclick="remove_row(0);"
                                       class="btn btn-xs bg-orange">

                                        <span class="fa fa-trash"></span>

                                    </a>

                                </td>

                            </tr>


                        <?php endif; ?>


                        </tbody>

                    </table>

                </div>


                <!-- =====================================================
                     HIDDEN PROJECT INFORMATION
                ====================================================== -->

                <input type="hidden"
                       name="project_code"
                       id="project_code"
                       value="<?= htmlspecialchars($mr['project_code']) ?>">


                <input type="hidden"
                       name="customer_name"
                       id="hidden_customer_name"
                       value="<?= htmlspecialchars($mr['customer_name']) ?>">


                <input type="hidden"
                       name="branch_name"
                       id="hidden_branch_name"
                       value="<?= htmlspecialchars($mr['branch_name']) ?>">


                <!-- =====================================================
                     BUTTONS
                ====================================================== -->

                <div class="col-md-12 text-end mt-3">

                    <button type="submit"
                            class="btn btn-success">

                        Update MR

                    </button>

                    <a href="<?= base_url('index.php/Project/list_material_request') ?>"
                       class="btn btn-secondary">

                        Cancel

                    </a>

                </div>


            </form>

        </div>

    </div>

</div>


<?php

/* ==========================================================
   PRODUCT OPTIONS FOR AJAX/JS ROW CREATION
========================================================== */

$productOptions = '<option value="">-- Select Product --</option>';

foreach ($pitems as $itm) {

    $productOptions .=
        '<option value="' . htmlspecialchars($itm['product_id'], ENT_QUOTES) . '">'
        . htmlspecialchars($itm['product_name'])
        . '</option>';
}


/* ==========================================================
   UNIT OPTIONS FOR AJAX/JS ROW CREATION
========================================================== */

$unitOptions = '<option value="">-- Select Unit --</option>';

foreach ($units as $unit) {

    $unitOptions .=
        '<option value="' . htmlspecialchars($unit['unit_id'], ENT_QUOTES) . '">'
        . htmlspecialchars($unit['unit_abbr'])
        . '</option>';
}

?>


<script>

$(document).ready(function () {


    /* ==========================================================
       PRODUCT OPTIONS
    ========================================================== */

    var productOptions =
        <?= json_encode($productOptions) ?>;


    /* ==========================================================
       UNIT OPTIONS
    ========================================================== */

    var unitOptions =
        <?= json_encode($unitOptions) ?>;


    /* ==========================================================
       INITIALIZE PROJECT SELECT2
    ========================================================== */

    $('#project_id').select2({

        placeholder: '-- Select Project --',

        allowClear: true,

        width: '100%'

    });


    /* ==========================================================
       INITIALIZE EXISTING PRODUCT SELECT2
    ========================================================== */

    $('.select2-product').select2({

        placeholder: '-- Select Product --',

        allowClear: true,

        width: '100%'

    });


    /* ==========================================================
       FIND NEXT ROW ID
       
       IMPORTANT:
       Do NOT use:
       
           var i = 1;
       
       because existing rows may already use addr1,
       addr2, addr3 etc.
    ========================================================== */

    function getNextRowId()
    {

        var maxId = -1;


        $('#mytbbody tr').each(function () {

            var id =
                $(this).attr('id');


            if (id && id.indexOf('addr') === 0) {

                var number =
                    parseInt(
                        id.replace('addr', ''),
                        10
                    );


                if (!isNaN(number) && number > maxId) {

                    maxId = number;

                }

            }

        });


        return maxId + 1;

    }


    /* ==========================================================
       ADD NEW MATERIAL ROW
    ========================================================== */

    $('#add_row').on('click', function (e) {

        e.preventDefault();


        /* Get a completely new ID */

        var i =
            getNextRowId();


        /* Create NEW TR */

        var html = '';


        html +=
            '<tr id="addr' + i + '">';


        /* ======================================================
           PRODUCT
        ====================================================== */

        html += '<td>';

        html +=
            '<input type="hidden" ' +
            'name="m_id[]" ' +
            'value="">';

        html +=
            '<select name="product[]" ' +
            'class="form-control select2-product">';

        html += productOptions;

        html += '</select>';

        html += '</td>';


        /* ======================================================
           QUANTITY
        ====================================================== */

        html += '<td>';

        html +=
            '<input type="number" ' +
            'name="pdt_qty[]" ' +
            'class="form-control" ' +
            'step="any">';

        html += '</td>';


        /* ======================================================
           UNIT
        ====================================================== */

        html += '<td>';

        html +=
            '<select name="unit[]" ' +
            'class="form-control">';

        html += unitOptions;

        html += '</select>';

        html += '</td>';


        /* ======================================================
           DESCRIPTION
        ====================================================== */

        html += '<td>';

        html +=
            '<textarea name="desc[]" ' +
            'id="desc' + i + '" ' +
            'rows="4" ' +
            'class="form-control" ' +
            'placeholder="Description"></textarea>';

        html += '</td>';


        /* ======================================================
           REMARKS
        ====================================================== */

        html += '<td>';

        html +=
            '<textarea name="item_remark[]" ' +
            'id="item_remark' + i + '" ' +
            'rows="4" ' +
            'class="form-control" ' +
            'placeholder="Remark"></textarea>';

        html += '</td>';


        /* ======================================================
           DELETE
        ====================================================== */

        html += '<td>';

        html +=
            '<a href="javascript:void(0);" ' +
            'onclick="remove_row(' + i + ');" ' +
            'class="btn btn-xs bg-orange">';

        html +=
            '<span class="fa fa-trash"></span>';

        html += '</a>';

        html += '</td>';


        html += '</tr>';


        /* ======================================================
           APPEND — NEVER REPLACE EXISTING ROW
        ====================================================== */

        $('#mytbbody').append(html);


        /* ======================================================
           INITIALIZE SELECT2 ONLY FOR NEW ROW
        ====================================================== */

        $('#addr' + i)
            .find('.select2-product')
            .select2({

                placeholder: '-- Select Product --',

                allowClear: true,

                width: '100%'

            });

    });


});


/* ==========================================================
   REMOVE MATERIAL ROW
========================================================== */

function remove_row(rowId)
{

    $('#addr' + rowId).remove();

}

</script>