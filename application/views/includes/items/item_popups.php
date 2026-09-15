


<button type="button" id="qa_hidden_trigger" data-toggle="modal" data-target="#quickAddItemModal" style="display:none;"></button>
<button type="button" id="et_hidden_trigger" data-toggle="modal" data-target="#editItemTypeModal" style="display:none;"></button>

<!-- Quick Add Item Modal -->
<div class="modal fade" id="quickAddItemModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Item</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
            <div class="modal-body">
        <div class="row">
          <div class="col-md-6 form-group">
            <label>Product Code <span class="text-danger">*</span></label>
            <input type="text" id="qa_product_code" class="form-control" required>
          </div>
          <div class="col-md-6 form-group">
            <label>Product Name <span class="text-danger">*</span></label>
            <input type="text" id="qa_product_name" class="form-control" required>
          </div>
          <div class="col-md-12 form-group">
            <label>Description <span class="text-danger">*</span></label>
            <textarea id="qa_description" class="form-control" rows="2" required></textarea>
          </div>
          <div class="col-md-4 form-group">
            <label>Main Category <span class="text-danger">*</span></label>
            <select id="qa_category_id" class="form-control" required>
              <option value="">-- Select Category --</option>
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Sub Category</label>
            <select id="qa_sub_category_id" class="form-control" disabled>
              <option value="">-- Select Sub Category --</option>
            </select>
          </div>
          <div class="col-md-4 form-group">
            <label>Child Category</label>
            <select id="qa_child_category_id" class="form-control" disabled>
              <option value="">-- Select Child Category --</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label>Unit <span class="text-danger">*</span></label>
            <select id="qa_unit_id" class="form-control"><option value="">-- Select Unit --</option></select>
          </div>
          <div class="col-md-6 form-group">
            <label>Retail Price</label>
            <input type="number" step="any" id="qa_retail_price" class="form-control">
          </div>
          <div class="col-md-6 form-group">
            <label>Product Type <span class="text-danger">*</span></label>
            <select id="qa_product_type" class="form-control">
              <option value="finished">Finished</option>
              <option value="custom_made">Custom Made</option>
            </select>
          </div>
        </div>

        <div id="qa_raw_material_section" style="display:none;">
          <label>Raw Materials</label>
          <table class="table table-bordered table-sm" id="qa_material_table">
            <thead>
             <tr><th>Material</th><th>Qty</th><th>Unit</th><th width="30"></th></tr>
            </thead>
            <tbody id="qa_material_tbody"></tbody>
          </table>
          <button type="button" class="btn btn-xs btn-info" id="qa_add_material_row">
            <i class="fa fa-plus"></i> Add Material
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="qa_cancel_btn" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="qa_save_btn">Save Item</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Item Type / Raw Materials Modal -->
<div class="modal fade" id="editItemTypeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Item Type / Raw Materials</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="et_product_id">
        <div class="row">
          <div class="col-md-6 form-group">
            <label>Product</label>
            <input type="text" id="et_product_label" class="form-control" readonly>
          </div>
          <div class="col-md-6 form-group">
            <label>Product Type <span class="text-danger">*</span></label>
            <select id="et_product_type" class="form-control">
              <option value="finished">Finished</option>
              <option value="custom_made">Custom Made</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label>Retail Price</label>
            <input type="number" step="any" id="et_retail_price" class="form-control">
          </div>
          <div class="col-md-12 form-group">
            <label>Description</label>
            <textarea id="et_description" class="form-control" rows="2"></textarea>
          </div>
        </div>

        <div id="et_raw_material_section" style="display:none;">
          <label>Raw Materials</label>
          <table class="table table-bordered table-sm" id="et_material_table">
            <thead>
              <tr><th>Material</th><th>Qty</th><th>Unit</th><th width="30"></th></tr>
            </thead>
            <tbody id="et_material_tbody"></tbody>
          </table>
          <button type="button" class="btn btn-xs btn-info" id="et_add_material_row">
            <i class="fa fa-plus"></i> Add Material
          </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="et_cancel_btn" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="et_save_btn">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<style>
#qa_material_table td, #et_material_table td { vertical-align: middle; }
</style>

