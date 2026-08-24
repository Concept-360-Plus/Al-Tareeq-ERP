<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Reports extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->model('Setup_model');
    $this->load->model('Reports_model');
  }

  ///////////////////// PURCHASE REQUEST REPORT START /////////////////////

  public function purchase_request_report()
  {
    $data['from'] = date('Y-m-01');
    $data['to']   = date('Y-m-d');
    $data['title'] = 'Purchase Request Report';
    $data['records'] = array();
    $data['supplier_id'] = '';
    $data['created_by']  = '';

    $data['user_list'] = $this->Setup_model->get_active_user_list_with_employee_code();
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['main_content'] = 'Reports/Purchase/purchase_request_report.php';

    $this->load->view('includes/template.php', $data);
  }


  public function get_purchase_request_report()
  {
    $data['from'] = $this->input->post('from_date');
    $data['to']   = $this->input->post('to_date');
    $data['title'] = 'Purchase Request Report';
    $data['created_by'] = $this->input->post('created_by');
    $data['supplier_id'] = $this->input->post('supplier_id');

    $data['user_list'] = $this->Setup_model->get_active_user_list_with_employee_code();
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['records'] = $this->Reports_model->get_purchase_request_report_records();
    $data['main_content'] = 'Reports/Purchase/purchase_request_report.php';

    $this->load->view('includes/template.php', $data);
  }


  public function print_purchase_request_report()
  {
    $from_date  = $this->input->get('from_date');
    $to_date    = $this->input->get('to_date');
    $supplier_id = $this->input->get('supplier_id');
    $created_by  = $this->input->get('created_by');

    $data['from'] = $from_date;
    $data['to'] = $to_date;

    $data['supplier_id'] = $supplier_id;
    $data['created_by'] = $created_by;


    $data['records'] = $this->Reports_model->get_purchase_request_report_records();

    $this->load->model('Company_model');

    $branch_id = 1;

    $branch = $this->Setup_model->get_branch_by_id($branch_id);

    $data['headerPath'] = !empty($branch->branch_header)
      ? base_url(ltrim($branch->branch_header, '/'))
      : '';

    $this->load->view(
      'Reports/Purchase/Print/print_purchase_request_report',
      $data
    );
  }

  public function export_purchase_request_excel()
  {
    $data['from'] = $this->input->get('from_date');
    $data['to'] = $this->input->get('to_date');
    $data['supplier_id'] = $this->input->get('supplier_id');
    $data['created_by'] = $this->input->get('created_by');
    $data['records'] = $this->Reports_model->get_purchase_request_report_records();
    $filename = 'Purchase_Request_Report_' . date('Y-m-d') . '.xls';

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    header('Pragma: no-cache');
    header('Expires: 0');

    $this->load->view(
      'Reports/Purchase/Export/export_purchase_request_report',
      $data
    );
  }
  ///////////////////// PURCHASE REQUEST REPORT END /////////////////////


  ///////////////  RFQ Report ////////////////////
  function rfq_report()
  {
    $data['from'] = date('Y-m-01'); // First day of current month
    $data['to']   = date('Y-m-d');  // Today's date
    $data['status'] = "";
    $data['title'] = "Direct RFQ Report";
    $data['records'] = array();
    $data['supplier_id'] = "";
    $data['created_by']  = "";
    $data['user_list'] = $this->Setup_model->get_active_user_list_with_employee_code();
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['main_content'] = 'Reports/Purchase/rfq_report.php';
    $this->load->view('includes/template.php', $data);
  }
  function get_rfq_report()
  {
    $data['from'] = $this->input->post('from_date');
    $data['to'] = $this->input->post('to_date');
    $data['title'] = "Direct RFQ Report";
    $data['created_by'] = $this->input->post('created_by');
    $data['supplier_id'] = $this->input->post('supplier_id');
    $data['user_list'] = $this->Setup_model->get_active_user_list_with_employee_code();
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['records'] = $this->Reports_model->get_rfq_report_records();
    $data['main_content'] = 'Reports/Purchase/rfq_report.php';
    $this->load->view('includes/template.php', $data);
  }
  public function print_rfq_report()
  {
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $supplier_id = $this->input->get('supplier_id');
    $created_by = $this->input->get('created_by');
    $data['from'] = $from_date;
    $data['to'] = $to_date;
    $data['supplier_id'] = $supplier_id;
    $data['created_by'] = $created_by;
    // Fetch filtered records again
    $data['records'] = $this->Reports_model->get_rfq_report_records();

    $data['supplier_id'] = $supplier_id;
    $this->load->model('Company_model');

    $branch_id = 1; // replace with dynamic branch_id if available
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['headerPath'] = !empty($branch->branch_header) ? base_url(ltrim($branch->branch_header, '/')) : '';

    $this->load->view('Reports/Purchase/Print/print_rfq_report', $data);
  }

  public function export_rfq_excel()
  {
    $data['from'] = $this->input->get('from_date');
    $data['to'] = $this->input->get('to_date');
    $data['supplier_id'] = $this->input->get('supplier_id');
    $data['created_by'] = $this->input->get('created_by');

    $data['records'] = $this->Reports_model->get_rfq_report_records();

    $filename = 'RFQ_Report_' . date('Y-m-d') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $this->load->view('Reports/Purchase/Export/export_rfq_report', $data);
  }


  ///////////////  PO Report ////////////////////
  function po_report()
  {
    $data['from'] = date('Y-m-01');
    $data['to']   = date('Y-m-d');
    $data['status'] = "";
    $data['title'] = "Purchase Order Report";
    $data['supplier_id'] = "";
    $data['created_by'] = "";
    $data['report_type'] = "";
    $data['po_type']     = "";
    $data['records'] = array();
    $data['user_list'] = $this->Setup_model->get_active_user_list_with_employee_code();
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['main_content'] = 'Reports/Purchase/po_report.php';
    $this->load->view('includes/template.php', $data);
  }

  function get_po_report()
  {
    $data['from'] = $this->input->post('from_date');
    $data['to'] = $this->input->post('to_date');
    $data['title'] = "Purchase Order Report";
    $data['created_by'] = $this->input->post('created_by');
    $data['supplier_id'] = $this->input->post('supplier_id');

    $data['report_type'] = $this->input->post('report_type');
    $data['po_type'] = $this->input->post('po_type');

    $data['user_list'] = $this->Setup_model->get_active_user_list_with_employee_code();
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['records'] = $this->Reports_model->get_po_report_records(
      $data['from'],
      $data['to'],
      $data['supplier_id'],
      $data['created_by'],
      $data['report_type'],
      $data['po_type']
    );
    $data['main_content'] = 'Reports/Purchase/po_report.php';
    $this->load->view('includes/template.php', $data);
  }

  // public function print_po_report()
  // {
  //   $from_date = $this->input->get('from_date');
  //   $to_date = $this->input->get('to_date');
  //   $supplier_id = $this->input->get('supplier_id');
  //   $created_by = $this->input->get('created_by');
  //   $data['from'] = $from_date;
  //   $data['to'] = $to_date;
  //   $data['supplier_id'] = $supplier_id;
  //   $data['created_by'] = $created_by;
  //   // Fetch filtered records again
  //   $data['records'] = $this->Reports_model->get_po_report_records();

  //   $data['supplier_id'] = $supplier_id;

  //   $this->load->model('Company_model');

  //   $branch_id = 8; // replace with dynamic branch_id if available
  //   $branch = $this->Setup_model->get_branch_by_id($branch_id);
  //   $data['headerPath'] = !empty($branch->branch_header) ? base_url(ltrim($branch->branch_header, '/')) : '';


  //   $this->load->view('Reports/Purchase/Print/print_po_report', $data);
  // }

  public function print_po_report()
  {
    $from_date   = $this->input->get('from_date');
    $to_date     = $this->input->get('to_date');
    $supplier_id = $this->input->get('supplier_id');
    $created_by  = $this->input->get('created_by');
    $report_type = $this->input->get('report_type');
    $po_type     = $this->input->get('po_type');

    $data['records'] = $this->Reports_model->get_po_report_records(
      $from_date,
      $to_date,
      $supplier_id,
      $created_by,
      $report_type,
      $po_type
    );

    $data['from'] = $from_date;
    $data['to']   = $to_date;

    $this->load->view(
      'Reports/Purchase/Print/print_po_report',
      $data
    );
  }

  public function export_po_excel()
  {
    $data['from'] = $this->input->get('from_date');
    $data['to'] = $this->input->get('to_date');
    $data['supplier_id'] = $this->input->get('supplier_id');
    $data['created_by'] = $this->input->get('created_by');
    $data['records'] = $this->Reports_model->get_po_report_records();
    $data['branch_name'] = '-';
    if (!empty($data['records'])) {
      $branch_id =
        $data['records'][0]->branch_id;
      if (!empty($branch_id)) {
        $branch =
          $this->Setup_model
          ->get_branch_by_id($branch_id);
        if (!empty($branch)) {
          $data['branch_name'] =
            $branch->branch_name;
        }
      }
    }
    $data['company_name'] = $this->Setup_model->get_company_details();
    $filename = 'Purchase_Order_Report_' . date('Y-m-d') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $this->load->view('Reports/Purchase/Export/export_po_report', $data);
  }

  ///////////////  GRN Report ////////////////////
  function grn_report()
  {
    $data['from'] = date('01-m-Y');
    $data['to'] = date('d-m-Y');
    $data['status'] = "";
    $data['title'] = "Goods Received Note Report";
    $data['supplier_id'] = "";
    $data['records'] = array();
    $data['user_list'] = $this->Setup_model->get_active_user_list();
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['main_content'] = 'Reports/Purchase/grn_report.php';
    $this->load->view('includes/template.php', $data);
  }
  function get_grn_report()
  {
    $data['from'] = $this->input->post('from_date');
    $data['to'] = $this->input->post('to_date');
    $data['title'] = "Goods Received Note Report";
    $data['created_by'] = $this->input->post('created_by');
    $data['supplier_id'] = $this->input->post('supplier_id');

    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['records'] = $this->Reports_model->get_grn_report_records();
    $data['main_content'] = 'Reports/Purchase/grn_report.php';
    $this->load->view('includes/template.php', $data);
  }
  public function print_grn_report()
  {
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $supplier_id = $this->input->get('supplier_id');
    $data['from'] = $from_date;
    $data['to'] = $to_date;
    $data['supplier_id'] = $supplier_id;
    // Fetch filtered records again
    $data['records'] = $this->Reports_model->get_grn_report_records();

    $data['supplier_id'] = $supplier_id;

    $this->load->model('Company_model');

    $branch_id = 1; // replace with dynamic branch_id if available
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['headerPath'] = !empty($branch->branch_header) ? base_url(ltrim($branch->branch_header, '/')) : '';


    $this->load->view('Reports/Purchase/Print/print_grn_report', $data);
  }

  public function enquiry_report()
  {
    $user = $this->session->userdata('user_id');
    if (!has_view_access($user, 'Reports/enquiry_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
    } else {
      $data['title'] = 'Enquiry Report';
      $this->load->model('Sales_model');

      $data['from_date'] = $_POST['from_date'] ?? date('Y-m-d');
      $data['to_date'] = $_POST['to_date'] ?? date('Y-m-d');
      $data['sales_person'] = $_POST['sales_person'] ?? '';
      $data['customer_id'] = $_POST['customer'] ?? '';
      $print = $_POST['print_option'] ?? 0;
      //echo $print;exit;
      $data['all_users'] = $this->Setup_model->get_active_user_list();
      $data['all_customers'] = $this->Setup_model->get_all_customer_list();

      // Get the logged-in user ID from session
      $data['logged_in_user_id'] = $this->session->userdata('user_id');

      // Define who can view all salespersons
      $data['admin_users'] = [1, 6, 9, 10, 11];

      if (isset($_POST['from_date'])) {
        $data['records'] = $this->Reports_model->get_enquiry_report();
      }
      if ($print == 0)
        $data['main_content'] = 'Reports/Sales/enquiry_report.php';
    }
    if ($print == 0)
      $this->load->view('includes/template', $data);
    else
      $this->load->view('Reports/Sales/print/enquiry_report.php', $data);
  }

  //////////////////// PURCHASE RETURN REPORT /////////////////////

  public function purchase_return_report()
  {
    $data['from'] = date('01-m-Y');
    $data['to']   = date('d-m-Y');

    $data['supplier_id'] = '';
    $data['title'] = "Purchase Return Report";
    $data['records'] = array();
    $this->load->model('Setup_model');

    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();
    $data['main_content'] = 'Reports/Purchase/purchase_return_report.php';

    $this->load->view('includes/template.php', $data);
  }


  public function get_purchase_return_report()
  {
    $data['from'] = $this->input->post('from_date');
    $data['to'] = $this->input->post('to_date');
    $data['supplier_id'] = $this->input->post('supplier_id');
    $data['title'] = "Purchase Return Report";

    $this->load->model('Setup_model');
    $data['supplier_records'] = $this->Setup_model->get_active_supplier_list();

    $this->load->model('Reports_model');
    $data['records'] = $this->Reports_model->get_purchase_return_report_records(
      $data['from'],
      $data['to'],
      $data['supplier_id']
    );


    $data['main_content'] = 'Reports/Purchase/purchase_return_report.php';

    $this->load->view('includes/template.php', $data);
  }


  public function print_purchase_return_report()
  {
    $from_date =
      $this->input->get('from_date');

    $to_date =
      $this->input->get('to_date');

    $supplier_id =
      $this->input->get('supplier_id');


    $data['from'] =
      $from_date;

    $data['to'] =
      $to_date;

    $data['supplier_id'] =
      $supplier_id;

    $data['title'] =
      "Purchase Return Report";


    $this->load->model('Reports_model');

    $data['records'] =
      $this->Reports_model->get_purchase_return_report_records(
        $from_date,
        $to_date,
        $supplier_id
      );


    $this->load->model('Setup_model');

    $branch_id = 1;

    $branch =
      $this->Setup_model->get_branch_by_id(
        $branch_id
      );


    $data['headerPath'] =
      !empty($branch->branch_header)
      ? base_url(
        ltrim(
          $branch->branch_header,
          '/'
        )
      )
      : '';


    $this->load->view(
      'Reports/Purchase/Print/print_purchase_return_report',
      $data
    );
  }


  public function export_purchase_return_excel()
  {
    $from_date =
      $this->input->get('from_date');

    $to_date =
      $this->input->get('to_date');

    $supplier_id =
      $this->input->get('supplier_id');


    $data['from'] =
      $from_date;

    $data['to'] =
      $to_date;

    $data['supplier_id'] =
      $supplier_id;

    $data['title'] =
      "Purchase Return Report";


    $this->load->model('Reports_model');

    $data['records'] =
      $this->Reports_model->get_purchase_return_report_records(
        $from_date,
        $to_date,
        $supplier_id
      );


    $filename =
      'Purchase_Return_Report_' .
      date('Y-m-d') .
      '.xls';


    header(
      'Content-Type: application/vnd.ms-excel'
    );

    header(
      'Content-Disposition: attachment; filename="' .
        $filename .
        '"'
    );

    header('Pragma: no-cache');

    header('Expires: 0');


    $this->load->view(
      'Reports/Purchase/Export/export_purchase_return_report',
      $data
    );
  }

  ///////////////////QUOTATION REPORT////////////////////
  public function quotation_report()
  {
    $user = $this->session->userdata('user_id');
    if (!has_view_access($user, 'Reports/quotation_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
    } else {
      $data['title'] = 'Quotation Report';
      $this->load->model('Sales_model');
      $this->load->model('Setup_model');
      $data['logged_in_user_id'] = $this->session->userdata('user_id');
      $data['admin_users'] = [14, 15, 16, 17];

      $data['from_date'] = $_POST['from_date'] ?? date('Y-m-d');
      $data['to_date'] = $_POST['to_date'] ?? date('Y-m-d');
      $data['sales_person'] = $_POST['sales_person'] ?? '';
      $data['status'] = $_POST['status'] ?? '123';
      $data['customer_id'] = $_POST['customer'] ?? '';

      $data['all_users'] = $this->Setup_model->get_active_user_list();
      $data['all_customers'] = $this->Setup_model->get_all_customer_list();


      if (isset($_POST['from_date'])) {
        $data['records'] = $this->Reports_model->get_quotation_report();
      }

      $data['main_content'] = 'Reports/Sales/quotation_report.php';
    }
    $this->load->view('includes/template', $data);
  }


  public function custom_quotation_report()
  {
    $user = $this->session->userdata('user_id');
    if (!has_view_access($user, 'Reports/custom_quotation_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
    } else {
      $data['title'] = 'Quotation Report';
      $this->load->model('Sales_model');
      $this->load->model('Setup_model');

      $data['quotation_id'] = $_POST['quotation_id'] ?? '';

      $data['approved_quotations'] = $this->Sales_model->get_approved_quotation_list();


      if (isset($_POST['quotation_id'])) {
        $data['records'] = $this->Reports_model->custom_quotation_report();
      }

      $data['main_content'] = 'Reports/Sales/custom_quotation_report.php';
    }
    $this->load->view('includes/template', $data);
  }

  ///////////////////PI REPORT////////////////////
  public function pi_report()
  {
    $user = $this->session->userdata('user_id');
    if (!has_view_access($user, 'Reports/pi_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
    } else {
      $data['title'] = 'Sales order Report';
      $this->load->model('Sales_model');
      $this->load->model('Setup_model');

      $data['from_date'] = $_POST['from_date'] ?? date('Y-m-d');
      $data['to_date'] = $_POST['to_date'] ?? date('Y-m-d');
      $data['sales_person'] = $_POST['sales_person'] ?? '';
      $data['status'] = $_POST['status'] ?? '';
      $data['quotation'] = $_POST['quotation'] ?? '';

      $data['all_users'] = $this->Setup_model->get_active_user_list();
      $data['all_customers'] = $this->Setup_model->get_all_customer_list();
      // $data['approved_quotations'] = $this->Sales_model->get_approved_quotation_list();


      if (isset($_POST['from_date'])) {
        $data['records'] = $this->Reports_model->pi_report();
      }

      $data['main_content'] = 'Reports/Sales/pi_report.php';
    }
    $this->load->view('includes/template', $data);
  }

  ///////////////////INVOICE REPORT////////////////////
  public function invoice_report()
  {

    $user = $this->session->userdata('user_id');
    if (!has_view_access($user, 'Reports/invoice_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
    } else {
      $data['title'] = 'Invoice Report';
      $this->load->model('Item_model');
      $data['from_date'] = $_POST['from_date'] ?? date('Y-m-d');
      $data['to_date'] = $_POST['to_date'] ?? date('Y-m-d');

      $data['customer_id'] = $_POST['customer'] ?? '';
      $data['status'] = $_POST['status'] ?? '123';
      //echo $data['status'];exit;
      $data['all_customers'] = $this->Setup_model->get_all_customer_list();
      if (isset($_POST['from_date'])) {
        $data['records'] = $this->Sales_order_model->list_all_invoices();
      }

      $data['main_content'] = 'Reports/Sales/invoice_report.php';
    }
    $this->load->view('includes/template', $data);
  }

  public function custom_invoice_report()
  {
    $user = $this->session->userdata('user_id');

    // Access control
    if (!has_view_access($user, 'Reports/custom_invoice_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
      $this->load->view('includes/template', $data);
      return;
    }

    $data['title'] = 'Invoice Report';

    // Load required models ONLY
    $this->load->model('Sales_order_model');
    $this->load->model('Setup_model');

    // Filters
    $data['from_date']    = $this->input->post('from_date') ?? date('Y-m-d');
    $data['to_date']      = $this->input->post('to_date') ?? date('Y-m-d');
    $data['sales_person'] = $this->input->post('sales_person') ?? '';
    $data['customer_id']  = $this->input->post('customer') ?? '';

    // Dropdown data
    $data['all_users']     = $this->Setup_model->get_active_user_list();
    $data['all_customers'] = $this->Setup_model->get_all_customer_list();

    // Fetch records ONLY after submit
    if ($this->input->post()) {
      $data['records'] = $this->Sales_order_model->get_filtered_invoices(
        $data['from_date'],
        $data['to_date'],
        $data['customer_id'],
        $data['sales_person']
      );
    } else {
      $data['records'] = [];
    }

    // Load view
    $data['main_content'] = 'Reports/Sales/custom_invoice_report.php';
    $this->load->view('includes/template', $data);
  }

  public function print_custom_invoice_report()
  {
    $user = $this->session->userdata('user_id');

    if (!has_view_access($user, 'Reports/custom_invoice_report')) {
      echo "Access Denied";
      return;
    }

    $this->load->model('Sales_order_model');
    $this->load->model('Setup_model');

    // Get parameters from GET
    $from_date    = $_GET['from_date'] ?? date('Y-m-d');
    $to_date      = $_GET['to_date'] ?? date('Y-m-d');
    $sales_person = $_GET['sales_person'] ?? '';
    $customer_id  = $_GET['customer'] ?? '';

    // Fetch filtered invoices
    $data['records'] = $this->Sales_order_model->get_filtered_invoices(
      $from_date,
      $to_date,
      $customer_id,
      $sales_person
    );

    $data['from_date'] = $from_date;
    $data['to_date'] = $to_date;
    $this->load->model('Company_model');

    $branch_id = 1; // replace with dynamic branch_id if available
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['headerPath'] = !empty($branch->branch_header) ? base_url(ltrim($branch->branch_header, '/')) : '';

    // Load print view
    $this->load->view('Reports/Sales/print/custom_invoice_report_print', $data);
  }

  public function delivery_report()
  {
    $user = $this->session->userdata('user_id');
    if (!has_view_access($user, 'Reports/delivery_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
    } else {
      $data['title'] = 'Delivery Note Report';
      $this->load->model('Item_model');

      // Get filter values
      $from_date = $_POST['from_date'] ?? date('Y-m-d');
      $to_date   = $_POST['to_date'] ?? date('Y-m-d');
      $customer  = $_POST['customer'] ?? '';
      $status    = $_POST['status'] ?? '123';

      $data['from_date'] = $from_date;
      $data['to_date']   = $to_date;
      $data['customer_id'] = $customer;
      $data['status']    = $status;

      $data['all_customers'] = $this->Setup_model->get_all_customer_list();

      // Pass filter values to the model
      if (isset($_POST['from_date'])) {
        $data['records'] = $this->Reports_model->delivery_report();
      }

      $data['main_content'] = 'Reports/Sales/delivery_report.php';
    }

    $this->load->view('includes/template', $data);
  }


  public function print_enquiry_report()
  {
    $user = $this->session->userdata('user_id');

    $data['title'] = 'Enquiry Report';
    $this->load->model('Sales_model');
    $this->load->model('Company_model'); // to get branch header

    $data['from_date'] = $_GET['from_date'] ?? date('Y-m-d');
    $data['to_date'] = $_GET['to_date'] ?? date('Y-m-d');
    $data['sales_person'] = $_GET['sales_person'] ?? '';
    $data['customer_id'] = $_GET['customer'] ?? '';

    // Get enquiry records
    $data['records'] = $this->Reports_model->print_enquiry_report();

    // Example: get default branch header
    // If you have a branch_id from session or user, use it instead
    $branch_id = 1; // replace with dynamic branch_id if available
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['headerPath'] = !empty($branch->branch_header) ? base_url(ltrim($branch->branch_header, '/')) : '';

    // Log for debugging
    log_message('info', 'Enquiry Report Data: ' . json_encode($data['records']));
    log_message('info', 'Header Path: ' . $data['headerPath']);

    // Load view
    $this->load->view('Reports/Sales/print/enquiry_report', $data);
  }

  public function print_quotation_report()
  {
    $user = $this->session->userdata('user_id');

    if (!has_view_access($user, 'Reports/quotation_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
      $this->load->view('includes/template', $data);
      return;
    }

    $this->load->model('Reports_model');
    $this->load->model('Setup_model');
    $this->load->model('Company_model');

    $filters = [
      'from_date'    => $this->input->get('from_date', true),
      'to_date'      => $this->input->get('to_date', true),
      'customer'     => $this->input->get('customer', true),
      'status'       => $this->input->get('status', true),
      'sales_person' => $this->input->get('sales_person', true),
    ];

    $data['records'] = $this->Reports_model->get_print_quotation_report($filters);

    $data['all_users']     = $this->Setup_model->get_active_user_list();
    $data['all_customers'] = $this->Setup_model->get_all_customer_list();

    $branch_id = 1; // replace with dynamic branch_id if available
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['headerPath'] = !empty($branch->branch_header) ? base_url(ltrim($branch->branch_header, '/')) : '';

    $data['title'] = 'Quotation Report';

    $this->load->view('Reports/Sales/print/quotation_report.php', $data);
  }

  public function print_pi_report()
  {
    $user = $this->session->userdata('user_id');
    if (!has_view_access($user, 'Reports/pi_report')) {
      $data['title'] = 'Access Denied';
      $data['main_content'] = 'errors/access_control.php';
    } else {
      $data['title'] = 'Sales order Report';
      $this->load->model('Sales_model');
      $this->load->model('Setup_model');

      $data['from_date'] = $_POST['from_date'] ?? date('Y-m-d');
      $data['to_date'] = $_POST['to_date'] ?? date('Y-m-d');
      $data['sales_person'] = $_POST['sales_person'] ?? '';
      $data['status'] = $_POST['status'] ?? '';
      $data['quotation'] = $_POST['quotation'] ?? '';

      $data['all_users'] = $this->Setup_model->get_active_user_list();
      $data['all_customers'] = $this->Setup_model->get_all_customer_list();
      // $data['approved_quotations'] = $this->Sales_model->get_approved_quotation_list();



      $data['records'] = $this->Reports_model->print_pi_report();
      $this->load->model('Company_model');

      $branch_id = 1; // replace with dynamic branch_id if available
      $branch = $this->Setup_model->get_branch_by_id($branch_id);
      $data['headerPath'] = !empty($branch->branch_header) ? base_url(ltrim($branch->branch_header, '/')) : '';


      $this->load->view('Reports/Sales/print/pi_report.php', $data);
    }
  }

  ///////////////////STOCK INVENTORY REPORT////////////////////
  function stock_inventory_report()
  {
    $data['title'] = 'Stock Inventory Report';

    // Empty filters when opening the report
    $data['warehouse_id'] = '';
    $data['store_id']     = '';
    $data['product_id']   = '';

    $this->load->model('Stock_model');

    // Product dropdown
    $data['products'] =
      $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');

    // Warehouse dropdown
    $data['warehouse_records'] =
      $this->Setup_model->get_warehouse_list();

    // Do not load stock initially
    $data['records'] = array();

    $data['main_content'] =
      'Reports/Stock/stock_inventory_report.php';

    $this->load->view(
      'includes/template.php',
      $data
    );
  }

  function get_stock_inventory_report()
  {
    $data['title'] = 'Stock Inventory Report';
    $data['warehouse_id'] = $this->input->post('warehouse_id');
    $data['store_id']     = $this->input->post('store_id');
    $data['product_id']   = $this->input->post('product_id');

    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');
    $data['warehouse_records'] = $this->Setup_model->get_warehouse_list();

    $data['records'] = $this->Stock_model->get_stock_inventory_report();

    $data['main_content'] = 'Reports/Stock/stock_inventory_report.php';
    $this->load->view('includes/template.php', $data);
  }

  function print_stock_inventory_report()
  {
    // =====================================================
    // LOAD MODELS
    // =====================================================

    $this->load->model('Setup_model');
    $this->load->model('Stock_Model');


    // =====================================================
    // FILTERS
    // =====================================================

    $data['title'] =
      'Stock Inventory Report';

    $data['warehouse_id'] =
      $this->input->post('warehouse_id');

    $data['store_id'] =
      $this->input->post('store_id');

    $data['product_id'] =
      $this->input->post('product_id');


    // =====================================================
    // COMPANY
    // =====================================================

    $data['comapny_records'] =
      $this->Setup_model
      ->get_company_master_list();


    // =====================================================
    // WAREHOUSE NAME
    // =====================================================

    $data['warehouse_name'] =
      'All Warehouses';

    if (!empty($data['warehouse_id'])) {

      $warehouse =
        $this->db
        ->where(
          'warehouse_id',
          $data['warehouse_id']
        )
        ->get('warehouse_master')
        ->row();

      if (!empty($warehouse)) {

        $data['warehouse_name'] =
          $warehouse->warehouse_name;
      }
    }


    // =====================================================
    // STORE NAME
    // =====================================================

    $data['store_name'] =
      'All Stores';

    if (!empty($data['store_id'])) {

      $store =
        $this->db
        ->where(
          'store_id',
          $data['store_id']
        )
        ->get('store_master')
        ->row();

      if (!empty($store)) {

        $data['store_name'] =
          $store->store_name;
      }
    }


    // =====================================================
    // PRODUCT NAME
    // =====================================================

    $data['product_name'] =
      'All Products';

    if (!empty($data['product_id'])) {

      $product =
        $this->db
        ->where(
          'product_id',
          $data['product_id']
        )
        ->get('item_master')
        ->row();

      if (!empty($product)) {

        $data['product_name'] =
          $product->product_name;
      }
    }


    // =====================================================
    // PREPARED BY
    // =====================================================

    $data['prepared_by'] =
      $this->session->userdata('user_name');

    if (empty($data['prepared_by'])) {

      $data['prepared_by'] =
        'Admin';
    }


    // =====================================================
    // STOCK RECORDS
    // =====================================================

    $data['records'] =
      $this->Stock_Model
      ->get_stock_inventory_report();


    // =====================================================
    // LOAD PRINT VIEW
    // =====================================================

    $this->load->view(
      'Print/print_stock_inventory_report.php',
      $data
    );
  }

  public function export_stock_inventory_report()
  {
    $this->load->model('Setup_model');
    $this->load->model('Stock_model');

    $data['title']        = 'Stock Inventory Report';
    $data['warehouse_id'] = $this->input->post('warehouse_id');
    $data['store_id']     = $this->input->post('store_id');
    $data['product_id']   = $this->input->post('product_id');

    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }

    $data['branch_name'] = '';
    $branch_id = 8;
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    if (!empty($branch)) {
      $data['branch_name'] = $branch->branch_name ?? '';
    }

    $data['warehouse_name'] = '';
    if (!empty($data['warehouse_id'])) {
      $warehouse = $this->db->where('warehouse_id', $data['warehouse_id'])->get('warehouse_master')->row();
      if (!empty($warehouse)) {
        $data['warehouse_name'] = $warehouse->warehouse_name ?? '';
      }
    }

    $data['store_name'] = '';
    if (!empty($data['store_id'])) {
      $store = $this->db
        ->where(
          'store_id',
          $data['store_id']
        )
        ->get('store_master')
        ->row();

      if (!empty($store)) {
        $data['store_name'] =
          $store->store_name ?? '';
      }
    }


    $data['product_name'] = 'All Products';
    if (!empty($data['product_id'])) {
      $product = $this->db
        ->where(
          'product_id',
          $data['product_id']
        )
        ->get('item_master')
        ->row();

      if (!empty($product)) {
        $data['product_name'] =
          $product->product_name ?? '';
      }
    }

    $data['records'] = $this->Stock_model->get_stock_inventory_report();
    $data['prepared_by'] = 'Admin';
    $user_id = $this->session->userdata('user_id');

    if (!empty($user_id)) {
      $user = $this->db
        ->where(
          'user_id',
          $user_id
        )
        ->get('users')
        ->row();

      if (!empty($user)) {
        $data['prepared_by'] =
          $user->user_name ?? 'Admin';
      }
    }

    $filename = 'Stock_Inventory_Report_' . date('Y-m-d') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $this->load->view('Reports/Stock/Export/export_stock_inventory_report', $data);
  }

  /////////////////// STOCK MOVEMENT REPORT ////////////////////

  function stock_movement_report()
  {
    $data['title'] = 'Stock Movement Report';

    $data['from']          = date('Y-m-01');
    $data['to']            = date('Y-m-d');
    $data['warehouse_id']  = '';
    $data['store_id']      = '';
    $data['product_id']    = '';
    $data['movement_type'] = '';

    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');
    $data['warehouse_records'] = $this->Setup_model->get_warehouse_list();

    $data['records'] = array();
    $data['main_content'] = 'Reports/Stock/stock_movement_report.php';

    $this->load->view('includes/template.php', $data);
  }

  function get_stock_movement_report()
  {
    $data['title'] = 'Stock Movement Report';

    $data['from'] = $this->input->post('from_date');
    $data['to'] = $this->input->post('to_date');
    $data['warehouse_id'] = $this->input->post('warehouse_id');
    $data['store_id'] = $this->input->post('store_id');
    $data['product_id'] = $this->input->post('product_id');
    $data['movement_type'] = $this->input->post('movement_type');

    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');
    $data['warehouse_records'] = $this->Setup_model->get_warehouse_list();

    $data['records'] = $this->Reports_model->get_stock_movement_report();

    $data['main_content'] = 'Reports/Stock/stock_movement_report.php';
    $this->load->view('includes/template.php', $data);
  }

  public function print_stock_movement_report()
  {
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $warehouse_id = $this->input->get('warehouse_id');
    $store_id = $this->input->get('store_id');
    $product_id = $this->input->get('product_id');
    $movement_type = $this->input->get('movement_type');

    $data['title'] = 'Stock Movement Report';
    $data['from'] = $from_date;
    $data['to'] = $to_date;
    $data['warehouse_id'] = $warehouse_id;
    $data['store_id'] = $store_id;
    $data['product_id'] = $product_id;
    $data['movement_type'] = $movement_type;

    $this->load->model('Reports_model');

    $data['records'] =
      $this->Reports_model->get_stock_movement_report(
        $from_date,
        $to_date,
        $warehouse_id,
        $store_id,
        $product_id,
        $movement_type
      );

    $this->load->model('Setup_model');

    $branch_id = 1;

    $branch =  $this->Setup_model->get_branch_by_id($branch_id);

    $data['headerPath'] =
      !empty($branch->branch_header)
      ? base_url(
        ltrim(
          $branch->branch_header,
          '/'
        )
      )
      : '';

    $this->load->view('Reports/Stock/Print/print_stock_movement_report', $data);
  }

  public function export_stock_movement_excel()
  {
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $warehouse_id = $this->input->get('warehouse_id');
    $store_id = $this->input->get('store_id');
    $product_id = $this->input->get('product_id');
    $movement_type = $this->input->get('movement_type');

    $data['title'] = 'Stock Movement Report';
    $data['from'] = $from_date;
    $data['to'] = $to_date;
    $data['warehouse_id'] = $warehouse_id;
    $data['store_id'] = $store_id;
    $data['product_id'] = $product_id;
    $data['movement_type'] = $movement_type;

    $this->load->model('Reports_model');
    $data['records'] = $this->Reports_model->get_stock_movement_report(
      $from_date,
      $to_date,
      $warehouse_id,
      $store_id,
      $product_id,
      $movement_type
    );

    $filename = 'Stock_Movement_Report_' . date('Y-m-d') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $this->load->view(
      'Reports/Stock/Export/export_stock_movement_report',
      $data
    );
  }

  /////////////////// STOCK LEDGER REPORT ////////////////////

  function stock_ledger_report()
  {
    $data['title'] = 'Stock Ledger Report';

    $data['from'] = date('Y-m-01');
    $data['to']   = date('Y-m-d');

    $data['warehouse_id'] = '';
    $data['store_id']     = '';
    $data['product_id']   = '';

    // Product dropdown
    $this->load->model('Stock_model');

    $data['products'] =
      $this->Stock_model->get_stock_code_list();

    // Warehouse dropdown
    $this->load->model('Setup_model');

    $data['warehouse_records'] =
      $this->Setup_model->get_warehouse_list();

    // Empty records initially
    $data['records'] = array();

    $data['main_content'] =
      'Reports/Stock/stock_ledger_report.php';

    $this->load->view(
      'includes/template.php',
      $data
    );
  }


  function get_stock_ledger_report()
  {
    $data['title'] = 'Stock Ledger Report';

    $data['from'] =
      $this->input->post('from_date');

    $data['to'] =
      $this->input->post('to_date');

    $data['warehouse_id'] =
      $this->input->post('warehouse_id');

    $data['store_id'] =
      $this->input->post('store_id');

    $data['product_id'] =
      $this->input->post('product_id');

    // Dropdown data
    $this->load->model('Stock_model');

    $data['products'] =
      $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');

    $data['warehouse_records'] =
      $this->Setup_model->get_warehouse_list();

    // Ledger records
    $data['records'] =
      $this->Reports_model->get_stock_ledger_report(
        $data['from'],
        $data['to'],
        $data['warehouse_id'],
        $data['store_id'],
        $data['product_id']
      );

    $data['main_content'] =
      'Reports/Stock/stock_ledger_report.php';

    $this->load->view(
      'includes/template.php',
      $data
    );
  }


  public function print_stock_ledger_report()
  {
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $warehouse_id = $this->input->get('warehouse_id');
    $store_id = $this->input->get('store_id');
    $product_id = $this->input->get('product_id');
    $data['title'] = 'Stock Ledger Report';
    $data['from'] = $from_date;
    $data['to'] = $to_date;
    $data['warehouse_id'] = $warehouse_id;
    $data['store_id'] = $store_id;
    $data['product_id'] = $product_id;

    $data['records'] =
      $this->Reports_model->get_stock_ledger_report(
        $from_date,
        $to_date,
        $warehouse_id,
        $store_id,
        $product_id
      );


    $this->load->model('Setup_model');
    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }

    $branch_id = 8;
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['branch_name'] = '';
    if (!empty($branch)) {
      $data['branch_name'] = $branch->branch_name ?? '';
    }

    $data['headerPath'] = '';

    if (
      !empty($branch) &&
      !empty($branch->branch_header)
    ) {
      $data['headerPath'] =
        base_url(
          ltrim(
            $branch->branch_header,
            '/'
          )
        );
    }

    $data['warehouse_name'] = 'All Warehouses';
    if (!empty($warehouse_id)) {
      $warehouse =
        $this->db
        ->where(
          'warehouse_id',
          $warehouse_id
        )
        ->get('warehouse_master')
        ->row();

      if (!empty($warehouse)) {
        $data['warehouse_name'] =
          $warehouse->warehouse_name;
      }
    }

    $data['store_name'] = 'All Stores';
    if (!empty($store_id)) {
      $store =
        $this->db
        ->where(
          'store_id',
          $store_id
        )
        ->get('store_master')
        ->row();

      if (!empty($store)) {
        $data['store_name'] =
          $store->store_name;
      }
    }

    $data['product_name'] = 'All Products';
    if (!empty($product_id)) {
      $product =
        $this->db
        ->where(
          'product_id',
          $product_id
        )
        ->get('item_master')
        ->row();

      if (!empty($product)) {
        $data['product_name'] =
          $product->product_name;
      }
    }

    $data['prepared_by'] = $this->session->userdata('user_name');
    if (empty($data['prepared_by'])) {
      $data['prepared_by'] = 'Admin';
    }

    $this->load->view('Reports/Stock/Print/print_stock_ledger_report', $data);
  }

  public function export_stock_ledger_excel()
  {
    // =====================================================
    // FILTERS
    // =====================================================

    $from_date =
      $this->input->get('from_date');

    $to_date =
      $this->input->get('to_date');

    $warehouse_id =
      $this->input->get('warehouse_id');

    $store_id =
      $this->input->get('store_id');

    $product_id =
      $this->input->get('product_id');


    // =====================================================
    // BASIC DATA
    // =====================================================

    $data['title'] =
      'Stock Ledger Report';

    $data['from'] =
      $from_date;

    $data['to'] =
      $to_date;

    $data['warehouse_id'] =
      $warehouse_id;

    $data['store_id'] =
      $store_id;

    $data['product_id'] =
      $product_id;


    // =====================================================
    // MODELS
    // =====================================================

    $this->load->model('Setup_model');


    // =====================================================
    // COMPANY NAME
    // =====================================================

    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }


    // =====================================================
    // BRANCH NAME
    // =====================================================

    $branch_id = 1;

    $branch =
      $this->Setup_model->get_branch_by_id(
        $branch_id
      );

    $data['branch_name'] = '';

    if (!empty($branch)) {

      $data['branch_name'] =
        $branch->branch_name ?? '';
    }


    // =====================================================
    // WAREHOUSE NAME
    // =====================================================

    $data['warehouse_name'] =
      'All Warehouses';

    if (!empty($warehouse_id)) {

      $warehouse =
        $this->db
        ->where(
          'warehouse_id',
          $warehouse_id
        )
        ->get('warehouse_master')
        ->row();

      if (!empty($warehouse)) {
        $data['warehouse_name'] = $warehouse->warehouse_name;
      }
    }

    $data['store_name'] = 'All Stores';
    if (!empty($store_id)) {
      $store = $this->db->where('store_id', $store_id)->get('store_master')->row();
      if (!empty($store)) {
        $data['store_name'] = $store->store_name;
      }
    }

    $data['product_name'] = 'All Products';
    if (!empty($product_id)) {
      $product = $this->db->where('product_id', $product_id)->get('item_master')->row();
      if (!empty($product)) {
        $data['product_name'] = $product->product_name;
      }
    }

    $data['prepared_by'] = $this->session->userdata('user_name');
    if (empty($data['prepared_by'])) {
      $data['prepared_by'] =
        'Admin';
    }

    $data['records'] = $this->Reports_model->get_stock_ledger_report($from_date, $to_date, $warehouse_id, $store_id, $product_id);
    $filename = 'Stock_Ledger_Report_' . date('Y-m-d') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    $this->load->view('Reports/Stock/Export/export_stock_ledger_report', $data);
  }

  ///////////////////// STOCK VALUATION REPORT /////////////////////

  function stock_valuation_report()
  {
    $data['title'] = 'Stock Valuation Report';

    $data['warehouse_id'] = '';
    $data['store_id']     = '';
    $data['product_id']   = '';

    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');
    $data['warehouse_records'] =  $this->Setup_model->get_warehouse_list();

    $data['records'] = array();
    $data['main_content'] = 'Reports/Stock/stock_valuation_report.php';

    $this->load->view('includes/template.php', $data);
  }


  function get_stock_valuation_report()
  {
    $data['title'] = 'Stock Valuation Report';
    $data['warehouse_id'] = $this->input->post('warehouse_id');
    $data['store_id'] = $this->input->post('store_id');
    $data['product_id'] = $this->input->post('product_id');

    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');
    $data['warehouse_records'] = $this->Setup_model->get_warehouse_list();

    $data['records'] = $this->Reports_model->get_stock_valuation_report($data['warehouse_id'], $data['store_id'], $data['product_id']);

    $data['main_content'] = 'Reports/Stock/stock_valuation_report.php';
    $this->load->view('includes/template.php', $data);
  }

  public function print_stock_valuation_report()
  {
    $warehouse_id = $this->input->get('warehouse_id');
    $store_id = $this->input->get('store_id');
    $product_id = $this->input->get('product_id');
    $data['title'] = 'Stock Valuation Report';
    $data['warehouse_id'] = $warehouse_id;
    $data['store_id'] = $store_id;
    $data['product_id'] = $product_id;
    $data['records'] = $this->Reports_model->get_stock_valuation_report($warehouse_id, $store_id, $product_id);

    $this->load->model('Setup_model');
    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }


    $branch_id = 1;
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['branch_name'] = '';
    if (!empty($branch)) {
      $data['branch_name'] = $branch->branch_name ?? '';
    }

    $data['headerPath'] = '';
    if (!empty($branch) && !empty($branch->branch_header)) {
      $data['headerPath'] = base_url(ltrim($branch->branch_header, '/'));
    }

    $data['warehouse_name'] = 'All Warehouses';
    if (!empty($warehouse_id)) {
      $warehouse = $this->db->where('warehouse_id', $warehouse_id)->get('warehouse_master')->row();
      if (!empty($warehouse)) {
        $data['warehouse_name'] = $warehouse->warehouse_name;
      }
    }

    $data['store_name'] = 'All Stores';
    if (!empty($store_id)) {
      $store = $this->db->where('store_id', $store_id)->get('store_master')->row();
      if (!empty($store)) {
        $data['store_name'] = $store->store_name;
      }
    }

    $data['product_name'] = 'All Products';
    if (!empty($product_id)) {
      $product = $this->db->where('product_id', $product_id)->get('item_master')->row();
      if (!empty($product)) {
        $data['product_name'] = $product->product_name;
      }
    }

    $data['prepared_by'] = $this->session->userdata('user_name');
    if (empty($data['prepared_by'])) {
      $data['prepared_by'] = 'Admin';
    }

    $this->load->view('Reports/Stock/Print/print_stock_valuation_report', $data);
  }

  public function export_stock_valuation_excel()
  {
    $warehouse_id = $this->input->get('warehouse_id');
    $store_id = $this->input->get('store_id');
    $product_id = $this->input->get('product_id');

    $data['title'] = 'Stock Valuation Report';
    $data['warehouse_id'] = $warehouse_id;
    $data['store_id'] = $store_id;
    $data['product_id'] = $product_id;

    $this->load->model('Setup_model');
    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }


    $branch_id = 1;
    $branch = $this->Setup_model->get_branch_by_id($branch_id);

    $data['branch_name'] = '';
    if (!empty($branch)) {
      $data['branch_name'] = $branch->branch_name ?? '';
    }

    $data['warehouse_name'] = 'All Warehouses';
    if (!empty($warehouse_id)) {
      $warehouse = $this->db->where('warehouse_id', $warehouse_id)->get('warehouse_master')->row();
      if (!empty($warehouse)) {
        $data['warehouse_name'] = $warehouse->warehouse_name;
      }
    }

    $data['store_name'] = 'All Stores';
    if (!empty($store_id)) {
      $store = $this->db->where('store_id', $store_id)->get('store_master')->row();
      if (!empty($store)) {
        $data['store_name'] = $store->store_name;
      }
    }

    $data['product_name'] = 'All Products';
    if (!empty($product_id)) {
      $product = $this->db->where('product_id', $product_id)->get('item_master')->row();
      if (!empty($product)) {
        $data['product_name'] = $product->product_name;
      }
    }

    $data['prepared_by'] = $this->session->userdata('user_name');
    if (empty($data['prepared_by'])) {
      $data['prepared_by'] = 'Admin';
    }

    $data['records'] = $this->Reports_model->get_stock_valuation_report($warehouse_id, $store_id, $product_id);
    $filename = 'Stock_Valuation_Report_' . date('Y-m-d') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    $this->load->view('Reports/Stock/Export/export_stock_valuation_report', $data);
  }

  ///////////////////// STOCK RESERVATION REPORT START /////////////////////

  public function stock_reservation_report()
  {
    $data['title'] = 'Stock Reservation Report';

    $data['from'] = date('Y-m-01');
    $data['to']   = date('Y-m-d');
    $data['product_id']  = '';
    $data['customer_id'] = '';
    $data['so_id']       = '';
    $data['status']      = '';

    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');
    $data['customer_records'] = $this->Setup_model->get_all_customer_list();

    $data['sales_orders'] = $this->Reports_model->get_reservation_sales_order_list();
    $data['records'] = array();

    $data['main_content'] = 'Reports/Stock/stock_reservation_report.php';
    $this->load->view('includes/template.php', $data);
  }


  public function get_stock_reservation_report()
  {
    $data['title'] = 'Stock Reservation Report';
    $data['from'] = $this->input->post('from_date');
    $data['to'] = $this->input->post('to_date');
    $data['product_id'] = $this->input->post('product_id');
    $data['customer_id'] = $this->input->post('customer_id');
    $data['so_id'] = $this->input->post('so_id');
    $data['status'] = $this->input->post('status');

    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    $this->load->model('Setup_model');
    $data['customer_records'] = $this->Setup_model->get_all_customer_list();
    $data['sales_orders'] = $this->Reports_model->get_reservation_sales_order_list();

    $data['records'] = $this->Reports_model->get_stock_reservation_report($data['from'], $data['to'], $data['product_id'], $data['customer_id'], $data['so_id'], $data['status']);

    $data['main_content'] = 'Reports/Stock/stock_reservation_report.php';
    $this->load->view('includes/template.php', $data);
  }


  public function print_stock_reservation_report()
  {
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $product_id = $this->input->get('product_id');
    $customer_id = $this->input->get('customer_id');
    $so_id = $this->input->get('so_id');
    $status = $this->input->get('status');

    $data['title'] = 'Stock Reservation Report';
    $data['from'] = $from_date;
    $data['to'] = $to_date;
    $data['product_id'] = $product_id;
    $data['customer_id'] = $customer_id;
    $data['so_id'] = $so_id;
    $data['status'] = $status;

    $data['records'] = $this->Reports_model->get_stock_reservation_report($from_date, $to_date, $product_id, $customer_id, $so_id, $status);

    $this->load->model('Setup_model');
    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }


    $branch_id = 1;
    $branch = $this->Setup_model->get_branch_by_id($branch_id);
    $data['branch_name'] = '';

    if (!empty($branch)) {
      $data['branch_name'] = $branch->branch_name ?? '';
    }

    $data['headerPath'] = '';

    if (!empty($branch) && !empty($branch->branch_header)) {
      $data['headerPath'] = base_url(ltrim($branch->branch_header, '/'));
    }

    $data['prepared_by'] = $this->session->userdata('user_name');
    if (empty($data['prepared_by'])) {
      $data['prepared_by'] = 'Admin';
    }

    $data['product_name'] = 'All Products';

    if (!empty($product_id)) {
      $product = $this->db->where('product_id', $product_id)->get('item_master')->row();
      if (!empty($product)) {
        $data['product_name'] = $product->product_name;
      }
    }

    $data['customer_name'] = 'All Customers';
    if (!empty($customer_id)) {
      $customer = $this->db->where('customer_id', $customer_id)->get('customer_master')->row();
      if (!empty($customer)) {
        $data['customer_name'] = $customer->customer_name;
      }
    }

    $data['sales_order_name'] = 'All Sales Orders';
    if (!empty($so_id)) {
      $so = $this->db->where('so_id', $so_id)->get('sales_order_master')->row();
      if (!empty($so)) {
        $data['sales_order_name'] = $so->so_code;
      }
    }

    $this->load->view('Reports/Stock/Print/print_stock_reservation_report', $data);
  }


  public function export_stock_reservation_excel()
  {
    $from_date = $this->input->get('from_date');
    $to_date = $this->input->get('to_date');
    $product_id = $this->input->get('product_id');
    $customer_id = $this->input->get('customer_id');
    $so_id = $this->input->get('so_id');
    $status = $this->input->get('status');


    $data['title'] = 'Stock Reservation Report';
    $data['from'] = $from_date;
    $data['to'] = $to_date;
    $data['product_id'] = $product_id;
    $data['customer_id'] = $customer_id;
    $data['so_id'] = $so_id;
    $data['status'] = $status;

    $this->load->model('Setup_model');
    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }



    // Branch
    $branch_id = 1;
    $branch = $this->Setup_model->get_branch_by_id($branch_id);

    $data['branch_name'] = '';
    if (!empty($branch)) {
      $data['branch_name'] = $branch->branch_name ?? '';
    }


    $data['product_name'] = 'All Products';
    if (!empty($product_id)) {
      $product = $this->db->where('product_id', $product_id)->get('item_master')->row();
      if (!empty($product)) {
        $data['product_name'] = $product->product_name;
      }
    }

    $data['customer_name'] = 'All Customers';
    if (!empty($customer_id)) {
      $customer = $this->db->where('customer_id', $customer_id)->get('customer_master')->row();
      if (!empty($customer)) {
        $data['customer_name'] = $customer->customer_name;
      }
    }

    $data['sales_order_name'] = 'All Sales Orders';
    if (!empty($so_id)) {
      $so = $this->db->where('so_id', $so_id)->get('sales_order_master')->row();
      if (!empty($so)) {
        $data['sales_order_name'] = $so->so_code;
      }
    }

    $data['prepared_by'] = $this->session->userdata('user_name');
    if (empty($data['prepared_by'])) {
      $data['prepared_by'] = 'Admin';
    }

    $data['records'] = $this->Reports_model->get_stock_reservation_report($from_date, $to_date, $product_id, $customer_id, $so_id, $status);

    $filename = 'Stock_Reservation_Report_' . date('Y-m-d') . '.xls';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $this->load->view('Reports/Stock/Export/export_stock_reservation_report', $data);
  }

  ///////////////////// STOCK RESERVATION REPORT END /////////////////////

  ///////////////////// STOCK ADJUSTMENT REPORT START /////////////////////

  public function stock_adjustment_report()
  {
    $data['title'] = 'Stock Adjustment Report';

    $data['from'] = date('Y-m-01');
    $data['to']   = date('Y-m-d');

    $data['warehouse_id'] = '';
    $data['store_id']     = '';
    $data['product_id']   = '';
    $data['adjustment_type'] = '';

    // Product list
    $this->load->model('Stock_model');

    $data['products'] =
      $this->Stock_model->get_stock_code_list();

    // Warehouse list
    $this->load->model('Setup_model');

    $data['warehouse_records'] =
      $this->Setup_model->get_warehouse_list();

    // Empty records initially
    $data['records'] = array();

    $data['main_content'] =
      'Reports/Stock/stock_adjustment_report.php';

    $this->load->view(
      'includes/template.php',
      $data
    );
  }


  public function get_stock_adjustment_report()
  {
    $data['title'] = 'Stock Adjustment Report';
    $data['from'] = $this->input->post('from_date');
    $data['to'] = $this->input->post('to_date');
    $data['warehouse_id'] = $this->input->post('warehouse_id');
    $data['store_id'] = $this->input->post('store_id');
    $data['product_id'] = $this->input->post('product_id');
    $data['adjustment_type'] = $this->input->post('adjustment_type');

    // Product list
    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();

    // Warehouse list
    $this->load->model('Setup_model');
    $data['warehouse_records'] = $this->Setup_model->get_warehouse_list();

    // Report records
    $data['records'] = $this->Reports_model->get_stock_adjustment_report($data['from'], $data['to'], $data['warehouse_id'], $data['store_id'], $data['product_id'], $data['adjustment_type']);

    $data['main_content'] = 'Reports/Stock/stock_adjustment_report.php';

    $this->load->view('includes/template.php', $data);
  }


  public function print_stock_adjustment_report()
  {
    $from_date =
      $this->input->get('from_date');

    $to_date =
      $this->input->get('to_date');

    $warehouse_id =
      $this->input->get('warehouse_id');

    $store_id =
      $this->input->get('store_id');

    $product_id =
      $this->input->get('product_id');

    $adjustment_type =
      $this->input->get('adjustment_type');


    $data['title'] =
      'Stock Adjustment Report';

    $data['from'] =
      $from_date;

    $data['to'] =
      $to_date;

    $data['warehouse_id'] =
      $warehouse_id;

    $data['store_id'] =
      $store_id;

    $data['product_id'] =
      $product_id;

    $data['adjustment_type'] =
      $adjustment_type;


    // Get records
    $data['records'] =
      $this->Reports_model->get_stock_adjustment_report(
        $from_date,
        $to_date,
        $warehouse_id,
        $store_id,
        $product_id,
        $adjustment_type
      );


    // Company
    $this->load->model('Setup_model');
    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }

    // Branch
    $branch_id = 1;

    $branch =
      $this->Setup_model->get_branch_by_id(
        $branch_id
      );

    $data['branch_name'] = '';

    if (!empty($branch)) {

      $data['branch_name'] =
        $branch->branch_name ?? '';
    }


    // Header
    $data['headerPath'] = '';

    if (
      !empty($branch) &&
      !empty($branch->branch_header)
    ) {

      $data['headerPath'] =
        base_url(
          ltrim(
            $branch->branch_header,
            '/'
          )
        );
    }


    // Warehouse name
    $data['warehouse_name'] =
      'All Warehouses';

    if (!empty($warehouse_id)) {

      $warehouse =
        $this->db
        ->where(
          'warehouse_id',
          $warehouse_id
        )
        ->get('warehouse_master')
        ->row();

      if (!empty($warehouse)) {

        $data['warehouse_name'] =
          $warehouse->warehouse_name;
      }
    }


    // Store name
    $data['store_name'] =
      'All Stores';

    if (!empty($store_id)) {

      $store =
        $this->db
        ->where(
          'store_id',
          $store_id
        )
        ->get('store_master')
        ->row();

      if (!empty($store)) {

        $data['store_name'] =
          $store->store_name;
      }
    }


    // Product name
    $data['product_name'] =
      'All Products';

    if (!empty($product_id)) {

      $product =
        $this->db
        ->where(
          'product_id',
          $product_id
        )
        ->get('item_master')
        ->row();

      if (!empty($product)) {

        $data['product_name'] =
          $product->product_name;
      }
    }


    // Prepared by
    $data['prepared_by'] =
      $this->session->userdata('user_name');

    if (empty($data['prepared_by'])) {

      $data['prepared_by'] =
        'Admin';
    }


    // Adjustment type name
    $data['adjustment_type_name'] =
      'All';

    if ($adjustment_type == 'IN') {

      $data['adjustment_type_name'] =
        'Increase';
    } elseif ($adjustment_type == 'OUT') {

      $data['adjustment_type_name'] =
        'Decrease';
    }


    $this->load->view(
      'Reports/Stock/Print/print_stock_adjustment_report',
      $data
    );
  }


  public function export_stock_adjustment_excel()
  {
    $from_date =
      $this->input->get('from_date');

    $to_date =
      $this->input->get('to_date');

    $warehouse_id =
      $this->input->get('warehouse_id');

    $store_id =
      $this->input->get('store_id');

    $product_id =
      $this->input->get('product_id');

    $adjustment_type =
      $this->input->get('adjustment_type');


    $data['title'] =
      'Stock Adjustment Report';

    $data['from'] =
      $from_date;

    $data['to'] =
      $to_date;

    $data['warehouse_id'] =
      $warehouse_id;

    $data['store_id'] =
      $store_id;

    $data['product_id'] =
      $product_id;

    $data['adjustment_type'] =
      $adjustment_type;


    // Company
    $this->load->model('Setup_model');
    $data['company_name'] = '';
    $company = $this->Setup_model->get_company_details();
    if (!empty($company) && is_array($company)) {
      $data['company_name'] = $company['company_name'] ?? '';
    }

    // Branch
    $branch_id = 1;

    $branch =
      $this->Setup_model->get_branch_by_id(
        $branch_id
      );

    $data['branch_name'] = '';

    if (!empty($branch)) {

      $data['branch_name'] =
        $branch->branch_name ?? '';
    }


    // Warehouse
    $data['warehouse_name'] =
      'All Warehouses';

    if (!empty($warehouse_id)) {

      $warehouse =
        $this->db
        ->where(
          'warehouse_id',
          $warehouse_id
        )
        ->get('warehouse_master')
        ->row();

      if (!empty($warehouse)) {

        $data['warehouse_name'] =
          $warehouse->warehouse_name;
      }
    }


    // Store
    $data['store_name'] =
      'All Stores';

    if (!empty($store_id)) {

      $store =
        $this->db
        ->where(
          'store_id',
          $store_id
        )
        ->get('store_master')
        ->row();

      if (!empty($store)) {

        $data['store_name'] =
          $store->store_name;
      }
    }


    // Product
    $data['product_name'] =
      'All Products';

    if (!empty($product_id)) {

      $product =
        $this->db
        ->where(
          'product_id',
          $product_id
        )
        ->get('item_master')
        ->row();

      if (!empty($product)) {

        $data['product_name'] =
          $product->product_name;
      }
    }


    // Adjustment Type
    $data['adjustment_type_name'] =
      'All';

    if ($adjustment_type == 'IN') {

      $data['adjustment_type_name'] =
        'Increase';
    } elseif ($adjustment_type == 'OUT') {

      $data['adjustment_type_name'] =
        'Decrease';
    }


    // Prepared By
    $data['prepared_by'] =
      $this->session->userdata('user_name');

    if (empty($data['prepared_by'])) {

      $data['prepared_by'] =
        'Admin';
    }


    // Records
    $data['records'] =
      $this->Reports_model->get_stock_adjustment_report(
        $from_date,
        $to_date,
        $warehouse_id,
        $store_id,
        $product_id,
        $adjustment_type
      );


    $filename =
      'Stock_Adjustment_Report_' .
      date('Y-m-d') .
      '.xls';


    header(
      'Content-Type: application/vnd.ms-excel'
    );

    header(
      'Content-Disposition: attachment; filename="' .
        $filename .
        '"'
    );

    header(
      'Pragma: no-cache'
    );

    header(
      'Expires: 0'
    );


    $this->load->view(
      'Reports/Stock/Export/export_stock_adjustment_report',
      $data
    );
  }

  ///////////////////// STOCK ADJUSTMENT REPORT END /////////////////////

  ///////////////////// STOCK TRANSFER REPORT /////////////////////

  public function stock_transfer_report()
  {
    $data['title'] = 'Stock Transfer Report';

    // Default date range
    $data['from'] = $this->input->post('from')
      ? $this->input->post('from')
      : date('Y-m-01');

    $data['to'] = $this->input->post('to')
      ? $this->input->post('to')
      : date('Y-m-d');

    $data['from_branch_id'] =
      $this->input->post('from_branch_id') ?? '';

    $data['to_branch_id'] =
      $this->input->post('to_branch_id') ?? '';

    $data['from_warehouse_id'] =
      $this->input->post('from_warehouse_id') ?? '';

    $data['to_warehouse_id'] =
      $this->input->post('to_warehouse_id') ?? '';

    $data['from_store_id'] =
      $this->input->post('from_store_id') ?? '';

    $data['to_store_id'] =
      $this->input->post('to_store_id') ?? '';

    $data['product_id'] =
      $this->input->post('product_id') ?? '';

    $data['status'] =
      $this->input->post('status') ?? '';
$this->load->model('Company_model');
    // Dropdowns
    $data['branch_records'] =
      $this->Company_model->get_all_branches();

    $data['warehouse_list'] =
      $this->Setup_model->get_warehouse_list();

    $data['products'] =
      $this->Setup_model->get_active_item_list();

    $data['records'] =
      $this->Reports_model->get_stock_transfer_report();

    $data['main_content'] =
      'Reports/Stock/stock_transfer_report.php';

    $this->load->view(
      'includes/template',
      $data
    );
  }

  function get_stock_transfer_report()
  {
    $data['title'] = 'Stock Transfer Report';
    $data['from_date'] = $this->input->post('from_date');
    $data['to_date'] = $this->input->post('to_date');
    $data['from_warehouse_id'] = $this->input->post('from_warehouse_id');
    $data['from_store_id'] = $this->input->post('from_store_id');
    $data['to_warehouse_id'] = $this->input->post('to_warehouse_id');
    $data['to_store_id'] = $this->input->post('to_store_id');
    $data['product_id'] = $this->input->post('product_id');
    $data['status'] = $this->input->post('status');

    $this->load->model('Setup_model');
    $this->load->model('Stock_model');
    $data['products'] = $this->Stock_model->get_stock_code_list();
    $data['warehouse_records'] = $this->Setup_model->get_warehouse_list();
    $data['records'] = $this->Reports_model->get_stock_transfer_report($data['from_date'], $data['to_date'], $data['from_warehouse_id'], $data['from_store_id'], $data['to_warehouse_id'], $data['to_store_id'], $data['product_id'], $data['status']);

    $data['main_content'] = 'Reports/Stock/stock_transfer_report.php';
    $this->load->view('includes/template.php', $data);
  }

  public function print_stock_transfer_report()
  {
    $data['from'] =
      $this->input->get('from')
      ?: date('Y-m-01');

    $data['to'] =
      $this->input->get('to')
      ?: date('Y-m-d');

    $data['from_branch_id'] =
      $this->input->get('from_branch_id') ?? '';

    $data['to_branch_id'] =
      $this->input->get('to_branch_id') ?? '';

    $data['from_warehouse_id'] =
      $this->input->get('from_warehouse_id') ?? '';

    $data['to_warehouse_id'] =
      $this->input->get('to_warehouse_id') ?? '';

    $data['from_store_id'] =
      $this->input->get('from_store_id') ?? '';

    $data['to_store_id'] =
      $this->input->get('to_store_id') ?? '';

    $data['product_id'] =
      $this->input->get('product_id') ?? '';

    $data['status'] =
      $this->input->get('status') ?? '';

    $data['records'] =
      $this->Reports_model->get_stock_transfer_report(
        'get'
      );

    /*
     * Company / branch information
     *
     * Using branch ID 1 here because your existing
     * Stock Transfer print function already uses branch 1.
     */
    $branch = $this->Setup_model->get_branch_by_id(1);

    $data['branch'] = $branch;

    $data['company_name'] =
      !empty($branch->company_name)
      ? $branch->company_name
      : '';

    $data['branch_name'] =
      !empty($branch->branch_name)
      ? $branch->branch_name
      : '';

    $data['prepared_by'] =
      $this->session->userdata('user_name')
      ?: 'Admin';

    $this->load->view(
      'Reports/Stock/Print/print_stock_transfer_report',
      $data
    );
  }

  public function export_stock_transfer_excel()
  {
    $data['from'] =
      $this->input->get('from')
      ?: date('Y-m-01');

    $data['to'] =
      $this->input->get('to')
      ?: date('Y-m-d');

    $data['from_branch_id'] =
      $this->input->get('from_branch_id') ?? '';

    $data['to_branch_id'] =
      $this->input->get('to_branch_id') ?? '';

    $data['from_warehouse_id'] =
      $this->input->get('from_warehouse_id') ?? '';

    $data['to_warehouse_id'] =
      $this->input->get('to_warehouse_id') ?? '';

    $data['from_store_id'] =
      $this->input->get('from_store_id') ?? '';

    $data['to_store_id'] =
      $this->input->get('to_store_id') ?? '';

    $data['product_id'] =
      $this->input->get('product_id') ?? '';

    $data['status'] =
      $this->input->get('status') ?? '';

    $data['records'] =
      $this->Reports_model->get_stock_transfer_report(
        'get'
      );

    $branch =
      $this->Setup_model->get_branch_by_id(1);

    $data['company_name'] =
      !empty($branch->company_name)
      ? $branch->company_name
      : '';

    $data['branch_name'] =
      !empty($branch->branch_name)
      ? $branch->branch_name
      : '';

    $data['prepared_by'] =
      $this->session->userdata('user_name')
      ?: 'Admin';

    header(
      'Content-Type: application/vnd.ms-excel'
    );

    header(
      'Content-Disposition: attachment; filename="Stock_Transfer_Report_' .
        date('Ymd') .
        '.xls"'
    );

    header('Pragma: no-cache');
    header('Expires: 0');

    $this->load->view(
      'Reports/Stock/Export/export_stock_transfer_report',
      $data
    );
  }
}
