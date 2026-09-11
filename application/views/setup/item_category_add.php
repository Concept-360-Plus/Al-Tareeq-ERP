<div class="clearfix"></div>

<div class="row">
<div class="col-md-12 col-sm-12">
<div class="x_panel">
<div class="x_content">
<br />

<!-- category details -->
<form action="<?php echo base_url().'index.php/Setup/' . (isset($category) ? 'update_item_category/'.$category['category_id'] : 'add_category_data'); ?>"
      method="post" autocomplete="off" id="category_form">

<div class="row">

    <div class="col-md-6">
        <label>Category Code <span class="required">*</span></label>
        <input type="text" name="category_code" class="form-control"
            value="<?= isset($category) ? htmlspecialchars($category['category_code']) : htmlspecialchars($category_code); ?>" readonly>
    </div>

    <div class="col-md-6">
        <label>Category Name <span class="required">*</span></label>
        <input type="text" name="category_name" class="form-control" required
            value="<?= isset($category) ? htmlspecialchars($category['category_name']) : '' ?>">
    </div>

    <div class="col-md-6 mt-2">
        <label>Description</label>
        <textarea name="description" class="form-control" rows="3"><?= isset($category) ? htmlspecialchars($category['description']) : '' ?></textarea>
    </div>

    <div class="col-md-6 mt-2">
        <label>Status</label><br>

        <label style="margin-right:15px;">
            <input type="checkbox" name="is_active" value="1"
                <?= isset($category) && $category['is_active'] == 1 ? 'checked' : '' ?>>
            Active
        </label>
    </div>

</div>

<div class="row mt-3">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-success">
            <?= isset($category) ? 'Update' : 'Save' ?>
        </button>
    </div>
</div>

</form>

<?php if (isset($category)): ?>

<hr>

<!-- sub category management -->
<div class="row mt-3">
    <div class="col-md-12">
        <label>Sub Categories</label>

        <table class="table table-bordered table-hover" id="subcat_table">
            <thead>
                <tr>
                    <th width="120px">Code</th>
                    <th>Sub Category Name</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody id="subcat_body">
                <?php foreach ($subcategories as $sc): ?>
                <tr data-id="<?= $sc->sub_category_id ?>">
                    <td><?= htmlspecialchars($sc->sub_category_code) ?></td>
                    <td><input type="text" class="form-control sc_name" value="<?= htmlspecialchars($sc->sub_category_name) ?>"></td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-xs bg-orange sc_update" title="Update"><span class="fa fa-save"></span></a>
                        <a href="javascript:void(0)" class="btn btn-xs bg-orange sc_delete" title="Delete"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tr id="subcat_new_row">
                    <td>Auto</td>
                    <td><input type="text" class="form-control" id="new_sc_name" placeholder="New sub category name"></td>
                    <td>
                        <a href="javascript:void(0)" id="add_subcategory" class="btn btn-xs bg-orange" title="Add"><span class="fa fa-plus"></span></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- child category management -->
