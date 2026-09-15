<style>
    .select2-container {
        width: 100% !important;
        display: block !important;
    }
    .select2-container .select2-selection--single {
        height: 31px !important;
    }
</style>

<div class="card-body">
	<form id="main" method="post" action="<?php echo base_url().'index.php/'; ?>AMC/add_quotation_data" autocomplete="off" enctype="multipart/form-data">
	<div class="form-group row align-items-center mb-3">
            <!-- Select Enquiry Label -->
            <label for="enq_id" class="col-sm-3 col-md-2 col-form-label">
                Select Enquiry <span class="text-danger">*</span>
            </label>
            
            <!-- Select Enquiry Field -->
            <div class="col-sm-9 col-md-4">
                <select tabindex="1"
                        class="form-select form-control-sm select2"
                        id="enq_id"
                        name="enq_id"
                        style="width: 100%;"
                        required
                        onchange="get_enquiry_info()">
                    <option value="">Select</option>
                    <?php foreach($enq_records as $s) { ?>
                        <option value="<?php echo $s->amc_enq_id; ?>">
                            <?php echo $s->amc_enq_code.' '.$s->cust_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Project Name Label -->
            <label for="project_name" class="col-sm-3 col-md-2 col-form-label">
                Project Name
            </label>
            
            <!-- Project Name Field -->
            <div class="col-sm-9 col-md-4">
               
					   <input type="text"
       name="project_name"
       id="project_name"
       class="form-control form-control-sm bg-soft-gray"
       readonly>
            </div>
        </div>
		
<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Quotation date</label>
		    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3" role='group'>
				<div class="input-group date datepicker1">			                  
		    			<input type="text" class="form-control form-control-sm datepicker1" id="qdate" name="qdate" value="<?php echo date('d-m-Y')?>" required tabindex='2'>
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			      	</div>
     		     </div>

	     	    <label class="col-xs-12 col-sm-1 col-md-2 col-lg-2 col-form-label">Quotation Code:</label>
	    	    <div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
			      <input type="text" name="qcode" id="qcode" class="form-control form-control-sm bg-soft-gray"  tabindex='3' value="<?php echo $code; ?>">
		     </div>
		</div>
<!-- <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-form-label">Quotation Print<span style="color: red;"> * </span></label>
<div class="col-xs-12 col-sm-9 col-md-3 col-lg-3">
    <select tabindex="4" class="form-select form-control-sm select2" id="quot_print_type" name="quot_print_type" required>
        <option value="1">Non-comprehensive</option>
        <option value="2">Comprehensive</option>
    </select>
</div> -->
	<div class="form-group row">

    <label class="col-md-2 col-form-label">
       Location
    </label>

    <div class="col-md-4">
      <input type="text" name="project_location" id="project_location"
               class="form-control form-control-sm">
    </div>

    <label class="col-md-2 col-form-label">
       Subject
    </label>

    <div class="col-md-4">
        <textarea name="subject" id="subject"
                  class="form-control form-control-sm"
                  rows="2"></textarea>
    </div>

</div>

		<div class="form-group row">

    <label class="col-md-2 col-form-label">
        AMC Start Date
    </label>

    <div class="col-md-4">
        <input
            type="date"
            name="amc_start_datea"
            id="amc_start_datea"
            class="form-control form-control-sm">
    </div>

    <label class="col-md-2 col-form-label">
        AMC End Date
    </label>

    <div class="col-md-4">
        <input
            type="date"
            name="amc_end_datea"
            id="amc_end_datea"
            class="form-control form-control-sm">
    </div>

</div>
	<div class="form-group row align-items-center">

    <label class="col-sm-2 col-form-label">Contract Type <span style="color: red;"> * </span></label>

    <div class="col-sm-2">
        <select class="form-control form-control-sm"
                name="contract_type"
                id="contract_type"
                onchange="toggleContractCount()" required>
            <option value="">Select</option>
            <option value="Yearly">Yearly</option>
            <option value="Quarterly">Quarterly</option>
        </select>
    </div>

    <div class="col-sm-3" id="year_block" style="display:none;">
        <div class="d-flex align-items-center">
            <label class="mr-2 mb-0">No. of Years</label>
            <input type="number" class="form-control form-control-sm"
                   name="no_of_years" id="no_of_years" min="1">
        </div>
    </div>

    <div class="col-sm-3" id="quarter_block" style="display:none;">
        <div class="d-flex align-items-center">
            <label class="mr-2 mb-0">No. of Quarters</label>
            <input type="number" class="form-control form-control-sm"
                   name="no_of_quarters" id="no_of_quarters" min="1">
        </div>
    </div>

</div>
		
		<div class="form-group row" >
	    	<div class="col-md-12">
			<div class="dt-responsive">
			<table class='bg-soft-success' width='85%' cellspacing="0" colspacing="0" border='1' style="font-size:12px;font-weight:bold;">
				<tr>
					<th  style="background-color:#cccccc!important;">Enquiry Code</th>
					<th  style="background-color:#cccccc!important;">Enquiry Date</th>
					<th  style="background-color:#cccccc!important;">Customer</th>
					<!-- <th  style="background-color:#cccccc!important;">AMC Start Date</th>
					<th  style="background-color:#cccccc!important;">AMC End Date</th> -->
				</tr>
				<tr>
					<th><label id='enq_code'></label></th>
					<th><input type="text" id='enq_date' class="form-control text-black" value="" readonly="TRUE"></th>					
					<th id='cust_name'> </th>
					<!-- <th><input type="text" id='amc_start_date' name='amc_start_date' > </th>
				
					<th><input type="text" id='amc_end_date' name='amc_end_date' > </th>  -->

				</tr>
				
				<input type="hidden" id='customer_id' name='customer_id' class="form-control" value="" readonly="TRUE">
				<!-- <input type="hidden" id='amc_start_datea' name='amc_start_datea' > 
				<input type="hidden" id='amc_end_datea' name='amc_end_datea' >  -->
				<input type="hidden" id='enq_type' name='enq_type' > 
				
				<input type="hidden" id='enquiry_code' name='enquiry_code' > 
				<input type="hidden" id='enquiry_revision' name='enquiry_revision' > 
			</table>
			</div>
	   	</div>
		</div>
		
		<div id="item_list_id">
		</div>
		
		<div id='product_div1'>
	
		</div>
		<!-- <div class="form-group row">

    <label class="col-md-2 col-form-label">
        Currency
    </label>

    <div class="col-md-4">

        <select
            class="form-control form-control-sm select2"
            id="currency_id"
            name="currency_id"
            onchange="get_currency_conversion()">

            <option value="">Select Currency</option>     

        </select>

    </div>

</div> -->

<input type="hidden" id="cid" name="cid" value="">
<input type="hidden" id="crate" name="crate" value="1">
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-1 col-lg-1 col-form-label">SubTot</label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		     	 <input type="text" id='sub_total' name='sub_total' readonly class="form-control form-control-sm" value="0" tabindex=12>
		    </div>
			<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 col-form-label">AMC Dis:</label>
	    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-1">
			      <input type="number" name="amc_discount" id="amc_discount" class="form-control form-control-sm"  onkeyup="calculate_grand_total()" value=0 tabindex=7>
		      </div>
			<label class="col-xs-12 col-sm-1 col-md-1 col-lg-1 col-form-label">Dis.%:</label>
	    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-1">
			      <!-- <input type="number" name="discount" id="discount" class="form-control form-control-sm"  onkeyup="calculate_grand_total()" value=0 tabindex=7> -->
                  <input type="number" name="discount" id="discount" class="form-control form-control-sm"  onkeyup="calc_discount_from_percent()" value=0 tabindex=7>  
		      </div>
	    	    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-1">
			      <input type="number" step="0.01" name="discount_amt" id="discount_amt" class="form-control form-control-sm"  onkeyup="calculate_grand_total()" value='0' tabindex=8>
		     </div>
	     	   
		    <label class="col-xs-12 col-sm-2 col-md-2  col-lg-2 col-form-label">Total before VAT</label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		       <input type="text" id='total_before_vat' name='total_before_vat' readonly class="form-control form-control-sm" value="0" >
		      </div>
		</div>
		<hr class='bg-primary'></hr>
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">VAT (<?php echo $vat_percent?>%) 
		    <input type='checkbox' id='vatbox' value='1' checked onclick='check_vat_option()' /></label>
		    <div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
		      <input type="text" id='vat_amt' name='vat_amt' class="form-control form-control-sm" readonly="TRUE" value="0" readonly>
		      <input type="hidden" id='vat_percent' name='vat_percent' class="form-control" value="<?php echo $vat_percent;?>" >
	            </div>
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Grand Total <span id='currabrev'></span><span style="color: red;"> * </span></label>
		    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		      <input type="text" id='grand_total' name='grand_total' readonly class="form-control form-control-sm"  value="0" required>
		      </div>
		</div>

		<!-- ================= Scope of Work (matches Direct Quotation page) ================= -->
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">
		        Scope of Work:
		    </label>

		    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
		        <textarea class="form-control"
		                  id="scope_work"
		                  name="scope_work"
		                  rows="6">1. Carrying out systematic inspection of the equipment, lubricating, motor tuning, and adjustment, testing for normal working and general servicing for good working and submitting the service report duly signed by the concerned authority.

2. Electricals, Mechanical & Civil necessity requirements to engineer while attending Preventive Maintenances should be provided by Customer.

3. In case of non-availability of the spare component for replacement quotation shall be provided. After the approval the work will be done and invoice shall be submitted. Payment after invoice submission as per usual process.</textarea>
		    </div>
		</div>

		<!-- ================= Payment Terms (matches Direct Quotation page) ================= -->
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">
		        Payment Terms:
		    </label>

		    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
		        <textarea class="form-control"
		                  id="term1"
		                  name="term1"
		                  rows="6">Quarterly after each PPM CDC payment.

This price will be varied according to the changes in quantity, design size specification etc.

We hope the above meets your requirements and waiting to execute your order with highest priority.

Please do not hesitate to contact the undersigned for any further enquiry.

We assure you our best services all the time.</textarea>
		    </div>
		</div>

		<!-- ================= No. of Visits (matches Direct Quotation page) ================= -->
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">
		        No. of Visits
		    </label>

		    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
		        <textarea class="form-control"
		                  id="ppm_details"
		                  name="ppm_details"
		                  rows="6">1 - 4 Visits (One in every three months.) with unlimited callout.

2 - We will not be responsible for any loss or damage caused by any accidents or due to the natural calamity to the system.

3 - Operator replacement is not included in this contract.

4 - Spare parts replacement will be payment after completion of approved work and submission of invoice.</textarea>
		    </div>
		</div>

		<!-- ================= No. of Visits (matches Direct Quotation page) ================= -->
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">
		        Validity:
		    </label>

		    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
		       	<input type="text" class="form-control form-control-sm" list="validity"  name="validity" value="15 days from quotation date"/>

		    </div>
		</div>
  <div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Contract Period:</label>
			<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
				<input type="text" class="form-control form-control-sm" list="contract_period"  name="contract_period" value="6 months from the date of signing the agreement"/>
			
			</div>
		
		</div>
         <div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Contract value (Dhs):</label>
			<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
				<input type="text" class="form-control form-control-sm" list="contract_value"  name="contract_value" value="6000 only (value in words) + 5% vat"/>
			
			</div>
		
		</div>
          <div class="form-group row">   
    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">
       Terms and Conditions:
    </label>

    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
        <textarea class="form-control"
                  id="termcond"
                  name="termcond"
                  rows="4">This contract shall be valid for a period of six (6) months from the date of signing.
                                  
Al Tareeq Kitchen Equipment shall provide preventive and corrective maintenance services in accordance with the agreed scope of work.

Preventive maintenance shall be carried out on a monthly basis, as mutually agreed.

Breakdown services shall be provided based on the following response times:
•Emergency: within 3-4 hours
•Urgent: within 6-12 hours
• Normal: within 24 hours

All service requests must be communicated through official channels such as phone or email.

Services shall be carried out during normal working hours unless otherwise mutually agreed in writing.

Spare parts are not included in this Annual Maintenance Contract unless specifically stated. Replacement of spare parts shall be carried out only after obtaining approval from the Client.
                
                
                
                
                </textarea>
    </div>    
</div>
          <div class="form-group row">   
    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">
       Exclusions:
    </label>

    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
        <textarea class="form-control"
                  id="exclusions"
                  name="exclusions"
                  rows="6">
                
                
                
                
                </textarea>
    </div>
</div>
		<!-- <hr>
		<div class="form-group row">
		    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-1 col-form-label">Validity:</label>
			<div class="col-xs-12 col-sm-9 col-md-8 col-lg-2">
				<input type="text" class="form-control form-control-sm" list="validity"  name="validity" value="15 days from quotation date"/>
			
			</div>
		</div> -->

		<!--
		<div class="form-group row">
			<label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 col-form-label">Select Company</label>
			<div class="col-xs-12 col-sm-9 col-md-2 col-lg-2">
				<select class="form-select form-control-sm select2" id="cmp_id" name="cmp_id">
					<option value="">Select</option>
					<option selected value="1">Dexion</option>
				</select>
			</div>
		</div>
		-->
<!-- ================= Billing Address ================= -->

<!-- <div class="form-group row">

    <label class="col-md-2 col-form-label">
        Billing Address
    </label>

    <div class="col-md-4">
        <textarea
            name="billing_addr1"
            id="billing_addr1"
            class="form-control form-control-sm"
            rows="3"></textarea>
    </div>

    <label class="col-md-2 col-form-label">
        City
    </label>

    <div class="col-md-4">
        <input
            type="text"
            name="billing_city"
            id="billing_city"
            class="form-control form-control-sm">
    </div>

</div>

<div class="form-group row">

    <label class="col-md-2 col-form-label">
        State
    </label>

    <div class="col-md-4">
        <input
            type="text"
            name="billing_state"
            id="billing_state"
            class="form-control form-control-sm">
    </div>

    <label class="col-md-2 col-form-label">
        Pincode
    </label>

    <div class="col-md-4">
        <input
            type="text"
            name="billing_po"
            id="billing_po"
            class="form-control form-control-sm">
    </div>

</div>

<div class="form-group row">

    <label class="col-md-2 col-form-label">
        Country
    </label>

    <div class="col-md-4">
        <input
            type="text"
            name="billing_country"
            id="billing_country"
            class="form-control form-control-sm">
    </div>

</div> -->
<!-- <div class="form-group row">
    <label class="col-sm-3 col-form-label">
        System SLA for Corrective Maintenance
    </label>
    <div class="col-sm-6">
        <input type="checkbox" id="sla_enabled" name="sla_enabled" value="1" onchange="toggleSlaTable()">
        Enable SLA
    </div>
</div> -->

<div id="sla_section" style="display:none; margin-top:15px;">
    <h6>SLA DETAILS</h6>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Service Item</th>
                <th>Service Availability Period</th>
                <th>Response Time</th>
                <th>Restoration Time</th>
                <th>Resolution Time</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="sla_body"></tbody>
    </table>
    <button type="button" class="btn btn-primary btn-sm" onclick="addSlaRow()">
        + Add SLA
    </button>
</div>

<!-- <div class="form-group row">
    <label class="col-sm-3 col-form-label">Annexure Details</label>
    <div class="col-sm-6">
        <input type="checkbox" id="annexure_enabled" name="annexure_enabled" value="1" onchange="toggleAnnexureTable()">
        Enable Annexure
    </div>
</div> -->

<div id="annexure_section" style="display:none; margin-top:15px;">
    <h6>ANNEXURE DETAILS</h6>

    <div class="form-group row">
        <label class="col-lg-2 col-form-label">Annexure Main Heading</label>
        <div class="col-lg-4">
            <input type="text" name="annexure_title" class="form-control" value="ANNEXURE - 1">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-3 col-form-label">Annexure Subtitle</label>
        <div class="col-sm-6">
            <input type="text" id="section_title" name="section_title" class="form-control" placeholder="Eg: Sliding Doors">
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="text" name="heading_slno" class="form-control" value="Sl No"></th>
                <th><input type="text" name="heading_type" class="form-control" value="Type"></th>
                <th><input type="text" name="heading_location" class="form-control" value="Location"></th>
                <th><input type="text" name="heading_quantity" class="form-control" value="Quantity"></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="annexure_body"></tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total Quantity</th>
                <th><input type="text" id="annex_total_qty" class="form-control" readonly></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
		<h6>Contact Person Details</h6>
		<br/>
		<div class="form-group row">
		    <label class="col-md-1 control-label">Name</label>
		    <div class="col-md-3">
		        <input id="cp_name" name="cp_name"
		               type="text"
		               class="form-control form-control-sm">
		    </div>

		    <label class="col-md-1 control-label">Mobile</label>
		    <div class="col-md-3">
		        <input id="cp_mobile" name="cp_mobile"
		               type="text"
		               class="form-control form-control-sm">
		    </div>

		    <label class="col-md-1 control-label">Email</label>
		    <div class="col-md-3">
		        <input id="cp_email" name="cp_email"
		               type="email"
		               class="form-control form-control-sm">
		    </div>
		</div>
		<div class="form-group row">

			<label class="col-md-1 control-label">Prepared By:</label>
		    <div class="col-md-3">
				<select class="form-control select2" 
		                id="employee_prepared" name="employee_prepared" required>
		                <option value="">Select</option>
		                <?php foreach ($employees as $s) { ?>
		                <option value="<?php echo $s->employee_id  ?>"><?php echo $s->user_code . ' ' . $s->employee_name; ?></option>
		                <?php } ?>
		              </select>
			</div>
        </div>
		
		<div class="col-sm-10">
		<button type="submit"  tabindex="22"  id="add" class="btn btn-primary m-b-0">Create Quotation</button>
		</div>
		</div>
		</form>

        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function(){
	$('.select2').select2({
        width: '100%' // Force Select2 to respect its parent container width
    });
	var i=1;
	$(document).on('click', '#add_row', function() {
        
    });
        $("#delete_row").click(function(){
    		 if(i>1){
			 $("#addr"+(i-1)).html('');
			 i--;
		 }
	 });

	 var i=1;
	$("#add_rowa").click(function()
	{
	     $('#addra'+i).html("<td><input class='form-control' type='text' name='scope_work[]'></td>");
	    $('#mytbody tr:last').after('<tr id="addr'+(i+1)+'"></tr>');
	      i++; 	     	
	});
        $("#remove_rowa").click(function(){
    		 if(i>1){
			 $("#addra"+(i-1)).html('');
			 i--;
		 }
	 });
	 
	
   });   
   function remove_row(append_id)
   {    	 
        $('#addr'+append_id).attr("id","addr"+append_id+"x");
        $('#addr'+append_id+"x").remove();
        calculate_grand_total();
   }
   function remove_product_div(append_id)
   {    	 
        $('#product_div'+append_id).remove();
        calculate_grand_total();
   }
   function remove_subrow(div_id,append_id)
   {    	
   	var x= div_id+'_ptr'+append_id;
        $('#'+x).remove();
        calculate_grand_total();
   }
  function add_nxt_row(div_id, append_id)
  {
  	const myArray = div_id.split("d");
  	var one= myArray[0];
  	var two= myArray[1];
	var pcode= parseFloat($('#row_id_'+div_id).val());
  	var k = parseFloat(pcode);
  	var m = parseFloat(k+1);
  	var tmp =div_id+'_ptr'+k;
  	var tmp2 ='mybody_'+div_id;
  	var tmp3 =div_id+'_ptr'+m;
  
  	 $('#'+tmp).html("<td><textarea name='sub_details"+two+"[]' id='sub_details"+div_id+k+"' class='form-control form-control-sm' ></textarea><input type='hidden' name='qty"+two+"[]' id='qty"+div_id+k+"' tabindex='10' class='form-control form-control-sm' value='1'></td><td  align='center'><a title='Delete' onclick=remove_subrow('"+div_id+"','"+k+"') class='btn btn-xs bg-orange remove1'><span class='fa fa-trash'></span></a></td>");
	  $('#'+tmp).after("<tr id='"+tmp3+"'></tr>");
	  $('#row_id_'+div_id).val(m);
  }
