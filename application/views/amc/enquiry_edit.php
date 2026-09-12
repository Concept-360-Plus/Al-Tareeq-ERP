<div class="card-body">
	<form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>AMC/update_enquiry_data" id="addform" autocomplete="off" enctype="multipart/form-data">
		<?php foreach ($records as $row) : ?>

		<div class="form-group row">

	  		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 col-form-label">Enq:Code</label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-2">
		    			<input type="text" class="form-control form-control-sm" id="amc_enq_code" name="amc_enq_code" value="<?php echo $row->amc_enq_code; ?>" tabindex=1 readonly>
						<input type="hidden" id="amc_enq_id" name="amc_enq_id" value="<?php echo $row->amc_enq_id; ?>" tabindex=1>
				</div>
				<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Customer:</label>
		    <div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
			     <input type='text' tabindex="5" class="form-control form-control-sm" id="customer_name" name="customer_name" value="<?php echo $row->cust_code." ".$row->cust_name?>" readonly ="true" />
				 <input type='hidden' tabindex="5" class="form-control form-control-sm" id="cust_id" name="cust_id" value="<?php echo $row->cust_id?>" readonly ="true" />
		    </div>
    	    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 col-form-label">Enq:Date </label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-2" role='group'>				
				<div class="input-group date datepicker1">

				<input
					type="date"
					class="form-control"
					name="enq_date"
					id="enq_date"
					value="<?php echo !empty($row->enq_date) ? date('Y-m-d', strtotime($row->enq_date)) : ''; ?>"
					required>

			</div>

    	    </div>

		</div>

		<div class="form-group row">

	  		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 col-form-label">Enq:Type</label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
	    			<select tabindex="4" class="form-select form-control-sm select2" id="enquiry_type" name="enquiry_type" required onchange="get_div_active();">
					<option value="2" <?php echo ($row->enq_type == '2') ? 'selected' : ''; ?>>New Products</option>
					<option value="1" <?php echo ($row->enq_type == '1') ? 'selected' : ''; ?>>Company Products</option>
					<option value="3" <?php echo ($row->enq_type == '3') ? 'selected' : ''; ?>>Partial Company / Partial New</option>
			      </select>
	  		</div>
			  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Name</label>
			<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
					<input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo $row->project_name; ?>">
			</div>

		</div>
		<div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Remark/Comments </label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-6">
	    			<input type='text' tabindex="9" class="form-control form-control-sm" id="remark" name="remark" placeholder="" value="<?php echo $row->remark; ?>" />
	  		</div>
		</div>

		<div class="form-group row">
	  		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Client Ref No  </label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-2" >
	    			<input type="text" class="form-control form-control-sm" id="client_ref" name="client_ref" value="<?php echo $row->client_ref; ?>" tabindex=8>
    	    </div>
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-3 col-form-label">Upload Document(PDF/PNG/JPEG) </label>
	  		<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
	    			<input type='file' tabindex="501" class="form-control form-control-sm" id="other_file" name="other_file" placeholder="" />
	  		</div>

		</div>

		<!-- ========================================================= -->
		<!-- ================= Details Table (matches Add page) ==== -->
		<!-- ========================================================= -->

		<div class="d-flex justify-content-between align-items-center mb-2">

			<h4 class="mb-0">
				Details
			</h4>

			<button
				type="button"
				id="add_item_row"
				class="btn btn-sm btn-success">

				<i class="fa fa-plus"></i>
				Add Row

			</button>

		</div>

		<table class="table table-bordered table-hover">

			<thead>

				<tr>

					<th>
						Product Code
					</th>

					<!-- <th>
						Description
					</th> -->
					<th>
						Brand
					</th>

					<th>
						Qty
					</th>

					<th style="width:70px;">
						Action
					</th>

				</tr>

			</thead>

			<tbody id="mytbbody">

			<?php if (!empty($trans_records)) : $i = 0; foreach ($trans_records as $s) : ?>

				<tr id="addr<?php echo $i; ?>">

					<!-- Product -->
					<td>

						<select
							class="form-control select2 item-select"
							name="item_id[]"
							id="item<?php echo $i; ?>"
							onchange="get_item_by_id(<?php echo $i; ?>)">

							<option value="">
								Select
							</option>

							<option value="new">
								+ Add New Product
							</option>

							<?php foreach ($active_items as $item) : ?>

								<option value="<?php echo $item->product_id; ?>"
									<?php echo ($item->product_id == $s->product_id) ? 'selected' : ''; ?>>

									<?php echo $item->product_name; ?>

								</option>

							<?php endforeach; ?>

						</select>

					</td>

					<!-- Description -->
					<!-- <td>

						<input
							type="text"
							name="prod_desc[]"
							id="desc<?php echo $i; ?>"
							class="form-control form-control-sm"
							value="<?php echo html_escape($s->desc); ?>">

					</td> -->

					<td>

						<input
							type="text"
							name="brand[]"
							id="brand<?php echo $i; ?>"
							class="form-control form-control-sm"
							value="<?php echo html_escape($s->brand); ?>">

					</td>

					<!-- Quantity -->
					<td>

						<input
							type="number"
							name="pro_qty[]"
							class="form-control form-control-sm qty-input"
							min="0"
							step="any"
							value="<?php echo $s->quantity; ?>">

					</td>

					<!-- Delete -->
					<td class="text-center">

						<button
							type="button"
							class="btn btn-sm bg-orange remove_row"
							title="Delete Row">

							<i class="fa fa-trash"></i>

						</button>

					</td>

				</tr>

			<?php $i++; endforeach; else : ?>

				<!-- fallback empty row if enquiry currently has no items -->
				<tr id="addr0">

					<td>

						<select
							class="form-control select2 item-select"
							name="item_id[]"
							id="item0"
							onchange="get_item_by_id(0)">

							<option value="">
								Select
							</option>

							<option value="new">
								+ Add New Product
							</option>

							<?php foreach ($active_items as $item) : ?>

								<option value="<?php echo $item->product_id; ?>">

									<?php echo $item->product_name; ?>

								</option>

							<?php endforeach; ?>

						</select>

					</td>

					<!-- <td>

						<input
							type="text"
							name="prod_desc[]"
							id="desc0"
							class="form-control form-control-sm">

					</td> -->

						<td>

						<input
							type="text"
							name="brand[]"
							id="brand"
							class="form-control form-control-sm">
					</td>


					<td>

						<input
							type="number"
							name="pro_qty[]"
							class="form-control form-control-sm qty-input"
							min="0"
							step="any">

					</td>

					<td class="text-center">

						<button
							type="button"
							class="btn btn-sm bg-orange remove_row"
							title="Delete Row">

							<i class="fa fa-trash"></i>

						</button>

					</td>

				</tr>

			<?php endif; ?>

			</tbody>

		</table>

		<?php endforeach; ?>

		<div class="col-sm-8" style="margin-bottom:10px;">
			<button type="submit" tabindex="31" id="add" class="btn btn-primary m-b-0">Update Enquiry</button>
			<button type="reset" id='reset' class="btn btn-primary m-b-0">Reset</button>
			<button class="btn btn-primary m-b-0" onclick="goBack()">Back</button>
		</div>

	</form>
