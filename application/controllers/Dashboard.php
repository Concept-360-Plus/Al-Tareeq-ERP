<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function accounts_dashboard()
    {
        $data['title']="Accounts Dashboard";

        // load data

        $data['main_content']="dashboard/account_dashboard";

        $this->load->view('includes/template',$data);
    }

    public function purchase_dashboard()
    {
        $this->load->model('Purchase_model');

        $data['title'] = 'Purchase Dashboard';

        $data['rfq_count']           = $this->Purchase_model->get_rfq_count();
        $data['quotation_count']     = $this->Purchase_model->get_quotation_count();
        $data['po_count']            = $this->Purchase_model->get_po_count();
        $data['grn_count']           = $this->Purchase_model->get_grn_count();

        $data['pending_rfq']         = $this->Purchase_model->get_pending_rfq();
        $data['pending_quotation']   = $this->Purchase_model->get_pending_quotation();
        $data['pending_po']          = $this->Purchase_model->get_pending_po();
        $data['pending_grn']         = $this->Purchase_model->get_pending_grn();

        $data['today_rfq']           = $this->Purchase_model->today_rfq();
        $data['today_quotation']     = $this->Purchase_model->today_quotation();
        $data['today_po']            = $this->Purchase_model->today_po();
        $data['today_grn']           = $this->Purchase_model->today_grn();

        $data['quotation_value']     = $this->Purchase_model->total_quotation_value();
        $data['po_value']            = $this->Purchase_model->total_po_value();
        $data['grn_value']           = $this->Purchase_model->total_grn_value();

        $data['recent_rfq']          = $this->Purchase_model->get_recent_rfq();
        $data['recent_po']           = $this->Purchase_model->get_recent_po();

        $data['top_suppliers']       = $this->Purchase_model->get_top_suppliers();

        $data['main_content'] = 'dashboard/purchase_dashboard';

        $this->load->view('includes/template', $data);
    }

    public function inventory_dashboard()
    {
        $data['title']="Inventory Dashboard";

        $data['main_content']="dashboard/inventory_dashboard";

        $this->load->view('includes/template',$data);
    }

    public function hr_dashboard()
    {
        $data['title']="HR Dashboard";

        $data['main_content']="dashboard/hr_dashboard";

        $this->load->view('includes/template',$data);
    }

    public function sales_dashboard()
    {
        $data['title']="Sales Dashboard";

        $data['main_content']="dashboard/sales_dashboard";

        $this->load->view('includes/template',$data);
    }
}