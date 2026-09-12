<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work_order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // ---------- Ref No generation ----------
    // TEMP logic — replace with exact pattern once you share the existing
    // amc_enq_code / quotation_code generator function for consistency.
    public function generate_ref_no($branch_code)
    {
        $prefix = strtoupper($branch_code) . date('ym'); // e.g. SWE2608
        $this->db->like('ref_no', $prefix, 'after');
        $this->db->order_by('wo_id', 'DESC');
        $last = $this->db->get('work_order_master')->row();
        $next = 1;
        if ($last) {
            $next = (int) substr($last->ref_no, strlen($prefix)) + 1;
        }
        return $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);
    }

    // ---------- Customer auto-fetch ----------
    public function get_customer_by_code($customer_code)
    {
        return $this->db->where('customer_code', $customer_code)
                         ->get('customer_master')->row();
    }

    // ---------- Product search (Select2 AJAX) ----------
    public function search_products($term)
    {
        $this->db->select('product_id, product_code, product_name');
        $this->db->from('item_master');
        $this->db->group_start();
        $this->db->like('product_code', $term);
        $this->db->or_like('product_name', $term);
        $this->db->group_end();
        $this->db->where('is_inactive', 0);
        $this->db->limit(20);
        return $this->db->get()->result();
    }

    // ---------- AMC Lookup ----------
    public function get_active_amc_contracts($cust_id)
    {
        $this->db->select('invoice_id, invoice_code, amc_start_date, amc_end_date, project_name');
        $this->db->from('amc_invoice_master');
        $this->db->where('customer_id', $cust_id);
        $this->db->where('cancelled', 0);
        $this->db->where('amc_end_date >=', date('Y-m-d'));
        return $this->db->get()->result();
    }

    public function get_amc_contract_detail($invoice_id)
    {
        return $this->db->where('invoice_id', $invoice_id)
                         ->get('amc_invoice_master')->row();
    }

    // ---------- CRUD ----------
    public function insert_work_order($data)
    {
        $this->db->insert('work_order_master', $data);
        return $this->db->insert_id();
    }

    public function insert_work_order_items($items)
    {
        $this->db->insert_batch('work_order_transaction', $items);
    }

    public function update_work_order($wo_id, $data)
    {
        $this->db->where('wo_id', $wo_id)->update('work_order_master', $data);
    }

    public function get_work_order($wo_id)
    {
        return $this->db->where('wo_id', $wo_id)->get('work_order_master')->row();
    }

    public function get_work_order_items($wo_id)
    {
        return $this->db->where('wo_id', $wo_id)->get('work_order_transaction')->result();
    }

    public function get_work_order_list($wo_type)
    {
        return $this->db->where('wo_type', $wo_type)
                         ->order_by('wo_id', 'DESC')
                         ->get('work_order_master')->result();
    }
}