</div>

<script>

/* =========================================================
 * Active items as JSON (safe — json_encode escapes backslashes,
 * quotes, etc. automatically). Never echo PHP product/customer
 * text directly inside a JS template literal — a stray backslash
 * in a product name (e.g. "600\X600") breaks JS parsing with
 * "Invalid hexadecimal escape sequence" and silently kills every
 * handler registered later in the same ready block.
 * ========================================================= */
var activeItems = <?php echo json_encode($active_items); ?>;

$(function () {

	/* =========================================================
	 * Row Counter (start after the last pre-rendered row)
	 * ========================================================= */

	let rowIndex = <?php echo (!empty($trans_records)) ? count($trans_records) : 1; ?>;


	/* =========================================================
	 * Initialize Select2
	 * ========================================================= */

	$('.select2').select2({
		width: '100%'
	});


	/* =========================================================
	 * Prevent Enter Form Submit
	 * ========================================================= */

	$(document).on('keydown', '#main input, #main select', function(e) {

		if (
			(e.key === 'Enter' || e.which === 13)
			&&
			$(this).hasClass('qty-input')
		) {

			return;

		}

		if (e.key === 'Enter' || e.which === 13) {

			e.preventDefault();

		}

	});


	/* =========================================================
	 * Add Row Button
	 * ========================================================= */

	$(document).on('click', '#add_item_row', function() {

		addNewRow();

	});


	/* =========================================================
	 * Add New Row When Enter Pressed In Qty
	 * ========================================================= */

	$(document).on('keydown', '.qty-input', function(e) {

		if (e.key === 'Enter' || e.which === 13) {

			e.preventDefault();

			addNewRow();

		}

	});


	/* =========================================================
	 * Add New Item Row
	 * ========================================================= */
	function addNewRow() {

		let currentIndex = rowIndex;

		/* Build the product <select> via DOM methods — .text() escapes
		   product names safely, no matter what characters they contain. */
		let $select = $('<select>', {
			class: 'form-control select2 item-select',
			name: 'item_id[]',
			id: 'item' + currentIndex,
			onchange: 'get_item_by_id(' + currentIndex + ')'
		});

		$select.append($('<option>', { value: '' }).text('Select'));
		$select.append($('<option>', { value: 'new' }).text('+ Add New Product'));

		activeItems.forEach(function (item) {
			$select.append(
				$('<option>', { value: item.product_id }).text(item.product_name)
			);
		});

		// let $descInput = $('<input>', {
		// 	type: 'text',
		// 	name: 'prod_desc[]',
		// 	id: 'desc' + currentIndex,
		// 	class: 'form-control form-control-sm'
		// });

			let $brandInput = $('<input>', {
			type: 'text',
			name: 'brand[]',
			id: 'brand' + currentIndex,
			class: 'form-control form-control-sm'
		});

		let $qtyInput = $('<input>', {
			type: 'number',
			name: 'pro_qty[]',
			class: 'form-control form-control-sm qty-input',
			min: '0',
			step: 'any'
		});

		let $deleteBtn = $('<button>', {
			type: 'button',
			class: 'btn btn-sm bg-orange remove_row',
			title: 'Delete Row'
		}).html('<i class="fa fa-trash"></i>');

		let $row = $('<tr>', { id: 'addr' + currentIndex });

		$row.append($('<td>').append($select));
		//$row.append($('<td>').append($descInput));
		$row.append($('<td>').append($brandInput));

		$row.append($('<td>').append($qtyInput));
		$row.append($('<td>', { class: 'text-center' }).append($deleteBtn));

		$('#mytbbody').append($row);

		$select.select2({
			width: '100%'
		});

		rowIndex++;

	}


	/* =========================================================
	 * Remove Item Row
	 * ========================================================= */

	$(document).on('click', '.remove_row', function() {

		let totalRows = $('#mytbbody tr').length;

		if (totalRows <= 1) {

			let $row = $(this).closest('tr');

			$row.find('select[name="item_id[]"]')
				.val('')
				.trigger('change');

			// $row.find('input[name="prod_desc[]"]')
			// 	.val('');

			$row.find('input[name="brand[]"]')
				.val('');

			$row.find('input[name="pro_qty[]"]')
				.val('');

			return;

		}

		$(this)
			.closest('tr')
			.remove();

	});

});

function confirmcancel(id)
{
	var r = confirm("Are you sure you want to Delete Record?");
	if (r == true)
	{
		$.ajax({
			url: "<?php echo base_url()?>index.php/Ajax/delete_record",
			type: "POST",
			data: {table_name:'amc_enquiry_transaction', where_key:'trans_id', where_val:id},
			success: function(msg) {
				if (msg == 1)
				{
					alert("Record deleted");
					window.location.href = "<?php echo $_SERVER['PHP_SELF']?>";
				}
				else {
					alert("Can't Delete record. Data already used!!!");
				}
			},
		});
		return true;
	}
	else
		return false;
}

</script>