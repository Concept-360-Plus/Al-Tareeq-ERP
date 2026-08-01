<style type="text/css">
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 220px !important;
        min-width: 220px !important;
    }
    .form-control-sm{
        border:1px solid #ced4da;
    }
    
</style>
<div class="row">
<div class="col-md-12">
<div class="x_panel">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Production/add_production_details"
        autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select WO Ref No :<span
                    style="color: red;"> * </span></label>
            <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8" role='group'>
                <select tabindex="1" class="form-select form-control-sm select2" id="work_id" name="work_id"
                    required onchange="get_wo_items_details()">
                    <option value="">Select</option>
                    <?php foreach ($records as $s) { ?>
                        <option value="<?php echo $s->work_id ?>"><?php echo $s->project_name . ' - ' . $s->wo_code . ' ' .  date('d-m-Y',strtotime($s->work_order_date)); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>


        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Actual Completion Date :</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <div class="input-group date datepicker1">
                    <input type="date" class="form-control form-control-sm" id="completion_date"
                        name="completion_date" value="<?php echo date('d-m-Y') ?>" tabindex=2 re>
                    
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Production Code :<span
                    style="color: red;"> * </span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                <input type="text" name="p_code" id="p_code" class=" form-control-sm bg-soft-gray" value="<?php echo $code; ?>" required>
            </div>

        </div>
  
        <div class="form-group row">
      	<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Handed Over To:</label>
			<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
				<select tabindex="1" class="form-select form-control-sm select2" id="handed_over_to" name="handed_over_to" 
					style='width:195px'>
					<option value="">Select</option>
					<?php foreach ($user_records as $s) { ?>
						<option <?php if ($this->session->userdata('user_id') == $s->user_id)
							echo 'selected'; ?>
							value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
					<?php } ?>
				</select>
			</div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Work Order Status</label>
			<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
			<input type="text" class="form-control form-control-sm " id="wo_status"
						name="wo_status" value=" " tabindex="3" >
    	     		 </div>

		</div>




        <div class="form-group row">
            <table class="table table-bordered table-hover" id="tab_logic4">
                <!-- <thead>
					    <tr>
					    	    <th title="Item">Main Heading</th>  
					    	    <th title="Item">Details</th>    
					    	    <th title="Item"><a id="add_row4" title="Add" class="btn btn-sm bg-orange" ><span class="fa fa-plus"></span></a></th>  
						</tr>
					    </thead>	
					     	 -->
            </table>
        </div>
        <div id="item_list_id"></div>








        <!-- <div class="form-group row">
            <table class="table table-bordered table-hover" id="tab_logic">
                <thead>
                    <tr>
                        <th>Select Items</th>
                        <th> Description</th>
                        <th>Total QTY</th>
                        <th>Unit</th>
                        <th>QTY Released</th>
                        <th>Completion %</th>
                        <th width='10%'><a id="add_row" title="Add" class="btn btn-sm bg-orange"><span
                                    class="fa fa-plus"></span></a></th>
                    </tr>
                </thead>

                <tbody id="mytbbody">
                    <tr id='addr0'>
                        <td>
                            <select tabindex="11" class="form-select form-control-sm select2" id="product_id0"
                                name="product_id[]" onchange="get_treding_product_info(0)" style="width:300px;">
                                <option value="">Select</option>
                                <?php foreach ($products as $s) { ?>
                                    <option value="<?php echo $s->item_id; ?>"><?php echo $s->item_code . ' ' . $s->item_name . ' ' . $s->part_code . ' ' . $s->make_model; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <textarea rows='4' cols='20' name="desc[]" id="desc0"
                                style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"
                                tabindex='13' placeholder="Description"></textarea>
                        </td>
                        <td><input type="number" name="tot_quantity[]" id="tot_quantity0" tabindex='14'
                                class="form-control form-control-sm" placeholder=""></td>
                                
                        <td><input type="text" name="unit[]" id="unit0" tabindex='14'
                                class="form-control form-control-sm" placeholder=""></td>

                        <td><input type="number" name="quantity_released[]" id="quantity_released0" tabindex='14'
                                class="form-control form-control-sm" placeholder=""></td>

                        <td><input type="text" name="completion[]" id="completion0" tabindex='16'
                                class="form-control form-control-sm" placeholder="" style="width: 80px; height: 35px; font-size: 16px;"></td>
                        <td><a id='delete_row' title="Delete" onclick='remove_row(0)'
                                class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>
                    </tr>
                    <tr id='addr1'></tr>
                </tbody>
            </table>
        </div> -->


        <div class="form-group row">
        <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Notes/Remark:</label>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<textarea style='font-size:12px' cols='50' rows='3' name="remark" id="remark" tabindex=20
					class="form-control form-control-sm"></textarea>
			</div>
			</div>



        <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
                <button type="submit" tabindex="502" id="add" class="btn btn-primary m-b-0">Submit</button>
            </div>
        </div>
    </form>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<script>
    ////////////////  Item   /////////////////////


    $(document).ready(function() {
        var i = 1;
        $("#add_row").click(function() {
            // $('#addr' + i).html("<td><select tabindex='11' class='form-select form-control-sm select2' id='product_id" + i + "' name='product_id[]' onchange='get_treding_product_info(" + i + ")' style='width:350px;'><option value=''>Select </option><?php foreach ($products as $s) { ?><option value='<?php echo $s->item_id; ?>'><?php echo $s->item_code . ' ' . $s->item_name . ' ' . $s->part_code . ' ' . $s->make_model; ?></option><?php } ?></select></td><td><textarea rows='4' cols='20' name='desc[]' id='desc" + i + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control-sm' tabindex='13' placeholder='Description'></textarea></td><td><input type='text' name='colour_finish[]' id='colour_finish" + i + "' tabindex='14' class='form-control form-control-sm' placeholder='' ></td><td><input type='number' name='trading_qty[]' id='trading_qty" + i + "' tabindex='14' class='form-control form-control-sm' placeholder='' ></td><td><input type='text' name='item_uom[]' id='item_uom" + i + "' tabindex='16' class='form-control form-control-sm' placeholder='' ></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
            $('#addr' + i).html("<td><select tabindex='11' class='form-select form-control-sm select2' id='product_id" + i + "' name='product_id[]' onchange='get_treding_product_info(" + i + ")' style='width:350px;'><option value=''>Select </option><?php foreach ($products as $s) { ?><option value='<?php echo $s->item_id; ?>'><?php echo $s->item_code . ' ' . $s->item_name . ' ' . $s->part_code . ' ' . $s->make_model; ?></option><?php } ?></select></td><td><textarea rows='4' cols='20' name='desc[]' id='desc" + i + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control-sm' tabindex='13' placeholder='Description'></textarea></td><td><input type='number' name='tot_quantity[]' id='tot_quantity" + i + "' tabindex='14' class='form-control form-control-sm' placeholder='' ></td><td><input type='text' name='unit[]' id='unit" + i + "' tabindex='14' class='form-control form-control-sm' placeholder='' ></td> <td><input type='number' name='quantity_released[]' id='quantity_released" + i + "' tabindex='14' class='form-control form-control-sm' placeholder='' ></td><td><input type='text' name='completion[]' id='completion" + i + "' tabindex='16' class='form-control form-control-sm' placeholder='' ></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
            $('#mytbbody tr:last').after('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
            $('.select2').select2({
                width: "220px"
            });
        });
        $("#delete_row").click(function() {
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
            $.ajax({
                url: "<?php echo site_url('Product/ajax_get_product_details'); ?>",
                type: 'POST',
                data: {
                    product_id: product_id
                },
                dataType: "json",
                success: function(msg) {
                    document.getElementById("desc" + append_id).value = msg.item_desc;
                    // document.getElementById("tot_quantity" + append_id).value = msg.unit_price;
                    document.getElementById("unit" + append_id).value = msg.unit_id;

                }
            });
        } else {
            document.getElementById("desc" + append_id).value = '';
            // document.getElementById("trading_qty" + append_id).value = '';

        }
    }

    function get_wo_items_details() {
        var work_id = $("#work_id").val();
        // alert(work_id);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>index.php/Ajax/get_wo_items_details",
            data: {
                work_id: work_id
            },
            success: function(msg) {
                // alert(msg);

                document.getElementById('item_list_id').innerHTML = msg;

            }
        });
    }

</script>