function get_enquiry_info() 
 {
   	var enq_id = document.getElementById("enq_id").value;		
   	if(enq_id!='')
   	{
	   	$.ajax({
	   	async:false,
		type: "POST",
		url:"<?php echo base_url()?>index.php/Ajax/ajax_get_amc_enquiry_info",
		data: {enq_id:enq_id} ,
		dataType: "json",
		success: function(msg){

			var url1= 'index.php/AMC/edit_enquiry/'+msg.enq_id+'/1';
			var x = '<u><a target="blank" href="<?php echo base_url()?>' + url1 + '">'+msg.enquiry_code+'</a></u>';
			document.getElementById("enq_code").innerHTML		=x;
			document.getElementById("enquiry_code").value		=msg.enquiry_code;		
			document.getElementById("enq_date").value			=msg.enquiry_date;
			document.getElementById("project_name").value		=msg.project_name;
			document.getElementById("customer_id").value		=msg.customer_id;		
			document.getElementById("cust_name").innerHTML		=msg.cust_code+' '+msg.cust_name;
			document.getElementById("enquiry_revision").value	=msg.revision;		
			document.getElementById("enq_type").value			=msg.enq_type;
			// document.getElementById("amc_start_date").value		=msg.amc_start_date;
			// document.getElementById("amc_end_date").value		=msg.amc_end_date;
			// document.getElementById("amc_start_datea").value		=msg.amc_start_date;
			// document.getElementById("amc_end_datea").value		=msg.amc_end_date;
			get_enquiry_items_list();
		     }
		});
	}
	else
	{
		document.getElementById("enq_code").innerHTML='';
		document.getElementById("enq_date").value='';
		document.getElementById("customer_id").value='';
		document.getElementById("cust_name").value='';
		document.getElementById("delivery_date").value='';
			
		document.getElementById('item_list_id').innerHTML='';
	}
 } 
 
