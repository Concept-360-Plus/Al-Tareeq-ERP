<?php $this->load->helper('stock_helper.php'); ?>

<style>
	.select2Width {
		max-width: 320px !important;
		min-width: 320px !important;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
	}
</style>

<div class="card-body">

<form id="main"
	method="post"
	action="<?= base_url('index.php/AMC/add_new_enquiry'); ?>"
	enctype="multipart/form-data"
	autocomplete="off">

	<!-- ================= Customer / Branch ================= -->
	<div class="form-group row">

		<label class="col-md-2 col-form-label">
			Select Branch <span class="text-danger">*</span>
		</label>

		<div class="col-md-4">
			<select name="branch_id" id="branch_id" class="form-control select2" required>

				<option value="">Select Branch</option>

				<?php foreach($branch_list as $branch): ?>

					<option value="<?= $branch->branch_id ?>"
						<?= isset($enquiry_data) && $enquiry_data['branch_id'] == $branch->branch_id ? "selected" : "" ?>>

						<?= $branch->branch_name ?>

					</option>

				<?php endforeach; ?>

			</select>
		</div>


		<label class="col-md-2 col-form-label">
			Customer <span class="text-danger">*</span>
		</label>

		<div class="col-md-4">

			<?= form_error('customer_id', '<small class="text-danger">', '</small>') ?>

			<select name="customer_id" id="customer_id" class="form-control select2">

				<option value="">Select Customer</option>

				<?php foreach ($customer_list as $c): ?>

					<option value="<?= $c->customer_id ?>"
						<?= (isset($enquiry_data['enquiry_customer']) && $enquiry_data['enquiry_customer'] == $c->customer_id) ? 'selected' : '' ?>>

						<?= $c->customer_name ?>
						(<?= $c->customer_code ?>)

					</option>

				<?php endforeach; ?>

			</select>

			<small>
				<a href="#" data-bs-toggle="modal" data-bs-target="#myModal">
					+ Add New Customer
				</a>
			</small>

		</div>

	</div>


	<!-- ================= Enquiry Info ================= -->
	<div class="form-group row">

		<label class="col-md-2 col-form-label">
			Enquiry Code
		</label>

		<div class="col-md-4">

			<input
				type="text"
				class="form-control form-control-sm"
				name="amc_enq_code"
				value="<?= $code; ?>">

		</div>


		<label class="col-md-2 col-form-label">
			Enquiry Date <span class="text-danger">*</span>
		</label>

		<div class="col-md-4">

			<div class="input-group date datepicker1">

				<input
					type="date"
					class="form-control"
					name="enq_date"
					id="enq_date"
					value="<?php echo date('Y-m-d'); ?>"
					required>

			</div>

		</div>

	</div>


	<!-- ================= New Customer ================= -->
	<div id="cust_div" style="display:none;">

		<div class="form-group row">

			<label class="col-md-2 col-form-label">
				Customer Name <span class="text-danger">*</span>
			</label>

			<div class="col-md-4">

				<input
					type="text"
					class="form-control form-control-sm"
					name="customer_name"
					id="customer_name">

			</div>


			<label class="col-md-1 col-form-label">
				Email
			</label>

			<div class="col-md-4">

				<input
					type="email"
					class="form-control form-control-sm"
					name="cust_email">

			</div>


			<label class="col-md-2 col-form-label">
				Mobile No
			</label>

			<div class="col-md-2">

				<input
					type="text"
					class="form-control form-control-sm"
					name="cust_mobile">

			</div>

		</div>

	</div>


	<!-- ================= Enquiry Type ================= -->
	<div class="form-group row">

		<label class="col-md-2 col-form-label">
			Enquiry Type <span class="text-danger">*</span>
		</label>

		<div class="col-md-4">

			<select
				class="form-control form-control-sm select2"
				name="enquiry_type"
				id="enquiry_type"
				required>

				<option value="2">
					New Products
				</option>

				<option value="1">
					Company Products
				</option>

				<option value="3">
					Partial Company / Partial New
				</option>

			</select>

		</div>


		<label class="col-md-2 col-form-label">
			Project Name
		</label>

		<div class="col-md-4">

			<input
				type="text"
				class="form-control"
				name="project_name">

		</div>

	</div>


	<!-- ================= Remarks ================= -->
	<div class="form-group row">

		<label class="col-md-2 col-form-label">
			Remarks
		</label>

		<div class="col-md-4">

			<textarea
				class="form-control form-control-sm"
				name="remark"
				rows="3"
				placeholder="Enter remarks"></textarea>

		</div>

	</div>


	<!-- ================= Reference & File ================= -->
	<div class="form-group row">

		<label class="col-md-2 col-form-label">
			Client Ref No
		</label>

		<div class="col-md-4">

			<input
				type="text"
				class="form-control form-control-sm"
				name="client_ref">

		</div>


		<label class="col-md-2 col-form-label">
			Upload Document (PDF / PNG / JPEG)
		</label>

		<div class="col-md-4">

			<input
				type="file"
				class="form-control form-control-sm"
				name="other_file">

		</div>

	</div>


	<!-- ========================================================= -->
	<!-- ================= Details Table ========================== -->
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

				<!-- <th>
					Unit
				</th> -->

				<th>
					Qty
				</th>

				<th style="width:70px;">
					Action
				</th>

			</tr>

		</thead>


		<tbody id="mytbbody">

			<!-- ================= First Row ================= -->
			<tr id="addr0">

				<!-- Product -->
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

						<?php foreach ($active_items as $item) { ?>

							<option value="<?php echo $item->product_id; ?>">

								<?php echo $item->product_name; ?>

							</option>

						<?php } ?>

					</select>

				</td>


				<!-- Description -->
				<!-- <td>

					<input
						type="text"
						name="prod_desc[]"
						id="desc0"
						class="form-control form-control-sm">

				</td>			 -->

				<!-- Brand -->
				<td>

					<input
						type="text"
						name="brand[]"
						id="brand"
						class="form-control form-control-sm">

				</td>			


				<!-- Quantity -->
				<td>

					<input
						type="number"
						name="pro_qty[]"
						class="form-control form-control-sm qty-input"
						min="0"
						step="any">

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

		</tbody>

	</table>


	<!-- ================= Submit ================= -->
	<div class="form-group row">

		<div class="col-md-10 offset-md-2">

			<button
				type="submit"
				class="btn btn-primary">

				Submit

			</button>

		</div>

	</div>

