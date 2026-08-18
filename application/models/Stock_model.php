<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Stock_Model extends CI_Model
{
    function stock_adjustment_details()
    {
        $this->db->trans_begin();

        $d1 = date('Y');
        $prefix = 'Adj/' . $d1 . '/';
        $this->load->model('Setup_model');

        $num = $this->Setup_model->get_next_code($prefix, 'stock_code', 'stock_adjustment', 10) + 1;

        $digit = sprintf("%1$04d", $num);
        $stock_code = $prefix . $digit;
        $user_id = $this->session->userdata('user_id');

        $master_data = array(
            'stock_code'   => $stock_code,
            'stock_date'   => date('Y-m-d', strtotime($this->input->post('date'))),
            'warehouse_id' => $this->input->post('warehouse_id'),
            'stock_type'   => $this->input->post('inward_type'),
            'product_id'   => $this->input->post('product_id'),
            'item_desc'    => $this->input->post('desc'),
            'remark'       => $this->input->post('remark'),
            'created_by'   => $user_id,
            'created_date' => date('Y-m-d H:i:s'),
            'status'       => 0
        );

        $this->db->insert(
            'stock_adjustment',
            $master_data
        );

        $adjustment_id = $this->db->insert_id();
        if (!$adjustment_id) {
            $this->db->trans_rollback();
            return false;
        }

        $bill_no = $this->input->post('bill_entry');
        $ref_no  = $this->input->post('ref_no');
        $qty     = $this->input->post('qty');
        $price   = $this->input->post('price');

        $storage_location = $this->input->post('storage_location');
        $item_remark      = $this->input->post('item_remark');

        $detail_data = array(
            'adjustment_id'     => $adjustment_id,
            'product_id'        => $this->input->post('product_id'),
            'bill_no'           => $bill_no,
            'order_ref_no'      => $ref_no,
            'quantity'          => $qty,
            'price'             => $price,
            'storage_location'  => $storage_location,
            'item_remark'       => $item_remark,
            'created_by'        => $user_id,
            'created_date'      => date('Y-m-d H:i:s')
        );

        $this->db->insert(
            'stock_adjustment_details',
            $detail_data
        );

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();

        return $adjustment_id;
    }

    function get_stock_adjustment_list()
    {
        $query = $this->db->query("
            SELECT
                a.*,
                i.product_code,
                i.product_name,
                u.user_name AS created_user,
                au.user_name AS approved_user,
                w.warehouse_name
            FROM stock_adjustment a
            LEFT JOIN item_master i
                ON a.product_id = i.product_id
            LEFT JOIN users u
                ON a.created_by = u.user_id
            LEFT JOIN users au
                ON a.approved_by = au.user_id
            LEFT JOIN warehouse_master w
                ON a.warehouse_id = w.warehouse_id
            ORDER BY a.sno DESC
        ");

        return $query->result();
    }

    // function get_stock_adjustment_by_id($doc_id){
    //     $query = $this->db->query("select * from stock_adjustment where sno =$doc_id");
    //     return $query->result();
    // }

    function get_stock_adjustment_by_id($doc_id)
    {
        $query = $this->db->query("
        SELECT sa.*, 
               im.product_name,
               im.description,
               um.unit_name
        FROM stock_adjustment sa
        LEFT JOIN item_master im ON sa.product_id = im.product_id
        LEFT JOIN unit_master um ON im.unit_id = um.unit_id
        WHERE sa.sno = '$doc_id'
    ");

        return $query->result();
    }

    function get_stock_adjustment_tr($id)
    {
        $this->db->select('
            sad.*,
            im.product_code,
            im.product_name,
            um.unit_name
        ');

        $this->db->from('stock_adjustment_details sad');

        $this->db->join(
            'item_master im',
            'im.product_id = sad.product_id',
            'left'
        );

        $this->db->join(
            'unit_master um',
            'um.unit_id = im.unit_id',
            'left'
        );

        $this->db->where(
            'sad.adjustment_id',
            $id
        );

        return $this->db->get()->result();
    }

    function approve_stock_adjustment($adjustment_id)
    {
        $this->db->trans_begin();

        $user_id = $this->session->userdata('user_id');

        $adjustment = $this->db
            ->where('sno', $adjustment_id)
            ->get('stock_adjustment')
            ->row();

        if (!$adjustment) {
            $this->db->trans_rollback();
            return array(
                'success' => false,
                'message' => 'Stock Adjustment not found.'
            );
        }

        if ((int)$adjustment->status !== 0) {
            $this->db->trans_rollback();
            return array(
                'success' => false,
                'message' => 'This Stock Adjustment has already been processed.'
            );
        }

        $details = $this->db
            ->where('adjustment_id', $adjustment_id)
            ->get('stock_adjustment_details')
            ->result();

        if (empty($details)) {
            $this->db->trans_rollback();
            return array(
                'success' => false,
                'message' => 'No adjustment items found.'
            );
        }

        if (
            $adjustment->stock_type == 'Opening' ||
            $adjustment->stock_type == 'IN'
        ) {
            $stock_type = 'IN';
        } else {
            $stock_type = 'OUT';
        }

        foreach ($details as $detail) {

            $quantity = (float)$detail->quantity;
            if ($quantity <= 0) {
                $this->db->trans_rollback();
                return array(
                    'success' => false,
                    'message' => 'Adjustment quantity must be greater than zero.'
                );
            }

            if ($stock_type == 'IN') {
                $stock_data = array(
                    'trans_id'          => $adjustment_id,
                    'adjustment_id'     => $adjustment_id,
                    'stock_date'        => $adjustment->stock_date,
                    'stock_type'        => 'IN',
                    'warehouse_id'      => $adjustment->warehouse_id,
                    'product_id'        => $detail->product_id,
                    'item_desc'         => $adjustment->item_desc,
                    'bill_no'           => $detail->bill_no,
                    'order_ref_no'      => $detail->order_ref_no,
                    'quantity'          => $quantity,
                    'balance_qty'       => $quantity,
                    'price'             => $detail->price,
                    'storage_location'  => $detail->storage_location,
                    'item_remark'       => $detail->item_remark,
                    'remark'            => 'Stock Adjustment',
                    'created_by'        => $user_id,
                    'created_date'      => date('Y-m-d H:i:s'),
                    'status'            => 0
                );

                $this->db->insert('stock_details',$stock_data);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return array(
                        'success' => false,
                        'message' => 'Unable to create IN stock record.'
                    );
                }
            } else {

                $remaining_qty = $quantity;

                $available_stock = $this->db->query("
                    SELECT
                        stock_id,
                        balance_qty
                    FROM stock_details
                    WHERE product_id = ?
                    AND warehouse_id = ?
                    AND stock_type = 'IN'
                    AND status = '0'
                    AND balance_qty > 0
                    ORDER BY stock_date ASC, stock_id ASC
                    FOR UPDATE
                ", array(
                        $detail->product_id,
                        $adjustment->warehouse_id
                    ))->result();

                $available_qty = 0;

                foreach ($available_stock as $stock) {
                    $available_qty += (float)$stock->balance_qty;
                }

                if ($available_qty < $quantity) {

                    $this->db->trans_rollback();

                    return array(
                        'success' => false,
                        'message' =>
                        'Insufficient stock available. ' .
                            'Available: ' . number_format($available_qty, 2) .
                            ', Requested: ' . number_format($quantity, 2)
                    );
                }

                foreach ($available_stock as $stock) {
                    if ($remaining_qty <= 0) {
                        break;
                    }

                    $current_balance = (float)$stock->balance_qty;
                    if ($current_balance <= 0) {
                        continue;
                    }

                    $consume_qty = min($remaining_qty,$current_balance);
                    $new_balance = $current_balance - $consume_qty;

                    // Avoid tiny decimal values
                    if (abs($new_balance) < 0.000001) {
                        $new_balance = 0;
                    }

                    $this->db
                        ->where('stock_id', $stock->stock_id)
                        ->update(
                            'stock_details',
                            array(
                                'balance_qty' => $new_balance
                            )
                        );

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        return array(
                            'success' => false,
                            'message' => 'Unable to update existing stock balance.'
                        );
                    }

                    $remaining_qty -= $consume_qty;
                }

                if ($remaining_qty > 0.000001) {
                    $this->db->trans_rollback();
                    return array(
                        'success' => false,
                        'message' => 'Unable to allocate sufficient stock.'
                    );
                }

                $stock_data = array(
                    'trans_id'          => $adjustment_id,
                    'adjustment_id'     => $adjustment_id,
                    'stock_date'        => $adjustment->stock_date,
                    'stock_type'        => 'OUT',
                    'warehouse_id'      => $adjustment->warehouse_id,
                    'product_id'        => $detail->product_id,
                    'item_desc'         => $adjustment->item_desc,
                    'bill_no'           => $detail->bill_no,
                    'order_ref_no'      => $detail->order_ref_no,
                    'quantity'          => $quantity,
                    'balance_qty'       => 0,
                    'price'             => $detail->price,
                    'storage_location'  => $detail->storage_location,
                    'item_remark'       => $detail->item_remark,
                    'remark'            => 'Stock Adjustment',
                    'created_by'        => $user_id,
                    'created_date'      => date('Y-m-d H:i:s'),
                    'status'            => 0
                );

                $this->db->insert(
                    'stock_details',
                    $stock_data
                );

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return array(
                        'success' => false,
                        'message' => 'Unable to create OUT stock record.'
                    );
                }
            }
        }

        $this->db
            ->where('sno', $adjustment_id)
            ->update(
                'stock_adjustment',
                array(
                    'status'        => 1,
                    'approved_by'   => $user_id,
                    'approved_date' => date('Y-m-d H:i:s')
                )
            );

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            return array(
                'success' => false,
                'message' => 'Unable to approve Stock Adjustment.'
            );
        }

        $this->db->trans_commit();

        return array(
            'success' => true,
            'message' => 'Stock Adjustment approved successfully.'
        );
    }

    function update_stock_adjustment_records()
    {
        $adjustment_id = (int)$this->input->post('sno');
        $user_id       = $this->session->userdata('user_id');

        if ($adjustment_id <= 0) {
            return false;
        }
        $this->db->trans_begin();

        $adjustment = $this->db
            ->where('sno', $adjustment_id)
            ->get('stock_adjustment')
            ->row();

        if (!$adjustment) {
            $this->db->trans_rollback();
            return false;
        }

        if ((int)$adjustment->status !== 0) {
            $this->db->trans_rollback();
            return false;
        }

        $master_data = array(
            'warehouse_id' => $this->input->post('warehouse_id'),
            'remark'       => $this->input->post('remark')
        );

        $this->db->where('sno', $adjustment_id)->update('stock_adjustment', $master_data);
        $detail_ids = $this->input->post('adjustment_detail_id');

        if (!empty($detail_ids) && is_array($detail_ids)) {

            $bill_entries        = $this->input->post('bill_entry');
            $ref_nos             = $this->input->post('ref_no');
            $quantities          = $this->input->post('qty');
            $prices              = $this->input->post('price');
            $storage_locations   = $this->input->post('storage_location');
            $item_remarks        = $this->input->post('item_remark');

            foreach ($detail_ids as $i => $detail_id) {
                $detail_id = (int)$detail_id;

                if ($detail_id <= 0) {
                    continue;
                }

                $existing_detail = $this->db
                    ->where('adjustment_detail_id', $detail_id)
                    ->where('adjustment_id', $adjustment_id)
                    ->get('stock_adjustment_details')
                    ->row();

                if (!$existing_detail) {
                    continue;
                }

                $detail_data = array(
                    'bill_no'          => isset($bill_entries[$i]) ? trim($bill_entries[$i]) : null,
                    'order_ref_no'     => isset($ref_nos[$i]) ? trim($ref_nos[$i]) : null,
                    'quantity'         => isset($quantities[$i]) ? (float)$quantities[$i] : 0,
                    'price'            => (isset($prices[$i]) && $prices[$i] !== '') ? (float)$prices[$i] : null,
                    'storage_location' => isset($storage_locations[$i]) ? trim($storage_locations[$i]) : null,
                    'item_remark'      => isset($item_remarks[$i]) ? trim($item_remarks[$i]) : null
                );

                $this->db->where('adjustment_detail_id', $detail_id)->where('adjustment_id', $adjustment_id)
                    ->update(
                        'stock_adjustment_details',
                        $detail_data
                    );
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

    function min_stock_add_records()
    {
        $item_id = $this->input->post('item');
        $min_stock_qty = $this->input->post('min_stock_qty');

        // Check duplicate product
        $existing = $this->db
            ->where('item_id', $item_id)
            ->get('min_stock_qty')
            ->row();

        if ($existing) {
            return false;
        }

        $data = array(
            'item_id'       => $item_id,
            'min_stock_qty' => $min_stock_qty,
            'created_by'    => $this->session->userdata('user_id'),
            'created_on'    => date('Y-m-d H:i:s')
        );

        return $this->db->insert('min_stock_qty', $data);
    }

    function get_min_stock_list()
    {
        $query = $this->db->query("SELECT * FROM min_stock_qty a left join item_master b on a.item_id=b.product_id;");
        return $query->result();
    }
    function get_min_stock_by_id($item_id)
    {
        $this->db->select('
            ms.item_id,
            ms.min_stock_qty,
            im.product_name,
            im.description
        ');
        $this->db->from('min_stock_qty ms');
        $this->db->join(
            'item_master im',
            'im.product_id = ms.item_id',
            'left'
        );
        $this->db->where('ms.item_id', $item_id);

        return $this->db->get()->row();
    }

    function update_min_stock_records()
    {
        $item_id = $this->input->post('item');
        $min_stock_qty = $this->input->post('min_stock_qty');

        $data = array(
            'min_stock_qty' => $min_stock_qty
        );

        $this->db->where('item_id', $item_id);

        return $this->db->update('min_stock_qty', $data);
    }

    function get_reorder_stock_list()
    {
        $warehouse_id = $this->input->post("warehouse_id");

        $warehouse_condition_stock = '';

        if (!empty($warehouse_id)) {
            $warehouse_condition_stock = " AND sd.warehouse_id = " . $this->db->escape($warehouse_id);
        }

        $sql = "
            SELECT
                ms.item_id,
                im.product_code AS item_code,
                im.product_name,
                im.description AS item_description,
                im.unit_id,
                ms.min_stock_qty,
                COALESCE(stock.inv_stock, 0) AS invstock,
                COALESCE(po.po_stock, 0) AS postock,
                (
                    COALESCE(stock.inv_stock, 0)
                    +
                    COALESCE(po.po_stock, 0)
                ) AS total_stock,
                GREATEST(
                    ms.min_stock_qty
                    -
                    (
                        COALESCE(stock.inv_stock, 0)
                        +
                        COALESCE(po.po_stock, 0)
                    ),
                    0
                ) AS reorder_qty
            FROM min_stock_qty ms
            INNER JOIN item_master im
                ON im.product_id = ms.item_id
            LEFT JOIN
            (
                SELECT
                    sd.product_id,
                    SUM(sd.balance_qty) AS inv_stock
                FROM stock_details sd
                WHERE sd.stock_type = 'IN'
                AND sd.status = '0'
                $warehouse_condition_stock
                GROUP BY sd.product_id
            ) stock
                ON stock.product_id = ms.item_id
            LEFT JOIN
            (
                SELECT
                    pot.product_id,
                    SUM(pot.quantity) AS po_stock
                FROM purchase_order_transaction pot
                INNER JOIN purchase_order_master pom
                    ON pom.po_id = pot.po_master_id
                WHERE pom.grn_status = 0
                AND pom.cancelled = 0
                GROUP BY pot.product_id
            ) po
                ON po.product_id = ms.item_id
            WHERE
                (
                    COALESCE(stock.inv_stock, 0)
                    +
                    COALESCE(po.po_stock, 0)
                ) < ms.min_stock_qty
            ORDER BY im.product_name ASC
        ";

        return $this->db->query($sql)->result();
    }

    function get_reorder_stock_for_PO($product_ids = array())
    {
        if (empty($product_ids)) {
            return [];
        }

        $product_ids = array_filter(
            array_map('intval', $product_ids)
        );

        if (empty($product_ids)) {
            return [];
        }

        $sql = "
                SELECT
                    ms.item_id AS product_id,
                    im.product_code,
                    im.product_name,
                    im.description AS item_description,
                    im.unit_id,
                    COALESCE(stock.inv_stock, 0) AS invstock,
                    COALESCE(po.po_stock, 0) AS postock,
                    (
                        COALESCE(stock.inv_stock, 0)
                        +
                        COALESCE(po.po_stock, 0)
                    ) AS total_stock,
                    ms.min_stock_qty,
                    GREATEST(
                        ms.min_stock_qty
                        -
                        (
                            COALESCE(stock.inv_stock, 0)
                            +
                            COALESCE(po.po_stock, 0)
                        ),
                        0
                    ) AS reorder_qty,
                    COALESCE(im.retail_price, 0) AS unit_price
                FROM min_stock_qty ms
                INNER JOIN item_master im
                    ON im.product_id = ms.item_id
                LEFT JOIN
                (
                    SELECT
                        sd.product_id,
                        SUM(sd.balance_qty) AS inv_stock
                    FROM stock_details sd
                    WHERE sd.stock_type = 'IN'
                    AND sd.status = '0'
                    GROUP BY sd.product_id
                ) stock
                    ON stock.product_id = ms.item_id
                LEFT JOIN
                (
                    SELECT
                        pot.product_id,
                        SUM(pot.quantity) AS po_stock
                    FROM purchase_order_transaction pot
                    INNER JOIN purchase_order_master pom
                        ON pom.po_id = pot.po_master_id
                    WHERE pom.grn_status = 0
                    AND pom.cancelled = 0
                    GROUP BY pot.product_id
                ) po
                    ON po.product_id = ms.item_id
                WHERE ms.item_id IN (" . implode(',', $product_ids) . ")
                ORDER BY im.product_name ASC
            ";

        return $this->db->query($sql)->result();
    }

    function delete_min_stock($id)
    {
        $this->db->where('item_id', $id);
        return $this->db->delete('min_stock_qty');
    }
    //     function get_stock_inventory_report($wh_id,$item_id)
    //     {

    //         $warehouse_id = !empty($wh_id) ? $wh_id : $this->input->post("warehouse_id");
    //         $model_code   = !empty($item_id) ? $item_id : $this->input->post("product_id");

    //     	$itemcondition='';
    //     	if($model_code!=''){
    // 			$itemcondition="and s.product_id='$model_code'";
    // 		}else{
    // 			$itemcondition="and s.product_id is not null";
    // 		}

    // 	$query = $this->db->query("SELECT zero.*,(COALESCE(one.in_qty, 0) - COALESCE(two.out_qty, 0)) AS stock,four.allocation,five.price AS costprice,six.price as saleprice FROM (SELECT s.*, i.item_code, i.item_model FROM stock_details s JOIN item_master i ON s.product_id = i.item_id WHERE s.warehouse_id = '' $itemcondition GROUP BY s.product_id) AS zero LEFT JOIN (SELECT COALESCE(SUM(quantity), 0) AS in_qty, product_id FROM stock_details WHERE stock_type = 'IN' GROUP BY product_id) AS one ON zero.product_id = one.product_id LEFT JOIN (SELECT COALESCE(SUM(quantity), 0) AS out_qty, product_id FROM stock_details WHERE stock_type = 'OUT' GROUP BY product_id) AS two ON zero.product_id = two.product_id LEFT JOIN (SELECT COALESCE(SUM(allocation), 0) AS allocation, s.product_id FROM stock_details s JOIN item_master i ON s.product_id = i.item_id WHERE s.stock_type = 'IN' AND s.status = '0' GROUP BY s.product_id) AS four ON zero.product_id = four.product_id LEFT JOIN (SELECT product_id, price FROM stock_details WHERE stock_type = 'IN' ORDER BY stock_date DESC LIMIT 1) AS five ON zero.product_id = five.product_id LEFT JOIN (SELECT product_id, price FROM stock_details WHERE stock_type = 'OUT' ORDER BY stock_date DESC LIMIT 1) AS six ON zero.product_id = six.product_id;");
    // //    echo $this->db->last_query();
    // //    exit;
    // 	return $query->result();
    //     }

    public function get_stock_inventory_report()
    {
        $warehouse_id = $this->input->post("warehouse_id");
        $store_id     = $this->input->post("store_id");
        $product_id   = $this->input->post("product_id");

        $condition = "";

        if ($warehouse_id != '') {
            $condition .= " AND s.warehouse_id = '$warehouse_id' ";
        }

        if ($store_id != '') {
            $condition .= " AND s.store_id = '$store_id' ";
        }

        if ($product_id != '') {
            $condition .= " AND s.product_id = '$product_id' ";
        }

        $sql = "
            SELECT
                zero.*,
                COALESCE(one.stock,0) AS stock,
                COALESCE(four.allocation,0) AS allocation

            FROM
            (
                SELECT
                    s.product_id,
                    MAX(s.price) AS price,
                    i.product_code,
                    i.product_name
                FROM stock_details s
                INNER JOIN item_master i
                    ON i.product_id = s.product_id
                WHERE 1=1
                $condition
                GROUP BY s.product_id
            ) AS zero

            LEFT JOIN
            (
                SELECT
                    product_id,
                    SUM(balance_qty) AS stock
                FROM stock_details
                WHERE stock_type='IN'
                " . ($warehouse_id != '' ? "AND warehouse_id='$warehouse_id'" : "") . "
                " . ($store_id != '' ? "AND store_id='$store_id'" : "") . "
                GROUP BY product_id
            ) AS one
            ON zero.product_id = one.product_id

            LEFT JOIN
            (
                SELECT
                    product_id,
                    SUM(allocation) AS allocation
                FROM stock_details
                WHERE stock_type='IN'
                AND status='0'
                " . ($warehouse_id != '' ? "AND warehouse_id='$warehouse_id'" : "") . "
                " . ($store_id != '' ? "AND store_id='$store_id'" : "") . "
                GROUP BY product_id
            ) AS four
            ON zero.product_id = four.product_id
            ORDER BY zero.product_name
            ";

        return $this->db->query($sql)->result();
    }

    //Stock Allocation
    function get_all_stock_allocations()
    {
        $this->db->select();
        $this->db->from('stock_allocation_master sam');
        $this->db->join('pi_master pi', 'sam.pi_master_id=pi.pi_id', 'left');
        $this->db->order_by('allocation_code', 'DESC');
        $res = $this->db->get()->result();

        return $res;
    }

    function get_stock_allocation_by_id($allocation_id)
    {
        $this->db->select();
        $this->db->from('stock_allocation_master sam');
        $this->db->join('pi_master pi', 'sam.pi_master_id=pi.pi_id', 'left');
        $this->db->where('allocation_id', $allocation_id);
        $res = $this->db->get()->row_array();

        return $res;
    }

    function get_stock_allocation_details_by_id($allocation_id)
    {

        $this->db->select();
        $this->db->from('stock_allocation_details sad');
        $this->db->join('stock_allocation_master sam', 'sad.allocation_master_id=sam.allocation_id');
        $this->db->join('pi_details pd', 'sad.pi_detail_id=pd.pi_detail_id', 'left');
        $this->db->join('estimation_details ed', 'pd.quotation_detail_id=ed.detail_id', 'left');
        $this->db->join('item_master im', 'ed.item_id=im.product_id', 'left');
        // $this->db->join('brand_master bm', 'im.item_brand=bm.brand_id', 'left');
        $this->db->join('unit_master um', 'ed.unit_id=um.unit_id', 'left');
        $this->db->where('pd.detail_status >=', 0);
        $this->db->where('sad.allocation_master_id', $allocation_id);
        $res = $this->db->get()->result();

        return $res;
    }

    function update_stock_allocation_data()
    {
        for ($i = 0; $i <= $_POST['row_count']; $i++) {
            $allocation_detail_id = $_POST['allocation_detail_id'][$i];
            $new_allocation_quantity = $_POST['quantity'][$i];

            $this->db->select();
            $this->db->from('stock_details');
            $this->db->where('allocation_id', $allocation_detail_id);
            $query = $this->db->get();
            $rows = $query->result_array();
            $previous_allocation_quantity = count($rows);
            if ($previous_allocation_quantity >  $new_allocation_quantity) {
                $keep_ids = array_column(array_slice($rows, 0, $new_allocation_quantity), 'stock_id'); // IDs to keep as is
                $update_ids = array_column(array_slice($rows, $new_allocation_quantity), 'stock_id');  // IDs to update to alloc_id = 0     

                if (!empty($update_ids)) {
                    $this->db->where_in('stock_id', $update_ids);
                    $res = $this->db->update('stock_details', ['status' => 0, 'allocation_id' => 0]);
                }
            } else if ($previous_allocation_quantity <  $new_allocation_quantity) {
                $added_quantity = $new_allocation_quantity - $previous_allocation_quantity;
                $this->db->select('*');
                $this->db->from('stock_details sd');
                $this->db->where('sd.product_id', $_POST['item_id'][$i]);
                $this->db->where('sd.status', 0);
                $this->db->order_by('stock_date');
                $this->db->limit($added_quantity);
                $res = $this->db->get()->result_array();
                if (empty($res)) {
                    $allocated_quantity = 0;
                } else {
                    $allocated_quantity = count($res);
                    foreach ($res as $row) {
                        $data = array(
                            'status' => 1,
                            'allocation_id' => $allocation_detail_id,
                        );
                        $this->db->where('stock_id', $row['stock_id']);
                        $this->db->update('stock_details', $data);
                    }
                }
                $new_allocation_quantity = $previous_allocation_quantity + $allocated_quantity;
            }

            //update stock allocation detail table

            $this->db->where('allocation_detail_id', $allocation_detail_id);
            $res = $this->db->update('stock_allocation_details', ['allocated_quantity' => $new_allocation_quantity]);
        }
        return $res;
    }

    public function get_allocated_stock_details_by_id($allocation_detail_id)
    {
        $this->db->select('serial_number,project');
        $this->db->from('stock_details');
        $this->db->where('status', 1);
        $this->db->where('allocation_id', $allocation_detail_id);
        $res = $this->db->get()->result_array();

        return $res;
    }

    public function update_allocation_details_data()
    {
        $allocation_id   = $this->input->post('allocation_detail_id');
        $scanned_serials = $this->input->post('scanned_serial');
        $allocated_qty = 0;
        $this->db->set('status', 0);
        $this->db->set('allocation_id', 0);
        $this->db->where('status', 1);
        $this->db->where('allocation_id', $allocation_id);
        $res = $this->db->update('stock_details');

        foreach ($scanned_serials as $scan) {
            if ($scan != '') {
                $this->db->set('status', 1);
                $this->db->set('allocation_id', $allocation_id);
                $this->db->where('serial_number', $scan);
                $res = $this->db->update('stock_details');
                $allocated_qty++;
            }
        }


        $res = $this->db->set('allocated_quantity', $allocated_qty)->where('allocation_detail_id', $allocation_id)->update('stock_allocation_details');

        return $res;
    }

    public function get_stock_item_status_by_serial_number($serial_no)
    {

        $this->db->select('status');
        //$this->db->where('serial_no',$serial_no);
        $this->db->where('stock_id', $serial_no);
        $res = $this->db->get('stock_details')->row_array();

        return $res['status'];
    }

    public function get_item_detail_by_serial_number($serial_no)
    {

        $this->db->select('item.product_name,item.description,item.product_id,im.invoice_id,im.invoice_code,sd.status,sd.inv_type');
        $this->db->from('stock_details sd');
        $this->db->join('item_master item', 'sd.product_id = item.product_id', 'left');
        $this->db->join('dn_details dd', 'sd.dc_id = dd.dn_detail_id', 'left');
        $this->db->join('invoice_details id', 'dd.invoice_detail_id = id.invoice_detail_id', 'left');
        $this->db->join('invoice_master im', 'id.invoice_master_id = im.invoice_id', 'left');
        $this->db->where('stock_id', $serial_no);
        $res = $this->db->get()->row_array();

        return $res;
    }

    function get_stock_code_list()
    {
        $query = $this->db->query("
        SELECT 
            s.product_id,
            SUM(s.quantity) AS qty,
            i.product_id,
            i.product_code,
            i.product_name
        FROM stock_details s
        JOIN item_master i ON s.product_id = i.product_id
        GROUP BY s.product_id, i.product_code, i.product_name
    ");

        return $query->result();
    }
}
