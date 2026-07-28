<style type="text/css">
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 220px !important;
        min-width: 220px !important;
    }
        label,
    h4 {
        color: black;
        font-weight: bold;
    }

    table th,
    table td {
        vertical-align: middle !important;
    }
    .btn-sm .fa{color:#fff;}
</style>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div >
              
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Project/add_work_order_details"
        autocomplete="off" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Project:<span
                    style="color: red;"> * </span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                <select tabindex="1" class="form-select form-control select2" id="project_id" name="project_id"
                    required onchange="get_project_items_details()">
                    <option value="">Select</option>
                    <?php foreach ($records as $s) { ?>
                        <option value="<?php echo $s->project_id ?>"><?php echo $s->project_code . ' ' . $s->project_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label" style="padding-right: 5px;"> Handed over to:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <select tabindex="2" class="form-select form-control select2" id="handed_over_to" name="handed_over_to" >
                    <option value="">Select</option>
                    <?php foreach ($user_records as $s) { ?>
                        <option value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>

        <div class="form-group row">

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Work Order Date :</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <div class="input-group date">
                    <input type="date" class="form-control form-control datepicker1" id="work_order_date"
                        name="work_order_date" value="<?php echo date('d-m-Y') ?>" tabindex=2 re>
                    
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Work Order Code:<span
                    style="color: red;"> * </span></label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                <input type="text" name="wo_code" id="wo_code" class=" form-control bg-soft-gray" value="<?php echo $code; ?>" required>
            </div>

        </div>

        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Fab. Starting Date :</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                <div class="input-group date">
                    <input type="date" class="form-control form-control datepicker1" id="fsdate"
                        name="fsdate" value="<?php echo date('d-m-Y') ?>" tabindex=2 re>
                    
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Fab. End Date :</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                <div class="input-group date">
                    <input type="date" class="form-control form-control datepicker1" id="fedate"
                        name="fedate" value="<?php echo date('d-m-Y') ?>" tabindex=2 re>
                    
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Fabrication Manhours :</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                <input type="number" step="0.01" class="form-control form-control" id="fm" name="fm" tabindex="3" min='0'>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Inst. Starting Date :</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                <div class="input-group date ">
                    <input type="date" class="form-control form-control" id="isdate"
                        name="isdate" value="<?php echo date('d-m-Y') ?>" tabindex=2 re>
                    
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Inst. End Date :</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                <div class="input-group date">
                    <input type="date" class="form-control form-control " id="iedate"
                        name="iedate" value="<?php echo date('d-m-Y') ?>" tabindex=2 re>
                    
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Installation Manhours :</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                <input type="number" step="0.01" class="form-control form-control" id="im" name="im" tabindex="3" min='0'>
            </div>

        </div>




        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Start Date :</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <div class="input-group date ">
                    <input type="text" class="form-control form-control bg-soft-gray" id="sdate"
                        name="sdate" value="<?php echo date('d-m-Y') ?>" tabindex="3" readonly>
                    <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                </div>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project End Date:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <div class="input-group date ">
                    <input type="text" class="form-control form-control bg-soft-gray" id="edate" name="edate"
                        value="<?php echo date('d-m-Y') ?>" tabindex=4 readonly>
                    <!-- <div class="input-group-addon"><i class="fa fa-calendar"></i></div> -->
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Manager:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                <input type="text" class="form-control form-control bg-soft-gray" id="manager_id"
                    name="manager_id" value=" " tabindex="3" readonly>
            </div>
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Customer:</label>
            <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                <input type="text" class="form-control form-control bg-soft-gray" id="customer_id"
                    name="customer_id" value=" " tabindex="3">
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
                        <th>Items Description</th>
                        <th>Colour/Finish</th>
                        <th>Quantity</th>
                        <th>UOM</th>
                        <th width='10%'><a id="add_row" title="Add" class="btn btn-sm bg-orange"><span
                                    class="fa fa-plus"></span></a></th>
                    </tr>
                </thead>

                <tbody id="mytbbody">
                    <tr id='addr0'>
                        <td>
                            <select tabindex="11" class="form-select form-control select2" id="product_id0"
                                name="product_id[]" onchange="get_treding_product_info(0)" style="width:300px;">
                                <option value="">Select</option>
                                <?php foreach ($products as $s) { ?>
                                    <option value="<?php echo $s->item_id; ?>"><?php echo $s->item_code . ' ' . $s->item_name; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <textarea rows='4' cols='20' name="desc[]" id="desc0"
                                style="font-size:11px; font-weight:bold;" class="form-control form-control"
                                tabindex='13' placeholder="Description"></textarea>
                        </td>
                        <td><input type="text" name="colour_finish[]" id="colour_finish0" tabindex='14'
                                class="form-control form-control" placeholder=""></td>

                        <td><input type="number" name="trading_qty[]" id="trading_qty0" tabindex='14'
                                class="form-control form-control" placeholder=""></td>

                        <td><input type="text" name="item_uom[]" id="item_uom0" tabindex='16'
                                class="form-control form-control" placeholder="" style="width: 80px; height: 35px; font-size: 16px;"></td>
                        <td><a id='delete_row' title="Delete" onclick='remove_row(0)'
                                class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a></td>
                    </tr>
                    <tr id='addr1'></tr>
                </tbody>
            </table>
        </div> -->


        <h7>Work Order Attachments:</h7>
        <div class="form-group row">
            <!-- <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg","png","doc","pdf"):</label> -->
            <!-- <div class="col-sm-8"> -->
            <table class="table table-bordered table-hover" id="tab_logic1">
                <thead>
                    <tr>
                        <th></th>
                        <th>Upload("jpeg","jpg","png","doc","pdf") <span
                    style="color: red;"> * </span></th>
                        <th>Select Type</th>
                        <th width='10%'>
                            <a id="add_row1" title="Add" class="btn btn-sm bg-red"><span class="fa fa-plus"></span></a>
                            <a id='delete_row1' title="Delete" class="btn btn-sm btn-primary"><span class="fa fa-trash"></span></a>
                        </th>
                    </tr>
                </thead>
                <tbody id="mytbbody1">
                    <tr id='r0'>
                        <td>1</td>

                        <td>
                            <div class="col-sm-8">
                                <input class="form-select form-control" id="documents_res0" name="documents_res[]" tabindex="6" type="file" required>
                            </div>
                        </td>


                        <td>
                            <div class="form-group row">

                                <div class="col-sm-10">
                                    <select class="form-select form-control" name="wo_attachments[]" id="wo_attachments">
                                        <option value="" selected disabled>Please select type</option>
                                        <option value="Cutting List">Cutting List </option>
                                        <option value="Optimization">Optimization</option>
                                        <option value="Material Allocation">Material Allocation</option>
                                        <option value="Indent To Stores">Indent To Stores</option>
                                        <option value="Fabrication Details">Fabrication Details</option>
                                        <option value="Templates/Samples">Templates/Samples</option>
                                        <option value="Shop Drawing">Shop Drawing</option>
                                    </select>
                                </div>
                            </div>
                        </td>

                        <td>
                            <!-- <a id="add_row1" title="Add" class="btn btn-sm bg-blue"><span class="fa fa-plus"></span></a>
                                <a id='delete_row1' title="Delete" class="btn btn-sm bg-blue"><span class="fa fa-trash"></span></a> -->
                        </td>
                    </tr>
                    <tr id='r1'></tr>
                </tbody>
            </table>
            <!-- </div> -->
        </div>


        <h7>Product Process Route:</h7>
        <div class="form-group row">
            <table class="table table-bordered table-hover" id="tab_logic2">
                <thead>
                    <tr>
                        <th></th>
                        <th>Select Type <span
                    style="color: red;"> * </span></th>
                        <th>Description</th>
                        <th width='10%'>
                            <a id="add_row2" title="Add" class="btn btn-sm bg-red"><span class="fa fa-plus"></span></a>
                            <a id='delete_row2' title="Delete" class="btn btn-sm btn-primary"><span class="fa fa-trash"></span></a>
                        </th>
                    </tr>
                </thead>
                <tbody id="mytbbody2">
                    <tr id='dr0'>
                        <td>1</td>
                        <td>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <select class="form-select form-control" name="product_route[]" id="product_route" required>
                                        <option value="" selected disabled>Please select process</option>
                                        <option value="Material Planning">Material Planning</option>
                                        <option value="Material Cutting">Material Cutting</option>
                                        <option value="CNC Machining">CNC Machining</option>
                                        <option value="Edge Banding">Edge Banding</option>
                                        <option value="Drilling">Drilling</option>
                                        <option value="Assembly">Assembly</option>
                                        <option value="Sanding">Sanding</option>
                                        <option value="Painting / Polishing">Painting / Polishing</option>
                                        <option value="Quality Inspection">Quality Inspection</option>
                                        <option value="Packing">Packing</option>
                                        <option value="Dispatch">Dispatch</option>
                                        <option value="Site Installation">Site Installation</option>
                                        <option value="Final Inspection">Final Inspection</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <textarea rows='4' cols='20' name="proute_desc[]" id="proute_desc0"
                                style="font-size:11px; font-weight:bold;" class="form-control form-control"
                                tabindex='13' placeholder="Description"></textarea>
                        </td>

                        <td></td>
                    </tr>
                    <tr id='dr1'></tr>
                </tbody>
            </table>
        </div>
        <h7>Work Order Distribution Plan:</h7>
        <div class="form-group row">
            <table class="table table-bordered table-hover" id="tab_logic3">
                <thead>
                    <tr>
                        <th></th>
                        <th>Select Type<span
                    style="color: red;"> * </span> </th>
                        <th>Description</th>
                        <th width='10%'>
                            <a id="add_row3" title="Add" class="btn btn-sm bg-red"><span class="fa fa-plus"></span></a>
                            <a id='delete_row3' title="Delete" class="btn btn-sm btn-primary"><span class="fa fa-trash"></span></a>
                        </th>
                    </tr>
                </thead>
                <tbody id="mytbbody3">
                    <tr id='ddr0'>
                        <td>1</td>
                        <td>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <select class="form-select form-control" name="wo_plan[]" id="wo_plan" required>
                                        <option value="" selected disabled>Please select type</option>
                                        <option value="Originator">Originator</option>
                                        <option value="Planning">Planning</option>
                                        <option value="Quality">Quality</option>
                                        <option value="Procurement">Procurement</option>
                                        <option value="Production">Production</option>
                                        <option value="Project">Project</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <textarea rows='4' cols='20' name="woplan_desc[]" id="woplan_desc0"
                                style="font-size:11px; font-weight:bold;" class="form-control form-control"
                                tabindex='13' placeholder="Description"></textarea>
                        </td>

                        <td></td>
                    </tr>
                    <tr id='ddr1'></tr>
                </tbody>
            </table>
        </div>



        <div class="form-group row">
            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label" style="padding-right: 5px;">Prepared By:</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2" style="padding-left: 5px;">
                <select tabindex="1" class="form-select form-control select2" id="prepared_id" name="prepared_id" required style="width: 150px;">
                    <option value="">Select</option>
                    <?php foreach ($user_records as $s) { ?>
                        <option value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label" style="padding-right: 5px;">Checked By:</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2" style="padding-left: 5px;">
                <select tabindex="1" class="form-select form-control select2" id="checked_id" name="checked_id" required style="width: 150px;">
                    <option value="">Select</option>
                    <?php foreach ($user_records as $s) { ?>
                        <option value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label" style="padding-right: 5px;">Approved By:</label>
            <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2" style="padding-left: 5px;">
                <select tabindex="1" class="form-select form-control select2" id="approved_id" name="approved_id" style="width: 150px;">
                    <option value="">Select</option>
                    <?php foreach ($user_records as $s) { ?>
                        <option value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                    <?php } ?>
                </select>
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

<script>
    ////////////////  Work Order Attachments   /////////////////////
    $(document).ready(function() {
        var j = 1;
        $("#add_row1").click(function() {
            $('#r' + j).html("<td>" + (j + 1) + "</td><td><div class='col-sm-8'><input class='form-control' id='documents_res" + j + "' name='documents_res[]' type='file'></div></td><td><div class='col-sm-10'><select class='form-select form-control' name='wo_attachments[]' id='wo_attachments'><option value='' selected disabled>Please select type</option><option value='Cutting List'>Cutting List</option><option value='Optimization'>Optimization</option><option value='Material Allocation'>Material Allocation</option><option value='Indent To Stores'>Indent To Stores</option><option value='Fabrication Details'>Fabrication Details</option><option value='Templates/Samples'>Templates/Samples</option><option value='Shop Drawing'>Shop Drawing</option></select></div></td><td></td>");
            $('#tab_logic1').append('<tr id="r' + (j + 1) + '"></tr>');
            j++;
        });

        $("#delete_row1").click(function() {
            if (j > 1) {
                $("#r" + (j - 1)).html('');
                j--;
            }
        });
    });

    ////////////////  Product Process Route   /////////////////////
    $(document).ready(function() {
        var k = 1;
        $("#add_row2").click(function() {
            //$('#dr' + k).html("<td>" + (k + 1) + "</td><td><div class='col-sm-10'><select class='form-select form-control' name='product_route[]' id='product_route'><option value='' selected disabled>Please select document type</option><option value='Paing plant'>Paing plant</option><option value='Galvanizing plant'>Galvanizing plant</option><option value='Alum. Fabrication'>Alum. Fabrication</option><option value='Steel Fabrication'>Steel Fabrication</option><option value='Glazing Section'>Glazing Section</option><option value='Site Installation'>Site Installation</option><option value='Other'>Other</option></select></div></td><td><textarea rows='4' cols='20' name='proute_desc[]' id='proute_desc" + k + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td></td>");
            $('#dr' + k).html("<td>" + (k + 1) + "</td><td><select class='form-select form-control' name='product_route[]' id='product_route'><option value='' selected disabled>Please select process</option><option value='Material Planning'>Material Planning</option><option value='Material Cutting'>Material Cutting</option><option value='CNC Machining'>CNC Machining</option><option value='Edge Banding'>Edge Banding</option><option value='Drilling'>Drilling</option><option value='Assembly'>Assembly</option><option value='Sanding'>Sanding</option><option value='Painting / Polishing'>Painting / Polishing</option><option value='Quality Inspection'>Quality Inspection</option><option value='Packing'>Packing</option><option value='Dispatch'>Dispatch</option><option value='Site Installation'>Site Installation</option><option value='Final Inspection'>Final Inspection</option><option value='Other'>Other</option></select></div></td><td><textarea rows='4' cols='20' name='proute_desc[]' id='proute_desc" + k + "' style='font-size:11px; font-weight:bold;' class='form-control form-control-sm' tabindex='13' placeholder='Description'></textarea></td><td></td>");
            $('#tab_logic2').append('<tr id="dr' + (k + 1) + '"></tr>');
            k++;
        });

        $("#delete_row2").click(function() {
            if (k > 1) {
                $("#dr" + (k - 1)).html('');
                k--;
            }
        });
    });
    ////////////////  Work Order Distribution Plan   /////////////////////
    $(document).ready(function() {
        var p = 1;
        $("#add_row3").click(function() {
            $('#ddr' + p).html("<td>" + (p + 1) + "</td><td><div class='col-sm-10'><select class='form-select form-control' name='wo_plan[]' id='wo_plan'><option value='' selected disabled>Please select document type</option><option value='Originator'>Originator</option><option value='Planning'>Planning</option><option value='Quality'>Quality</option><option value='Procurement'>Procurement</option><option value='Production'>Production</option><option value='Project'>Project</option><option value='Other'>Other</option></select></div></td><td><textarea rows='4' cols='20' name='woplan_desc[]' id='woplan_desc" + p + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td></td>");
            $('#tab_logic3').append('<tr id="ddr' + (p + 1) + '"></tr>');
            p++;
        });

        $("#delete_row3").click(function() {
            if (p > 1) {
                $("#ddr" + (p - 1)).html('');
                p--;
            }
        });
    });


    ////////////////  Item   /////////////////////


    $(document).ready(function() {
        var i = 1;
        $("#add_row").click(function() {
            $('#addr' + i).html("<td><select tabindex='11' class='form-select form-control select2' id='product_id" + i + "' name='product_id[]' onchange='get_treding_product_info(" + i + ")' style='width:350px;'><option value=''>Select </option><?php foreach ($products as $s) { ?><option value='<?php echo $s->item_id; ?>'><?php echo $s->item_code . ' ' . $s->item_name; ?></option><?php } ?></select></td><td><textarea rows='4' cols='20' name='desc[]' id='desc" + i + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td><input type='text' name='colour_finish[]' id='colour_finish" + i + "' tabindex='14' class='form-control form-control' placeholder='' ></td><td><input type='number' name='trading_qty[]' id='trading_qty" + i + "' tabindex='14' class='form-control form-control' placeholder='' ></td><td><input type='text' name='item_uom[]' id='item_uom" + i + "' tabindex='16' class='form-control form-control' placeholder='' ></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
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
                    document.getElementById("trading_qty" + append_id).value = msg.unit_price;

                }
            });
        } else {
            document.getElementById("desc" + append_id).value = '';
            document.getElementById("trading_qty" + append_id).value = '';

        }
    }

    ////////////////  Item  detail /////////////////////

    function get_project_items_details() {
        var project_id = $("#project_id").val();
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url() ?>index.php/Project/get_project_items_details",
            data: {
                project_id: project_id
            },
            dataType: "json",
            success: function(msg) {
                // alert(msg);

                document.getElementById("customer_id").value = msg.customer_id;
                document.getElementById("manager_id").value = msg.user_id;
                document.getElementById("sdate").value = msg.sdate;
                document.getElementById("edate").value = msg.edate;

            }
        });
        get_project_items_list();

    }

    function get_project_items_list() {
        var project_id = $("#project_id").val();
        // alert(project_id);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>index.php/Project/get_project_items_list",
            data: {
                project_id: project_id
            },
            success: function(msg) {
                // alert(msg);

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
                url: "<?php echo base_url() ?>index.php/Ajax/ajax_get_project_info",

                data: {
                    project_id: project_id
                },
                dataType: "json",
                success: function(msg) {
                    document.getElementById("customer_id").value = msg.customer_id;
                    document.getElementById("manager_id").value = msg.user_id;
                    document.getElementById("sdate").value = msg.sdate;
                    document.getElementById("edate").value = msg.edate;

                },
                error: function(xhr, status, error) {
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