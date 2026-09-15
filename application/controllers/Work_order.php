<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Work_order_model');
    }

    public function index($type = 'external')
    {
        $data['title']='Work order';
        $data['wo_type']  = ucfirst($type);
        $data['wo_list']  = $this->Work_order_model->get_work_order_list(ucfirst($type));
        $data['main_content']='work_order/list.php';

		$this->load->view('includes/template.php',$data);        
    }

    public function add($type = 'external')
    {
         $data['title']='Add Work order';
        $data['wo_type'] = ucfirst($type);
        $data['main_content']='work_order/form.php';

		$this->load->view('includes/template.php',$data);
      
    }

    public function edit($wo_id)
    {
        $data['wo']    = $this->Work_order_model->get_work_order($wo_id);
        $data['items'] = $this->Work_order_model->get_work_order_items($wo_id);
        $this->load->view('work_order/form', $data);
    }

    // ---- AJAX: customer auto-fetch ----
    public function customer_lookup()
    {
        $code = $this->input->post('customer_code');
        $cust = $this->Work_order_model->get_customer_by_code($code);
        echo json_encode($cust);
    }

    // ---- AJAX: product search (Select2) ----
    public function product_search()
    {
        $term = $this->input->get('term');
        $products = $this->Work_order_model->search_products($term);
        $results = [];
        foreach ($products as $p) {
            $results[] = ['id' => $p->product_id, 'text' => $p->product_code . ' - ' . $p->product_name];
        }
        echo json_encode(['results' => $results]);
    }

    // ---- AJAX: AMC lookup list ----
    public function amc_lookup()
    {
        $cust_id = $this->input->post('cust_id');
        $contracts = $this->Work_order_model->get_active_amc_contracts($cust_id);
        echo json_encode($contracts);
    }

    // ---- AJAX: AMC contract selected ----
    public function amc_select()
    {
        $invoice_id = $this->input->post('invoice_id');
        $c = $this->Work_order_model->get_amc_contract_detail($invoice_id);
        echo json_encode([
            'amc_invoice_id'       => $c->invoice_id,
            'contract_invoice_ref' => $c->invoice_code,
            'expiry_date'          => $c->amc_end_date
        ]);
    }

    // ---- Save ----
    public function save()
    {
        $wo_id = $this->input->post('wo_id');

        $data = [
            'wo_type'              => $this->input->post('wo_type'),
            'branch_id'            => $this->input->post('branch_id'),
            'ref_date'              => $this->input->post('ref_date'),
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
            $this->Work_order_model->update_work_order($wo_id, $data);
        } else {
            $data['ref_no']       = $this->Work_order_model->generate_ref_no($this->input->post('branch_code'));
            $data['created_by']   = $this->session->userdata('user_id');
            $data['created_date'] = date('Y-m-d H:i:s');
            $wo_id = $this->Work_order_model->insert_work_order($data);
        }

        // items
        $product_ids = $this->input->post('product_id');
        $product_codes = $this->input->post('product_code');
        if (!empty($product_ids)) {
            $items = [];
            foreach ($product_ids as $i => $pid) {
                $items[] = ['wo_id' => $wo_id, 'product_id' => $pid, 'product_code' => $product_codes[$i]];
            }
            $this->Work_order_model->insert_work_order_items($items);
        }

        echo json_encode(['status' => 'success', 'wo_id' => $wo_id]);
    }
}