<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12">
<div class="x_panel">
<div class="x_content">
<br />

<form action="<?php echo base_url().'index.php/Setup/' . (isset($material) && $material ? 'update_raw_material_data/'.$material->material_id : 'add_raw_material_data'); ?>"
      method="post" autocomplete="off" id="rawMaterial">

<div class="row">

    <!-- Material Code -->
    <div class="col-md-6">
        <label>Material Code <span class="required">*</span></label>
        <input type="text" id="material_code" name="material_code" required class="form-control"
            value="<?= isset($material) && $material ? htmlspecialchars($material->material_code) : '' ?>">
    </div>

    <!-- Material Name -->
    <div class="col-md-6">
        <label>Material Name <span class="required">*</span></label>
        <input type="text" id="material_name" name="material_name" required class="form-control"
            value="<?= isset($material) && $material ? htmlspecialchars($material->material_name) : '' ?>">
    </div>

    <!-- Unit -->
    <div class="col-md-6 mt-2">
        <label>Unit <span class="required">*</span></label>
        <select name="unit" id="unit" class="form-control" required>
            <option value="">-- Select Unit --</option>
            <?php foreach ($active_units as $unit): ?>
                <option value="<?= htmlspecialchars($unit->unit_name) ?>"
                    <?= (isset($material) && $material && $material->unit == $unit->unit_name) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($unit->unit_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Submit -->
<div class="row mt-3">
    <div class="col-md-12 text-center">
        <button type="submit" id="saveBtn" class="btn btn-success">
            <?= isset($material) && $material ? 'Update' : 'Submit' ?>
        </button>
    </div>
</div>

</form>

</div>
</div>
</div>
</div>
<script>
document.getElementById("rawMaterial").addEventListener("submit", function (e) {
    var btn = document.getElementById("saveBtn");

    if (btn.disabled) {
        e.preventDefault();
        return false;
    }

    btn.disabled = true;
    btn.innerHTML = "Processing...";
});
</script>