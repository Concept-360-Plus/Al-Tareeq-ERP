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

        $data['top_suppliers']       = $this->Purchase_model->get_top_suppliers();

        $data['main_content'] = 'dashboard/purchase_dashboard';

        $this->load->view('includes/template', $data);
    }

    public function inventory_dashboard()
    {
        $data['title'] = "Inventory Dashboard";

        $data['main_content'] = "dashboard/inventory_dashboard";

        $this->load->view('includes/template', $data);
    }

    public function hr_dashboard()
    {
        $data['title'] = "HR Dashboard";

        $data['main_content'] = "dashboard/hr_dashboard";

        $this->load->view('includes/template', $data);
    }

    public function sales_dashboard()
    {
        $data['title'] = "Sales Dashboard";

        $data['main_content'] = "dashboard/sales_dashboard";

        $this->load->view('includes/template', $data);
    }
}
