<div class="card-body">
	<div class="dt-responsive table-responsive">
		<table id="datatable" class="table table-striped" data-toggle="data-table">
			<thead>
				<tr>
					<th>Sl. No</th>
					<th>Offer CODE</th>
					<th>Emp. Name</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; //print_r($records);
				foreach ($records as $row) {
				?>
					<tr>
						<td>
							<?php echo $i;
							$i++; ?>
						</td>

						<td>
							<?php echo $row->offer_code; ?>
						</td>

						<td>
							<?php echo htmlspecialchars($row->employee_name); ?>
						</td>

						<td>

							<a href="<?php echo base_url('index.php/Hr/edit_offer_letter/' . $row->offer_id); ?>"
								title="Edit">
								<i class="fa fa-edit" style="font-size:18px"></i>
							</a>

							&nbsp;&nbsp;&nbsp;

							<a href="javascript:void(0);"
								title="Delete"
								onclick="return confirmcancel(<?php echo $row->offer_id; ?>);">
								<i class="fa fa-trash" style="font-size:18px"></i>
							</a>

							&nbsp;&nbsp;&nbsp;

							<a target="_blank"
								href="<?php echo base_url('index.php/Hr/print_offer_letter/' . $row->offer_id); ?>"
								title="Download Offer Letter">
								<i class="fa fa-print" style="font-size:18px"></i>
							</a>

						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Static Table End -->



<script>
	function confirmcancel(tid) {
		var r = confirm("Are you sure you want to Delete Record?");
		if (r == true) {
			$.ajax({
				url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
				type: "POST",
				data: {
					table_name: 'employee_offer_letter',
					where_key: 'offer_id ',
					where_val: tid
				},
				success: function(msg) {
					if (msg == 1) {
						$.ajax({
							url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
							type: "POST",
							data: {
								table_name: 'employee_offer_salary',
								where_key: 'offer_id',
								where_val: tid
							},
							success: function(msg) {
								if (msg == 1) {
									$.ajax({
										url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
										type: "POST",
										data: {
											table_name: 'employee_offer_incentive',
											where_key: 'offer_id',
											where_val: tid
										},
										success: function(msg) {
											if (msg == 1) {

												window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
											} else {
												alert("Can't Delete record. Data already exist!!!");
											}
										},
									});
									//window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
								} else {
									alert("Can't Delete record. Data already exist!!!");
								}
							},
						});
						//window.location.href = "<?php echo $_SERVER['PHP_SELF'] ?>";
					} else {
						alert("Can't Delete record. Data already exist!!!");
					}
				},
			});
			return true;
		} else
			return false;

	}
</script>