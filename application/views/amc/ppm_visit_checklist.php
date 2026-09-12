<div class="card-body">
	<h5>Visit Checklist — <?php echo $visit->project_name ?? ''; ?> (<?php echo $visit->ppmnum ?? ''; ?>)</h5>
	<p><b>Customer:</b> <?php echo $visit->customer_name ?? '-'; ?> | <b>Technician:</b> <?php echo $visit->ppm_tech ?? '-'; ?> | <b>Visit Date:</b> <?php echo $visit->ppm_visit_date ?? '-'; ?></p>

	<form id="checklistForm">
		<input type="hidden" name="ppm_detail_id" value="<?php echo $ppm_detail_id; ?>">

		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="5%">#</th>
					<th width="50%">Checklist Item</th>
					<th width="10%">Checked</th>
					<th width="35%">Remarks</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($checklist as $i => $c): ?>
				<tr>
					<td><?php echo $i+1; ?></td>
					<td>
						<?php echo html_escape($c->checklist_item); ?>
						<input type="hidden" name="checklist_item[]" value="<?php echo html_escape($c->checklist_item); ?>">
					</td>
					<td class="text-center">
						<input type="checkbox" name="is_checked[<?php echo $i; ?>]" value="1" <?php echo $c->is_checked ? 'checked' : ''; ?>>
					</td>
					<td>
						<input type="text" class="form-control form-control-sm" name="remarks[<?php echo $i; ?>]" value="<?php echo html_escape($c->remarks ?? ''); ?>">
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>

		<button type="button" class="btn btn-success btn-sm" onclick="saveChecklist()">Save Checklist</button>
	</form>

	<hr>
	<h6>Replacement / Spare Parts Noticed During Visit</h6>

	<table class="table table-bordered" id="replacementTable">
		<thead>
			<tr>
				<th width="5%">✓</th>
				<th>Item</th>
				<th>Qty</th>
				<th>Unit Price</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody id="replacementBody">
		<?php foreach ($replacements as $r): ?>
			<tr>
				<td><input type="checkbox" class="repl_chk" value="<?php echo $r->replacement_id; ?>"></td>
				<td><?php echo html_escape($r->item_name); ?></td>
				<td><?php echo $r->qty; ?></td>
				<td><?php echo $r->unit_price; ?></td>
				<td><?php echo $r->total; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<div class="form-group row">
		<div class="col-md-3"><input type="text" id="new_item_name" class="form-control form-control-sm" placeholder="Item name"></div>
		<div class="col-md-2"><input type="number" id="new_qty" class="form-control form-control-sm" placeholder="Qty" value="1"></div>
		<div class="col-md-2"><input type="number" id="new_price" class="form-control form-control-sm" placeholder="Unit Price" value="0"></div>
		<div class="col-md-2"><button type="button" class="btn btn-secondary btn-sm" onclick="addReplacement()">+ Add Item</button></div>
	</div>

	<button type="button" class="btn btn-primary btn-sm" onclick="prepareQuotation()">Prepare Quotation from Selected Items</button>
</div>

<script>
function saveChecklist() {
	$.ajax({
		url: "<?php echo base_url('index.php/AMC/save_visit_checklist'); ?>",
		type: "POST",
		dataType: "json",  
		data: $('#checklistForm').serialize(),
		success: function(res) {
			alert('Checklist saved');
		}
	});
}

function addReplacement() {
	var item  = $('#new_item_name').val();
	var qty   = $('#new_qty').val();
	var price = $('#new_price').val();

	if (!item) { alert('Enter item name'); return; }

	$.ajax({
		url: "<?php echo base_url('index.php/AMC/add_ppm_replacement'); ?>",
		type: "POST",
		dataType: "json", 
		data: {
			ppm_detail_id: "<?php echo $ppm_detail_id; ?>",
			quote_id: "<?php echo $visit->quote_id ?? ''; ?>",
			item_name: item,
			qty: qty,
			unit_price: price
		},
		success: function(res) {
			var total = (qty * price).toFixed(2);
			$('#replacementBody').append(
				'<tr><td><input type="checkbox" class="repl_chk" value="'+res.replacement_id+'"></td>' +
				'<td>'+item+'</td><td>'+qty+'</td><td>'+price+'</td><td>'+total+'</td></tr>'
			);
			$('#new_item_name').val('');
		}
	});
}

// function prepareQuotation() {
// 	var ids = [];
// 	$('.repl_chk:checked').each(function(){ ids.push($(this).val()); });

// 	if (ids.length == 0) { alert('Select at least one item'); return; }

// 	$.ajax({
// 		url: "<?php echo base_url('index.php/AMC/prepare_replacement_quotation'); ?>",
// 		type: "POST",
// 		dataType: "json",
// 		data: { ppm_detail_id: "<?php echo $ppm_detail_id; ?>", replacement_ids: ids },
// 		success: function(res) {
// 			if (res.status == 'success') {
// 				alert('Quotation created: ' + res.quote_id);
// 				location.reload();
// 			} else {
// 				alert(res.msg);
// 			}
// 		}
// 	});
// }
function prepareQuotation() {
	var ids = [];
	$('.repl_chk:checked').each(function(){ ids.push($(this).val()); });

	if (ids.length == 0) { alert('Select at least one item'); return; }

	var form = $('<form>', {
		action: "<?php echo base_url('index.php/AMC/prepare_replacement_quotation'); ?>",
		method: "POST"
	});

	form.append($('<input>', { type: 'hidden', name: 'ppm_detail_id', value: "<?php echo $ppm_detail_id; ?>" }));

	ids.forEach(function(id) {
		form.append($('<input>', { type: 'hidden', name: 'replacement_ids[]', value: id }));
	});

	$('body').append(form);
	form.submit();
}
</script>