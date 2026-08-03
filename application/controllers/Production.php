<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('Login/login');
        }

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->load->model('Users_model');
        $this->load->model('Project_model');
        $this->load->model('Production_model');
		$this->load->model('Product_model');
        $this->load->model('Sales_model'); 
        $this->load->model('Company_model');
        $this->load->model('Item_model');
        
    }

    function production()
	{
		$data['title'] = "Production Details";
 		$prifix = 'PD' . date('y') . '';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'p_code', 'project_production', 6) + 1;
		$digit = sprintf("%1$04d", $num);
		$code = $prifix . $digit;
		$data['code'] = $code;
		$data['products'] = $this->Project_model->get_product_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Production_model->get_production_list();
		$data['main_content'] = 'production/production_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_production_list()
	{
		$data['title'] = "Production Details List";
		$data['records'] = $this->Production_model->get_production_list_records();
		$data['main_content'] = 'production/production_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_production_details()
	{
		$data['title'] = " Add Production Details";
		$flag = $this->Production_model->add_production_details();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('production/view_production_list');
		} else {
			$this->session->set_flashdata('warning', 'Report Already Exist');
			redirect('Project/add_work_order');
		}
	}

	function edit_production()
	{
		$data['title'] = " Edit Production Details";
		$id = $this->uri->segment('3');
		$data['products'] = $this->Product_model->get_product_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Production_model->get_production_list();

		$data['records1'] = $this->Production_model->transaction_production($id);
		$data['trans_records'] = $this->Production_model->get_production_tr_by_id_item($id);
		$data['product_route'] = $this->Project_model->get_product_extra_records($id);
		$data['attachment'] = $this->Project_model->get_attachment_records($id);
		$data['records2'] = $this->Production_model->get_wo_trans($id);
		$data['records3'] = $this->Production_model->get_wo_trans1($id);
		$data['main_content'] = 'production/production_edit.php';
		$this->load->view('includes/template', $data);
	}
	function update_production()
	{
		$data['title'] = "Update Production Details";
		$id = $this->input->post('production_id');
		$res = $this->Production_model->update_production_details($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Production/view_production_list');
		}
	}
	function delete_production()
	{
		$id = $this->uri->segment('3');
		$data['user_records'] = $this->Production_model->delete_production_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Production/view_production_list');
	}

	function qc_approve_production()
	{
		$data['title'] = 'QC Approve Production';
		$id = $this->uri->segment('3');
		$approve_id = $this->uri->segment('4');
		$this->load->model('Production_model');
		$this->Production_model->qc_approve_production($id,$approve_id);
		$this->session->set_flashdata('success', 'Record Approved Successfully..');
		redirect('Production/view_production_list');
	}
	function packing_approve_production()
	{
		$data['title'] = 'Packing Approve Production';
		$id = $this->uri->segment('3');

		$approve_id = $this->uri->segment('4');

		$this->load->model('Production_model');
		$this->Production_model->packing_approve_production($id,$approve_id);

		$this->session->set_flashdata('success', 'Record Approved Successfully..');
		redirect('Production/view_production_list');
	}	
	function transport_approve_production()
	{
		$data['title'] = 'Transport Approve Production';
		$id = $this->uri->segment('3');
		$approve_id = $this->uri->segment('4');
		$this->Production_model->transport_approve_production($id,$approve_id);
		$this->session->set_flashdata('success', 'Record Approved Successfully..');
		redirect('Production/view_production_list');
	}



    

}
