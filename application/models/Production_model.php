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
    public function get_job_orders()
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
    public function save_job_order($header, $items)
    {
        $this->db->trans_start();

        $this->db->insert('job_order', $header);

        $job_order_id = $this->db->insert_id();

        foreach ($items as $item) {

            if (empty($item['selected'])) {
                continue;
            }

            $item_data = array(
                'job_order_id'     => $job_order_id,
                'project_item_id'  => $item['product_table_id'],
                'item_master_id'   => $item['item_master_id'],
                'item_code'        => $item['item_code'],
                'item_description' => $item['item_description'],
                'quantity'         => $item['quantity'],
                'unit'             => $item['unit']
            );

            $this->db->insert(
                'job_order_items',
                $item_data
            );
echo $this->db->last_query();exit;
            $job_order_item_id =
                $this->db->insert_id();


            /*
             * Get standard materials
             */
            $materials =
                $this->get_item_materials(
                    $item['item_master_id']
                );


            /*
             * Copy BOM to Job Order
             */
            foreach ($materials as $material) {

                $sql_unit = $this->db->query("select unit_id from unit_master where unit_abbr='$material->unit'");
                $qry = $sql_unit->row_array();

                $material_data = array(
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
                        $qry['unit_id'] ?? $material->unit,

                    'cost' =>
                        $material->cost,

                    'source' => 'BOM'
                );

                $this->db->insert(
                    'job_order_item_materials',
                    $material_data
                );
            }
        }

        $this->db->trans_complete();

        return $this->db->trans_status()
            ? $job_order_id
            : false;
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

            pi.product_id,
            pi.quantity,
            joi.cost,
            pi.total,

            p.product_name
        ')
        ->from('job_order_items joi')
        ->join(
            'project_items pi',
            'pi.id = joi.project_item_id',
            'left'
        )
        ->join(
            'item_master p',
            'p.product_id = pi.product_id',
            'left'
        )
        ->where(
            'joi.job_order_id',
            $job_order_id
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
            pi.total,

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
    // //joi.item_description,
    $sql = "
    SELECT 
        joi.job_order_item_id,
        joi.item_master_id,
        im.product_code,
        im.product_name as item_description,
       
        joi.quantity AS item_quantity,

        joim.job_order_material_id,
        joim.material_id,
        joim.material_code,
        joim.material_name,
        joim.quantity_required,

        joim.unit AS unit_id,
        um.unit_abbr AS unit,

        joim.cost,

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

    INNER JOIN item_master im
        ON im.product_id = joi.item_master_id

    INNER JOIN job_order_item_materials joim
        ON joim.job_order_item_id =
           joi.job_order_item_id

    LEFT JOIN unit_master um
        ON um.unit_id = joim.unit

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
        $previously_requested = (float) $item->previously_requested;
        $remaining =  $required - $previously_requested;
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
            pi.total,

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
            so_id, so_code,  so_date, grand_total, project_type
        ');
        $this->db->from('sales_order_master');
        $this->db->where('active', 1);
        $this->db->where('project_type', 0);
        $this->db->order_by('so_id', 'DESC');
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
    
}
