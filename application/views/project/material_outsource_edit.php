<style>
	 .btn-sm .fa{color:#fff;}
</style>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
        <form id="main" method="post"
            action="<?php echo base_url() . 'index.php/'; ?>Project/update_material_outsource_processing"
            autocomplete="off" enctype="multipart/form-data">
            <?php foreach ($records1 as $row) { ?>

                <div class="form-group row">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Name<span
                            style="color: red;"> *</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                        <select tabindex="1" class="form-select form-control select2" id="project_id" name="project_id"
                            onchange="get_project_info()" readonly>
                            <option value="">Select</option>
                            <?php foreach ($records as $s) { ?>
                                <option value="<?php echo $s->project_id ?>" <?php if ($row->project_id == $s->project_id)
                                       echo 'selected'; ?>>
                                    <?php echo $s->project_code . ' ' . $s->project_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Supplier<span
                            style="color: red;"> *</span></label>
                    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                        <select tabindex="2" class="form-select form-control select2" id="supplier_id" name="supplier_id"
                            readonly>
                            <option value="">Select</option>
                            <?php foreach ($supplier_records as $sr) { ?>
                                <option value="<?php echo $sr->supplier_id ?>" <?php if ($row->supplier_id == $sr->supplier_id)
                                       echo 'selected'; ?>>
                                    <?php echo $sr->supplier_code . ' ' . $sr->supplier_name; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Start Date :</label>
				<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
					<div class="input-group date ">
						<input type="text" class="form-control form-control bg-soft-gray" id="sdate"
							name="sdate" value="<?php echo date('d-m-Y', strtotime($pinfo[0]['start_date']));?>" tabindex="3" readonly>
						<!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
					</div>
				</div>

				<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project End Date:</label>
				<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
					<div class="input-group date ">
						<input type="text" class="form-control form-control bg-soft-gray" id="edate" name="edate"
							value="<?php echo date('d-m-Y', strtotime($pinfo[0]['end_date'])); ?>" tabindex="4" readonly>
						<!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
					</div>
				</div>
			</div>

			 <div class="form-group row">
			 <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Manager:</label>
		    	<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="text" class="form-control form-control bg-soft-gray" id="manager_id"
						name="manager_id" value="<?php echo $pinfo[0]['user_name'] ?? ""; ?>" tabindex="3" readonly>
		       </div>

				            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Customer</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
            <input type="text" class="form-control form-control bg-soft-gray" id="customer_id"
						name="customer_id" value="<?php echo $pinfo[0]['customer_name'] ?? ""; ?>" tabindex="3" readonly>
			</div>

		</div> 


                 <div class="form-group row">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Outsource Starting Date:</label>
                    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                        <div class="input-group date datepicker1">
                          <input type="date" class="form-control form-control" 
       id="outsource_date" name="outsource_date"
       value="<?php echo !empty($row->outsource_date) && $row->outsource_date != '0000-00-00' ? $row->outsource_date : ''; ?>">
                            
                        </div>
                    </div>

                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Outsource Finishing Date:</label>
                    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                        <div class="input-group date datepicker1">
                           <input type="date" class="form-control form-control datepicker1" 
       id="outsource_finish_date" name="outsource_finish_date"
       value="<?php echo !empty($row->outsource_finish_date) && $row->outsource_finish_date != '0000-00-00' ? $row->outsource_finish_date : ''; ?>">
                            
                        </div>
                    </div>
                      </div>
                      <div class="form-group row">
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Remark:</label>
                    <div class="col-sm-3">
                        <textarea id="remark" name="remark" rows="1" placeholder="Remark/Comments" class="form-control" style="width: 100%;"
                            tabindex="11"><?php echo $row->remark; ?></textarea>
                    </div>

                </div>
                
                <div class="form-group row">
    <!-- Quality Check Done -->
    <label class="col-sm-2 col-form-label">Quality Check Done:</label>
    <div class="col-sm-3">
        <select name="quality_check_done" class="form-control form-control" tabindex="12">
            <option value="">Select</option>
            <option value="Yes" <?php echo ($row->quality_check_done=='Yes')?'selected':''; ?>>Yes</option>
            <option value="No" <?php echo ($row->quality_check_done=='No')?'selected':''; ?>>No</option>
        </select>
    </div>

    <!-- Quality Check Done By -->
    <label class="col-sm-2 col-form-label">Quality Check Done By:</label>
    <div class="col-sm-3">
        <input type="text" name="quality_check_by" class="form-control form-control" 
               value="<?php echo $row->quality_check_by; ?>" tabindex="13">
    </div>
</div>

<div class="form-group row">
    <!-- Quality Check Comments -->
    <label class="col-sm-2 col-form-label">Quality Check Comments:</label>
    <div class="col-sm-8">
        <textarea name="quality_check_comments" rows="2" class="form-control" 
                  tabindex="14"><?php echo $row->quality_check_comments; ?></textarea>
    </div>
</div>
                <div class="form-group row">
				<table class="table table-bordered table-hover" id="tab_logic">
					<thead>
						<tr>
							<th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Nature Of Work</th>
							<th width='10%'>
								<a id="add_row" title="Add"	class="btn btn-primary btn-sm"><span class="fa fa-plus"></span></a>
							</th>
						</tr>
					</thead>
					<tbody id="mytbbody">
						<?php $i = 50001;
						foreach ($trans_records as $r):?>
							<tr>
								<!--<td>
									<select tabindex="11" class="form-select form-control select2 select2Width"
										id="product_id<?php echo $i; ?>" name="product_id[]"
										onchange="get_product_info_old(<?php echo $i; ?>)">
										<option value="">Select </option>
										<?php foreach ($products as $s) { ?>
											<option <?php if ($s['product_id'] == $r->outsource_type)
												echo 'selected'; ?>
												value="<?php echo $s['product_id']; ?>"><?php echo $s['product_code'] . ' ' . $s['product_name']; ?></option>
										<?php } ?>
									</select>
									<textarea rows='4' cols='20' name="desc[]" id="desc<?php echo $i; ?>"
										style="font-size:11px; font-weight:bold;" class="form-control form-control"
										tabindex='9' required><?php echo $r->product_desc; ?></textarea>
								</td>-->
                                <td><input type="text" name="outsource_item[]" id="outsource_item0" tabindex='10' class="form-control form-control"	value="<?php echo $r->outsource_item ?? ''; ?>" required>
						        </td>
								<td>
									<input type="number" name="trading_qty[]" id="trading_qty<?php echo $i; ?>" tabindex='10'
										class="form-control form-control" value="<?php echo $r->quantity ?? ''; ?>" required>
								</td>
                                
                                <td>
                                    <input type="number" name="item_price[]" id="item_price<?php echo $i; ?>" tabindex='10'
                                        class="form-control form-control" value="<?php echo $r->item_price ?? ''; ?>" required>
								<td>
									<textarea name="nature_work[]" id="nature_work<?php echo $i; ?>" tabindex='16'
										class="form-control form-control"
										><?php echo $r->nature_work; ?></textarea>
									<input type="hidden" name="outsource_trid[]" value="<?php echo $r->outsource_trid; ?>">
								</td>
								<td>
									<a href="javascript:confirmcancel(<?php echo $r->outsource_trid; ?>)" title="Delete"
										class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
								</td>
							</tr>
							<?php $i++; endforeach; ?>

						<tr id='addr1'></tr>
					</tbody>
				</table>
			</div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="hidden" id="outsource_id" name="outsource_id"
                            value='<?php echo $row->outsource_id; ?>'>
                        <button type="submit" tabindex="" id="add" class="btn btn-primary m-b-0 pull-left">Submit</button>

                    </div>
                </div>
            <?php } ?>
        </form>
    </div>

<div>
</div>
</div>
<script>
 	$(document).ready(function () {

var i = 1;
$("#add_row").click(function () {
    //$('#addr' + i).html("<td><select tabindex='11' class='form-select form-control select2' id='product_id" + i + "' name='product_id[]' onchange='get_treding_product_info(" + i + ")' style='width:350px;'><option value=''>Select </option><?php foreach ($products as $s) { ?><option value='<?php echo $s['product_id']; ?>'><?php echo $s['product_code'] . ' ' . $s['product_name']; ?></option><?php } ?></select><textarea rows='4' cols='20' name='desc[]' id='desc" + i + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td><input type='number' name='trading_qty[]' id='trading_qty" + i + "' tabindex='14' class='form-control form-control' placeholder='' ></td><td><textarea name='nature_work[]' id='nature_work" + i + "' tabindex='16' class='form-control form-control' ></textarea></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-danger btn-sm remove1'><span class='fa fa-trash'></span></a></td>");
    $('#addr' + i).html("<td><input type='text' name='outsource_item[]' id='outsource_item0' tabindex='10' class='form-control form-control' value='' required></td><td><input type='number' name='trading_qty[]' id='trading_qty" + i + "' tabindex='14' class='form-control form-control' placeholder='' required></td><td><input type='number' name='item_price[]' id='item_price" + i + "' tabindex='10' class='form-control form-control' value='' required><td><textarea name='nature_work[]' id='nature_work" + i + "' tabindex='16' class='form-control form-control' ></textarea></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-sm bg-red remove1'><span class='fa fa-trash'></span></a></td>");
    $('#mytbbody tr:last').after('<tr id="addr' + (i + 1) + '"></tr>');
    i++;
    $('.select2').select2({ width: "220px" });
});
$("#delete_row").click(function () {
    if (i > 1) {
        $("#addr" + (i - 1)).html('');
        i--;
    }
});
});

function remove_row(append_id) {
$('#addr' + append_id).attr("id", "addr" + append_id + "x");
$('#addr' + append_id + "x").remove();
}

function confirmcancel(outsource_trid) {
    if (!confirm("Are you sure you want to delete this resource entry?")) {
        return false;
    }

    $.ajax({
        url: "<?php echo base_url() ?>index.php/Ajax/delete_record",
        type: "POST",
        data: {
            table_name: 'project_outsource_details',
            where_key: 'outsource_trid',
            where_val: outsource_trid
        },
        success: function (response) {
            if ($.trim(response) === '1') {
                $("input[name='outsource_trid[]'][value='" + outsource_trid + "']")
                    .closest('tr')
                    .remove();
            } else {
                alert("Unable to delete this resource entry.");
            }
        },
        error: function () {
            alert("Unable to delete this resource entry. Please try again.");
        }
    });

    return false;
}

function call_me(append_id) {
var item_id = document.getElementById("item_id" + append_id).value;
$.ajax({
    type: "POST",
    url: "<?php echo base_url() ?>index.php/Setup/ajax_get_item_details",
    data: { item_id: item_id },
    dataType: "json",
    success: function (msg) {
        document.getElementById("desc" + append_id).value = msg.description;
        document.getElementById("truei" + append_id).value = item_id;
        document.getElementById("unit_id" + append_id).value = msg.unit_id;
        document.getElementById("width" + append_id).value = msg.width;
        document.getElementById("height" + append_id).value = msg.height;
        document.getElementById("area" + append_id).value = msg.area;
        document.getElementById("selling_unit" + append_id).innerHTML = msg.selling_unit_name;
        ////  view model popup
        $('#indent-Modal').modal('show');
        document.getElementById('model_heading').innerHTML = msg.item_name;
        document.getElementById('pocode').innerHTML = msg.pocode;
        document.getElementById('lastpo_price').innerHTML = msg.po_price;
        document.getElementById('lastpo_qty').innerHTML = msg.po_qty;
        document.getElementById('stock').innerHTML = msg.stock;
    }
});
}
function call_me1(append_id) {
var item_id = document.getElementById("item_id" + append_id).value;
$.ajax({
    type: "POST",
    url: "<?php echo base_url() ?>index.php/Setup/ajax_get_item_details",
    data: { item_id: item_id },
    dataType: "json",
    success: function (msg) {
        ////  view model popup
        $('#indent-Modal').modal('show');
        document.getElementById('model_heading').innerHTML = msg.item_name;
        document.getElementById('pocode').innerHTML = msg.pocode;
        document.getElementById('lastpo_price').innerHTML = msg.po_price;
        document.getElementById('lastpo_qty').innerHTML = msg.po_qty;
        document.getElementById('stock').innerHTML = msg.stock;
    }
});
}


function get_indent_item_list() {
var indent_id = $("#indent_id").val();
var rev_version = $("#revision_version").val();
$.ajax({
    type: "POST",
    url: "<?php echo base_url() ?>index.php/Ajax/get_indent_item_list",
    data: { indent_id: indent_id, rev_version: rev_version },
    success: function (msg) {
        document.getElementById('item_list_id').innerHTML = msg;
    }
});
}



    function get_project_info() {
		var project_id = document.getElementById("project_id").value;
		if (project_id != '') {
			$.ajax({
				async: false,
				type: "POST",
				url: "<?php echo base_url() ?>index.php/Project/ajax_get_project_info",
				data: { project_id: project_id },
				dataType: "json",
				success: function (msg) {
					document.getElementById("customer_id").value = msg.customer_id;
					document.getElementById("manager_id").value = msg.user_id;
					document.getElementById("sdate").value = msg.sdate;
					document.getElementById("edate").value = msg.edate;

				},
				error: function (xhr, status, error) {
					console.error("AJAX Error: ", status, error);
				}
			});
		} else {
			document.getElementById("customer_id").value = '';
			document.getElementById("manager_id").value = '';
			document.getElementById("sdate").value = '';
			document.getElementById("edate").value = '';
		}
	}


    window.onload = function () {
        var project_id = document.getElementById("project_id").value;
        if (project_id) {
            get_project_info();
        }
    };
    /*$(document).ready(function () {

        $('.select2').select2({
            placeholder: '-- Select Project --',
            allowClear: true,
            width: '100%'
        });

    });
    */
</script>
