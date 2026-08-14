<style type="text/css">
	.select2Width {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		max-width: 220px !important;
		min-width: 220px !important;
	}
</style>

<div class="card-body">
	<?php if (!empty($records1)) { ?>
		<?php foreach ($records1 as $row) { ?>
			<form id="main"
				method="post"
				action="<?php echo base_url(); ?>index.php/Stock/update_stock_adjustment_records"
				autocomplete="off">
				
				<!-- Hidden Adjustment ID -->
				<input type="hidden"
					name="sno"
					value="<?php echo $row->sno; ?>">

				<div class="form-group row">
					<!-- Warehouse -->
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">
						Warehouse <span style="color:red;">*</span>
					</label>

					<div class="col-xs-12 col-sm-2 col-md-3 col-lg-3">
						<select name="warehouse_id"
							id="warehouse_id"
							class="form-control select2"
							required>
							<option value="">Select warehouse</option>
							<?php foreach ($store_records as $g) { ?>
								<option value="<?php echo $g->warehouse_id; ?>"
									<?php
									if ($g->warehouse_id == $row->warehouse_id) {
										echo 'selected';
									}
									?>>
									<?php echo $g->warehouse_name; ?>
								</option>
							<?php } ?>
						</select>
					</div>

					<!-- Stock Date -->
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">
						Stock Date <span style="color:red;">*</span>
					</label>

					<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
						<input type="text"
							name="stock_date"
							id="stock_date"
							class="form-control bg-soft-gray"
							value="<?php echo date('d-m-Y', strtotime($row->stock_date)); ?>"
							readonly
							required>
					</div>
				</div>

				<!-- Remark + Stock Type -->
				<div class="form-group row">

					<!-- Remark -->
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">
						Remark
					</label>

					<div class="col-xs-12 col-sm-10 col-md-3 col-lg-3">
						<textarea name="remark"
							id="remark"
							class="form-control"
							rows="1"
							placeholder="Enter remark"><?php echo htmlspecialchars($row->remark); ?></textarea>
					</div>

					<!-- Stock Type -->
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">
						Stock Type <span style="color:red;">*</span>
					</label>

					<div class="col-xs-12 col-sm-10 col-md-4 col-lg-2">
						<select class="form-control bg-soft-gray"
							id="inward_type"
							name="inward_type"
							required
							disabled>
							<option value="">Select</option>

							<option value="Opening"
								<?php if ($row->stock_type == 'Opening') echo 'selected'; ?>>
								Opening Stock
							</option>

							<option value="IN"
								<?php if ($row->stock_type == 'IN') echo 'selected'; ?>>
								Stock Inward
							</option>

							<option value="OUT"
								<?php if ($row->stock_type == 'OUT') echo 'selected'; ?>>
								Stock Outward
							</option>
						</select>

						<!-- Because disabled fields are NOT submitted -->
						<input type="hidden"
							name="inward_type"
							value="<?php echo htmlspecialchars($row->stock_type); ?>">
					</div>
				</div>


				<!-- Adjustment Details -->
				<div class="form-group row">
					<div class="col-md-12">
						<div class="dt-responsive table-responsive">
							<table class="table table-bordered table-hover"
								id="tab_logic">

								<thead>
									<tr>
										<th width="5%">Sr</th>
										<th width="20%">Bill of Entry</th>
										<th width="15%">Order Ref No</th>
										<th width="20%">Quantity / Price</th>
										<th width="40%">Remark / Location</th>
									</tr>
								</thead>

								<tbody id="mytbbody">
									<?php
									$i = 1;
									if (!empty($records2)) {
										foreach ($records2 as $r) {
									?>

											<tr>
												<!-- Sr -->
												<td>
													<?php echo $i; ?>
													<input type="hidden"
														name="adjustment_detail_id[]"
														value="<?php echo $r->adjustment_detail_id; ?>">
												</td>

												<!-- Bill No -->
												<td>
													<label>Bill of Entry</label>
													<input type="text"
														name="bill_entry[]"
														class="form-control form-control-sm select2Width"
														value="<?php echo htmlspecialchars($r->bill_no ?? ''); ?>">
												</td>

												<!-- Order Ref -->
												<td>
													<label>Order Ref No</label>
													<input type="text"
														name="ref_no[]"
														class="form-control form-control-sm"
														value="<?php echo htmlspecialchars($r->order_ref_no ?? ''); ?>">
												</td>

												<!-- Quantity / Price -->
												<td>
													<label>Quantity</label>
													<input type="number"
														name="qty[]"
														class="form-control form-control-sm"
														min="0"
														step="0.01"
														value="<?php echo htmlspecialchars($r->quantity ?? 0); ?>"
														required>

													<br>

													<label>Price</label>
													<input type="number"
														name="price[]"
														class="form-control form-control-sm"
														min="0"
														step="0.01"
														value="<?php echo htmlspecialchars($r->price ?? 0); ?>">
												</td>

												<!-- Remark / Location -->
												<td>
													<label>Item Remark</label>
													<textarea name="item_remark[]"
														class="form-control form-control-sm"
														rows="2"><?php echo htmlspecialchars($r->item_remark ?? ''); ?></textarea>
													<br>
													<label>Storage Location</label>
													<textarea name="storage_location[]"
														class="form-control form-control-sm"
														rows="4"
														placeholder="Enter rack / shelf / bin details"><?php echo htmlspecialchars($r->storage_location ?? ''); ?></textarea>
												</td>
											</tr>

										<?php
											$i++;
										}
									} else {
										?>
										<tr>
											<td colspan="5"
												class="text-center">
												No adjustment details found.
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!-- Buttons -->
				<div class="form-group row">
					<label class="col-sm-2"></label>
					<div class="col-sm-10">
						<button type="submit"
							id="add"
							class="btn btn-primary">
							Update
						</button>

						<a href="<?php echo base_url(); ?>index.php/Stock/list_stock_adjustment"
							class="btn btn-secondary">
							Cancel
						</a>
					</div>
				</div>
			</form>
		<?php } ?>
	<?php } else { ?>
		<div class="alert alert-danger">
			Stock Adjustment not found.
		</div>
	<?php } ?>
</div>