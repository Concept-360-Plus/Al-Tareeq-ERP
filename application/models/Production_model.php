<?php
class Production_model extends CI_Model
{
    function get_wo_details()
    {
        $query=$this->db->query("select * from project_work_order order by created_date desc");
        return $query->result();
    }	

    function get_production_tr_by_id_item($id)
    {
        $query = $this->db->query("select *  from project_production_transaction where ptrans_id =$id");

        return $query->result();
    }
    function transaction_production($id)
    {
        // $query = $this->db->query("SELECT pp.*, pt.* FROM project_production pp JOIN project_production_transaction pt ON pp.production_id = pt.production_master_id AND pp.production_id=$id ORDER BY pp.completion_date DESC");
        $query = $this->db->query("SELECT pp.*, pt.* FROM project_production pp JOIN project_production_transaction pt ON pp.production_id = pt.production_master_id AND pp.production_id=$id group by pp.production_id ORDER BY pp.completion_date DESC");
        return $query->result();
    }
    function get_production_list()
    {
        // $query=$this->db->query("select * from project_work_order order by work_order_date desc");
        $query=$this->db->query("select wo.*, pm.* from project_work_order wo,project_master pm where wo.project_id = pm.project_id order by work_order_date desc");
        return $query->result();
    }	
    function get_production_list_records()
    {
        // $query = $this->db->query("SELECT pp.*, pt.* FROM project_production pp JOIN project_production_transaction pt ON pp.production_id = pt.production_master_id ORDER BY pp.completion_date DESC");
        // $query = $this->db->query("SELECT pp.*, pt.*, pm.*, wo.* FROM project_production pp, project_production_transaction pt,project_work_order wo, project_master pm where pp.production_id = pt.production_master_id and pp.work_id = wo.work_id and wo.project_id = pm.project_id ORDER BY pp.completion_date DESC");
        $query = $this->db->query("SELECT pp.*, pt.*, pm.*, wo.* FROM project_production pp, project_production_transaction pt,project_work_order wo, project_master pm where pp.production_id = pt.production_master_id and pp.work_id = wo.work_id and wo.project_id = pm.project_id group by pp.production_id ORDER BY pp.completion_date DESC");
        return $query->result();
    }	


    function add_production_details()
    {
        $prifix = 'PD/' . date('y') . '/';
        $this->load->model('Setup_model');
        $num = $this->Setup_model->get_next_code($prifix, 'p_code', 'project_production', 7) + 1;
        $digit = sprintf("%1$04d", $num);
        $code = $prifix . $digit;

            

        $data = array(
            'work_id' => $this->input->post('work_id'),
            'p_code' => $this->input->post('p_code'),
            'completion_date' => date('Y-m-d', strtotime($this->input->post('completion_date'))),
            'handed_over_to' => $this->input->post('handed_over_to'),
            'wo_status' => $this->input->post('wo_status'),
            'remark' => $this->input->post('remark'),
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d'),
        );
        $this->db->insert('project_production', $data);
        $insert_id = $this->db->insert_id();

        //ss for ($c = 0; $c < count($_POST['desc']); $c++) {
        /*if(isset($_POST['desc'])):
                for ($c = 0; $c < count($_POST['desc']); $c++) {
                    $trans_id= $_POST['trans_id'][$c];

                    $data2 = array(
                        'production_master_id' => $insert_id,
                        // 'production_type' => $_POST['product_id'][$c],
                        'product_desc' => $_POST['desc'][$c],
                        'item_remark' => $_POST['item_remark'][$c],
                    );
                    $this->db->insert('project_production_transaction', $data2);
                }

                for ($j = 0; $j < count($_POST["sub_details$trans_id"]); $j++)
                {

                $data = array(
                'trans_id1' => $insert_id,
                'sub_details' => $_POST["sub_details$trans_id"][$j],
                'qty' =>  $_POST["qty"][$j],
                'width' =>  $_POST["width$trans_id"][$j],
                'height' =>  $_POST["height$trans_id"][$j],
                'unit' =>  $_POST["unit$trans_id"][$j],
                'price' =>  $_POST["price$trans_id"][$j],
                'total' =>  $_POST["total$trans_id"][$j],
                'colour_finish' => $_POST['colour_finish'][$j],
                'item_name' => $_POST['item_name'][$j],
                'item_code' => $_POST['item_code'][$j],
                'quantity_released' => $_POST['quantity_released'][$j],
                'completion' => $_POST['completion'][$j],


                );
                $this->db->insert('project_production_transaction1', $data);
            }
        endif;
        */
        $data2 = array(
            'production_master_id' => $insert_id,
            'product_desc' => $this->input->post('remark'),
            'item_remark' => $this->input->post('remark')
        );
        $this->db->insert('project_production_transaction', $data2);
        if ($insert_id) {
            $user_se_id = $this->session->userdata('user_id');
            $page_name = explode('index.php/', $_SERVER['PHP_SELF']);
            $ci = get_instance();
            $ci->load->helper('log');
            $log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $insert_id);
        }
        return $insert_id;
    }


    function update_production_details($id)
    {

        $data = array(
            'remark' => $this->input->post('remark'),
            'wo_status' => $this->input->post('wo_status'),
            'completion_date' => date('Y-m-d', strtotime($this->input->post('completion_date'))),

        );
        $this->db->where('production_id', $id);
        $res = $this->db->update('project_production', $data);


        // for ($c = 0; $c < count($_POST['product_id']); $c++) {
        // 	$data2 = array(
        // 		'production_master_id' => $id,
        // 		'production_desc' => $_POST['desc'][$c],
        // 		'production_type' => $_POST['product_id'][$c],
        // 		'tot_quantity' => $_POST['tot_quantity'][$c],
        // 		'quantity_released' => $_POST['quantity_released'][$c],
        // 		'unit' => $_POST['unit'][$c],
        // 		'completion' => $_POST['completion'][$c],

        // 	);
        // 	$this->db->update('project_production_transaction', $data2);
        // }

        if ($id) {
            $user_se_id = $this->session->userdata('user_id');
            $page_name = explode('index.php/', $_SERVER['PHP_SELF']);
            $ci = get_instance();
            $ci->load->helper('log');
            $log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'project_production', 'production_id', $id);

        }
        return $id;
    }

    function delete_production($id)
    {
        $query = $this->db->query(" delete from project_production where production_id=$id");
        $query = $this->db->query(" delete from project_production_transaction where production_master_id=$id");

    }


    function get_project_wo_trans($id)
    {
        $query=$this->db->query("select * from project_work_order_transaction where trans_id = '$id' ");
        // $query=$this->db->query("select * from project_production_transaction where ptrans_id = '$id' ");

        return $query->result();
    }

    function get_project_wo_trans1($id)
    {
        // $query=$this->db->query("select * from project_work_order_transaction1 where trans_id1 = '$id' ");
            $query=$this->db->query("select one.*, three.unit_abbr from (select * from project_work_order_transaction1  where trans_id1='$id' )as one  left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        // $query=$this->db->query("select one.*, two.item_name, two.item_code, three.unit_abbr from (select * from project_work_order_transaction1  where trans_id1='$id' )as one left join(select * from item_master)as two on(one.sub_details=two.item_id) left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        
        return $query->result();
    }

    //////////////////////////// production items //////////////////////

    function get_wo_items_trans1($id)
    {
        
        $query=$this->db->query("select * from project_work_order_transaction where pid='$id'");
        return $query->result();
    }
    function get_wo_items_trans2($id)
    {
        $query=$this->db->query("select one.*, two.unit_abbr from (select * from project_work_order_transaction1  where pid='$id' )as one  left join(select * from unit_master)as two on(one.unit=two.unit_id)");
        // $query=$this->db->query("select * from project_work_order_transaction1  where pid='$id'");
        return $query->result();
    }



    function get_wo_trans($id)
    {
        $query=$this->db->query("select * from project_production_transaction where ptrans_id = '$id' ");
        return $query->result();
    }

    function get_wo_trans1($id)
    {
            $query=$this->db->query("select one.*, three.unit_abbr from (select * from project_production_transaction1  where trans_id1='$id' )as one  left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        
        return $query->result();
    }    

    //approve production
    function qc_approve_production($id,$approve_id)
{

	$data = array(
		'qc_approve_flag' => $approve_id,
		'qc_approved_by' => $this->session->userdata('user_id'),
		'qc_approved_date' => date('Y-m-d H:i:s'),
	);
	$this->db->where('production_id', $id);
	$res = $this->db->update('project_production', $data);


	if ($id) {
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $id);
	}
	return $id;
}

function packing_approve_production($id,$approve_id)
{

	$data = array(
		'packing_flag' => $approve_id,
		'packing_by' => $this->session->userdata('user_id'),
		'packing_date' => date('Y-m-d H:i:s'),

	);
	$this->db->where('production_id', $id);
	$res = $this->db->update('project_production', $data);


	if ($id) {
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $id);
	}
	return $id;
}

function transport_approve_production($id,$approve_id)
{

	$data = array(
		'transport_flag' => $approve_id,
		'transport_by' => $this->session->userdata('user_id'),
		'transport_date' => date('Y-m-d H:i:s'),

	);
	$this->db->where('production_id', $id);
	$res = $this->db->update('project_production', $data);
	if ($id) {
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_production', 'production_id', $id);
	}
	return $id;
}