function get_enquiry_items_list()
{
	var enq_id=$("#enq_id").val();
	var customer_id=$("#customer_id").val();
	$.ajax({
        type: "POST",
        url:"<?php echo base_url()?>index.php/Ajax/get_amc_enquiry_items_for_quote",
        data: {enq_id:enq_id} , 
		//data: {enq_id: enq_id,rev_version: $("#enquiry_revision").val() }
        success: function(msg){	      	
		document.getElementById('item_list_id').innerHTML=msg;
		$('.select2').select2();
        buildEnquiryDynamicColumns();
		calculate_grand_total();
	     }
	});
	
}
function getOrdinal(n)
{
    let s = ["th","st","nd","rd"];
    let v = n % 100;
    return s[(v-20)%10] || s[v] || s[0];
}

function getEnquiryPeriodCount()
{
    let type = $('#contract_type').val();
    let count = 0;

    if (type === 'Yearly')
        count = parseInt($('#no_of_years').val()) || 0;
    else if (type === 'Quarterly')
        count = parseInt($('#no_of_quarters').val()) || 0;

    return { type: type, count: count };
}

function buildEnquiryDynamicColumns()
{
    let info  = getEnquiryPeriodCount();
    let count = info.count;
    let label = (info.type === 'Yearly') ? 'Year' : (info.type === 'Quarterly' ? 'Quarter' : '');

    // remove previously injected period columns before rebuilding
    $('#item_list_id th.dynamic-period-col').remove();
    $('#item_list_id td.dynamic-period-col').remove();

    if (count <= 0 || label === '') {
        recalc_all_rows();
        return;
    }

    // header columns
    for (let p = 1; p <= count; p++) {
        $('#item_list_id th.total-col-header')
            .before('<th class="dynamic-period-col" width="15%">Total Price ' + p + getOrdinal(p) + ' ' + label + '</th>');
    }

    // body columns, one set per existing item row
    $('#item_list_id tr[id^="addr"]').each(function () {
        var rowId = $(this).attr('id').replace('addr', '');
        if (rowId === '' || rowId === '1') return; // skip the empty placeholder row

        var $totalCell = $(this).find('td.total-col-cell');
        if ($totalCell.length === 0) return;

        for (let p = 1; p <= count; p++) {
            $totalCell.before(
                '<td class="dynamic-period-col">' +
                '<input type="text" id="period_' + p + '_' + rowId + '" class="form-control" readonly>' +
                '</td>'
            );
        }
    });

    recalc_all_rows();
}


