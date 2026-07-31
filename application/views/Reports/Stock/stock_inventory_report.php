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
					type="submit"
					id="export"
					class="btn btn-success">

					<i class="fa fa-file-excel-o"></i> Export to Excel

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
				<?php $i = 1;
				$tot1 = 0;
				$st = 0;
				foreach ($records as $row) : ?>
					<tr>
						<td><?php echo $i;
							$i++; ?></td>
						<td>
							<a target='_blank' href="<?php echo base_url() . 'index.php/'; ?>Reports/item_wise_ledger/<?php echo $row->product_code . '/' . $warehouse_id; ?>"><?php echo $row->product_name; ?></a>
						</td>

						<td><?php echo $row->stock;
							$st = $st + $row->stock; ?></td>
						<td><?php echo $row->price; ?></td>
						<td align='right'><?php echo $tot = sprintf("%0.2f", $row->stock * $row->price);
											$tot1 = $tot1 + $tot; ?></td>
						<td><?php echo $row->allocation; ?></td>
					</tr>
				<?php endforeach; ?>
				<tr class="bg-soft-primary">
					<th>Total</th>
					<th></th>
					<th><?php echo $st; ?></th>
					<th></th>
					<th align='right'><?php echo sprintf("%0.2f", $tot1); ?></th>
					<th></th>
				</tr>
			</tbody>
		</table>
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
	</script>