/***
 * JOB ORDER FUNCTIONS
 * ***/
    /*
     * Job Order list
     */
    /*public function get_job_orders()
    {
        return $this->db
            ->select('
                jo.*,
                pm.project_name,
                COUNT(joi.job_order_item_id) AS total_items
            ')
            ->from('job_order jo')
            ->join(
                'project_master pm',
                'pm.project_id = jo.fk_project_id',
                'left'
            )
            ->join(
                'job_order_items joi',
                'joi.job_order_id = jo.job_order_id',
                'left'
            )
            ->where('jo.is_deleted', 0)
            ->group_by('jo.job_order_id')
            ->order_by('jo.job_order_id', 'DESC')
            ->get()
            ->result();
    }
    */
  public function get_job_orders()
{
    $this->db->select('
        jo.*,
        pm.project_name,
        so.so_code,
        COUNT(joi.job_order_item_id) AS total_items
    ');

    $this->db->select("
        CASE
            WHEN jo.job_order_type = 1 THEN pm.project_name
            WHEN jo.job_order_type = 0 THEN so.so_code
            ELSE NULL
        END AS order_reference
    ", FALSE);

    $this->db->from('job_order jo');

    $this->db->join(
        'project_master pm',
        'pm.project_id = jo.fk_project_id',
        'left'
    );

    $this->db->join(
        'sales_order_master so',
        'so.so_id = jo.fk_sales_order_id
         AND jo.job_order_type = 0',
        'left'
    );

    $this->db->join(
        'job_order_items joi',
        'joi.job_order_id = jo.job_order_id',
        'left'
    );

    $this->db->where('jo.is_deleted', 0);

    $this->db->group_by('jo.job_order_id');

    $this->db->order_by('jo.job_order_id', 'DESC');

    return $this->db->get()->result();
}
    /*
     * Projects
     */
    public function get_projects()
    {
        return $this->db
            ->select('project_id, project_name')
            ->from('project_master')
            ->order_by('project_name', 'ASC')
            ->get()
            ->result();
    }

    public function get_projects_job_order()
    {
        return $this->db
            ->select('pm.project_id, pm.project_name, pm.project_code')
            ->from('project_master pm')
            ->where('pm.status', 'Approved')
            ->where('NOT EXISTS (
                SELECT 1
                FROM job_order jo
                WHERE jo.fk_project_id = pm.project_id
            )', NULL, FALSE)
            ->order_by('pm.project_name', 'ASC')
            ->get()
            ->result ();
    }


    /*
     * Generate Job Order number
     */
    public function generate_job_order_no()
    {
        $last = $this->db
            ->select('job_order_no')
            ->from('job_order')
            ->order_by('job_order_id', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        if ($last) {
            return str_pad(
                ((int)$last->job_order_no + 1),
                6,
                '0',
                STR_PAD_LEFT
            );
        }

        return '000001';
    }


    /*
     * Project items
     *
     * IMPORTANT:
     * Change the column names here if your
     * project_items table is different.
     */
    public function get_project_items($project_id)
    {
        return $this->db
            ->select('
                pi.id,
                pi.project_id,
                pi.product_id,
                pi.quantity,
                u.unit_abbr,
                im.product_code,
                im.retail_price,
                im.product_name as item_description
            ')
            ->from('project_items pi')
            ->join(
                'item_master im',
                'im.product_id = pi.product_id',
                'left'
            )
             ->join('unit_master u', 'u.unit_id = im.unit_id', 'left') 
            ->where('pi.project_id', $project_id)
            ->get()
            ->result();
    }


    /*
     * Get standard BOM
     * from amc_product_materials
     */
    public function get_item_materials($item_master_id)
    {
        return $this->db
        ->select('
            apm.id,
            apm.item_id,
            apm.material_id,
            apm.material_name,
            apm.material_code,
            apm.quantity_required,
            apm.cost,
            apm.unit,
            um.unit_abbr
        ')
        ->from('amc_product_materials apm')
        ->join(
            'unit_master um',
            'um.unit_id = apm.unit',
            'left'
        )
        ->where('apm.item_id', $item_master_id)
        ->where('apm.is_marked_delete', 0)
        ->order_by('apm.id', 'ASC')
        ->get()
        ->result();
        }


    /*
     * Save Job Order + Items + BOM materials
     */
        public function save_job_order()
{
    try {

        // ---------------------------------------------------------
        // START TRANSACTION
        // ---------------------------------------------------------
        $this->db->trans_begin();


        // ---------------------------------------------------------
        // 1. GET JOB ORDER TYPE
        // ---------------------------------------------------------
        $jobOrderType = $this->input->post('job_order_type');

        $projectId    = null;
        $salesOrderId = null;


        // ---------------------------------------------------------
        // 2. PROJECT / SALES ORDER
        // ---------------------------------------------------------
        if ($jobOrderType == 1) {

            // PROJECT JOB ORDER
            $projectId = $this->input->post('fk_project_id');

            if (empty($projectId)) {
                throw new Exception('Please select a project.');
            }

        } else {

            // SALES ORDER JOB ORDER
            $salesOrderId = $this->input->post('sales_order_id');

            if (empty($salesOrderId)) {
                throw new Exception('Please select a sales order.');
            }
        }


        // ---------------------------------------------------------
        // 3. JOB ORDER HEADER
        // ---------------------------------------------------------
        $jobOrderData = array(
            'job_order_no'      => $this->input->post('job_order_no'),
            'job_order_type'    => $jobOrderType,
            'fk_project_id'     => $projectId,
            'fk_sales_order_id' => $salesOrderId,
            'order_date'        => $this->input->post('order_date'),
            'order_no'          => $this->input->post('order_no'),
            'rep_name'          => $this->input->post('rep_name'),
            'contact_person'   => $this->input->post('contact_person'),
            'remarks'           => $this->input->post('remarks'),
            'start_date'        => $this->input->post('start_date'),
            'finish_date'       => $this->input->post('finish_date')
        );


        // ---------------------------------------------------------
        // 4. INSERT JOB ORDER
        // ---------------------------------------------------------
        $jobOrderId = $this->Production_model->insert_job_order($jobOrderData);

        if (!$jobOrderId) {

            $dbError = $this->db->error();

            throw new Exception(
                'Failed to create Job Order. ' .
                (!empty($dbError['message']) ? $dbError['message'] : '')
            );
        }


        // ---------------------------------------------------------
        // 5. SALES ORDER MAPPING
        // ---------------------------------------------------------
        if ($jobOrderType == 1) {

            // PROJECT TYPE
            $salesOrderIds = $this->input->post('sales_order_ids');

            if (!empty($salesOrderIds) && is_array($salesOrderIds)) {

                foreach ($salesOrderIds as $soId) {

                    if (empty($soId)) {
                        continue;
                    }

                    $mappingData = array(
                        'job_order_id' => $jobOrderId,
                        'so_id'        => $soId
                    );

                    $savedMapping =
                        $this->Production_model
                            ->insert_job_order_sales_order($mappingData);

                    if (!$savedMapping) {

                        $dbError = $this->db->error();

                        throw new Exception(
                            'Failed to save Sales Order mapping. ' .
                            (!empty($dbError['message'])
                                ? $dbError['message']
                                : '')
                        );
                    }
                }
            }

        } else {

            // SALES ORDER TYPE
            $mappingData = array(
                'job_order_id' => $jobOrderId,
                'so_id'        => $salesOrderId
            );

            $savedMapping =
                $this->Production_model
                    ->insert_job_order_sales_order($mappingData);

            if (!$savedMapping) {

                $dbError = $this->db->error();

                throw new Exception(
                    'Failed to save Sales Order mapping. ' .
                    (!empty($dbError['message'])
                        ? $dbError['message']
                        : '')
                );
            }
        }


        // ---------------------------------------------------------
        // 6. GET ITEMS
        // ---------------------------------------------------------
        $items = $this->input->post('items');

        if (empty($items) || !is_array($items)) {
            throw new Exception('Please select at least one item.');
        }


        // ---------------------------------------------------------
        // 7. GET POSTED JOB ORDER MATERIALS JSON
        // ---------------------------------------------------------
        $materialsJson = $this->input->post('job_order_materials');

        $jobOrderMaterials = array();

        if (!empty($materialsJson)) {

            $jobOrderMaterials = json_decode(
                $materialsJson,
                true
            );

            if (json_last_error() !== JSON_ERROR_NONE) {

                throw new Exception(
                    'Invalid Job Order Materials JSON: ' .
                    json_last_error_msg()
                );
            }

            if (!is_array($jobOrderMaterials)) {
                $jobOrderMaterials = array();
            }
        }


        // ---------------------------------------------------------
        // 8. LOOP ITEMS
        // ---------------------------------------------------------
        foreach ($items as $itemIndex => $item) {

            // -----------------------------------------------------
            // IMPORTANT:
            // Your POST contains:
            //
            // items[0][product_table_id] = 133
            // items[1][product_table_id] = 134
            //
            // So DO NOT use:
            // $item['project_item_id']
            // -----------------------------------------------------
            $projectItemId = !empty($item['product_table_id'])
                ? $item['product_table_id']
                : null;


            // -----------------------------------------------------
            // ITEM MASTER ID
            // -----------------------------------------------------
            $itemMasterId = !empty($item['item_master_id'])
                ? $item['item_master_id']
                : null;


            if (empty($itemMasterId)) {

                throw new Exception(
                    'Item master ID is missing for item ' .
                    ($itemIndex + 1)
                );
            }


            // -----------------------------------------------------
            // ITEM DATA
            // -----------------------------------------------------
            $itemData = array(
                'job_order_id'    => $jobOrderId,

                // Your POST product_table_id is being stored here
                'project_item_id' => $projectItemId,

                'item_master_id'  => $itemMasterId,

                'item_description' =>
                    isset($item['item_description'])
                        ? $item['item_description']
                        : '',

                'item_code' =>
                    isset($item['item_code'])
                        ? $item['item_code']
                        : '',

                'quantity' =>
                    isset($item['quantity'])
                        ? $item['quantity']
                        : 0,

                'unit' =>
                    isset($item['unit'])
                        ? $item['unit']
                        : '',

                'cost' =>
                    isset($item['retail_price'])
                        ? $item['retail_price']
                        : 0
            );


            // -----------------------------------------------------
            // INSERT JOB ORDER ITEM
            // -----------------------------------------------------
            $jobOrderItemId =
                $this->Production_model
                    ->insert_job_order_item($itemData);


            if (!$jobOrderItemId) {

                $dbError = $this->db->error();

                throw new Exception(
                    'Failed to save job order item ' .
                    ($itemIndex + 1) . '. ' .
                    (!empty($dbError['message'])
                        ? $dbError['message']
                        : '')
                );
            }


            // -----------------------------------------------------
            // 9. FIND MATERIALS FOR THIS ITEM
            // -----------------------------------------------------
            $materials = array();


            /*
             * IMPORTANT:
             *
             * JSON:
             *
             * "133" => materials
             * "134" => materials
             *
             * And product_table_id:
             *
             * item 1 = 133
             * item 2 = 134
             *
             * Therefore lookup must use product_table_id.
             */
            if (
                !empty($projectItemId) &&
                isset($jobOrderMaterials[$projectItemId]) &&
                is_array($jobOrderMaterials[$projectItemId])
            ) {

                $materials =
                    $jobOrderMaterials[$projectItemId];

            }


            // -----------------------------------------------------
            // DEBUG LOG
            // -----------------------------------------------------
            log_message(
                'debug',
                'JOB ORDER ID: ' . $jobOrderId .
                ' | JOB ORDER ITEM ID: ' . $jobOrderItemId .
                ' | PROJECT ITEM ID: ' . $projectItemId .
                ' | MATERIAL COUNT: ' . count($materials)
            );


            // -----------------------------------------------------
            // 10. SAVE MATERIALS
            // -----------------------------------------------------
            if (!empty($materials)) {

                foreach ($materials as $materialIndex => $material) {

                    // -------------------------------------------------
                    // MATERIAL ID
                    // -------------------------------------------------
                    $materialId =
                        !empty($material['material_id'])
                            ? $material['material_id']
                            : null;


                    if (empty($materialId)) {

                        // Skip invalid material
                        log_message(
                            'error',
                            'Skipping material because material_id is empty. ' .
                            print_r($material, true)
                        );

                        continue;
                    }


                    // -------------------------------------------------
                    // SOURCE
                    // BOM / MANUAL
                    // -------------------------------------------------
                    $source = isset($material['source'])
                        ? strtoupper(trim($material['source']))
                        : 'BOM';


                    if ($source !== 'BOM' && $source !== 'MANUAL') {
                        $source = 'BOM';
                    }


                    // -------------------------------------------------
                    // QUANTITY
                    //
                    // IMPORTANT:
                    // Your POST contains:
                    //
                    // quantity_required
                    //
                    // NOT:
                    //
                    // quantity
                    // -------------------------------------------------
                    $quantityRequired =
                        isset($material['quantity_required'])
                            ? (float)$material['quantity_required']
                            : 0;


                    // -------------------------------------------------
                    // MATERIAL COST
                    // -------------------------------------------------
                    $cost = 0;


                    if ($source === 'BOM') {

                        // BOM MATERIAL
                        $materialRow =
                            $this->db
                                ->select('cost')
                                ->from('amc_product_materials')
                                ->where(
                                    'material_id',
                                    $materialId
                                )
                                ->get()
                                ->row();

                    } else {

                        // MANUAL RAW MATERIAL
                        $materialRow =
                            $this->db
                                ->select('cost')
                                ->from('amc_raw_materials')
                                ->where(
                                    'material_id',
                                    $materialId
                                )
                                ->get()
                                ->row();
                    }


                    // -------------------------------------------------
                    // GET DB COST
                    // -------------------------------------------------
                    if ($materialRow) {

                        $cost =
                            isset($materialRow->cost)
                                ? (float)$materialRow->cost
                                : 0;
                    }


                    // -------------------------------------------------
                    // FALLBACK TO POSTED COST
                    //
                    // Useful especially for MANUAL materials.
                    // -------------------------------------------------
                    if (
                        $cost == 0 &&
                        isset($material['cost']) &&
                        $material['cost'] !== ''
                    ) {

                        $cost =
                            (float)$material['cost'];
                    }


                    // -------------------------------------------------
                    // MATERIAL DATA
                    // -------------------------------------------------
                    $materialData = array(

                        'job_order_item_id' =>
                            $jobOrderItemId,

                        'project_item_id' =>
                            $projectItemId,

                        'material_id' =>
                            $materialId,

                        'material_code' =>
                            isset($material['material_code'])
                                ? $material['material_code']
                                : '',

                        'material_name' =>
                            isset($material['material_name'])
                                ? $material['material_name']
                                : '',

                        'quantity_required' =>
                            $quantityRequired,

                        'unit' =>
                            isset($material['unit'])
                                ? $material['unit']
                                : '',

                        'cost' =>
                            $cost,

                        'source' =>
                            $source
                    );


                    // -------------------------------------------------
                    // INSERT MATERIAL
                    // -------------------------------------------------
                    $savedMaterial =
                        $this->Production_model
                            ->insert_job_order_material(
                                $materialData
                            );


                    if (!$savedMaterial) {

                        $dbError = $this->db->error();

                        throw new Exception(
                            'Failed to save material "' .
                            (isset($material['material_name'])
                                ? $material['material_name']
                                : 'Unknown') .
                            '" for item ' .
                            ($itemIndex + 1) .
                            '. ' .
                            (!empty($dbError['message'])
                                ? $dbError['message']
                                : '')
                        );
                    }


                    // -------------------------------------------------
                    // LOG SUCCESS
                    // -------------------------------------------------
                    log_message(
                        'debug',
                        'Material saved successfully. ' .
                        'Job Order ID: ' . $jobOrderId .
                        ' | Job Order Item ID: ' . $jobOrderItemId .
                        ' | Project Item ID: ' . $projectItemId .
                        ' | Material ID: ' . $materialId .
                        ' | Source: ' . $source .
                        ' | Qty: ' . $quantityRequired
                    );
                }
            }
        }


        // ---------------------------------------------------------
        // 11. CHECK TRANSACTION
        // ---------------------------------------------------------
        if ($this->db->trans_status() === FALSE) {

            $dbError = $this->db->error();

            throw new Exception(
                'Database transaction failed. ' .
                (!empty($dbError['message'])
                    ? $dbError['message']
                    : '')
            );
        }


        // ---------------------------------------------------------
        // 12. COMMIT
        // ---------------------------------------------------------
        $this->db->trans_commit();


        // ---------------------------------------------------------
        // 13. SUCCESS RESPONSE
        // ---------------------------------------------------------
        echo json_encode(array(
            'status'       => true,
            'message'      => 'Job Order created successfully.',
            'job_order_id' => $jobOrderId
        ));

    } catch (Exception $e) {

        // ---------------------------------------------------------
        // ROLLBACK
        // ---------------------------------------------------------
        $this->db->trans_rollback();


        // ---------------------------------------------------------
        // ERROR LOG
        // ---------------------------------------------------------
        log_message(
            'error',
            'Save Job Order Error: ' .
            $e->getMessage()
        );


        // ---------------------------------------------------------
        // ERROR RESPONSE
        // ---------------------------------------------------------
        echo json_encode(array(
            'status'  => false,
            'message' => $e->getMessage()
        ));
    }
}
    /*
     * Get Job Order
     */
    public function get_job_order($job_order_id)
    {
        return $this->db
            ->select('
                jo.*,
                pm.project_name
            ')
            ->from('job_order jo')
            ->join(
                'project_master pm',
                'pm.project_id = jo.fk_project_id',
                'left'
            )
            ->where('jo.job_order_id', $job_order_id)
            ->where('jo.is_deleted', 0)
            ->get()
            ->row();
    }


    /*
     * Get Job Order Items
     */
    public function get_job_order_items($job_order_id)
    {
        return $this->db
            ->select('
                joi.*,
                COUNT(jom.job_order_material_id) AS material_count
            ')
            ->from('job_order_items joi')
            ->join(
                'job_order_item_materials jom',
                'jom.job_order_item_id = joi.job_order_item_id',
                'left'
            )
            ->where('joi.job_order_id', $job_order_id)
            ->group_by('joi.job_order_item_id')
            ->order_by('joi.job_order_item_id', 'ASC')
            ->get()
            ->result();
    }


    /*
     * Get materials of a Job Order item
     */
    public function get_job_order_materials($job_order_item_id)
    {
        return $this->db
            ->where(
                'job_order_item_id',
                $job_order_item_id
            )
            ->order_by(
                'job_order_material_id',
                'ASC'
            )
            ->get('job_order_item_materials')
            ->result();
    }


    /*
     * Update Job Order
     */
    /*public function update_job_order(
        $job_order_id,
        $header,
        $items
    ) {

        $this->db->trans_start();

        $this->db
            ->where('job_order_id', $job_order_id)
            ->update('job_order', $header);


       
        $existing_items =
            $this->db
                ->where(
                    'job_order_id',
                    $job_order_id
                )
                ->get('job_order_items')
                ->result();


        $existing_ids = array();

        foreach ($existing_items as $row) {
            $existing_ids[] =
                $row->job_order_item_id;
        }


        $submitted_ids = array();


        foreach ($items as $item) {

            if (empty($item['selected'])) {
                continue;
            }


            $job_order_item_id =
                !empty($item['job_order_item_id'])
                ? $item['job_order_item_id']
                : 0;


            $item_data = array(
                'job_order_id'     => $job_order_id,
                'project_item_id'  => $item['project_item_id'],
                'item_master_id'   => $item['item_master_id'],
                'item_code'        => $item['item_code'],
                'item_description' => $item['item_description'],
                'quantity'         => $item['quantity'],
                'unit'             => $item['unit']
            );


            if ($job_order_item_id) {

                $this->db
                    ->where(
                        'job_order_item_id',
                        $job_order_item_id
                    )
                    ->update(
                        'job_order_items',
                        $item_data
                    );

                $submitted_ids[] =
                    $job_order_item_id;

            } else {

                $this->db->insert(
                    'job_order_items',
                    $item_data
                );

                $job_order_item_id =
                    $this->db->insert_id();


                $materials =
                    $this->get_item_materials(
                        $item['item_master_id']
                    );

                foreach ($materials as $material) {

                    $this->db->insert(
                        'job_order_item_materials',
                        array(
                            'job_order_item_id' =>
                                $job_order_item_id,

                            'material_id' =>
                                $material->material_id,

                            'material_code' =>
                                $material->material_code,

                            'material_name' =>
                                $material->material_name,

                            'quantity_required' =>
                                $material->quantity_required *
                                $item['quantity'],

                            'unit' =>
                                $material->unit,

                            'cost' =>
                                $material->cost,

                            'source' => 'BOM'
                        )
                    );
                }

                $submitted_ids[] =
                    $job_order_item_id;
            }
        }

        foreach ($existing_ids as $existing_id) {

            if (!in_array(
                $existing_id,
                $submitted_ids
            )) {

                $this->db
                    ->where(
                        'job_order_item_id',
                        $existing_id
                    )
                    ->delete(
                        'job_order_item_materials'
                    );

                $this->db
                    ->where(
                        'job_order_item_id',
                        $existing_id
                    )
                    ->delete(
                        'job_order_items'
                    );
            }
        }


        $this->db->trans_complete();

        return $this->db->trans_status();
    }
*/
    public function update_job_order($job_order_id, $data)
    {
        return $this->db
            ->where('job_order_id', $job_order_id)
            ->update('job_order', $data);
    }

    /*
     * Add manual material
     */
    public function add_material($data)
    {
        $this->db->insert(
            'job_order_item_materials',
            $data
        );

        return $this->db->insert_id();
    }


    /*
     * Delete material
     */
    public function delete_material($id)
    {
        return $this->db
            ->where(
                'job_order_material_id',
                $id
            )
            ->delete(
                'job_order_item_materials'
            );
    }


    /*
     * Delete Job Order
     */
   /* public function delete_job_order($job_order_id)
    {
        $this->db->trans_start();

        
        $items =
            $this->db
                ->where(
                    'job_order_id',
                    $job_order_id
                )
                ->get('job_order_items')
                ->result();


        foreach ($items as $item) {

            $this->db
                ->where(
                    'job_order_item_id',
                    $item->job_order_item_id
                )
                ->delete(
                    'job_order_item_materials'
                );
        }


        $this->db
            ->where(
                'job_order_id',
                $job_order_id
            )
            ->delete('job_order_items');


        $this->db
            ->where(
                'job_order_id',
                $job_order_id
            )
            ->update(
                'job_order',
                array(
                    'is_deleted' => 1
                )
            );


        $this->db->trans_complete();

        return $this->db->trans_status();
    }
        */
    public function delete_job_order($job_order_id)
{
    $this->db->trans_start();

    $job_completion_count = $this->db
        ->where(
            'job_order_id',
            $job_order_id
        )
        ->count_all_results(
            'job_completion'
        );

    if ($job_completion_count > 0) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Cannot delete this Job Order because it is already used in Job Completion.'
        );
    }


    $stock_transfer_count = $this->db
        ->where(
            'job_order_id',
            $job_order_id
        )
        ->count_all_results(
            'stock_transfers'
        );

    if ($stock_transfer_count > 0) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Cannot delete this Job Order because it is already used in Stock Transfer.'
        );
    }


    $items = $this->db
        ->where(
            'job_order_id',
            $job_order_id
        )
        ->get(
            'job_order_items'
        )
        ->result();


    foreach ($items as $item) {

        $completion_item_count = $this->db
            ->where(
                'job_order_item_id',
                $item->job_order_item_id
            )
            ->count_all_results(
                'job_completion_items'
            );

        if ($completion_item_count > 0) {

            $this->db->trans_rollback();

            return array(
                'status'  => false,
                'message' =>
                    'Cannot delete this Job Order because one or more items are already used in Job Completion.'
            );
        }


        $stock_transfer_item_count = $this->db
            ->where(
                'job_order_item_id',
                $item->job_order_item_id
            )
            ->count_all_results(
                'pstock_transfer_items'
            );

        if ($stock_transfer_item_count > 0) {

            $this->db->trans_rollback();

            return array(
                'status'  => false,
                'message' =>
                    'Cannot delete this Job Order because one or more items are already used in Stock Transfer.'
            );
        }
    }

    foreach ($items as $item) {

        $this->db
            ->where(
                'job_order_item_id',
                $item->job_order_item_id
            )
            ->delete(
                'job_order_item_materials'
            );
    }

    $this->db
        ->where(
            'job_order_id',
            $job_order_id
        )
        ->delete(
            'job_order_items'
        );


    $this->db
        ->where(
            'job_order_id',
            $job_order_id
        )
        ->update(
            'job_order',
            array(
                'is_deleted' => 1
            )
        );


    
    $this->db->trans_complete();


    if ($this->db->trans_status() === false) {

        return array(
            'status'  => false,
            'message' => 'Unable to delete Job Order.'
        );
    }


    return array(
        'status'  => true,
        'message' => 'Job Order deleted successfully.'
    );
}
    
    /*public function get_raw_materials()
    {
        return $this->db
            ->select('
                material_id,
                material_name,
                material_code
            ')
            ->from('amc_raw_materials')
            //->where('is_marked_delete', 0)
            ->order_by('material_name', 'ASC')
            ->get()
            ->result();
    }*/
    public function get_raw_materials()
{
    return $this->db
        ->select('
            arm.material_id,
            arm.material_name,
            arm.material_code,
            arm.unit,
            um.unit_abbr
        ')
        ->from('amc_raw_materials arm')
        ->join(
            'unit_master um',
            'um.unit_id = arm.unit',
            'left'
        )
        // ->where('arm.is_marked_delete', 0)
        ->order_by('arm.material_name', 'ASC')
        ->get()
        ->result();
}
    public function get_units()
    {
        return $this->db
            ->select('
                unit_id,
                unit_name,
                unit_abbr
            ')
            ->from('unit_master')
            ->where('active', 1)
            ->order_by('unit_name', 'ASC')
            ->get()
            ->result();
    }

    //save job order
    public function insert_job_order($data)
{
    $this->db->insert(
        'job_order',
        $data
    );

    return $this->db->insert_id();
}
public function insert_job_order_item($data)
{
    $this->db->insert(
        'job_order_items',
        $data
    );

    return $this->db->insert_id();
}

public function get_job_order_item($job_order_id,$project_item_id) {
    return $this->db
        ->where('job_order_id', $job_order_id)
        ->where('project_item_id', $project_item_id)
        ->get('job_order_items')
        ->row();
}
public function delete_job_order_item_materials($job_order_item_id) {
    return $this->db
        ->where(
            'job_order_item_id',
            $job_order_item_id
        )
        ->delete('job_order_item_materials');
}
public function insert_job_order_material($data)
{
    return $this->db
        ->insert(
            'job_order_item_materials',
            $data
        );
}

public function get_job_ordere($job_order_id)
{
    return $this->db
        ->where('job_order_id', $job_order_id)
        ->get('job_order')
        ->row();
}

public function get_job_order_itemse($job_order_id)
{
    return $this->db
        ->select('
            joi.job_order_item_id,
            joi.job_order_id,
            joi.project_item_id,
            joi.so_id,

            som.so_code AS sales_order_code,

            pi.product_id,
            pi.quantity,
            u.unit_abbr AS unit,
            pi.amount AS total,

            joi.cost,

            p.product_id AS item_master_id,
            p.product_code AS item_code,
            p.product_name AS product_name
        ')

        ->from('job_order_items joi')

        /*
         * Job Order Item
         *      ↓
         * Sales Order Product
         */
        ->join(
            'sales_order_products pi',
            'pi.product_table_id = joi.project_item_id',
            'left'
        )

        /*
         * Job Order Item
         *      ↓
         * Sales Order
         */
        ->join(
            'sales_order_master som',
            'som.so_id = joi.so_id',
            'left'
        )

        /*
         * Sales Order Product
         *      ↓
         * Item Master
         */
        ->join(
            'item_master p',
            'p.product_id = pi.product_id',
            'left'
        )

        ->join(
            'unit_master u',
            'u.unit_id = pi.unit_id',
            'left'
        )

        ->where(
            'joi.job_order_id',
            $job_order_id
        )

        ->order_by(
            'joi.job_order_item_id',
            'ASC'
        )

        ->get()
        ->result();
}

public function get_job_order_item_materials(
    $job_order_item_id
) {
    return $this->db
        ->select('
            job_order_material_id,
            job_order_item_id,
            project_item_id,
            material_id,
            material_code,
            material_name,
            quantity_required,
            unit,
            cost,
            source
        ')
        ->from('job_order_item_materials')
        ->where(
            'job_order_item_id',
            $job_order_item_id
        )
        ->order_by(
            'job_order_material_id',
            'ASC'
        )
        ->get()
        ->result();
}
public function get_raw_materialse()
{
    return $this->db
        //->where('is_marked_delete', 0)
        ->order_by('material_name', 'ASC')
        ->get('amc_raw_materials')
        ->result();
}

public function get_job_order_print($job_order_id)
{
    return $this->db
        ->select('
            jo.*,

            p.project_name,
            p.remarks as premarks,

            so.so_id,
            so.so_code,
            so.so_date
        ')
        ->from('job_order jo')

        ->join(
            'project_master p',
            'p.project_id = jo.fk_project_id',
            'left'
        )

        ->join(
            'sales_order_master so',
            'so.so_id = jo.fk_sales_order_id',
            'left'
        )

        ->where(
            'jo.job_order_id',
            $job_order_id
        )

        ->get()
        ->row();
}

public function get_job_order_items_print($job_order_id)
{
    return $this->db
        ->select('
            joi.job_order_item_id,
            joi.job_order_id,
            joi.project_item_id,

            pi.product_id,
            pi.quantity,
            joi.cost,
            pi.amount as total,

            im.product_name
        ')
        ->from('job_order_items joi')
        /*->join(
            'project_items pi',
            'pi.id = joi.project_item_id',
            'left'
        )*/
        ->join(
            'sales_order_products pi',
            'pi.product_table_id  = joi.project_item_id',
            'left'
        )
        ->join(
            'item_master im',
            'im.product_id = pi.product_id',
            'left'
        )
        ->where(
            'joi.job_order_id',
            $job_order_id
        )
        ->get()
        ->result();
}

public function get_job_order_item_materials_print($job_order_item_id)
{
    return $this->db
        ->select('
            jom.job_order_material_id,
            jom.job_order_item_id,
            jom.project_item_id,
            jom.material_id,
            jom.material_code,
            jom.material_name,
            jom.quantity_required,jom.unit,

            um.unit_id,
            um.unit_abbr,

            jom.cost,
            jom.source
        ')
        ->from('job_order_item_materials jom')
        ->join(
            'unit_master um',
            'um.unit_id = jom.unit',
            'left'
        )
        ->where(
            'jom.job_order_item_id',
            $job_order_item_id
        )
        ->order_by(
            'jom.job_order_material_id',
            'ASC'
        )
        ->get()
        ->result();
}
/*
 * Get all warehouses
 */
public function get_warehouses_list()
{
    return $this->db
        ->select('*')
        ->from('warehouses')
        ->order_by('wa_id', 'DESC')
        ->get()
        ->result();
}


/*
 * Get single warehouse
 */
public function get_warehouse($wa_id)
{
    return $this->db
        ->where('wa_id', $wa_id)
        ->get('warehouses')
        ->row();
}


/*
 * Insert warehouse
 */
public function insert_warehouse($data)
{
    return $this->db
        ->insert(
            'warehouses',
            $data
        );
}


/*
 * Update warehouse
 */
public function update_warehouse(
    $wa_id,
    $data
) {
    return $this->db
        ->where(
            'wa_id',
            $wa_id
        )
        ->update(
            'warehouses',
            $data
        );
}


/*
 * Delete warehouse
 */
public function delete_warehouse($wa_id)
{
    return $this->db
        ->where(
            'wa_id',
            $wa_id
        )
        ->delete('warehouses');
}


/*
 * Check duplicate warehouse code
 */
public function warehouse_code_exists(
    $code,
    $exclude_id = null
) {
    $this->db
        ->where(
            'code',
            $code
        );


    if ($exclude_id) {

        $this->db->where(
            'wa_id !=',
            $exclude_id
        );
    }


    return $this->db
        ->count_all_results(
            'warehouses'
        ) > 0;
}
    //JOB ORDER COMPLETION
  public function generate_job_completion_no()
{
    $row = $this->db
        ->select('job_completion_no')
        ->from('job_completion')
        ->order_by(
            'job_completion_id',
            'DESC'
        )
        ->limit(1)
        ->get()
        ->row();

    if (!$row) {
        return 'JC-000001';
    }

    $number = (int) str_replace(
        'JC-',
        '',
        $row->job_completion_no
    );

    $number++;

    return 'JC-' . str_pad(
        $number,
        6,
        '0',
        STR_PAD_LEFT
    );
}

    public function get_job_order_for_completion($job_order_id)
{
    return $this->db
        ->select('
            jo.job_order_id,
            jo.job_order_no,
            jo.order_date,
            jo.order_no,
            jo.rep_name,
            jo.contact_person,
            jo.start_date,
            jo.finish_date,
            jo.fk_project_id,
            jo.status,

            pm.project_name
        ')
        ->from('job_order jo')

        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )

        ->where(
            'jo.job_order_id',
            $job_order_id
        )

        ->get()
        ->row();
}
public function get_job_order_item_completion($job_order_item_id) {
    return $this->db
        ->select('
            joi.job_order_item_id,
            joi.job_order_id,
            joi.project_item_id,

            pi.product_id,
            pi.quantity AS ordered_quantity,

            im.product_name
        ')
        ->from('job_order_items joi')

        ->join(
            'project_items pi',
            'pi.id = joi.project_item_id',
            'left'
        )

        ->join(
            'item_master im',
            'im.product_id = pi.product_id',
            'left'
        )

        ->where(
            'joi.job_order_item_id',
            $job_order_item_id
        )->get()->row();
}
public function get_completed_quantity($job_order_item_id) {
    $row = $this->db
        ->select_sum(
            'completed_quantity'
        )
        ->from(
            'job_completion_items'
        )
        ->where(
            'job_order_item_id',
            $job_order_item_id
        )
        ->get()
        ->row();

    return $row &&
           $row->completed_quantity
        ? (float) $row->completed_quantity
        : 0;
}

/*public function get_job_orders_for_completion()
{
    return $this->db
        ->select('
            jo.job_order_id,
            jo.job_order_no,
            jo.order_date,
            jo.fk_project_id,
            jo.status,

            pm.project_name
        ')
        ->from(
            'job_order jo'
        )

        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )

        ->where_in(
            'jo.status',
            [
                'Pending',
                'In Progress'
            ]
        )

        ->order_by(
            'jo.job_order_id',
            'DESC'
        )

        ->get()
        ->result();
}  */
public function get_job_orders_for_completion()
{
    $this->db->select('
        jo.*,
        pm.project_name
    ');

    $this->db->from('job_order jo');

    $this->db->join(
        'project_master pm',
        'pm.project_id = jo.fk_project_id',
        'left'
    );

    $this->db->where('jo.is_deleted', 0);

    $this->db->where(
        'NOT EXISTS (
            SELECT 1
            FROM job_completion jc
            WHERE jc.job_order_id = jo.job_order_id
        )',
        NULL,
        FALSE
    );

    $this->db->order_by('jo.job_order_id', 'DESC');

    return $this->db->get()->result();
}

public function get_job_order_details($job_order_id) {
    return $this->db
        ->select('
            jo.job_order_id,
            jo.job_order_no,
            jo.order_date,
            jo.order_no,
            jo.rep_name,
            jo.contact_person,
            jo.start_date,
            jo.finish_date,
            jo.fk_project_id,
            jo.status,

            pm.project_name
        ')
        ->from(
            'job_order jo'
        )

        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )

        ->where(
            'jo.job_order_id',
            $job_order_id
        )->get()->row();
}

//Job completion
public function get_job_completions()
{
    return $this->db
        ->select('
            jc.*,jo.fk_project_id,
            jo.job_order_no,
            pm.project_name,

            COUNT(jci.job_completion_item_id) AS completed_items,

            COALESCE(SUM(jci.ordered_quantity), 0) AS total_ordered_quantity,

            COALESCE(SUM(jci.completed_quantity), 0) AS total_completed_quantity
        ')
        ->from('job_completion jc')

        ->join(
            'job_order jo',
            'jo.job_order_id = jc.job_order_id',
            'left'
        )

        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )

        ->join(
            'job_completion_items jci',
            'jci.job_completion_id = jc.job_completion_id',
            'left'
        )

        ->group_by('jc.job_completion_id')

        ->order_by(
            'jc.job_completion_id',
            'DESC'
        )

        ->get()
        ->result();
}
public function delete_job_completion($job_completion_id)
{
    $this->db->trans_start();

    /*
     * ---------------------------------------------------------
     * 1. Check Job Completion exists
     * ---------------------------------------------------------
     */
    $completion = $this->db
        ->select('job_order_id')
        ->where(
            'job_completion_id',
            $job_completion_id
        )
        ->get('job_completion')
        ->row();

    if (!$completion) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Job Completion not found.'
        );
    }


    /*
     * ---------------------------------------------------------
     * 2. Check Stock Transfer
     * ---------------------------------------------------------
     *
     * Job Completion cannot be deleted if it is already
     * used in Stock Transfer.
     */
    $stock_transfer = $this->db
        ->select('stock_transfer_id, stock_transfer_no')
        ->where(
            'job_completion_id',
            $job_completion_id
        )
        ->get('stock_transfers')
        ->row();


    if ($stock_transfer) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' =>
                'This Job Completion cannot be deleted because it is already used in Stock Transfer '
                . '(' . $stock_transfer->stock_transfer_no . ').'
        );
    }


    /*
     * ---------------------------------------------------------
     * 3. Delete Job Completion Items
     * ---------------------------------------------------------
     */
    $this->db
        ->where(
            'job_completion_id',
            $job_completion_id
        )
        ->delete('job_completion_items');


    /*
     * ---------------------------------------------------------
     * 4. Delete Job Completion
     * ---------------------------------------------------------
     */
    $this->db
        ->where(
            'job_completion_id',
            $job_completion_id
        )
        ->delete('job_completion');


    /*
     * ---------------------------------------------------------
     * 5. Reset Job Order Status
     * ---------------------------------------------------------
     */
    $this->db
        ->where(
            'job_order_id',
            $completion->job_order_id
        )
        ->update(
            'job_order',
            array(
                'status' =>
                    'In Progress',

                'updated_at' =>
                    date('Y-m-d H:i:s')
            )
        );


    /*
     * ---------------------------------------------------------
     * 6. Complete Transaction
     * ---------------------------------------------------------
     */
    $this->db->trans_complete();


    if (!$this->db->trans_status()) {

        return array(
            'status'  => false,
            'message' => 'Unable to delete Job Completion.'
        );
    }


    return array(
        'status'  => true,
        'message' => 'Job Completion deleted successfully.'
    );
}

public function get_job_completion($job_completion_id)
{
    $this->db->select('
        jc.*,
        jo.job_order_no,
        jo.fk_project_id,
        pm.project_name
    ');

    $this->db->from('job_completion jc');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = jc.job_order_id',
        'inner'
    );

    $this->db->join(
        'project_master pm',
        'pm.project_id = jo.fk_project_id',
        'left'
    );

    $this->db->where(
        'jc.job_completion_id',
        $job_completion_id
    );

    return $this->db->get()->row();
}

public function get_job_completion_items($completion_id)
{
    // joi.item_description,
    $items = $this->db
        ->select('
            jci.*,

            joi.job_order_id,
            joi.project_item_id,
            joi.item_master_id,
           
            joi.quantity AS job_order_quantity,

            im.product_code,
            im.product_name as item_description,
            im.description AS product_description,
            im.unit_id
        ')
        ->from('job_completion_items jci')

        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = jci.job_order_item_id',
            'left'
        )

        ->join(
            'item_master im',
            'im.product_id = joi.item_master_id',
            'left'
        )

        ->where(
            'jci.job_completion_id',
            $completion_id
        )

        ->get()
        ->result();


    foreach ($items as &$item) {

        /*
         * Original ordered quantity
         */
        $ordered_quantity =
            (float)($item->job_order_quantity ?? 0);


        /*
         * Total completed quantity from
         * OTHER Job Completions
         */
        $previous = $this->db
            ->select_sum(
                'completed_quantity',
                'total_completed'
            )
            ->where(
                'job_order_item_id',
                $item->job_order_item_id
            )
            ->where(
                'job_completion_id !=',
                $completion_id
            )
            ->get(
                'job_completion_items'
            )
            ->row();


        $previously_completed =
            (float)($previous->total_completed ?? 0);


        /*
         * Maximum quantity that can be entered
         * while editing this completion.
         */
        $editable_max_quantity =
            $ordered_quantity -
            $previously_completed;


        if ($editable_max_quantity < 0) {
            $editable_max_quantity = 0;
        }


        /*
         * Set properties explicitly
         */
        $item->ordered_quantity =
            $ordered_quantity;

        $item->previously_completed =
            $previously_completed;

        $item->editable_max_quantity =
            $editable_max_quantity;


        /*
         * Current completion quantity
         */
        $current_completed =
            (float)($item->completed_quantity ?? 0);


        /*
         * Remaining after current completion
         */
        $item->remaining_quantity =
            $editable_max_quantity -
            $current_completed;


        if ($item->remaining_quantity < 0) {
            $item->remaining_quantity = 0;
        }
    }

    return $items;
}
/*
public function update_job_completion($completion_id, $completion_data,$items) {
    $this->db->trans_start();
   
    $completion = $this->db
        ->select('job_order_id')
        ->where(
            'job_completion_id',
            $completion_id
        )
        ->get('job_completion')
        ->row();

    if (!$completion) {
        $this->db->trans_rollback();
        return false;
    }


    $this->db
        ->where(
            'job_completion_id',
            $completion_id
        )
        ->update(
            'job_completion',
            $completion_data
        );


    if (!empty($items)) {

        foreach ($items as $item) {

            $job_completion_item_id =
                !empty($item['job_completion_item_id'])
                    ? $item['job_completion_item_id']
                    : 0;

            $job_order_item_id =
                !empty($item['job_order_item_id'])
                    ? $item['job_order_item_id']
                    : 0;

            $completed_quantity =
                isset($item['completed_quantity'])
                    ? (float)$item['completed_quantity']
                    : 0;

            if ($completed_quantity <= 0) {
                continue;
            }


            if ($job_completion_item_id) {

                
                $existing = $this->db
                    ->where(
                        'job_completion_item_id',
                        $job_completion_item_id
                    )
                    ->get('job_completion_items')
                    ->row();

                if (!$existing) {
                    continue;
                }


                $ordered_quantity =
                    (float)$existing->ordered_quantity;


                $previously_completed =
                    (float)$existing->previously_completed;


                $remaining_quantity =
                    $ordered_quantity
                    - $previously_completed
                    - $completed_quantity;


                if ($remaining_quantity < 0) {
                    $remaining_quantity = 0;
                }

                $this->db
                    ->where(
                        'job_completion_item_id',
                        $job_completion_item_id
                    )
                    ->update(
                        'job_completion_items',
                        array(

                            'completed_quantity' =>
                                $completed_quantity,

                            'remaining_quantity' =>
                                $remaining_quantity
                        )
                    );

            }


            else {

                if (!$job_order_item_id) {
                    continue;
                }


                $job_item = $this->db
                    ->where(
                        'job_order_item_id',
                        $job_order_item_id
                    )
                    ->get('job_order_items')
                    ->row();


                if (!$job_item) {
                    continue;
                }


                $ordered_quantity =
                    (float)$job_item->quantity;

                $previously_completed = $this->db
                    ->select_sum(
                        'completed_quantity',
                        'total_completed'
                    )
                    ->where(
                        'job_order_item_id',
                        $job_order_item_id
                    )
                    ->where(
                        'job_completion_id !=',
                        $completion_id
                    )
                    ->get('job_completion_items')
                    ->row();


                $previously_completed_quantity =
                    !empty(
                        $previously_completed->total_completed
                    )
                        ? (float)$previously_completed->total_completed
                        : 0;

                $remaining_before =
                    $ordered_quantity
                    - $previously_completed_quantity;


                if (
                    $completed_quantity >
                    $remaining_before
                ) {

                    $this->db->trans_rollback();

                    return false;
                }

                $remaining_quantity =
                    $remaining_before
                    - $completed_quantity;


                $this->db->insert(
                    'job_completion_items',
                    array(

                        'job_completion_id' =>
                            $completion_id,

                        'job_order_item_id' =>
                            $job_order_item_id,

                        'project_item_id' =>
                            !empty(
                                $item['project_item_id']
                            )
                                ? $item['project_item_id']
                                : $job_item->project_item_id,

                        'ordered_quantity' =>
                            $ordered_quantity,

                        'previously_completed' =>
                            $previously_completed_quantity,

                        'completed_quantity' =>
                            $completed_quantity,

                        'remaining_quantity' =>
                            $remaining_quantity
                    )
                );
            }
        }
    }


    if ($completion) {

        $this->update_job_order_status(
            $completion->job_order_id
        );
    }

    $this->db->trans_complete();

    return $this->db->trans_status();
}
*/
public function update_job_completion( $completion_id, $completion_data, $items
) {
    $this->db->trans_start();
    $completion = $this->db
        ->select('job_order_id')
        ->where(
            'job_completion_id',
            $completion_id
        )
        ->get('job_completion')
        ->row();

    if (!$completion) {
        $this->db->trans_rollback();
        return false;
    }

    $job_order_id = $completion->job_order_id;

    $this->db
        ->where(
            'job_completion_id',
            $completion_id
        )
        ->update(
            'job_completion',
            $completion_data
        );

    if (!empty($items)) {

        foreach ($items as $item) {

            $job_completion_item_id =
                !empty($item['job_completion_item_id'])
                    ? $item['job_completion_item_id']
                    : 0;

            $job_order_item_id =
                !empty($item['job_order_item_id'])
                    ? $item['job_order_item_id']
                    : 0;

            $additional_quantity =
                isset($item['completed_quantity'])
                    ? (float)$item['completed_quantity']
                    : 0;

            if ($additional_quantity < 0) {

                $this->db->trans_rollback();

                return false;
            }

            if ($job_completion_item_id) {

                $existing = $this->db
                    ->where(
                        'job_completion_item_id',
                        $job_completion_item_id
                    )
                    ->where(
                        'job_completion_id',
                        $completion_id
                    )
                    ->get(
                        'job_completion_items'
                    )
                    ->row();

                if (!$existing) {
                    continue;
                }


                $job_order_item_id = $existing->job_order_item_id;

                $job_item = $this->db
                    ->where(
                        'job_order_item_id',
                        $job_order_item_id
                    )
                    ->get(
                        'job_order_items'
                    )
                    ->row();

                if (!$job_item) {
                    continue;
                }


                $ordered_quantity =  (float)$job_item->quantity;
                $previous = $this->db
                    ->select_sum(
                        'completed_quantity',
                        'total_completed'
                    )
                    ->where(
                        'job_order_item_id',
                        $job_order_item_id
                    )
                    ->where(
                        'job_completion_id !=',
                        $completion_id
                    )
                    ->get(
                        'job_completion_items'
                    )
                    ->row();


                $previously_completed =
                    !empty($previous->total_completed)
                        ? (float)$previous->total_completed
                        : 0;

                $old_current_quantity =  (float)$existing->completed_quantity;

                $new_current_quantity =
                    $old_current_quantity
                    + $additional_quantity;

                $total_completed =
                    $previously_completed
                    + $new_current_quantity;
                if (
                    $total_completed
                    > $ordered_quantity
                ) {

                    $this->db->trans_rollback();

                    return false;
                }

                $remaining_quantity =
                    $ordered_quantity
                    - $total_completed;


                if ($remaining_quantity < 0) {
                    $remaining_quantity = 0;
                }

                $this->db
                    ->where(
                        'job_completion_item_id',
                        $job_completion_item_id
                    )
                    ->update(
                        'job_completion_items',
                        array(

                            'ordered_quantity' =>   $ordered_quantity,
                            'previously_completed' => $previously_completed,
                            'completed_quantity' => $new_current_quantity,
                            'remaining_quantity' =>  $remaining_quantity
                        )
                    );
            }

            else {

                if ($additional_quantity <= 0) {
                    continue;
                }


                if (!$job_order_item_id) {
                    continue;
                }

                $job_item = $this->db
                    ->where(
                        'job_order_item_id',
                        $job_order_item_id
                    )
                    ->get(
                        'job_order_items'
                    )
                    ->row();

                if (!$job_item) {
                    continue;
                }

                $ordered_quantity =  (float)$job_item->quantity;

                $previous = $this->db
                    ->select_sum(
                        'completed_quantity',
                        'total_completed'
                    )
                    ->where(
                        'job_order_item_id',
                        $job_order_item_id
                    )
                    ->where(
                        'job_completion_id !=',
                        $completion_id
                    )
                    ->get(
                        'job_completion_items'
                    )
                    ->row();
                $previously_completed =
                    !empty($previous->total_completed)
                        ? (float)$previous->total_completed
                        : 0;
                $remaining_before =  $ordered_quantity - $previously_completed;

                if (
                    $additional_quantity
                    > $remaining_before
                ) {

                    $this->db->trans_rollback();

                    return false;
                }

                $remaining_quantity =
                    $remaining_before
                    - $additional_quantity;


                if ($remaining_quantity < 0) {
                    $remaining_quantity = 0;
                }

                $this->db->insert(
                    'job_completion_items',
                    array(

                        'job_completion_id' =>
                            $completion_id,

                        'job_order_item_id' =>
                            $job_order_item_id,

                        'project_item_id' =>
                            !empty(
                                $item['project_item_id']
                            )
                                ? $item['project_item_id']
                                : $job_item->project_item_id,

                        'ordered_quantity' =>
                            $ordered_quantity,

                        'previously_completed' =>
                            $previously_completed,

                        'completed_quantity' =>
                            $additional_quantity,

                        'remaining_quantity' =>
                            $remaining_quantity
                    )
                );
            }
        }
    }


    $this->update_job_order_status(
        $job_order_id
    );
    $this->db->trans_complete();


    return $this->db->trans_status();
}
public function update_job_order_status($job_order_id)
{
    /*
     * ---------------------------------------------------------
     * 1. Check whether the Job Order has any items
     * ---------------------------------------------------------
     */
    $total_items = $this->db
        ->where('job_order_id', $job_order_id)
        ->count_all_results('job_order_items');

    /*
     * No items -> do not mark completed
     */
    if ($total_items == 0) {

        return $this->db
            ->where('job_order_id', $job_order_id)
            ->update(
                'job_order',
                array(
                    'status' => 'In Progress',
                    'updated_at' => date('Y-m-d H:i:s')
                )
            );
    }


    /*
     * ---------------------------------------------------------
     * 2. Check whether ALL Job Order items are completed
     *
     * An item is completed when:
     *
     * ordered_quantity <= completed_quantity
     *
     * ---------------------------------------------------------
     */
    $incomplete_items = $this->db
        ->select('
            joi.job_order_item_id,
            joi.quantity AS ordered_quantity,
            COALESCE(
                SUM(jci.completed_quantity),
                0
            ) AS completed_quantity
        ')
        ->from('job_order_items joi')
        ->join(
            'job_completion_items jci',
            'jci.job_order_item_id = joi.job_order_item_id',
            'left'
        )
        ->where(
            'joi.job_order_id',
            $job_order_id
        )
        ->group_by(
            'joi.job_order_item_id'
        )
        ->having(
            'ordered_quantity > completed_quantity'
        )
        ->get()
        ->num_rows();


    /*
     * ---------------------------------------------------------
     * 3. Update Job Order Status
     * ---------------------------------------------------------
     */

    if ($incomplete_items == 0) {

        /*
         * ALL products are completely produced
         */
        $status = 'Production Completed';

    } else {

        /*
         * At least one product is still remaining
         */
        $status = 'In Progress';
    }


    /*
     * ---------------------------------------------------------
     * 4. Update Job Order
     * ---------------------------------------------------------
     */
    return $this->db
        ->where(
            'job_order_id',
            $job_order_id
        )
        ->update(
            'job_order',
            array(
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            )
        );
}

public function get_job_order_items_for_completion($job_order_id)
{
    $this->db->select('
        joi.job_order_item_id,
        joi.job_order_id,
        joi.project_item_id,
        joi.item_master_id,
        joi.item_code,
        joi.item_description,
        joi.quantity AS ordered_quantity,
        joi.unit,
        im.product_code,
        im.product_name
    ');

    $this->db->from('job_order_items joi');

    $this->db->join(
        'item_master im',
        'im.product_id = joi.item_master_id',
        'left'
    );

    $this->db->where(
        'joi.job_order_id',
        $job_order_id
    );

    $this->db->order_by(
        'joi.job_order_item_id',
        'ASC'
    );

    return $this->db->get()->result();
}

public function get_job_completion_items_for_edit($job_completion_id)
{
    return $this->db
        ->select('
            jci.job_completion_item_id,
            jci.job_completion_id,
            jci.job_order_item_id,
            jci.project_item_id,

            jci.ordered_quantity,
            jci.completed_quantity,
            jci.remaining_quantity,

            joi.item_master_id,
            joi.item_code,
            joi.item_description,
            joi.unit,

            im.product_code,
            im.product_name
        ')
        ->from('job_completion_items jci')
        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = jci.job_order_item_id',
            'inner'
        )
        ->join(
            'item_master im',
            'im.product_id = joi.item_master_id',
            'left'
        )
        ->where(
            'jci.job_completion_id',
            $job_completion_id
        )
        ->order_by(
            'jci.job_completion_item_id',
            'ASC'
        )
        ->get()
        ->result();
}

public function save_job_completion($completion_data, $items)
{
    $this->db->trans_start();

    /*
     * Insert Job Completion header
     */
    $this->db->insert(
        'job_completion',
        $completion_data
    );

    $completion_id = $this->db->insert_id();

    /*
     * Insert Job Completion Items
     */
    if (!empty($items)) {

        foreach ($items as $item) {

            $ordered_quantity =
                (float) $item['ordered_quantity'];

            $completed_quantity =
                (float) $item['completed_quantity'];

            /*
             * Calculate remaining quantity
             */
            $remaining_quantity =
                $ordered_quantity -
                $completed_quantity;

            if ($remaining_quantity < 0) {
                $remaining_quantity = 0;
            }

            $item_data = array(
                'job_completion_id' =>
                    $completion_id,

                'job_order_item_id' =>
                    $item['job_order_item_id'],

                'project_item_id' =>
                    $item['project_item_id'],

                'ordered_quantity' =>
                    $ordered_quantity,

                /*
                 * No previous completion
                 */
                'previously_completed' =>
                    0,

                'completed_quantity' =>
                    $completed_quantity,

                'remaining_quantity' =>
                    $remaining_quantity
            );

            $this->db->insert(
                'job_completion_items',
                $item_data
            );
        }
    }

    /*
     * Mark Job Order as completed
     */
    $this->db
        ->where(
            'job_order_id',
            $completion_data['job_order_id']
        )
        ->update(
            'job_order',
            array(
                'status' => 'Production Completed',
                'updated_at' =>
                    date('Y-m-d H:i:s')
            )
        );

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
        return $completion_id;
    }

    return false;
}

public function get_remaining_job_order_items($job_order_id)
{
    // joi.item_description,
    $this->db->select("
        joi.job_order_item_id,
        joi.job_order_id,
        joi.project_item_id,
        joi.item_master_id,

        im.product_code,
        im.product_name as item_description,

        joi.item_code AS job_item_code,
        joi.quantity AS ordered_quantity,

        COALESCE(
            SUM(jci.completed_quantity),
            0
        ) AS previously_completed,

        (
            joi.quantity -
            COALESCE(SUM(jci.completed_quantity), 0)
        ) AS remaining_quantity
    ");

    $this->db->from('job_order_items joi');

    // Item master
    $this->db->join(
        'item_master im',
        'im.product_id = joi.item_master_id',
        'left'
    );

    // Previous completions
    $this->db->join(
        'job_completion_items jci',
        'jci.job_order_item_id = joi.job_order_item_id',
        'left'
    );

    $this->db->where(
        'joi.job_order_id',
        $job_order_id
    );

    $this->db->group_by(
        'joi.job_order_item_id'
    );

    // Only items with remaining quantity
    $this->db->having(
        'remaining_quantity >',
        0
    );

    return $this->db->get()->result();
}

public function get_remaining_items_for_edit($job_completion_id)
{
     $completion = $this->db->select('job_order_id')
        ->where(
            'job_completion_id',
            $job_completion_id
        )
        ->get('job_completion')->row();
    if (!$completion) {
        return [];
    }
    /*
     * Get Job Order Items + Item Master
     */
    // joi.item_description,
    $items = $this->db
        ->select('
            joi.job_order_item_id,
            joi.job_order_id,
            joi.project_item_id,
            joi.item_master_id,

            joi.item_code AS job_item_code,
            joi.quantity AS ordered_quantity,

            im.product_code,
            im.product_name as item_description,
            im.description AS product_description,
            im.unit_id
        ')
        ->from('job_order_items joi')

        ->join(
            'item_master im',
            'im.product_id = joi.item_master_id',
            'left'
        )

        ->where(
            'joi.job_order_id',
            $completion->job_order_id
        )

        ->get()
        ->result();


    foreach ($items as &$item) {

        /*
         * Total completed quantity
         * from ALL Job Completions
         */
        $completed = $this->db
            ->select_sum(
                'completed_quantity',
                'total_completed'
            )
            ->where(
                'job_order_item_id',
                $item->job_order_item_id
            )
            ->get('job_completion_items')
            ->row();

        $previously_completed =
            (float)($completed->total_completed ?? 0);


        /*
         * This current Job Completion's quantity
         */
        $current = $this->db
            ->select_sum(
                'completed_quantity',
                'current_completed'
            )
            ->where(
                'job_completion_id',
                $job_completion_id
            )
            ->where(
                'job_order_item_id',
                $item->job_order_item_id
            )
            ->get('job_completion_items')
            ->row();

        $current_completed =
            (float)($current->current_completed ?? 0);


        /*
         * Exclude current completion when
         * calculating previous completed quantity
         */
        $previously_completed =
            $previously_completed -
            $current_completed;

        if ($previously_completed < 0) {
            $previously_completed = 0;
        }


        /*
         * Remaining quantity
         */
        $remaining_quantity =
            (float)$item->ordered_quantity -
            $previously_completed -
            $current_completed;

        if ($remaining_quantity < 0) {
            $remaining_quantity = 0;
        }


        $item->previously_completed =
            $previously_completed;

        $item->current_completed =
            $current_completed;

        $item->remaining_quantity =
            $remaining_quantity;
    }


    /*
     * Only return items having remaining quantity
     *
     * Don't return items already part of
     * this Job Completion.
     */
    $items = array_filter(
        $items,
        function ($item) {

            return
                (float)$item->remaining_quantity > 0 &&
                (float)$item->current_completed <= 0;
        }
    );

    return array_values($items);
}

public function generate_production_material_request_no()
{
    $row = $this->db
        ->select('production_material_request_id')
        ->from('production_material_requests')
        ->order_by(
            'production_material_request_id',
            'DESC'
        )
        ->limit(1)
        ->get()
        ->row();

    if ($row) {

        $next_id =
            ((int)$row->production_material_request_id) + 1;

    } else {

        $next_id = 1;
    }

    return 'PMR-' . str_pad(
        $next_id,
        6,
        '0',
        STR_PAD_LEFT
    );
}
/**
 * Get Job Orders available for Material Request
 */
public function get_job_orders_for_material_request()
{
    return $this->db
        ->select('
            jo.job_order_id,
            jo.job_order_no,
            jo.fk_project_id,
            jo.order_date,
            pm.project_name
        ')
        ->from('job_order jo')
        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )
        ->where('jo.is_deleted', 0)
        ->where_in('jo.status', array(
            'Pending',
            'In Progress',
            'Production'
        ))
        ->order_by('jo.job_order_id', 'DESC')
        ->get()
        ->result();
}
public function get_production_items_for_material_request($job_order_id) {
    return $this->db
        ->select('
            pi.*,
            joi.item_description
        ')
        ->from('production_items pi')
        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = pi.job_order_item_id',
            'left'
        )
        ->where(
            'pi.job_order_id',
            $job_order_id
        )
        ->get()
        ->result();
}

public function get_production_item_materials_for_request(
    $production_item_id,
    $job_order_id
) {
    $materials = $this->db
        ->select('
            pim.raw_material_id,
            pim.production_item_id,
            pim.required_quantity,
            pim.unit_id,

            rm.raw_material_name,

            um.unit_name
        ')
        ->from(
            'production_item_materials pim'
        )
        ->join(
            'amc_raw_materials rm',
            'rm.raw_material_id = pim.raw_material_id',
            'left'
        )
        ->join(
            'unit_master um',
            'um.unit_id = pim.unit_id',
            'left'
        )
        ->where(
            'pim.production_item_id',
            $production_item_id
        )
        ->get()
        ->result();

    foreach ($materials as &$material) {

        /*
         * Total previously requested
         */
        $requested = $this->db
            ->select_sum(
                'requested_quantity',
                'total_requested'
            )
            ->where(
                'job_order_id',
                $job_order_id
            )
            ->where(
                'production_item_id',
                $production_item_id
            )
            ->where(
                'raw_material_id',
                $material->raw_material_id
            )
            ->get(
                'production_material_request_items'
            )
            ->row();

        $already_requested =
            (float)(
                $requested->total_requested ?? 0
            );

        /*
         * Remaining
         */
        $remaining =
            (float)$material->required_quantity -
            $already_requested;

        if ($remaining < 0) {
            $remaining = 0;
        }

        $material->already_requested =
            $already_requested;

        $material->remaining_quantity =
            $remaining;
    }

    return $materials;
}

public function validate_material_request_quantity(
    $job_order_id,
    $production_item_id,
    $raw_material_id
) {
    $material = $this->db
        ->select('
            pim.required_quantity,
            pim.unit_id,
            rm.raw_material_name
        ')
        ->from(
            'production_item_materials pim'
        )
        ->join(
            'amc_raw_materials rm',
            'rm.raw_material_id = pim.raw_material_id',
            'left'
        )
        ->where(
            'pim.production_item_id',
            $production_item_id
        )
        ->where(
            'pim.raw_material_id',
            $raw_material_id
        )
        ->get()
        ->row();

    if (!$material) {
        return false;
    }

    $requested = $this->db
        ->select_sum(
            'requested_quantity',
            'total_requested'
        )
        ->where(
            'job_order_id',
            $job_order_id
        )
        ->where(
            'production_item_id',
            $production_item_id
        )
        ->where(
            'raw_material_id',
            $raw_material_id
        )
        ->get(
            'production_material_request_items'
        )
        ->row();

    $already_requested =
        (float)(
            $requested->total_requested ?? 0
        );

    $material->already_requested =
        $already_requested;

    $material->remaining_quantity =
        max(
            0,
            (float)$material->required_quantity -
            $already_requested
        );

    return $material;
}

public function get_production_material_requests()
{
    return $this->db
        ->select('
            pmr.*,
            jo.job_order_no,
            pm.project_name,

            COUNT(pmri.production_material_request_item_id)
                AS material_count,

            COALESCE(
                SUM(pmri.total_cost),
                0
            ) AS total_cost
        ')
        ->from(
            'production_material_requests pmr'
        )
        ->join(
            'job_order jo',
            'jo.job_order_id = pmr.job_order_id',
            'left'
        )
        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )
        ->join(
            'production_material_request_items pmri',
            'pmri.production_material_request_id = pmr.production_material_request_id',
            'left'
        )
        ->group_by(
            'pmr.production_material_request_id'
        )
        ->order_by(
            'pmr.production_material_request_id',
            'DESC'
        )
        ->get()
        ->result();
}

public function get_materials_for_material_request($job_order_id)
{
    $sql = "
        SELECT
            joi.job_order_item_id,
            joi.item_master_id,

            /* Product */
            im.product_code,
            im.product_name AS item_description,

            joi.quantity AS item_quantity,

            /* ============================
             * SALES ORDER
             * ============================ */

            CASE
                /* Normal Job Order */
                WHEN jo.job_order_type = 0
                    THEN jo.fk_sales_order_id

                /* Project Job Order */
                WHEN jo.job_order_type = 1
                    THEN (
                        SELECT sop.so_id
                        FROM job_order_sales_orders jos
                        INNER JOIN sales_order_products sop
                            ON sop.so_id = jos.so_id
                        WHERE jos.job_order_id = jo.job_order_id
                          AND sop.product_id = joi.item_master_id
                        ORDER BY sop.product_table_id
                        LIMIT 1
                    )
            END AS sales_order_id,

            CASE
                /* Normal Job Order */
                WHEN jo.job_order_type = 0
                    THEN so_normal.so_code

                /* Project Job Order */
                WHEN jo.job_order_type = 1
                    THEN (
                        SELECT so_project.so_code
                        FROM job_order_sales_orders jos
                        INNER JOIN sales_order_products sop
                            ON sop.so_id = jos.so_id
                        INNER JOIN sales_order_master so_project
                            ON so_project.so_id = sop.so_id
                        WHERE jos.job_order_id = jo.job_order_id
                          AND sop.product_id = joi.item_master_id
                        ORDER BY sop.product_table_id
                        LIMIT 1
                    )
            END AS so_code,

            /* ============================
             * JOB ORDER MATERIAL
             * ============================ */

            joim.job_order_material_id,
            joim.material_id,
            joim.material_code,
            joim.material_name,
            joim.quantity_required,

            /* Unit */
            joim.unit AS unit_id,
            um.unit_abbr AS unit,

            joim.cost,

            /* ============================
             * PREVIOUSLY REQUESTED
             * ============================ */

            COALESCE(
                (
                    SELECT SUM(pmri.request_quantity)
                    FROM production_material_request_items pmri

                    INNER JOIN production_material_requests pmr
                        ON pmr.production_material_request_id =
                           pmri.production_material_request_id

                    WHERE pmri.job_order_material_id =
                          joim.job_order_material_id
                ),
                0
            ) AS previously_requested

        FROM job_order_items joi

        INNER JOIN job_order jo
            ON jo.job_order_id = joi.job_order_id

        INNER JOIN item_master im
            ON im.product_id = joi.item_master_id

        INNER JOIN job_order_item_materials joim
            ON joim.job_order_item_id = joi.job_order_item_id

        LEFT JOIN unit_master um
            ON um.unit_id = joim.unit

        /* Normal SO */
        LEFT JOIN sales_order_master so_normal
            ON so_normal.so_id = jo.fk_sales_order_id
            AND jo.job_order_type = 0

        WHERE joi.job_order_id = ?

        ORDER BY
            joi.job_order_item_id,
            joim.job_order_material_id
    ";

    $query = $this->db->query(
        $sql,
        array($job_order_id)
    );

    $items = $query->result();

    foreach ($items as &$item) {

        $required = (float) $item->quantity_required;

        $previously_requested =
            (float) $item->previously_requested;

        $remaining =
            $required - $previously_requested;

        if ($remaining < 0) {
            $remaining = 0;
        }

        $item->remaining_quantity = $remaining;
    }

    return $items;
}
public function save_material_request(
    $job_order_id,
    $request_date,
    $remarks,
    $items
) {
    $this->db->trans_start();

    /*
     * =========================================================
     * 1. Generate Request Number
     * =========================================================
     */
    $request_no = $this->generate_material_request_no();


    /*
     * =========================================================
     * 2. Insert Header
     * =========================================================
     */
    $header = array(
        'material_request_no' => $request_no,
        'job_order_id'        => $job_order_id,
        'request_date'        => $request_date,
        'remarks'             => $remarks,
        'status'              => 'Pending'
    );

    $this->db->insert(
        'production_material_requests',
        $header
    );

    $request_id = $this->db->insert_id();


    /*
     * =========================================================
     * 3. Insert Items
     * =========================================================
     */
    if (!empty($items)) {

        foreach ($items as $item) {

            $request_quantity = isset($item['request_quantity'])
                ? (float)$item['request_quantity']
                : 0;

            if ($request_quantity <= 0) {
                continue;
            }


            /*
             * Required quantity
             */
            $required_quantity = isset($item['required_quantity'])
                ? (float)$item['required_quantity']
                : 0;


            /*
             * =================================================
             * Get TOTAL previously requested quantity
             *
             * This is from older material requests.
             * =================================================
             */
            $previous = $this->db
                ->select_sum(
                    'request_quantity',
                    'total_requested'
                )
                ->from(
                    'production_material_request_items'
                )
                ->where(
                    'job_order_item_id',
                    $item['job_order_item_id']
                )
                ->where(
                    'job_order_material_id',
                    $item['job_order_material_id']
                )
                ->get()
                ->row();


            $previously_requested =
                !empty($previous->total_requested)
                    ? (float)$previous->total_requested
                    : 0;


            /*
             * =================================================
             * New total previously requested
             *
             * Previous + Current Request
             * =================================================
             */
            $new_previously_requested =
                $previously_requested
                + $request_quantity;


            /*
             * =================================================
             * Do not exceed Required Quantity
             * =================================================
             */
            if (
                $new_previously_requested >
                $required_quantity
            ) {

                $request_quantity =
                    $required_quantity
                    - $previously_requested;


                if ($request_quantity <= 0) {
                    continue;
                }


                $new_previously_requested =
                    $previously_requested
                    + $request_quantity;
            }


            /*
             * =================================================
             * Remaining Quantity
             *
             * Required - Total Requested
             * =================================================
             */
            $remaining_quantity =
                $required_quantity
                - $new_previously_requested;


            if ($remaining_quantity < 0) {
                $remaining_quantity = 0;
            }


            /*
             * =================================================
             * Unit Cost
             * =================================================
             */
            $material = $this->db
                ->select('cost')
                ->from('job_order_item_materials')
                ->where(
                    'job_order_material_id',
                    $item['job_order_material_id']
                )
                ->where(
                    'job_order_item_id',
                    $item['job_order_item_id']
                )
                ->get()
                ->row_array();


            $unit_cost =
                !empty($material['cost'])
                    ? (float)$material['cost']
                    : 0;


            /*
             * =================================================
             * Total Cost
             * =================================================
             */
            $total_cost =
                $request_quantity
                * $unit_cost;


            /*
             * =================================================
             * Insert Item
             * =================================================
             */
            $item_data = array(

                'production_material_request_id'
                    => $request_id,

                'job_order_item_id'
                    => $item['job_order_item_id'],

                'job_order_material_id'
                    => $item['job_order_material_id'],

                'material_id'
                    => !empty($item['material_id'])
                        ? $item['material_id']
                        : null,

                'material_code'
                    => isset($item['material_code'])
                        ? $item['material_code']
                        : null,

                'material_name'
                    => isset($item['material_name'])
                        ? $item['material_name']
                        : null,

                'required_quantity'
                    => $required_quantity,

                /*
                 * TOTAL requested until this request
                 */
                'previously_requested'
                    => $new_previously_requested,

                /*
                 * Current request only
                 */
                'request_quantity'
                    => $request_quantity,

                /*
                 * Remaining after this request
                 */
                'remaining_quantity'
                    => $remaining_quantity,

                'unit'
                    => isset($item['unit'])
                        ? $item['unit']
                        : null,

                'unit_cost'
                    => $unit_cost,

                'total_cost'
                    => $total_cost
            );


            $this->db->insert(
                'production_material_request_items',
                $item_data
            );
        }
    }


    /*
     * =========================================================
     * 4. Complete Transaction
     * =========================================================
     */
    $this->db->trans_complete();


    return $this->db->trans_status();
}

public function generate_material_request_no()
{
    $row = $this->db
        ->select('material_request_no')
        ->from('production_material_requests')
        ->order_by(
            'production_material_request_id',
            'DESC'
        )
        ->limit(1)
        ->get()
        ->row();

    if (!$row) {
        return 'MR-000001';
    }

    $number =
        (int)str_replace(
            'MR-',
            '',
            $row->material_request_no
        );

    $number++;

    return 'MR-' .
        str_pad(
            $number,
            6,
            '0',
            STR_PAD_LEFT
        );
}
public function get_job_order_materials_for_request($job_order_id)
{
    $this->db->select('
        joi.job_order_item_id,
        joi.job_order_id,
        joi.project_item_id,
        joi.item_master_id,
        joi.item_code,
        joi.item_description,
        joi.quantity AS item_quantity,

        jom.job_order_material_id,
        jom.material_id,
        jom.material_code,
        jom.material_name,
        jom.quantity_required,
        jom.unit,
        jom.cost AS unit_cost
    ');

    $this->db->from('job_order_items joi');

    $this->db->join(
        'job_order_item_materials jom',
        'jom.job_order_item_id = joi.job_order_item_id',
        'inner'
    );

    $this->db->where(
        'joi.job_order_id',
        $job_order_id
    );

    $this->db->order_by(
        'joi.job_order_item_id',
        'ASC'
    );

    $this->db->order_by(
        'jom.job_order_material_id',
        'ASC'
    );

    $rows = $this->db->get()->result();

    foreach ($rows as &$row) {

        /*
         * Total quantity already requested
         * through previous material requests
         */
        $previous = $this->db
            ->select_sum(
                'request_quantity',
                'previously_requested'
            )
            ->from('production_material_request_items')
            ->where(
                'job_order_material_id',
                $row->job_order_material_id
            )
            ->get()
            ->row();

        $previously_requested =
            (float)($previous->previously_requested ?? 0);

        /*
         * Required quantity
         */
        $required_quantity =
            (float)$row->quantity_required;

        /*
         * Remaining quantity available
         * for new request
         */
        $remaining_quantity =
            $required_quantity -
            $previously_requested;

        if ($remaining_quantity < 0) {
            $remaining_quantity = 0;
        }

        $row->previously_requested =
            $previously_requested;

        $row->remaining_quantity =
            $remaining_quantity;

        $row->unit_cost =
            (float)$row->unit_cost;

        /*
         * Default request quantity
         */
        $row->request_quantity =
            $remaining_quantity;

        /*
         * Default total cost
         */
        $row->total_cost =
            $remaining_quantity *
            $row->unit_cost;
    }

    return $rows;
}

public function save_production_material_request(
    $request_data,
    $items
) {
    $this->db->trans_start();

    /*
     * ---------------------------------------------------------
     * 1. Insert Material Request Header
     * ---------------------------------------------------------
     */
    $this->db->insert(
        'production_material_requests',
        $request_data
    );

    $request_id = $this->db->insert_id();


    /*
     * ---------------------------------------------------------
     * 2. Insert Request Items
     * ---------------------------------------------------------
     */
    if (
        $request_id &&
        !empty($items)
    ) {

        foreach ($items as $item) {

            $request_quantity =
                isset($item['request_quantity'])
                    ? (float)$item['request_quantity']
                    : 0;

            /*
             * Ignore zero quantity
             */
            if ($request_quantity <= 0) {
                continue;
            }


            /*
             * -------------------------------------------------
             * 3. Get Required Quantity and Cost
             *    directly from Job Order Material
             * -------------------------------------------------
             */
            $material = $this->db
                ->select('
                    quantity_required,
                    cost
                ')
                ->from('job_order_item_materials')
                ->where(
                    'job_order_material_id',
                    $item['job_order_material_id']
                )
                ->where(
                    'job_order_item_id',
                    $item['job_order_item_id']
                )
                ->get()
                ->row();


            if (!$material) {
                continue;
            }


            $required_quantity =
                (float)$material->quantity_required;

            $unit_cost = (float)$material->cost;


            /*
             * -------------------------------------------------
             * 4. Calculate Previously Requested
             *
             * Get all previous requests for this material.
             *
             * No current request exists yet, so no need
             * to exclude $request_id.
             * -------------------------------------------------
             */
            $previous = $this->db
                ->select_sum(
                    'request_quantity',
                    'previously_requested'
                )
                ->from(
                    'production_material_request_items'
                )
                ->where(
                    'job_order_material_id',
                    $item['job_order_material_id']
                )
                ->get()
                ->row();


            $previously_requested =
                !empty(
                    $previous->previously_requested
                )
                    ? (float)$previous->previously_requested
                    : 0;


            /*
             * -------------------------------------------------
             * 5. Calculate Available Quantity
             * -------------------------------------------------
             */
            $available_quantity =
                $required_quantity -
                $previously_requested;


            if ($available_quantity < 0) {
                $available_quantity = 0;
            }


            /*
             * -------------------------------------------------
             * 6. Prevent Request Quantity from exceeding
             *    available quantity
             * -------------------------------------------------
             */
            if (
                $request_quantity >
                $available_quantity
            ) {

                $request_quantity =
                    $available_quantity;
            }


            /*
             * Ignore if nothing is available
             */
            if ($request_quantity <= 0) {
                continue;
            }


            /*
             * -------------------------------------------------
             * 7. Calculate Total Cost
             * -------------------------------------------------
             */
            $total_cost =  $request_quantity * $unit_cost;

            

            /*
             * -------------------------------------------------
             * 8. Insert Item
             * -------------------------------------------------
             */
            $item_data = array(

                'production_material_request_id' =>
                    $request_id,

                'job_order_item_id' =>
                    $item['job_order_item_id'],

                'job_order_material_id' =>
                    $item['job_order_material_id'],

                'material_id' =>
                    !empty($item['material_id'])
                        ? $item['material_id']
                        : null,

                'material_code' =>
                    isset($item['material_code'])
                        ? $item['material_code']
                        : null,

                'material_name' =>
                    $item['material_name'],

                'required_quantity' =>
                    $required_quantity,

                'previously_requested' =>
                    $previously_requested,

                'request_quantity' =>
                    $request_quantity,

                'unit' =>
                    isset($item['unit'])
                        ? $item['unit']
                        : null,

                'unit_cost' =>
                    $unit_cost,

                'total_cost' =>
                    $total_cost
            );


            $this->db->insert(
                'production_material_request_items',
                $item_data
            );
        }
    }


    /*
     * ---------------------------------------------------------
     * 9. Complete Transaction
     * ---------------------------------------------------------
     */
    $this->db->trans_complete();


    /*
     * ---------------------------------------------------------
     * 10. Return Result
     * ---------------------------------------------------------
     */
    if (
        $this->db->trans_status() === FALSE
    ) {
        return false;
    }


    return $request_id;
}

public function get_production_material_request(
    $request_id
) {
    return $this->db
        ->select('
            pmr.*,
            jo.job_order_no,
            jo.fk_project_id,
            pm.project_name
        ')
        ->from(
            'production_material_requests pmr'
        )
        ->join(
            'job_order jo',
            'jo.job_order_id = pmr.job_order_id',
            'left'
        )
        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )
        ->where(
            'pmr.production_material_request_id',
            $request_id
        )
        ->get()
        ->row();
}
public function get_production_material_request_items(
    $request_id
) {
    return $this->db
        ->select('
            pmri.*,

            joi.item_code,
            joi.item_description,

            jom.quantity_required AS original_required_quantity
        ')
        ->from(
            'production_material_request_items pmri'
        )
        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = pmri.job_order_item_id',
            'left'
        )
        ->join(
            'job_order_item_materials jom',
            'jom.job_order_material_id = pmri.job_order_material_id',
            'left'
        )
        ->where(
            'pmri.production_material_request_id',
            $request_id
        )
        ->order_by(
            'pmri.production_material_request_item_id',
            'ASC'
        )
        ->get()
        ->result();
}
public function delete_production_material_request(
    $request_id
) {
    $this->db->trans_start();

    $this->db
        ->where(
            'production_material_request_id',
            $request_id
        )
        ->delete(
            'production_material_request_items'
        );

    $this->db
        ->where(
            'production_material_request_id',
            $request_id
        )
        ->delete(
            'production_material_requests'
        );

    $this->db->trans_complete();

    return $this->db->trans_status();
}

public function get_materials_for_material_request_edit(
    $job_order_id,
    $material_request_id
) {
    $sql = "
        SELECT
            joi.job_order_item_id,
            joi.item_master_id,
            joi.item_description,
            joi.quantity AS item_quantity,

            joim.job_order_material_id,
            joim.material_id,
            joim.material_code,
            joim.material_name,
            joim.quantity_required,
            joim.unit,
            joim.cost,

            pmri.production_material_request_item_id,
            pmri.request_quantity,
            pmri.unit_cost,
            pmri.total_cost,

            COALESCE(
                (
                    SELECT SUM(pmri2.request_quantity)
                    FROM production_material_request_items pmri2
                    INNER JOIN production_material_requests pmr2
                        ON pmr2.production_material_request_id =
                           pmri2.production_material_request_id
                    WHERE pmri2.job_order_material_id =
                          joim.job_order_material_id

                    AND pmri2.production_material_request_id != ?
                ),
                0
            ) AS previously_requested

        FROM job_order_items joi

        INNER JOIN job_order_item_materials joim
            ON joim.job_order_item_id =
               joi.job_order_item_id

        LEFT JOIN production_material_request_items pmri
            ON pmri.job_order_material_id =
               joim.job_order_material_id

            AND pmri.production_material_request_id = ?

        WHERE joi.job_order_id = ?

        ORDER BY
            joi.job_order_item_id,
            joim.job_order_material_id
    ";

    $query = $this->db->query(
        $sql,
        array(
            $material_request_id,
            $material_request_id,
            $job_order_id
        )
    );

    $items = $query->result();

    foreach ($items as &$item) {

        $required = (float) $item->quantity_required;

        /*
         * Requests from OTHER material requests
         */
        $previously_requested =
            (float) $item->previously_requested;

        /*
         * Current request quantity
         */
        $current_request_quantity =
            (float) $item->request_quantity;

        /*
         * Maximum quantity that can be entered
         * while editing this request.
         */
        $editable_remaining =
            $required -
            $previously_requested;

        if ($editable_remaining < 0) {
            $editable_remaining = 0;
        }

        /*
         * Remaining after current request
         */
        $remaining_quantity =
            $editable_remaining -
            $current_request_quantity;

        if ($remaining_quantity < 0) {
            $remaining_quantity = 0;
        }

        $item->previously_requested =
            $previously_requested;

        $item->editable_remaining =
            $editable_remaining;

        $item->remaining_quantity =
            $remaining_quantity;
    }

    return $items;
}

    public function material_request_view($request_id) {
        $data['title'] = 'View Material Request';
        $data['request'] =  $this->Production_model->get_material_request($request_id);
        if (empty($data['request'])) {
            show_404();
        }
        $data['items'] = $this->Production_model->get_material_request_items($request_id);
        $data['main_content'] = 'production/material_request_view';
        $this->load->view('includes/template', $data);
    }

    public function material_request_edit($request_id)
    {
        $data['title'] = 'Edit Material Request';
        $data['request'] = $this->Production_model->get_material_request($request_id);
        if (empty($data['request'])) {
            show_404();
        }
        $data['items'] = $this->Production_model->get_material_request_items($request_id);
        $data['main_content'] = 'production/material_request_edit';
        $this->load->view('includes/template',$data);
    }

    public function get_material_request($request_id)
    {
        return $this->db
            ->select('
                pmr.*,
                jo.job_order_no,
                jo.fk_project_id,
                pm.project_name
            ')
            ->from(
                'production_material_requests pmr'
            )
            ->join(
                'job_order jo',
                'jo.job_order_id = pmr.job_order_id',
                'left'
            )
            ->join(
                'project_master pm',
                'pm.project_id = jo.fk_project_id',
                'left'
            )
            ->where(
                'pmr.production_material_request_id',
                $request_id
            )
            ->get()
            ->row();
    }

public function get_material_request_items($request_id)
{
    return $this->db
        ->select('
            pmri.*,
            joi.item_description,
            joi.item_master_id,
            im.product_name,

            joim.unit,
            joim.quantity_required AS job_order_material_qty,

            arm.material_name AS raw_material_name,
            arm.material_code AS raw_material_code,
            arm.unit AS raw_material_unit,
            arm.cost AS raw_material_cost

        ')
        ->from('production_material_request_items pmri')

        /* Job Order Item */
        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = pmri.job_order_item_id',
            'left'
        )

        /* Item Master */
        ->join(
            'item_master im',
            'im.product_id = joi.item_master_id',
            'left'
        )

        /* Raw Material */
        ->join(
            'amc_raw_materials arm',
            'arm.material_id = pmri.material_id',
            'left'
        )

        /* Job Order Item Material */
        ->join(
            'job_order_item_materials joim',
            'joim.job_order_item_id = pmri.job_order_item_id
             AND joim.material_id = pmri.material_id',
            'left'
        )

        ->where(
            'pmri.production_material_request_id',
            $request_id
        )

        ->order_by(
            'pmri.production_material_request_item_id',
            'ASC'
        )

        ->get()
        ->result();
}



    public function delete_material_request($request_id)
    {
        $this->db->trans_start();

        /*
        * Delete request items
        */
        $this->db
            ->where(
                'production_material_request_id',
                $request_id
            )
            ->delete(
                'production_material_request_items'
            );

        /*
        * Delete request header
        */
        $this->db
            ->where(
                'production_material_request_id',
                $request_id
            )
            ->delete(
                'production_material_requests'
            );

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    //M edit
public function get_material_request_items_for_edit($request_id)
{
    $this->db->select('
        pmri.*,
        joi.item_master_id,
        joi.item_description,
        im.product_name,
        joim.quantity_required AS original_required_quantity,
        joim.cost AS material_cost,joim.unit,

        COALESCE(
            (
                SELECT SUM(pmri2.request_quantity)
                FROM production_material_request_items pmri2
                INNER JOIN production_material_requests pmr2
                    ON pmr2.production_material_request_id =
                       pmri2.production_material_request_id
                WHERE pmri2.job_order_material_id =
                      pmri.job_order_material_id
                AND pmri2.production_material_request_id != ' . (int)$request_id . '
            ),
            0
        ) AS previous_other_requests
    ');

    $this->db->from('production_material_request_items pmri');

    $this->db->join(
        'job_order_items joi',
        'joi.job_order_item_id = pmri.job_order_item_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = joi.item_master_id',
        'left'
    );

    $this->db->join(
        'job_order_item_materials joim',
        'joim.job_order_material_id = pmri.job_order_material_id',
        'left'
    );

    $this->db->where(
        'pmri.production_material_request_id',
        $request_id
    );

    $this->db->order_by(
        'pmri.production_material_request_item_id',
        'ASC'
    );

    $items = $this->db->get()->result();

    foreach ($items as &$item) {

        /*
         * Total quantity requested
         * by OTHER requests
         */
        $previous_other =
            (float) $item->previous_other_requests;

        /*
         * Required quantity from BOM
         */
        $required =
            (float) $item->required_quantity;

        /*
         * Maximum quantity available
         * for current edit
         */
        $editable_max =
            $required - $previous_other;

        if ($editable_max < 0) {
            $editable_max = 0;
        }

        /*
         * Remaining quantity after
         * current request
         */
        $remaining =
            $editable_max -
            (float) $item->request_quantity;

        if ($remaining < 0) {
            $remaining = 0;
        }

        $item->editable_max_quantity =
            $editable_max;

        $item->remaining_quantity1 =
            (float) $item->original_required_quantity
            - (float) $item->previously_requested;

        $item->unit_cost =
            (float) $item->material_cost;
    }

    return $items;
}

public function update_material_request(
    $request_id,
    $request_date,
    $remarks,
    $items
) {
    $this->db->trans_start();


    /*
     * =========================================================
     * 1. Update Header
     * =========================================================
     */
    $this->db
        ->where(
            'production_material_request_id',
            $request_id
        )
        ->update(
            'production_material_requests',
            array(
                'request_date' => $request_date,
                'remarks'      => $remarks,
                'updated_at'   => date('Y-m-d H:i:s')
            )
        );


    /*
     * =========================================================
     * 2. Update Items
     * =========================================================
     */
    if (!empty($items)) {

        foreach ($items as $item) {

            if (
                empty(
                    $item[
                        'production_material_request_item_id'
                    ]
                )
            ) {
                continue;
            }


            $request_item_id =
                (int)$item[
                    'production_material_request_item_id'
                ];


            /*
             * =================================================
             * Get Existing Item
             * =================================================
             */
            $current_item = $this->db
                ->select('
                    required_quantity,
                    previously_requested,
                    request_quantity,
                    unit_cost
                ')
                ->from(
                    'production_material_request_items'
                )
                ->where(
                    'production_material_request_item_id',
                    $request_item_id
                )
                ->where(
                    'production_material_request_id',
                    $request_id
                )
                ->get()
                ->row();


            if (!$current_item) {
                continue;
            }


            /*
             * =================================================
             * Required
             * =================================================
             */
            $required_quantity =
                (float)$current_item->required_quantity;


            /*
             * =================================================
             * Previously Requested
             *
             * Existing accumulated quantity
             * =================================================
             */
            $old_previously_requested =
                (float)$current_item->previously_requested;


            /*
             * =================================================
             * New Request Quantity
             * =================================================
             */
            $request_quantity =
                isset($item['request_quantity'])
                    ? (float)$item['request_quantity']
                    : 0;


            if ($request_quantity < 0) {
                $request_quantity = 0;
            }


            /*
             * =================================================
             * NEW Previously Requested
             *
             * Old Previously Requested + New Request
             *
             * Example:
             *
             * Old Previously = 100
             * New Request    = 20
             *
             * New Previously = 120
             * =================================================
             */
            $new_previously_requested =
                $old_previously_requested
                + $request_quantity;


            /*
             * =================================================
             * Prevent exceeding required quantity
             * =================================================
             */
            if (
                $new_previously_requested >
                $required_quantity
            ) {

                $request_quantity =
                    $required_quantity
                    - $old_previously_requested;


                if ($request_quantity < 0) {
                    $request_quantity = 0;
                }


                $new_previously_requested =
                    $old_previously_requested
                    + $request_quantity;
            }


            /*
             * =================================================
             * Remaining Quantity
             *
             * Required - Previously Requested
             * =================================================
             */
            $remaining_quantity =
                $required_quantity
                - $new_previously_requested;


            if ($remaining_quantity < 0) {
                $remaining_quantity = 0;
            }


            /*
             * =================================================
             * Unit Cost
             * =================================================
             */
            $unit_cost =
                (float)$current_item->unit_cost;


            if ($unit_cost < 0) {
                $unit_cost = 0;
            }


            /*
             * =================================================
             * Total Cost
             * =================================================
             */
            $total_cost =
                $request_quantity
                * $unit_cost;


            /*
             * =================================================
             * Update
             * =================================================
             */
            $item_data = array(

                /*
                 * Accumulated requested quantity
                 */
                'previously_requested'
                    => $new_previously_requested,

                /*
                 * New request
                 */
                'request_quantity'
                    => $request_quantity,

                /*
                 * Remaining
                 */
                'remaining_quantity'
                    => $remaining_quantity,

                /*
                 * Cost
                 */
                'unit_cost'
                    => $unit_cost,

                'total_cost'
                    => $total_cost
            );


            $this->db
                ->where(
                    'production_material_request_item_id',
                    $request_item_id
                )
                ->where(
                    'production_material_request_id',
                    $request_id
                )
                ->update(
                    'production_material_request_items',
                    $item_data
                );
        }
    }


    /*
     * =========================================================
     * 3. Complete Transaction
     * =========================================================
     */
    $this->db->trans_complete();


    return $this->db->trans_status();
}
public function get_material_info($material_id)
{

     $query=$this->db->query("select material_request_no,	remarks from production_material_requests where production_material_request_id =$material_id");
     return $row = $query->row();

}
public function get_material_print($material_id)
{

     $query=$this->db->query("select job_order_id from production_material_requests where production_material_request_id =$material_id");
     $row = $query->row();
     $job_order_id = $row->job_order_id;
     return $this->db
        ->select('
            jo.*,
            p.project_name,p.remarks as premarks
        ')
        ->from('job_order jo')
        ->join(
            'project_master p',
            'p.project_id = jo.fk_project_id',
            'left'
        )
        ->where(
            'jo.job_order_id',
            $job_order_id
        )
        ->get()
        ->row();
}

public function get_material_items_print($job_order_id)
{
  
    return $this->db
        ->select('
            joi.job_order_item_id,
            joi.job_order_id,
            joi.project_item_id,joi.unit,joi.cost,

            pi.product_id,
            pi.quantity,
            pi.unit_price,
            pi.amount as total,

            im.product_name
        ')
        ->from('job_order_items joi')
        /*->join(
            'project_items pi',
            'pi.id = joi.project_item_id',
            'left'
        )*/
        ->join(
           // 'project_items pi',
            'sales_order_products pi',
            'pi.product_table_id  = joi.project_item_id',
            'left'
        )
        ->join(
            'item_master im',
            'im.product_id = pi.product_id',
            'left'
        )
        ->where(
            'joi.job_order_id',
            $job_order_id
        )->get()->result();
}

public function get_production_item_materials_for_print($job_order_id)
{
    return $this->db
        ->select('
            jom.production_material_request_item_id,jom.job_order_item_id,
            jo.project_item_id,jom.material_id,jom.material_code,
            jom.material_name,jom.required_quantity,jom.required_quantity,jom.previously_requested,jom.required_quantity,jom.remaining_quantity,
            um.unit_id,um.unit_abbr,jom.unit_cost,jomm.unit,jomm.source
        ')->from('production_material_request_items jom')
         ->join(
            'job_order_items jo',
            'jo.job_order_item_id = jom.job_order_item_id',
            'left'
        )
         ->join(
            'job_order_item_materials jomm',
            'jomm.job_order_material_id = jom.job_order_material_id',
            'left'
        )
        ->join(
            'unit_master um',
            'um.unit_id = jom.unit',
            'left'
        )->where('jom.job_order_item_id ',$job_order_id)
        ->order_by(
            'jom.job_order_material_id',
            'ASC'
        )->get()->result();
}
///FMT MODEL FUNS
   public function generate_stock_transfer_no()
    {
        $row = $this->db
            ->select('stock_transfer_no')
            ->from('stock_transfers')
            ->order_by(
                'stock_transfer_id',
                'DESC'
            )
            ->limit(1)
            ->get()
            ->row_array();


        if (!$row) {
            return 'FMT-000001';
        }


        $last =
            $row['stock_transfer_no'];

        preg_match(
            '/(\d+)$/',
            $last,
            $matches
        );


        $number =
            !empty($matches[1])
                ? ((int)$matches[1] + 1)
                : 1;


        return 'FMT-' .
            str_pad(
                $number,
                6,
                '0',
                STR_PAD_LEFT
            );
    }


    /* =========================================================
     * LIST
     * ========================================================= */

    public function get_stock_transfers()
    {
        return $this->db
            ->select('
                st.*,

                jo.job_order_no,
                jc.job_completion_no,

                bm1.branch_name AS from_branch_name,
                wm1.warehouse_name AS from_warehouse_name,
                sm1.store_name AS from_store_name,

                bm2.branch_name AS to_branch_name,
                wm2.warehouse_name AS to_warehouse_name,
                sm2.store_name AS to_store_name
            ')
            ->from('stock_transfers st')

            ->join(
                'job_order jo',
                'jo.job_order_id = st.job_order_id',
                'left'
            )

            ->join(
                'job_completion jc',
                'jc.job_completion_id = st.job_completion_id',
                'left'
            )

            ->join(
                'branch_master bm1',
                'bm1.branch_id = st.from_branch_id',
                'left'
            )

            ->join(
                'warehouse_master wm1',
                'wm1.warehouse_id = st.from_warehouse_id',
                'left'
            )

            ->join(
                'store_master sm1',
                'sm1.store_id = st.from_store_id',
                'left'
            )

            ->join(
                'branch_master bm2',
                'bm2.branch_id = st.to_branch_id',
                'left'
            )

            ->join(
                'warehouse_master wm2',
                'wm2.warehouse_id = st.to_warehouse_id',
                'left'
            )

            ->join(
                'store_master sm2',
                'sm2.store_id = st.to_store_id',
                'left'
            )

            ->order_by(
                'st.stock_transfer_id',
                'DESC'
            )

            ->get()
            ->result_array();
    }


    /* =========================================================
     * GET SINGLE TRANSFER
     * ========================================================= */

    public function get_stock_transfer($id)
    {
        return $this->db
            ->where(
                'stock_transfer_id',
                $id
            )
            ->get('stock_transfers')
            ->row_array();
    }


    /* =========================================================
     * GET TRANSFER ITEMS
     * ========================================================= */

    public function get_stock_transfer_items($id)
    {
        return $this->db
        ->select('
            sti.*,

            jci.job_completion_item_id,

            im.product_code AS master_product_code,
            im.product_name AS master_product_name,
            im.unit_id,

            um.unit_name,
            um.unit_abbr
        ')

        ->from('pstock_transfer_items sti')

        ->join(
            'job_completion_items jci',
            'jci.job_completion_item_id = sti.job_completion_item_id',
            'left'
        )

        ->join(
            'item_master im',
            'im.product_id = sti.item_master_id',
            'left'
        )

        ->join(
            'unit_master um',
            'um.unit_id = im.unit_id',
            'left'
        )

        ->where(
            'sti.stock_transfer_id',
            $id
        )

        ->order_by(
            'sti.stock_transfer_item_id',
            'ASC'
        )

        ->get()
        ->result_array();
    }


    /* =========================================================
     * AVAILABLE JOB COMPLETIONS
     * ========================================================= */

   /* public function get_available_job_completions(
        $selected_id = null
    ) {

        $sql = "
            SELECT
                jc.job_completion_id,
                jc.job_completion_no,
                jc.completion_date,

                jo.job_order_id,
                jo.job_order_no,
                jo.fk_project_id AS project_id,

                (
                    SELECT p.so_id
                    FROM project_master p
                    WHERE p.project_id = jo.fk_project_id
                    LIMIT 1
                ) AS so_id

            FROM job_completion jc

            INNER JOIN job_order jo
                ON jo.job_order_id = jc.job_order_id

            WHERE 1=1

            AND (
                EXISTS (
                    SELECT 1
                    FROM job_completion_items jci

                    LEFT JOIN (
                        SELECT
                            job_completion_item_id,
                            SUM(transfer_quantity)
                                AS transferred_qty

                        FROM stock_transfer_items
                        GROUP BY job_completion_item_id
                    ) sti
                        ON sti.job_completion_item_id =
                           jci.job_completion_item_id

                    WHERE
                        jci.job_completion_id =
                        jc.job_completion_id

                    AND (
                        jci.completed_quantity -
                        IFNULL(
                            sti.transferred_qty,
                            0
                        )
                    ) > 0
                )

                OR jc.job_completion_id = ?
            )

            ORDER BY
                jc.job_completion_id DESC
        ";


        return $this->db
            ->query(
                $sql,
                array(
                    $selected_id ?: 0
                )
            )
            ->result_array();
    }
*/
public function get_available_job_completions($selected_id = null)
{
    $sql = "
        SELECT
            jc.job_completion_id,
            jc.job_completion_no,
            jc.completion_date,

            jo.job_order_id,
            jo.job_order_no,
            jo.fk_project_id AS project_id,

            (
                SELECT p.so_id
                FROM project_master p
                WHERE p.project_id = jo.fk_project_id
                LIMIT 1
            ) AS so_id

        FROM job_completion jc

        INNER JOIN job_order jo
            ON jo.job_order_id = jc.job_order_id

        WHERE jo.is_deleted = 0
        AND NOT EXISTS (
            SELECT 1

            FROM job_order_items joi

            WHERE joi.job_order_id = jo.job_order_id

            AND joi.quantity > (
                SELECT
                    IFNULL(
                        SUM(jci.completed_quantity),
                        0
                    )

                FROM job_completion_items jci

                INNER JOIN job_completion jc2
                    ON jc2.job_completion_id =
                       jci.job_completion_id

                WHERE
                    jci.job_order_item_id =
                    joi.job_order_item_id

                AND jc2.job_order_id =
                    jo.job_order_id
            )
        )
        AND (
            NOT EXISTS (
                SELECT 1

                FROM stock_transfers st

                WHERE st.job_completion_id =
                      jc.job_completion_id
            )

            OR jc.job_completion_id = ?
        )

        ORDER BY
            jc.job_completion_id DESC
    ";

    return $this->db
        ->query(
            $sql,
            array(
                $selected_id ?: 0
            )
        )
        ->result_array();
}
public function get_job_completion_for_transfer($job_completion_id)
{
    /* =========================================================
     * HEADER
     * ========================================================= */

    $header = $this->db
        ->select('
            jc.job_completion_id,
            jc.job_completion_no,
            jc.completion_date,

            jo.job_order_id,
            jo.job_order_no,
            jo.fk_project_id AS project_id,

            p.so_id,
            p.project_name
        ')
        ->from('job_completion jc')
        ->join(
            'job_order jo',
            'jo.job_order_id = jc.job_order_id',
            'inner'
        )
        ->join(
            'project_master p',
            'p.project_id = jo.fk_project_id',
            'left'
        )
        ->where(
            'jc.job_completion_id',
            $job_completion_id
        )
        ->get()
        ->row_array();


    if (!$header) {
        return false;
    }


    /* =========================================================
     * COMPLETED ITEMS
     *
     * Important:
     * We use job_completion_items as the source.
     * Therefore, when a second item is completed later,
     * it will also appear here.
     * ========================================================= */

    $this->db->select('
        jci.job_completion_item_id,
        jci.job_completion_id,

        jci.job_order_item_id,
        jci.project_item_id,

        jci.ordered_quantity,
        jci.previously_completed,
        jci.completed_quantity,
        jci.remaining_quantity,

        joi.item_master_id,
        joi.item_code,
        joi.item_description,
        joi.unit,

        im.product_code,
        im.product_name,

        um.unit_name,
        um.unit_abbr
    ');

    $this->db->from('job_completion_items jci');

    $this->db->join(
        'job_order_items joi',
        'joi.job_order_item_id = jci.job_order_item_id',
        'inner'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = joi.item_master_id',
        'left'
    );

    $this->db->join(
        'unit_master um',
        'um.unit_id = im.unit_id',
        'left'
    );

    $this->db->where(
        'jci.job_completion_id',
        $job_completion_id
    );

    /*
     * Only items that actually have completed quantity.
     */
    $this->db->where(
        'jci.completed_quantity >',
        0
    );

    $this->db->order_by(
        'jci.job_completion_item_id',
        'ASC'
    );

    $items = $this->db
        ->get()
        ->result_array();


    if (empty($items)) {
        return false;
    }


    return array(
        'header' => $header,
        'items'  => $items
    );
}


    /* =========================================================
     * SAVE STOCK TRANSFER
     * ========================================================= */
    /*
    public function save_stock_transfer(
        $header,
        $items
    ) {

        $this->db->trans_begin();

        $completion =
            $this->db
                 ->select('
                    jc.job_order_id,
                    jo.fk_project_id
                 ')
                 ->from('job_completion jc')
                 ->join(
                     'job_order jo',
                     'jo.job_order_id =
                      jc.job_order_id'
                 )
                 ->where(
                     'jc.job_completion_id',
                     $header['job_completion_id']
                 )
                 ->get()
                 ->row_array();


        if (!$completion) {

            $this->db->trans_rollback();

            return false;
        }


        $project_id =
            $completion['fk_project_id'];

        $project =
            $this->db
                 ->select('so_id')
                 ->where(
                     'project_id',
                     $project_id
                 )
                 ->get('project_master')
                 ->row_array();


        $so_id =
            $project
                ? $project['so_id']
                : null;


        $header['stock_transfer_no'] =
            $this->generate_stock_transfer_no();

        $header['job_order_id'] =
            $completion['job_order_id'];

        $header['project_id'] =
            $project_id;

        $header['so_id'] =
            $so_id;

        $header['status'] =
            'Pending';


        $this->db->insert(
            'stock_transfers',
            $header
        );


        $stock_transfer_id =
            $this->db->insert_id();


        if (!$stock_transfer_id) {

            $this->db->trans_rollback();

            return false;
        }

        foreach ($items as $item) {

            $jci =
                $this->db
                     ->select('
                        jci.*,
                        joi.item_master_id,
                        joi.item_code,
                        joi.item_description,
                        joi.unit
                     ')
                     ->from(
                         'job_completion_items jci'
                     )
                     ->join(
                         'job_order_items joi',
                         'joi.job_order_item_id =
                          jci.job_order_item_id'
                     )
                     ->where(
                         'jci.job_completion_item_id',
                         $item['job_completion_item_id']
                     )
                     ->where(
                         'jci.job_completion_id',
                         $header['job_completion_id']
                     )
                     ->get()
                     ->row_array();


            if (!$jci) {

                $this->db->trans_rollback();

                return false;
            }


            $previous =
                $this->db
                     ->select_sum(
                         'transfer_quantity'
                     )
                     ->where(
                         'job_completion_item_id',
                         $item['job_completion_item_id']
                     )
                     ->get(
                         'stock_transfer_items'
                     )
                     ->row_array();


            $previously_transferred =
                (float)(
                    $previous['transfer_quantity']
                    ?? 0
                );


            $available =
                (float)$jci['completed_quantity']
                -
                $previously_transferred;


            $transfer_qty =
                (float)$item['transfer_quantity'];



            if (
                $transfer_qty <= 0 ||
                $transfer_qty > $available
            ) {

                $this->db->trans_rollback();

                return false;
            }


            $remaining =
                $available - $transfer_qty;


            $item_data = array(

                'stock_transfer_id' =>
                    $stock_transfer_id,

                'job_completion_item_id' =>
                    $item['job_completion_item_id'],

                'job_order_item_id' =>
                    $jci['job_order_item_id'],

                'project_item_id' =>
                    $jci['project_item_id'],

                'item_master_id' =>
                    $jci['item_master_id'],

                'item_code' =>
                    $jci['item_code'],

                'item_description' =>
                    $jci['item_description'],

                'completed_quantity' =>
                    $jci['completed_quantity'],

                'previously_transferred' =>
                    $previously_transferred,

                'transfer_quantity' =>
                    $transfer_qty,

                'remaining_quantity' =>
                    $remaining,

                'unit' =>
                    $jci['unit']
            );


            $this->db->insert(
                'stock_transfer_items',
                $item_data
            );
        }


        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            return false;
        }


        $this->db->trans_commit();

        return true;
    }
    */

    
public function save_stock_transfer($header, $items)
{
    $this->db->trans_begin();
    if (empty($header['job_completion_id'])) {

        $this->db->trans_rollback();

        return false;
    }

    if (empty($items) || !is_array($items)) {

        $this->db->trans_rollback();

        return false;
    }
    $job_completion_id = (int) $header['job_completion_id'];
    $completion = $this->db
        ->select('
            jc.job_completion_id,
            jc.job_order_id,
            jo.fk_project_id
        ')
        ->from('job_completion jc')
        ->join(
            'job_order jo',
            'jo.job_order_id = jc.job_order_id',
            'inner'
        )
        ->where(
            'jc.job_completion_id',
            $job_completion_id
        )
        ->get()
        ->row_array();


    if (!$completion) {

        $this->db->trans_rollback();

        return false;
    }
    $job_order_id = (int) $completion['job_order_id'];
    $project_id   = (int) $completion['fk_project_id'];
    $project = $this->db
        ->select('so_id')
        ->from('project_master')
        ->where(
            'project_id',
            $project_id
        )
        ->get()
        ->row_array();


    $so_id = !empty($project)
        ? $project['so_id']
        : null;
    $stock_transfer_data = array(

        'stock_transfer_no' =>
            $this->generate_stock_transfer_no(),

        'ref_number' =>
            isset($header['ref_number'])
                ? trim($header['ref_number'])
                : null,

        'ref_date' =>
            !empty($header['ref_date'])
                ? $header['ref_date']
                : date('Y-m-d H:i:s'),

        'so_id' =>
            $so_id,

        'project_id' =>
            $project_id,

        'job_order_id' =>
            $job_order_id,

        'job_completion_id' =>
            $job_completion_id,

        'status' =>
            'Pending',
        'from_branch_id'  => $header['from_branch_id'],
        'from_warehouse_id' => $header['from_warehouse_id'],
        'from_store_id' => $header['from_store_id'],
        'to_branch_id'  => $header['to_branch_id'],
        'to_warehouse_id' => $header['to_warehouse_id'],
        'to_store_id' => $header['to_store_id'],
        'remarks' => $header['remarks']
    );

    $this->db->insert(
        'stock_transfers',
        $stock_transfer_data
    );


    $stock_transfer_id =
        $this->db->insert_id();


    if (!$stock_transfer_id) {

        $this->db->trans_rollback();

        return false;
    }

    foreach ($items as $item) {

        if (
            empty($item['job_completion_item_id']) ||
            !isset($item['transfer_quantity'])
        ) {

            $this->db->trans_rollback();

            return false;
        }


        $job_completion_item_id =  (int) $item['job_completion_item_id'];
        $transfer_qty =   (float) $item['transfer_quantity'];
        $jci = $this->db
            ->select('
                jci.job_completion_item_id,
                jci.job_completion_id,
                jci.job_order_item_id,
                jci.project_item_id,
                jci.completed_quantity,

                joi.item_master_id,
                joi.item_code,
                joi.item_description,
                joi.unit
            ')
            ->from('job_completion_items jci')
            ->join(
                'job_order_items joi',
                'joi.job_order_item_id = jci.job_order_item_id',
                'inner'
            )
            ->where(
                'jci.job_completion_item_id',
                $job_completion_item_id
            )
            ->where(
                'jci.job_completion_id',
                $job_completion_id
            )
            ->get()->row_array();

        if (!$jci) {

            $this->db->trans_rollback();

            return false;
        }
        $previous = $this->db
            ->select_sum('transfer_quantity')
            ->from('pstock_transfer_items')
            ->where(
                'job_completion_item_id',
                $job_completion_item_id
            )
            ->get()
            ->row_array();


        $previously_transferred =
            !empty($previous['transfer_quantity'])
                ? (float) $previous['transfer_quantity']
                : 0;
        $completed_quantity =
            (float) $jci['completed_quantity'];

        $available_quantity = $completed_quantity -
            $previously_transferred;
        if ($available_quantity < 0) {

            $available_quantity = 0;
        }
        if ($transfer_qty <= 0) {

            $this->db->trans_rollback();

            return false;
        }

        if ($transfer_qty > $available_quantity) {

            $this->db->trans_rollback();

            return false;
        }
        $remaining_quantity =  $available_quantity - $transfer_qty;
        $item_data = array(

            'stock_transfer_id' =>
                $stock_transfer_id,

            'job_completion_item_id' =>
                $job_completion_item_id,

            'job_order_item_id' =>
                $jci['job_order_item_id'],

            'project_item_id' =>
                $jci['project_item_id'],

            'item_master_id' =>
                $jci['item_master_id'],

            'item_code' =>
                $jci['item_code'],

            'item_description' =>
                $jci['item_description'],

            'completed_quantity' =>
                $completed_quantity,

            'previously_transferred' =>
                $previously_transferred,

            'transfer_quantity' =>
                $transfer_qty,

            'remaining_quantity' =>
                $remaining_quantity,

            'unit' =>
                $jci['unit']
        );
        $this->db->insert(
            'pstock_transfer_items',
            $item_data
        );


        if ($this->db->affected_rows() <= 0) {

            $this->db->trans_rollback();

            return false;
        }
    }
    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return false;
    }
    $this->db->trans_commit();
    $this->update_stock_transfer_status($stock_transfer_id);
    return $stock_transfer_id;
}
    /* =========================================================
     * UPDATE STOCK TRANSFER
     * ========================================================= */

    public function update_stock_transfer(
        $stock_transfer_id,
        $header,
        $items
    ) {

        $this->db->trans_begin();
        $existing =
            $this->get_stock_transfer(
                $stock_transfer_id
            );


        if (!$existing) {

            $this->db->trans_rollback();

            return false;
        }


        $this->db
            ->where(
                'stock_transfer_id',
                $stock_transfer_id
            )
            ->update(
                'stock_transfers',
                $header
            );

        $this->db
            ->where(
                'stock_transfer_id',
                $stock_transfer_id
            )
            ->delete(
                'pstock_transfer_items'
            );

        foreach ($items as $item) {

            $jci =
                $this->db
                     ->select('
                        jci.*,
                        joi.item_master_id,
                        joi.item_code,
                        joi.item_description,
                        joi.unit
                     ')
                     ->from(
                         'job_completion_items jci'
                     )
                     ->join(
                         'job_order_items joi',
                         'joi.job_order_item_id =
                          jci.job_order_item_id'
                     )
                     ->where(
                         'jci.job_completion_item_id',
                         $item['job_completion_item_id']
                     )
                     ->where(
                         'jci.job_completion_id',
                         $existing['job_completion_id']
                     )
                     ->get()
                     ->row_array();


            if (!$jci) {

                $this->db->trans_rollback();

                return false;
            }


            /* Previous transfers excluding this document */

            $sql = "
                SELECT
                    IFNULL(
                        SUM(sti.transfer_quantity),
                        0
                    ) AS qty

                FROM pstock_transfer_items sti

                INNER JOIN stock_transfers st
                    ON st.stock_transfer_id =
                       sti.stock_transfer_id

                WHERE
                    sti.job_completion_item_id = ?

                AND sti.stock_transfer_id != ?

                AND st.status != 'Cancelled'
            ";


            $previous =
                $this->db
                     ->query(
                         $sql,
                         array(
                             $item['job_completion_item_id'],
                             $stock_transfer_id
                         )
                     )
                     ->row_array();


            $previously_transferred =
                (float)$previous['qty'];


            $available =
                (float)$jci['completed_quantity']
                -
                $previously_transferred;


            $transfer_qty =
                (float)$item['transfer_quantity'];


            if (
                $transfer_qty <= 0 ||
                $transfer_qty > $available
            ) {

                $this->db->trans_rollback();

                return false;
            }


            $item_data = array(

                'stock_transfer_id' =>
                    $stock_transfer_id,

                'job_completion_item_id' =>
                    $item['job_completion_item_id'],

                'job_order_item_id' =>
                    $jci['job_order_item_id'],

                'project_item_id' =>
                    $jci['project_item_id'],

                'item_master_id' =>
                    $jci['item_master_id'],

                'item_code' =>
                    $jci['item_code'],

                'item_description' =>
                    $jci['item_description'],

                'completed_quantity' =>
                    $jci['completed_quantity'],

                'previously_transferred' =>
                    $previously_transferred,

                'transfer_quantity' =>
                    $transfer_qty,

                'remaining_quantity' =>
                    $available - $transfer_qty,

                'unit' =>
                    $jci['unit']
            );


            $this->db->insert(
                'pstock_transfer_items',
                $item_data
            );
        }


        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            return false;
        }


        $this->db->trans_commit();
        $this->update_stock_transfer_status(
            $stock_transfer_id
        );

        return true;
    }


    /* =========================================================
     * BRANCHES
     * ========================================================= */

    public function get_branches()
    {
        // ->where( 'status', 1 )
        return $this->db
           
            ->order_by(
                'branch_name',
                'ASC'
            )
            ->get('branch_master')
            ->result_array();
    }


    /* =========================================================
     * WAREHOUSES
     * ========================================================= */

    public function get_warehouses($branch_id)
    {
        return $this->db
            ->where(
                'branch_id',
                $branch_id
            )
            ->where(
                'status',
                1
            )
            ->order_by(
                'warehouse_name',
                'ASC'
            )
            ->get('warehouse_master')
            ->result_array();
    }


    /* =========================================================
     * STORES
     * ========================================================= */

    public function get_stores($warehouse_id)
    {
        return $this->db
            ->where(
                'warehouse_id',
                $warehouse_id
            )
            ->where(
                'status',
                1
            )
            ->order_by(
                'store_name',
                'ASC'
            )
            ->get('store_master')
            ->result_array();
    }

public function get_job_completion_for_transfer_fmt($job_completion_id)
{
   
    $header = $this->db
        ->select('
            jc.job_completion_id,
            jc.job_completion_no,
            jc.job_order_id,
            jc.completion_date,
            jc.remarks,

            jo.job_order_no,
            jo.fk_project_id AS project_id,
            jo.order_no,

            pm.project_name,
            pm.so_id
        ')
        ->from('job_completion jc')
        ->join(
            'job_order jo',
            'jo.job_order_id = jc.job_order_id',
            'left'
        )
        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )
        ->where(
            'jc.job_completion_id',
            $job_completion_id
        )
        ->get()
        ->row_array();


    if (empty($header)) {

        return [
            'header' => null,
            'items'  => []
        ];
    }


    $items = $this->db
        ->select('
            jci.job_completion_item_id,
            jci.job_completion_id,
            jci.job_order_item_id,
            jci.project_item_id,

            jci.ordered_quantity,
            jci.previously_completed,
            jci.completed_quantity,
            jci.remaining_quantity,

            joi.item_master_id,
            joi.item_code,
            joi.item_description,
            joi.quantity AS requested_quantity,

            im.product_code,
            im.product_name,
            im.unit_id,

            um.unit_abbr
        ')
        ->from('job_completion_items jci')

        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = jci.job_order_item_id',
            'left'
        )

        ->join(
            'item_master im',
            'im.product_id = joi.item_master_id',
            'left'
        )

        ->join(
            'unit_master um',
            'um.unit_id = im.unit_id',
            'left'
        )

        ->where(
            'jci.job_completion_id',
            $job_completion_id
        )

       
        ->where(
            'jci.ordered_quantity = jci.completed_quantity',
            null,
            false
        )

        ->order_by(
            'jci.job_completion_item_id',
            'ASC'
        )

        ->get()
        ->result_array();

    return [
        'header' => $header,
        'items'  => $items
    ];
}
public function get_stock_transfer_items_for_edit($stock_transfer_id)
{
    /*
     * =========================================================
     * 1. GET STOCK TRANSFER HEADER
     * =========================================================
     */

    $transfer = $this->db
        ->select('
            stock_transfer_id,
            job_completion_id,
            job_order_id
        ')
        ->where(
            'stock_transfer_id',
            $stock_transfer_id
        )
        ->get('stock_transfers')
        ->row_array();


    if (!$transfer) {
        return array();
    }


    $job_order_id = $transfer['job_order_id'];


    /*
     * =========================================================
     * 2. EXISTING ITEMS IN CURRENT STOCK TRANSFER
     * =========================================================
     *
     * These are already saved in stock_transfer_items.
     */

    $existing_items = $this->db
        ->select('
            sti.stock_transfer_item_id,
            sti.stock_transfer_id,

            sti.job_completion_item_id,
            sti.job_order_item_id,
            sti.project_item_id,
            sti.item_master_id,

            sti.item_code,
            sti.item_description,

            sti.completed_quantity,
            sti.transfer_quantity,
            sti.remaining_quantity,

            sti.unit,

            im.product_code AS master_product_code,
            im.product_name AS master_product_name,

            um.unit_name,
            um.unit_abbr
        ')

        ->from('pstock_transfer_items sti')

        ->join(
            'item_master im',
            'im.product_id = sti.item_master_id',
            'left'
        )

        ->join(
            'unit_master um',
            'um.unit_id = im.unit_id',
            'left'
        )

        ->where(
            'sti.stock_transfer_id',
            $stock_transfer_id
        )

        ->order_by(
            'sti.stock_transfer_item_id',
            'ASC'
        )

        ->get()
        ->result_array();


    /*
     * =========================================================
     * 3. FIND NEWLY COMPLETED ITEMS
     * =========================================================
     *
     * IMPORTANT:
     *
     * Search using JOB ORDER ID.
     *
     * This allows:
     *
     * JC-001 -> Product A
     * JC-002 -> Product B
     *
     * both to appear.
     */

    $sql = "

        SELECT

            jci.job_completion_item_id,

            jci.job_order_item_id,
            jci.project_item_id,

            jci.ordered_quantity,
            jci.previously_completed,
            jci.completed_quantity,
            jci.remaining_quantity,

            joi.item_master_id,
            joi.item_code,
            joi.item_description,
            joi.unit,

            im.product_code,
            im.product_name,

            um.unit_name,
            um.unit_abbr,

            IFNULL(
                (
                    SELECT
                        SUM(sti2.transfer_quantity)

                    FROM pstock_transfer_items sti2

                    INNER JOIN stock_transfers st2
                        ON st2.stock_transfer_id =
                           sti2.stock_transfer_id

                    WHERE
                        sti2.job_completion_item_id =
                        jci.job_completion_item_id

                    AND st2.status != 'Cancelled'

                    /*
                     * IMPORTANT:
                     *
                     * Do NOT count the current stock transfer
                     * while editing it.
                     */

                    AND st2.stock_transfer_id != ?

                ),
                0
            ) AS transferred_qty

        FROM job_completion_items jci

        INNER JOIN job_completion jc
            ON jc.job_completion_id =
               jci.job_completion_id

        INNER JOIN job_order_items joi
            ON joi.job_order_item_id =
               jci.job_order_item_id

        LEFT JOIN item_master im
            ON im.product_id =
               joi.item_master_id

        LEFT JOIN unit_master um
            ON um.unit_id =
               im.unit_id

        WHERE

            jc.job_order_id = ?

        /*
         * Don't add an item again if it already
         * exists in the current stock transfer.
         */

        AND NOT EXISTS (

            SELECT 1

            FROM pstock_transfer_items current_sti

            WHERE
                current_sti.stock_transfer_id = ?

            AND current_sti.job_completion_item_id =
                jci.job_completion_item_id
        )

        HAVING

            (
                completed_quantity -
                transferred_qty
            ) > 0

        ORDER BY
            jci.job_completion_item_id ASC
    ";


    $new_items = $this->db
        ->query(
            $sql,
            array(
                $stock_transfer_id,
                $job_order_id,
                $stock_transfer_id
            )
        )
        ->result_array();


    /*
     * =========================================================
     * 4. PREPARE NEW ITEMS
     * =========================================================
     */

    foreach ($new_items as &$item) {

        /*
         * Previous transfer is calculated dynamically.
         *
         * We are NOT using:
         *
         * stock_transfer_items.previously_transferred
         */

        $transferred_qty =
            (float)$item['transferred_qty'];


        $completed_qty =
            (float)$item['completed_quantity'];


        /*
         * Remaining quantity available for transfer
         */

        $remaining_qty =
            max(
                0,
                $completed_qty -
                $transferred_qty
            );


        $item['transfer_quantity'] = 0;

        $item['remaining_quantity'] =
            $remaining_qty;

        $item['is_new_item'] = 1;
    }

    unset($item);


    /*
     * =========================================================
     * 5. MARK EXISTING ITEMS
     * =========================================================
     */

    foreach ($existing_items as &$item) {

        $item['is_new_item'] = 0;

    }

    unset($item);


    /*
     * =========================================================
     * 6. COMBINE EXISTING + NEW
     * =========================================================
     */

    return array_merge(
        $existing_items,
        $new_items
    );
}

/*REPORTS*/
 /* ============================================================
 * REPORT PROJECTS
 * ============================================================ */
public function get_report_projects()
{
    return $this->db
        ->select('project_id, project_name')
        ->from('project_master')
        ->order_by('project_name', 'ASC')
        ->get()
        ->result_array();
}


/* ============================================================
 * REPORT JOB ORDERS
 * ============================================================ */
public function get_report_job_orders()
{
    return $this->db
        ->select('
            jo.job_order_id,
            jo.job_order_no,
            jo.fk_project_id,
            pm.project_name
        ')
        ->from('job_order jo')
        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )
        ->where('jo.is_deleted', 0)
        ->order_by('jo.job_order_id', 'DESC')
        ->get()
        ->result_array();
}


/* ============================================================
 * PRODUCTION SUMMARY REPORT
 * ============================================================ */
public function get_production_summary_report(
    $from_date = null,
    $to_date = null,
    $project_id = null,
    $job_order_id = null,
    $status = null
) {
    /*
     * First calculate completion quantity per job order item.
     * This prevents duplicate quantities when an item has
     * multiple job completion records.
     */
    $completion_subquery = "
        SELECT
            job_order_item_id,
            SUM(completed_quantity) AS completed_quantity
        FROM job_completion_items
        GROUP BY job_order_item_id
    ";

    $this->db->select("
        jo.job_order_id,
        jo.job_order_no,
        DATE_FORMAT(
            jo.order_date,
            '%m-%d-%Y'
        ) AS order_date,
        DATE_FORMAT(
            jo.start_date,
            '%m-%d-%Y'
        ) AS start_date,
        DATE_FORMAT(
            jo.finish_date,
            '%m-%d-%Y'
        ) AS finish_date,
        jo.status,
        pm.project_name,
        COUNT(DISTINCT joi.job_order_item_id) AS total_items,
        COALESCE(
            SUM(joi.quantity),
            0
        ) AS ordered_quantity,
        COALESCE(
            SUM(
                COALESCE(jci.completed_quantity, 0)
            ),
            0
        ) AS completed_quantity,

        (
            COALESCE(SUM(joi.quantity), 0)
            -
            COALESCE(
                SUM(
                    COALESCE(jci.completed_quantity, 0)
                ),
                0
            )
        ) AS remaining_quantity
    ");

    $this->db->from('job_order jo');

    $this->db->join(
        'project_master pm',
        'pm.project_id = jo.fk_project_id',
        'left'
    );

    $this->db->join(
        'job_order_items joi',
        'joi.job_order_id = jo.job_order_id',
        'left'
    );

    $this->db->join(
        "($completion_subquery) jci",
        'jci.job_order_item_id = joi.job_order_item_id',
        'left',
        false
    );

    $this->db->where('jo.is_deleted', 0);

    if (!empty($from_date)) {
        $this->db->where(
            'DATE(jo.order_date) >=',
            $from_date
        );
    }

    if (!empty($to_date)) {
        $this->db->where(
            'DATE(jo.order_date) <=',
            $to_date
        );
    }

    if (!empty($project_id)) {
        $this->db->where(
            'jo.fk_project_id',
            $project_id
        );
    }

    if (!empty($job_order_id)) {
        $this->db->where(
            'jo.job_order_id',
            $job_order_id
        );
    }

    if (!empty($status)) {
        $this->db->where(
            'jo.status',
            $status
        );
    }

    $this->db->group_by('jo.job_order_id');

    $this->db->order_by(
        'jo.order_date',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}


/* ============================================================
 * JOB ORDER REPORT
 * ============================================================ */
public function get_job_order_report(
    $from_date = null,
    $to_date = null,
    $project_id = null,
    $job_order_id = null,
    $status = null
) {
    $completion_subquery = "
        SELECT
            job_order_item_id,
            SUM(completed_quantity) AS completed_quantity
        FROM job_completion_items
        GROUP BY job_order_item_id
    ";

    $this->db->select("
        jo.job_order_id,
        jo.job_order_no,
         DATE_FORMAT(
            jo.order_date,
            '%m-%d-%Y'
        ) AS order_date,
        DATE_FORMAT(
            jo.start_date,
            '%m-%d-%Y'
        ) AS start_date,
        DATE_FORMAT(
            jo.finish_date,
            '%m-%d-%Y'
        ) AS finish_date,
        jo.status,
        pm.project_name,
        joi.job_order_item_id,
        joi.item_master_id,
        joi.item_code,
        joi.item_description,
        joi.quantity AS ordered_quantity,
        joi.unit,

        im.product_name,

        COALESCE(
            jci.completed_quantity,
            0
        ) AS completed_quantity,

        (
            joi.quantity -
            COALESCE(
                jci.completed_quantity,
                0
            )
        ) AS remaining_quantity
    ");

    $this->db->from('job_order jo');

    $this->db->join(
        'project_master pm',
        'pm.project_id = jo.fk_project_id',
        'left'
    );

    $this->db->join(
        'job_order_items joi',
        'joi.job_order_id = jo.job_order_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = joi.item_master_id',
        'left'
    );

    $this->db->join(
        "($completion_subquery) jci",
        'jci.job_order_item_id = joi.job_order_item_id',
        'left',
        false
    );

    $this->db->where('jo.is_deleted', 0);

    if (!empty($from_date)) {
        $this->db->where(
            'DATE(jo.order_date) >=',
            $from_date
        );
    }

    if (!empty($to_date)) {
        $this->db->where(
            'DATE(jo.order_date) <=',
            $to_date
        );
    }

    if (!empty($project_id)) {
        $this->db->where(
            'jo.fk_project_id',
            $project_id
        );
    }

    if (!empty($job_order_id)) {
        $this->db->where(
            'jo.job_order_id',
            $job_order_id
        );
    }

    if (!empty($status)) {
        $this->db->where(
            'jo.status',
            $status
        );
    }

    $this->db->order_by(
        'jo.order_date',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}


/* ============================================================
 * JOB COMPLETION REPORT
 * ============================================================ */
public function get_job_completion_report(
    $from_date = null,
    $to_date = null,
    $project_id = null,
    $job_order_id = null
) {
    $this->db->select("
        jc.job_completion_id,
        jc.job_completion_no,
        DATE_FORMAT(
            jc.completion_date,
            '%m-%d-%Y'
        ) AS completion_date,
        jc.remarks,
        jo.job_order_id,
        jo.job_order_no,
        DATE_FORMAT(
            jo.order_date,
            '%m-%d-%Y'
        ) AS order_date,
        pm.project_name,
        jci.job_completion_item_id,
        jci.job_order_item_id,
        joi.item_master_id,
        joi.item_code,
        joi.item_description,
        joi.unit,
        im.product_name,
        jci.ordered_quantity,
        jci.previously_completed,
        jci.completed_quantity,
        jci.remaining_quantity,
         DATE_FORMAT(
            jci.created_at,
            '%m-%d-%Y'
        ) AS created_at
    ");

    $this->db->from('job_completion jc');

    $this->db->join(
        'job_completion_items jci',
        'jci.job_completion_id = jc.job_completion_id',
        'left'
    );

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = jc.job_order_id',
        'left'
    );

    $this->db->join(
        'job_order_items joi',
        'joi.job_order_item_id = jci.job_order_item_id',
        'left'
    );

    $this->db->join(
        'project_master pm',
        'pm.project_id = jo.fk_project_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = joi.item_master_id',
        'left'
    );

    if (!empty($from_date)) {
        $this->db->where(
            'DATE(jc.completion_date) >=',
            $from_date
        );
    }

    if (!empty($to_date)) {
        $this->db->where(
            'DATE(jc.completion_date) <=',
            $to_date
        );
    }

    if (!empty($project_id)) {
        $this->db->where(
            'jo.fk_project_id',
            $project_id
        );
    }

    if (!empty($job_order_id)) {
        $this->db->where(
            'jc.job_order_id',
            $job_order_id
        );
    }

    $this->db->order_by(
        'jc.completion_date',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}


public function get_material_request_report(
    $from_date = null,
    $to_date = null,
    $job_order_id = null,
    $status = null
) {
    $this->db->select("
        pmr.production_material_request_id,
        pmr.material_request_no,
        DATE_FORMAT(
                        pmr.request_date,
                        '%m-%d-%Y'
                    ) AS request_date,
        pmr.status,
        pmr.remarks,

        jo.job_order_id,
        jo.job_order_no,
        pmri.production_material_request_item_id,
        pmri.job_order_item_id,
        pmri.job_order_material_id,
        pmri.material_id,
        pmri.material_code,
        pmri.material_name,
        pmri.required_quantity,
        pmri.request_quantity,
        pmri.unit,
        pmri.unit_cost,
        pmri.total_cost
    ");

    $this->db->from('production_material_requests pmr');

    $this->db->join(
        'production_material_request_items pmri',
        'pmri.production_material_request_id =
         pmr.production_material_request_id',
        'left'
    );

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pmr.job_order_id',
        'left'
    );

    /*
     * Only non-deleted job orders
     */
    $this->db->where('jo.is_deleted', 0);

    /*
     * Date filter
     */
    if (!empty($from_date)) {
        $this->db->where(
            'DATE(pmr.request_date) >=',
            $from_date
        );
    }

    if (!empty($to_date)) {
        $this->db->where(
            'DATE(pmr.request_date) <=',
            $to_date
        );
    }

    /*
     * Job Order filter
     */
    if (!empty($job_order_id)) {
        $this->db->where(
            'pmr.job_order_id',
            $job_order_id
        );
    }

    /*
     * Material Request status
     */
    if (!empty($status)) {
        $this->db->where(
            'pmr.status',
            $status
        );
    }

    $this->db->order_by(
        'pmr.request_date',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}


public function get_stock_transfer_report(
    $from_date = null,
    $to_date = null,
    $project_id = null,
    $job_order_id = null,
    $status = null
) {
    $this->db->select("
        st.stock_transfer_id,
        st.stock_transfer_no,
        st.ref_number,
        DATE_FORMAT(
            st.ref_date,
            '%m-%d-%Y'
        ) AS ref_date,
        st.project_id,
        st.job_completion_id,
        st.job_order_id,

        st.from_branch_id,
        st.from_warehouse_id,
        st.from_store_id,

        st.to_branch_id,
        st.to_warehouse_id,
        st.to_store_id,

        st.status,
        st.remarks,
         DATE_FORMAT(
            st.created_at,
            '%m-%d-%Y'
        ) AS created_at,
        jo.job_order_no,
        pm.project_name,
        jc.job_completion_no,

        sti.stock_transfer_item_id,
        sti.job_completion_item_id,
        sti.job_order_item_id,

        sti.item_master_id,
        sti.item_code,
        sti.item_description,
        im.product_name,
        sti.completed_quantity,
        sti.previously_transferred,
        sti.transfer_quantity,
        sti.remaining_quantity,
        sti.unit
    ");

    $this->db->from(
        'stock_transfers st'
    );

    $this->db->join(
        'pstock_transfer_items sti',
        'sti.stock_transfer_id =
         st.stock_transfer_id',
        'left'
    );

    $this->db->join(
        'job_order jo',
        'jo.job_order_id =
         st.job_order_id',
        'left'
    );

    $this->db->join(
        'job_completion jc',
        'jc.job_completion_id =
         st.job_completion_id',
        'left'
    );

    $this->db->join(
        'project_master pm',
        'pm.project_id =
         st.project_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id =
         sti.item_master_id',
        'left'
    );

    if (!empty($from_date)) {
        $this->db->where(
            'DATE(st.ref_date) >=',
            $from_date
        );
    }

    if (!empty($to_date)) {
        $this->db->where(
            'DATE(st.ref_date) <=',
            $to_date
        );
    }

    if (!empty($project_id)) {
        $this->db->where(
            'st.project_id',
            $project_id
        );
    }

    if (!empty($job_order_id)) {
        $this->db->where(
            'st.job_order_id',
            $job_order_id
        );
    }

    if (!empty($status)) {
        $this->db->where(
            'st.status',
            $status
        );
    }

    $this->db->order_by(
        'st.ref_date',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}

//PRODUCTION DASHBOARD FUNCTIONS
  public function get_production_projects()
    {
        return $this->db
            ->select('
                pm.project_id,
                pm.project_name
            ')
            ->from('project_master pm')
            ->order_by('pm.project_name', 'ASC')
            ->get()
            ->result_array();
    }


    /* ============================================================
     * COMMON JOB ORDER QUANTITY QUERY
     *
     * Completion is calculated from ALL
     * job_completion_items.completed_quantity.
     *
     * previously_completed is intentionally NOT used.
     * ============================================================ */

    private function job_order_quantity_query($filters = array())
    {
        $this->db->select('
            jo.job_order_id,
            jo.job_order_no,
            jo.fk_project_id,
            jo.order_date,
            jo.status,
            pm.project_name,

            COALESCE(
                SUM(ji.quantity),
                0
            ) AS ordered_quantity,

            COALESCE(
                (
                    SELECT SUM(jci.completed_quantity)
                    FROM job_completion_items jci
                    INNER JOIN job_completion jc
                        ON jc.job_completion_id =
                           jci.job_completion_id
                    WHERE jc.job_order_id =
                          jo.job_order_id
                ),
                0
            ) AS completed_quantity
        ', false);

        $this->db->from('job_order jo');

        $this->db->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        );

        $this->db->join(
            'job_order_items ji',
            'ji.job_order_id = jo.job_order_id',
            'left'
        );

        $this->db->where(
            'jo.is_deleted',
            0
        );

        if (!empty($filters['from_date'])) {

            $this->db->where(
                'DATE(jo.order_date) >=',
                $filters['from_date']
            );
        }

        if (!empty($filters['to_date'])) {

            $this->db->where(
                'DATE(jo.order_date) <=',
                $filters['to_date']
            );
        }

        if (!empty($filters['project_id'])) {

            $this->db->where(
                'jo.fk_project_id',
                $filters['project_id']
            );
        }

        $this->db->group_by(
            'jo.job_order_id'
        );
    }


    /* ============================================================
     * DASHBOARD SUMMARY
     * ============================================================ */

    public function get_production_dashboard_summary(
        $filters = array()
    ) {

        $this->job_order_quantity_query(
            $filters
        );

        $rows =
            $this->db
                ->get()
                ->result_array();

        $summary = array(
            'job_orders'          => 0,
            'pending'             => 0,
            'in_progress'         => 0,
            'production_completed'=> 0,
            'ordered_quantity'    => 0,
            'completed_quantity'  => 0,
            'remaining_quantity'  => 0,
            'completion_percent'  => 0
        );

        foreach ($rows as $row) {

            $ordered =
                (float)$row['ordered_quantity'];

            $completed =
                (float)$row['completed_quantity'];

            $remaining =
                $ordered - $completed;

            if ($remaining < 0) {
                $remaining = 0;
            }

            $summary['job_orders']++;

            switch ($row['status']) {

                case 'Pending':
                    $summary['pending']++;
                    break;

                case 'In Progress':
                    $summary['in_progress']++;
                    break;

                case 'Production Completed':
                    $summary['production_completed']++;
                    break;
            }

            $summary['ordered_quantity'] +=
                $ordered;

            $summary['completed_quantity'] +=
                $completed;

            $summary['remaining_quantity'] +=
                $remaining;
        }

        if (
            $summary['ordered_quantity'] > 0
        ) {

            $summary['completion_percent'] =
                (
                    $summary['completed_quantity']
                    /
                    $summary['ordered_quantity']
                ) * 100;
        }

        return $summary;
    }


    /* ============================================================
     * JOB ORDER STATUS
     * ============================================================ */

    public function get_job_order_status_chart(
        $filters = array()
    ) {

        $this->job_order_quantity_query(
            $filters
        );

        $rows =
            $this->db
                ->get()
                ->result_array();

        $result = array();

        foreach ($rows as $row) {

            $status =
                !empty($row['status'])
                    ? $row['status']
                    : 'Pending';

            if (!isset($result[$status])) {

                $result[$status] = 0;
            }

            $result[$status]++;
        }

        $output = array();

        foreach ($result as $status => $count) {

            $output[] = array(
                'status' => $status,
                'count'  => $count
            );
        }

        return $output;
    }


    /* ============================================================
     * PRODUCTION QUANTITY
     * ============================================================ */

    public function get_production_quantity_chart(
        $filters = array()
    ) {

        $this->job_order_quantity_query(
            $filters
        );

        $rows =
            $this->db
                ->get()
                ->result_array();

        $ordered = 0;
        $completed = 0;
        $remaining = 0;

        foreach ($rows as $row) {

            $o =
                (float)$row['ordered_quantity'];

            $c =
                (float)$row['completed_quantity'];

            $r = $o - $c;

            if ($r < 0) {
                $r = 0;
            }

            $ordered += $o;
            $completed += $c;
            $remaining += $r;
        }

        return array(
            array(
                'label' => 'Ordered',
                'quantity' => $ordered
            ),
            array(
                'label' => 'Completed',
                'quantity' => $completed
            ),
            array(
                'label' => 'Remaining',
                'quantity' => $remaining
            )
        );
    }


    /* ============================================================
     * MONTHLY PRODUCTION
     * ============================================================ */

    public function get_monthly_production_chart(
        $filters = array()
    ) {

        $this->db->select('
            DATE_FORMAT(
                jc.completion_date,
                "%Y-%m"
            ) AS month,

            DATE_FORMAT(
                jc.completion_date,
                "%b %Y"
            ) AS month_label,

            SUM(
                jci.completed_quantity
            ) AS completed_quantity
        ', false);

        $this->db->from(
            'job_completion jc'
        );

        $this->db->join(
            'job_completion_items jci',
            'jci.job_completion_id =
             jc.job_completion_id',
            'inner'
        );

        $this->db->join(
            'job_order jo',
            'jo.job_order_id =
             jc.job_order_id',
            'inner'
        );

        $this->db->where(
            'jo.is_deleted',
            0
        );

        if (!empty($filters['from_date'])) {

            $this->db->where(
                'DATE(jc.completion_date) >=',
                $filters['from_date']
            );
        }

        if (!empty($filters['to_date'])) {

            $this->db->where(
                'DATE(jc.completion_date) <=',
                $filters['to_date']
            );
        }

        if (!empty($filters['project_id'])) {

            $this->db->where(
                'jo.fk_project_id',
                $filters['project_id']
            );
        }

        $this->db->group_by(
            'DATE_FORMAT(jc.completion_date,"%Y-%m")',
            false
        );

        $this->db->order_by(
            'month',
            'ASC'
        );

        return $this->db
            ->get()
            ->result_array();
    }


    /* ============================================================
     * MATERIAL REQUEST STATUS
     * ============================================================ */

    public function get_material_request_chart(
        $filters = array()
    ) {

        $this->db->select('
            pmr.status,
            COUNT(
                DISTINCT
                pmr.production_material_request_id
            ) AS total
        ');

        $this->db->from(
            'production_material_requests pmr'
        );

        $this->db->join(
            'job_order jo',
            'jo.job_order_id =
             pmr.job_order_id',
            'left'
        );

        $this->db->where(
            'jo.is_deleted',
            0
        );

        if (!empty($filters['from_date'])) {

            $this->db->where(
                'DATE(pmr.request_date) >=',
                $filters['from_date']
            );
        }

        if (!empty($filters['to_date'])) {

            $this->db->where(
                'DATE(pmr.request_date) <=',
                $filters['to_date']
            );
        }

        if (!empty($filters['project_id'])) {

            $this->db->where(
                'jo.fk_project_id',
                $filters['project_id']
            );
        }

        $this->db->group_by(
            'pmr.status'
        );

        return $this->db
            ->get()
            ->result_array();
    }


    /* ============================================================
     * STOCK TRANSFER STATUS
     * ============================================================ */

    public function get_stock_transfer_chart($from_date = '', $to_date = '', $project_id = '')
{
    $this->db
        ->select("
            status,
            COUNT(stock_transfer_id) AS total
        ")
        ->from('stock_transfers')
        ->where('1 = 1', null, false);

    /*
     * ---------------------------------------------------------
     * DATE FILTER
     * ---------------------------------------------------------
     * Use stock_transfers.ref_date
     */
    if (!empty($from_date)) {

        $this->db->where(
            'DATE(ref_date) >=',
            $from_date
        );
    }

    if (!empty($to_date)) {

        $this->db->where(
            'DATE(ref_date) <=',
            $to_date
        );
    }


    /*
     * ---------------------------------------------------------
     * PROJECT FILTER
     * ---------------------------------------------------------
     */
    if (!empty($project_id)) {

        $this->db->where(
            'project_id',
            $project_id
        );
    }


    /*
     * ---------------------------------------------------------
     * GROUP BY TRANSFER STATUS
     * ---------------------------------------------------------
     */
    $this->db
        ->group_by('status')
        ->order_by('status', 'ASC');


    return $this->db
        ->get()
        ->result();
}


    /* ============================================================
     * TOP PRODUCTS
     * ============================================================ */

    public function get_top_production_products(
        $filters = array()
    ) {

        $this->db->select('
            jci.job_order_item_id,

            COALESCE(
                im.product_name,
                joi.item_description
            ) AS product_name,

            COALESCE(
                im.product_code,
                joi.item_code
            ) AS product_code,

            joi.unit,

            SUM(
                jci.completed_quantity
            ) AS completed_quantity
        ', false);

        $this->db->from(
            'job_completion_items jci'
        );

        $this->db->join(
            'job_completion jc',
            'jc.job_completion_id =
             jci.job_completion_id',
            'inner'
        );

        $this->db->join(
            'job_order jo',
            'jo.job_order_id =
             jc.job_order_id',
            'inner'
        );

        $this->db->join(
            'job_order_items joi',
            'joi.job_order_item_id =
             jci.job_order_item_id',
            'left'
        );

        $this->db->join(
            'item_master im',
            'im.product_id =
             joi.item_master_id',
            'left'
        );

        $this->db->where(
            'jo.is_deleted',
            0
        );

        if (!empty($filters['from_date'])) {

            $this->db->where(
                'DATE(jc.completion_date) >=',
                $filters['from_date']
            );
        }

        if (!empty($filters['to_date'])) {

            $this->db->where(
                'DATE(jc.completion_date) <=',
                $filters['to_date']
            );
        }

        if (!empty($filters['project_id'])) {

            $this->db->where(
                'jo.fk_project_id',
                $filters['project_id']
            );
        }

        $this->db->group_by(
            'jci.job_order_item_id'
        );

        $this->db->order_by(
            'completed_quantity',
            'DESC'
        );

        $this->db->limit(10);

        return $this->db
            ->get()
            ->result_array();
    }


    /* ============================================================
     * DRILL DOWN
     * ============================================================ */

    public function get_production_drilldown(
        $type,
        $value,
        $filters = array()
    ) {

        /*
         * --------------------------------------------------------
         * JOB ORDER STATUS
         * --------------------------------------------------------
         */

        if ($type == 'job_status') {

            $this->job_order_quantity_query(
                $filters
            );

            if ($value != '') {

                $this->db->having(
                    'status',
                    $value
                );
            }

            return $this->db
                ->get()
                ->result_array();
        }


        /*
         * --------------------------------------------------------
         * PRODUCTION QUANTITY
         * --------------------------------------------------------
         */

        if ($type == 'production_quantity') {

            $this->job_order_quantity_query(
                $filters
            );

            $rows =
                $this->db
                    ->get()
                    ->result_array();

            $result = array();

            foreach ($rows as $row) {

                $ordered =
                    (float)$row['ordered_quantity'];

                $completed =
                    (float)$row['completed_quantity'];

                $remaining =
                    max(
                        0,
                        $ordered - $completed
                    );

                $show = false;

                if ($value == 'Ordered') {
                    $show = true;
                }

                if (
                    $value == 'Completed' &&
                    $completed > 0
                ) {
                    $show = true;
                }

                if (
                    $value == 'Remaining' &&
                    $remaining > 0
                ) {
                    $show = true;
                }

                if ($show) {

                    $row['remaining_quantity'] =
                        $remaining;

                    $result[] = $row;
                }
            }

            return $result;
        }


        /*
         * --------------------------------------------------------
         * MATERIAL REQUEST
         * --------------------------------------------------------
         */

        if ($type == 'material_status') {

            $this->db->select("
                pmr.material_request_no,
                DATE_FORMAT(
                    pmr.request_date,
                    '%m-%d-%Y'
                ) AS request_date,
                pmr.status,
                jo.job_order_no,
                pm.project_name
            ");

            $this->db->from(
                'production_material_requests pmr'
            );

            $this->db->join(
                'job_order jo',
                'jo.job_order_id =
                 pmr.job_order_id',
                'left'
            );

            $this->db->join(
                'project_master pm',
                'pm.project_id =
                 jo.fk_project_id',
                'left'
            );

            $this->db->where(
                'pmr.status',
                $value
            );

            $this->db->where(
                'jo.is_deleted',
                0
            );

            if (!empty($filters['from_date'])) {

                $this->db->where(
                    'DATE(pmr.request_date) >=',
                    $filters['from_date']
                );
            }

            if (!empty($filters['to_date'])) {

                $this->db->where(
                    'DATE(pmr.request_date) <=',
                    $filters['to_date']
                );
            }

            if (!empty($filters['project_id'])) {

                $this->db->where(
                    'jo.fk_project_id',
                    $filters['project_id']
                );
            }

            return $this->db
                ->order_by(
                    'pmr.request_date',
                    'DESC'
                )
                ->get()
                ->result_array();
        }


        /*
         * --------------------------------------------------------
         * STOCK TRANSFER
         * --------------------------------------------------------
         */

        if ($type == 'transfer_status') {

            $this->db->select('
                st.stock_transfer_no,
                st.ref_number,
                st.ref_date,
                st.status,
                jo.job_order_no,
                pm.project_name
            ');

            $this->db->from(
                'stock_transfers st'
            );

            $this->db->join(
                'job_order jo',
                'jo.job_order_id =
                 st.job_order_id',
                'left'
            );

            $this->db->join(
                'project_master pm',
                'pm.project_id =
                 jo.fk_project_id',
                'left'
            );

            $this->db->where(
                'st.status',
                $value
            );

            $this->db->where(
                'jo.is_deleted',
                0
            );

            if (!empty($filters['from_date'])) {

                $this->db->where(
                    'DATE(st.ref_date) >=',
                    $filters['from_date']
                );
            }

            if (!empty($filters['to_date'])) {

                $this->db->where(
                    'DATE(st.ref_date) <=',
                    $filters['to_date']
                );
            }

            if (!empty($filters['project_id'])) {

                $this->db->where(
                    'jo.fk_project_id',
                    $filters['project_id']
                );
            }

            return $this->db
                ->order_by(
                    'st.ref_date',
                    'DESC'
                )
                ->get()
                ->result_array();
        }


        /*
         * --------------------------------------------------------
         * MONTHLY PRODUCTION
         * --------------------------------------------------------
         */

        if ($type == 'production_month') {

            $this->db->select('
                jc.job_completion_no,
                jc.completion_date,
                jo.job_order_no,
                pm.project_name,

                COALESCE(
                    im.product_name,
                    joi.item_description
                ) AS product_name,

                jci.completed_quantity,
                joi.unit
            ', false);

            $this->db->from(
                'job_completion_items jci'
            );

            $this->db->join(
                'job_completion jc',
                'jc.job_completion_id =
                 jci.job_completion_id',
                'inner'
            );

            $this->db->join(
                'job_order jo',
                'jo.job_order_id =
                 jc.job_order_id',
                'inner'
            );

            $this->db->join(
                'project_master pm',
                'pm.project_id =
                 jo.fk_project_id',
                'left'
            );

            $this->db->join(
                'job_order_items joi',
                'joi.job_order_item_id =
                 jci.job_order_item_id',
                'left'
            );

            $this->db->join(
                'item_master im',
                'im.product_id =
                 joi.item_master_id',
                'left'
            );

            /*
             * value = YYYY-MM
             */
            $this->db->where(
                'DATE_FORMAT(
                    jc.completion_date,
                    "%Y-%m"
                ) =',
                $value
            );
            
            $this->db->where(
                'jo.is_deleted',
                0
            );

            if (!empty($filters['from_date'])) {

                $this->db->where(
                    'DATE(jc.completion_date) >=',
                    $filters['from_date']
                );
            }

            if (!empty($filters['to_date'])) {

                $this->db->where(
                    'DATE(jc.completion_date) <=',
                    $filters['to_date']
                );
            }

            if (!empty($filters['project_id'])) {

                $this->db->where(
                    'jo.fk_project_id',
                    $filters['project_id']
                );
            }

            return $this->db
                ->order_by(
                    'jc.completion_date',
                    'DESC'
                )
                ->get()
                ->result_array();
        }

        return array();
    }

public function update_stock_transfer_status($stock_transfer_id)
{
    
    $items = $this->db
        ->select('
            sti.stock_transfer_item_id,
            sti.job_completion_item_id,
            sti.completed_quantity,
            sti.transfer_quantity
        ')
        ->from('pstock_transfer_items sti')
        ->where(
            'sti.stock_transfer_id',
            $stock_transfer_id
        )
        ->get()
        ->result_array();

    if (empty($items)) {

        $status = 'Pending';

    } else {

        $all_completed = true;


        foreach ($items as $item) {

              $previous = $this->db
                ->select_sum(
                    'sti2.transfer_quantity',
                    'total_transferred'
                )
                ->from(
                    'pstock_transfer_items sti2'
                )
                ->join(
                    'stock_transfers st2',
                    'st2.stock_transfer_id = sti2.stock_transfer_id',
                    'inner'
                )
                ->where(
                    'sti2.job_completion_item_id',
                    $item['job_completion_item_id']
                )
                ->where(
                    'st2.status !=',
                    'Cancelled'
                )
                ->get()
                ->row_array();


            $total_transferred =
                !empty($previous['total_transferred'])
                    ? (float)$previous['total_transferred']
                    : 0;


            $completed_quantity =
                (float)$item['completed_quantity'];

            if (
                $total_transferred
                <
                $completed_quantity
            ) {

                $all_completed = false;

                break;
            }
        }


        $status =
            $all_completed
                ? 'Completed'
                : 'Pending';
    }

    $this->db
        ->where(
            'stock_transfer_id',
            $stock_transfer_id
        )
        ->update(
            'stock_transfers',
            array(
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            )
        );


    return $status;
}
public function get_stock_transfer_for_print($stock_id)
{
    return $this->db
        ->select('
            st.*,
            jo.job_order_no,
            jo.order_date,
            jo.order_no,
            jo.rep_name,
            jo.contact_person,
            jo.remarks AS job_order_remarks,
            jo.start_date,
            jo.finish_date,
            jo.status AS job_order_status,
            pm.project_name,
            jc.job_completion_no,
            jc.completion_date,
            jc.remarks AS job_completion_remarks,
            fb.branch_name AS from_branch_name,
            fw.warehouse_name AS from_warehouse_name,
            fs.store_name AS from_store_name,
            tb.branch_name AS to_branch_name,
            tw.warehouse_name AS to_warehouse_name,
            ts.store_name AS to_store_name
        ')
        ->from('stock_transfers st')

         ->join(
            'job_order jo',
            'jo.job_order_id = st.job_order_id',
            'left'
        )

        /* Project */
        ->join(
            'project_master pm',
            'pm.project_id = st.project_id',
            'left'
        )

        /* Job Completion */
        ->join(
            'job_completion jc',
            'jc.job_completion_id = st.job_completion_id',
            'left'
        )

        /* FROM BRANCH */
        ->join(
            'branch_master fb',
            'fb.branch_id = st.from_branch_id',
            'left'
        )

        /* FROM WAREHOUSE */
        ->join(
            'warehouse_master fw',
            'fw.warehouse_id = st.from_warehouse_id',
            'left'
        )

        /* FROM STORE */
        ->join(
            'store_master fs',
            'fs.store_id = st.from_store_id',
            'left'
        )

        /* TO BRANCH */
        ->join(
            'branch_master tb',
            'tb.branch_id = st.to_branch_id',
            'left'
        )

        /* TO WAREHOUSE */
        ->join(
            'warehouse_master tw',
            'tw.warehouse_id = st.to_warehouse_id',
            'left'
        )

        /* TO STORE */
        ->join(
            'store_master ts',
            'ts.store_id = st.to_store_id',
            'left'
        )

        ->where(
            'st.stock_transfer_id',
            $stock_id
        )

        ->get()
        ->row();
}
public function get_stock_transfer_items_for_print($stock_id)
{
    return $this->db
        ->select('
            sti.*,

            im.product_id,
            im.product_code,
            im.product_name,
            im.description AS master_description

        ')
        ->from('pstock_transfer_items sti')

        ->join(
            'item_master im',
            'im.product_id = sti.item_master_id',
            'left'
        )

        ->where(
            'sti.stock_transfer_id',
            $stock_id
        )

        ->order_by(
            'sti.stock_transfer_item_id',
            'ASC'
        )

        ->get()
        ->result();
}
public function get_job_completion_for_stock_print(
    $job_completion_id
) {
    return $this->db
        ->select('
            jc.*,
            jo.job_order_no,
            jo.fk_project_id,
            jo.order_date,
            jo.order_no,
            jo.rep_name,
            jo.contact_person
        ')
        ->from('job_completion jc')

        ->join(
            'job_order jo',
            'jo.job_order_id = jc.job_order_id',
            'left'
        )

        ->where(
            'jc.job_completion_id',
            $job_completion_id
        )

        ->get()
        ->row();
}
public function get_job_completion_items_for_stock_print(
    $job_completion_id
) {
    return $this->db
        ->select('
            jci.*,

            joi.item_master_id,
            joi.item_code,
            joi.item_description,
            joi.unit,

            im.product_name,
            im.product_code

        ')
        ->from('job_completion_items jci')

        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = jci.job_order_item_id',
            'left'
        )

        ->join(
            'item_master im',
            'im.product_id = joi.item_master_id',
            'left'
        )

        ->where(
            'jci.job_completion_id',
            $job_completion_id
        )

        ->order_by(
            'jci.job_completion_item_id',
            'ASC'
        )

        ->get()
        ->result();
}
public function get_job_order_for_stock_print(
    $job_order_id
) {
    return $this->db
        ->select('
            jo.*,
            pm.project_name
        ')
        ->from('job_order jo')

        ->join(
            'project_master pm',
            'pm.project_id = jo.fk_project_id',
            'left'
        )

        ->where(
            'jo.job_order_id',
            $job_order_id
        )

        ->get()
        ->row();
}
public function get_job_order_items_for_stock_print(
    $job_order_id
) {
    $items =
        $this->db
            ->select('
                joi.*,

                im.product_name,
                im.product_code

            ')
            ->from('job_order_items joi')

            ->join(
                'item_master im',
                'im.product_id = joi.item_master_id',
                'left'
            )

            ->where(
                'joi.job_order_id',
                $job_order_id
            )

            ->order_by(
                'joi.job_order_item_id',
                'ASC'
            )

            ->get()
            ->result();


    /*
     * Load BOM materials
     */
    foreach ($items as &$item) {

        $item->materials =
            $this->db
                ->select('
                    job_order_material_id,
                    material_id,
                    material_code,
                    material_name,
                    quantity_required,
                    unit,
                    cost,
                    source
                ')
                ->from('job_order_item_materials')
                ->where(
                    'job_order_item_id',
                    $item->job_order_item_id
                )
                ->order_by(
                    'job_order_material_id',
                    'ASC'
                )
                ->get()
                ->result();
    }

    unset($item);

    return $items;
}
public function get_material_requests_for_stock_print(
    $job_order_id
) {
    return $this->db
        ->select('
            pmr.*
        ')
        ->from(
            'production_material_requests pmr'
        )

        ->where(
            'pmr.job_order_id',
            $job_order_id
        )

        ->order_by(
            'pmr.production_material_request_id',
            'ASC'
        )

        ->get()
        ->result();
}
public function get_material_request_items_for_stock_print(
    $material_request_id
) {
    return $this->db
        ->select('
            pmri.*,

            joi.item_code,
            joi.item_description,

            im.product_name,
            im.product_code

        ')
        ->from(
            'production_material_request_items pmri'
        )

        ->join(
            'job_order_items joi',
            'joi.job_order_item_id = pmri.job_order_item_id',
            'left'
        )

        ->join(
            'item_master im',
            'im.product_id = pmri.material_id',
            'left'
        )

        ->where(
            'pmri.production_material_request_id',
            $material_request_id
        )

        ->order_by(
            'pmri.production_material_request_item_id',
            'ASC'
        )

        ->get()
        ->result();
}

    //NEW SALES ORDER CHANGES
   public function get_sales_orders_job_order()
    {
        $this->db->select('
            so.so_id,
            so.so_code,
            so.so_date,
            so.grand_total,
            so.project_type
        ');

        $this->db->from('sales_order_master so');

        $this->db->where('so.active', 1);

        // Single Sales Order
        $this->db->where('so.project_type', 0);

        // Sales Order must not already have a Single-SO Job Order
        $this->db->where("
            NOT EXISTS (
                SELECT 1
                FROM job_order jo
                WHERE jo.fk_sales_order_id = so.so_id
                AND jo.job_order_type = 0
                
            )
        ", null, false);

        $this->db->order_by('so.so_id', 'DESC');

        return $this->db->get()->result();
    }

   public function get_sales_order_items($so_id)
    {
        $this->db->select('
            sop.product_table_id,
            sop.so_id,som.so_code AS sales_order_code,
            sop.product_id,im.product_code,im.product_name,
            im.description,  sop.unit_id,
            um.unit_abbr, sop.quantity,
            sop.unit_price, sop.amount
        ');
        $this->db->from('sales_order_products sop');
        // Sales Order Master
        $this->db->join(
            'sales_order_master som',
            'som.so_id = sop.so_id',
            'left'
        );
        // Item Master
        $this->db->join(
            'item_master im',
            'im.product_id = sop.product_id',
            'left'
        );
        // Unit Master
        $this->db->join(
            'unit_master um',
            'um.unit_id = sop.unit_id',
            'left'
        );

        $this->db->where('sop.so_id', $so_id);

        return $this->db->get()->result();
    }
    
    public function insert_job_order_sales_order($data)
    {
        $this->db->insert('job_order_sales_orders', $data);

        return $this->db->insert_id();
    }
    public function get_sales_orders_job_order_project($project_id)
    {
        return $this->db
            ->select('
                som.so_id,
                som.so_code,
                som.so_date,
                qm.quotation_customer,
                cm.customer_id,
                cm.customer_name
            ')
            ->from('sales_order_master som')

            ->join(
                'quotation_master qm',
                'qm.qtn_id = som.qtn_id',
                'left'
            )

            ->join(
                'customer_master cm',
                'cm.customer_id = qm.quotation_customer',
                'left'
            )

            ->where(
                'som.project_id',
                $project_id
            )

            ->where(
                'som.active',
                1
            )

            ->order_by(
                'som.so_id',
                'DESC'
            )

            ->get()
            ->result();
    }
   
    public function get_multiple_sales_order_items($so_ids)
    {
        if (empty($so_ids)) {
            return array();
        }

        $this->db->select('
            sop.product_table_id, sop.so_id,som.so_code,
            sop.product_id,sop.unit_id, sop.quantity,
            sop.unit_price, sop.amount, im.product_code,
            im.product_name
        ');

        $this->db->from('sales_order_products sop');

        $this->db->join(
            'sales_order_master som',
            'som.so_id = sop.so_id',
            'left'
        );

        $this->db->join(
            'item_master im',
            'im.product_id = sop.product_id',
            'left'
        );

        $this->db->where_in('sop.so_id', $so_ids);

        $this->db->order_by('sop.so_id', 'DESC');
        $this->db->order_by('sop.product_table_id', 'ASC');

        return $this->db->get()->result();
    }

    public function get_sales_order_by_id($so_id)
    {
        return $this->db
            ->where('so_id', $so_id)
            ->get('sales_order_master')
            ->row();
    }
    public function get_job_order_sales_order_ids($job_order_id)
    {
        $this->db->select('so_id');
        $this->db->from('job_order_sales_orders');
        $this->db->where('job_order_id', $job_order_id);

        $query = $this->db->get();

        $sales_order_ids = array();

        foreach ($query->result() as $row) {
            $sales_order_ids[] = (int)$row->so_id;
        }

        return $sales_order_ids;
    }

    public function get_project_print($project_id)
    {
        $this->db->select('
            p.project_id,p.project_code, p.project_name,
            p.location,p.start_date, p.end_date,
            p.duration, p.subject, p.po_number, p.remarks
        ');
        $this->db->from('project p');
        $this->db->where('p.project_id', $project_id);
        return $this->db->get()->row();
    }

    public function get_sales_order_job_items_print($so_id,$project_id) {
        $this->db->select('
            joi.job_order_item_id,joi.job_order_id,joi.project_item_id,
            joi.item_master_id,  joi.item_code,joi.item_description,
            joi.quantity, joi.unit
        ');

        $this->db->from('job_order_items joi');

        $this->db->join(
            'job_order jo',
            'jo.job_order_id = joi.job_order_id',
            'left'
        );

        $this->db->where(
            'jo.fk_project_id',
            $project_id
        );

        $this->db->where(
            'joi.so_id',
            $so_id
        );

        return $this->db->get()->result();
    }

    public function get_project_job_item_materials_print($job_order_item_id)
    {
        $this->db->select('
            job_order_material_id,job_order_item_id, project_item_id,
            material_id,material_code, material_name,
            quantity_required,unit,cost,source
        ');
        $this->db->from(
            'job_order_item_materials'
        );

        $this->db->where(
            'job_order_item_id',
            $job_order_item_id
        );

        $this->db->order_by(
            'job_order_material_id',
            'ASC'
        );

        return $this->db->get()->result();
    }
    public function get_job_order_sales_orders_print($job_order_id)
{
    $this->db->select('
        jo.job_order_id,
        jo.job_order_type,
        jo.fk_project_id,
        jo.fk_sales_order_id
    ');

    $this->db->from('job_order jo');

    $this->db->where('jo.job_order_id', $job_order_id);
    $this->db->where('jo.is_deleted', 0);

    $job_order = $this->db->get()->row();

    if (!$job_order) {
        return array();
    }


    /*
     * NORMAL / SINGLE SALES ORDER
     * job_order_type = 0
     */
    if ((int)$job_order->job_order_type === 0) {

        if (empty($job_order->fk_sales_order_id)) {
            return array();
        }

        $this->db->select('
            so.so_id,
            so.so_code,
            so.so_date,
            so.grand_total,
            so.project_type,
            so.project_id
        ');

        $this->db->from('sales_order_master so');

        $this->db->where(
            'so.so_id',
            $job_order->fk_sales_order_id
        );

        $this->db->where('so.active', 1);

        return $this->db
            ->order_by('so.so_id', 'ASC')
            ->get()
            ->result();
    }


    /*
     * PROJECT SALES ORDER
     * job_order_type = 1
     *
     * First use job_order_sales_orders
     * to identify the Sales Orders assigned
     * to this Job Order.
     */
    $this->db->select('
        so.so_id,
        so.so_code,
        so.so_date,
        so.grand_total,
        so.project_type,
        so.project_id
    ');

    $this->db->from('job_order_sales_orders joso');

    $this->db->join(
        'sales_order_master so',
        'so.so_id = joso.so_id',
        'inner'
    );

    $this->db->where(
        'joso.job_order_id',
        $job_order_id
    );

    $this->db->where('so.active', 1);

    $this->db->where('so.project_type', 1);

    $this->db->where(
        'so.project_id',
        $job_order->fk_project_id
    );

    $this->db->order_by('so.so_id', 'ASC');

    return $this->db->get()->result();
}
public function get_project_for_job_order_print($job_order_id)
{
    $this->db->select('
        p.*,
        jo.job_order_id,
        jo.job_order_no,
        jo.fk_project_id
    ');

    $this->db->from('job_order jo');

    $this->db->join(
        'project_master p',
        'p.project_id = jo.fk_project_id',
        'inner'
    );

    $this->db->where('jo.job_order_id', $job_order_id);
    $this->db->where('jo.job_order_type', 1);
    $this->db->where('jo.is_deleted', 0);

    return $this->db->get()->row();
}
public function get_project_job_order_items_print($job_order_id, $so_id)
{
    $this->db->select('
        joi.job_order_item_id,
        joi.job_order_id,
        joi.item_master_id,
        joi.item_code,
        joi.item_description,
        joi.quantity,
        joi.cost,
        joi.unit
    ');

    $this->db->from('job_order_items joi');

    $this->db->where('joi.job_order_id', $job_order_id);
    $this->db->where(
        "EXISTS (
            SELECT 1
            FROM sales_order_products sop
            WHERE sop.so_id = " . (int)$so_id . "
            AND sop.product_id = joi.item_master_id
        )",
        NULL,
        FALSE
    );

    $this->db->order_by(
        'joi.job_order_item_id',
        'ASC'
    );

    return $this->db->get()->result();
}
//CNC
  public function get_cnc_job_orders()
    {
        $this->db->select('
            jo.job_order_id,
            jo.job_order_no,
            jo.job_order_type,
            jo.fk_project_id,
            jo.fk_sales_order_id,
            jo.order_date,
            jo.status
        ');

        $this->db->from('job_order jo');

        $this->db->where('jo.is_deleted', 0);

        /*
         * Only active production Job Orders.
         *
         * We are not restricting to a particular status
         * because your current Job Order status values may vary.
         */
        $this->db->order_by('jo.job_order_id', 'DESC');

        return $this->db->get()->result();
    }


    /**
     * Get Sales Orders for a Job Order
     *
     * Normal Job Order:
     *     job_order.fk_sales_order_id
     *
     * Project Job Order:
     *     job_order_sales_orders
     */
    public function get_job_order_sales_orders($job_order_id)
    {
        /*
         * First get Job Order
         */
        $job_order = $this->db
            ->select('
                job_order_id,
                job_order_type,
                fk_sales_order_id,
                fk_project_id
            ')
            ->from('job_order')
            ->where('job_order_id', $job_order_id)
            ->where('is_deleted', 0)
            ->get()
            ->row();

        if (!$job_order) {
            return array();
        }

        /*
         * NORMAL JOB ORDER
         */
        if ((int) $job_order->job_order_type === 0) {

            if (!$job_order->fk_sales_order_id) {
                return array();
            }

            return $this->db
                ->select('
                    som.so_id,
                    som.so_code,
                    som.so_date,
                    som.grand_total
                ')
                ->from('sales_order_master som')
                ->where('som.so_id', $job_order->fk_sales_order_id)
                ->where('som.active', 1)
                ->get()
                ->result();
        }

        /*
         * PROJECT JOB ORDER
         */
        return $this->db
            ->select('
                som.so_id,
                som.so_code,
                som.so_date,
                som.grand_total
            ')
            ->from('job_order_sales_orders jos')
            ->join(
                'sales_order_master som',
                'som.so_id = jos.so_id',
                'inner'
            )
            ->where('jos.job_order_id', $job_order_id)
            ->where('som.active', 1)
            ->order_by('som.so_code', 'ASC')
            ->get()
            ->result();
    }


    /**
     * Get SO Products belonging to selected Job Order + SO
     *
     * IMPORTANT:
     *
     * We use sales_order_products.product_table_id
     * as sales_order_product_id.
     */
    public function get_cnc_sales_order_products(
        $job_order_id,
        $sales_order_id
    ) {

        /*
         * Make sure SO belongs to Job Order
         */
        if (!$this->validate_job_order_sales_order(
            $job_order_id,
            $sales_order_id
        )) {
            return array();
        }

        $this->db->select('
            sop.product_table_id,
            sop.so_id,
            sop.product_id,
            sop.unit_id,
            sop.quantity,
            sop.unit_price,
            sop.amount
        ');

        $this->db->from('sales_order_products sop');

        $this->db->where('sop.so_id', $sales_order_id);

        $this->db->order_by('sop.product_table_id', 'ASC');

        return $this->db->get()->result();
    }


    /**
     * Validate SO Product
     */
    public function validate_cnc_sales_order_product(
        $sales_order_id,
        $sales_order_product_id
    ) {

        return $this->db
            ->select('
                product_table_id,
                so_id,
                product_id,
                unit_id,
                quantity
            ')
            ->from('sales_order_products')
            ->where('so_id', $sales_order_id)
            ->where(
                'product_table_id',
                $sales_order_product_id
            )
            ->get()
            ->row();
    }


    /**
     * Validate that SO belongs to Job Order
     *
     * Handles normal and project Job Orders.
     */
    public function validate_job_order_sales_order(
        $job_order_id,
        $sales_order_id
    ) {

        $job_order = $this->db
            ->select('
                job_order_id,
                job_order_type,
                fk_sales_order_id
            ')
            ->from('job_order')
            ->where('job_order_id', $job_order_id)
            ->where('is_deleted', 0)
            ->get()
            ->row();

        if (!$job_order) {
            return false;
        }

        /*
         * NORMAL
         */
        if ((int) $job_order->job_order_type === 0) {

            return (
                (int) $job_order->fk_sales_order_id ===
                (int) $sales_order_id
            );
        }

        /*
         * PROJECT
         */
        $exists = $this->db
            ->from('job_order_sales_orders')
            ->where('job_order_id', $job_order_id)
            ->where('so_id', $sales_order_id)
            ->count_all_results();

        return $exists > 0;
    }


    /**
     * Insert Production Task
     */
    public function insert_production_task($data)
    {
        $this->db->insert(
            'production_tasks',
            $data
        );

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }

        return false;
    }


    /**
     * Insert Status History
     */
    public function insert_task_status_history($data)
    {
        return $this->db->insert(
            'production_task_status_history',
            $data
        );
    }

    /**
     * Get CNC Task List
     */
   public function get_cnc_task_list()
{
    $this->db->select('
        pt.task_id, pt.job_order_id, pt.sales_order_id, pt.sales_order_product_id,
        pt.department_id, pt.task_description, pt.quantity,pt.assigned_employee_id,
        pt.assigned_by, pt.priority, pt.status, pt.remarks, pt.started_at, pt.completed_at,
        pt.created_at,jo.job_order_no, som.so_code, dm.dept_name, em.employee_name AS assigned_employee_name,
        joi.job_order_item_id, joi.item_master_id, joi.item_code, joi.item_description,
        joi.unit, im.product_name AS product_name
    ');

    $this->db->from('production_tasks pt');

    // Job Order
    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    // Sales Order
    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    // Job Order Item
    // project_item_id contains sales_order_products.product_table_id
    $this->db->join(
        'job_order_items joi',
        'joi.job_order_id = pt.job_order_id
         AND joi.project_item_id = pt.sales_order_product_id',
        'left'
    );

    // Item Master
    $this->db->join(
        'item_master im',
        'im.product_id = joi.item_master_id',
        'left'
    );

    // Department
    $this->db->join(
        'department_master dm',
        'dm.dept_id = pt.department_id',
        'left'
    );

    // Assigned Employee
    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    // CNC Department
    $this->db->where(
        'pt.department_id',
        8
    );

    $this->db->order_by(
        'pt.task_id',
        'DESC'
    );

    return $this->db->get()->result();
}
    /**
     * Department:
     * 8 = CNC * Designation: * 19 = CNC Employee
     */
    public function get_cnc_employees()
    {
        $this->db->select('
            em.employee_id AS id,em.employee_name AS name,
            em.uid_number, em.user_code, em.designation_id,em.department_id
        ');

        $this->db->from('employee_master em');
        $this->db->where('em.department_id', 8);
        $this->db->where('em.designation_id', 19);
        $this->db->where('em.active', 1);
        $this->db->order_by(
            'em.employee_name',
            'ASC'
        );

        return $this->db->get()->result();
    }


    /**
     * Get CNC task by ID
     */
    public function get_cnc_task_by_id($task_id)
    {
        return $this->db
            ->select('
                task_id,
                job_order_id,
                sales_order_id,
                sales_order_product_id,
                department_id,
                task_description,
                quantity,
                assigned_employee_id,
                assigned_by,
                priority,
                status,
                remarks,
                started_at,
                completed_at,
                created_at,
                updated_at
            ')
            ->from('production_tasks')
            ->where('task_id', $task_id)
            ->where('department_id', 8)
            ->get()
            ->row();
    }


    /**
     * Validate CNC employee
     */
    public function validate_cnc_employee($employee_id)
    {
        return $this->db
            ->select('employee_id')
            ->from('employee_master')
            ->where('employee_id', $employee_id)
            ->where('department_id', 8)
            ->where('designation_id', 19)
            ->where('active', 1)
            ->get()
            ->row();
    }


    /**
     * Update production task
     */
    public function update_production_task($task_id, $data)
    {
        $this->db
            ->where('task_id', $task_id)
            ->where('department_id', 8)
            ->update('production_tasks', $data);

        return $this->db->trans_status();
    }


    /**
     * Insert employee assignment history
     */
    public function insert_task_assignment_history($data)
    {
        return $this->db
            ->insert('production_task_assignment_history', $data);
    }


    /**
     * Get assignment history for a task
     */
    public function get_task_assignment_history($task_id)
    {
        $this->db->select('
            h.assignment_history_id,
            h.task_id,
            h.old_employee_id,
            old_emp.employee_name AS old_employee_name,
            h.new_employee_id,
            new_emp.employee_name AS new_employee_name,
            h.changed_by,
            changed_emp.employee_name AS changed_by_name,
            h.remarks,
            h.changed_at
        ');

        $this->db->from('production_task_assignment_history h');

        $this->db->join(
            'employee_master old_emp',
            'old_emp.employee_id = h.old_employee_id',
            'left'
        );

        $this->db->join(
            'employee_master new_emp',
            'new_emp.employee_id = h.new_employee_id',
            'left'
        );

        $this->db->join(
            'employee_master changed_emp',
            'changed_emp.employee_id = h.changed_by',
            'left'
        );

        $this->db->where('h.task_id', $task_id);

        $this->db->order_by(
            'h.assignment_history_id',
            'DESC'
        );

        return $this->db->get()->result();
    }
/*
      public function get_cnc_employee_tasks($employee_id)
    {
        $this->db->select('
            pt.task_id, pt.job_order_id, pt.sales_order_id, pt.sales_order_product_id,
            pt.department_id,pt.task_description, pt.quantity, pt.assigned_employee_id,
            pt.assigned_by, pt.priority,pt.status,pt.remarks, pt.started_at, pt.completed_at,
            pt.created_at,jo.job_order_no, som.so_code, dm.dept_name,
            em.employee_name AS assigned_employee_name
        ');

        $this->db->from('production_tasks pt');
        $this->db->join(
            'job_order jo',
            'jo.job_order_id = pt.job_order_id',
            'left'
        );
        $this->db->join(
            'sales_order_master som',
            'som.so_id = pt.sales_order_id',
            'left'
        );
        $this->db->join(
            'department_master dm',
            'dm.dept_id = pt.department_id',
            'left'
        );
        $this->db->join(
            'employee_master em',
            'em.employee_id = pt.assigned_employee_id',
            'left'
        );
        $this->db->where('pt.department_id', 8);
        $this->db->where(
            'pt.assigned_employee_id',
            $employee_id
        );

        $this->db->order_by(
            'pt.task_id',
            'DESC'
        );

        return $this->db->get()->result();
    }*/
 
    /**
     * ============================================================
     * CNC EMPLOYEE TASKS
     * ============================================================
     */

    /**
     * Get CNC tasks assigned to a specific employee
     */
    public function get_cnc_employee_tasks($employee_id)
    {
        $this->db->select('
            pt.task_id, pt.job_order_id, pt.sales_order_id,
            pt.sales_order_product_id,pt.department_id,
            pt.task_description,pt.quantity, pt.assigned_employee_id,
            pt.assigned_by,pt.priority,pt.status, pt.remarks,
            pt.started_at,pt.completed_at, pt.created_at,
            jo.job_order_no,som.so_code,dm.dept_name,
            em.employee_name AS assigned_employee_name
        ');

        $this->db->from('production_tasks pt');
        $this->db->join(
            'job_order jo',
            'jo.job_order_id = pt.job_order_id',
            'left'
        );

        $this->db->join(
            'sales_order_master som',
            'som.so_id = pt.sales_order_id',
            'left'
        );

        $this->db->join(
            'department_master dm',
            'dm.dept_id = pt.department_id',
            'left'
        );

        $this->db->join(
            'employee_master em',
            'em.employee_id = pt.assigned_employee_id',
            'left'
        );

        /*
        * CNC department
        */
        $this->db->where('pt.department_id', 8);

        /*
        * Employee can see ONLY his own tasks
        */
        $this->db->where(
            'pt.assigned_employee_id',
            $employee_id
        );

        $this->db->order_by(
            'pt.task_id',
            'DESC'
        );

        return $this->db->get()->result();
    }


    /**
     * Get one CNC task for an employee
     * - CNC department
     * - logged-in employee
     */
    public function get_cnc_employee_task($task_id, $employee_id ) {
        return $this->db
            ->select('
                task_id, job_order_id,sales_order_id,sales_order_product_id,
                department_id, task_description, quantity,
                assigned_employee_id,assigned_by,priority,
                status, remarks, started_at, completed_at, created_at, updated_at
            ')
            ->from('production_tasks')
            ->where('task_id', $task_id)
            ->where('department_id', 8)
            ->where(
                'assigned_employee_id',
                $employee_id
            )
            ->get()
            ->row();
    }

    /**
     * Update CNC task status
     */
    public function update_cnc_task_status($task_id, $employee_id, $status,$data = array() ) {
        $this->db->where(
            'task_id',
            $task_id
        );

        $this->db->where(
            'department_id',
            8
        );
        $this->db->where(
            'assigned_employee_id',
            $employee_id
        );

        return $this->db->update(
            'production_tasks',
            $data
        );
    }

    public function insert_cnc_status_history(
        $task_id, $old_status, $new_status, $employee_id, $remarks = null
    ) {
        $data = array(
            'task_id'    => $task_id,
            'old_status' => $old_status,
            'new_status' => $new_status,
            'changed_by' => $employee_id,
            'remarks'    => $remarks,
            'changed_at' => date('Y-m-d H:i:s')
        );

        return $this->db->insert(
            'production_task_status_history',
            $data
        );
    }
    
    public function get_cnc_task_status_history(
        $task_id,
        $employee_id
    ) {
        
        $task = $this->get_cnc_employee_task(
            $task_id,
            $employee_id
        );

        if (!$task) {
            return array();
        }

        $this->db->select('
            h.history_id, h.task_id, h.old_status,
            h.new_status,h.changed_by, h.remarks,
            h.changed_at,em.employee_name AS changed_by_name
        ');

        $this->db->from(
            'production_task_status_history h'
        );

        $this->db->join(
            'employee_master em',
            'em.employee_id = h.changed_by',
            'left'
        );

        $this->db->where(
            'h.task_id',
            $task_id
        );

        $this->db->order_by(
            'h.history_id',
            'DESC'
        );

        return $this->db->get()->result();
    }

    /**
     * Get CNC task by ID
     */
   /* public function get_cnc_task_by_id($task_id)
    {
        return $this->db
            ->where('task_id', (int) $task_id)
            ->get('production_tasks')
            ->row();
    }
   */


/**
 * Get CNC task by ID
 */
public function get_cnc_task_by_idt($task_id)
{
    return $this->db
        ->where('task_id', (int) $task_id)
        ->get('production_tasks')
        ->row();
}


/**
 * Save CNC task work note
 */
public function save_cnc_task_note($data)
{
    $this->db->insert('production_task_notes', $data);

    if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
    }

    return false;
}


/**
 * Get CNC Task Timeline
 
 */

public function get_cnc_task_timeline($task_id)
{
    $timeline = array();
    $this->db->select('
        h.history_id,
        h.task_id, h.old_status,
        h.new_status,h.changed_by,
        h.remarks, h.changed_at
    ');

    $this->db->from('production_task_status_history h');

    $this->db->where(
        'h.task_id',
        (int) $task_id
    );

    $status_history = $this->db
        ->order_by('h.changed_at', 'ASC')
        ->get()
        ->result_array();


    foreach ($status_history as $row) {

        $timeline[] = array(
            'entry_type'    => 'status',
            'entry_id'      => $row['history_id'],
            'task_id'       => $row['task_id'],

            // Status history user
            'employee_id'   => $row['changed_by'],

            // Kept empty because your existing table
            // does not contain employee/user name.
            'employee_name' => '',

            // Role can be added later if needed
            // from your existing user/session structure.
            'added_by_role' => '',

            'note_type'     => 'Status Change',

            'note'          => !empty($row['remarks'])
                ? $row['remarks']
                : '',

            'from_status'   => !empty($row['old_status'])
                ? $row['old_status']
                : '',

            'to_status'     => $row['new_status'],

            'status'        => $row['new_status'],

            'created_at'    => $row['changed_at']
        );
    }

    $this->db->select('
        n.note_id,
        n.task_id,
        n.employee_id,
        n.added_by_role,
        n.note_type,
        n.note,
        n.created_at
    ');

    $this->db->from('production_task_notes n');

    $this->db->where(
        'n.task_id',
        (int) $task_id
    );

    $notes = $this->db
        ->order_by('n.created_at', 'ASC')
        ->get()
        ->result_array();


    foreach ($notes as $row) {

        $timeline[] = array(
            'entry_type'    => 'note',
            'entry_id'      => $row['note_id'],
            'task_id'       => $row['task_id'],

            'employee_id'   => $row['employee_id'],

            /*
             * Supervisor / Employee
             */
            'added_by_role' => !empty($row['added_by_role'])
                ? $row['added_by_role']
                : 'Employee',

            'employee_name' => '',

            'note_type'     => $row['note_type'],

            'note'          => $row['note'],

            'from_status'   => '',

            'to_status'     => '',

            'status'        => '',

            'created_at'    => $row['created_at']
        );
    }

    usort(
        $timeline,
        function ($a, $b) {

            $time_a = strtotime($a['created_at']);
            $time_b = strtotime($b['created_at']);

            if ($time_a == $time_b) {
                return 0;
            }

            return ($time_a < $time_b) ? -1 : 1;
        }
    );


    return $timeline;
}

public function get_task_handover_by_task_id($task_id)
{
    $task_id = (int)$task_id;
    if (!$task_id) {
        return null;
    }
    return $this->db
        ->where('from_task_id', $task_id)
        ->order_by('handover_id', 'DESC')
        ->limit(1)
        ->get('production_task_handover')
        ->row();
}
public function get_cnc_task_for_approval($task_id)
{
    $task_id = (int)$task_id;

    if (!$task_id) {
        return null;
    }

    $this->db->select('
        pt.task_id, pt.job_order_id, pt.sales_order_id,
        pt.sales_order_product_id, pt.department_id, pt.task_description,
        pt.quantity, pt.assigned_employee_id, pt.assigned_by, pt.priority,
        pt.status, pt.remarks,pt.started_at,pt.completed_at,pt.created_at,
        pt.updated_at,jo.job_order_no, so.so_code,sop.product_id,sop.product_table_id,
        sop.quantity AS sales_order_quantity, sop.unit_id, sop.unit_price, sop.amount,
        im.product_code, im.product_name, emp.employee_id, emp.employee_name,
        emp.uid_number, emp.mobile, emp.designation_id,emp.department_id AS employee_department_id
    ');

    $this->db->from('production_tasks pt');
    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master so',
        'so.so_id = pt.sales_order_id',
        'left'
    );
    $this->db->join(
        'sales_order_products sop',
        'sop.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sop.product_id',
        'left'
    );

    $this->db->join(
        'employee_master emp',
        'emp.employee_id = pt.assigned_employee_id',
        'left'
    );

    $this->db->where(
        'pt.task_id',
        $task_id
    );

    $this->db->where(
        'pt.department_id',
        8
    );

    return $this->db
        ->get()
        ->row();
}
public function update_cnc_task_supervisor_status($task_id, $status)
{
    $task_id = (int)$task_id;

    if (!$task_id || !$status) {
        return false;
    }

    $this->db->where('task_id', $task_id);
    $this->db->where('department_id', 8);

    return $this->db->update('production_tasks', array(
        'status'     => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ));
}

public function insert_task_handover($data)
{
    if (empty($data)) {
        return false;
    }

    $insert_data = array(
        'from_task_id'      => isset($data['from_task_id']) ? (int)$data['from_task_id'] : 0,
        'from_department_id'=> isset($data['from_department_id']) ? (int)$data['from_department_id'] : 0,
        'to_department_id'  => isset($data['to_department_id']) ? (int)$data['to_department_id'] : 0,
        'approved_by'       => isset($data['approved_by']) ? (int)$data['approved_by'] : 0,
        'approval_status'   => isset($data['approval_status']) && $data['approval_status'] !== ''
                                ? $data['approval_status']
                                : 'Approved',
        'remarks'           => isset($data['remarks']) ? $data['remarks'] : null
    );

    // Basic validation
    if (
        !$insert_data['from_task_id'] ||
        !$insert_data['from_department_id'] ||
        !$insert_data['to_department_id'] ||
        !$insert_data['approved_by']
    ) {
        return false;
    }

    $this->db->insert('production_task_handover', $insert_data);

    if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
    }

    return false;
}

public function get_approved_task_handover($task_id, $to_department_id)
{
    $task_id = (int)$task_id;
    $to_department_id = (int)$to_department_id;

    if (!$task_id || !$to_department_id) {
        return null;
    }

    $this->db->where('from_task_id', $task_id);
    $this->db->where('to_department_id', $to_department_id);
    $this->db->where('approval_status', 'Approved');

    return $this->db
        ->order_by('handover_id', 'DESC')
        ->limit(1)
        ->get('production_task_handover')
        ->row();
}
public function create_production_task($data)
{
    if (empty($data) || !is_array($data)) {
        return false;
    }

    $insert_data = array(
        'job_order_id'           => isset($data['job_order_id']) ? (int)$data['job_order_id'] : 0,
        'sales_order_id'         => isset($data['sales_order_id']) ? (int)$data['sales_order_id'] : 0,
        'sales_order_product_id' => isset($data['sales_order_product_id']) ? (int)$data['sales_order_product_id'] : 0,
        'department_id'          => isset($data['department_id']) ? (int)$data['department_id'] : 0,
        'task_description'       => isset($data['task_description']) ? $data['task_description'] : null,
        'quantity'               => isset($data['quantity']) ? $data['quantity'] : 0,
        'assigned_employee_id'   => isset($data['assigned_employee_id']) && $data['assigned_employee_id'] !== ''
                                    ? (int)$data['assigned_employee_id']
                                    : null,
        'assigned_by'            => isset($data['assigned_by']) ? (int)$data['assigned_by'] : 0,
        'priority'               => isset($data['priority']) ? $data['priority'] : 'Medium',
        'status'                 => isset($data['status']) ? $data['status'] : 'Pending',
        'remarks'                => isset($data['remarks']) ? $data['remarks'] : null,
        'created_at'             => isset($data['created_at'])
                                    ? $data['created_at']
                                    : date('Y-m-d H:i:s')
    );

    if (
        !$insert_data['job_order_id'] ||
        !$insert_data['department_id']
    ) {
        return false;
    }

    $this->db->insert('production_tasks', $insert_data);

    if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();
    }

    return false;
}

/* =========================================================
 * BENDING SUPERVISOR
 * Department ID = 9
 * ========================================================= */


/**
 * Get all tasks belonging to Bending department
 *
 * IMPORTANT:
 * CNC handover creates the task with:
 *
 * department_id = 9
 * assigned_employee_id = NULL
 *
 * Bending supervisor then assigns employee.
 */
public function get_bending_supervisor_tasks()
{
    $this->db->select('
        pt.*,
        jo.job_order_no,
        so.so_code,
        imp.product_name AS product_name,
        em.employee_name AS assigned_employee_name,
        em.uid_number AS assigned_employee_uid
    ');

    $this->db->from('production_tasks pt');

    // Job Order
    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    // Sales Order
    $this->db->join(
        'sales_order_master so',
        'so.so_id = pt.sales_order_id',
        'left'
    );

    // Sales Order Product -> Item Master
    $this->db->join(
        'sales_order_products sop',
        'sop.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master imp',
        'imp.product_id = sop.product_id',
        'left'
    );

    // Assigned Employee
    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    // Bending Department
    $this->db->where('pt.department_id', 10);

    // Only active tasks
    //$this->db->where('pt.is_deleted', 0);

    $this->db->order_by('pt.task_id', 'DESC');

    return $this->db->get()->result_array();
}

/**
 * Get one Bending task
 */
public function get_bending_task_by_id($task_id)
{
    $this->db->select('
        pt.*,
        jo.job_order_no,
        so.so_code,
        imp.product_name AS product_name,
        em.employee_name AS assigned_employee_name,
        em.uid_number AS assigned_employee_uid
    ');

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master so',
        'so.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sop',
        'sop.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master imp',
        'imp.product_id = sop.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    $this->db->where('pt.task_id', (int)$task_id);
    $this->db->where('pt.department_id', 10);

    return $this->db->get()->row_array();
}


/**
 * Get active Bending employees
 */
public function get_bending_employees()
{
    $this->db->select('
        employee_id,
        employee_name,
        uid_number,
        department_id,
        designation_id
    ');

    $this->db->from('employee_master');

    $this->db->where('department_id', 10);
    $this->db->where('designation_id', 21);
    $this->db->where('active', 1);

    $this->db->order_by('employee_name', 'ASC');

    return $this->db->get()->result_array();
}

/**
 * Get one Bending employee
 */
public function get_bending_employee($employee_id)
{
    return $this->db
        ->select("
            employee_id,
            employee_name,
            uid_number,
            department_id,
            active
        ")
        ->from('employee_master')
        ->where(
            'employee_id',
            (int)$employee_id
        )
        ->where(
            'department_id',
            10
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();
}


/**
 * Assign task to Bending employee
 */
public function assign_bending_employee(
    $task_id,
    $employee_id
) {
    /*
     * Only Bending tasks can be assigned.
     */
    $this->db
        ->where(
            'task_id',
            (int)$task_id
        )
        ->where(
            'department_id',
            10
        );


    return $this->db->update(
        'production_tasks',
        array(
            'assigned_employee_id' =>
                (int)$employee_id
        )
    );
}


/**
 * Insert Bending supervisor note
 */
public function insert_bending_supervisor_note($data)
{
    return $this->db->insert(
        'production_task_notes',
        $data
    );
}


/**
 * Get Bending task status history
 */
public function get_bending_task_status_history($task_id)
{
    $this->db->select('*');

    $this->db->from(
        'production_task_status_history'
    );

    $this->db->where(
        'task_id',
        (int)$task_id
    );

    $this->db->order_by(
        'changed_at',
        'ASC'
    );

    return $this->db
        ->get()
        ->result();
}


/**
 * Get Bending task timeline
 *
 * Combines status history + notes.
 */
public function get_bending_task_timeline($task_id)
{
    $timeline = array();

    $task_id = (int) $task_id;

    if (!$task_id) {
        return $timeline;
    }

    /*
     * -----------------------------------------------------
     * STATUS HISTORY
     * -----------------------------------------------------
     */

    $this->db->select("
        'status' AS entry_type,
        h.task_id,
        h.old_status,
        h.new_status,
        h.remarks AS note,
        h.changed_at AS created_at,
        CAST(NULL AS CHAR) AS note_type,
        CAST(NULL AS CHAR) AS employee_name
    ", false);

    $this->db->from('production_task_status_history h');

    $this->db->where('h.task_id', $task_id);

    $history = $this->db->get()->result();

    foreach ($history as $row) {
        $timeline[] = $row;
    }


    /*
     * -----------------------------------------------------
     * NOTES
     * -----------------------------------------------------
     */

    $this->db->select("
        'note' AS entry_type,
        n.task_id,
        CAST(NULL AS CHAR) AS old_status,
        CAST(NULL AS CHAR) AS new_status,
        n.note,n.added_by_role,
        n.created_at,
        n.note_type,
        em.employee_name
    ", false);

    $this->db->from('production_task_notes n');

    $this->db->join(
        'employee_master em',
        'em.employee_id = n.employee_id',
        'left'
    );

    $this->db->where('n.task_id', $task_id);

    $notes = $this->db->get()->result();

    foreach ($notes as $row) {
        $timeline[] = $row;
    }


    /*
     * -----------------------------------------------------
     * SORT BY DATE
     * -----------------------------------------------------
     */

    usort(
        $timeline,
        function ($a, $b) {

            $timeA = !empty($a->created_at)
                ? strtotime($a->created_at)
                : 0;

            $timeB = !empty($b->created_at)
                ? strtotime($b->created_at)
                : 0;

            return $timeA - $timeB;
        }
    );


    return $timeline;
}
/* =========================================================
 * GET BENDING EMPLOYEE
 * ========================================================= */
/*public function get_bending_employee($employee_id)
{
    $employee_id = (int) $employee_id;

    if (!$employee_id) {
        return null;
    }

    $this->db->select('
        employee_id,
        uid_number,
        employee_name,
        branch_id,
        designation_id,
        department_id,
        user_code,
        active
    ');

    $this->db->from('employee_master');

    $this->db->where('employee_id', $employee_id);
    $this->db->where('department_id', 10);
    $this->db->where('designation_id', 21);
    $this->db->where('active', 1);

    return $this->db->get()->row();
}

*/
/* =========================================================
 * GET BENDING EMPLOYEE TASKS
 * ========================================================= */
public function get_bending_employee_tasks($employee_id)
{
    $employee_id = (int) $employee_id;

    if (!$employee_id) {
        return array();
    }

    $this->db->select("
        pt.task_id,
        pt.job_order_id,
        pt.sales_order_id,
        pt.sales_order_product_id,
        pt.department_id,
        pt.task_description,
        pt.quantity,
        pt.assigned_employee_id,
        pt.assigned_by,
        pt.priority,
        pt.status,
        pt.remarks,
        pt.started_at,
        pt.completed_at,
        pt.created_at,
        pt.updated_at,
        jo.job_order_no,
        jo.order_no,
        som.so_code,
        sp.product_id,
        sp.quantity AS ordered_quantity,
        im.product_name AS product_name,
        im.product_code,
        em.employee_name,
        em.uid_number
    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    /*
     * BENDING = 10
     */
    $this->db->where('pt.department_id', 10);

    /*
     * Only logged-in employee's tasks.
     */
    $this->db->where(
        'pt.assigned_employee_id',
        $employee_id
    );

    /*
     * Do not show handed-over tasks.
     */
    $this->db->where_not_in(
        'LOWER(pt.status)',
        array(
            'handed over',
            'handover'
        )
    );

    $this->db->order_by(
        'pt.created_at',
        'DESC'
    );

    return $this->db->get()->result_array();
}


/* =========================================================
 * GET ONE BENDING TASK FOR EMPLOYEE
 * ========================================================= */
public function get_bending_task_for_employee(
    $task_id,
    $employee_id
) {
    $task_id     = (int) $task_id;
    $employee_id = (int) $employee_id;

    if (!$task_id || !$employee_id) {
        return null;
    }

    $this->db->select("
        pt.*,

        jo.job_order_no,
        jo.order_no,

        som.so_code,

        sp.quantity AS ordered_quantity,

        im.product_name AS product_name,
        im.product_code,

        em.employee_name,
        em.uid_number
    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    $this->db->where(
        'pt.task_id',
        $task_id
    );

    $this->db->where(
        'pt.department_id',
        10
    );

    $this->db->where(
        'pt.assigned_employee_id',
        $employee_id
    );

    return $this->db->get()->row();
}


/* =========================================================
 * UPDATE BENDING EMPLOYEE TASK STATUS
 * ========================================================= */
public function update_bending_employee_task_status(
    $task_id,
    $employee_id,
    $old_status,
    $new_status,
    $remarks = ''
) {
    $task_id     = (int) $task_id;
    $employee_id = (int) $employee_id;

    if (!$task_id || !$employee_id) {
        return array(
            'status'  => false,
            'message' => 'Invalid task or employee.'
        );
    }

    /*
     * Get current task.
     */
    $task = $this->get_bending_task_for_employee(
        $task_id,
        $employee_id
    );

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Task not found or not assigned to you.'
        );
    }

    /*
     * Always use actual DB status.
     */
    $old_status = trim($task->status);

    $now = date('Y-m-d H:i:s');

    $this->db->trans_start();

    $update = array(
        'status'     => $new_status,
        'updated_at' => $now
    );

    /*
     * Started timestamp.
     */
    if (
        strtolower(trim($new_status)) == 'in progress' &&
        empty($task->started_at)
    ) {
        $update['started_at'] = $now;
    }

    /*
     * Completion timestamp.
     */
    if (
        strtolower(trim($new_status)) == 'completed'
    ) {
        $update['completed_at'] = $now;
    }

    /*
     * Update only own task.
     */
    $this->db->where(
        'task_id',
        $task_id
    );

    $this->db->where(
        'department_id',
        10
    );

    $this->db->where(
        'assigned_employee_id',
        $employee_id
    );

    $this->db->update(
        'production_tasks',
        $update
    );

    /*
     * Status history.
     */
    $this->db->insert(
        'production_task_status_history',
        array(
            'task_id'    => $task_id,
            'old_status' => $old_status,
            'new_status' => $new_status,
            'remarks'    => $remarks,
            'changed_at' => $now
        )
    );

    /*
     * If a status action contains a note,
     * save it as an employee note.
     */
    if ($remarks != '') {

        $note_type = 'General';

        if (strtolower($new_status) == 'hold') {
            $note_type = 'Hold Reason';
        } elseif (strtolower($new_status) == 'completed') {
            $note_type = 'Completion';
        } elseif (
            strtolower($new_status) == 'in progress' &&
            (
                strtolower($old_status) == 'rework' ||
                strtolower($old_status) == 'qc rework' ||
                strtolower($old_status) == 'rejected'
            )
        ) {
            $note_type = 'Rework';
        }

        $this->db->insert(
            'production_task_notes',
            array(
                'task_id'     => $task_id,
                'employee_id' => $employee_id,
                'note_type'   => $note_type,
                'note'        => $remarks,
                'created_at'  => $now
            )
        );
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === false) {
        return array(
            'status'  => false,
            'message' => 'Database error while updating task.'
        );
    }

    return array(
        'status'  => true,
        'message' => 'Task status updated successfully.'
    );
}


/* =========================================================
 * INSERT BENDING EMPLOYEE NOTE
 * ========================================================= */
public function insert_bending_employee_note($data)
{
    if (
        empty($data['task_id']) ||
        empty($data['employee_id']) ||
        empty($data['note'])
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid note data.'
        );
    }

    /*
     * Verify employee is actually Bending Employee.
     */
    $employee = $this->get_bending_employee(
        (int) $data['employee_id']
    );

    if (!$employee) {
        return array(
            'status'  => false,
            'message' => 'Invalid Bending employee.'
        );
    }

    /*
     * Verify task belongs to employee.
     */
    $task = $this->get_bending_task_for_employee(
        (int) $data['task_id'],
        (int) $data['employee_id']
    );

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Task is not assigned to this employee.'
        );
    }

    $this->db->insert(
        'production_task_notes',
        $data
    );

    if ($this->db->affected_rows() <= 0) {
        return array(
            'status'  => false,
            'message' => 'Unable to save note.'
        );
    }

    return array(
        'status'  => true,
        'message' => 'Work note saved successfully.'
    );
}


/* =========================================================
 * GET BENDING EMPLOYEE STATUS HISTORY
 * ========================================================= */
public function get_bending_employee_status_history($task_id)
{
    $this->db->select("
        h.task_id,
        h.old_status,
        h.new_status,
        h.remarks,
        h.changed_at
    ", false);

    $this->db->from(
        'production_task_status_history h'
    );

    $this->db->where(
        'h.task_id',
        (int) $task_id
    );

    $this->db->order_by(
        'h.changed_at',
        'DESC'
    );

    return $this->db->get()->result_array();
}


/* =========================================================
 * GET BENDING EMPLOYEE TIMELINE
 * ========================================================= */
public function get_bending_employee_timeline($task_id)
{
    $timeline = array();

    $task_id = (int) $task_id;

    if (!$task_id) {
        return $timeline;
    }

    /*
     * -----------------------------------------------------
     * STATUS HISTORY
     * -----------------------------------------------------
     */
    $this->db->select("
        'status' AS entry_type,
        h.task_id,
        h.old_status AS from_status,
        h.new_status AS to_status,
        h.remarks AS note,
        h.changed_at AS created_at,
        CAST(NULL AS CHAR) AS note_type,
        CAST(NULL AS CHAR) AS employee_name,
        CAST(NULL AS CHAR) AS added_by_role
    ", false);

    $this->db->from(
        'production_task_status_history h'
    );

    $this->db->where(
        'h.task_id',
        $task_id
    );

    $history = $this->db->get()->result();

    foreach ($history as $row) {
        $timeline[] = $row;
    }


    /*
     * -----------------------------------------------------
     * WORK NOTES
     * -----------------------------------------------------
     */
    $this->db->select("
        'note' AS entry_type,
        n.task_id,
        CAST(NULL AS CHAR) AS from_status,
        CAST(NULL AS CHAR) AS to_status,
        n.note,
        n.created_at,
        n.note_type,
        em.employee_name,

        CASE
            WHEN em.designation_id = 20 THEN 'Supervisor'
            WHEN em.designation_id = 21 THEN 'Employee'
            ELSE 'Employee'
        END AS added_by_role
    ", false);

    $this->db->from(
        'production_task_notes n'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = n.employee_id',
        'left'
    );

    $this->db->where(
        'n.task_id',
        $task_id
    );

    $notes = $this->db->get()->result();

    foreach ($notes as $row) {
        $timeline[] = $row;
    }


    /*
     * -----------------------------------------------------
     * SORT CHRONOLOGICALLY
     * -----------------------------------------------------
     */
    usort(
        $timeline,
        function ($a, $b) {

            $timeA = !empty($a->created_at)
                ? strtotime($a->created_at)
                : 0;

            $timeB = !empty($b->created_at)
                ? strtotime($b->created_at)
                : 0;

            if ($timeA == $timeB) {
                return 0;
            }

            return ($timeA < $timeB) ? -1 : 1;
        }
    );

    return $timeline;
}
/*
public function get_bending_supervisor_tasks()
{
    $this->db->select("
        pt.task_id,
        pt.job_order_id,
        pt.sales_order_id,
        pt.sales_order_product_id,
        pt.department_id,
        pt.task_description,
        pt.quantity,
        pt.assigned_employee_id,
        pt.assigned_by,
        pt.priority,
        pt.status,
        pt.remarks,
        pt.started_at,
        pt.completed_at,
        pt.created_at,
        pt.updated_at,

        jo.job_order_no,
        jo.order_no,

        som.so_code,

        sp.product_id,
        sp.quantity AS ordered_quantity,

        im.item_name AS product_name,
        im.item_code,

        em.employee_name,
        em.uid_number

    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.item_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

   
    $this->db->where('pt.department_id', 10);

    $this->db->order_by('pt.created_at', 'DESC');

    return $this->db->get()->result_array();
}
 */

/* =========================================================
 * BENDING SUPERVISOR V2
 * NEW FUNCTIONS ONLY
 *
 * Existing Bending functions are NOT modified.
 *
 * Bending Department = 10
 * Polishing Department = 11
 * ========================================================= */


/**
 * Get Bending Supervisor task list
 *
 * Gets tasks currently belonging to Bending.
 *
 * CNC creates these tasks with:
 * department_id = 10
 * assigned_employee_id = NULL
 */
public function get_bending_supervisor_tasks_v2()
{
    $this->db->select("
        pt.task_id,
        pt.job_order_id,
        pt.sales_order_id,
        pt.sales_order_product_id,
        pt.department_id,
        pt.task_description,
        pt.quantity,
        pt.assigned_employee_id,
        pt.assigned_by,
        pt.priority,
        pt.status,
        pt.remarks,
        pt.started_at,
        pt.completed_at,
        pt.created_at,
        pt.updated_at,

        jo.job_order_no,
        jo.order_no,

        som.so_code,

        sp.product_id,
        sp.quantity AS ordered_quantity,

        im.product_name AS product_name,
        im.product_code,

        em.employee_name AS assigned_employee_name,
        em.uid_number AS assigned_employee_uid

    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    /*
     * Bending department.
     */
    $this->db->where(
        'pt.department_id',
        10
    );

    $this->db->order_by(
        'pt.task_id',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}


/**
 * Get Bending employees V2
 *
 * Only active Bending Employees.
 *
 * Department = 10
 * Designation = 21
 */
public function get_bending_employees_v2()
{
    $this->db->select("
        employee_id,
        employee_name,
        uid_number,
        department_id,
        designation_id
    ");

    $this->db->from('employee_master');

    $this->db->where(
        'department_id',
        10
    );

    $this->db->where(
        'designation_id',
        21
    );

    $this->db->where(
        'active',
        1
    );

    $this->db->order_by(
        'employee_name',
        'ASC'
    );

    return $this->db
        ->get()
        ->result_array();
}


/**
 * Get one Bending task V2
 */
public function get_bending_task_v2($task_id)
{
    $task_id = (int) $task_id;

    if (!$task_id) {
        return null;
    }

    $this->db->select("
        pt.*,

        jo.job_order_no,
        jo.order_no,

        som.so_code,

        sp.product_id,
        sp.quantity AS ordered_quantity,

        im.product_name AS product_name,
        im.product_code,

        em.employee_name AS assigned_employee_name,
        em.uid_number AS assigned_employee_uid

    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    $this->db->where(
        'pt.task_id',
        $task_id
    );

    $this->db->where(
        'pt.department_id',
        10
    );

    return $this->db
        ->get()
        ->row();
}


/**
 * Assign / Reassign Bending employee V2
 *
 */
public function assign_bending_employee_v2(
    $task_id,
    $employee_id,
    $supervisor_employee_id
) {
    $task_id               = (int) $task_id;
    $employee_id           = (int) $employee_id;
    $supervisor_employee_id = (int) $supervisor_employee_id;

    if (
        !$task_id ||
        !$employee_id ||
        !$supervisor_employee_id
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid assignment data.'
        );
    }

    /*
     * Verify employee.
     */
    $employee = $this->db
        ->select("
            employee_id,
            employee_name,
            uid_number,
            department_id,
            designation_id,
            active
        ")
        ->from('employee_master')
        ->where(
            'employee_id',
            $employee_id
        )
        ->where(
            'department_id',
            10
        )
        ->where(
            'designation_id',
            21
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();

    if (!$employee) {
        return array(
            'status'  => false,
            'message' => 'Invalid Bending employee.'
        );
    }

    /*
     * Verify task belongs to Bending.
     */
    $task = $this->db
        ->select('*')
        ->from('production_tasks')
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            10
        )
        ->get()
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Bending task not found.'
        );
    }

    $old_employee_id = (int) $task->assigned_employee_id;

    $this->db->trans_begin();

    /*
     * Assign employee.
     */
    $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            10
        )
        ->update(
            'production_tasks',
            array(
                'assigned_employee_id' => $employee_id,
                'updated_at'           => date('Y-m-d H:i:s')
            )
        );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to assign employee.'
        );
    }

    /*
     * Save supervisor note.
     */
    $note = ($old_employee_id > 0)
        ? 'Task reassigned to ' . $employee->employee_name . '.'
        : 'Task assigned to ' . $employee->employee_name . '.';

    $this->db->insert(
        'production_task_notes',
        array(
            'task_id'       => $task_id,
            'employee_id'   => $supervisor_employee_id,
            'note_type'     => 'Assignment',
            'note'          => $note,
            'added_by_role' => 'Supervisor',
            'created_at'    => date('Y-m-d H:i:s')
        )
    );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Employee assigned but note could not be saved.'
        );
    }

    $this->db->trans_commit();

    return array(
        'status'  => true,
        'message' => (
            $old_employee_id > 0
                ? 'Bending task reassigned successfully.'
                : 'Bending task assigned successfully.'
        )
    );
}


/**
 * Approve Bending task and hand over to Polishing.
 *
 * Bending = 10
 * Polishing = 11
 *
 * IMPORTANT:
 * No employee is assigned in Polishing.
 */
public function bending_supervisor_approve_and_handover_v2(
    $task_id,
    $supervisor_employee_id,
    $next_department_id,
    $remarks
) {
    $task_id               = (int) $task_id;
    $supervisor_employee_id = (int) $supervisor_employee_id;
    $next_department_id    = (int) $next_department_id;

    $remarks = trim($remarks);

    if (
        !$task_id ||
        !$supervisor_employee_id
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid approval data.'
        );
    }

    if ($next_department_id !== 11) {
        return array(
            'status'  => false,
            'message' => 'Bending must hand over to Polishing.'
        );
    }

    if ($remarks === '') {
        return array(
            'status'  => false,
            'message' => 'Handover remarks are required.'
        );
    }

    /*
     * Get current Bending task.
     */
    $task = $this->db
        ->select('*')
        ->from('production_tasks')
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            10
        )
        ->get()
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Bending task not found.'
        );
    }

    $current_status = strtolower(
        trim($task->status)
    );

    /*
     * Supervisor can approve only completed/review task.
     */
    if (
        $current_status !== 'completed' &&
        $current_status !== 'supervisor review' &&
        $current_status !== 'review'
    ) {
        return array(
            'status'  => false,
            'message' => 'Only completed/review tasks can be handed over.'
        );
    }

    /*
     * Prevent duplicate handover.
     */
    $existing = $this->db
        ->where(
            'from_task_id',
            $task_id
        )
        ->where(
            'to_department_id',
            11
        )
        ->where(
            'approval_status',
            'Approved'
        )
        ->get(
            'production_task_handover'
        )
        ->row();

    if ($existing) {
        return array(
            'status'  => false,
            'message' => 'This task has already been handed over to Polishing.'
        );
    }

    $now = date('Y-m-d H:i:s');

    $this->db->trans_begin();

    /*
     * Mark current Bending task approved.
     */
    $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            10
        )
        ->update(
            'production_tasks',
            array(
                'status'     => 'Approved',
                'updated_at' => $now
            )
        );

    /*
     * Status history.
     */
    $this->db->insert(
        'production_task_status_history',
        array(
            'task_id'    => $task_id,
            'old_status' => $task->status,
            'new_status' => 'Approved',
            'remarks'    => $remarks,
            'changed_by' => $supervisor_employee_id,
            'changed_at' => $now
        )
    );

    /*
     * Create new Polishing task.
     *
     * assigned_employee_id MUST remain NULL.
     */
    $polishing_task = array(
        'job_order_id'           => $task->job_order_id,
        'sales_order_id'         => $task->sales_order_id,
        'sales_order_product_id' => $task->sales_order_product_id,
        'department_id'          => 11,
        'task_description'       => $task->task_description,
        'quantity'               => $task->quantity,
        'assigned_employee_id'   => null,
        'assigned_by'            => $supervisor_employee_id,
        'priority'               => $task->priority,
        'status'                 => 'Pending',
        'remarks'                => $remarks,
        'created_at'             => $now
    );

    $this->db->insert(
        'production_tasks',
        $polishing_task
    );

    $polishing_task_id =
        $this->db->insert_id();

    if (
        !$polishing_task_id ||
        $this->db->trans_status() === false
    ) {
        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to create Polishing task.'
        );
    }

    /*
     * Polishing initial status.
     */
    $this->db->insert(
        'production_task_status_history',
        array(
            'task_id'    => $polishing_task_id,
            'old_status' => null,
            'new_status' => 'Pending',
            'remarks'    => 'Task received from Bending.',
            'changed_by' => $supervisor_employee_id,
            'changed_at' => $now
        )
    );

    /*
     * Handover record.
     */
    $this->db->insert(
        'production_task_handover',
        array(
            'from_task_id'       => $task_id,
            'from_department_id' => 10,
            'to_department_id'   => 11,
            'approved_by'        => $supervisor_employee_id,
            'approval_status'    => 'Approved',
            'remarks'            => $remarks,
            'handed_over_at'     => $now
        )
    );

    /*
     * Supervisor note.
     */
    $this->db->insert(
        'production_task_notes',
        array(
            'task_id'       => $task_id,
            'employee_id'   => $supervisor_employee_id,
            'note_type'     => 'Handover',
            'note'          => $remarks,
            'added_by_role' => 'Supervisor',
            'created_at'    => $now
        )
    );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to complete Bending handover.'
        );
    }

    $this->db->trans_commit();

    return array(
        'status'            => true,
        'message'           => 'Bending task approved and handed over to Polishing successfully.',
        'polishing_task_id' => $polishing_task_id
    );
}


/**
 * Send Bending task for rework.
 *
 * department_id = 10
 *
 * Assigned employee remains unchanged.
 */
public function bending_supervisor_rework_v2(
    $task_id,
    $supervisor_employee_id,
    $remarks
) {
    $task_id                = (int) $task_id;
    $supervisor_employee_id = (int) $supervisor_employee_id;

    $remarks = trim($remarks);

    if (
        !$task_id ||
        !$supervisor_employee_id
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid rework data.'
        );
    }

    if ($remarks === '') {
        return array(
            'status'  => false,
            'message' => 'Rework reason is required.'
        );
    }

    $task = $this->db
        ->select('*')
        ->from('production_tasks')
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            10
        )
        ->get()
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Bending task not found.'
        );
    }

    $current_status = strtolower(
        trim($task->status)
    );

    if (
        $current_status !== 'completed' &&
        $current_status !== 'supervisor review' &&
        $current_status !== 'review'
    ) {
        return array(
            'status'  => false,
            'message' => 'Only completed/review tasks can be sent for rework.'
        );
    }

    $now = date('Y-m-d H:i:s');

    $this->db->trans_begin();

    /*
     * Keep department and employee unchanged.
     */
    $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            10
        )
        ->update(
            'production_tasks',
            array(
                'status'     => 'Rework',
                'updated_at' => $now
            )
        );

    /*
     * Status history.
     */
    $this->db->insert(
        'production_task_status_history',
        array(
            'task_id'    => $task_id,
            'old_status' => $task->status,
            'new_status' => 'Rework',
            'remarks'    => $remarks,
            'changed_by' => $supervisor_employee_id,
            'changed_at' => $now
        )
    );

    /*
     * Rework handover record.
     *
     * Bending -> Bending
     */
    $this->db->insert(
        'production_task_handover',
        array(
            'from_task_id'       => $task_id,
            'from_department_id' => 10,
            'to_department_id'   => 10,
            'approved_by'        => $supervisor_employee_id,
            'approval_status'    => 'Rework',
            'remarks'            => $remarks,
            'handed_over_at'     => $now
        )
    );

    /*
     * Supervisor rework note.
     */
    $this->db->insert(
        'production_task_notes',
        array(
            'task_id'       => $task_id,
            'employee_id'   => $supervisor_employee_id,
            'note_type'     => 'Rework',
            'note'          => $remarks,
            'added_by_role' => 'Supervisor',
            'created_at'    => $now
        )
    );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to send task for rework.'
        );
    }

    $this->db->trans_commit();

    return array(
        'status'  => true,
        'message' => 'Bending task has been sent for rework.'
    );
}


/**
 * Insert Bending Supervisor note V2
 */
public function insert_bending_supervisor_note_v2(
    $task_id,
    $employee_id,
    $note_type,
    $note
) {
    $task_id     = (int) $task_id;
    $employee_id = (int) $employee_id;

    $note_type = trim($note_type);
    $note      = trim($note);

    if (
        !$task_id ||
        !$employee_id ||
        $note === ''
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid note data.'
        );
    }

    /*
     * Verify supervisor employee.
     */
    $supervisor = $this->db
        ->select("
            employee_id, employee_name, department_id,
            designation_id, active
        ")
        ->from('employee_master')
        ->where(
            'employee_id',
            $employee_id
        )
        ->where(
            'department_id',
            10
        )
        ->where(
            'designation_id',
            20
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();

    if (!$supervisor) {
        return array(
            'status'  => false,
            'message' => 'Invalid Bending Supervisor.'
        );
    }

    /*
     * Verify Bending task.
     */
    $task = $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            10
        )
        ->get(
            'production_tasks'
        )
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Bending task not found.'
        );
    }

    $insert = array(
        'task_id'       => $task_id,
        'employee_id'   => $employee_id,
        'note_type'     => ($note_type !== '' ? $note_type : 'General'),
        'note'          => $note,
        'added_by_role' => 'Supervisor',
        'created_at'    => date('Y-m-d H:i:s')
    );

    $this->db->insert(
        'production_task_notes',
        $insert
    );

    if ($this->db->affected_rows() <= 0) {
        return array(
            'status'  => false,
            'message' => 'Unable to save supervisor note.'
        );
    }

    return array(
        'status'  => true,
        'message' => 'Supervisor note saved successfully.'
    );
}


/**
 * Get Bending Supervisor timeline V2
 */
public function get_bending_supervisor_timeline_v2(
    $task_id
) {
    $task_id = (int) $task_id;

    if (!$task_id) {
        return array();
    }

    $timeline = array();

    /*
     * Status history
     */
    $this->db->select("
        'status' AS entry_type,
        h.task_id,  h.old_status AS from_status,  h.new_status AS to_status,
        h.remarks AS note, h.changed_at AS created_at,
        CAST(NULL AS CHAR) AS note_type, CAST(NULL AS CHAR) AS employee_name,
        CAST(NULL AS CHAR) AS added_by_role", false);

    $this->db->from(
        'production_task_status_history h'
    );

    $this->db->where(
        'h.task_id',
        $task_id
    );

    $history = $this->db
        ->get()
        ->result();

    foreach ($history as $row) {
        $timeline[] = $row;
    }

    /*
     * Notes
     */
    $this->db->select("
        'note' AS entry_type,
        n.task_id,
        CAST(NULL AS CHAR) AS from_status,
        CAST(NULL AS CHAR) AS to_status,
        n.note,
        n.created_at,
        n.note_type,
        em.employee_name,

        CASE
            WHEN em.designation_id = 20
                THEN 'Supervisor'
            WHEN em.designation_id = 21
                THEN 'Employee'
            ELSE
                COALESCE(n.added_by_role, 'Employee')
        END AS added_by_role

    ", false);

    $this->db->from(
        'production_task_notes n'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = n.employee_id',
        'left'
    );

    $this->db->where(
        'n.task_id',
        $task_id
    );

    $notes = $this->db
        ->get()
        ->result();

    foreach ($notes as $row) {
        $timeline[] = $row;
    }

    /*
     * Sort chronologically.
     */
    usort(
        $timeline,
        function ($a, $b) {

            $timeA = !empty($a->created_at)
                ? strtotime($a->created_at)
                : 0;

            $timeB = !empty($b->created_at)
                ? strtotime($b->created_at)
                : 0;

            if ($timeA == $timeB) {
                return 0;
            }

            return ($timeA < $timeB)
                ? -1
                : 1;
        }
    );

    return $timeline;
}


/**
 * Get latest handover for Bending task V2
 */
public function get_bending_task_handover_v2(
    $task_id
) {
    $task_id = (int) $task_id;

    if (!$task_id) {
        return null;
    }

    return $this->db
        ->where(
            'from_task_id',
            $task_id
        )
        ->order_by(
            'handover_id',
            'DESC'
        )
        ->limit(1)
        ->get(
            'production_task_handover'
        )
        ->row();
}
/**
 * POLISHING
 */
public function get_polishing_supervisor_tasks_v2()
{
    $this->db->select("
        pt.task_id, pt.job_order_id, pt.sales_order_id, pt.sales_order_product_id,
        pt.department_id,pt.task_description, pt.quantity,pt.assigned_employee_id,
        pt.assigned_by, pt.priority, pt.status, pt.remarks, pt.started_at,pt.completed_at,
        pt.created_at,pt.updated_at,jo.job_order_no, jo.order_no,
        som.so_code, sp.product_id, sp.quantity AS ordered_quantity,
        im.product_name AS product_name,
        im.product_code,

        em.employee_name AS assigned_employee_name,
        em.uid_number AS assigned_employee_uid

    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    /*
     * Polishing department.
     */
    $this->db->where(
        'pt.department_id',
        11
    );

    $this->db->order_by(
        'pt.task_id',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}


/**
 * Get Polishing employees V2
 *
 * Only active Polishing Employees.
 *
 * Department = 11
 * Designation = 23
 */
public function get_polishing_employees_v2()
{
    $this->db->select("
        employee_id,
        employee_name,
        uid_number,
        department_id,
        designation_id
    ");

    $this->db->from('employee_master');

    $this->db->where(
        'department_id',
        11
    );

    $this->db->where(
        'designation_id',
        23
    );

    $this->db->where(
        'active',
        1
    );

    $this->db->order_by(
        'employee_name',
        'ASC'
    );

    return $this->db
        ->get()
        ->result_array();
}


/**
 * Get one Polishing task V2
 */
public function get_polishing_task_v2($task_id)
{
    $task_id = (int) $task_id;

    if (!$task_id) {
        return null;
    }

    $this->db->select("
        pt.*,

        jo.job_order_no, jo.order_no,
        som.so_code,
        sp.product_id, sp.quantity AS ordered_quantity,

        im.product_name AS product_name,
        im.product_code,

        em.employee_name AS assigned_employee_name,
        em.uid_number AS assigned_employee_uid

    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    $this->db->where(
        'pt.task_id',
        $task_id
    );

    $this->db->where(
        'pt.department_id',
        11
    );

    return $this->db
        ->get()
        ->row();
}


/**
 * Assign / Reassign Polishing employee V2
 *
 */
public function assign_polishing_employee_v2(
    $task_id,
    $employee_id,
    $supervisor_employee_id
) {
    $task_id               = (int) $task_id;
    $employee_id           = (int) $employee_id;
    $supervisor_employee_id = (int) $supervisor_employee_id;

    if (
        !$task_id ||
        !$employee_id ||
        !$supervisor_employee_id
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid assignment data.'
        );
    }

    /*
     * Verify employee.
     */
    $employee = $this->db
        ->select("
            employee_id,
            employee_name,
            uid_number,
            department_id,
            designation_id,
            active
        ")
        ->from('employee_master')
        ->where(
            'employee_id',
            $employee_id
        )
        ->where(
            'department_id',
            11
        )
        ->where(
            'designation_id',
            23
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();

    if (!$employee) {
        return array(
            'status'  => false,
            'message' => 'Invalid Polishing employee.'
        );
    }

    /*
     * Verify task belongs to Polishing.
     */
    $task = $this->db
        ->select('*')
        ->from('production_tasks')
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            11
        )
        ->get()
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Polishing task not found.'
        );
    }

    $old_employee_id = (int) $task->assigned_employee_id;

    $this->db->trans_begin();

    /*
     * Assign employee.
     */
    $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            11
        )
        ->update(
            'production_tasks',
            array(
                'assigned_employee_id' => $employee_id,
                'updated_at'           => date('Y-m-d H:i:s')
            )
        );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to assign employee.'
        );
    }

    /*
     * Save supervisor note.
     */
    $note = ($old_employee_id > 0)
        ? 'Task reassigned to ' . $employee->employee_name . '.'
        : 'Task assigned to ' . $employee->employee_name . '.';

    $this->db->insert(
        'production_task_notes',
        array(
            'task_id'       => $task_id,
            'employee_id'   => $supervisor_employee_id,
            'note_type'     => 'Assignment',
            'note'          => $note,
            'added_by_role' => 'Supervisor',
            'created_at'    => date('Y-m-d H:i:s')
        )
    );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Employee assigned but note could not be saved.'
        );
    }

    $this->db->trans_commit();

    return array(
        'status'  => true,
        'message' => (
            $old_employee_id > 0
                ? 'Polishing task reassigned successfully.'
                : 'Polishing task assigned successfully.'
        )
    );
}


/**
 * Approve Polishing task and hand over to Joining/Fixing
 *
 * Polishing = 11
 * Joining/Fixing = 12
 *
 * IMPORTANT:
 * No employee is assigned in Polishing.
 */
public function polishing_supervisor_approve_and_handover_v2(
    $task_id,
    $supervisor_employee_id,
    $next_department_id,
    $remarks
) {
    $task_id               = (int) $task_id;
    $supervisor_employee_id = (int) $supervisor_employee_id;
    $next_department_id    = (int) $next_department_id;

    $remarks = trim($remarks);

    if (
        !$task_id ||
        !$supervisor_employee_id
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid approval data.'
        );
    }

    if ($next_department_id !== 12) {
        return array(
            'status'  => false,
            'message' => 'Polishing must hand over to Joining/Fixing.'
        );
    }

    if ($remarks === '') {
        return array(
            'status'  => false,
            'message' => 'Handover remarks are required.'
        );
    }

    /*
     * Get current Polishing task.
     */
    $task = $this->db
        ->select('*')
        ->from('production_tasks')
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            11
        )
        ->get()
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Polishing task not found.'
        );
    }

    $current_status = strtolower(
        trim($task->status)
    );

    /*
     * Supervisor can approve only completed/review task.
     */
    if (
        $current_status !== 'completed' &&
        $current_status !== 'supervisor review' &&
        $current_status !== 'review'
    ) {
        return array(
            'status'  => false,
            'message' => 'Only completed/review tasks can be handed over.'
        );
    }

    /*
     * Prevent duplicate handover.
     */
    $existing = $this->db
        ->where(
            'from_task_id',
            $task_id
        )
        ->where(
            'to_department_id',
            12
        )
        ->where(
            'approval_status',
            'Approved'
        )
        ->get(
            'production_task_handover'
        )
        ->row();

    if ($existing) {
        return array(
            'status'  => false,
            'message' => 'This task has already been handed over to Polishing.'
        );
    }

    $now = date('Y-m-d H:i:s');

    $this->db->trans_begin();

    /*
     * Mark current Polishing task approved.
     */
    $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            11
        )
        ->update(
            'production_tasks',
            array(
                'status'     => 'Approved',
                'updated_at' => $now
            )
        );

    /*
     * Status history.
     */
    $this->db->insert(
        'production_task_status_history',
        array(
            'task_id'    => $task_id,
            'old_status' => $task->status,
            'new_status' => 'Approved',
            'remarks'    => $remarks,
            'changed_by' => $supervisor_employee_id,
            'changed_at' => $now
        )
    );

    /*
     * Create new Polishing task.
     *
     * assigned_employee_id MUST remain NULL.
     */
    $polishing_task = array(
        'job_order_id'           => $task->job_order_id,
        'sales_order_id'         => $task->sales_order_id,
        'sales_order_product_id' => $task->sales_order_product_id,
        'department_id'          => 12,
        'task_description'       => $task->task_description,
        'quantity'               => $task->quantity,
        'assigned_employee_id'   => null,
        'assigned_by'            => $supervisor_employee_id,
        'priority'               => $task->priority,
        'status'                 => 'Pending',
        'remarks'                => $remarks,
        'created_at'             => $now
    );

    $this->db->insert(
        'production_tasks',
        $polishing_task
    );

    $polishing_task_id =
        $this->db->insert_id();

    if (
        !$polishing_task_id ||
        $this->db->trans_status() === false
    ) {
        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to create Polishing task.'
        );
    }

    /*
     * Polishing initial status.
     */
    $this->db->insert(
        'production_task_status_history',
        array(
            'task_id'    => $polishing_task_id,
            'old_status' => null,
            'new_status' => 'Pending',
            'remarks'    => 'Task received from Polishing.',
            'changed_by' => $supervisor_employee_id,
            'changed_at' => $now
        )
    );

    /*
     * Handover record.
     */
    $this->db->insert(
        'production_task_handover',
        array(
            'from_task_id'       => $task_id,
            'from_department_id' => 11,
            'to_department_id'   => 12,
            'approved_by'        => $supervisor_employee_id,
            'approval_status'    => 'Approved',
            'remarks'            => $remarks,
            'handed_over_at'     => $now
        )
    );

    /*
     * Supervisor note.
     */
    $this->db->insert(
        'production_task_notes',
        array(
            'task_id'       => $task_id,
            'employee_id'   => $supervisor_employee_id,
            'note_type'     => 'Handover',
            'note'          => $remarks,
            'added_by_role' => 'Supervisor',
            'created_at'    => $now
        )
    );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to complete Polishing handover.'
        );
    }

    $this->db->trans_commit();

    return array(
        'status'            => true,
        'message'           => 'Polishing task approved and handed over to Polishing successfully.',
        'polishing_task_id' => $polishing_task_id
    );
}


/**
 * Send Polishing task for rework.
 *
 * department_id = 11
 *
 * Assigned employee remains unchanged.
 */
public function polishing_supervisor_rework_v2(
    $task_id,
    $supervisor_employee_id,
    $remarks
) {
    $task_id                = (int) $task_id;
    $supervisor_employee_id = (int) $supervisor_employee_id;

    $remarks = trim($remarks);

    if (
        !$task_id ||
        !$supervisor_employee_id
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid rework data.'
        );
    }

    if ($remarks === '') {
        return array(
            'status'  => false,
            'message' => 'Rework reason is required.'
        );
    }

    $task = $this->db
        ->select('*')
        ->from('production_tasks')
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            11
        )
        ->get()
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Polishing task not found.'
        );
    }

    $current_status = strtolower(
        trim($task->status)
    );

    if (
        $current_status !== 'completed' &&
        $current_status !== 'supervisor review' &&
        $current_status !== 'review'
    ) {
        return array(
            'status'  => false,
            'message' => 'Only completed/review tasks can be sent for rework.'
        );
    }

    $now = date('Y-m-d H:i:s');

    $this->db->trans_begin();

    /*
     * Keep department and employee unchanged.
     */
    $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            11
        )
        ->update(
            'production_tasks',
            array(
                'status'     => 'Rework',
                'updated_at' => $now
            )
        );

    /*
     * Status history.
     */
    $this->db->insert(
        'production_task_status_history',
        array(
            'task_id'    => $task_id,
            'old_status' => $task->status,
            'new_status' => 'Rework',
            'remarks'    => $remarks,
            'changed_by' => $supervisor_employee_id,
            'changed_at' => $now
        )
    );

    /*
     * Rework handover record.
     *
     * Polishing -> Polishing
     */
    $this->db->insert(
        'production_task_handover',
        array(
            'from_task_id'       => $task_id,
            'from_department_id' => 11,
            'to_department_id'   => 11,
            'approved_by'        => $supervisor_employee_id,
            'approval_status'    => 'Rework',
            'remarks'            => $remarks,
            'handed_over_at'     => $now
        )
    );

    /*
     * Supervisor rework note.
     */
    $this->db->insert(
        'production_task_notes',
        array(
            'task_id'       => $task_id,
            'employee_id'   => $supervisor_employee_id,
            'note_type'     => 'Rework',
            'note'          => $remarks,
            'added_by_role' => 'Supervisor',
            'created_at'    => $now
        )
    );

    if ($this->db->trans_status() === false) {

        $this->db->trans_rollback();

        return array(
            'status'  => false,
            'message' => 'Unable to send task for rework.'
        );
    }

    $this->db->trans_commit();

    return array(
        'status'  => true,
        'message' => 'Polishing task has been sent for rework.'
    );
}


/**
 * Insert Polishing Supervisor note V2
 */
public function insert_polishing_supervisor_note_v2(
    $task_id,
    $employee_id,
    $note_type,
    $note
) {
    $task_id     = (int) $task_id;
    $employee_id = (int) $employee_id;

    $note_type = trim($note_type);
    $note      = trim($note);

    if (
        !$task_id ||
        !$employee_id ||
        $note === ''
    ) {
        return array(
            'status'  => false,
            'message' => 'Invalid note data.'
        );
    }

    /*
     * Verify supervisor employee.
     */
    $supervisor = $this->db
        ->select("
            employee_id, employee_name, department_id,
            designation_id, active
        ")
        ->from('employee_master')
        ->where(
            'employee_id',
            $employee_id
        )
        ->where(
            'department_id',
            11
        )
        ->where(
            'designation_id',
            22
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();

    if (!$supervisor) {
        return array(
            'status'  => false,
            'message' => 'Invalid Polishing Supervisor.'
        );
    }

    /*
     * Verify Polishing task.
     */
    $task = $this->db
        ->where(
            'task_id',
            $task_id
        )
        ->where(
            'department_id',
            11
        )
        ->get(
            'production_tasks'
        )
        ->row();

    if (!$task) {
        return array(
            'status'  => false,
            'message' => 'Polishing task not found.'
        );
    }

    $insert = array(
        'task_id'       => $task_id,
        'employee_id'   => $employee_id,
        'note_type'     => ($note_type !== '' ? $note_type : 'General'),
        'note'          => $note,
        'added_by_role' => 'Supervisor',
        'created_at'    => date('Y-m-d H:i:s')
    );

    $this->db->insert(
        'production_task_notes',
        $insert
    );

    if ($this->db->affected_rows() <= 0) {
        return array(
            'status'  => false,
            'message' => 'Unable to save supervisor note.'
        );
    }

    return array(
        'status'  => true,
        'message' => 'Supervisor note saved successfully.'
    );
}


/**
 * Get Polishing Supervisor timeline V2
 */
public function get_polishing_supervisor_timeline_v2(
    $task_id
) {
    $task_id = (int) $task_id;

    if (!$task_id) {
        return array();
    }

    $timeline = array();

    /*
     * Status history
     */
    $this->db->select("
        'status' AS entry_type,
        h.task_id,  h.old_status AS from_status,  h.new_status AS to_status,
        h.remarks AS note, h.changed_at AS created_at,
        CAST(NULL AS CHAR) AS note_type, CAST(NULL AS CHAR) AS employee_name,
        CAST(NULL AS CHAR) AS added_by_role", false);

    $this->db->from(
        'production_task_status_history h'
    );

    $this->db->where(
        'h.task_id',
        $task_id
    );

    $history = $this->db
        ->get()
        ->result();

    foreach ($history as $row) {
        $timeline[] = $row;
    }

    /*
     * Notes
     */
    $this->db->select("
        'note' AS entry_type,
        n.task_id,
        CAST(NULL AS CHAR) AS from_status,
        CAST(NULL AS CHAR) AS to_status,
        n.note,
        n.created_at,
        n.note_type,
        em.employee_name,

        CASE
            WHEN em.designation_id = 22
                THEN 'Supervisor'
            WHEN em.designation_id = 23
                THEN 'Employee'
            ELSE
                COALESCE(n.added_by_role, 'Employee')
        END AS added_by_role

    ", false);

    $this->db->from(
        'production_task_notes n'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = n.employee_id',
        'left'
    );

    $this->db->where(
        'n.task_id',
        $task_id
    );

    $notes = $this->db
        ->get()
        ->result();

    foreach ($notes as $row) {
        $timeline[] = $row;
    }

    /*
     * Sort chronologically.
     */
    usort(
        $timeline,
        function ($a, $b) {

            $timeA = !empty($a->created_at)
                ? strtotime($a->created_at)
                : 0;

            $timeB = !empty($b->created_at)
                ? strtotime($b->created_at)
                : 0;

            if ($timeA == $timeB) {
                return 0;
            }

            return ($timeA < $timeB)
                ? -1
                : 1;
        }
    );

    return $timeline;
}


/**
 * Get latest handover for Polishing task V2
 */
public function get_polishing_task_handover_v2(
    $task_id
) {
    $task_id = (int) $task_id;

    if (!$task_id) {
        return null;
    }

    return $this->db
        ->where(
            'from_task_id',
            $task_id
        )
        ->order_by(
            'handover_id',
            'DESC'
        )
        ->limit(1)
        ->get(
            'production_task_handover'
        )
        ->row();
}

/* =========================================================
 * POLISHING EMPLOYEE - V2
 * ========================================================= */

public function get_polishing_employee_v2($employee_id)
{
    return $this->db
        ->select("employee_id, employee_name, uid_number, department_id, designation_id, active")
        ->from("employee_master")
        ->where("employee_id", (int)$employee_id)
        ->where("department_id", 11)
        ->where("designation_id", 23)
        ->where("active", 1)
        ->get()
        ->row();
}


public function get_polishing_employee_tasks_v2($employee_id)
{
    $employee_id = (int) $employee_id;

    if (!$employee_id) {
        return array();
    }

    $this->db->select("
        pt.task_id, pt.job_order_id, pt.sales_order_id,
        pt.sales_order_product_id,pt.department_id, pt.task_description,
        pt.quantity, pt.assigned_employee_id, pt.assigned_by,
        pt.priority, pt.status, pt.remarks,pt.started_at, pt.completed_at,
        pt.created_at,pt.updated_at,jo.job_order_no,jo.order_no,
        som.so_code,sp.product_id,sp.quantity AS ordered_quantity,
        im.product_name AS product_name,im.product_code, em.employee_name, em.uid_number
    ", false);

    $this->db->from('production_tasks pt');

    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );

    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );

    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    /*
     * BENDING = 11
     */
    $this->db->where('pt.department_id', 11);

    /*
     * Only logged-in employee's tasks.
     */
    $this->db->where(
        'pt.assigned_employee_id',
        $employee_id
    );

    /*
     * Do not show handed-over tasks.
     */
    $this->db->where_not_in(
        'LOWER(pt.status)',
        array(
            'handed over',
            'handover'
        )
    );

    $this->db->order_by(
        'pt.created_at',
        'DESC'
    );

    return $this->db->get()->result_array();
}


/* =========================================================
 * GET ONE BENDING TASK FOR EMPLOYEE
 * ========================================================= */
public function get_polishing_task_for_employee_v2(
    $task_id,
    $employee_id
) {
    $task_id     = (int) $task_id;
    $employee_id = (int) $employee_id;

    if (!$task_id || !$employee_id) {
        return null;
    }

    $this->db->select("
        pt.*,

        jo.job_order_no,
        jo.order_no,

        som.so_code, sp.quantity AS ordered_quantity,
        im.product_name AS product_name,
        im.product_code,em.employee_name,
        em.uid_number
    ", false);

    $this->db->from('production_tasks pt');
    $this->db->join(
        'job_order jo',
        'jo.job_order_id = pt.job_order_id',
        'left'
    );
    $this->db->join(
        'sales_order_master som',
        'som.so_id = pt.sales_order_id',
        'left'
    );
    $this->db->join(
        'sales_order_products sp',
        'sp.product_table_id = pt.sales_order_product_id',
        'left'
    );
    $this->db->join(
        'item_master im',
        'im.product_id = sp.product_id',
        'left'
    );
    $this->db->join(
        'employee_master em',
        'em.employee_id = pt.assigned_employee_id',
        'left'
    );

    $this->db->where(
        'pt.task_id',
        $task_id
    );

    $this->db->where(
        'pt.department_id',
        11
    );

    $this->db->where(
        'pt.assigned_employee_id',
        $employee_id
    );

    return $this->db->get()->row();
}


/* =========================================================
 * UPDATE BENDING EMPLOYEE TASK STATUS
 * ========================================================= */
public function update_polishing_employee_task_status_v2(
    $task_id,
    $employee_id,
    $new_status,
    $remarks = ''
) {
    $task_id = (int)$task_id;
    $employee_id = (int)$employee_id;
    $new_status = trim($new_status);
    $remarks = trim($remarks);

    if (!$task_id || !$employee_id || $new_status === '') {
        return array(
            'status' => false,
            'message' => 'Invalid task or employee.'
        );
    }

    $task = $this->get_polishing_task_for_employee_v2(
        $task_id,
        $employee_id
    );

    if (!$task) {
        return array(
            'status' => false,
            'message' => 'Task not found or not assigned to you.'
        );
    }

    $old_status = trim($task->status);
    $old = strtolower($old_status);
    $new = strtolower($new_status);

    $allowed = array(
        'pending' => array('in progress'),
        'in progress' => array('hold', 'completed'),
        'hold' => array('in progress'),
        'rework' => array('in progress'),
        'qc rework' => array('in progress'),
        'rejected' => array('in progress')
    );

    if (!isset($allowed[$old]) || !in_array($new, $allowed[$old])) {
        return array(
            'status' => false,
            'message' => 'Invalid status transition from ' .
                         $old_status . ' to ' . $new_status . '.'
        );
    }

    if (($new === 'hold' || $new === 'completed') && $remarks === '') {
        return array(
            'status' => false,
            'message' => 'Note is required for Hold/Complete.'
        );
    }

    $now = date('Y-m-d H:i:s');

    $update = array(
        'status' => $new_status,
        'updated_at' => $now
    );

    if ($new === 'in progress' && empty($task->started_at)) {
        $update['started_at'] = $now;
    }

    if ($new === 'completed') {
        $update['completed_at'] = $now;
    }

    $this->db->trans_begin();

    $this->db
        ->where('task_id', $task_id)
        ->where('department_id', 11)
        ->where('assigned_employee_id', $employee_id)
        ->update('production_tasks', $update);

    $this->db->insert('production_task_status_history', array(
        'task_id' => $task_id,
        'old_status' => $old_status,
        'new_status' => $new_status,
        'remarks' => $remarks,
        'changed_by' => $employee_id,
        'changed_at' => $now
    ));

    if ($remarks !== '') {
        $note_type = 'General';

        if ($new === 'hold') {
            $note_type = 'Hold Reason';
        } elseif ($new === 'completed') {
            $note_type = 'Completion';
        } elseif (
            $new === 'in progress' &&
            in_array($old, array('rework', 'qc rework', 'rejected'))
        ) {
            $note_type = 'Rework';
        }

        $this->db->insert('production_task_notes', array(
            'task_id' => $task_id,
            'employee_id' => $employee_id,
            'note_type' => $note_type,
            'note' => $remarks,
            'added_by_role' => 'Employee',
            'created_at' => $now
        ));
    }

    if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();

        return array(
            'status' => false,
            'message' => 'Database error while updating task.'
        );
    }

    $this->db->trans_commit();

    return array(
        'status' => true,
        'message' => 'Task status updated successfully.'
    );
}

public function insert_polishing_employee_note_v2(
    $task_id,
    $employee_id,
    $note_type,
    $note
) {
    $task_id = (int)$task_id;
    $employee_id = (int)$employee_id;
    $note_type = trim($note_type);
    $note = trim($note);

    if (!$task_id || !$employee_id || $note === '') {
        return array(
            'status' => false,
            'message' => 'Invalid note data.'
        );
    }

    $employee = $this->get_polishing_employee_v2($employee_id);

    if (!$employee) {
        return array(
            'status' => false,
            'message' => 'Invalid Polishing employee.'
        );
    }

    $task = $this->get_polishing_task_for_employee_v2(
        $task_id,
        $employee_id
    );

    if (!$task) {
        return array(
            'status' => false,
            'message' => 'Task is not assigned to this employee.'
        );
    }

    $insert = $this->db->insert('production_task_notes', array(
        'task_id' => $task_id,
        'employee_id' => $employee_id,
        'note_type' => $note_type ?: 'General',
        'note' => $note,
        'added_by_role' => 'Employee',
        'created_at' => date('Y-m-d H:i:s')
    ));

    return $insert
        ? array('status' => true, 'message' => 'Work note saved successfully.')
        : array('status' => false, 'message' => 'Unable to save note.');
}

public function get_polishing_employee_status_history_v2($task_id)
{
    $this->db->select("
        h.task_id,
        h.old_status,
        h.new_status,
        h.remarks,
        h.changed_at
    ", false);

    $this->db->from(
        'production_task_status_history h'
    );

    $this->db->where(
        'h.task_id',
        (int) $task_id
    );

    $this->db->order_by(
        'h.changed_at',
        'DESC'
    );

    return $this->db->get()->result_array();
}


public function get_polishing_employee_timeline_v2($task_id)
{
    $timeline = array();

    $task_id = (int) $task_id;

    if (!$task_id) {
        return $timeline;
    }

   $this->db->select("
        'status' AS entry_type,
        h.task_id,
        h.old_status AS from_status,
        h.new_status AS to_status,
        h.remarks AS note,
        h.changed_at AS created_at,
        CAST(NULL AS CHAR) AS note_type,
        CAST(NULL AS CHAR) AS employee_name,
        CAST(NULL AS CHAR) AS added_by_role
    ", false);

    $this->db->from(
        'production_task_status_history h'
    );

    $this->db->where(
        'h.task_id',
        $task_id
    );

    $history = $this->db->get()->result();

    foreach ($history as $row) {
        $timeline[] = $row;
    }

    $this->db->select("
        'note' AS entry_type,
        n.task_id,
        CAST(NULL AS CHAR) AS from_status,
        CAST(NULL AS CHAR) AS to_status,
        n.note,
        n.created_at,
        n.note_type,
        em.employee_name,

        CASE
            WHEN em.designation_id = 22 THEN 'Supervisor'
            WHEN em.designation_id = 23 THEN 'Employee'
            ELSE 'Employee'
        END AS added_by_role
    ", false);

    $this->db->from(
        'production_task_notes n'
    );

    $this->db->join(
        'employee_master em',
        'em.employee_id = n.employee_id',
        'left'
    );

    $this->db->where(
        'n.task_id',
        $task_id
    );

    $notes = $this->db->get()->result();

    foreach ($notes as $row) {
        $timeline[] = $row;
    }

    usort(
        $timeline,
        function ($a, $b) {

            $timeA = !empty($a->created_at)
                ? strtotime($a->created_at)
                : 0;

            $timeB = !empty($b->created_at)
                ? strtotime($b->created_at)
                : 0;

            if ($timeA == $timeB) {
                return 0;
            }

            return ($timeA < $timeB) ? -1 : 1;
        }
    );

    return $timeline;
}

}
