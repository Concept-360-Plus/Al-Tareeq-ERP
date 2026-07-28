<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('Sales_model');
		
		// Prevent browser caching
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
	}

	

    function validate_credentials()
    {
		$date = date('Y-m-d h:i:s');
		$today=date('Y-m-d');
		
        $this->load->model('Login_model');
        $query = $this->Login_model->validate();
        if($query) 
        {
            foreach($query as $key) 
            {
                $sess_id = $key->user_id.'-'.time();   
                $data = array(
                    'user_id' => $key->user_id,
                    'user_name' => $key->user_name,
                    'employee_id' => $key->employee_id,
                    'is_logged_in' => true,
                );
                $this->session->set_userdata($data); 
                $this->session->sess_regenerate(); 
                $dashboard = $this->Login_model->get_user_dashboard($key->user_id);

                if ($dashboard) {
                    $this->session->set_userdata('dashboard_controller', $dashboard->controller_name);
                }

                redirect('Login/dashboard');
            }   
        }
        else 
        {
           redirect('/');
        }
    }

    function logout() {
        $this->session->sess_destroy();
        $this->session->unset_userdata('logged_in');

        // Prevent back button from showing cached page
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        redirect('Welcome'); // Redirect to login page
    }

    // public function dashboard()
	// {
    //     $data['title'] = 'Dashboard';
    //     // First day of current month
    //     $firstDay = (new DateTime('first day of this month'))->format('Y-m-d');
    //     // Last day of current month
    //     $lastDay = (new DateTime('last day of this month'))->format('Y-m-d');
    //     //$data['enquiry_count'] = $this->Sales_model->get_enquiry_count($firstDay,$lastDay);
    //     //$data['quotation_count'] = $this->Sales_model->get_quotation_count($firstDay,$lastDay);
    //     //$data['aed_invoice_amount'] = $this->Sales_model->get_invoice_amount($firstDay,$lastDay,1);
    //     //$data['usd_invoice_amount'] = $this->Sales_model->get_invoice_amount($firstDay,$lastDay,2);

    //     $this->load->model('Project_model');
    //     $data['overdue_projects'] = $this->Project_model->get_overdue_projects();
    //     $data['overdue_count']    = count($data['overdue_projects']);
    //     $this->load->model('Amc_model');
    //     $data['amc_alerts'] = $this->Amc_model->get_amc_alert(7);
    //     $data['ppm_alerts'] = $this->Amc_model->get_ppm_scheduled_alerts(7);

	// 	$data['main_content'] = 'dashboard.php';
    //     $data['dashboard'] = true;
	// 	$this->load->view('includes/template',$data);
	// }

    public function dashboard()
    {
        $dashboard = $this->session->userdata('dashboard_controller');

        switch ($dashboard)
        {
            case 'purchase_dashboard':
                redirect('Dashboard/purchase_dashboard');
                break;

            case 'accounts_dashboard':
                redirect('Dashboard/accounts_dashboard');
                break;

            case 'inventory_dashboard':
                redirect('Dashboard/inventory_dashboard');
                break;

            case 'hr_dashboard':
                redirect('Dashboard/hr_dashboard');
                break;

            case 'sales_dashboard':
                redirect('Dashboard/sales_dashboard');
                break;

            default:
                $data['title'] = 'Dashboard';
            	$data['main_content'] = 'dashboard.php';
                $data['dashboard'] = true;
	        	$this->load->view('includes/template',$data);
        }
    }
}
