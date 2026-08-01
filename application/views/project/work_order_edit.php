<style type="text/css">
    .select2Width {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 220px !important;
        min-width: 220px !important;
    }
    .btn-sm .fa{color:#fff;}
</style>

<div class="x_panel">
    <div class="x_title">
        
        <div class="clearfix"></div>
        <a class="btn btn-sm btn-primary" href="<?php echo base_url() . 'index.php/'; ?>Project/print_work_order/<?php echo $id; ?>">Print</a>
    </div>

    <div class="x_content">
    <form id="main" method="post" action="<?php echo base_url() . 'index.php/'; ?>Project/update_work_order"
        autocomplete="off" enctype="multipart/form-data">
        <?php foreach ($records1 as $row1) { ?>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Project Name:<span
                        style="color: red;"> *</span></label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                    <select tabindex="1" class="form-control" id="project_id" name="project_id"
                        readonly onchange="get_project_info()">
                        <option value="">Select</option>
                        <?php foreach ($records as $s) { ?>
                            <option value="<?php echo $s->project_id ?>" <?php if ($row1->project_id == $s->project_id)
                                                                                echo 'selected'; ?>>
                                <?php echo $s->project_code . ' ' . $s->project_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Handed over to:</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <select tabindex="2" class="form-control" id="handed_over_to" name="handed_over_to">
                        <option value="">Select</option>
                        <?php foreach ($user_records as $s) { ?>
                            <option <?php if ($row1->handed_over_to == $s->user_id)
                                        echo 'selected'; ?>
                                value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                        <?php } ?>
                    </select>
                </div>



            </div>
            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Work Order Date :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <div class="input-group date datepicker1">
                        <input type="text" class="form-control form-control datepicker1" id="work_order_date"
                            name="work_order_date" value="<?php echo date('d-m-Y', strtotime($row1->work_order_date)); ?>"
                            tabindex="3">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label"> Work Order Code:</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
                    <input type="text" name="wo_code" id="wo_code" class="form-control form-control bg-soft-gray" value="<?php echo $row1->wo_code; ?>" readonly>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Fabrication Manhours :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <!-- <input type="number" step="0.01" class="form-control form-control" id="fm" name="fm" tabindex="3" min='0' value="<?php echo $row->overtime; ?>"> -->
                    <input type="number" step="0.01" class="form-control form-control" id="fm" name="fm" tabindex="3" min='0' value="<?php echo $row1->fabrication_manhr; ?>">

                </div>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Installation Manhours :</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <!-- <input type="number" step="0.01" class="form-control form-control" id="im" name="im" tabindex="3" min='0' value="<?php echo $row->overtime; ?>"> -->
                    <input type="number" step="0.01" class="form-control form-control" id="im" name="im" tabindex="3" min='0' value="<?php echo $row1->installation_manhr; ?>">

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

                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Select Customer</label>
                <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
                    <input type="text" class="form-control form-control bg-soft-gray" id="customer_id"
                        name="customer_id" value=" " tabindex="3">
                </div>

            </div>


            <!-- <div class="form-group row">
                <table class="table table-bordered table-hover" id="tab_logic">
                    <thead>
                        <tr>
                            <th>Items</th>
                            <th>Items Description</th>
                            <th>Colour/Finish</th>
                            <th>Quantity</th>
                            <th>UOM</th>
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
                                    <select tabindex="11" class="form-control select2Width"
                                        id="product_id<?php echo $i; ?>" name="product_id[]"
                                        onchange="get_treding_product_info(<?php echo $i; ?>)">
                                        <option value="">Select </option>
                                        <?php foreach ($products as $s) { ?>
                                            <option <?php if ($s->item_id == $r->cproduct_type)
                                                        echo 'selected'; ?>
                                                value="<?php echo $s->item_id; ?>"><?php echo $s->item_code . ' ' . $s->item_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td> <textarea rows='4' cols='20' name="desc[]" id="desc<?php echo $i; ?>"
                                        style="font-size:11px; font-weight:bold;" class="form-control form-control"
                                        tabindex='9' ><?php echo $r->item_desc; ?></textarea>
                                </td>
                                <td>
                                    <input type="Text" name="colour_finish[]" id="colour_finish0" tabindex='10'
                                        class="form-control form-control" value="<?php echo $r->colour_finish; ?>" >
                                </td>

                                <td>
                                    <input type="number" name="trading_qty[]" id="trading_qty0" tabindex='10'
                                        class="form-control form-control" value="<?php echo $r->quntity; ?>" >
                                </td>
                                <td>
                                    <input type="text" name="item_uom[]" id="item_uom0" tabindex='16'
                                        class="form-control form-control" value="<?php echo $r->uom; ?>"
                                        placeholder="" >
                                    <input type="hidden" name="trans_id[]" value="<?php echo $r->trans_id; ?>">
                                </td>
                                <td>
                                    <a href="javascript:confirmcancel(<?php echo $r->trans_id; ?>)" title="Delete"
                                        class="btn btn-xs bg-orange"><span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>

                        <tr id='addr1'></tr>
                    </tbody>
                </table>
            </div> -->

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


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records2 as $r) { ?>
                            <!--<tr class="bg-soft-gray">
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
                                    <textarea name='item_remark[]' class="form-control form-control" placeholder="add remark"><?php echo $r->item_remark; ?></textarea>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>-->
                            <?php $i = 1;
                            foreach ($records3 as $tr) {
                                if ($tr->trans_id1 == $r->trans_id) { ?>
                                    <tr>
                                        <td style="width: 80px;"><?php echo $i; ?></td>
                                        <td style="width: 80px;">
                                            <?php echo $tr->item_code; ?>
                                            <!-- <input type="text" name="item_code[]" value="<?php echo $tr->item_code; ?>" /> -->
                                        </td>
                                        <td style="width: 100px;">
                                            <?php echo $tr->item_name; ?>
                                            <!-- <input type="text" name="item_name[]" value="<?php echo $tr->item_name; ?>" /> -->
                                        </td>
                                        <td style="width: 80px;" align='center'><?php echo $tr->colour_finish; ?></td>
                                        <!-- <td style="width: 90px;"><input type="text" name="colour_finish[]" class="form-control form-control" style="margin-right: 30px;" value="<?php echo $tr->colour_finish; ?>" /></td> -->
                                        <!-- <td style="width: 80px;"><input type="text" name="qty<?php echo $r->trans_id; ?>[]" class="form-control form-control" value="<?php echo intval($tr->qty); ?>" readonly /></td> -->
                                        <td style="width: 80px;" align='center'><input type="text" name="qty<?php echo $r->trans_id; ?>[]" class="form-control form-control" value=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo intval($tr->qty); ?>" readonly style="border: none; background-color: transparent;" /></td>

                                        <td style="width: 80px;" align='center'><?php echo $tr->unit_abbr; ?></td>
                                        <input type="hidden" name="sub_details<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->sub_details; ?>" />
                                        <input type="hidden" name="width<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->width; ?>" />
                                        <input type="hidden" name="height<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->height; ?>" />
                                        <input type="hidden" name="unit<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->unit; ?>" />
                                        <input type="hidden" name="price<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->price; ?>" />
                                        <input type="hidden" name="total<?php echo $r->trans_id; ?>[]" value="<?php echo $tr->total; ?>" />
                                        <input type="hidden" name="item_name[]" value="<?php echo $tr->item_name; ?>" />
                                        <input type="hidden" name="item_code[]" value="<?php echo $tr->item_code; ?>" />
                                        <input type="hidden" name="product_id[]" value="<?php echo $tr->product_id; ?>" />
								

                                    </tr>
                        <?php $i++;
                                }  //end of if
                            }
                        } ?>


                    </tbody>
                </table>
            </div>
            <h7>Work Order Attachments:</h7>
            <div class="form-group row">
                <!-- <label class="col-xs-12 col-sm-3 col-md-3 col-lg-3 col-form-label">Upload("jpeg","jpg","png","doc","pdf"):</label> -->
                <!-- <div class="col-sm-8"> -->
                <table class="table table-bordered table-hover" id="tab_logic1">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Upload("jpeg","jpg","png","doc","pdf")</th>
                            <th>Select Type</th>
                            <th width='10%'>
                                <a id="add_row1" title="Add" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span></a>
                                <a id='delete_row1' title="Delete" class="btn btn-sm bg-red"><span class="fa fa-trash"></span></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="mytbbody1">
                        <?php $k = 50001;
                        //foreach ($attachment as $row): ?>
                            <tr id='r0'>
                                <td>1</td>

                                <td>
                                    <div class="col-sm-8">
                                        <input class="form-select form-control" id="documents_res" name="documents_res[]" tabindex="6" type="file">
                                    </div>
                                </td>


                                <td>
                                    <div class="form-group row">

                                        <div class="col-sm-10">
                                            <select class="form-select form-control" name="wo_attachments[]" id="wo_attachments">
                                                <option value="" selected disabled>Please select type</option>
                                                <option  value="Cutting List">Cutting List </option>
                                                <option  value="Optimization">Optimization</option>
                                                <option  value="Material Allocation">Material Allocation</option>
                                                <option  value="Indent To Stores">Indent To Stores</option>
                                                <option  value="Fabrication Details">Fabrication Details</option>
                                                <option  value="Templates/Samples">Templates/Samples</option>
                                                <option  value="Shop Drawing">Shop Drawing</option>

                                            </select>
                                        </div>
                                    </div>
                                </td>

                                <!--<td>
                                <a id="add_row1" title="Add" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span></a>
                                <a id='delete_row1' title="Delete" class="btn btn-sm bg-red"><span class="fa fa-trash"></span></a> 
                                </td>-->
                            </tr>



                            <?php if (!empty($file_records)) { 
                                
                                $x = 1;
                                $i = 1;
                                foreach ($file_records as $f) { ?>
                                     <input type="hidden" name="work_extra_id[]" value="<?= $f['work_extra_id']; ?>">
                                <?php
                                    if ($f['wo_type'] == 'Work Order Attachments') { ?>
                                        <tr>
                                            <td><?php echo $i;
                                                $i++; ?>
                                            </td>
                                            <td><a href="<?php echo base_url() . 'public/uploded_documents/' . $f['attachment_one']; ?>" download>File <?php echo $x;
                                                                                                                                                        $x++; ?></a></td>
                                            <td><?php echo $f['wo_attachments']; ?></td>
                                             <td>
                                                <button type="button"
                                                        class="btn btn-sm btn-danger deleteRoute"
                                                        data-id="<?= $f['work_extra_id']; ?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>                                                                                               
                                        </tr> 
                            <?php } 
                                }
                            } ?> 
 
 
 
 
                         <?php $k++;
                         //endforeach; ?>
 
                         <tr id='r1'></tr>
                    </tbody>
                 </table>
                 <!-- </div> -->
                   </div>
               
            <h7 >Product Process Route:</h7>
            <div  class="form-group row">
                <table class="table table-bordered table-hover" id="tab_logic2">
                     <thead>
                         <tr>
                             <!-- <th></th> -->
                            <th>Select Type</th>
                             <th>Description</th>
                             <th width='10%'>
                                  <a id="add_row2" title="Add" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span></a>
                                <a id='delete_row2' title="Delete" class="btn btn-sm bg-red"><span class="fa fa-trash"></span></a>
                             </th>
                        </ tr>
                    </thead >
                    <tbody id="mytbbody2">
                        <?php  $j = 50001;
                        foreach ($product_route as $row): 
                            if  ($row->wo_type == 'Product Process Route'):
                        ?>
                                 
                            <tr id='dr0'>
                               
                                <td >
                                     <div class="form-group row">
                                         <div class="col-sm-10">
                                            <select class="form-select form-control" name="product_route[]" id="product_route" required>
                <option value="" disabled>Please se lect process</option>
            
                <option value="Material Planning" <?php if ($row->product_route == 'Material Planning') echo 'selected'; ?>>
                    Material Planning
                </option>

                <option value="Material Cutting" <?php if ($row->product_route == 'Material Cutting') echo 'selected'; ?>>
                    Material Cutting
                </option>
            
                <option value="CNC Machining" <?php if ($row->product_route == 'CNC Machining') echo 'selected'; ?>>
                    CNC Machining
                </option>
            
                <option value="Edge Banding" <?php if ($row->product_route == 'Edge Banding') echo 'selected'; ?>>
                    Edge Banding
                </option>

                <option value="Drilling" <?php if ($row->product_route == 'Drilling') echo 'selected'; ?>>
                    Drilling
                </option>
            
                <option value="Assembly" <?php if ($row->product_route == 'Assembly') echo 'selected'; ?>>
                    Assembly
                </option>
            
                <option value="Sanding" <?php if ($row->product_route == 'Sanding') echo 'selected'; ?>>
                    Sanding
                </option>
            
                <option value="Painting / Polishing" <?php if ($row->product_route == 'Painting / Polishing') echo 'selected'; ?>>
                    Painting / Polishing
                </option>
            
                <option value="Quality Inspection" <?php if ($row->product_route == 'Quality Inspection') echo 'selected'; ?>>
                    Quality Inspection
                </option>
            
                <option value="Packing" <?php if ($row->product_route == 'Packing') echo 'selected'; ?>>
                    Packing
                </option>

                <option value="Dispatch" <?php if ($row->product_route == 'Dispatch') echo 'selected'; ?>>
                    Dispatch
                </ option>
            
                <option value="Site Installation" <?php if ($row->product_route == 'Site Installation') echo 'selected'; ?>>
                    Site Installation
                </option>
            
                <option value="Final Inspection" <?php if ($row->product_route == 'Final Inspection') echo 'selected'; ?>>
                    Final Inspection
                </option>

                <option value="Other" <?php if ($row->product_route == 'Other') echo 'selected'; ?>>
                    Other
                </option>
            </select>
                                         </div>
                                     </div>
                                 </td>
                                 <td>
                                     <input type="hidden" name="work_extra_id[]" value="<?= $row->work_extra_id; ?>">
                                    <textarea rows='4' cols='20' name="proute_desc[]" id="proute_desc0"
                                         style="font-size:11px; font-weight:bold;" class="form-control form-control"
                                         tabindex='13' placeholder="Description"><?php echo $row->proute_desc; ?></textarea>
                                 </td>
 
                                 <td>
                                 <button type="button"
                                         class="btn btn-sm btn-danger deleteRoute"
                                         data-id="<?= $row->work_extra_id; ?>">
                                     <i class="fa fa-trash"></i>
                                 </button>
                            </td>
 
                             </tr>
                             <?php
                              endif;
                               $j++;
                         endforeach; ?>
 
                             <tr id='dr1'></tr>
                     </tbody>
                 </table>
             </div>
            <h7>Work Order Distribution Plan:</h7>
             <div class="form-group row">
                 <table class="table table-bordered table-hover" id="tab_logic3">
                     <thead>
                         <tr>
                             <!-- <th></th> -->
                             <th>Select Type</th>
                             <th>Description</th>
                            <th width='10%'>
                                  <a id="add_row3" title="Add" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span></a>
                                 <a id='delete_row3' title="Delete" class="btn btn-sm bg-red"><span class="fa fa-trash"></span></a>
                            </th>
                         </tr>
                     </thead>
                     <tbody id="mytbbody3">
                     <?php $s = 50001;
                         foreach ($product_route as $row):
                             if ($row->wo_type == 'Work Order Distribution Plan'):
                         ?>
                         <tr id='ddr0'>
                             <!-- <td>1</td> -->
                             <td>
                                 <div class="form-group row">
                                    <div class="col-sm-10">
                                         <select class="form-select form-control" name="wo_plan[]" id="wo_plan">
                                             <option value="" selected disabled>Please select type</option>
                                             <option <?php if ($row->wo_plan == 'Originator') echo 'selected'; ?> value="Originator">Originator</option>
                                             <option <?php if ($row->wo_plan == 'Planning') echo 'selected'; ?> value="Planning">Planning</option>
                                             <option <?php if ($row->wo_plan == 'Quality') echo 'selected'; ?> value="Quality">Quality</option>
                                             <option <?php if ($row->wo_plan == 'Procurement') echo 'selected'; ?> value="Procurement">Procurement</option>
                                             <option <?php if ($row->wo_plan == 'Production') echo 'selected'; ?> value="Production">Production</option>
                                             <option <?php if ($row->wo_plan == 'Project') echo 'selected'; ?> value="Project">Project</option>
                                             <option <?php if ($row->wo_plan == 'Other') echo 'selected'; ?> value="Other">Other</option>
                                         </select>
                                    </div>
                                </di v>
                            </td> 
                            <td> 
                                  <input type="hidden" name="work_extra_id[]" value="<?= $row->work_extra_id; ?>">
                                    
                                <te xtarea rows='4' cols='20' name="woplan_desc[]" id="woplan_desc0"
                                     style="font-size:11px; font-weight:bold;" class="form-control form-control"
                                    tabindex='13' placeholder="Description"><?php echo $row->woplan_desc; ?></textarea>
                            </td>  
 
                            <td>
                                 <button type="button"
                                         class="btn btn-sm btn-danger deleteRoute"
                                         data-id="<?= $row->work_extra_id; ?>">
                                     <i class="fa fa-trash"></i>
                                 </button>
                             </td>
 
 
                         </tr>
                     <?php 
                     endif;
                    $s++;
                         endforeach; ?>
 
                     <tr id='ddr1'></tr>
                     </tbody>
                 </table>
             </div>
 
 
 
             <div class="form-group row">
                 <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Prepared By:</label>
                 <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                    <select tabindex="1" class="form-control" id="prepared_id" name="prepared_id"
                         style='width:155px'>
                         <option value="">Select</option>
                         <?php foreach ($user_records as $s) { ?>
                             <option <?php if ($row1->prepared_by == $s->user_id)
                                         echo 'selected'; ?>
                                 value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                         <?php } ?>
                     </select>
                 </div>
 
                 <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Checked By:</label>
                 <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                    <select tabindex="1" class="form-control" id="checked_id" name="checked_id"
                         style='width:155px'>
                         <option value="">Select</option>
                         <?php foreach ($user_records as $s) { ?>
                             <option <?php if ($row1->checked_by == $s->user_id)
                                         echo 'selected'; ?>
                                 value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                         <?php } ?>
                    </select>
                 </div>
                 <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Approved By:</label>
                 <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
                     <select tabindex="1" class="form-control" id="approved_id" name="approved_id"
                         style='width:155px'>
                         <option value="">Select</option>
                         <?php foreach ($user_records as $s) { ?>
                             <option <?php if ($row1->approved_by == $s->user_id)
                                         echo 'selected'; ?>
                                 value="<?php echo $s->user_id ?>"><?php echo $s->user_name; ?></option>
                         <?php } ?>
                    </select>
                </div>
 
             </div>
 
                                                                                                                                                                                      



            <table>
                <tr>
                    <td>
                        <div class="form-group row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <input type="hidden" id="work_id" name="work_id" value='<?php echo $row1->work_id; ?>'>

                                <?php if ($row1->approve_flag == 0): ?>
                                    <button type="submit" tabindex="19" id="add" class="btn btn-primary m-b-0">Update</button>
                                <?php endif; ?>
                            </div>
                        </div>


    </form>



    </td>
    <td>

        <form id="main" method="post" action="<?php echo base_url() . 'index.php/Project/approve_work_order'; ?>"
            autocomplete="off" enctype="multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="hidden" id="work_id" name="work_id" value='<?php echo $row1->work_id; ?>'>
                    <?php if ($row1->approve_flag == 0): ?>
                        <button type="submit" name="action" value="1" class="btn btn-success m-b-0">Accept</button>
                    <?php else: ?>
                        <button type="submit" name="action" value="0" class="btn btn-danger m-b-0">Reject</button>

                    <?php endif; ?>
                </div>
            </div>
        </form>

    </td>

    </tr>
    </table>
<?php } ?>
</div>
</div></div></div>

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
            //$('#dr' + k).html("<td><div class='col-sm-10'><select class='form-select form-control' name='product_route[]' id='product_route'><option value='' selected disabled>Please select document type</option><option value='Paing plant'>Paing plant</option><option value='Galvanizing plant'>Galvanizing plant</option><option value='Alum. Fabrication'>Alum. Fabrication</option><option value='Steel Fabrication'>Steel Fabrication</option><option value='Glazing Section'>Glazing Section</option><option value='Site Installation'>Site Installation</option><option value='Other'>Other</option></select></div></td><td><textarea rows='4' cols='20' name='proute_desc[]' id='proute_desc" + k + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td></td>");
            $('#dr' + k).html("<td><div class='col-sm-10'><select class='form-select form-control' name='product_route[]' id='product_route'><option value='' selected disabled>Please select process</option><option value='Material Planning'>Material Planning</option><option value='Material Cutting'>Material Cutting</option><option value='CNC Machining'>CNC Machining</option><option value='Edge Banding'>Edge Banding</option><option value='Drilling'>Drilling</option><option value='Assembly'>Assembly</option><option value='Sanding'>Sanding</option><option value='Painting / Polishing'>Painting / Polishing</option><option value='Quality Inspection'>Quality Inspection</option><option value='Packing'>Packing</option><option value='Dispatch'>Dispatch</option><option value='Site Installation'>Site Installation</option><option value='Final Inspection'>Final Inspection</option><option value='Other'>Other</option></select></div></td><td><textarea rows='4' cols='20' name='proute_desc[]' id='proute_desc" + k + "' style='font-size:11px; font-weight:bold;' class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td></td>");
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
            $('#ddr' + p).html("<td><div class='col-sm-10'><select class='form-select form-control' name='wo_plan[]' id='wo_plan'><option value='' selected disabled>Please select document type</option><option value='Originator'>Originator</option><option value='Planning'>Planning</option><option value='Quality'>Quality</option><option value='Procurement'>Procurement</option><option value='Production'>Production</option><option value='Project'>Project</option><option value='Other'>Other</option></select></div></td><td><textarea rows='4' cols='20' name='woplan_desc[]' id='woplan_desc" + p + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td></td>");
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
            // $('#addr' + i).html("<td><select tabindex='11' class='form-control' id='product_id" + i + "' name='product_id[]' onchange='get_treding_product_info(" + i + ")' style='width:350px;'><option value=''>Select </option><?php foreach ($products as $s) { ?><option value='<?php echo $s->item_id; ?>'><?php echo $s->item_code . ' ' . $s->item_name; ?></option><?php } ?></select><textarea rows='4' cols='20' name='desc[]' id='desc" + i + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td><input type='number' name='trading_qty[]' id='trading_qty" + i + "' tabindex='14' class='form-control form-control' placeholder='' ></td><td><textarea name='item_remark[]' id='item_remark" + i + "' tabindex='16' class='form-control form-control' placeholder='remark' ></textarea></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
            $('#addr' + i).html("<td><select tabindex='11' class='form-control' id='product_id" + i + "' name='product_id[]' onchange='get_treding_product_info(" + i + ")' style='width:350px;'><option value=''>Select </option><?php foreach ($products as $s) { ?><option value='<?php echo $s->item_id; ?>'><?php echo $s->item_code . ' ' . $s->item_name; ?></option><?php } ?></select></td><td><textarea rows='4' cols='20' name='desc[]' id='desc" + i + "' style='font-size:11px; font-weight:bold;'  class='form-control form-control' tabindex='13' placeholder='Description'></textarea></td><td><input type='text' name='colour_finish[]' id='colour_finish" + i + "' tabindex='14' class='form-control form-control' placeholder='' ></td><td><input type='number' name='trading_qty[]' id='trading_qty" + i + "' tabindex='14' class='form-control form-control' placeholder='' ></td><td><input type='text' name='item_uom[]' id='item_uom" + i + "' tabindex='16' class='form-control form-control' placeholder='' ></td><td><a id='delete_row' title='Delete' onclick='remove_row(" + i + ")' class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
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


    function get_project_info() {
        var project_id = document.getElementById("project_id").value;
        if (project_id != '') {
            $.ajax({
                async: false,
                type: "POST",
                url: "<?php echo base_url() ?>index.php/Project/ajax_get_project_info",
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


    window.onload = function() {
        var project_id = document.getElementById("project_id").value;
        if (project_id) {
            get_project_info();
        }
    };



    ////////////////  Item  detail /////////////////////

    function get_project_items_details() {
        var project_id = $("#project_id").val();
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo base_url() ?>index.php/Ajax/get_project_items_details",
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
            url: "<?php echo base_url() ?>index.php/Ajax/get_project_items_list",
            data: {
                project_id: project_id
            },
            success: function(msg) {
                // alert(msg);

                document.getElementById('item_list_id').innerHTML = msg;

            }
        });
    }

    $(document).on('click', '.deleteRoute', function () {

    var btn = $(this);
    var id = btn.data('id');

    if(confirm('Are you sure you want to delete this process?'))
    {
        $.ajax({
            url: "<?php echo base_url() ?>index.php/Project/delete_product_route",
            type: "POST",
            data: {
                id:id
            },
            success:function(response)
            {
                if(response == 1)
                {
                    btn.closest('tr').remove();
                }
                else
                {
                    alert('Delete failed.');
                }
            }
        });
    }

});
</script>