// function calculate_total(append_id)
// {
//     var price    = parseFloat(document.getElementById("price"+append_id).value) || 0;
//     var quantity = parseFloat(document.getElementById("qty"+append_id).value) || 0;

//     var type = document.getElementById("contract_type") ? document.getElementById("contract_type").value : '';
//     var count = 0;

//     if (type === 'Yearly') {
//         count = parseInt(document.getElementById("no_of_years").value) || 0;
//     } else if (type === 'Quarterly') {
//         count = parseInt(document.getElementById("no_of_quarters").value) || 0;
//     }

//     var periods = count > 0 ? count : 1;

//     var total = price * quantity * periods;

//     document.getElementById("total"+append_id).value = parseFloat(total).toFixed(2);
//     calculate_grand_total();
// }
function calculate_total(append_id)
{
    var price    = parseFloat(document.getElementById("price"+append_id).value) || 0;
    var quantity = parseFloat(document.getElementById("qty"+append_id).value) || 0;

    var type = document.getElementById("contract_type") ? document.getElementById("contract_type").value : '';
    var count = 0;

    if (type === 'Yearly') {
        count = parseInt(document.getElementById("no_of_years").value) || 0;
    } else if (type === 'Quarterly') {
        count = parseInt(document.getElementById("no_of_quarters").value) || 0;
    }

    var perPeriodAmount = price * quantity;
    var total = 0;

    if (count > 0) {
        for (var p = 1; p <= count; p++) {
            var periodField = document.getElementById("period_" + p + "_" + append_id);
            if (periodField) {
                periodField.value = perPeriodAmount.toFixed(2);
            }
            total += perPeriodAmount;
        }
    } else {
        total = perPeriodAmount;
    }

    document.getElementById("total"+append_id).value = parseFloat(total).toFixed(2);
    calculate_grand_total();
}
function recalc_all_rows()
{
    $('input[id^="price"]').each(function(){
        var append_id = this.id.replace('price', '');
        calculate_total(append_id);
    });
}

