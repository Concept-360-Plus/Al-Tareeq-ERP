<?php date_default_timezone_set('Asia/Kolkata');
		//use Dompdf\Dompdf;
		//require_once FCPATH . 'vendor/autoload.php';

	use Dompdf\Dompdf;
use Dompdf\Options;
    class AMC extends CI_Controller {
        
        function __construct() {
             parent::__construct();
             $this->is_logged_in();
			 $this->load->model('Amc_model');
			 $this->load->model('Product_model');
			 $this->load->model('Users_model');
			 $this->load->model('Setup_model');
			 $this->load->model('Company_model');
			// $this->load->model('Sales_Model');
			 $this->load->model('Amc_model');
        }

        function is_logged_in() {
            $is_logged_in = $this->session->userdata('is_logged_in');
            if(!isset($is_logged_in) || $is_logged_in != true)
            {
                echo 'You don\'t have permission to access this page. <a href="../">Login</a>';
                die();
                $this->load->view('login/login_form');
            }
        }
        
        /////////////////////// New user  /////////////////////////////////////
	function add_enquiry()
	{
		$data['title']='Add New Enquiry(AMC)';
		$prifix='AL/ENQ/';
		$num = $this->Setup_model->get_next_code($prifix,'amc_enq_code','amc_enquiry_master',9)+1;
		$digit=sprintf("%1$04d",$num);
		$code =$prifix.$digit;
		$data['code'] =$code;

		$this->load->model('Product_model');

		$data['customer_list']  = $this->Setup_model->get_all_customer_list();
		$data['branch_list']    = $this->Setup_model->get_all_branches();
		$data['active_users']   = $this->Setup_model->get_active_user_list();

		$data['all_products']   = $this->Setup_model->get_all_item_list();
		$data['active_items']       = $this->Setup_model->get_active_item_list();	
		$data['active_units']       = $this->Setup_model->get_active_unit_list();
		$data['main_content']='amc/enquiry_add.php';

		$this->load->view('includes/template.php',$data);
	}	

	public function add_new_enquiry()
{
    $data['title'] = 'Add New Enquiry';

    $insert_id = $this->Amc_model->add_new_amc_enquiry();

    if ($insert_id !== false && !empty($insert_id)) {

        $this->session->set_flashdata(
            'success',
            'AMC Enquiry Saved Successfully.'
        );

        redirect('AMC/view_enquiry_list');

    } else {

        /*
         * If insertion fails, return to enquiry page.
         * The model will already set the error message.
         */
        redirect('AMC/add_enquiry');
    }
}

	public function view_enquiry_list()
{
    $data['title'] = 'AMC Enquiry List';

    $data['records'] =  $this->Amc_model->get_enquiry_list();

    $data['main_content'] = 'amc/enquiry_list.php';

    $this->load->view('includes/template.php', $data);
}
	function edit_enquiry()
	{
		$data['title']='Enquiry Edit';
		$id = $this->uri->segment('3');
		$data['edit_flag'] = $this->uri->segment('4');
		$version = $this->uri->segment('5');
		$data['records']=$this->Amc_model->get_enquiry_record_by_id($id);
		$data['trans_records']=$this->Amc_model->get_enquiry_trans_by_id($id);
		$data['supplier_records']=$this->Users_model->get_supplier_list();
		$data['brand_list']=$this->Product_model->get_brand_list();
		$data['user_records']=$this->Users_model->get_user_list();		
		//$data['cust_records'] = $this->Users_model->get_active_customer_list();
		$data['cust_records']  = $this->Setup_model->get_all_customer_list();
		
			$data['active_items']       = $this->Setup_model->get_active_item_list();	
		$data['main_content']='amc/enquiry_edit.php';
		//echo '<pre>';print_R($data);exit;
		$this->load->view('includes/template.php',$data);
	}

	public function update_enquiry_data()
{
    $id = $this->input->post('amc_enq_id');

    $res = $this->Amc_model->update_enquiry_data($id);

    if ($res) {
        $this->session->set_flashdata('success', 'Data Updated Successfully..');
    } else {
        $this->session->set_flashdata('error', 'Update Failed.');
    }

    redirect('AMC/view_enquiry_list');
}
	function delete_enquiry()
	{
		$enquiry_id=$this->input->post('enquiry_id');
		$res = $this->Amc_model->delete_enquiry($enquiry_id);
		echo $res;
	}
	/////////////////////// New quotation /////////////////////////////////////
	function add_quotation()
	{
		$data['title']='Add New AMC ';

		
		$data['enq_records']=$this->Amc_model->get_amc_enquiry_list_for_qtn();
		// $data['products']=$this->Product_model->get_product_list();
		$prifix='ADL/AQT/';
		$num = $this->Setup_model->get_next_code($prifix,'quotation_code','amc_quotation_master',9)+1;
		$digit=sprintf("%1$04d",$num);
		$code =$prifix.$digit;
		$data['code'] =$code;
		$data['vat_percent']=$this->Setup_model->get_vat_for_calculation();
		// $data['currency_list']=$this->Setup_model->get_currency_list();
	    // $data['bank_details']=$this->Setup_model->get_company_bank_list();	
		// $data['terms_rec']=$this->Setup_model->get_terms_all_details();
		$data['user_records']=$this->Users_model->get_user_list();
		// $data['scope_records']=$this->Amc_model->get_scope_of_work();
		// $data['service_scheme_records'] = $this->Amc_model->get_service_schemes();
		$this->load->model('Sales_model');
		// $data['qtn_records']=$this->Sales_model->get_all_quotation_list();
		// $data['products']=$this->Product_model->get_product_list();		
		$this->load->model('Hr_model');
            $data['employees'] = $this->Hr_model->get_employee_list();
		$data['main_content']='amc/quotation_add.php';
		// echo '<pre>';print_r($data);exit;		
		$this->load->view('includes/template.php',$data);
	}
	function add_quotation_data()
	{
		$this->load->model('Sales_model');
		$insert_id = $this->Amc_model->add_quotation_data();

		if($insert_id!=''){
			$this->session->set_flashdata('success', 'Data Saved Successfully..');
			redirect('AMC/view_quotation_list');
		}
	}
	function view_quotation_list()
	{
		$data['title']='AMC Quotation List';
		$this->load->model('Sales_model');
		$data['records']=$this->Amc_model->get_quotation_list();

		 $data['main_content']='amc/quotation_list.php';
        	//$data['main_content']='amc/quotation_list_direct.php';
		$this->load->view('includes/template.php',$data);
	}
// 	function print_quotation()
// {
//     $data['title'] = 'Quotation Print';

//     $id = $this->uri->segment('3');  
//     $data['rev_version'] = $this->uri->segment('4');  
//     $enq_type = $this->uri->segment('5');    
//     $data['disc'] = $this->uri->segment('6'); 
//     $data['l_head'] = $this->uri->segment('7'); 

//     $this->load->model('Setup_model');

//     $data['vat_percent'] = $this->Setup_model->get_vat_for_calculation();

//     $data['records1'] = $this->Amc_model->get_quotation_master_by_id($id);

//     if (empty($data['records1'])) {
//         show_error("Quotation not found");
//     }

//     // ✔ take first record correctly
//     $master = $data['records1'][0];
// 		$data['quotation_info'] = $this->Amc_model->get_amc_quotation_info($master->quote_id);


//     $data['comapny_records'] = $this->Setup_model->get_company_details();
//     $data['records2'] = $this->Amc_model->get_quotation_tr_by_id($id, $data['rev_version']);
//     $data['records3'] = $this->Amc_model->get_work_scope_by_id($master->scope_work);

// 	$data['sla_records'] = $this->Amc_model->get_quotation_sla_by_id($id);
// $data['annexure_records'] = $this->Amc_model->get_quotation_annexure_by_id($id);
//     // ✔ correct branch id usage
// //     $branch_id = $master->branch_id;
// // 		$data['branch_id'] = $branch_id;

// //     $branch_details = $this->Company_model->get_branch_by_id($branch_id);

// // 	// Branch details for cover page
// // $data['branch_name']     = $branch_details->branch_name ?? '';
// // $data['branch_address']  = $branch_details->branch_address ?? '';
// // $data['branch_location'] = $branch_details->branch_location ?? '';
// // $data['branch_contact']  = $branch_details->branch_contact ?? '';
// // $data['branch_email']    = $branch_details->branch_email ?? '';
// // $data['cover_page']     = $branch_details->cover_page ?? '';
// //  $data['branch_stamp']  = $branch_details->branch_stamp ?? '';

// $branch_id = !empty($master->branch_id)
//     ? $master->branch_id
//     : 0;

// /*
//  * Quotation branch_id is empty.
//  * Get the branch from the related AMC enquiry.
//  */
// if (empty($branch_id) && !empty($master->enq_master_id)) {

//     $enquiry = $this->db
//         ->where('amc_enq_id', $master->enq_master_id)
//         ->get('amc_enquiry_master')
//         ->row();

//     if (!empty($enquiry) && !empty($enquiry->branch_id)) {
//         $branch_id = $enquiry->branch_id;
//     }
// }

// $data['branch_id'] = $branch_id;

// $branch_details = null;

// if (!empty($branch_id)) {
//     $branch_details = $this->Company_model->get_branch_by_id($branch_id);
// }

// $data['branch_name']     = '';
// $data['branch_address']  = '';
// $data['branch_location'] = '';
// $data['branch_contact']  = '';
// $data['branch_email']    = '';
// $data['cover_page']      = '';
// $data['branch_stamp']    = '';
// $data['headerPath']      = '';
// $data['footerPath']      = '';

// if (!empty($branch_details)) {

//     $data['branch_name'] =
//         !empty($branch_details->branch_name)
//         ? $branch_details->branch_name
//         : '';

//     $data['branch_address'] =
//         !empty($branch_details->branch_address)
//         ? $branch_details->branch_address
//         : '';

//     $data['branch_location'] =
//         !empty($branch_details->branch_location)
//         ? $branch_details->branch_location
//         : '';

//     $data['branch_contact'] =
//         !empty($branch_details->branch_contact)
//         ? $branch_details->branch_contact
//         : '';

//     $data['branch_email'] =
//         !empty($branch_details->branch_email)
//         ? $branch_details->branch_email
//         : '';

//     $data['cover_page'] =
//         !empty($branch_details->cover_page)
//         ? $branch_details->cover_page
//         : '';

//     $data['branch_stamp'] =
//         !empty($branch_details->branch_stamp)
//         ? $branch_details->branch_stamp
//         : '';

//     $header = ltrim(
//         str_replace('./', '', $branch_details->branch_header ?? ''),
//         '/'
//     );

//     $footer = ltrim(
//         str_replace('./', '', $branch_details->branch_footer ?? ''),
//         '/'
//     );

//     if (!empty($header)) {
//         $data['headerPath'] = base_url($header);
//     }

//     if (!empty($footer)) {
//         $data['footerPath'] = base_url($footer);
//     }
// }

// //  $prepared_by_id = $master->prepared_by;
// //  $prepared_by_name = '';
// //   $prepared_signature = '';
// //  if (!empty($prepared_by_id)) {
// //         $prepared_emp = $this->Company_model->get_employee_by_id($prepared_by_id);
// //         $prepared_by_name = $prepared_emp->employee_name ?? '';
// //         $prepared_signature = $prepared_emp->signature_file ?? '';
// // 		$prepared_by_contact = $prepared_emp->mobile ?? '';

// //     }
// $prepared_by_name = '';
// $prepared_signature = '';
// $prepared_by_contact = '';

// /*
//  * created_by refers to users.user_id.
//  * Do not pass it directly to employee_master because
//  * employee_master does not contain employee_id = 1.
//  */
// if (!empty($master->created_by)) {

//     $user = $this->db
//         ->where('user_id', $master->created_by)
//         ->get('users')
//         ->row();

//     if (!empty($user)) {

//         $prepared_by_name = !empty($user->user_name)
//             ? $user->user_name
//             : '';

//         /*
//          * If this user is linked to an employee and that employee
//          * actually exists, then get employee details.
//          */
//         if (!empty($user->employee_id)) {

//             $prepared_emp = $this->Company_model
//                 ->get_employee_by_id($user->employee_id);

//             if (!empty($prepared_emp)) {

//                 $prepared_by_name = !empty($prepared_emp->employee_name)
//                     ? $prepared_emp->employee_name
//                     : $prepared_by_name;

//                 $prepared_signature = !empty($prepared_emp->signature_file)
//                     ? $prepared_emp->signature_file
//                     : '';

//                 $prepared_by_contact = !empty($prepared_emp->mobile)
//                     ? $prepared_emp->mobile
//                     : '';
//             }
//         }
//     }
// }

// $data['prepared_by_name'] = $prepared_by_name;
// $data['prepared_signature'] = $prepared_signature;
// $data['prepared_by_contact'] = $prepared_by_contact;

// 	$header = ltrim(str_replace('./', '', $branch_details->branch_header), '/');
// $footer = ltrim(str_replace('./', '', $branch_details->branch_footer), '/');

// $data['headerPath'] = base_url($header);
// $data['footerPath'] = base_url($footer);
// $data['prepared_by_name'] = $prepared_by_name;
// $data['prepared_signature'] = $prepared_signature;
// $data['prepared_by_contact'] = $prepared_by_contact ?? '';

// //    $data['headerPath'] = base_url() . ltrim($branch_details->branch_header, '/');
// // $data['footerPath'] = base_url() . ltrim($branch_details->branch_footer, '/');
// 	// DOMPDF
//     $options = new Options();
//     $options->set('isHtml5ParserEnabled', true);
//     $options->set('isRemoteEnabled', true);
	

//     $dompdf = new Dompdf($options);

//     $html = $this->load->view('amc/print/amc_quotation_print', $data, true);

//     $dompdf->loadHtml($html);
//     $dompdf->setPaper('A4', 'portrait');
//     $dompdf->render();

//     $dompdf->stream("amc_$id.pdf", ["Attachment" => 0]);

//     // $this->load->view('amc/print/amc_quotation_print.php', $data);
// }

	function print_quotation()
{
    $data['title'] = 'Quotation Print';

    $id = $this->uri->segment('3');  
    $data['rev_version'] = $this->uri->segment('4');  
    $enq_type = $this->uri->segment('5');    
    $data['disc'] = $this->uri->segment('6'); 
    $data['l_head'] = $this->uri->segment('7'); 

    $this->load->model('Setup_model');

    $data['vat_percent'] = $this->Setup_model->get_vat_for_calculation();

    $data['records1'] = $this->Amc_model->get_quotation_master_by_id($id);

    if (empty($data['records1'])) {
        show_error("Quotation not found");
    }

    // ✔ take first record correctly
    $master = $data['records1'][0];
		$data['quotation_info'] = $this->Amc_model->get_amc_quotation_info($master->quote_id);


    $data['comapny_records'] = $this->Setup_model->get_company_details();
    $data['records2'] = $this->Amc_model->get_quotation_tr_by_id($id, $data['rev_version']);
    $data['records3'] = $this->Amc_model->get_work_scope_by_id($master->scope_work);

	$data['sla_records'] = $this->Amc_model->get_quotation_sla_by_id($id);
$data['annexure_records'] = $this->Amc_model->get_quotation_annexure_by_id($id);
    // ✔ correct branch id usage	
// Get enquiry details
$enquiry = $this->Amc_model->get_enquiry_by_id($master->enq_master_id);

if (empty($enquiry)) {
    show_error("Enquiry not found for this quotation.");
}



// Get branch_id based on quotation type
if (!empty($master->enq_master_id)) {

    // Enquiry-based quotation
    $branch_id = $enquiry->branch_id;

} else {

    // Direct quotation
    $branch_id = $master->branch_id;

}
$data['branch_id'] = $branch_id;	

    $branch_details = $this->Company_model->get_branch_by_id($branch_id);

	// Branch details for cover page
$data['branch_name']     = $branch_details->branch_name ?? '';
$data['branch_address']  = $branch_details->branch_address ?? '';
$data['branch_location'] = $branch_details->branch_location ?? '';
$data['branch_contact']  = $branch_details->branch_contact ?? '';
$data['branch_email']    = $branch_details->branch_email ?? '';
$data['cover_page']     = $branch_details->cover_page ?? '';
 $data['branch_stamp']  = $branch_details->branch_stamp ?? '';

//  $prepared_by_id = $master->prepared_by;
$prepared_by_id = $master->created_by;
 $prepared_by_name = '';
  $prepared_signature = '';
 if (!empty($prepared_by_id)) {
        $prepared_emp = $this->Company_model->get_employee_by_id($prepared_by_id);
        $prepared_by_name = $prepared_emp->employee_name ?? '';
        $prepared_signature = $prepared_emp->signature_file ?? '';
		$prepared_by_contact = $prepared_emp->mobile ?? '';

    }

	$header = ltrim(str_replace('./', '', $branch_details->branch_header), '/');
$footer = ltrim(str_replace('./', '', $branch_details->branch_footer), '/');

$data['headerPath'] = base_url($header);
$data['footerPath'] = base_url($footer);
$data['prepared_by_name'] = $prepared_by_name;
$data['prepared_signature'] = $prepared_signature;
$data['prepared_by_contact'] = $prepared_by_contact ?? '';

//    $data['headerPath'] = base_url() . ltrim($branch_details->branch_header, '/');
// $data['footerPath'] = base_url() . ltrim($branch_details->branch_footer, '/');
	// DOMPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);

    $html = $this->load->view('amc/print/amc_quotation_print', $data, true);
    // echo $html;   
    //  exit;

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("amc_$id.pdf", ["Attachment" => 0]);

    // $this->load->view('amc/print/amc_quotation_print.php', $data);
}
	function edit_quotation()
	{
		$data['title']='Edit Quotation';
		$id = $this->uri->segment('3');
		$version = $this->uri->segment('4');
		$data['edit_flag'] = $this->uri->segment('5');

		$this->load->model('Users_model');
		//$data['cust_records'] = $this->Users_model->get_active_customer_list();
        $data['cust_records']  = $this->Setup_model->get_all_customer_list();
		$this->load->model('Setup_model');
		$data['vat_percent']=$this->Setup_model->get_vat_for_calculation();
		$data['currency_list']=$this->Setup_model->get_currency_list();
	   // $data['bank_details']=$this->Setup_model->get_company_bank_list();
		//$data['terms_rec']=$this->Setup_model->get_terms_details();
		//$data['payment_terms']=$this->Setup_model->get_payment_terms();
		$data['records1']=$this->Amc_model->get_quotation_master_by_id($id);		
		$data['records2']=$this->Amc_model->get_quotation_tr_by_id($id,$version);
		$data['scope_records']=$this->Amc_model->get_scope_of_work();
		$data['records3']=$this->Amc_model->get_quotation_scope_by_id($id);
		//$data['service_scheme_records'] = $this->Amc_model->get_service_schemes();
		$enq_type = $data['records1'][0]->enq_type;
		$this->load->model('Product_model');
		//$data['products']=$this->Product_model->get_product_list_by_category($enq_type);
		// echo '<pre>';print_r($data);exit;

		$data['main_content']='amc/quotation_edit.php';
		$this->load->view('includes/template.php',$data);
	}

	function update_quotation_data()
	{
		$qid=$this->input->post('quote_id');
		$this->Amc_model->update_quotation_data($qid);
		$this->session->set_flashdata('success', 'Data Updated Successfully..');
		redirect('AMC/view_quotation_list');
	}
	function get_invoice_code()
	{
	  	$prifix='DEX/AI/'.date('y').'/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix,'invoice_code','amc_invoice_master',11)+1;
		$digit=sprintf("%1$04d",$num);
		$data['code'] =$prifix.$digit;
		 echo $data['code'];
	}
	public function add_invoice()
{
    $data['title']='Generate AMC Agreement';
    $data['records']=$this->Amc_model->get_amc_quotations_for_invoice();

    $prifix='ADL/AI/'.date('y').'/';
    $this->load->model('Setup_model');
    $num = $this->Setup_model->get_next_code($prifix,'invoice_code','amc_invoice_master',11)+1;
    $digit=sprintf("%1$04d",$num);
    $data['code'] =$prifix.$digit;        

    $data['vat_percent']=$this->Setup_model->get_vat_for_calculation();
    $data['currency_list']=$this->Setup_model->get_currency_list();

    // ❌ DO NOT load banks here
    $data['bank_details'] = [];  

    $this->load->model('Users_model');
    $data['user_records']=$this->Users_model->get_user_list();
   // $data['cust_records'] = $this->Users_model->get_active_customer_list();
	$data['cust_records']  = $this->Setup_model->get_all_customer_list();
$this->load->model('Hr_model');
            $data['employees'] = $this->Hr_model->get_employee_list();

    $data['main_content']='amc/invoice_add.php';
    $this->load->view('includes/template.php',$data);
}
	function add_invoice_data()
	{
		$data['title']='Add New Invoice';
		$insert_id = $this->Amc_model->add_invoice_data();

		if($insert_id!=''){
			$this->session->set_flashdata('success', 'Data Saved Successfully..');
			redirect('AMC/view_invoice_list');
		}
	}

	function edit_amc()
{
    $data['title'] = 'Edit Invoice';

    $id = $this->uri->segment(3);
    $data['edit_flag'] = $this->uri->segment(4);

    // ✅ master + items structure
    $data['records1'] = $this->Amc_model->get_invoice_master_by_id($id);
	$quote_id = !empty($data['records1']) ? $data['records1']->quote_id : 0;
	$data['quotation_info'] = $this->Amc_model->get_amc_quotation_info($quote_id);
	$branch_id = !empty($data['records1']) ? $data['records1']->branch_id : null;

    // (optional: if still using separate query for safety, keep it)
    $data['records2'] = $this->Amc_model->get_invoice_tr_by_id($id);
	$data['sla_records'] = $this->Amc_model->get_invoice_sla_by_id($id);
$data['annexure_records'] = $this->Amc_model->get_invoice_annexure_by_id($id);
    $this->load->model('Setup_model');

    $data['vat_percent']   = $this->Setup_model->get_vat_for_calculation();
    $data['currency_list'] = $this->Setup_model->get_currency_list();
    $data['bank_details']  = $this->Setup_model->get_company_bank_list($branch_id);

    $this->load->model('Users_model');
    $this->load->model('Product_model');

    $data['user_records'] = $this->Users_model->get_user_list();
    $data['cust_records'] = $this->Users_model->get_active_customer_list();
    $data['brand_list']   = $this->Product_model->get_brand_list();
	$this->load->model('Hr_model');
            $data['employees'] = $this->Hr_model->get_employee_list();

    $data['main_content'] = 'amc/invoice_edit.php';

    $this->load->view('includes/template.php', $data);
}

	function update_invoice_data()
	{
		$data['title']='Edit Invoice';
		$gid=$this->input->post('invoice_id');

		$this->Amc_model->update_invoice_data($gid);
		$this->session->set_flashdata('success', 'Data Updated Successfully..');
		redirect('AMC/view_invoice_list');
	}
	function reminders(){
		$data['title']='Reminder List';
		$data['records']=$this->Amc_model->get_reminder_list();
		$data['ppmrecords']=$this->Amc_model->get_ppm_rem_list();
		$data['main_content']='amc/amc_reminder_list.php';
		$this->load->view('includes/template.php',$data);
	}
	function reports(){
		$data['title']		='AMC Reports';
		$data['from']		= date('01-m-Y');
		$data['to']			= date('d-m-Y');
		$data['date_type'] 	= '';
		$data['cust_id'] 	= '';
		$data['project_name'] 	= '';
		$data['rpt_type'] = '';
		$data['records']=$this->Amc_model->get_reminder_list();
		$data['amc_customer_list']=$this->Amc_model->get_amc_customer_list();
		$data['amc_project_list']=$this->Amc_model->get_amc_project_list();
		$data['main_content']='amc/amc_reports.php';
		//echo '<pre>';print_r($data);exit;
		$this->load->view('includes/template.php',$data);
	}
	function get_reports(){
		$data['title']='AMC Reports';	
		$data['from'] 		= $this->input->post('from');
		$data['to'] 		= $this->input->post('to');
		//$data['cmp_type'] = $this->input->post('cmp_type');
		$data['date_type'] 	= $this->input->post('date_type');
		$data['cust_id'] 	= $this->input->post('customer_id');
$data['project_name'] = $this->input->post('project_name') ?? '';
		$data['rpt_type'] = $this->input->post('rpt_type');
		$data['amc_customer_list']=$this->Amc_model->get_amc_customer_list();
		$data['amc_quotation_list']=$this->Amc_model->get_amc_quotation_list();	
		$data['amc_project_list']=$this->Amc_model->get_amc_project_list();
		$data['amc_list']=$this->Amc_model->get_amc_report();
		$data['main_content']='amc/amc_reports.php';
		//echo '<pre>';print_r($data);exit;
		$this->load->view('includes/template.php',$data);
	}
function quotation_reports(){
		$data['title']		='AMC Quotation Reports';
		$data['from']		= date('01-m-Y');
		$data['to']			= date('d-m-Y');
		$data['date_type'] 	= '';
		$data['customer_id'] 	= '';
		$data['project_name'] 	= '';
		$data['status'] = $this->input->post('status');
		
		$data['amc_customer_list']=$this->Amc_model->get_amc_customer_list();
		$data['amc_quotation_list'] = []; 
		
		$data['main_content']='amc/amc_quotation_report.php';
		//echo '<pre>';print_r($data);exit;
		$this->load->view('includes/template.php',$data);
	}
	function get_quotation_report(){
		$data['title']='AMC Quotation Reports';	
		$data['from'] 		= $this->input->post('from');
		$data['to'] 		= $this->input->post('to');
		
		$data['date_type'] 	= $this->input->post('date_type');
		$data['customer_id'] 	= $this->input->post('customer_id');
		$data['project_name'] 	= $this->input->post('project_name');
		 $data['status'] = $this->input->post('status');
		$data['amc_customer_list']=$this->Amc_model->get_amc_customer_list();
		$data['amc_quotation_list']=$this->Amc_model->get_amc_quotation_report();	
		
		$data['main_content']='amc/amc_quotation_report.php';
		//echo '<pre>';print_r($data);exit;
		$this->load->view('includes/template.php',$data);
	}
function print_quotation_report()
  {
    $data['from'] = $this->input->post('from');
    $data['to'] = $this->input->post('to');
    $data['status'] = $this->input->post('status');
    $data['customer_id'] = $this->input->post('customer_id');
    $data['quotation_id'] = $this->input->post('quotation_id');

    $this->load->model('Setup_model');
    $data['customer_list'] = $this->Users_model->get_customer_list();
    $data['comapny_records'] = $this->Setup_model->get_company_master_list();
   
    $this->load->model('Report_Model');
    $data['records'] =$this->Amc_model->get_amc_quotation_report();

    $this->load->view('Print/quotation_report_print.php', $data);
  }

  function export_quotation_report()
  {
    $data['from'] = $this->input->post('from');
    $data['to'] = $this->input->post('to');
    $data['status'] = $this->input->post('status');
    $data['customer_id'] = $this->input->post('customer_id');
    $data['quotation_id'] = $this->input->post('quotation_id');

    $this->load->model('Setup_model');
   // $data['customer_list'] = $this->Setup_model->get_customer_list();

    $this->load->model('Report_Model');
    $data['records'] = $this->Amc_model->get_amc_quotation_report();

    $this->load->view('excel_reports/amc_quotation_report_export.php', $data);
  }

	function view_invoice_list(){
		$data['title']='AMC List';
		$data['records']=$this->Amc_model->get_amc_list();
		$data['main_content']='amc/amc_list.php';
		$this->load->view('includes/template.php',$data);
	}
public function print_amc()
{
    $id = $this->uri->segment(3);

    // ❌ REMOVE URI PRINT TYPE (better from DB)
    $records1 = $this->Amc_model->get_invoice_master_by_id($id);

    if (!$records1) {
        show_error('AMC record not found');
    }
	$quote_id = $records1->quote_id;

    $data['records1'] = $records1;
		 $data['quotation_info'] = $this->Amc_model->get_amc_quotation_info($quote_id);

	$data['sla_records'] = $this->Amc_model->get_invoice_sla_by_id($id);
$data['annexure_records'] = $this->Amc_model->get_invoice_annexure_by_id($id);

    // ✔ PRINT TYPE FROM DB (quotation table)
    $data['print_type_text'] = ($records1->quot_print_type == 1)
        ? 'NON-COMPREHENSIVE'
        : 'COMPREHENSIVE';

    $data['records2'] = $this->Amc_model->get_invoice_tr_by_id($id, 0);
    $data['vat_percent'] = $this->Setup_model->get_vat_for_calculation();

    // Branch
    $branch_id = $records1->branch_id;
    $branch_details = $this->Company_model->get_branch_by_id($branch_id);

	 $data['branch_stamp']  = $branch_details->branch_stamp ?? '';

 $prepared_by_id = $records1->prepared_by;
 $prepared_by_name = '';
  $prepared_signature = '';
 if (!empty($prepared_by_id)) {
        $prepared_emp = $this->Company_model->get_employee_by_id($prepared_by_id);
        $prepared_by_name = $prepared_emp->employee_name ?? '';
        $prepared_signature = $prepared_emp->signature_file ?? '';
		$prepared_by_contact = $prepared_emp->mobile ?? '';

    }
$data['prepared_by_name'] = $prepared_by_name;
$data['prepared_signature'] = $prepared_signature;
$data['prepared_by_contact'] = $prepared_by_contact ?? '';
	

    if ($branch_details && !empty($branch_details->branch_header)) {
    $data['headerPath'] = base_url($branch_details->branch_header);
} else {
    $data['headerPath'] = ''; // or default header image
}

if ($branch_details && !empty($branch_details->branch_footer)) {
    $data['footerPath'] = base_url($branch_details->branch_footer);
} else {
    $data['footerPath'] = ''; // or default footer image
}



    // DOMPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);

    $html = $this->load->view('amc/print/amc_print', $data, true);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("amc_$id.pdf", ["Attachment" => 0]);
}
	function delete_amc(){
		$invoice_id = $this->input->post('invoice_id');
		$quote_id 	= $this->input->post('quote_id');
		$res = $this->Amc_model->delete_invoice($quote_id,$invoice_id);
		echo $res;
	}
	function add_complaint()
	{

		$data['title']='Complaint Registration';
		$data['records']=$this->Amc_model->get_amc_list();
		//echo '<pre>';print_r($data['records']);exit;
		$prifix='ADL/CP/'.date('y').'/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix,'cmp_code','amc_complaint_master',11)+1;
		$digit=sprintf("%1$04d",$num);
		$data['code'] =$prifix.$digit;		
		$data['user_records']=$this->Users_model->get_user_list();
		$data['amc_products']=$this->Product_model->get_amc_product_list();
		$data['main_content']='amc/complaint_add.php';
		$this->load->view('includes/template.php',$data);
	}

	function add_complaint_data(){
		$data['title']='Add Complaint Data';
		$insert_id = $this->Amc_model->add_complaint_data();

		if($insert_id!=''){
			$this->session->set_flashdata('success', 'Data Saved Successfully..');
			redirect('AMC/view_complaint');
		}
	}
	function view_complaint(){
		$data['title']='Complaint List';
		$data['records']=$this->Amc_model->get_complaint_list();
		$data['main_content']='amc/complaint_list.php';
		$this->load->view('includes/template.php',$data);
	}
	function edit_complaint(){
		$data['title']='Complaint Edit';
		$id = $this->uri->segment('3');
		$data['records']=$this->Amc_model->get_complaint_list_with_id($id);
		$data['tr_records1']=$this->Amc_model->get_cmp_details1($id);
		$data['tr_records2']=$this->Amc_model->get_cmp_details2($id);
		$data['user_records']=$this->Users_model->get_user_list();
		$data['amc_products']=$this->Product_model->get_amc_product_list();
		$data['main_content']='amc/complaint_edit.php';
		//echo '<pre>';print_r($data);exit;
		$this->load->view('includes/template.php',$data);
	}
	function update_complaint_data()
	{
		$data['title']='Update Complaint';
		$cid=$this->input->post('cmp_id');

		$this->Amc_model->update_complaint_data($cid);
		

		$this->session->set_flashdata('success', 'Data Updated Successfully..');
		redirect('AMC/view_complaint');
	}
	function complaint_report()
	{
		$data['title'] = "Complaint Report";
		$data['from']=date('01-m-Y');
		$data['to']=date('d-m-Y');
		$data['status'] ="";
		$data['project_name'] =""; 
		$data['technician'] =""; 
		$data['product_code'] ="";
		$data['rpt_type'] = "";
		$data['customer_list']=$this->Users_model->get_customer_list();

		$this->load->model('Reports_model');
		// $data['user_records']=$this->Users_model->get_user_list_id(2);
		$data['records']=array();
		$data['projects']=$this->Amc_model->get_complaint_records_project();
		// $data['amc_products']=$this->Product_model->get_amc_product_list();
		$data['main_content']='amc/complaint_report.php';
		$this->load->view('includes/template.php',$data);
	}
	function get_complaint_report()
	{
		$data['title'] = "Complaint Report";
		$data['from'] = $this->input->post('from');
		$data['to'] = $this->input->post('to');
		$data['status'] =$this->input->post('status');
		$data['rpt_type'] = $this->input->post('rpt_type');
		//$data['cmp_type'] =$this->input->post('cmp_type');
		$data['project_name'] =$this->input->post('project_name');
		$data['technician'] =$this->input->post('technician');
		$data['product_code'] =$this->input->post('product_code');
		$data['user_records']=$this->Users_model->get_user_list();	
		if($data['from']==''){
			$data['from'] = $this->uri->segment('3');
			$data['to'] = $this->uri->segment('4');}
		
		$data['customer_list']=$this->Users_model->get_customer_list();
		$data['records']=$this->Amc_model->get_complaint_records();
		$data['projects']=$this->Amc_model->get_complaint_records_project();
		$data['amc_products']=$this->Product_model->get_amc_product_list();
		$data['main_content']='amc/complaint_report.php';
		$this->load->view('includes/template.php',$data);
	}
	function print_complaint_report()
	{
	$data['from'] = $this->input->post('from');
	$data['to'] = $this->input->post('to');
	$data['status'] =$this->input->post('status');
	$data['rpt_type'] = $this->input->post('rpt_type');

	$this->load->model('Users_model');
	$data['customer_list']=$this->Users_model->get_customer_list();
	$data['supplier_records']=$this->Users_model->get_supplier_list();
	$data['comapny_records']=$this->Setup_model->get_company_master_list();
	$data['records']=$this->Amc_model->get_complaint_records();
	$this->load->view('amc/print/print_complaint_report.php',$data);
	}

	function print_amc_report()
	{
	$data['from'] 		= $this->input->post('from');
	$data['to'] 		= $this->input->post('to');
	$data['date_type'] 	=$this->input->post('date_type');
	$data['cust_id'] 	= $this->input->post('customer_id');
	$data['quote_id'] 	= $this->input->post('quotation_id');
	$data['amc_customer_list']=$this->Amc_model->get_amc_customer_list();
	$data['amc_quotation_list']=$this->Amc_model->get_amc_quotation_list();	
	$data['records']=$this->Amc_model->get_amc_report();
	$this->load->model('Users_model');
	$data['amc_list']=$this->Amc_model->get_amc_report();
	$data['customer_list']=$this->Users_model->get_customer_list();
	
	$data['comapny_records']=$this->Setup_model->get_company_master_list();
	$this->load->view('amc/print/print_amc_report.php',$data);
	}

	function delete_cmp()
	{
		$id=$this->input->post('cmp_id');
		$res = $this->Amc_model->delete_cmp($id);
		echo $res;
	}
	function add_ppm(){
		$data['title']='AMC PPM Schedule';
		$data['records']=$this->Amc_model->get_amc_list();
		//echo '<pre>';print_r($data['records']);exit;
		$prifix='ADL/PP/'.date('y').'/';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix,'ppm_code','amc_ppm_master',11)+1;
		$digit=sprintf("%1$04d",$num);
		$data['code'] =$prifix.$digit;		
		// $data['user_records']=$this->Users_model->get_user_list_id(2);
		$data['main_content']='amc/ppm_add.php';
		$this->load->view('includes/template.php',$data);
	}
	function add_ppm_data(){
		$data['title']='Add PPM Data';
		$insert_id = $this->Amc_model->add_ppm_data();

		if($insert_id!=''){
			$this->session->set_flashdata('success', 'Data Saved Successfully..');
			redirect('AMC/view_ppm');
		}
	}
	function view_ppm(){
		$data['title']='PPM List';
		$data['records']=$this->Amc_model->get_ppm_list();
		$data['main_content']='amc/ppm_list.php';
		$this->load->view('includes/template.php',$data);
	}
	

	function edit_ppm(){
    $data['title'] = 'PPM Edit';

    $id = $this->uri->segment(3);
    $data['source'] = $this->uri->segment(4); // ppm_list or reminder

    $data['records'] = $this->Amc_model->get_ppm_with_id($id);
    $data['summary_records'] = $this->Amc_model->get_ppm_summ_with_id($id);
    $data['detail_records'] = $this->Amc_model->get_ppm_details_with_id($id);

    $data['main_content'] = 'amc/ppm_edit.php';
    $this->load->view('includes/template.php', $data);
}
	function update_ppm_data()
{
    $data['title'] = 'PPM Update';

    $pid = $this->input->post('ppm_id');

    // update model
    $this->Amc_model->update_ppm_data($pid);

    $this->session->set_flashdata('success', 'Data Updated Successfully..');

    // 👇 get source (reminder / ppm_list)
    $source = $this->input->post('source');

    if ($source == 'reminder') {
        redirect('AMC/reminders');
    } else {
        redirect('AMC/view_ppm');
    }

    exit;
}
	function delete_ppm()
	{
		$id=$this->input->post('id');
		$res = $this->Amc_model->delete_ppm($id);
		echo $res;
	}

	////////////////////// QUOT direct ///////////////////////////
	
	function add_direct_quotation()
	{
		$data['title']='Direct AMC Quotation';
		
		$this->load->model('Setup_model');
		
		$prifix='ADL/AQT/';
		$num = $this->Setup_model->get_next_code($prifix,'quotation_code','amc_quotation_master',9)+1;
		$digit=sprintf("%1$04d",$num);
		$code =$prifix.$digit;
		$data['Code'] =$code;
		
		$this->load->model('Company_model');
				$this->load->model('Item_model');
						$this->load->model('Setup_model');

			$data['branch_list']   = $this->Company_model->get_all_branches();
		
			$data['customer_list']  = $this->Setup_model->get_all_customer_list();

		$this->load->model('Users_model');
		// $data['cust_records'] = $this->Users_model->get_active_customer_list();
		$data['user_records']=$this->Users_model->get_user_list();

			$data['active_users']  = $this->Setup_model->get_active_user_list();
		
			// $data['active_units']  = $this->Item_model->get_all_units();

		$data['all_products']       = $this->Setup_model->get_active_item_list();	
		$data['active_units']       = $this->Setup_model->get_active_unit_list();
		$data['active_items']       = $this->Setup_model->get_active_item_list();	

		$data['vat_percent']=$this->Setup_model->get_vat_for_calculation();		

		$this->load->model('Users_model');
		$data['user_records']=$this->Users_model->get_user_list();
		//$data['supplier_records']=$this->Users_model->get_supplier_list();
		//$data['cust_records'] = $this->Users_model->get_active_customer_list();
	$data['cust_records']  = $this->Setup_model->get_all_customer_list();
		
		$this->load->model('Product_model');	
		
		$this->load->model('Hr_model');
            $data['employees'] = $this->Hr_model->get_employee_list();
// Prefill from PPM replacement flow (if any) — consumed once
$data['prefill'] = $this->session->userdata('replacement_quote_prefill');
if (!empty($data['prefill']))
{
    $this->session->unset_userdata('replacement_quote_prefill');
}
		$data['main_content']='amc/quotation_add_direct.php';
		$this->load->view('includes/template.php',$data);
	}

	function add_quot_direct()
  	{    
    	$data['title']='Direct Quotation Create';
	   $this->Amc_model->add_quot_direct();
	    
	   $this->session->set_flashdata('success', 'Data Saved Successfully..');
	   redirect('AMC/quotation_direct_list');
   }

   	function quotation_direct_list()
	{
		$data['title']='AMC Quotation List';
		$this->load->model('Sales_model');
		$data['records']=$this->Amc_model->get_quotation_list();

		$data['main_content']='amc/quotation_list_direct.php';
		$this->load->view('includes/template.php',$data);
	}

	function edit_direct_quotation()
	{
		$data['title']='Edit Quotation';
		$id = $this->uri->segment('3');
		$version = $this->uri->segment('4');
		$data['edit_flag'] = $this->uri->segment('5');

		$this->load->model('Users_model');
		// $data['cust_records'] = $this->Users_model->get_active_customer_list();
		$this->load->model('Setup_model');
		$data['vat_percent']=$this->Setup_model->get_vat_for_calculation();
		// $data['currency_list']=$this->Setup_model->get_currency_list();
	    // $data['bank_details']=$this->Setup_model->get_company_bank_list();
		// $data['terms_rec']=$this->Setup_model->get_terms_details();
		// $data['payment_terms']=$this->Setup_model->get_payment_terms();
		$data['records1']=$this->Amc_model->get_quotation_master_by_id($id);
		$data['sla_records'] = $this->Amc_model->get_quotation_sla_by_id($id);
        $data['annexure_records'] = $this->Amc_model->get_quotation_annexure_by_id($id);
				
		$data['records2']=$this->Amc_model->get_quotation_tr_by_id($id,$version);
		$data['scope_records']=$this->Amc_model->get_scope_of_work();
		$data['records3']=$this->Amc_model->get_quotation_scope_by_id($id);
		// $data['service_scheme_records'] = $this->Amc_model->get_service_schemes();
		//$enq_type = $data['records1'][0]->enq_type;
		$this->load->model('Product_model');
		//$data['products']=$this->Product_model->get_product_list_by_category($enq_type);
		// echo '<pre>';print_r($data);exit;
        $this->load->model('Hr_model');
            $data['employees'] = $this->Hr_model->get_employee_list();
        $data['active_items']       = $this->Setup_model->get_active_item_list();	

		$data['main_content']='amc/quotation_edit_direct.php';
		$this->load->view('includes/template.php',$data);
	}

	function update_quot_direct()
	{
		$data['title']='Update Direct Quotation';
		$qid=$this->input->post('quote_id');

		$this->load->model('Amc_Model');
		$this->Amc_Model->update_direct_quotation_data($qid);

		$this->session->set_flashdata('success', 'Data Updated Successfully..');
		redirect('AMC/quotation_direct_list');
	}

	public function get_branch_banks()
{
    $branch_id = $this->input->post('branch_id');
			$this->load->model('Setup_model');


    $bank_details = $this->Setup_model->get_company_bank_list($branch_id);
	

    if (!empty($bank_details)) {
        foreach ($bank_details as $r) {
            echo "<tr style='font-size:13px;'>
                    <td width='30px'>
                        <input type='radio' name='bank' value='{$r->bid}' checked>
                        <input type='hidden' name='trans_id[]' value='{$r->bid}'>
                    </td>
                    <td><input type='text' class='form-control' value='{$r->bank_name}' readonly></td>
                    <td><input type='text' class='form-control' value='{$r->bank_account}' readonly></td>
                    <td><input type='text' class='form-control' value='{$r->bank_branch}' readonly></td>
                    <td><input type='text' class='form-control' value='{$r->bank_iban}' readonly></td>
                    <td><input type='text' class='form-control' value='{$r->bank_swift}' readonly></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center text-danger'>No banks found for this branch</td></tr>";
    }
}
function ppm_report()
{
    $data['title'] = "PPM Report";

    $data['from'] = $this->input->post('from') ?? date('Y-m-01');
    $data['to']   = $this->input->post('to') ?? date('Y-m-d');

    $data['project_name'] = "";
    $data['status'] = "";
    $data['ppm_code'] = "";

    // FIX DEFAULT HERE ALSO
    $data['rpt_type'] = $this->input->post('rpt_type') ?? "Summary";

    $this->load->model('Amc_model');

    $data['projects'] = $this->Amc_model->get_ppm_project_list();
    $data['records']  = $this->Amc_model->get_ppm_records();
    $data['main_content'] = 'amc/ppm_report.php';
    $this->load->view('includes/template.php', $data);
}

function get_ppm_report()
{
     $data['title'] = "PPM Report";

     $data['from'] = $this->input->post('from') ?? date('Y-m-01');
    $data['to']   = $this->input->post('to') ?? date('Y-m-d');

    $data['status']       = $this->input->post('status');
    $data['project_name'] = $this->input->post('project_name');
    $data['ppm_code']     = $this->input->post('ppm_code');

    $data['rpt_type'] = $this->input->post('rpt_type');

    if (empty($data['rpt_type'])) {
        $data['rpt_type'] = "Summary";
    }

    $this->load->model('Amc_model');

    $data['projects'] = $this->Amc_model->get_ppm_project_list();

    $data['records'] = $this->Amc_model->get_ppm_records(
        $data['from'],
        $data['to']
    );

    // attach details for detailed view
    foreach ($data['records'] as $r) {
        $r->details = $this->Amc_model->get_ppm_details($r->ppm_id);
    }
    $data['main_content'] = 'amc/ppm_report.php';
    $this->load->view('includes/template.php', $data);
}

function print_ppm_report()
	{
	$data['from'] = $this->input->post('from');
	$data['to'] = $this->input->post('to');
	// $data['status'] =$this->input->post('status');
	// $data['rpt_type'] = $this->input->post('rpt_type');
    $this->load->model('Amc_model');

	$data['records'] = $this->Amc_model->get_ppm_records(
        $data['from'],
        $data['to']
    );

	$this->load->model('Users_model');
	$data['customer_list']=$this->Users_model->get_customer_list();
	$data['supplier_records']=$this->Users_model->get_supplier_list();
	$data['comapny_records']=$this->Setup_model->get_company_master_list();
	// $data['records']=$this->Amc_model->get_complaint_records();
	 $branch_id = 1;
    $branch_details = $this->Company_model->get_branch_by_id($branch_id);

	$header = ltrim(str_replace('./', '', $branch_details->branch_header), '/');
$footer = ltrim(str_replace('./', '', $branch_details->branch_footer), '/');

$data['headerPath'] = base_url($header);
$data['footerPath'] = base_url($footer);
	$this->load->view('amc/print/print_ppm_report.php',$data);
	}

public function generate_ppm_invoice()
{
    $ppm_summary_id = $this->input->post('ppm_summary_id');

    $this->load->model('AMC_model');

    $ppm = $this->AMC_model->get_ppm_invoice_data($ppm_summary_id);

    if(empty($ppm)){
        echo json_encode([
            'status' => false,
            'message' => 'Data not found'
        ]);
        return;
    }

    // prevent duplicate invoice
    if($ppm->invoice_generated == 1){
        echo json_encode([
            'status' => false,
            'message' => 'Invoice already generated'
        ]);
        return;
    }

    $invoice_no = 'PPMINV/'.date('y').'/'.rand(1000,9999);

    $this->db->insert('ppm_invoice_master', array(
        'ppm_summary_id' => $ppm->id,
        'ppm_id'         => $ppm->ppm_id,
        'quote_id'       => $ppm->quote_id,
        'invoice_no'     => $invoice_no,
        'invoice_date'   => date('Y-m-d'),
        'customer_id'    => $ppm->customer_id,
        'project_name'   => $ppm->project_name,
        'amount'         => $ppm->ppm_amt,
        'created_by'     => $this->session->userdata('user_id')
    ));

    $invoice_id = $this->db->insert_id();

    $this->db->where('id', $ppm_summary_id);
    $this->db->update('amc_ppm_summary', array(
        'invoice_generated' => 1,
        'invoice_id'        => $invoice_id
    ));

    echo json_encode([
        'status' => true,
        'message' => 'Invoice Generated Successfully',
        'invoice_id' => $invoice_id
    ]);
}

public function print_ppm_invoice($invoice_id)
{
    $this->load->model('AMC_model');

    // invoice header
    $data['invoice'] = $this->AMC_model->get_ppm_invoice_by_id($invoice_id);

    if (empty($data['invoice'])) {
        show_404();
    }

    // ppm details
    $data['ppm_details'] = $this->AMC_model->get_ppm_summary_by_invoice($invoice_id);

    // branch details
    $branch_id = 1;
    $branch_details = $this->Company_model->get_branch_by_id($branch_id);

    if (!empty($branch_details)) {

        $header = ltrim(str_replace('./', '', $branch_details->branch_header), '/');
        $footer = ltrim(str_replace('./', '', $branch_details->branch_footer), '/');

        $data['headerPath'] = base_url($header);
        $data['footerPath'] = base_url($footer);

    } else {
        $data['headerPath'] = '';
        $data['footerPath'] = '';
    }

    $data['title'] = 'PPM Invoice Print';

    $this->load->view('amc/print/print_ppm_invoice', $data);
}
//work order start---------------------------------------

//   public function work_order_list($type = 'external')
//     {
//         $data['title']='Work order';
//         $data['wo_type']  = ucfirst($type);
//         $data['wo_list']  = $this->Amc_model->get_work_order_list(ucfirst($type));
//         $data['main_content']='work_order/list.php';
// 		$this->load->view('includes/template.php',$data);        
//     }
public function work_order_list()
    {
		$type='';
        $data['title']='Work order';
        $data['wo_type']  = ucfirst($type);
        $data['wo_list']  = $this->Amc_model->get_work_order_list();
        $data['main_content']='work_order/list.php';
		$this->load->view('includes/template.php',$data);        
    }

	
	  public function work_order_add($type = 'external')
    {
         $data['title']='Add Work order';
        $data['wo_type'] = ucfirst($type);
		  $data['branches'] = $this->Amc_model->get_branches();
         $data['main_content']='work_order/form.php';
		$this->load->view('includes/template.php',$data);		
      
    }

    public function work_order_edit($wo_id)
    {
		 $data['title']='Edit Work order';
		   $data['branches'] = $this->Amc_model->get_branches();
        $data['wo']    = $this->Amc_model->get_work_order($wo_id);
        $data['items'] = $this->Amc_model->get_work_order_items($wo_id);
		   $data['main_content']='work_order/form.php';

		$this->load->view('includes/template.php',$data);		
       
    }

    // ---- AJAX: customer auto-fetch ----
    public function customer_lookup()
    {
        $code = $this->input->post('customer_code');
        $cust = $this->Amc_model->get_customer_by_code($code);
        echo json_encode($cust);
    }

    // ---- AJAX: product search (Select2) ----
    public function product_search()
    {
        $term = $this->input->get('term');
        $products = $this->Amc_model->search_products($term);
        $results = [];
        foreach ($products as $p) {
            $results[] = ['id' => $p->product_id, 'text' => $p->product_code . ' - ' . $p->product_name];
        }
        echo json_encode(['results' => $results]);
    }
    // ---- AJAX: staff search (Select2) ----
    public function staff_search()
    {
        $term = $this->input->get('term');
        $staff = $this->Amc_model->search_staff($term);
        $results = [];
        foreach ($staff as $s) {
            $results[] = ['id' => $s->user_id, 'text' => $s->user_code . ' - ' . $s->user_name];
        }
        echo json_encode(['results' => $results]);
    }
    // ---- AJAX: AMC lookup list ----
    public function amc_lookup()
    {
        $cust_id = $this->input->post('cust_id');
        $contracts = $this->Amc_model->get_active_amc_contracts($cust_id);
        echo json_encode($contracts);
    }

    // ---- AJAX: AMC contract selected ----
    public function amc_select()
    {
        $invoice_id = $this->input->post('invoice_id');
        $c = $this->Amc_model->get_amc_contract_detail($invoice_id);
        echo json_encode([
            'amc_invoice_id'       => $c->invoice_id,
            'contract_invoice_ref' => $c->invoice_code,
            'expiry_date'          => $c->amc_end_date
        ]);
    }

    // ---- Save ----
    // public function save()
    // {
    //     $wo_id = $this->input->post('wo_id');

    //     $data = [
    //         'wo_type'              => $this->input->post('wo_type'),
    //         'branch_id'            => $this->input->post('branch_id'),
    //         'ref_date'              => $this->input->post('ref_date'),
    //         'enquiry_no'           => $this->input->post('enquiry_no'),
    //         'customer_code'        => $this->input->post('customer_code'),
    //         'cust_id'              => $this->input->post('cust_id'),
    //         'contact_name'         => $this->input->post('contact_name'),
    //         'telephone'            => $this->input->post('telephone'),
    //         'contact_no'           => $this->input->post('contact_no'),
    //         'fax'                  => $this->input->post('fax'),
    //         'delivery_date'        => $this->input->post('delivery_date'),
    //         'supervisor_id'        => $this->input->post('supervisor_id'),
    //         'technician_id'        => $this->input->post('technician_id'),
    //         'nature_of_complaint'  => $this->input->post('nature_of_complaint'),
    //         'inspection_comments'  => $this->input->post('inspection_comments'),
    //         'technical_comments'   => $this->input->post('technical_comments'),
    //         'type_of_service'      => $this->input->post('type_of_service'),
    //         'contract_invoice_ref' => $this->input->post('contract_invoice_ref'),
    //         'amc_invoice_id'       => $this->input->post('amc_invoice_id') ?: null,
    //         'expiry_date'          => $this->input->post('expiry_date') ?: null,
    //     ];

    //     if ($wo_id) {
    //         $this->Amc_model->update_work_order($wo_id, $data);
    //     } else {         

	// 		$branch = $this->db->where('branch_id', $this->input->post('branch_id'))->get('branch_master')->row();
	// 		$data['ref_no']       = $this->Amc_model->generate_wo_ref_no($branch->branch_code);
	// 		$data['created_by']   = $this->session->userdata('user_id');
	// 		$data['created_date'] = date('Y-m-d H:i:s');
	// 		$wo_id = $this->Amc_model->insert_work_order($data);
    //     }

    //     // items
    //    // $product_ids = $this->input->post('product_id');
    // //     $product_codes = $this->input->post('product_code');
    // //     if (!empty($product_ids)) {
    // //         $items = [];
    // //         foreach ($product_ids as $i => $pid) {
    // //             $items[] = ['wo_id' => $wo_id, 'product_id' => $pid, 'product_code' => $product_codes[$i]];
    // //         }
    // //         $this->Amc_model->insert_work_order_items($items);
    // //     }

    // //     echo json_encode(['status' => 'success', 'wo_id' => $wo_id]);
    // // }
	// $product_ids = $this->input->post('product_id');
	// if (!empty($product_ids)) {
	// 	$this->Amc_model->replace_work_order_items($wo_id, $product_ids);
	// }
	// }
	    public function save()
    {
        $wo_id = $this->input->post('wo_id');

        // ---- Server-side validation (Select2 hides <select> from HTML5 required check) ----
        $required = [
            'wo_type'         => 'Maintenance Type (External/Internal)',
            'branch_id'       => 'Division / Branch',
            'customer_code'   => 'Customer Code',
            'type_of_service' => 'Type of Service',
        ];
        $missing = [];
        foreach ($required as $field => $label) {
            if (!$this->input->post($field)) {
                $missing[] = $label;
            }
        }
        if (!empty($missing)) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill: ' . implode(', ', $missing)]);
            return;
        }

        $data = [
            'wo_type'              => $this->input->post('wo_type'),
            'branch_id'            => $this->input->post('branch_id'),
            'ref_date'             => $this->input->post('ref_date'),
            'enquiry_no'           => $this->input->post('enquiry_no'),
            'customer_code'        => $this->input->post('customer_code'),
            'cust_id'              => $this->input->post('cust_id'),
            'contact_name'         => $this->input->post('contact_name'),
            'telephone'            => $this->input->post('telephone'),
            'contact_no'           => $this->input->post('contact_no'),
            'fax'                  => $this->input->post('fax'),
            'delivery_date'        => $this->input->post('delivery_date'),
            'supervisor_id'        => $this->input->post('supervisor_id'),
            'technician_id'        => $this->input->post('technician_id'),
            'nature_of_complaint'  => $this->input->post('nature_of_complaint'),
            'inspection_comments'  => $this->input->post('inspection_comments'),
            'technical_comments'   => $this->input->post('technical_comments'),
            'type_of_service'      => $this->input->post('type_of_service'),
            'contract_invoice_ref' => $this->input->post('contract_invoice_ref'),
            'amc_invoice_id'       => $this->input->post('amc_invoice_id') ?: null,
            'expiry_date'          => $this->input->post('expiry_date') ?: null,
        ];

        if ($wo_id) {
            $this->Amc_model->update_work_order($wo_id, $data);
        } else {
            $branch = $this->db->where('branch_id', $this->input->post('branch_id'))->get('branch_master')->row();
            if (!$branch) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Branch selected.']);
                return;
            }
            $data['ref_no']       = $this->Amc_model->generate_wo_ref_no($branch->branch_code);
            $data['created_by']   = $this->session->userdata('user_id');
            $data['created_date'] = date('Y-m-d H:i:s');
            $wo_id = $this->Amc_model->insert_work_order($data);
        }

        $product_ids = $this->input->post('product_id');
        if (!empty($product_ids)) {
            $this->Amc_model->replace_work_order_items($wo_id, $product_ids);
        }

        echo json_encode(['status' => 'success', 'wo_id' => $wo_id]);
    }
	    public function update_status()
    {
        $wo_id  = $this->input->post('wo_id');
        $status = $this->input->post('status');
        $allowed = ['Completed', 'Rejected'];
        if (!in_array($status, $allowed)) {
            echo json_encode(['status' => 'error']); return;
        }
        $this->Amc_model->update_work_order($wo_id, ['order_status' => $status]);
        echo json_encode(['status' => 'success']);
    }

	    public function retrieve_by_ref()
    {
        $ref_no = $this->input->post('ref_no');
        $wo = $this->Amc_model->get_work_order_by_ref($ref_no);
        if (!$wo) { echo json_encode(['status' => 'error']); return; }
        $items = $this->Amc_model->get_work_order_items($wo->wo_id);
        echo json_encode(['status' => 'success', 'wo' => $wo, 'items' => $items]);
    }
	//work order end------------------------------------------------------

	// ===================== PPM VISIT CHECKLIST (NEW) =====================