</form>


</div>

<script>

$(function () {


	/* =========================================================
	 * Row Counter
	 * ========================================================= */

	let rowIndex = 1;


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

		/*
		 * Qty Enter is handled separately.
		 */
		if (
			(e.key === 'Enter' || e.which === 13)
			&&
			$(this).hasClass('qty-input')
		) {

			return;

		}


		/*
		 * Prevent normal form submit
		 * when Enter is pressed in other fields.
		 */
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

let newRow = `

	<tr id="addr${currentIndex}">

		<!-- ================= Product ================= -->
		<td>

			<select
				class="form-control select2 item-select"
				name="item_id[]"
				id="item${currentIndex}"
				onchange="get_item_by_id(${currentIndex})">

				<option value="">
					Select
				</option>

				<option value="new">
					+ Add New Product
				</option>

				<?php foreach ($active_items as $item) { ?>

					<option value="<?php echo $item->product_id; ?>">

						<?php echo $item->product_name; ?>

					</option>

				<?php } ?>

			</select>

		</td>


		<!-- ================= Description ================= 
		<td>

			<input
				type="text"
				name="prod_desc[]"
				id="desc${currentIndex}"
				class="form-control form-control-sm">

		</td>	-->

		<!-- ================= Brand ================= -->
		<td>

			<input
				type="text"
				name="brand[]"
				id="brand${currentIndex}"
				class="form-control form-control-sm">

		</td>		


		<!-- ================= Quantity ================= -->
		<td>

			<input
				type="number"
				name="pro_qty[]"
				class="form-control form-control-sm qty-input"
				min="0"
				step="any">

		</td>


		<!-- ================= Delete ================= -->
		<td class="text-center">

			<button
				type="button"
				class="btn btn-sm bg-orange remove_row"
				title="Delete Row">

				<i class="fa fa-trash"></i>

			</button>

		</td>

	</tr>

`;


/* Add new row */
$('#mytbbody').append(newRow);


/* Initialize Select2 for the new Product dropdown */
$('#item' + currentIndex).select2({
	width: '100%'
});


/* Initialize Select2 for the new Unit dropdown */
$('#unit' + currentIndex).select2({
	width: '100%'
});


/* Increase row index */
rowIndex++;


}



	/* =========================================================
	 * Remove Item Row
	 * ========================================================= */

	$(document).on('click', '.remove_row', function() {

		let totalRows = $('#mytbbody tr').length;


		/*
		 * Keep at least one row.
		 */
		if (totalRows <= 1) {

			let $row = $(this).closest('tr');


			/*
			 * Clear Product.
			 */
			$row.find('select[name="item_id[]"]')
				.val('')
				.trigger('change');


			/*
			 * Clear Description.
			 */
		/*	$row.find('input[name="prod_desc[]"]')
				.val('');  
				*/

			/*
			 * Clear Brand.
			 */

				$row.find('input[name="brand[]"]')
				.val('');


			

			/*
			 * Clear Qty.
			 */
			$row.find('input[name="pro_qty[]"]')
				.val('');


			return;

		}


		/*
		 * Remove selected row.
		 */
		$(this)
			.closest('tr')
			.remove();

	});


	/* =========================================================
	 * Branch → Customer
	 * ========================================================= */

/*	$('#branch_id').on('change', function() {

		let branch_id = $(this).val();


		$('#customer_id')
			.empty()
			.append(
				'<option value="">-- Select Customer --</option>'
			);


		if (!branch_id) {

			return;

		}


		$.ajax({

			url: '<?= base_url("index.php/Company/get_customers_by_branch") ?>',

			type: 'POST',

			dataType: 'json',

			data: {
				branch_id: branch_id
			},

			success: function(data) {

				$.each(data, function(_, customer) {

					$('#customer_id').append(

						`<option value="${customer.customer_id}">
							${customer.customer_name}
							(${customer.customer_code})
							- ${customer.contact_number}
						</option>`

					);

				});


				$('#customer_id').trigger('change');

			}

		});

	});   */

});