$(document).on('change keyup', '#contract_type, #no_of_years, #no_of_quarters', function(){
    buildEnquiryDynamicColumns();
});

function calc_discount_from_percent()
{
	var i_total = parseFloat(document.getElementById("sub_total").value) || 0;
	var discount_percent = parseFloat(document.getElementById("discount").value) || 0;

	if(discount_percent > 0)
	{
		var discount_val = i_total * (discount_percent/100);
		document.getElementById("discount_amt").value = parseFloat(discount_val).toFixed(2);
	}
	else
	{
		document.getElementById("discount_amt").value = 0;
	}

	calculate_grand_total();
}
function calculate_grand_total()
{
	var i_value=0;i_total=0;
	$('.subItemAmt').each(function()
	{
		i_value=$(this).val();
		if(i_value=='')
			 i_value = 0;
		else
			i_total+=parseFloat(i_value);
	});
	if(isNaN(i_total)) var s_total = 0;

	document.getElementById("sub_total").value= parseFloat(i_total).toFixed(2);
	// if (document.getElementById("amc_discount").value>0){
	// 	var amc_discount = parseFloat(document.getElementById("amc_discount").value).toFixed(2)
	// }
	// else{
	// 	var amc_discount =0;
	// }
		
	// if(document.getElementById("discount").value==0)
	//  	var discount=0;
	//  else
	//  {
	//  	var discount_per = parseFloat(document.getElementById("discount").value/100);
	//  	var discount= i_total*discount_per;
	//  	document.getElementById("discount_amt").value= parseFloat(discount).toFixed(2);
	//  }
	//  var discount= document.getElementById("discount_amt").value;
	//  var total_before_vat = i_total-amc_discount-discount;

     	var amc_discount = parseFloat(document.getElementById("amc_discount").value) || 0;
	var discount = parseFloat(document.getElementById("discount_amt").value) || 0;

	var total_before_vat = i_total-amc_discount-discount;
	
	document.getElementById("total_before_vat").value= parseFloat(total_before_vat).toFixed(2);


	var vat_percent= document.getElementById("vat_percent").value;
	var vat_per= parseFloat(vat_percent/100);
   	var calVatAmt = parseFloat(total_before_vat*vat_per);
	document.getElementById("vat_amt").value= parseFloat(calVatAmt).toFixed(2);
   	var grand_total = parseFloat(calVatAmt+total_before_vat);
	
	var crate=1;
	var grand_total = parseFloat(grand_total*crate);
	document.getElementById("grand_total").value= parseFloat(grand_total).toFixed(2);
}

