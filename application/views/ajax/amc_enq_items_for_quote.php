<?php $this->load->helper('stock_helper.php');

foreach($records as $res1)
{ ?>
 
	<table id="tab_logic">
		<thead>
<tr id="quotation_header_enq">

    <th width='20%'>Description</th>    
	<th width='20%'>Brand</th>     
    <th width='10%'>Qty<span class="text-danger">*</span></th>  
	<th width='20%'>Rate <span class="text-danger">*</span></th>  
    <th width='20%' class="total-col-header">Total</th>   
   
</tr>
</thead>
 		<?php $i=5000; foreach($records2 as $r) { ?>
		<tr id="addr<?php echo $i;?>" style=" font-weight:bold;height" overflow="scroll">
			
			<td width='20%'>
			
				<input type="hidden" name ="product_id[]" id = "product_id<?php echo $i;?>" class="form-control" value ="<?php echo $r->product_id; ?>"/>
				<input type="text" name="product_name[]" id="product_name<?php echo $i; ?>" class="form-control" value="<?php echo htmlspecialchars($r->product_name, ENT_QUOTES, 'UTF-8'); ?>" readonly>
			</td>
			<td width='20%'>
				
				<input type="text" name ="brand[]" id = "brand<?php echo $i;?>" class="form-control" value ="<?php echo $r->brand; ?>"/>
			</td>
			
			<!-- <td width='10%'>	
			   <input type="text" name ="capacity[]" id = "capacity<?php echo $i;?>" class="form-control" value ="<?php echo $r->capacity; ?>"/>
			</td> -->
			<td width='10%'>	
				<input type="text" name="qty[]" id="qty<?php echo $i;?>"  class="form-control" value="<?php echo $r->quantity;?>" onkeyup="calculate_total('<?php echo $i;?>')" required>
			</td>
			<td width='20%'>		
				<input type="number" step='0.01' name="price[]" id="price<?php echo $i;?>" class="form-control"  onkeyup="calculate_total('<?php echo $i;?>')"  tabindex='9' required>
			</td>
			
			<td width='20%' class="total-col-cell">
    <input type="number" name="total[]" id="total<?php echo $i;?>"  class="form-control subItemAmt" readonly required>
	
	<input type="hidden"  name="trans_id[]" value="<?php echo $r->trans_id;?>" >
	<input type="hidden"  name="append_id[]" value="<?php echo $i;?>" >
</td>
			<td>
				<a id='delete_row' title="Delete" onclick='remove_row("<?php echo $i;?>")' class="btn btn-xs bg-orange remove1"><span class="fa fa-trash"></span></a>
			</td>
		</tr>	
		<?php $i++; } ?>
	   	<tbody id="mytbbody"> 
			<tr id='addr1'></tr>
	        </tbody>	
		</table>
</div>
<?php 
	$i++; } ?>