// Edit this list to match Al Thareeq's actual checklist items
private $default_ppm_checklist = array(
    'Equipment inspected and cleaned',
    'Filters checked / cleaned',
    'Gas pressure / refrigerant level checked',
    'Electrical connections checked',
    'Noise / vibration checked',
    'Overall functioning confirmed OK'
);

function ppm_visit_checklist()
{
    $ppm_detail_id = $this->uri->segment(3);

    $data['title']         = 'PPM Visit Checklist';
    $data['ppm_detail_id'] = $ppm_detail_id;
    $data['visit']         = $this->Amc_model->get_ppm_detail_with_master($ppm_detail_id);
    $data['checklist']     = $this->Amc_model->get_visit_checklist($ppm_detail_id, $this->default_ppm_checklist);
    $data['replacements']  = $this->Amc_model->get_replacements_by_detail($ppm_detail_id);
	$data['main_content']='amc/ppm_visit_checklist.php';
	$this->load->view('includes/template.php',$data);
    //$this->load->view('amc/ppm_visit_checklist.php', $data);
}

function save_visit_checklist()
{
    $ppm_detail_id = $this->input->post('ppm_detail_id');

    $this->Amc_model->save_visit_checklist($ppm_detail_id, $this->input->post());

    echo json_encode(array('status' => 'success'));
}