function check_vat_option()
{
	var checkBox = document.getElementById("vatbox");
	var vat_percent="<?php echo $vat_percent?>";
	if (checkBox.checked == true){
		$("#vat_percent").val(vat_percent);		
		calculate_grand_total();
	 	
	} else {
	 
		$("#vat_percent").val(0);
	 	document.getElementById("vat_amt").value=0.00;
		calculate_grand_total();
	}
}
function get_currency_conversion()
{
	var str=$('#currency_id').val();
	var myarray = str.split("@");
	var cid=myarray[0];
	var crate=myarray[1];
	var currabrev=myarray[2];
	document.getElementById('cid').value=cid;
	document.getElementById('crate').value=crate;
	document.getElementById('currabrev').innerHTML=currabrev;
	calculate_grand_total();
}

 
function copy_billing_address()
{
	var checkBox = document.getElementById("copy_address");
	// If the checkbox is checked, display the output text
	if (checkBox.checked == true){
		var billing_addr1 = document.getElementById("billing_addr1").value;
		var billing_city = document.getElementById("billing_city").value;
		var billing_state = document.getElementById("billing_state").value;
		var billing_po = document.getElementById("billing_po").value;
		var billing_country = document.getElementById("billing_country").value;
		
	 	document.getElementById("shipping_addr1").value=billing_addr1;
	 	document.getElementById("shipping_city").value=billing_city;
	 	document.getElementById("shipping_state").value=billing_state;
	 	document.getElementById("shipping_po").value=billing_po;
	 	document.getElementById("shipping_country").value=billing_country;
	 	
	} else {
	 
	 	document.getElementById("shipping_addr1").value='';
	 	document.getElementById("shipping_city").value='';
	 	document.getElementById("shipping_state").value='';
	 	document.getElementById("shipping_po").value='';
	 	document.getElementById("shipping_country").value='';
	}
}