/* =========================================================
 * Customer Info
 * ========================================================= */

function get_customer_info() {

	let customer_id = $('#customer_id').val();


	if (customer_id === 'new') {

		$('#cust_div').show();

		$('#customer_name').prop('required', true);

	} else {

		$('#cust_div').hide();

		$('#customer_name').prop('required', false);

		get_invoice_list();

	}

}


/* =========================================================
 * Enquiry Type Check
 * ========================================================= */

function get_div_active() {

	let enq_type = $('#enquiry_type').val();

	let cust_id = $('#customer_id').val();


	if (enq_type != 2) {

		$.post(

			'<?= base_url("index.php/Ajax/get_invoices_of_customer") ?>',

			{
				cust_id: cust_id
			},

			function(msg) {

				$('#enq_form').html(msg);


				$('.select2').select2({
					width: '100%'
				});

			}

		);

	}

}


/* =========================================================
 * Product Description
 * ========================================================= */

function get_product_description(append_id) {

	let pcode = $('#order_code' + append_id).val();

	let cleanCode = pcode.replace(/,/g, '');


	$('#pcode' + append_id).val(cleanCode);


	$.post(

		'<?= site_url("Product/get_product_description") ?>',

		{
			post_id: pcode
		},

		function(msg) {

			if (msg != 0) {

				$('#desc' + append_id).val(msg);

			} else {

				alert('Match not found');

			}

		}

	);

}


/* =========================================================
 * Enquiry Items
 * ========================================================= */

function get_enquiry_info() {

	let enq_id = $('#enq_id').val();


	$.post(

		'<?= base_url("index.php/Ajax/get_enquiry_items_for_enq") ?>',

		{
			enq_id: enq_id,
			rev_version: 1
		},

		function(msg) {

			$('#mytbbody').html(msg);


			/*
			 * Reinitialize Select2 after AJAX
			 * replaces table content.
			 */
			$('#mytbbody .select2').select2({
				width: '100%'
			});

		}

	);

}


/* =========================================================
 * Invoice List
 * ========================================================= */

function get_invoice_list() {

	let cust_id = $('#customer_id').val();


	$.post(

		'<?= site_url("Ajax/ajax_get_inv_list") ?>',

		{
			cust_id: cust_id
		},

		function(res) {

			let invoice = JSON.parse(res);

			let $inv = $('#inv_no');


			$inv.html(
				'<option value="">Select</option>'
			);


			if (invoice) {

				$inv.append(

					`<option value="${invoice.invoice_id}">
						${invoice.invoice_code}
					</option>`

				);

			}

		}

	);

}


/* =========================================================
 * Product Options
 * ========================================================= */

function populateProductOptions() {

	let selectedOption = $('#mainDropdown').val();


	$('#prd_type').empty();


	$.post(

		'<?= site_url("Ajax/ajax_get_subcategory") ?>',

		{
			cat: selectedOption
		},

		function(msg) {

			let options = JSON.parse(msg);


			$('#prd_type').append(
				'<option value="">Select</option>'
			);


			$.each(options, function(_, obj) {

				$('#prd_type').append(

					`<option value="${obj.category_id}">
						${obj.category_name}
					</option>`

				);

			});

		}

	);

}

</script>
