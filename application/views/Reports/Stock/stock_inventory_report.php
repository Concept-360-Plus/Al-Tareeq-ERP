<div class="card-body">

	<!-- Filter Form -->
	<form id="main"
		method="post"
		action="<?= base_url('index.php/Reports/get_stock_inventory_report'); ?>"
		autocomplete="off">

		<div class="row">

			<!-- Warehouse -->
			<div class="col-md-3">
				<div class="form-group">
					<label>Warehouse <span class="text-danger">*</span></label>

					<select name="warehouse_id"
						id="warehouse_id"
						class="form-control select2"
						required>

						<option value="">Select Warehouse</option>

						<?php foreach ($warehouse_records as $g) { ?>

							<option value="<?= $g->warehouse_id ?>"
								<?= ($warehouse_id == $g->warehouse_id) ? 'selected' : ''; ?>>

								<?= $g->warehouse_name ?>

							</option>

						<?php } ?>

					</select>

				</div>
			</div>

			<!-- Store -->
			<div class="col-md-3">
				<div class="form-group">

					<label>Store</label>

					<select
						name="store_id"
						id="store_id"
						class="form-control select2">

						<option value="">Select Store</option>

					</select>

				</div>
			</div>

			<!-- Product -->
			<div class="col-md-3">
				<div class="form-group">

					<label>Product</label>

					<select
						id="product_id"
						name="product_id"
						class="form-control select2">

						<option value="">Select Product</option>

						<?php foreach ($products as $s) { ?>

							<option value="<?= $s->product_id ?>"
								<?= ($product_id == $s->product_id) ? 'selected' : ''; ?>>

								<?= $s->product_name ?>

							</option>

						<?php } ?>

					</select>

				</div>
			</div>

			<!-- Go Button -->
			<div class="col-md-3">

				<div class="form-group">

					<label>&nbsp;</label>

					<div>

						<button
							type="submit"
							id="view"
							class="btn btn-primary">

							<i class="fa fa-search"></i> Go

						</button>

					</div>

				</div>

			</div>

		</div>

	</form>

	<!-- Print & Export -->

	<div class="row" style="margin-top:5px;margin-bottom:20px;">

		<div class="col-md-12">

			<form target="_blank"
				action="<?= base_url('index.php/Reports/print_stock_inventory_report'); ?>"
				method="post"
				style="display:inline-block;">

				<input type="hidden" name="warehouse_id" value="<?= $warehouse_id; ?>">
				<input type="hidden" name="store_id" value="<?= $store_id; ?>">
				<input type="hidden" name="product_id" value="<?= $product_id; ?>">

				<button type="submit" class="btn btn-warning">

					<i class="fa fa-print"></i> Print

				</button>

			</form>

			&nbsp;

			<form
				action="<?= base_url('index.php/Reports/export_stock_inventory_report'); ?>"
				method="post"
				style="display:inline-block;">

				<input type="hidden" name="warehouse_id" value="<?= $warehouse_id; ?>">
				<input type="hidden" name="store_id" value="<?= $store_id; ?>">
				<input type="hidden" name="product_id" value="<?= $product_id; ?>">

				<button
					type="button"
					id="export"
					class="btn btn-success"
					onclick="export_stock_inventory_report();">
					<i class="fa fa-file-excel-o"></i>
					Export to Excel
				</button>

			</form>

		</div>

	</div>

	<div class="dt-responsive table-responsive">
		<table id="basic-btn" class="table table-striped table-bordered nowrap">
			<thead>
				<tr>
					<th>Srn</th>
					<th>Stock Code</th>

					<th>Stock Qty</th>
					<th>Unit Price</th>
					<th>Total</th>
					<th>Allocated Qty</th>
				</tr>
			</thead>

			<tbody>

				<?php

				$i = 1;
				$tot1 = 0;
				$st = 0;

				?>

				<?php if (!empty($records)) { ?>

					<?php foreach ($records as $row) : ?>

						<tr>

							<td>
								<?= $i++; ?>
							</td>

							<td>
								<a target="_blank"
									href="<?= base_url('index.php/Reports/item_wise_ledger/')
												. $row->product_code . '/' . $warehouse_id; ?>">

									<?= $row->product_name; ?>

								</a>
							</td>

							<td>
								<?php
								echo $row->stock;
								$st += $row->stock;
								?>
							</td>

							<td>
								<?= $row->price; ?>
							</td>

							<td align="right">

								<?php

								$tot = $row->stock * $row->price;

								echo number_format($tot, 2);

								$tot1 += $tot;

								?>

							</td>

							<td>
								<?= $row->allocation; ?>
							</td>

						</tr>

					<?php endforeach; ?>

					<tr class="bg-soft-primary">

						<th>Total</th>
						<th></th>

						<th>
							<?= $st; ?>
						</th>

						<th></th>

						<th align="right">
							<?= number_format($tot1, 2); ?>
						</th>

						<th></th>

					</tr>

				<?php } else { ?>

					<tr>

						<td colspan="6"
							class="text-center text-muted">

							Please select a Warehouse and click
							<strong>Go</strong> to view the stock inventory.

						</td>

					</tr>

				<?php } ?>

			</tbody>
		</table>
	</div>
</div>

<script>
	document.getElementById("export").addEventListener("click", function(e) {
		// count table rows (excluding header)
		var rowCount = document.querySelectorAll("#basic-btn tbody tr").length;
		// check if only total row OR no data
		if (rowCount <= 1) {
			e.preventDefault();
			alert("No data available to export. Please check your filter criteria.");
			return false;
		}
	});

	$(document).ready(function() {
		$('#warehouse_id').change(function() {
			var warehouse_id = $(this).val();
			$('#store_id').html('<option value="">Loading...</option>');
			$.ajax({
				url: "<?= base_url('index.php/Ajax/get_store_by_warehouse'); ?>",
				type: "POST",
				data: {
					warehouse_id: warehouse_id
				},
				dataType: "json",
				success: function(result) {
					var selectedStore = "<?= $store_id ?>";
					var html = '<option value="">Select Store</option>';
					$.each(result, function(i, row) {
						var selected = (row.store_id == selectedStore) ? 'selected' : '';
						html += '<option value="' + row.store_id + '" ' + selected + '>' +
							row.store_name +
							'</option>';
					});
					$('#store_id').html(html);
					// Refresh Select2
					$('#store_id').trigger('change.select2');
				}
			});
		});
		// Trigger AFTER binding
		if ($('#warehouse_id').val() != '') {
			$('#warehouse_id').trigger('change');
		}
	});



	function export_stock_inventory_report() {
		var rowCount = document.querySelectorAll("#basic-btn tbody tr").length;

		if (rowCount <= 1) {
			alert(
				"No data available to export. Please check your filter criteria."
			);
			return false;
		}

		var warehouse_id = $('#warehouse_id').val();
		var store_id = $('#store_id').val();
		var product_id = $('#product_id').val();

		if (warehouse_id === '') {
			alert("Please select a Warehouse.");
			return false;
		}

		var form = $('<form>', {
			method: 'POST',
			action: '<?= base_url("index.php/Reports/export_stock_inventory_report"); ?>'
		});

		$('<input>', {
			type: 'hidden',
			name: 'warehouse_id',
			value: warehouse_id
		}).appendTo(form);

		$('<input>', {
			type: 'hidden',
			name: 'store_id',
			value: store_id
		}).appendTo(form);

		$('<input>', {
			type: 'hidden',
			name: 'product_id',
			value: product_id
		}).appendTo(form);

		$('body').append(form);

		form.submit();
		form.remove();
		return true;
	}
</script>