function get_trading_product_info(append_id)
{
	var product_id= document.getElementById("product_id"+append_id).value;
	if(product_id!='')
	{
	$.ajax
	({
		url: "<?php echo site_url('Product/ajax_get_product_details'); ?>",
		type: 'POST',
		data: {product_id: product_id },
		dataType: "json",
		success: function(msg) {
				document.getElementById("desc"+append_id).value=msg.item_desc;
		}
	});
	}
	else
	{
		document.getElementById("desc"+append_id).value='';
	}
}
function toggleContractCount()
{
    let type = $('#contract_type').val();

    if(type === 'Yearly')
    {
        $('#year_block').show();
        $('#quarter_block').hide();

        $('#no_of_years').prop('required', true);
        $('#no_of_quarters').prop('required', false).val('');
    }
    else if(type === 'Quarterly')
    {
        $('#quarter_block').show();
        $('#year_block').hide();

        $('#no_of_quarters').prop('required', true);
        $('#no_of_years').prop('required', false).val('');
    }
    else
    {
        $('#year_block, #quarter_block').hide();

        $('#no_of_years').prop('required', false).val('');
        $('#no_of_quarters').prop('required', false).val('');
    }
}
let sla_i = 0;

function toggleSlaTable()
{
    if($('#sla_enabled').is(':checked')){
        $('#sla_section').show();

        if($('#sla_body').children().length === 0){
            let defaults = [
                { item: "Critical / Emergency", avail: "24/7 call-out services", response: "1-2 hrs", restore: "3-6 hrs", resolve: "2-3 Days" },
                { item: "Major / High", avail: "24/7 call-out services", response: "4-8 hrs", restore: "1-2 Days", resolve: "5 Days" },
                { item: "Minor / Medium", avail: "24/7 call-out services", response: "1 Day", restore: "3 Working Days", resolve: "1 Week" }
            ];
            defaults.forEach(function(d){ addSlaRow(d); });
        }
    } else {
        $('#sla_section').hide();
    }
}