<div class="row mt-3">
    <div class="col-md-12">
        <label>Child Categories</label>

        <table class="table table-bordered table-hover" id="childcat_table">
            <thead>
                <tr>
                    <th width="120px">Code</th>
                    <th>Sub Category</th>
                    <th>Child Category Name</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody id="childcat_body">
                <?php foreach ($childcategories as $cc): ?>
                <tr data-id="<?= $cc->child_category_id ?>">
                    <td><?= htmlspecialchars($cc->child_category_code) ?></td>
                    <td>
                        <select class="form-control cc_subcategory">
                            <?php foreach ($subcategories as $sc): ?>
                                <option value="<?= $sc->sub_category_id ?>"
                                    <?= $sc->sub_category_id == $cc->sub_category_id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($sc->sub_category_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control cc_name" value="<?= htmlspecialchars($cc->child_category_name) ?>"></td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-xs bg-orange cc_update" title="Update"><span class="fa fa-save"></span></a>
                        <a href="javascript:void(0)" class="btn btn-xs bg-orange cc_delete" title="Delete"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <tr id="childcat_new_row">
                    <td>Auto</td>
                    <td>
                        <select class="form-control" id="new_cc_subcategory">
                            <option value="">-- Select Sub Category --</option>
                            <?php foreach ($subcategories as $sc): ?>
                                <option value="<?= $sc->sub_category_id ?>"><?= htmlspecialchars($sc->sub_category_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" id="new_cc_name" placeholder="New child category name"></td>
                    <td>
                        <a href="javascript:void(0)" id="add_childcategory" class="btn btn-xs bg-orange" title="Add"><span class="fa fa-plus"></span></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php else: ?>

<div class="row mt-3">
    <div class="col-md-12">
        <p class="text-muted">Save the category first to manage its sub categories and child categories.</p>
    </div>
</div>

<?php endif; ?>

</div>
</div>
</div>
</div>

<?php if (isset($category)): ?>
<script>
var categoryId = <?= $category['category_id'] ?>;
var baseUrl = "<?php echo base_url(); ?>";

// add sub category
$(document).on("click", "#add_subcategory", function () {

    var name = $("#new_sc_name").val().trim();

    if (name === "") {
        alert("Enter sub category name");
        return;
    }

    $.ajax({
        url: baseUrl + "index.php/Setup/save_subcategory",
        type: "POST",
        data: { category_id: categoryId, sub_category_name: name },
        dataType: "json",
        success: function (res) {

            if (res.status == 1) {

                var row = '<tr data-id="' + res.sub_category_id + '">' +
                    '<td>' + res.sub_category_code + '</td>' +
                    '<td><input type="text" class="form-control sc_name" value="' + name + '"></td>' +
                    '<td>' +
                    '<a href="javascript:void(0)" class="btn btn-xs bg-orange sc_update" title="Update"><span class="fa fa-save"></span></a> ' +
                    '<a href="javascript:void(0)" class="btn btn-xs bg-orange sc_delete" title="Delete"><span class="fa fa-trash"></span></a>' +
                    '</td></tr>';

                $("#subcat_new_row").before(row);
                $("#new_sc_name").val("");

                var option = '<option value="' + res.sub_category_id + '">' + name + '</option>';
                $("#new_cc_subcategory").append(option);
            }
        }
    });
});

// update sub category
$(document).on("click", ".sc_update", function () {

    var row = $(this).closest("tr");
    var id = row.data("id");
    var name = row.find(".sc_name").val().trim();

    if (name === "") {
        alert("Enter sub category name");
        return;
    }

    $.ajax({
        url: baseUrl + "index.php/Setup/save_subcategory",
        type: "POST",
        data: { category_id: categoryId, sub_category_id: id, sub_category_name: name },
        dataType: "json",
        success: function (res) {

            if (res.status == 1) {
                alert("Sub category updated");
                $('.cc_subcategory option[value="' + id + '"]').text(name);
                $('#new_cc_subcategory option[value="' + id + '"]').text(name);
            }
        }
    });
});

// delete sub category
$(document).on("click", ".sc_delete", function () {

    if (!confirm("Are you sure you want to delete this sub category?")) {
        return;
    }

    var row = $(this).closest("tr");
    var id = row.data("id");

    $.ajax({
        url: baseUrl + "index.php/Setup/delete_subcategory",
        type: "POST",
        data: { sub_category_id: id },
        success: function (msg) {

            if (msg == 1) {
                row.remove();
                $('.cc_subcategory option[value="' + id + '"]').remove();
                $('#new_cc_subcategory option[value="' + id + '"]').remove();
            } else {
                alert("Can't delete. Data already used!");
            }
        }
    });
});

// add child category
$(document).on("click", "#add_childcategory", function () {

    var subCategoryId = $("#new_cc_subcategory").val();
    var name = $("#new_cc_name").val().trim();

    if (subCategoryId === "" || name === "") {
        alert("Select sub category and enter child category name");
        return;
    }

    $.ajax({
        url: baseUrl + "index.php/Setup/save_childcategory",
        type: "POST",
        data: { sub_category_id: subCategoryId, child_category_name: name },
        dataType: "json",
        success: function (res) {

            if (res.status == 1) {

                var options = $("#new_cc_subcategory").html();

                var row = '<tr data-id="' + res.child_category_id + '">' +
                    '<td>' + res.child_category_code + '</td>' +
                    '<td><select class="form-control cc_subcategory">' + options + '</select></td>' +
                    '<td><input type="text" class="form-control cc_name" value="' + name + '"></td>' +
                    '<td>' +
                    '<a href="javascript:void(0)" class="btn btn-xs bg-orange cc_update" title="Update"><span class="fa fa-save"></span></a> ' +
                    '<a href="javascript:void(0)" class="btn btn-xs bg-orange cc_delete" title="Delete"><span class="fa fa-trash"></span></a>' +
                    '</td></tr>';

                $("#childcat_new_row").before(row);
                $("#childcat_body tr[data-id='" + res.child_category_id + "'] .cc_subcategory").val(subCategoryId);
                $("#new_cc_name").val("");
            }
        }
    });
});

// update child category
$(document).on("click", ".cc_update", function () {

    var row = $(this).closest("tr");
    var id = row.data("id");
    var subCategoryId = row.find(".cc_subcategory").val();
    var name = row.find(".cc_name").val().trim();

    if (name === "") {
        alert("Enter child category name");
        return;
    }

    $.ajax({
        url: baseUrl + "index.php/Setup/save_childcategory",
        type: "POST",
        data: { child_category_id: id, sub_category_id: subCategoryId, child_category_name: name },
        dataType: "json",
        success: function (res) {

            if (res.status == 1) {
                alert("Child category updated");
            }
        }
    });
});

// delete child category
$(document).on("click", ".cc_delete", function () {

    if (!confirm("Are you sure you want to delete this child category?")) {
        return;
    }

    var row = $(this).closest("tr");
    var id = row.data("id");

    $.ajax({
        url: baseUrl + "index.php/Setup/delete_childcategory",
        type: "POST",
        data: { child_category_id: id },
        success: function (msg) {

            if (msg == 1) {
                row.remove();
            } else {
                alert("Can't delete. Data already used!");
            }
        }
    });
});
</script>
<?php endif; ?>