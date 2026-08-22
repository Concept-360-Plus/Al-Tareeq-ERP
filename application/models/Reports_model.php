<?php
class Reports_model extends CI_Model
{

    public function __construct() {}

    public function get_rfq_report_records()
    {
        $from = isset($_REQUEST['from_date']) ? date('Y-m-d', strtotime($_REQUEST['from_date'])) : '';
        $to = isset($_REQUEST['to_date']) ? date('Y-m-d', strtotime($_REQUEST['to_date'])) : '';

        if (empty($from) || empty($to)) {
            return [];
        }

        $created_by = isset($_REQUEST['created_by']) ? $_REQUEST['created_by'] : '';
        $supplier_id = isset($_REQUEST['supplier_id']) ? $_REQUEST['supplier_id'] : '';

        $user_condition = '';
        $supplier_condition = '';

        if ($created_by != '') {
            $user_condition = " AND r.created_by = '$created_by'";
        }

        if ($supplier_id != '') {
            $supplier_condition = " AND r.supplier_id = '$supplier_id'";
        }

        $query = $this->db->query("
            SELECT 
                r.rfq_id,
                r.rfq_code,
                r.rfq_date,
                r.rev_version,
                r.supplier_id,
                CONCAT(em.user_name) AS rfq_created_by,
                supplier_name 
            FROM 
                purchase_rfq r
            JOIN users em ON r.created_by = em.user_id
            JOIN supplier_master s ON r.supplier_id = s.supplier_id
            WHERE 
                r.rfq_date BETWEEN '$from' AND '$to'
                $user_condition 
                $supplier_condition 
            ORDER BY 
                r.rfq_date DESC
        ");

        return $query->result();
    }

    public function get_po_report_records(
        $from_date = null,
        $to_date = null,
        $supplier_id = '',
        $created_by = '',
        $report_type = '',
        $po_type = ''
    ) {
        if (empty($from_date) || empty($to_date)) {
            return [];
        }

        $from = date('Y-m-d', strtotime($from_date));
        $to   = date('Y-m-d', strtotime($to_date));

        $this->db->select('
            r.po_id,
            r.po_code,
            r.po_date,
            r.po_type,
            r.grand_total,
            r.po_status,
            r.grn_status,
            r.supplier_id,

            s.supplier_code,
            s.supplier_name,

            r.created_by,

            em.user_name AS rfq_created_by,

            CASE
                WHEN r.po_status = 0 THEN "Pending"
                WHEN r.po_status = 1 AND r.grn_status = 0 THEN "Awaiting GRN"
                WHEN r.po_status = 1 AND r.grn_status = 1 THEN "Completed"
                ELSE "Pending"
            END AS report_status
        ', false);

        $this->db->from('purchase_order_master r');

        $this->db->join(
            'users em',
            'em.user_id = r.created_by',
            'left'
        );

        $this->db->join(
            'supplier_master s',
            's.supplier_id = r.supplier_id',
            'left'
        );

        $this->db->where(
            'r.po_date >=',
            $from
        );

        $this->db->where(
            'r.po_date <=',
            $to
        );

        if (!empty($supplier_id)) {
            $this->db->where(
                'r.supplier_id',
                $supplier_id
            );
        }

        if (!empty($created_by)) {
            $this->db->where(
                'r.created_by',
                $created_by
            );
        }

        if (!empty($po_type)) {
            $this->db->where(
                'r.po_type',
                $po_type
            );
        }

        switch ($report_type) {
            case 'pending':
                $this->db->where(
                    'r.po_status',
                    0
                );
                break;

            case 'awaiting_grn':
                $this->db->where(
                    'r.po_status',
                    1
                );
                $this->db->where(
                    'r.grn_status',
                    0
                );
                break;

            case 'completed':

                $this->db->where(
                    'r.po_status',
                    1
                );
                $this->db->where(
                    'r.grn_status',
                    1
                );
                break;

            case 'all':
            default:
                break;
        }

        $this->db->order_by('r.po_date', 'DESC');
        $this->db->order_by('r.po_id', 'DESC');

        return $this->db->get()->result();
    }

    ///////////////////  PURCHASE RETURN REPORT  ///////////////////////

    public function get_purchase_return_report_records(
        $from_date = null,
        $to_date = null,
        $supplier_id = ''
    ) {

        /*
     * Convert dates if they are supplied in d-m-Y format.
     */

        if (!empty($from_date)) {

            $from_date_db =
                date(
                    'Y-m-d',
                    strtotime($from_date)
                );
        } else {

            $from_date_db =
                date('Y-m-01');
        }


        if (!empty($to_date)) {

            $to_date_db =
                date(
                    'Y-m-d',
                    strtotime($to_date)
                );
        } else {

            $to_date_db =
                date('Y-m-d');
        }


        $this->db->select("
            prm.return_id,
            prm.return_code,
            prm.return_date,
            prm.remarks,
            pgm.grn_code,
            sm.supplier_name,
            wm.warehouse_name,
            stm.store_name,
            im.product_code,
            im.product_name,
            um.unit_name,
            prt.return_qty
        ");


        $this->db->from(
            'purchase_return_master prm'
        );


        $this->db->join(
            'purchase_return_transaction prt',
            'prt.return_master_id = prm.return_id',
            'left'
        );


        $this->db->join(
            'purchase_grn_master pgm',
            'pgm.grn_id = prm.grn_id',
            'left'
        );


        $this->db->join(
            'supplier_master sm',
            'sm.supplier_id = prm.supplier_id',
            'left'
        );


        $this->db->join(
            'warehouse_master wm',
            'wm.warehouse_id = prm.warehouse_id',
            'left'
        );


        $this->db->join(
            'store_master stm',
            'stm.store_id = prm.store_id',
            'left'
        );


        $this->db->join(
            'item_master im',
            'im.product_id = prt.product_id',
            'left'
        );


        $this->db->join(
            'unit_master um',
            'um.unit_id = im.unit_id',
            'left'
        );


        $this->db->where(
            'prm.return_date >=',
            $from_date_db
        );


        $this->db->where(
            'prm.return_date <=',
            $to_date_db
        );


        if (!empty($supplier_id)) {

            $this->db->where(
                'prm.supplier_id',
                $supplier_id
            );
        }


        $this->db->order_by(
            'prm.return_date',
            'DESC'
        );


        $this->db->order_by(
            'prm.return_id',
            'DESC'
        );


        return $this->db
            ->get()
            ->result();
    }

    function get_grn_report_records()
    {
        $from = isset($_REQUEST['from_date']) ? date('Y-m-d', strtotime($_REQUEST['from_date'])) : '';
        $to = isset($_REQUEST['to_date']) ? date('Y-m-d', strtotime($_REQUEST['to_date'])) : '';

        // Fail early if no date filters
        if (empty($from) || empty($to)) {
            return [];
        }

        $created_by = isset($_REQUEST['created_by']) ? $_REQUEST['created_by'] : '';
        $supplier_id = isset($_REQUEST['supplier_id']) ? $_REQUEST['supplier_id'] : '';

        $user_condition = '';
        $supplier_condition = '';

        if ($created_by != '') {
            $user_condition = " AND r.created_by = '$created_by'";
        }

        if ($supplier_id != '') {
            $supplier_condition = " AND r.supplier_id = '$supplier_id'";
        }


        $query = $this->db->query("select r.grn_id,r.grn_code,r.grn_date, concat(em.user_name)as grn_created_by, supplier_name,r.grand_total from purchase_grn_master r, users em, supplier_master s where r.created_by=em.user_id and r.supplier_id=s.supplier_id and r.grn_date between '$from' and '$to'  $user_condition $supplier_condition order by r.grn_date desc;");
        return $query->result();
    }

    public function get_purchase_request_report_records()
    {
        $from = isset($_REQUEST['from_date'])
            ? date('Y-m-d', strtotime($_REQUEST['from_date']))
            : '';

        $to = isset($_REQUEST['to_date'])
            ? date('Y-m-d', strtotime($_REQUEST['to_date']))
            : '';

        // Fail early if no date filters
        if (empty($from) || empty($to)) {
            return [];
        }

        $created_by = isset($_REQUEST['created_by'])
            ? $_REQUEST['created_by']
            : '';

        $supplier_id = isset($_REQUEST['supplier_id'])
            ? $_REQUEST['supplier_id']
            : '';

        $this->db->select('
            pr.pr_id,
            pr.pr_code,
            pr.pr_date,
            pr.subject,
            pr.project,
            pr.ref,
            pr.remarks,
            pr.mi_id,

            b.branch_name,

            s.supplier_id,
            s.supplier_code,
            s.supplier_name,

            mi.mi_code,

            u.user_id AS created_by,
            u.user_name AS created_by_name,
            em.user_code AS created_by_code
        ');

        $this->db->from('purchase_requests pr');

        $this->db->join(
            'branch_master b',
            'b.branch_id = pr.branch_id',
            'left'
        );

        $this->db->join(
            'supplier_master s',
            's.supplier_id = pr.supplier_id',
            'left'
        );

        $this->db->join(
            'material_issue mi',
            'mi.mi_id = pr.mi_id',
            'left'
        );

        $this->db->join(
            'users u',
            'u.user_id = pr.created_by',
            'left'
        );

        $this->db->join(
            'employee_master em',
            'em.employee_id = u.employee_id',
            'left'
        );

        $this->db->where('pr.pr_date >=', $from);
        $this->db->where('pr.pr_date <=', $to);

        if ($created_by != '') {
            $this->db->where('pr.created_by', $created_by);
        }

        if ($supplier_id != '') {
            $this->db->where('pr.supplier_id', $supplier_id);
        }

        $this->db->order_by('pr.pr_date', 'DESC');
        $this->db->order_by('pr.pr_id', 'DESC');

        return $this->db->get()->result();
    }

    public function get_enquiry_report()
    {

        $from_date = $_POST['from_date'] ?? date('Y-m-d');
        $to_date = $_POST['to_date'] ?? date('Y-m-d');
        $customer = $_POST['customer'] ?? '';
        $sales_person = $_POST['sales_person'] ?? '';

        $this->db->select('em.*,cm.customer_name,u.user_name as sales_person,u2.user_name as created,u3.user_name as last_updated');
        $this->db->from('enquiry_master em');
        $this->db->join('customer_master cm', 'em.enquiry_customer=cm.customer_id', 'left');
        $this->db->join('users u', 'em.created_by=u.user_id', 'left');
        $this->db->join('users u2', 'em.created_by=u2.user_id', 'left');
        $this->db->join('users u3', 'em.updated_by=u3.user_id', 'left');

        if ($sales_person != '') {
            $this->db->where('em.created_by', $sales_person);
        }
        if ($customer != '') {
            $this->db->where('em.enquiry_customer', $customer);
        }
        $this->db->where("em.enquiry_date BETWEEN '$from_date' AND '$to_date'", null, false);
        $res = $this->db->get()->result();

        return $res;
    }


    public function print_enquiry_report()
    {
        $from_date1 = $_GET['from_date'] ?? date('Y-m-d');
        $to_date1 = $_GET['to_date'] ?? date('Y-m-d');
        $customer = $_GET['customer'] ?? '';
        $sales_person = $_GET['sales_person'] ?? '';

        $from_date = date('Y-m-d', strtotime($from_date1));
        $to_date = date('Y-m-d', strtotime($to_date1));


        $this->db->select('em.*, cm.customer_name, u.user_name as sales_person, u2.user_name as created, u3.user_name as last_updated');
        $this->db->from('enquiry_master em');
        $this->db->join('customer_master cm', 'em.enquiry_customer = cm.customer_id', 'left');
        $this->db->join('users u', 'em.sales_person = u.user_id', 'left');
        $this->db->join('users u2', 'em.created_by = u2.user_id', 'left');
        $this->db->join('users u3', 'em.updated_by = u3.user_id', 'left');

        if (!empty($sales_person)) {
            $this->db->where('em.created_by', $sales_person);
        }

        if (!empty($customer)) {
            $this->db->where('em.enquiry_customer', $customer);
        }

        $this->db->where("em.enquiry_date BETWEEN '$from_date' AND '$to_date'", null, false);

        $res = $this->db->get()->result();


        //   echo $this->db->last_query();

        return $res;
    }

    public function get_quotation_report()
    {
        $from_date     = $_POST['from_date'] ?? date('Y-m-d');
        $to_date       = $_POST['to_date'] ?? date('Y-m-d');
        $customer      = $_POST['customer'] ?? '';
        $status        = $_POST['status'] ?? '123';
        $sales_person  = $_POST['sales_person'] ?? '';

        $this->db->select('
        qm.*, 
        c.customer_name,
        COALESCE(u.user_name, "-") as created, 
        COALESCE(u2.user_name, "-") as last_updated
    ');

        $this->db->from('quotation_master qm');

        // ✅ Correct enquiry join
        $this->db->join(
            'enquiry_master enq',
            'qm.enquiry_id = enq.enquiry_id AND qm.quotation_type != "direct"',
            'left'
        );

        // ✅ Customer join (correct)
        $this->db->join(
            "customer_master c",
            "(
            (qm.quotation_type != 'direct' AND enq.enquiry_customer = c.customer_id) OR
            (qm.quotation_type = 'direct' AND qm.quotation_customer = c.customer_id)
        )",
            "left"
        );

        $this->db->join('users u', 'qm.created_by = u.user_id', 'left');
        $this->db->join('users u2', 'qm.updated_by = u2.user_id', 'left');

        // Status filter
        if ($status != '123') {
            $this->db->where('qm.aproval', $status);
        }

        // ✅ Customer filter
        if (!empty($customer)) {
            $this->db->group_start();
            $this->db->where('qm.quotation_customer', $customer);
            $this->db->or_where('enq.enquiry_customer', $customer);
            $this->db->group_end();
        }

        // ✅ Sales person filter
        if (!empty($sales_person)) {
            $this->db->where('qm.created_by', $sales_person);
        }

        // Date filter
        $this->db->where("qm.quotation_date >=", $from_date);
        $this->db->where("qm.quotation_date <=", $to_date);

        // ✅ ADD THIS
        $this->db->where("
    qm.quotation_revision = (
        SELECT MAX(q2.quotation_revision)
        FROM quotation_master q2
        WHERE q2.quotation_code = qm.quotation_code
    )
", null, false);

        $this->db->order_by('qm.qtn_id', 'DESC');

        return $this->db->get()->result();
    }
    public function get_print_quotation_report($filters = [])
    {
        $from_date    = $filters['from_date'] ?? date('Y-m-d');
        $to_date      = $filters['to_date'] ?? date('Y-m-d');
        $customer     = $filters['customer'] ?? '';
        $status       = $filters['status'] ?? '123';
        $sales_person = $filters['sales_person'] ?? '';

        $this->db->select('
        qm.*,
        c.customer_name,
        COALESCE(u.user_name,"-") as created,
        COALESCE(u2.user_name,"-") as last_updated
    ');

        $this->db->from('quotation_master qm');

        // COMMON JOINS (ALWAYS OUTSIDE CONDITION)
        $this->db->join('users u', 'qm.created_by = u.user_id', 'left');
        $this->db->join('users u2', 'qm.updated_by = u2.user_id', 'left');
        $this->db->join('estimation_master em', 'qm.estimation_id = em.estimation_id', 'left');
        $this->db->join('enquiry_master enq', 'em.enquiry_id = enq.enquiry_id', 'left');

        // CUSTOMER JOIN (UNIFIED)
        $this->db->join('customer_master c', "
        (
            (qm.quotation_type = 'direct' AND qm.quotation_customer = c.customer_id)
            OR
            (qm.quotation_type != 'direct' AND enq.enquiry_customer = c.customer_id)
        )
    ", 'left');

        // STATUS
        if ($status != '123') {
            $this->db->where('qm.aproval', $status);
        }

        // DATE FILTER
        $this->db->where('qm.quotation_date >=', $from_date);
        $this->db->where('qm.quotation_date <=', $to_date);

        // CUSTOMER FILTER
        if (!empty($customer)) {
            $this->db->group_start();
            $this->db->where('qm.quotation_customer', $customer);
            $this->db->or_where('enq.enquiry_customer', $customer);
            $this->db->group_end();
        }

        // SALES PERSON FILTER (IMPORTANT FIX)
        if (!empty($sales_person)) {
            $this->db->group_start();
            $this->db->where('qm.created_by', $sales_person);
            $this->db->or_where('enq.sales_person', $sales_person);
            $this->db->group_end();
        }

        // 🔥 FIX DUPLICATE REVISION ISSUE
        $this->db->where("
        qm.quotation_revision = (
            SELECT MAX(q2.quotation_revision)
            FROM quotation_master q2
            WHERE q2.quotation_code = qm.quotation_code
        )
    ", null, false);

        $this->db->order_by('qm.qtn_id', 'DESC');

        return $this->db->get()->result();
    }

    public function pi_report()
    {

        $from_date = $_POST['from_date'] ?? date('Y-m-d');
        $to_date = $_POST['to_date'] ?? date('Y-m-d');
        $customer = $_POST['customer'] ?? '';
        $quotation = $_POST['quotation'] ?? '';
        $status = $_POST['status'] ?? '';
        $sales_person = $_REQUEST['sales_person'] ?? '';

        $this->db->select('so.*,cm.customer_name,sqm.quotation_code,sqm.quotation_revision,u.user_name as created,u2.user_name as last_updated');
        $this->db->from('sales_order_master so');
        $this->db->join('quotation_master sqm', 'so.qtn_id=sqm.qtn_id', 'left');
        $this->db->join('estimation_master em', 'sqm.estimation_id=em.estimation_id', 'left');
        $this->db->join('enquiry_master enq', 'em.enquiry_id=enq.enquiry_id', 'left');
        $this->db->join('customer_master cm', 'enq.enquiry_customer=cm.customer_id', 'left');
        $this->db->join('users u', 'so.created_by=u.user_id', 'left');
        $this->db->join('users u2', 'so.updated_by=u2.user_id', 'left');

        if ($status != '') {
            $this->db->where('so.active', $status);
        }
        if ($quotation != '') {
            $this->db->where('so.qtn_id', $quotation);
        }
        if ($customer != '') {
            $this->db->where('enq.enquiry_customer', $customer);
        }
        if ($sales_person != '') {
            $this->db->where('so.created_by', $sales_person);
        }
        $this->db->where("so.so_date BETWEEN '$from_date' AND '$to_date'", null, false);
        $res = $this->db->get()->result();

        return $res;
    }
    public function print_pi_report()
    {

        $from_date = $_GET['from_date'] ?? date('Y-m-d');
        $to_date = $_GET['to_date'] ?? date('Y-m-d');
        $customer = $_GET['customer'] ?? '';
        $quotation = $_GET['quotation'] ?? '';
        $status = $_GET['status'] ?? '';
        $sales_person = $_GET['sales_person'] ?? '';

        $this->db->select('so.*,cm.customer_name,sqm.quotation_code,sqm.quotation_revision,u.user_name as created,u2.user_name as last_updated');
        $this->db->from('sales_order_master so');
        $this->db->join('quotation_master sqm', 'so.qtn_id=sqm.qtn_id', 'left');
        $this->db->join('estimation_master em', 'sqm.estimation_id=em.estimation_id', 'left');
        $this->db->join('enquiry_master enq', 'em.enquiry_id=enq.enquiry_id', 'left');
        $this->db->join('customer_master cm', 'enq.enquiry_customer=cm.customer_id', 'left');
        $this->db->join('users u', 'so.created_by=u.user_id', 'left');
        $this->db->join('users u2', 'so.updated_by=u2.user_id', 'left');

        if ($status != '') {
            $this->db->where('so.active', $status);
        }
        if ($quotation != '') {
            $this->db->where('so.qtn_id', $quotation);
        }
        if ($customer != '') {
            $this->db->where('enq.enquiry_customer', $customer);
        }
        if ($sales_person != '') {
            $this->db->where('so.created_by', $sales_person);
        }
        $this->db->where("so.so_date BETWEEN '$from_date' AND '$to_date'", null, false);
        $res = $this->db->get()->result();

        return $res;
    }

    ///////////////////// Stock Movement Report //////////////////////

    public function get_stock_movement_report()
    {
        $from          = $this->input->post('from_date');
        $to            = $this->input->post('to_date');
        $warehouse_id  = $this->input->post('warehouse_id');
        $store_id      = $this->input->post('store_id');
        $product_id    = $this->input->post('product_id');
        $movement_type = $this->input->post('movement_type');

        $condition = '';

        // Date
        if (!empty($from)) {
            $condition .= " AND DATE(sd.stock_date) >= "
                . $this->db->escape($from);
        }

        if (!empty($to)) {
            $condition .= " AND DATE(sd.stock_date) <= "
                . $this->db->escape($to);
        }

        // Warehouse
        if ($warehouse_id != '') {
            $condition .= " AND sd.warehouse_id = "
                . $this->db->escape($warehouse_id);
        }

        // Store
        if ($store_id != '') {
            $condition .= " AND sd.store_id = "
                . $this->db->escape($store_id);
        }

        // Product
        if ($product_id != '') {
            $condition .= " AND sd.product_id = "
                . $this->db->escape($product_id);
        }

        // Movement Type
        if ($movement_type != '') {
            $condition .= " AND sd.stock_type = "
                . $this->db->escape($movement_type);
        }

        $sql = "
            SELECT
                sd.stock_id,
                sd.stock_date,

                sd.product_id,
                im.product_code,
                im.product_name,

                sd.stock_type,
                sd.quantity,
                sd.price,

                sd.bill_no,
                sd.order_ref_no,

                sd.warehouse_id,
                wm.warehouse_name,

                sd.store_id,
                sm.store_name,

                sd.storage_location,
                sd.item_remark,
                sd.remark,

                sd.trans_id,
                sd.adjustment_id,

                sd.created_by,
                u.user_name AS created_user,
                sd.created_date

            FROM stock_details sd

            LEFT JOIN item_master im
                ON im.product_id = sd.product_id

            LEFT JOIN warehouse_master wm
                ON wm.warehouse_id = sd.warehouse_id

            LEFT JOIN store_master sm
                ON sm.store_id = sd.store_id

            LEFT JOIN users u
                ON u.user_id = sd.created_by

            WHERE 1 = 1

            $condition

            ORDER BY
                sd.stock_date ASC,
                sd.stock_id ASC
        ";

        return $this->db->query($sql)->result();
    }

    ///////////////////// STOCK LEDGER REPORT /////////////////////
    
    public function get_stock_ledger_report(
        $from_date = null,
        $to_date = null,
        $warehouse_id = '',
        $store_id = '',
        $product_id = ''
    ) {
        if (empty($from_date)) {
            $from_date = date('Y-m-01');
        }

        if (empty($to_date)) {
            $to_date = date('Y-m-d');
        }

        $from = date(
            'Y-m-d',
            strtotime($from_date)
        );

        $to = date(
            'Y-m-d',
            strtotime($to_date)
        );


        $this->db->select("
            COALESCE(
                SUM(
                    CASE
                        WHEN stock_type = 'IN'
                        THEN quantity
                        WHEN stock_type = 'OUT'
                        THEN -quantity
                        ELSE 0
                    END
                ),
                0
            ) AS opening_balance
        ", false);

        $this->db->from('stock_details');

        $this->db->where(
            'DATE(stock_date) <',
            $from
        );


        if (!empty($warehouse_id)) {

            $this->db->where(
                'warehouse_id',
                $warehouse_id
            );
        }


        if (!empty($store_id)) {

            $this->db->where(
                'store_id',
                $store_id
            );
        }


        if (!empty($product_id)) {

            $this->db->where(
                'product_id',
                $product_id
            );
        }


        $opening_query =
            $this->db->get()
            ->row();


        $opening_balance =
            !empty($opening_query)
            ? (float)$opening_query->opening_balance
            : 0;


        $this->db->select("
            sd.stock_id,
            sd.stock_date,

            sd.product_id,

            im.product_code,
            im.product_name,

            sd.stock_type,
            sd.quantity,
            sd.price,

            sd.bill_no,
            sd.order_ref_no,

            sd.warehouse_id,
            wm.warehouse_name,

            sd.store_id,
            sm.store_name,

            sd.storage_location,

            sd.item_remark,
            sd.remark,

            sd.trans_id,
            sd.adjustment_id,

            sd.created_by,
            u.user_name AS created_user,

            sd.created_date
        ", false);


        $this->db->from(
            'stock_details sd'
        );

        $this->db->join(
            'item_master im',
            'im.product_id = sd.product_id',
            'left'
        );

        $this->db->join(
            'warehouse_master wm',
            'wm.warehouse_id = sd.warehouse_id',
            'left'
        );

        $this->db->join(
            'store_master sm',
            'sm.store_id = sd.store_id',
            'left'
        );

        $this->db->join(
            'users u',
            'u.user_id = sd.created_by',
            'left'
        );

        $this->db->where(
            'DATE(sd.stock_date) >=',
            $from
        );

        $this->db->where(
            'DATE(sd.stock_date) <=',
            $to
        );

        if (!empty($warehouse_id)) {
            $this->db->where(
                'sd.warehouse_id',
                $warehouse_id
            );
        }


        if (!empty($store_id)) {
            $this->db->where(
                'sd.store_id',
                $store_id
            );
        }


        if (!empty($product_id)) {
            $this->db->where(
                'sd.product_id',
                $product_id
            );
        }


        $this->db->order_by(
            'sd.stock_date',
            'ASC'
        );

        $this->db->order_by(
            'sd.stock_id',
            'ASC'
        );

        $transactions = $this->db->get()->result();
        $balance = $opening_balance;
        $records = array();

        foreach ($transactions as $row) {
            $stock_in = 0;
            $stock_out = 0;

            if (
                strtoupper($row->stock_type) == 'IN'
            ) {
                $stock_in = (float)$row->quantity;
                $balance += $stock_in;
            } elseif (
                strtoupper($row->stock_type) == 'OUT'
            ) {
                $stock_out = (float)$row->quantity;
                $balance -= $stock_out;
            }


            $reference = '-';

            if (
                !empty($row->bill_no)
            ) {
                $reference = $row->bill_no;
            } elseif (
                !empty($row->order_ref_no)
            ) {
                $reference = $row->order_ref_no;
            } elseif (
                !empty($row->trans_id)
            ) {
                $reference = 'Transaction: ' . $row->trans_id;
            } elseif (
                !empty($row->adjustment_id)
            ) {
                $reference = 'Adjustment: ' . $row->adjustment_id;
            }

            $row->opening_balance = $opening_balance;
            $row->stock_in = $stock_in;
            $row->stock_out = $stock_out;
            $row->closing_balance =  $balance;
            $row->reference = $reference;
            $opening_balance = $balance;
            $records[] = $row;
        }


        return $records;
    }

    ///////////////////// STOCK VALUATION REPORT /////////////////////
    public function get_stock_valuation_report($warehouse_id = '', $store_id = '', $product_id = '')
    {
        $condition = '';
        $allocation_condition = '';

        if (!empty($warehouse_id)) {
            $condition .= ' AND sd.warehouse_id = ' . $this->db->escape($warehouse_id);
            $allocation_condition .= ' AND sa.warehouse_id = ' . $this->db->escape($warehouse_id);
        }

        if (!empty($store_id)) {
            $condition .= ' AND sd.store_id = ' . $this->db->escape($store_id);
            $allocation_condition .= ' AND sa.store_id = ' . $this->db->escape($store_id);
        }

        if (!empty($product_id)) {
            $condition .= ' AND sd.product_id = ' . $this->db->escape($product_id);
            $allocation_condition .= ' AND sa.product_id = ' . $this->db->escape($product_id);
        }

        $sql = "
            SELECT
                stock.product_id,
                im.product_code,
                im.product_name,
                stock.warehouse_id,
                wm.warehouse_name,
                stock.store_id,
                sm.store_name,
                stock.stock_qty,
                COALESCE(
                    allocation.allocated_qty,
                    0
                ) AS allocated_qty,
                (
                    stock.stock_qty -
                    COALESCE(
                        allocation.allocated_qty,
                        0
                    )
                ) AS available_qty,
                stock.unit_price,
                (
                    stock.stock_qty *
                    stock.unit_price
                ) AS stock_value
            FROM
            (
                SELECT
                    sd.product_id,
                    sd.warehouse_id,
                    sd.store_id,
                    SUM(
                        CASE
                            WHEN sd.stock_type = 'IN'
                            THEN COALESCE(
                                sd.balance_qty,
                                0
                            )
                            ELSE 0
                        END
                    ) AS stock_qty,
                    MAX(
                        CASE
                            WHEN sd.stock_type = 'IN'
                            THEN sd.price
                            ELSE 0
                        END
                    ) AS unit_price
                FROM stock_details sd
                WHERE 1 = 1
                $condition
                GROUP BY
                    sd.product_id,
                    sd.warehouse_id,
                    sd.store_id
            ) stock
            INNER JOIN item_master im
                ON im.product_id = stock.product_id
            LEFT JOIN warehouse_master wm
                ON wm.warehouse_id = stock.warehouse_id
            LEFT JOIN store_master sm
                ON sm.store_id = stock.store_id
            LEFT JOIN
            (
                SELECT
                    sa.product_id,
                    sa.warehouse_id,
                    sa.store_id,
                    SUM(
                        COALESCE(
                            sa.allocation,
                            0
                        )
                    ) AS allocated_qty
                FROM stock_details sa
                WHERE
                    sa.stock_type = 'IN'
                    AND sa.status = '0'
                    $allocation_condition
                GROUP BY
                    sa.product_id,
                    sa.warehouse_id,
                    sa.store_id
            ) allocation
                ON allocation.product_id =
                stock.product_id
                AND allocation.warehouse_id =
                    stock.warehouse_id
                AND allocation.store_id =
                    stock.store_id
            WHERE
                stock.stock_qty > 0
            ORDER BY
                im.product_name ASC,
                im.product_code ASC
        ";

        return $this->db->query($sql)->result();
    }
}
