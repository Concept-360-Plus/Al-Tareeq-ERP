<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12">
<div class="x_panel">
<div class="x_content">
<br />

<form action="<?php echo base_url().'index.php/Setup/' . (isset($product) ? 'update_item/'.$product['product_id'] : 'add_item_data'); ?>"
      method="post" autocomplete="off" id="product" enctype="multipart/form-data">

<div class="row">

    <!-- Product Code -->
    <div class="col-md-6">
        <label>Product Code <span class="required">*</span></label>
        <input type="text" id="product_code" name="product_code" required class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['product_code']) : '' ?>">
    </div>

    <!-- Product Name -->
    <div class="col-md-6">
        <label>Product Name <span class="required">*</span></label>
        <input type="text" id="product_name" name="product_name" required class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['product_name']) : '' ?>">
    </div>

    <!-- Short Description -->
    <div class="col-md-6 mt-2">
        <label>Short Description</label>
        <input type="text" name="short_description" class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['short_description']) : '' ?>">
    </div>

    <!-- Long Description -->
    <div class="col-md-6 mt-2">
        <label>Long Description</label>
        <textarea name="long_description" class="form-control"><?= isset($product) ? htmlspecialchars($product['long_description']) : '' ?></textarea>
    </div>

    <!-- Unit -->
    <div class="col-md-6 mt-2">
        <label>Unit <span class="required">*</span></label>
        <select name="unit_id" class="form-control" required>
            <option value="">-- Select Unit --</option>
            <?php foreach ($active_units as $unit): ?>
                <option value="<?= $unit->unit_id ?>"
                    <?= isset($product) && $product['unit_id'] == $unit->unit_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($unit->unit_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

        <!-- Retail Price -->
    <div class="col-md-6 mt-2">
        <label>Retail Price</label>
        <input type="number" step="any" name="retail_price" id="retail_price" class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['retail_price']) : '' ?>">
    </div>

    <!-- Cost Price -->
    <div class="col-md-6 mt-2">
        <label>Cost Price</label>
        <input type="number" step="any" name="cost_price" id="cost_price" class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['cost_price']) : '' ?>">
    </div>

        <!-- Product Type -->
    <div class="col-md-6 mt-2">
        <label>Product Type <span class="required">*</span></label>
        <select name="product_type_id" id="product_type" class="form-control" required>
            <option value="">-- Select Product Type --</option>
            <?php foreach ($product_types as $pt): ?>
                <option value="<?= $pt->product_type_id ?>" data-code="<?= $pt->type_code ?>"
                    <?= (isset($product) && $product['product_type_id'] == $pt->product_type_id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($pt->type_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-12 mt-2" id="raw_material_section">

        <label>Raw Materials</label>

            <table class="table table-bordered table-hover" id="tab_logic">
            <thead>
                <tr>
                    <th title="Item">Material</th>
                    <th title="Item">Quantity</th>
                    <th title="Item">Unit</th>
                    <th width='30px'><a id="add_row" title="Add" class="btn btn-xs bg-orange"><span class="fa fa-plus"></span></a></th>
                </tr>
            </thead>
            <tbody id="mytbbody">
                <?php foreach ($rawmat as $r): ?>
                <tr style='font-size: 13px;'>
                    <td>
                        <select name="material_id_old[]" class="form-control material_select" required>
                            <option value="">-- Select Material --</option>
                            <?php foreach ($active_materials as $mat): ?>
                                <option value="<?= $mat->material_id ?>" data-unit="<?= $mat->unit ?>"
                                    <?= (isset($r->material_id) && $r->material_id == $mat->material_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($mat->material_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" step="0.01" name="qty_old[]" class="form-control qty" value="<?php echo $r->quantity_required; ?>"></td>
                    <td>
                        <select name="unit_old[]" class="form-control unit_select">
                            <option value="">-- Select Unit --</option>
                            <?php foreach ($active_units as $unit): ?>
                                <option value="<?= $unit->unit_id ?>" <?= ($r->unit == $unit->unit_id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($unit->unit_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td width='30px'>
                        <input type="hidden" name="m_id[]" value="<?php echo $r->id; ?>">
                        <a href="javascript:confirmcancel(<?php echo $r->id; ?>, this)" title="Delete" class="btn btn-xs bg-orange"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($rawmat)): ?>
                <tr id='addr0' style='font-size: 13px;'>
                    <td>
                        <select name="material_id[]" class="form-control material_select" required>
                            <option value="">-- Select Material --</option>
                            <?php foreach ($active_materials as $mat): ?>
                                <option value="<?= $mat->material_id ?>" data-unit="<?= $mat->unit ?>">
                                    <?= htmlspecialchars($mat->material_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type='number' step='0.01' name="qty[]" class="form-control qty" placeholder=""></td>
                    <td>
                        <select name="unit[]" class="form-control unit_select">
                            <option value="">-- Select Unit --</option>
                            <?php foreach ($active_units as $unit): ?>
                                <option value="<?= $unit->unit_id ?>"><?= htmlspecialchars($unit->unit_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td width='30px'><a id='delete_row' title="Delete" onclick='remove_row(0)' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>
                </tr>
                <?php endif; ?>

                <tr id='addr1'></tr>
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="col-md-6 mt-2">
        <label>Total Price </label>
        <input type="text" name="total_amount" id="total_amount" class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['total_price']) : '' ?>" readonly>
    </div>

    <!-- Group Code -->
    <div class="col-md-6 mt-2">
        <label>Group Code</label>
        <input type="text" name="group_code" class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['group_code']) : '' ?>">
    </div>

    <!-- Category -->
    <div class="col-md-6 mt-2">
        <label>Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">-- Select Category --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->category_id; ?>"
                    <?= (isset($product) && $product['category_id'] == $cat->category_id) ? 'selected' : ''; ?>>
                    <?= $cat->category_code; ?> - <?= htmlspecialchars($cat->category_name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Sub Category -->
    <div class="col-md-6 mt-2">
        <label>Sub Category</label>
        <select name="sub_category_id" id="sub_category_id" class="form-control">
            <option value="">-- Select Sub Category --</option>
        </select>
    </div>

    <!-- Child Category -->
    <div class="col-md-6 mt-2">
        <label>Child Category</label>
        <select name="child_category_id" id="child_category_id" class="form-control">
            <option value="">-- Select Child Category --</option>
        </select>
    </div>


    <!-- HS Code -->
    <div class="col-md-6 mt-2">
        <label>HS Code</label>
        <input type="text" name="hs_code" class="form-control"
            value="<?= isset($product) ? htmlspecialchars($product['hs_code']) : '' ?>">
    </div>

    <!-- Status -->
    <div class="col-md-6 mt-2">
        <label>Status</label><br>

        <label style="margin-right:15px;">
            <input type="checkbox" name="is_inactive" value="1"
                <?= isset($product) && $product['is_inactive'] == 1 ? 'checked' : '' ?>>
            Inactive
        </label>
    </div>

    <!-- Image -->
    <div class="col-md-6 mt-2">
        <label>Product Image</label>
        <input type="file" name="product_image" class="form-control" accept="image/*">

        <?php if (isset($product) && !empty($product['product_image'])) { ?>
            <img src="<?= base_url('public/items/'.$product['product_image']) ?>" style="width:80px;margin-top:5px;">
        <?php } ?>
    </div>

</div>

<!-- Submit -->
<div class="row mt-3">
    <div class="col-md-12 text-center">
        <button type="submit" id="saveBtn" class="btn btn-success">
            <?= isset($product) ? 'Update' : 'Submit' ?>
        </button>
    </div>
</div>

</form>

</div>
</div>
</div>
</div>
<script>
var baseUrl = "<?php echo base_url(); ?>";

var unitOptions = `<?php
echo '<option value="">Select</option>';
foreach ($active_units as $unit) {
    echo '<option value="'.$unit->unit_id.'">'.htmlspecialchars($unit->unit_name).'</option>';
}
?>`;

var materialOptions = `<?php
echo '<option value="">-- Select Material --</option>';
foreach ($active_materials as $mat) {
    echo '<option value="'.$mat->material_id.'" data-unit="'.$mat->unit.'">'.htmlspecialchars($mat->material_name).'</option>';
}
?>`;

var selectedSubCategoryId = <?= isset($product) && !empty($product['sub_category_id']) ? $product['sub_category_id'] : 0 ?>;
var selectedChildCategoryId = <?= isset($product) && !empty($product['child_category_id']) ? $product['child_category_id'] : 0 ?>;
</script>
<script>
document.getElementById("product").addEventListener("submit", function (e) {
    var btn = document.getElementById("saveBtn");

    if (btn.disabled) {
        e.preventDefault();
        return false;
    }

    btn.disabled = true;
    btn.innerHTML = "Processing...";
});

$(document).on("keyup change", "#retail_price, .qty, .uprice", function () {
    calculateTotal();
});

// auto fill unit when a raw material is picked; unit price is entered manually
$(document).on("change", ".material_select", function () {

    var selected = $(this).find(":selected");
    var unit = selected.data("unit");
    var row = $(this).closest("tr");

    if (unit !== undefined && unit !== "") {
        row.find(".unit_select").val(unit);
    }

    calculateTotal();
});

function toggleRawMaterialSection() {

    var isCustomMade = $("#product_type option:selected").data("code") === "custom_made";

    if (isCustomMade) {
        $("#raw_material_section").show();
        $("#raw_material_section .material_select").attr("required", "required");
    } else {
        $("#raw_material_section").hide();
        // hidden required fields block native form submission silently
        $("#raw_material_section .material_select").removeAttr("required");
    }
}

$(document).on("change", "#product_type", function () {
    toggleRawMaterialSection();
    calculateTotal();
});

// category > sub category > child category cascade
function loadSubCategories(categoryId, preselectId) {

    $("#sub_category_id").html('<option value="">-- Select Sub Category --</option>');
    $("#child_category_id").html('<option value="">-- Select Child Category --</option>');

    if (!categoryId) {
        return;
    }

    $.ajax({
        url: baseUrl + "index.php/Setup/get_subcategories_ajax",
        type: "POST",
        data: { category_id: categoryId },
        dataType: "json",
        success: function (res) {

            $.each(res, function (i, sc) {

                var selected = (preselectId && preselectId == sc.sub_category_id) ? 'selected' : '';
                $("#sub_category_id").append(
                    '<option value="' + sc.sub_category_id + '" ' + selected + '>' + sc.sub_category_name + '</option>'
                );
            });

            if (preselectId) {
                loadChildCategories(preselectId, selectedChildCategoryId);
            }
        }
    });
}

function loadChildCategories(subCategoryId, preselectId) {

    $("#child_category_id").html('<option value="">-- Select Child Category --</option>');

    if (!subCategoryId) {
        return;
    }

    $.ajax({
        url: baseUrl + "index.php/Setup/get_childcategories_ajax",
        type: "POST",
        data: { sub_category_id: subCategoryId },
        dataType: "json",
        success: function (res) {

            $.each(res, function (i, cc) {

                var selected = (preselectId && preselectId == cc.child_category_id) ? 'selected' : '';
                $("#child_category_id").append(
                    '<option value="' + cc.child_category_id + '" ' + selected + '>' + cc.child_category_name + '</option>'
                );
            });
        }
    });
}

$(document).on("change", "#category_id", function () {
    loadSubCategories($(this).val(), null);
});

$(document).on("change", "#sub_category_id", function () {
    loadChildCategories($(this).val(), null);
});

$(document).ready(function () {

    var i = 1;

    $("#add_row").click(function () {

        $('#addr' + i).html(
            "<td><select name='material_id[]' class='form-control material_select' required>" + materialOptions + "</select></td>" +
            "<td><input name='qty[]' class='form-control qty' placeholder='' type='number' step='0.01' required></td>" +
            "<td><select name='unit[]' class='form-control unit_select'>" + unitOptions + "</select></td>" +
            "<td><a onclick='remove_row(" + i + ");calculateTotal();' id='delete_row' title='Delete' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>"
        );

        $('#mytbbody tr:last').after('<tr id="addr' + (i + 1) + '"></tr>');
        i++;
        toggleRawMaterialSection();
        calculateTotal();
    });

    $("#delete_row").click(function () {
        if (i > 1) {
            $("#addr" + (i - 1)).html('');
            i--;
        }
    });

    toggleRawMaterialSection();

    var initialCategoryId = $("#category_id").val();
    if (initialCategoryId) {
        loadSubCategories(initialCategoryId, selectedSubCategoryId);
    }

    calculateTotal();
});

function remove_row(append_id) {
    $('#addr' + append_id).attr("id", "addr" + append_id + "x");
    $('#addr' + append_id + "x").remove();
    calculateTotal();
}

function calculateTotal() {

    var retail = parseFloat($("#retail_price").val()) || 0;

    $("#total_amount").val(retail.toFixed(2));
}

function confirmcancel(id, el) {

    var r = confirm("Are you sure you want to Delete Record?");

    if (r == true) {
        $.ajax({
            url: baseUrl + "index.php/Ajax/delete_record",
            type: "POST",
            data: { table_name: 'amc_product_materials', where_key: 'id', where_val: id },
            success: function (msg) {
                if (msg == 1) {
                    $(el).closest("tr").remove();
                    calculateTotal();
                } else {
                    alert("Can't Delete record. Data already used!!!");
                }
            },
        });
    }

    return false;
}
</script>