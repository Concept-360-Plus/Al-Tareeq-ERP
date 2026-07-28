<style>
	 .btn-sm .fa{color:#fff;}
	</style>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
			<!--<div class="x_title">
				<h2>Outsource Processing</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>-->
			<div class="x_content">
        <form id="main" method="post"
            action="<?php echo base_url() . 'index.php/'; ?>Project/add_material_outsource_processing"
            autocomplete="off" enctype="multipart/form-data">


            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Select Project<span
                        style="color: red;"> * </span></label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                    <select tabindex="1" class="form-select form-control select2" id="project_id" name="project_id"
                        required onchange="get_project_info()">
                        <option value="">Select</option>
                        <?php foreach ($records as $s) { ?>
                            <option value="<?php echo $s->project_id ?>"><?php echo $s->project_code . ' ' . $s->project_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Select Supplier<span
                        style="color: red;"> * </span></label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <select tabindex="2" class="form-select form-control select2" id="supplier_id" name="supplier_id"
                        required>
                        <option value="">Select</option>
                        <?php foreach ($supplier_records as $sr) { ?>
                            <option value="<?php echo $sr->supplier_id ?>"><?php echo $sr->supplier_code . ' ' . $sr->supplier_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Start Date :</label>
			<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<div class="input-group date ">
					<input type="text" class="form-control form-control-sm bg-soft-gray" id="sdate"
						name="sdate" value="" tabindex="3" readonly>
					<!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
				</div>
			</div>
			<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project End Date:</label>
			<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<div class="input-group date ">
					<input type="text" class="form-control form-control-sm bg-soft-gray" id="edate" name="edate"
						value="" tabindex=4 readonly>
					<!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
				</div>
			</div>
		</div>
		<div class="form-group row">
		<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Approver:</label>
		    	<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<input type="text" class="form-control form-control bg-soft-gray" id="manager_id"
						name="manager_id" value=" " tabindex="3" readonly>
		       </div>		
			   	<label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Customer</label>
			<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
			<input type="text" class="form-control form-control bg-soft-gray" id="customer_id"
						name="customer_id" value="" tabindex="3" readonly>
    	     		 </div>

		</div>

           
          <div class="form-group row">       
    <!-- Starting Date -->
    <label class="col-sm-2 col-form-label">Outsource Starting Date :</label>
    <div class="col-sm-3">
        <div class="input-group date datepicker1">
           <input type="date" class="form-control form-control-sm" 
       id="outsource_date" name="outsource_date" 
       value="" tabindex="10" placeholder="Select start date">
            
        </div>
    </div>

    <!-- Finishing Date -->
    <label class="col-sm-2 col-form-label">Outsource Finishing Date :</label>
    <div class="col-sm-3">
        <div class="input-group date datepicker1">
            <input type="date" class="form-control form-control-sm" 
       id="outsource_finish_date" name="outsource_finish_date" 
       value="" tabindex="11" placeholder="Select finish date">
           
        </div>
    </div>
</div>
<div class="form-group row">   

                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Remark :</label>
                <div class="col-sm-3">
                    <textarea id="remark" class='form-control'  name="remark" rows="1" placeholder="Remark/Comments" style="width: 100%;"
                        tabindex="11"></textarea>
                </div>
            </div>


          
		<div class="form-group row">
			<table class="table table-bordered table-hover" id="tab_logic">
				<thead>
					<tr>
						<!-- <th>Sr</th> -->
						<th>Select Items</th>
						<th>Quantity</th>
						<th>Nature Of Work</th>
						<th width='10%'><a id="add_row" title="Add" class="btn btn-sm bg-red"><span
									class="fa fa-plus"></span></a></th>
					</tr>
				</thead>

				<tbody id="mytbbody">
					<tr id='addr0'>
						<!-- <td><input type="text" name="srn[]" id="srn0" tabindex='10' class="form-control form-control"
								value="1">
						</td> -->
						<td>
							<select tabindex="11" class="form-select form-control select2" id="product_id0"
								name="product_id[]" onchange="get_treding_product_info(0)" style="width:350px;">
								<option value="">Select</option>
								<?php foreach ($products as $s) { //. ' ' . $s->part_code . ' ' . $s->make_model ?>
									<option value="<?php echo $s->product_id; ?>"><?php echo $s->product_code . ' ' . $s->product_name; ?></option>
								<?php } ?>
							</select>
							<textarea rows='4' cols='20' name="desc[]" id="desc0"
								style="font-size:11px; font-weight:bold;" class="form-control form-control"
								tabindex='13' placeholder="Description"></textarea>
						</td>
						<td><input type="number" name="trading_qty[]" id="trading_qty0" tabindex='14'
								class="form-control form-control" placeholder=""></td>

						<td><textarea name="nature_work[]" id="nature_work0" tabindex='16'
								class="form-control form-control" ></textarea></td>
						<td><a id='delete_row' title="Delete" onclick='remove_row(0)'
								class="btn btn-sm btn-primary remove1"><span class="fa fa-trash"></span></a></td>
					</tr>
					<tr id='addr1'></tr>
				</tbody>
			</table>
		</div>

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <button type="submit" tabindex="" id="add" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>
        </form>
    </div>
    </div>
 

<script>

$(document).ready(function () {
		var i = 1;
		$("#add_row").click(function () {
			$('#addr' + i).html("<td><select tabindex='11' class='form-select form-control select2' id='product_id" + i + "' name='product_id[]' onchange='get_treding_product_info(" + i + ")' style='width:350px;'><option value=''>Select </option><?php foreach ($products as $s) { ?><option value='<?php echo $s->product_id; ?>'><?php echo $s->product_code . ' ' . $s->product_name; ?></option><?php } ?></select><textarea rows='4' cols='20' name='desc[]' id='desc" + i + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td><input type='number' name='trading_qty[]' id='trading_qty" + i + "' tabindex='14' class='form-control form-control' placeholder='' ></td><td><textarea name='nature_work[]' id='nature_work" + i + "' tabindex='16' class='form-control form-control' ></textarea></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");

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

	function get_treding_product_info(append_id) {
		var product_id = document.getElementById("product_id" + append_id).value;
		if (product_id != '') {
			$.ajax
				({
					url: "<?php echo site_url('Product/ajax_get_product_details'); ?>",
					type: 'POST',
					data: { product_id: product_id },
					dataType: "json",
					success: function (msg) {
						document.getElementById("desc" + append_id).value = msg.item_desc;
					}
				});
		}
		else {
			document.getElementById("desc" + append_id).value = '';
		}
	}



	var projects = <?php
		$projectDetails = array();
		foreach ($records as $project) {
			$projectDetails[$project->project_id] = array(
				'customer' => $project->customer_name,
				'approver' => $project->user_name,
				'startDate' => $project->start_date,
				'endDate' => $project->end_date,
			);
		}
		echo json_encode($projectDetails);
	?>;

	function formatProjectDate(dateValue) {
		if (!dateValue || dateValue === '0000-00-00') {
			return '';
		}

		var dateParts = dateValue.split('-');
		return dateParts.length === 3 ? dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0] : dateValue;
	}

	function get_project_info() {
		var project_id = document.getElementById("project_id").value;
		if (project_id != '') {
			$.ajax({
				async: false,
				type: "POST",
				url: "<?php echo base_url() ?>index.php/project/ajax_get_project_info",
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

</script>
