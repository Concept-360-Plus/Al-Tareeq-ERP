<div class="card-body">
	<div class="form-group row">
		<h7>items Details:</h7>

		<table border='1' width='90%' cellpadding='0' cellspacing=0>
			<thead>
				<tr height="50px">
					<td style="width: 80px;" rowspan=2>SL.NO</td>
					<td style="width: 80px;" rowspan=2>ITEM CODE</td>
					<td style="width: 100px;" rowspan=2>DESCRIPTION</td>
					<td style="width: 90px;" rowspan=2>COLOUR/FINISH</td>
					<td style="width: 80px;" align='center' rowspan=2>QTY</td>
					<td style="width: 80px;" align='center' rowspan=2>&nbsp;&nbsp;UNIT</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($records2 as $r) { ?>
					<tr class="bg-soft-gray">
						<td></td>
						<td></td>
						<td> &nbsp;&nbsp;&nbsp;
							<b><?php echo $r->product_desc; ?></b>
							<input type="hidden" name="desc[]" value="<?php echo $r->product_desc; ?>" />
							<input type="hidden" name="pid[]" value="<?php echo $r->pid; ?>" />
							<input type="hidden" name="qid[]" value="<?php echo $r->qid; ?>" />
							<input type="hidden" name="trans_id[]" value="<?php echo $r->trans_id; ?>" />
							<input type="hidden" name="revision[]" value="<?php echo $r->revision + 1; ?>" />
						</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td width='400px' style='font-size: 10px;'>
							<textarea name='item_remark[]' class="form-control form-control-sm" placeholder="add remark"><?php echo $r->item_remark; ?></textarea>
						</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php $i = 1;
					foreach ($records3 as $tr) {
						if ($tr->trans_id1 == $r->trans_id) { ?>
							<tr>
								<td style="width: 80px;"><?php echo $i; ?></td>
								<td style="width: 80px;"><?php echo $tr->item_code; ?></td>
								<td style="width: 100px;"><?php echo $tr->item_name; ?></td>
								<td style="width: 90px;"><input type="text" name="colour_finish[]" class="form-control form-control-sm" style="margin-right: 30px;" /></td>
								<td style="width: 80px;"><input type="text" name="qty<?php echo $r->trans_id; ?>[]" class="form-control form-control-sm" value="<?php echo intval($tr->qty); ?>" readonly /></td>
								<!-- <td style="width: 80px;" align='center'><input type="text" name="qty<?php echo $r->trans_id; ?>[]" class="form-control form-control-sm" value=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo intval($tr->qty); ?>" readonly style="border: none; background-color: transparent;" /></td> -->

								<td style="width: 80px;" align='center'><?php echo $tr->unit_abbr; ?></td>
								<input type="hidden" name="sub_details<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->sub_details; ?>" />
								<input type="hidden" name="width<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->width; ?>" />
								<input type="hidden" name="height<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->height; ?>" />
								<input type="hidden" name="unit<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->unit; ?>" />
								<input type="hidden" name="price<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->price; ?>" />
								<input type="hidden" name="total<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->total; ?>" />
								<input type="hidden" name="item_name[]" value="<?php echo $tr->item_name; ?>" />
								<input type="hidden" name="item_code[]" value="<?php echo $tr->item_code; ?>" />

							</tr>
				<?php $i++;
						}  //end of if
					}
				} ?>


			</tbody>
		</table>
	</div>






</div>
</div>
</div>
</div>
</div>
</div>

<!-- <script>
	$(document).ready(function() {
		var i = 1;
		$("#add_row").click(function() {
			$('#addr' + i).html("<td><select name='employee_id[]' id='employee_id" + i + "' class='form-control select2' required><option value=''>Please Employee</option><?php foreach ($user_records as $g) { ?><option value='<?php echo $g->user_id ?>'><?php echo $g->user_name; ?> </option><?php } ?></select></td><td><input type='text' id='emp_start_date" + i + "' name='emp_start_date[]' class='form-control date_today' value='<?php echo date('d-M-Y'); ?>'></td><td><textarea name='production_desc[]' id='production_desc" + i + "' class='form-control' rows='2'></textarea></td><td><textarea name='remark[]' id='remark" + i + "' class='form-control' rows='2'></textarea></td><td><a onclick='remove_row(" + i + ");' id='delete_row' title='Delete' class='btn btn-xs bg-orange'><span class='fa fa-trash'></span></a></td>");
			$('#mytbbody tr:first').after('<tr id="addr' + (i + 1) + '"></tr>');
			i++;
			$('.select2').select2();
		});
		$("#delete_row").click(function() {
			if (i > 1) {
				$("#addr" + (i - 1)).html('');
				i--;
			}
		});
	});

	function remove_row(append_id) {
		//$("#MY_addr"+append_id).html('');	
		//getElementById("addr"+append_id).id = "addr"+append_id+'x';
		//jQuery(this).prev("li").attr("id","newId");.
		$('#addr' + append_id).attr("id", "addr" + append_id + "x");
		$('#addr' + append_id + "x").remove();
		calculate_grand_total();
	}
</script> -->