function add_ppm_replacement()
{
    $ppm_detail_id = $this->input->post('ppm_detail_id');
    $qty   = (float) $this->input->post('qty');
    $price = (float) $this->input->post('unit_price');

    $data = array(
        'ppm_detail_id' => $ppm_detail_id,
        'quote_id'      => $this->input->post('quote_id'),
        'item_name'     => $this->input->post('item_name'),
        'description'   => $this->input->post('description'),
        'qty'           => $qty,
        'unit_price'    => $price,
        'total'         => $qty * $price,
        'status'        => 'Pending',
        'created_by'    => $this->session->userdata('user_id'),
        'created_date'  => date('Y-m-d H:i:s')
    );

    $id = $this->Amc_model->add_ppm_replacement($data);
    echo json_encode(array('status' => 'success', 'replacement_id' => $id));
}

// function prepare_replacement_quotation()
// {
//     $replacement_ids = $this->input->post('replacement_ids'); // array
//     $ppm_detail_id   = $this->input->post('ppm_detail_id');

//     if (empty($replacement_ids) || !is_array($replacement_ids))
//     {
//         echo json_encode(array('status' => 'error', 'msg' => 'No items selected'));
//         return;
//     }

//     $insert_id = $this->Amc_model->create_replacement_quotation($ppm_detail_id, $replacement_ids);

//     if ($insert_id)
//         echo json_encode(array('status' => 'success', 'quote_id' => $insert_id));
//     else
//         echo json_encode(array('status' => 'error', 'msg' => 'Could not create quotation'));
// }

function prepare_replacement_quotation()
{
    $replacement_ids = $this->input->post('replacement_ids'); // array
    $ppm_detail_id   = $this->input->post('ppm_detail_id');

    if (empty($replacement_ids) || !is_array($replacement_ids))
    {
        redirect('AMC/ppm_visit_checklist/'.$ppm_detail_id);
        return;
    }

    $visit = $this->Amc_model->get_ppm_detail_with_master($ppm_detail_id);
    $items = $this->Amc_model->get_replacement_items_by_ids($replacement_ids);

    if (empty($items))
    {
        redirect('AMC/ppm_visit_checklist/'.$ppm_detail_id);
        return;
    }

    $prefill = array(
        'customer_id'     => $visit->customer_id,
        'project_name'    => $visit->project_name,
        'parent_quote_id' => $visit->quote_id,
        'items'           => $items
    );

    $this->session->set_userdata('replacement_quote_prefill', $prefill);

    redirect('AMC/add_direct_quotation');
}
}