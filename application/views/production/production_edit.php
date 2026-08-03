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
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Project/update_production"
        autocomplete="off" enctype="multipart/form-data">
        <?php foreach ($records1 as $row1) { ?>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Select WO Ref No:<span
                        style="color: red;"> *</span></label>
                <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8" role='group'>
                    <select tabindex="1" class="form-select form-control-sm select2" id="work_id" name="work_id"
                        readonly onchange="get_project_info()">
                        <option value="">Select</option>
                        <?php foreach ($records as $s) { ?>
                            <option value="<?php echo $s->work_id ?>" <?php if ($row1->work_id == $s->work_id)
                                                                            echo 'selected'; ?>>
                                <?php echo $s->project_name . ' ' . $s->wo_code . ' ' . $s->work_order_date; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>


            </div>
            <div class="form-group row">

                <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Actual Completion Date :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control-sm datepicker1" id="completion_date"
                            name="completion_date" value="<?php echo date('d-m-Y', strtotime($row1->completion_date)); ?>"
                            tabindex="3">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label"> Production Code:</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                    <input type="text" name="p_code" id="p_code" class="form-control form-control-sm bg-soft-gray" value="<?php echo $row1->p_code; ?>" readonly>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 col-form-label">Handed Over To:</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <select tabindex="1" class="form-select form-control-sm select2" id="handed_over_to" name="handed_over_to"
                        style='width:155px'>
                        <option value="">Select</option>
                        <?php foreach ($user_records as $s) { ?>
                            <option <?php if ($row1->handed_over_to == $s->user_id)
                                        echo 'selected'; ?>
                                value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-xs-12 col-sm-3 col-md-3 col-lg-2 col-form-label">Work Order Status</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <input type="text" class="form-control form-control-sm " id="wo_status"
                        name="wo_status" value="<?php echo $row1->wo_status; ?> " tabindex="3">
                </div>
            </div>






            <h7>items Details:</h7>

            <div class="form-group row">

                <table border='1' width='90%' cellpadding='0' cellspacing=0>
                    <thead>
                        <tr height="50px">
                            <th style="width: 80px;" rowspan=2>SL.NO</th>
                            <th style="width: 80px;" rowspan=2>ITEM CODE</th>
                            <th style="width: 100px;" rowspan=2>DESCRIPTION</th>
                            <th style="width: 90px;" rowspan=2>COLOUR/FINISH</th>
                            <th style="width: 80px;" align='center' rowspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;QTY</th>
                            <th style="width: 80px;" align='center' rowspan=2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;UNIT</th>
                            <th style="width: 100px;" rowspan=2>QTY Released</th>
                            <th style="width: 90px;" rowspan=2>Completion %</th>


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
                                    <!-- <input type="hidden" name="pid[]" value="<?php echo $r->pid; ?>" />
                                    <input type="hidden" name="qid[]" value="<?php echo $r->qid; ?>" />-->
                                    <input type="hidden" name="ptrans_id[]" value="<?php echo $r->ptrans_id; ?>" /> 
                                    <!-- <input type="hidden" name="revision[]" value="<?php echo $r->revision + 1; ?>" /> -->
                                </td>
                                <td></td>
                                <td></td>
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
                                <td></td>
                                <td></td>
                            </tr>
                            <?php $i = 1;
                            foreach ($records3 as $tr) {
                                if ($tr->trans_id1 == $r->ptrans_id) { ?>
                                    <tr>
                                        <td style="width: 80px;"><?php echo $i; ?></td>
                                        <td style="width: 80px;">
                                        <?php echo $tr->item_code; ?>
                                    </td>
                                        <td style="width: 100px;">
                                        <?php echo $tr->item_name; ?>
                                    </td>
                                        <!-- <td style="width: 90px;"><input type="text" name="colour_finish[]" class="form-control form-control-sm" style="margin-right: 30px;" value="<?php echo $tr->colour_finish; ?>" /></td> -->
                                        <!-- <td style="width: 80px;"><input type="text" name="qty<?php echo $r->ptrans_id; ?>[]" class="form-control form-control-sm" value="<?php echo intval($tr->qty); ?>" readonly /></td> -->
                                        <!-- <td style="width: 80px;" align='center'><input type="text" name="qty<?php echo $r->ptrans_id; ?>[]" class="form-control form-control-sm" value=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo intval($tr->qty); ?>" readonly style="border: none; background-color: transparent;" /></td> -->
                                        <td style="width: 90px;" align='center'><?php echo $tr->colour_finish; ?></td>
								<td style="width: 80px;" align='center'><?php echo intval($tr->qty); ?></td>

                                        <td style="width: 80px;" align='center'><?php echo $tr->unit_abbr; ?></td>
                                        <td style="width: 80px;" align='center'><?php echo $tr->quantity_released;?></td>
                                        <td style="width: 80px;" align='center'><?php echo $tr->completion; ?></td>

                                        <input type="hidden" name="sub_details<?php echo $r->ptrans_id; ?>[]" value="<?php echo $tr->sub_details; ?>" />
                                        <input type="hidden" name="width<?php echo $r->ptrans_id; ?>[]" value="<?php echo $tr->width; ?>" />
                                        <input type="hidden" name="height<?php echo $r->ptrans_id; ?>[]" value="<?php echo $tr->height; ?>" />
                                        <input type="hidden" name="unit<?php echo $r->ptrans_id; ?>[]" value="<?php echo $tr->unit; ?>" />
                                        <input type="hidden" name="price<?php echo $r->ptrans_id; ?>[]" value="<?php echo $tr->price; ?>" />
                                        <input type="hidden" name="total<?php echo $r->ptrans_id; ?>[]" value="<?php echo $tr->total; ?>" />
                                        <input type="hidden" name="item_name[]" value="<?php echo $tr->item_name; ?>" />
                                        <input type="hidden" name="item_code[]" value="<?php echo $tr->item_code; ?>" />
                                        <input type="hidden" name="qty[]" value="<?php echo intval($tr->qty); ?>" />
								<input type="hidden" name="colour_finish[]" value="<?php echo $tr->colour_finish; ?>" />
                                <input type="hidden" name="quantity_released[]" value="<?php echo intval($tr->quantity_released); ?>" />
								<input type="hidden" name="completion[]" value="<?php echo $tr->completion; ?>" />

                                    </tr>
                        <?php $i++;
                                }  //end of if
                            }
                        } ?>


                    </tbody>
                </table>
            </div>









            <!-- <div class="form-group row">
                <table class="table table-bordered table-hover" id="tab_logic">
                    <thead>
                        <tr>
                            <th>Items</th>
                            <th> Description</th>
                            <th>Total QTY</th>
                            <th>Unit</th>
                            <th>QTY Released</th>
                            <th>Completion %</th>
                            <th width='10%'>                        
                                <a id="add_row" title="Add"
                                    class="btn btn-sm bg-orange"><span class="fa fa-plus"></span></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="mytbbody">
                        <?php $i = 50001;
                        foreach ($trans_records as $r): ?>
                            <tr>
                                <td>
                                    <select tabindex="11" class="form-select form-control-sm select2 select2Width"
                                        id="product_id<?php echo $i; ?>" name="product_id[]"
                                        onchange="get_treding_product_info(<?php echo $i; ?>)">
                                        <option value="">Select </option>
                                        <?php foreach ($products as $s) { ?>
                                            <option <?php if ($s->item_id == $r->production_type)
                                                        echo 'selected'; ?>
                                                value="<?php echo $s->item_id; ?>"><?php echo $s->item_code . ' ' . $s->item_name . ' ' . $s->part_code . ' ' . $s->make_model; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td> <textarea rows='4' cols='20' name="desc[]" id="desc<?php echo $i; ?>"
                                        style="font-size:11px; font-weight:bold;" class="form-control form-control-sm"
                                        tabindex='9'><?php echo $r->production_desc; ?></textarea>
                                </td>
                                <td>
                                    <input type="Text" name="tot_quantity[]" id="tot_quantity0" tabindex='10'
                                        class="form-control form-control-sm" value="<?php echo $r->tot_quantity; ?>">
                                </td>
                                <td>
                                    <input type="Text" name="unit[]" id="unit0" tabindex='10'
                                        class="form-control form-control-sm" value="<?php echo $r->unit; ?>">
                                </td>

                                <td>
                                    <input type="number" name="quantity_released[]" id="quantity_released0" tabindex='10'
                                        class="form-control form-control-sm" value="<?php echo $r->quantity_released; ?>">
                                </td>
                                <td>
                                    <input type="text" name="completion[]" id="completion0" tabindex='16'
                                        class="form-control form-control-sm" value="<?php echo $r->completion; ?>"
                                        placeholder="">
                                    <input type="hidden" name="trans_ptrans_idid[]" value="<?php echo $r->ptrans_id; ?>">
                                </td>
                                <td>
                                    <a href="javascript:confirmcancel(<?php echo $r->ptrans_id; ?>)" title="Delete"
                                        class="btn btn-xs bg-orange"><span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>

                        <tr id='addr1'></tr>
                    </tbody>
                </table>
            </div> -->

            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Remark</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <textarea name="remark" id="remark" class="form-control" rows="3"
                        cols="2"><?php echo $row1->remark; ?></textarea>
                </div>
            </div>




            <div class="form-group row">
            <label class="col-sm-2"></label>
            <div class="col-sm-10">
            <input type="hidden" id="production_id" name="production_id" value='<?php echo $row1->production_id; ?>'>
                                <button type="submit" tabindex="19" id="add" class="btn btn-primary m-b-0">Update</button>
            </div>
        </div>

        </form>




            
<?php } ?>
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
</script>