function addSlaRow(d = null)
{
    $('#sla_body').append(`
        <tr id="sla_${sla_i}">
            <td><input type="text" name="service_item[]" value="${d?.item || ''}" class="form-control"></td>
            <td><input type="text" name="service_availability_period[]" value="${d?.avail || ''}" class="form-control"></td>
            <td><input type="text" name="response_time[]" value="${d?.response || ''}" class="form-control"></td>
            <td><input type="text" name="restoration_time[]" value="${d?.restore || ''}" class="form-control"></td>
            <td><input type="text" name="resolution_time[]" value="${d?.resolve || ''}" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="$('#sla_${sla_i}').remove()">X</button></td>
        </tr>
    `);
    sla_i++;
}
let annex_i = 0;

function toggleAnnexureTable()
{
    if($('#annexure_enabled').is(':checked')){
        $('#annexure_section').show();
        if($('#annexure_body').children().length === 0){
            addAnnexureRow();
        }
    } else {
        $('#annexure_section').hide();
        $('#annexure_body').html('');
    }
}

function addAnnexureRow()
{
    let sl = $('#annexure_body tr').length + 1;

    $('#annexure_body').append(`
        <tr id="annex_${annex_i}">
            <td><input type="text" name="sl_no[]" value="${sl}" class="form-control" readonly></td>
            <td><input type="text" name="type[]" class="form-control"></td>
            <td><input type="text" name="location[]" class="form-control"></td>
            <td><input type="number" name="annex_qty[]" class="form-control annex_qty" onkeyup="calculateAnnexTotal()"></td>
            <td>
                <button type="button" class="btn btn-primary btn-sm" onclick="addAnnexureRow()">+</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeAnnexRow(${annex_i})">X</button>
            </td>
        </tr>
    `);

    annex_i++;
    calculateAnnexTotal();
}

function calculateAnnexTotal()
{
    let total = 0;
    $('.annex_qty').each(function(){
        let val = parseFloat($(this).val());
        if(!isNaN(val)) total += val;
    });
    $('#annex_total_qty').val(total);
}

function removeAnnexRow(id)
{
    $('#annex_' + id).remove();
    calculateAnnexTotal();
}

$(document).ready(function () {
    toggleContractCount();
});


</script>