<script>
var ItemPopups = (function($){

    var unitsCache = null;
    var materialsCache = null;
    var categoriesCache = null;

    function showModal(id) {
        var triggerId = (id === 'quickAddItemModal') ? 'qa_hidden_trigger' : 'et_hidden_trigger';
        document.getElementById(triggerId).click();
    }

    function hideModal(id) {
        var closeId = (id === 'quickAddItemModal') ? 'qa_cancel_btn' : 'et_cancel_btn';
        document.getElementById(closeId).click();
    }

    function unitOptionsHtml() {
        var html = '<option value="">-- Select Unit --</option>';
        $.each(unitsCache, function(i, u){
            html += '<option value="'+u.unit_id+'">'+u.unit_name+'</option>';
        });
        return html;
    }

    function categoryOptionsHtml() {
        var html = '<option value="">-- Select Category --</option>';
        $.each(categoriesCache, function(i, c){
            html += '<option value="'+c.category_id+'">'+c.category_name+'</option>';
        });
        return html;
    }

    function materialOptionsHtml() {
        var html = '<option value="">-- Select Material --</option>';
        $.each(materialsCache, function(i, m){
            html += '<option value="'+m.material_id+'" data-cost="'+m.cost+'" data-unit="'+m.unit+'">'+m.material_name+'</option>';
        });
        return html;
    }

    function loadUnitsAndMaterials(callback) {
        if (unitsCache && materialsCache && categoriesCache) { callback(); return; }

        $.ajax({
            url: baseUrl + 'index.php/Setup/ajax_get_units_materials',
            type: 'GET',
            dataType: 'json',
            success: function(res){
                unitsCache = res.units;
                materialsCache = res.materials;
                categoriesCache = res.categories;
                callback();
            }
        });
    }

    function materialRowHtml() {
        return '<tr>' +
            '<td><select class="form-control form-control-sm material_select">'+materialOptionsHtml()+'</select></td>' +
            '<td><input type="number" step="1" class="form-control form-control-sm qty"></td>' +
            '<td><select class="form-control form-control-sm unit_select">'+unitOptionsHtml()+'</select></td>' +
            '<td><button type="button" class="btn btn-xs btn-danger remove_material_row"><i class="fa fa-trash"></i></button></td>' +
            '</tr>';
    }

    $(document).on('change', '.material_select', function(){
      var selected = $(this).find(':selected');
      var row = $(this).closest('tr');
      if (selected.data('unit') !== undefined) row.find('.unit_select').val(selected.data('unit'));
  });

        $(document).on('click', '.remove_material_row', function(){
        $(this).closest('tr').remove();
    });

        // Load sub categories for the selected main category
    $(document).on('change', '#qa_category_id', function(){
        var categoryId = $(this).val();
        var subSelect = $('#qa_sub_category_id');
        var childSelect = $('#qa_child_category_id');

        subSelect.html('<option value="">-- Select Sub Category --</option>').prop('disabled', true);
        childSelect.html('<option value="">-- Select Child Category --</option>').prop('disabled', true);

        if (!categoryId) { return; }

        $.ajax({
            url: baseUrl + 'index.php/Setup/get_subcategories_ajax',
            type: 'POST',
            dataType: 'json',
            data: { category_id: categoryId },
            success: function(res){
                $.each(res, function(i, s){
                    subSelect.append('<option value="'+s.sub_category_id+'">'+s.sub_category_name+'</option>');
                });
                subSelect.prop('disabled', false);
            }
        });
    });

    // Load child categories for the selected sub category
    $(document).on('change', '#qa_sub_category_id', function(){
        var subCategoryId = $(this).val();
        var childSelect = $('#qa_child_category_id');

        childSelect.html('<option value="">-- Select Child Category --</option>').prop('disabled', true);

        if (!subCategoryId) { return; }

        $.ajax({
            url: baseUrl + 'index.php/Setup/get_childcategories_ajax',
            type: 'POST',
            dataType: 'json',
            data: { sub_category_id: subCategoryId },
            success: function(res){
                $.each(res, function(i, c){
                    childSelect.append('<option value="'+c.child_category_id+'">'+c.child_category_name+'</option>');
                });
                childSelect.prop('disabled', false);
            }
        });
    });

    // ---------- QUICK ADD ----------

    function resetQuickAddForm() {
        $('#qa_product_code, #qa_product_name, #qa_retail_price, #qa_description').val('');
        $('#qa_product_type').val('finished');
        $('#qa_category_id').val('');
        $('#qa_sub_category_id').html('<option value="">-- Select Sub Category --</option>').prop('disabled', true);
        $('#qa_child_category_id').html('<option value="">-- Select Child Category --</option>').prop('disabled', true);
        $('#qa_material_tbody').html('');
        $('#qa_raw_material_section').hide();
    }

    function openQuickAddModal() {
        loadUnitsAndMaterials(function(){
            resetQuickAddForm();
            $('#qa_unit_id').html(unitOptionsHtml());
            $('#qa_category_id').html(categoryOptionsHtml());
            showModal('quickAddItemModal');
        });
    }
    $(document).on('click', '.openQuickAddItemBtn', function(){
        openQuickAddModal();
    });

    $(document).on('change', '#qa_product_type', function(){
        $('#qa_raw_material_section').toggle($(this).val() === 'custom_made');
    });

    $(document).on('click', '#qa_add_material_row', function(){
        $('#qa_material_tbody').append(materialRowHtml());
    });

        $(document).on('click', '#qa_save_btn', function(){

        var productCode = $('#qa_product_code').val().trim();
        var productName = $('#qa_product_name').val().trim();
        var description = $('#qa_description').val().trim();
        var categoryId = $('#qa_category_id').val();

        if (!productCode || !productName || !description || !categoryId) {
            alert('Product code, product name, description and main category are required.');
            return;
        }

        var materials = [];
        $('#qa_material_tbody tr').each(function(){
            materials.push({
                material_id: $(this).find('.material_select').val(),
                qty: $(this).find('.qty').val(),
                unit: $(this).find('.unit_select').val()
            });
        });

        $.ajax({
            url: baseUrl + 'index.php/Setup/ajax_quick_add_item',
            type: 'POST',
            dataType: 'json',
            data: {
                product_code: productCode,
                product_name: productName,
                description: description,
                category_id: categoryId,
                sub_category_id: $('#qa_sub_category_id').val(),
                child_category_id: $('#qa_child_category_id').val(),
                unit_id: $('#qa_unit_id').val(),
                retail_price: $('#qa_retail_price').val(),
                product_type: $('#qa_product_type').val(),
                materials: materials
            },
            success: function(res){
                if (res.status) {
                    hideModal('quickAddItemModal');
                    $(document).trigger('itemQuickAdded', [res.item]);
                } else {
                    alert(res.message || 'Could not save item.');
                }
            }
        });
    });

    // ---------- EDIT TYPE / MATERIALS ----------

    function openEditModal(productId) {
        loadUnitsAndMaterials(function(){
            $.ajax({
                url: baseUrl + 'index.php/Setup/ajax_get_item_for_edit/' + productId,
                type: 'GET',
                dataType: 'json',
                success: function(res){
                    if (!res.status) { alert(res.message || 'Item not found.'); return; }

                    $('#et_product_id').val(res.item.product_id);
                    $('#et_product_label').val(res.item.product_code + ' - ' + res.item.product_name);
                    $('#et_product_type').val(res.item.product_type);
                    $('#et_retail_price').val(res.item.retail_price);
                    $('#et_description').val(res.item.description);
                    $('#et_material_tbody').html('');

                    $.each(res.raw_materials, function(i, r){
                        var row = $(materialRowHtml());
                        row.find('.material_select').val(r.material_id);
                        row.find('.qty').val(r.quantity_required);
                        row.find('.unit_select').val(r.unit);
                        $('#et_material_tbody').append(row);
                    });

                    $('#et_raw_material_section').toggle(res.item.product_type === 'custom_made');
                    showModal('editItemTypeModal');
                }
            });
        });
    }

    $(document).on('click', '.editItemTypeBtn', function(){
        openEditModal($(this).data('product-id'));
    });

    $(document).on('change', '#et_product_type', function(){
        $('#et_raw_material_section').toggle($(this).val() === 'custom_made');
    });

    $(document).on('click', '#et_add_material_row', function(){
        $('#et_material_tbody').append(materialRowHtml());
    });

    $(document).on('click', '#et_save_btn', function(){

        var materials = [];
        $('#et_material_tbody tr').each(function(){
            materials.push({
                material_id: $(this).find('.material_select').val(),
                qty: $(this).find('.qty').val(),
                uprice: $(this).find('.uprice').val(),
                unit: $(this).find('.unit_select').val()
            });
        });

          $.ajax({
            url: baseUrl + 'index.php/Setup/ajax_update_item_type_materials',
            type: 'POST',
            dataType: 'json',
            data: {
                product_id: $('#et_product_id').val(),
                product_type: $('#et_product_type').val(),
                retail_price: $('#et_retail_price').val(),
                description: $('#et_description').val(),
                materials: materials
            },
            success: function(res){
                if (res.status) {
                    hideModal('editItemTypeModal');
                    $(document).trigger('itemTypeMaterialsUpdated', [res.item]);
                } else {
                    alert(res.message || 'Could not update item.');
                }
            }
        });
    });

    return { openQuickAddModal: openQuickAddModal, openEditModal: openEditModal };

})(jQuery);
</script>