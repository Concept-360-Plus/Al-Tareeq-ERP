<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function accounts_dashboard()
    {
        $data['title'] = "Accounts Dashboard";

        $this->load->model('Accounts_model');

        $data['ledger_count']       = $this->Accounts_model->get_ledger_count();
        $data['receipt_count']      = $this->Accounts_model->get_receipt_count();
        $data['payment_count']      = $this->Accounts_model->get_payment_count();
        $data['journal_count']      = $this->Accounts_model->get_journal_count();
        $data['contra_count']       = $this->Accounts_model->get_contra_count();
        $data['expense_count']      = $this->Accounts_model->get_expense_count();
        $data['debit_note_count']   = $this->Accounts_model->get_debit_note_count();
        $data['credit_note_count']  = $this->Accounts_model->get_credit_note_count();
        $data['today_receipts']     = $this->Accounts_model->today_receipts();
        $data['today_payments']     = $this->Accounts_model->today_payments();
        $data['today_expenses']     = $this->Accounts_model->today_expenses();
        $data['today_journals']     = $this->Accounts_model->today_journals();
        $data['cash_in']            = $this->Accounts_model->get_today_cash_in();
        $data['cash_out']           = $this->Accounts_model->get_today_cash_out();
        $data['net_cash']           = $this->Accounts_model->get_today_net_cash();
        $data['recent_receipts']    = $this->Accounts_model->get_recent_receipts();
        $data['recent_payments']    = $this->Accounts_model->get_recent_payments();
        $data['recent_journals']    = $this->Accounts_model->get_recent_journals();
        $data['recent_expenses']    = $this->Accounts_model->get_recent_expenses();
        $data['pending_reconciliation'] = $this->Accounts_model->get_recent_bank_reconciliation();

        $data['main_content'] = "dashboard/account_dashboard";

        $this->load->view('includes/template', $data);
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

        $data['purchase_today'] = $this->Purchase_model->get_purchase_today();
        $data['monthly_purchase'] = $this->Purchase_model->get_monthly_purchase();
        $data['purchase_return_summary'] = $this->Purchase_model->get_purchase_return_summary();
        $data['average_purchase_cost'] = $this->Purchase_model->get_average_purchase_cost();

        $data['monthly_purchase_chart'] = $this->Purchase_model->get_monthly_po();
        $data['top_suppliers']       = $this->Purchase_model->get_top_suppliers();

        $data['main_content'] = 'dashboard/purchase_dashboard';

        $this->load->view('includes/template', $data);
    }

    public function inventory_dashboard()
    {
        $this->load->model('Inventory_model');

        $data['title'] = "Inventory Dashboard";
        $data['product_count'] = $this->Inventory_model->get_product_count();
        $data['material_issue_count'] = $this->Inventory_model->get_material_issue_count();
        $data['ledger_count'] = $this->Inventory_model->get_stock_ledger_count();

        $stock_summary = $this->Inventory_model->get_inventory_stock_summary();
        $data['available_stock'] = $stock_summary->available_stock ?? 0;
        $data['reserved_stock'] = $stock_summary->reserved_stock ?? 0;
        $data['pending_stock'] = $stock_summary->pending_stock ?? 0;

        $data['inventory_value'] = $this->Inventory_model->get_inventory_value();
        $data['low_stock_count'] = $this->Inventory_model->get_low_stock_count();
        $data['out_of_stock_count'] = $this->Inventory_model->get_out_of_stock_count();
        $data['overstock_count'] = $this->Inventory_model->get_overstock_count();

        $data['stock_in'] =  $this->Inventory_model->get_total_stock_in();
        $data['stock_out'] = $this->Inventory_model->get_total_stock_out();

        $today_movement = $this->Inventory_model->get_today_stock_movement();
        $data['today_stock_in'] = $today_movement->stock_in ?? 0;
        $data['today_stock_out'] = $today_movement->stock_out ?? 0;

        $data['today_issue'] = $this->Inventory_model->today_material_issue();
        $data['today_adjustment'] = $this->Inventory_model->today_stock_adjustment();

        $data['monthly_stock_movement'] = $this->Inventory_model->get_monthly_stock_movement();
        $data['inventory_value_trend'] = $this->Inventory_model->get_inventory_value_trend();
        $data['stock_status_summary'] = $this->Inventory_model->get_stock_status_summary();

        $data['fast_moving_items'] = $this->Inventory_model->get_fast_moving_items();
        $data['dead_stock_items'] = $this->Inventory_model->get_dead_stock_items();

        $data['recent_issue'] = $this->Inventory_model->recent_material_issue();
        $data['recent_stock'] = $this->Inventory_model->recent_stock_ledger();
        $data['low_stock'] = $this->Inventory_model->low_stock_items();
        $data['warehouse_summary'] = $this->Inventory_model->warehouse_summary();

        $data['main_content'] = "dashboard/inventory_dashboard";
        $this->load->view('includes/template', $data);
    }

    public function hr_dashboard()
    {
        $this->load->model('Hr_model');
        $data['title'] = "HR Dashboard";
        $data['employee_count'] = $this->Hr_model->get_dashboard_employee_count();
        $attendance = $this->Hr_model->get_dashboard_today_attendance();
        $data['today_present'] = $attendance->present_count ?? 0;

        $data['today_absent'] = $attendance->absent_count ?? 0;
        $data['today_leave'] = $attendance->leave_count ?? 0;
        $data['leave_request_count'] = $this->Hr_model->get_dashboard_monthly_leave_count();
        $data['payroll_cost'] = $this->Hr_model->get_dashboard_monthly_payroll_cost();

        $data['new_hires'] = $this->Hr_model->get_dashboard_new_hires();
        $data['resignations'] = $this->Hr_model->get_dashboard_resignations();

        $data['pending_leave'] = $this->Hr_model->get_dashboard_pending_leave();
        $data['payroll_pending'] = $this->Hr_model->get_dashboard_payroll_pending();

        $data['attendance_trend'] = $this->Hr_model->get_dashboard_attendance_trend();
        $data['employee_movement'] = $this->Hr_model->get_dashboard_employee_movement();
        $data['leave_analysis'] = $this->Hr_model->get_dashboard_leave_analysis();
        $data['payroll_trend'] = $this->Hr_model->get_dashboard_payroll_trend();

        $data['pending_leave_list'] = $this->Hr_model->get_dashboard_pending_leave_list();
        $data['today_attendance_list'] = $this->Hr_model->get_dashboard_today_attendance_list();
        $data['recent_joinings'] = $this->Hr_model->get_dashboard_recent_joinings();
        $data['recent_resignations'] = $this->Hr_model->get_dashboard_recent_resignations();
        $data['recent_activities'] = $this->Hr_model->get_dashboard_recent_activities();

        $data['main_content'] = "dashboard/hr_dashboard";
        $this->load->view('includes/template', $data);
    }

    public function sales_dashboard()
    {
        $data['title'] = "Sales Dashboard";

        $data['main_content'] = "dashboard/sales_dashboard";

        $this->load->view('includes/template', $data);
    }

    public function project_dashboard()
    {
        $this->load->model('Project_dashboard_model', 'dashboard');
        $this->load->helper(array('url', 'form'));
        $data['title'] = 'Project Dashboard';
        $data['total_projects']  = $this->dashboard->count_total_projects();
        $data['active_projects'] = $this->dashboard->count_active_projects();
        $data['completed_projects'] = $this->dashboard->count_completed_projects();
        $data['pending_workorders']  = $this->dashboard->count_pending_workorders();
        $data['approved_workorders'] = $this->dashboard->count_approved_workorders();
        $data['pending_outsource'] = $this->dashboard->count_pending_outsource();
        $data['completed_outsource'] = $this->dashboard->count_completed_outsource();
        $data['delayed_projects'] = $this->dashboard->count_delayed_projects();
        $data['due_projects'] = $this->dashboard->count_due_projects();
        $data['average_progress'] = $this->dashboard->average_progress();
        $data['estimated_cost'] = $this->dashboard->total_estimated_cost();
        $data['outsource_cost'] = $this->dashboard->total_outsource_cost();
        $data['material_request_cost'] = $this->dashboard->total_material_request_cost();

        $data['project_status'] = $this->dashboard->project_status_chart();
        $data['monthly_projects'] = $this->dashboard->monthly_projects_chart();
        $data['workorder_chart']  = $this->dashboard->workorder_chart();
        $data['progress_chart'] = $this->dashboard->progress_distribution_chart();

        $data['recent_projects'] = $this->dashboard->recent_projects();
        $data['recent_workorders'] = $this->dashboard->recent_workorders();
        $data['recent_progress'] = $this->dashboard->recent_progress();
        $data['pending_outsource_list'] = $this->dashboard->pending_outsource_list();
        $data['delayed_project_list'] = $this->dashboard->delayed_projects();
        $data['due_project_list'] = $this->dashboard->due_projects();

        $data['page_title'] = 'Project Manager Dashboard';
        $data['module'] = 'Project Management';
        $data['icon']  = 'fa fa-dashboard';
        $data['cost_summary'] = $this->dashboard->estimated_cost_per_project();
        $data['main_content'] = 'project/dashboard.php';
        $this->load->view('includes/template', $data);;
    }
}
