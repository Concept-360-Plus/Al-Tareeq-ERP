<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Production extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('Login/login');
        }

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->load->model('Users_model');
        $this->load->model('Project_model');
        $this->load->model('Production_model');
		$this->load->model('Product_model');
        $this->load->model('Sales_model'); 
        $this->load->model('Company_model');
        $this->load->model('Item_model');
        $this->load->model('Setup_model');
        
    }

    function production()
	{
		$data['title'] = "Production Details";
 		$prifix = 'PD' . date('y') . '';
		$this->load->model('Setup_model');
		$num = $this->Setup_model->get_next_code($prifix, 'p_code', 'project_production', 6) + 1;
		$digit = sprintf("%1$04d", $num);
		$code = $prifix . $digit;
		$data['code'] = $code;
		$data['products'] = $this->Project_model->get_product_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Production_model->get_production_list();
		$data['main_content'] = 'production/production_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_production_list()
	{
		$data['title'] = "Production Details List";
		$data['records'] = $this->Production_model->get_production_list_records();
		$data['main_content'] = 'production/production_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_production_details()
	{
		$data['title'] = " Add Production Details";
		$flag = $this->Production_model->add_production_details();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('production/view_production_list');
		} else {
			$this->session->set_flashdata('warning', 'Report Already Exist');
			redirect('Project/add_work_order');
		}
	}

	function edit_production()
	{
		$data['title'] = " Edit Production Details";
		$id = $this->uri->segment('3');
		$data['products'] = $this->Product_model->get_product_list();
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['records'] = $this->Production_model->get_production_list();

		$data['records1'] = $this->Production_model->transaction_production($id);
		$data['trans_records'] = $this->Production_model->get_production_tr_by_id_item($id);
		$data['product_route'] = $this->Project_model->get_product_extra_records($id);
		$data['attachment'] = $this->Project_model->get_attachment_records($id);
		$data['records2'] = $this->Production_model->get_wo_trans($id);
		$data['records3'] = $this->Production_model->get_wo_trans1($id);
		$data['main_content'] = 'production/production_edit.php';
		$this->load->view('includes/template', $data);
	}
	function update_production()
	{
		$data['title'] = "Update Production Details";
		$id = $this->input->post('production_id');
		$res = $this->Production_model->update_production_details($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Production/view_production_list');
		}
	}
	function delete_production()
	{
		$id = $this->uri->segment('3');
		$data['user_records'] = $this->Production_model->delete_production_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Production/view_production_list');
	}

	function qc_approve_production()
	{
		$data['title'] = 'QC Approve Production';
		$id = $this->uri->segment('3');
		$approve_id = $this->uri->segment('4');
		$this->load->model('Production_model');
		$this->Production_model->qc_approve_production($id,$approve_id);
		$this->session->set_flashdata('success', 'Record Approved Successfully..');
		redirect('Production/view_production_list');
	}
	function packing_approve_production()
	{
		$data['title'] = 'Packing Approve Production';
		$id = $this->uri->segment('3');

		$approve_id = $this->uri->segment('4');

		$this->load->model('Production_model');
		$this->Production_model->packing_approve_production($id,$approve_id);

		$this->session->set_flashdata('success', 'Record Approved Successfully..');
		redirect('Production/view_production_list');
	}	
	function transport_approve_production()
	{
		$data['title'] = 'Transport Approve Production';
		$id = $this->uri->segment('3');
		$approve_id = $this->uri->segment('4');
		$this->Production_model->transport_approve_production($id,$approve_id);
		$this->session->set_flashdata('success', 'Record Approved Successfully..');
		redirect('Production/view_production_list');
	}
	/// JOB ORDER 
	/*
     * Job Order Listing
     */
    public function job_order()
    {
        $user = $this->session->userdata('user_id');

        if (!has_view_access($user, 'Production/job_order')) {
            
            $data['title'] = 'Access Denied';
            $this->session->set_flashdata(
                'error',
                'You do not have permission to view Job Orders.'
            );
            $data['main_content'] = 'errors/access_control.php';
        } else {
            $data['title'] = "Job Orders";
            $data['job_orders'] = $this->Production_model->get_job_orders();
            $data['company'] =  $this->Setup_model->get_company_details();
            $data['main_content'] = 'job_order/list.php';
        }
		
		$this->load->view('includes/template', $data);
    }


    /*
     * Create Job Order
     */
    public function job_create()
    {
        $user = $this->session->userdata('user_id');

        if (!has_access($user, 'Production/job_order', 'A')) {

            $data['title'] = 'Access Denied';
            $data['main_content'] = 'errors/access_control.php';

        } else {

            $data['title'] = "Create Job Order";
            $data['projects'] = $this->Production_model->get_projects_job_order();
            $data['sales_orders'] =  $this->Production_model->get_sales_orders_job_order();
            $data['job_order_no'] =  $this->Production_model->generate_job_order_no();
            $data['user_records'] = $this->Project_model->get_active_users();
            $data['main_content'] = 'job_order/create.php';
        }

        $this->load->view('includes/template', $data);
    }
    /*
     * Get project items
     *
     * AJAX
     */
    public function get_project_items()
    {
        $project_id = $this->input->post('project_id');

        if (!$project_id) {
            echo json_encode(array());
            return;
        }
        $items = $this->Production_model->get_project_items($project_id);
        echo json_encode($items);
    }

    /*
     * Get BOM materials for an item
     *
     * AJAX
     */
    public function get_item_materials()
    {
        $item_master_id = $this->input->post('item_master_id');

        if (!$item_master_id) {
            echo json_encode(array());
            return;
        }

        $materials = $this->Production_model->get_item_materials($item_master_id);
        echo json_encode($materials);
    }


    /*
     * Save Job Order
     */
    public function job_save()
    {
        $project_id = $this->input->post('fk_project_id');

        $items = $this->input->post('items');

        if (!$project_id) {
            $this->session->set_flashdata(
                'error',
                'Please select project.'
            );
            redirect('job_order/create');
            return;
        }

        if (empty($items)) {
            $this->session->set_flashdata(
                'error',
                'Please select at least one item.'
            );
            redirect('job_order/create');
            return;
        }

        $job_order_data = array(
            'job_order_no'   => $this->input->post('job_order_no'),
            'fk_project_id'  => $project_id,
            'order_date'     => $this->input->post('order_date'),
            'order_no'       => $this->input->post('order_no'),
            'rep_name'       => $this->input->post('rep_name'),
            'contact_person' => $this->input->post('contact_person'),
            'remarks'        => $this->input->post('remarks'),
            'start_date'     => $this->input->post('start_date'),
            'finish_date'    => $this->input->post('finish_date'),
            'status'         => 'Pending'
        );
        $job_order_materials = $this->input->post('job_order_materials');

        if (!empty($job_order_materials)) {
            $job_order_materials = json_decode($job_order_materials, true);
        } else {
            $job_order_materials = array();
        }

       $job_order_id = $this->Production_model->save_job_order(
            $header,
            $items,
            $job_order_materials
        );
       
        if ($job_order_id) {
            $this->session->set_flashdata(
                'success',
                'Job Order created successfully.'
            );
            redirect('job_order/edit/' . $job_order_id);
        } else {
            $this->session->set_flashdata(
                'error',
                'Unable to create Job Order.'
            );
            redirect('job_order/create');
        }
    }


    /*
     * Edit Job Order
     */
    public function edit($job_order_id)
    {
         $user = $this->session->userdata('user_id');

        if (!has_access($user, 'Production/job_order', 'E')) {

            $data['title'] = 'Access Denied';
            $data['main_content'] = 'errors/access_control.php';
        } else {
            $data['title'] = "Edit Job Order";
            $data['job_order'] = $this->Production_model->get_job_order($job_order_id);
            if (!$data['job_order']) {
                show_404();
            }
            $data['projects'] = $this->Production_model->get_projects();
            $data['user_records'] = $this->Project_model->get_active_users();
            $data['items'] = $this->Production_model->get_job_order_items($job_order_id);
            $data['main_content'] = 'job_order/edit.php';
        }
		
        $this->load->view('includes/template', $data);
    }
    /*
     * Update Job Order
     */
    /*

    public function update()
{
    try {

        $this->db->trans_begin();

        $jobOrderId = $this->input->post('job_order_id');

        if (empty($jobOrderId)) {
            throw new Exception('Job Order ID is missing.');
        }

        $jobOrder = $this->db
            ->where('job_order_id', $jobOrderId)
            ->get('job_order')
            ->row();

        if (!$jobOrder) {
            throw new Exception('Job Order not found.');
        }

        $jobOrderType = (int)$jobOrder->job_order_type;

        

        $updateData = [

            'order_no' =>
                $this->input->post('order_no'),

            'contact_person' =>
                $this->input->post('contact_person'),

            'rep_name' =>
                $this->input->post('rep_name'),

            'start_date' =>
                $this->input->post('start_date'),

            'finish_date' =>
                $this->input->post('finish_date'),

            'remarks' =>
                $this->input->post('remarks')
        ];

       

        if ($jobOrderType === 1) {

            $projectId =
                $this->input->post('fk_project_id');

            if (empty($projectId)) {
                throw new Exception(
                    'Project is required.'
                );
            }

            $updateData['fk_project_id'] =
                $projectId;

           

            $updateData['fk_sales_order_id'] = null;

        } else {

            
            $salesOrderId =
                $this->input->post('sales_order_id');

            if (empty($salesOrderId)) {
                throw new Exception(
                    'Sales Order is required.'
                );
            }

            $updateData['fk_sales_order_id'] =
                $salesOrderId;

            $updateData['fk_project_id'] = null;
        }

       

        $this->db
            ->where('job_order_id', $jobOrderId)
            ->update(
                'job_order',
                $updateData
            );



        $this->db
            ->where('job_order_id', $jobOrderId)
            ->delete('job_order_sales_orders');



        if ($jobOrderType === 1) {

            $salesOrderIds =
                $this->input->post('sales_order_ids');

            if (
                empty($salesOrderIds)
                || !is_array($salesOrderIds)
            ) {

                throw new Exception(
                    'Please select at least one Sales Order.'
                );
            }

            foreach ($salesOrderIds as $salesOrderId) {

                $salesOrderId =
                    (int)$salesOrderId;

                if ($salesOrderId <= 0) {
                    continue;
                }

                $this->db->insert(
                    'job_order_sales_orders',
                    [
                        'job_order_id' =>
                            $jobOrderId,

                        'so_id' =>
                            $salesOrderId
                    ]
                );
            }

        }

       

        else {

            $salesOrderId =
                (int)$this->input->post(
                    'sales_order_id'
                );

            if ($salesOrderId <= 0) {
                throw new Exception(
                    'Sales Order is required.'
                );
            }

            $this->db->insert(
                'job_order_sales_orders',
                [
                    'job_order_id' =>
                        $jobOrderId,

                    'so_id' =>
                        $salesOrderId
                ]
            );
        }



        if ($this->db->trans_status() === FALSE) {

            throw new Exception(
                'Database update failed.'
            );
        }

        $this->db->trans_commit();

        echo json_encode([
            'status' => true,
            'message' =>
                'Job Order updated successfully.'
        ]);

    } catch (Exception $e) {

        $this->db->trans_rollback();

        echo json_encode([
            'status' => false,
            'message' =>
                $e->getMessage()
        ]);
    }
}
*/
public function update()
{
    try {

        $this->db->trans_begin();

        $jobOrderId = (int)$this->input->post('job_order_id');

        if ($jobOrderId <= 0) {
            throw new Exception('Job Order ID is missing.');
        }

        /* =========================================================
         * GET EXISTING JOB ORDER
         * ========================================================= */

        $jobOrder = $this->db
            ->where('job_order_id', $jobOrderId)
            ->get('job_order')
            ->row();

        if (!$jobOrder) {
            throw new Exception('Job Order not found.');
        }

        $jobOrderType = (int)$jobOrder->job_order_type;


        /* =========================================================
         * HEADER DATA
         * ========================================================= */

        $updateData = array(
            'order_no'       => $this->input->post('order_no'),
            'contact_person' => $this->input->post('contact_person'),
            'rep_name'       => $this->input->post('rep_name'),
            'start_date'     => $this->input->post('start_date'),
            'finish_date'    => $this->input->post('finish_date'),
            'remarks'        => $this->input->post('remarks'),
            'updated_at'     => date('Y-m-d H:i:s')
        );


        /* =========================================================
         * SALES ORDER / PROJECT
         * ========================================================= */

        $selectedSalesOrderIds = array();

        if ($jobOrderType === 1) {

            /* PROJECT JOB ORDER */

            $projectId = (int)$this->input->post('fk_project_id');

            if ($projectId <= 0) {
                throw new Exception('Project is required.');
            }

            $selectedSalesOrderIds =
                $this->input->post('sales_order_ids');

            if (
                empty($selectedSalesOrderIds)
                || !is_array($selectedSalesOrderIds)
            ) {
                throw new Exception(
                    'Please select at least one Sales Order.'
                );
            }

            /* Convert to integers and remove duplicates */

            $selectedSalesOrderIds = array_values(
                array_unique(
                    array_map(
                        'intval',
                        $selectedSalesOrderIds
                    )
                )
            );

            $selectedSalesOrderIds = array_filter(
                $selectedSalesOrderIds,
                function ($id) {
                    return $id > 0;
                }
            );

            if (empty($selectedSalesOrderIds)) {
                throw new Exception(
                    'Please select at least one Sales Order.'
                );
            }

            $updateData['fk_project_id'] = $projectId;
            $updateData['fk_sales_order_id'] = null;

        } else {

            /* NORMAL SALES ORDER JOB ORDER */

            $salesOrderId =
                (int)$this->input->post('sales_order_id');

            if ($salesOrderId <= 0) {
                throw new Exception('Sales Order is required.');
            }

            $selectedSalesOrderIds = array(
                $salesOrderId
            );

            $updateData['fk_sales_order_id'] =
                $salesOrderId;

            $updateData['fk_project_id'] = null;
        }


        /* =========================================================
         * UPDATE JOB ORDER HEADER
         * ========================================================= */

        $this->db
            ->where('job_order_id', $jobOrderId)
            ->update(
                'job_order',
                $updateData
            );


        /* =========================================================
         * UPDATE JOB ORDER ↔ SALES ORDER MAPPING
         * ========================================================= */

        $this->db
            ->where('job_order_id', $jobOrderId)
            ->delete('job_order_sales_orders');


        foreach ($selectedSalesOrderIds as $salesOrderId) {

            $this->db->insert(
                'job_order_sales_orders',
                array(
                    'job_order_id' => $jobOrderId,
                    'so_id'        => $salesOrderId
                )
            );
        }


        /* =========================================================
         * GET CURRENT JOB ORDER ITEMS
         * ========================================================= */

        $existingItems = $this->db
            ->select('
                job_order_item_id,
                so_id
            ')
            ->from('job_order_items')
            ->where(
                'job_order_id',
                $jobOrderId
            )
            ->get()
            ->result();


        /* =========================================================
         * REMOVE ITEMS WHOSE SALES ORDER WAS UNCHECKED
         *
         * IMPORTANT:
         * Delete materials first because they belong to
         * job_order_item_id.
         * ========================================================= */

        foreach ($existingItems as $existingItem) {

            if (
                !in_array(
                    (int)$existingItem->so_id,
                    $selectedSalesOrderIds,
                    true
                )
            ) {

                /* Delete materials */

                $this->db
                    ->where(
                        'job_order_item_id',
                        $existingItem->job_order_item_id
                    )
                    ->delete(
                        'job_order_item_materials'
                    );


                /* Delete job order item */

                $this->db
                    ->where(
                        'job_order_item_id',
                        $existingItem->job_order_item_id
                    )
                    ->delete(
                        'job_order_items'
                    );
            }
        }


        /* =========================================================
         * PROJECT JOB ORDER
         *
         * Reproduce missing items for newly checked SOs.
         * Existing items are NOT duplicated.
         * ========================================================= */

        if ($jobOrderType === 1) {

            foreach ($selectedSalesOrderIds as $salesOrderId) {

                /*
                 * Get Sales Order products
                 *
                 * project_item_id in job_order_items is
                 * sales_order_products.product_table_id
                 */

                $salesOrderItems = $this->db
                    ->select('
                        sop.product_table_id,
                        sop.product_id,
                        sop.quantity,
                        sop.unit_id,
                        sop.amount,
                        p.product_code,
                        p.product_name,
                        u.unit_abbr
                    ')
                    ->from(
                        'sales_order_products sop'
                    )
                    ->join(
                        'item_master p',
                        'p.product_id = sop.product_id',
                        'left'
                    )
                    ->join(
                        'unit_master u',
                        'u.unit_id = sop.unit_id',
                        'left'
                    )
                    ->where(
                        'sop.so_id',
                        $salesOrderId
                    )
                    ->get()
                    ->result();


                foreach ($salesOrderItems as $salesItem) {

                    /*
                     * Check whether this exact item already
                     * exists in this Job Order.
                     *
                     * so_id + project_item_id identifies
                     * the item.
                     */

                    $exists = $this->db
                        ->where(
                            'job_order_id',
                            $jobOrderId
                        )
                        ->where(
                            'so_id',
                            $salesOrderId
                        )
                        ->where(
                            'project_item_id',
                            $salesItem->product_table_id
                        )
                        ->count_all_results(
                            'job_order_items'
                        );

                    if ($exists > 0) {
                        continue;
                    }


                    /* =================================================
                     * INSERT MISSING JOB ORDER ITEM
                     * ================================================= */

                    $this->db->insert(
                        'job_order_items',
                        array(
                            'job_order_id' =>
                                $jobOrderId,

                            'project_item_id' =>
                                $salesItem->product_table_id,

                            'so_id' =>
                                $salesOrderId,

                            'item_master_id' =>
                                $salesItem->product_id,

                            'item_code' =>
                                $salesItem->product_code,

                            'item_description' =>
                                $salesItem->product_name,

                            'quantity' =>
                                $salesItem->quantity,

                            'cost' =>
                                $salesItem->amount,

                            'unit' =>
                                $salesItem->unit_abbr
                        )
                    );
                }
            }

        } else {

            /* =========================================================
             * NORMAL JOB ORDER
             *
             * Keep the existing items.
             * ========================================================= */

            /*
             * Nothing needs to be rebuilt here because a normal
             * Job Order belongs to one Sales Order.
             */
        }


        /* =========================================================
         * CHECK TRANSACTION
         * ========================================================= */

        if ($this->db->trans_status() === FALSE) {

            throw new Exception(
                'Database update failed.'
            );
        }


        /* =========================================================
         * COMMIT
         * ========================================================= */

        $this->db->trans_commit();


        echo json_encode(
            array(
                'status' => true,
                'message' =>
                    'Job Order updated successfully.'
            )
        );

    } catch (Exception $e) {

        $this->db->trans_rollback();

        echo json_encode(
            array(
                'status' => false,
                'message' => $e->getMessage()
            )
        );
    }
}
    /*
     * Delete Job Order
     */
    public function delete($job_order_id)
    {
        $user = $this->session->userdata('user_id');

        if (!has_access($user, 'Production/job_order', 'D')) {
            $data['title'] = 'Access Denied';
            $data['main_content'] = 'errors/access_control.php';
        } else {
    
        $result =
            $this->Production_model->delete_job_order($job_order_id);

        if ($result['status']==true) {

            $this->session->set_flashdata(
                'success',
                'Job Order deleted successfully.'
            );

        } else {
            
            $msg = $result['message'];

            $this->session->set_flashdata(
                'error',
                 $msg
            );
        }

        redirect('Production/job_order');
        }
    }


    /*
     * Add material manually
     */
    public function add_material()
    {
        $data = array(
            'job_order_item_id' => $this->input->post('job_order_item_id'),
            'material_id'       => $this->input->post('material_id'),
            'material_code'     => $this->input->post('material_code'),
            'material_name'     => $this->input->post('material_name'),
            'quantity_required' => $this->input->post('quantity_required'),
            'unit'              => $this->input->post('unit'),
            'cost'              => $this->input->post('cost'),
            'source'            => 'MANUAL'
        );

        $id = $this->Production_model->add_material($data);

        echo json_encode(array(
            'status' => $id ? true : false,
            'id'     => $id
        ));
    }


    /*
     * Delete Job Order Material
     */
    public function delete_material()
    {
        $id = $this->input->post('job_order_material_id');

        $result =
            $this->Production_model->delete_material($id);

        echo json_encode(array(
            'status' => $result
        ));
    }

	public function get_raw_materials()
	{
		$materials = $this->Production_model->get_raw_materials();

		echo json_encode($materials);
	}
	public function get_units()
	{
		$units = $this->Production_model->get_units();

		echo json_encode($units);
	}

public function save_job_order()
{
    try {

        $this->db->trans_begin();

        // =============================================
        // 1. GET JOB ORDER TYPE
        // =============================================

        $jobOrderType = (int)$this->input->post('job_order_type');

        $projectId    = null;
        $salesOrderId = null;


        // =============================================
        // 2. VALIDATE TYPE
        // =============================================

        if ($jobOrderType === 1) {

            // PROJECT JOB ORDER

            $projectId = $this->input->post('fk_project_id');

            if (empty($projectId)) {
                throw new Exception('Please select a project.');
            }

        } else {

            // NORMAL SALES ORDER JOB ORDER

            $salesOrderId = $this->input->post('sales_order_id');

            if (empty($salesOrderId)) {
                throw new Exception('Please select a sales order.');
            }
        }


        // =============================================
        // 3. JOB ORDER HEADER
        // =============================================

        $jobOrderData = [

            'job_order_no'     => $this->input->post('job_order_no'),

            'job_order_type'   => $jobOrderType,

            'fk_project_id'    => $projectId,

            'fk_sales_order_id' => $salesOrderId,

            'order_date'       => $this->input->post('order_date'),

            'order_no'         => $this->input->post('order_no'),

            'rep_name'         => $this->input->post('rep_name'),

            'contact_person'   => $this->input->post('contact_person'),

            'remarks'          => $this->input->post('remarks'),

            'start_date'       => $this->input->post('start_date'),

            'finish_date'      => $this->input->post('finish_date')
        ];


        // =============================================
        // 4. INSERT JOB ORDER
        // =============================================

        $jobOrderId = $this->Production_model
            ->insert_job_order($jobOrderData);


        if (!$jobOrderId) {
            throw new Exception('Failed to create Job Order.');
        }


        // =============================================
        // 5. SAVE SALES ORDER MAPPING
        // =============================================

        if ($jobOrderType === 1) {

            // PROJECT JOB ORDER
            // Multiple Sales Orders

            $salesOrderIds = $this->input->post('sales_order_ids');

            if (
                empty($salesOrderIds) ||
                !is_array($salesOrderIds)
            ) {
                throw new Exception(
                    'Please select at least one Sales Order for the project.'
                );
            }

            foreach ($salesOrderIds as $mappedSalesOrderId) {

                $mappedSalesOrderId = (int)$mappedSalesOrderId;

                if ($mappedSalesOrderId <= 0) {
                    continue;
                }

                $mappingData = [

                    'job_order_id' => $jobOrderId,

                    'so_id' => $mappedSalesOrderId
                ];

                $savedMapping =
                    $this->Production_model
                        ->insert_job_order_sales_order(
                            $mappingData
                        );

                if (!$savedMapping) {

                    throw new Exception(
                        'Failed to save Sales Order mapping.'
                    );
                }
            }

        } else {

            // NORMAL SALES ORDER JOB ORDER
            // Single Sales Order

            $mappingData = [

                'job_order_id' => $jobOrderId,

                'so_id' => $salesOrderId
            ];

            $savedMapping =
                $this->Production_model
                    ->insert_job_order_sales_order(
                        $mappingData
                    );

            if (!$savedMapping) {

                throw new Exception(
                    'Failed to save Sales Order mapping.'
                );
            }
        }


        // =============================================
        // 6. GET ITEMS
        // =============================================

        $items = $this->input->post('items');

        if (
            empty($items) ||
            !is_array($items)
        ) {
            throw new Exception(
                'Please select at least one item.'
            );
        }


        // =============================================
        // 7. GET MATERIALS
        // =============================================

        $materialsJson =
            $this->input->post('job_order_materials');

        $jobOrderMaterials = [];

        if (!empty($materialsJson)) {

            $jobOrderMaterials = json_decode(
                $materialsJson,
                true
            );

            if (!is_array($jobOrderMaterials)) {
                $jobOrderMaterials = [];
            }
        }


        // =============================================
        // 8. SAVE JOB ORDER ITEMS
        // =============================================

        foreach ($items as $item) {

            // -----------------------------------------
            // PROJECT ITEM
            // -----------------------------------------

            $projectItemId = !empty(
                $item['product_table_id']
            )
                ? (int)$item['product_table_id']
                : null;


            // -----------------------------------------
            // ITEM MASTER
            // -----------------------------------------

            $itemMasterId = !empty(
                $item['item_master_id']
            )
                ? (int)$item['item_master_id']
                : null;


            if (empty($itemMasterId)) {

                throw new Exception(
                    'Item master ID is missing.'
                );
            }


            // =========================================
            // DETERMINE SALES ORDER FOR THIS ITEM
            // =========================================

            if ($jobOrderType === 1) {

                // PROJECT JOB ORDER
                // Every item MUST belong to an SO

                $itemSalesOrderId = !empty(
                    $item['so_id']
                )
                    ? (int)$item['so_id']
                    : 0;


                if ($itemSalesOrderId <= 0) {

                    throw new Exception(
                        'Sales Order is missing for item: ' .
                        (
                            !empty($item['item_description'])
                                ? $item['item_description']
                                : $itemMasterId
                        )
                    );
                }

            } else {

                // NORMAL JOB ORDER

                $itemSalesOrderId = (int)$salesOrderId;
            }


            // =========================================
            // INSERT JOB ORDER ITEM
            // =========================================

            $itemData = [

                'job_order_id' => $jobOrderId,

                'project_item_id' => $projectItemId,

                // IMPORTANT
                'so_id' => $itemSalesOrderId,

                'item_master_id' => $itemMasterId,

                'item_description' => isset(
                    $item['item_description']
                )
                    ? $item['item_description']
                    : '',

                'item_code' => isset(
                    $item['item_code']
                )
                    ? $item['item_code']
                    : '',

                'quantity' => isset(
                    $item['quantity']
                )
                    ? $item['quantity']
                    : 0,

                'unit' => isset(
                    $item['unit']
                )
                    ? $item['unit']
                    : '',

                'cost' => isset(
                    $item['retail_price']
                )
                    ? $item['retail_price']
                    : 0
            ];


            $jobOrderItemId =
                $this->Production_model
                    ->insert_job_order_item(
                        $itemData
                    );


            if (!$jobOrderItemId) {

                throw new Exception(
                    'Failed to save job order item.'
                );
            }


            // =========================================
            // 9. FIND MATERIALS
            // =========================================

            $materials = [];


            // -----------------------------------------
            // PROJECT ITEM MATERIALS
            // -----------------------------------------

            if (
                !empty($projectItemId) &&
                isset(
                    $jobOrderMaterials[$projectItemId]
                ) &&
                is_array(
                    $jobOrderMaterials[$projectItemId]
                )
            ) {

                $materials =
                    $jobOrderMaterials[$projectItemId];
            }


            // -----------------------------------------
            // NORMAL SO ITEM MATERIALS
            // -----------------------------------------

            elseif (
                !empty($itemMasterId) &&
                isset(
                    $jobOrderMaterials[$itemMasterId]
                ) &&
                is_array(
                    $jobOrderMaterials[$itemMasterId]
                )
            ) {

                $materials =
                    $jobOrderMaterials[$itemMasterId];
            }


            // =========================================
            // 10. SAVE MATERIALS
            // =========================================

            if (!empty($materials)) {

                foreach ($materials as $material) {

                    // ---------------------------------
                    // MATERIAL ID
                    // ---------------------------------

                    $materialId = !empty(
                        $material['material_id']
                    )
                        ? (int)$material['material_id']
                        : null;


                    if (empty($materialId)) {
                        continue;
                    }


                    // ---------------------------------
                    // SOURCE
                    // ---------------------------------

                    $source = !empty(
                        $material['source']
                    )
                        ? $material['source']
                        : 'BOM';


                    // ---------------------------------
                    // GET COST
                    // ---------------------------------

                    $cost = 0;


                    if ($source === 'BOM') {

                        $materialRow = $this->db
                            ->select('cost')
                            ->from('amc_product_materials')
                            ->where(
                                'material_id',
                                $materialId
                            )
                            ->get()
                            ->row();

                    } else {

                        $materialRow = $this->db
                            ->select('cost')
                            ->from('amc_raw_materials')
                            ->where(
                                'material_id',
                                $materialId
                            )
                            ->get()
                            ->row();
                    }


                    if ($materialRow) {

                        $cost = !empty(
                            $materialRow->cost
                        )
                            ? $materialRow->cost
                            : 0;
                    }


                    // ---------------------------------
                    // QUANTITY
                    // ---------------------------------

                    $quantityRequired =
                        isset(
                            $material['quantity_required']
                        )
                            ? $material['quantity_required']
                            : 0;


                    // ---------------------------------
                    // INSERT MATERIAL
                    // ---------------------------------

                    $materialData = [

                        'job_order_item_id' =>
                            $jobOrderItemId,

                        'project_item_id' =>
                            $projectItemId,

                        'material_id' =>
                            $materialId,

                        'material_code' =>
                            isset(
                                $material['material_code']
                            )
                                ? $material['material_code']
                                : '',

                        'material_name' =>
                            isset(
                                $material['material_name']
                            )
                                ? $material['material_name']
                                : '',

                        'unit' =>
                            isset(
                                $material['unit']
                            )
                                ? $material['unit']
                                : '',

                        'unit_id' =>
                            isset(
                                $material['unit_id']
                            )
                                ? $material['unit_id']
                                : null,

                        'quantity_required' =>
                            $quantityRequired,

                        'cost' => $cost,

                        'source' => $source
                    ];


                    $savedMaterial =
                        $this->Production_model
                            ->insert_job_order_material(
                                $materialData
                            );


                    if (!$savedMaterial) {

                        throw new Exception(
                            'Failed to save material.'
                        );
                    }
                }
            }
        }


        // =============================================
        // 11. TRANSACTION CHECK
        // =============================================

        if ($this->db->trans_status() === FALSE) {

            throw new Exception(
                'Database transaction failed.'
            );
        }


        // =============================================
        // 12. COMMIT
        // =============================================

        $this->db->trans_commit();


        // =============================================
        // 13. SUCCESS
        // =============================================

        echo json_encode([

            'status' => true,

            'message' =>
                'Job Order created successfully.',

            'job_order_id' =>
                $jobOrderId
        ]);

    } catch (Exception $e) {

        $this->db->trans_rollback();

        echo json_encode([

            'status' => false,

            'message' => $e->getMessage()
        ]);
    }
}



public function save_job_order_item_materials()
{
    $project_item_id = $this->input->post('project_item_id');
    $job_order_id    = $this->input->post('job_order_id');

    $materials = json_decode(
        $this->input->post('materials'),
        true
    );

    /*
     * Validate Project Item
     */
    if (!$project_item_id) {

        echo json_encode([
            'status'  => false,
            'message' => 'Project item not found.'
        ]);

        return;
    }

    /*
     * Validate Materials
     */
    if (empty($materials) || !is_array($materials)) {

        echo json_encode([
            'status'  => false,
            'message' => 'No materials found.'
        ]);

        return;
    }

    /*
     * Find Job Order Item
     *
     * project_item_id = sales_order_products.product_table_id
     */
    $job_order_item = $this->Production_model->get_job_order_item(
        $job_order_id,
        $project_item_id
    );

    if (!$job_order_item) {

        echo json_encode([
            'status'  => false,
            'message' => 'Job Order item not found.'
        ]);

        return;
    }

    /*
     * Start Transaction
     */
    $this->db->trans_start();

    /*
     * Delete existing materials
     *
     * This allows the user to edit the material list.
     */
    $this->Production_model->delete_job_order_item_materials(
        $job_order_item->job_order_item_id
    );

    /*
     * Insert current materials
     */
    foreach ($materials as $material) {

        /*
         * Material ID
         */
        $material_id = !empty($material['material_id'])
            ? $material['material_id']
            : null;

        /*
         * Material Code
         */
        $material_code = isset($material['material_code'])
            ? trim($material['material_code'])
            : null;

        /*
         * Material Name
         */
        $material_name = isset($material['material_name'])
            ? trim($material['material_name'])
            : '';

        /*
         * Quantity
         */
        $quantity_required = isset($material['quantity_required'])
            ? (float)$material['quantity_required']
            : 0;

        /*
         * Unit
         */
        $unit = isset($material['unit'])
            ? trim($material['unit'])
            : null;

        /*
         * Source
         *
         * BOM / MANUAL
         */
        $source = isset($material['source'])
            ? strtoupper(trim($material['source']))
            : 'MANUAL';

        /*
         * Cost
         *
         * Cost comes from the material data already selected
         * from amc_raw_materials / BOM.
         */
        $cost = isset($material['cost'])
            ? (float)$material['cost']
            : 0;

        /*
         * Validate material name
         */
        if ($material_name == '') {
            continue;
        }

        /*
         * Validate quantity
         */
        if ($quantity_required <= 0) {
            continue;
        }

        /*
         * If cost is not posted, get it from amc_raw_materials
         */
        if ($cost <= 0 && !empty($material_id)) {

            $raw_material = $this->db
                ->select('cost')
                ->where('material_id', $material_id)
                ->get('amc_raw_materials')
                ->row();

            if ($raw_material) {
                $cost = (float)$raw_material->cost;
            }
        }

        /*
         * Prepare Job Order Material
         */
        $data = [
            'job_order_item_id' => $job_order_item->job_order_item_id,

            'project_item_id'   => $project_item_id,

            'material_id'       => $material_id,

            'material_code'     => $material_code,

            'material_name'     => $material_name,

            'quantity_required' => $quantity_required,

            'unit'              => $unit,

            'cost'              => $cost,

            'source'            => $source
        ];

        /*
         * Insert
         */
        $insert_id = $this->Production_model
            ->insert_job_order_material($data);

        /*
         * Stop transaction if insert failed
         */
        if (!$insert_id) {

            $this->db->trans_rollback();

            echo json_encode([
                'status'  => false,
                'message' => 'Failed to insert material: ' . $material_name
            ]);

            return;
        }
    }

    /*
     * Complete Transaction
     */
    $this->db->trans_complete();

    /*
     * Check Transaction Status
     */
    if ($this->db->trans_status() === FALSE) {

        echo json_encode([
            'status'  => false,
            'message' => 'Unable to save materials.'
        ]);

        return;
    }

    /*
     * Success
     */
    echo json_encode([
        'status'  => true,
        'message' => 'Materials saved successfully.'
    ]);
}


        //// EDIT JOB ORDER
public function edit_job_order($job_order_id)
{
        $user = $this->session->userdata('user_id');

        if (!has_access($user, 'Production/job_order', 'E')) {

            $data['title'] = 'Access Denied';
            $data['main_content'] = 'errors/access_control.php';

        } else {

            $data['title'] = "Edit Job Order";

            // Get Job Order
            $data['job_order'] = $this->Production_model->get_job_ordere($job_order_id);

            if (!$data['job_order']) {
                show_404();
                return;
            }

            // Active users
            $data['user_records'] = $this->Project_model->get_active_users();

            /*
            * NORMAL SALES ORDER JOB ORDER
            */
            if (
                isset($data['job_order']->job_order_type) &&
                (int)$data['job_order']->job_order_type === 0
            ) {
                $data['sales_order'] = null;

                if (!empty($data['job_order']->fk_sales_order_id)) {

                    $data['sales_order'] =
                        $this->Production_model->get_sales_order_by_id(
                            $data['job_order']->fk_sales_order_id
                        );
                }

                $data['sales_orders'] = array();
                $data['project'] = array();
            }

            /*
            * PROJECT JOB ORDER
            */
            elseif (
                isset($data['job_order']->job_order_type) &&
                (int)$data['job_order']->job_order_type === 1
            ) {
                $projectId = $data['job_order']->fk_project_id;

                // Project Sales Orders
                $data['sales_orders'] =$this->Production_model->get_sales_orders_job_order_project(
                        $projectId
                    );

                // Project details
                $data['project'] =
                    $this->Project_model->get_project_details(
                        $projectId
                    );

                // Existing selected project SO mappings
                $data['job_order_sales_orders'] =
                    $this->Production_model->get_job_order_sales_order_ids(
                        $job_order_id
                    );

                // Normal SO not required
                $data['sales_order'] = null;
            }

            /*
            * Job Order Items
            */
            $data['job_order_items'] = $this->Production_model->get_job_order_itemse($job_order_id);

            /*
            * Load materials for each Job Order Item
            */
            foreach ($data['job_order_items'] as &$item) {

                $item->materials =
                    $this->Production_model->get_job_order_item_materials(
                        $item->job_order_item_id
                    );
            }

            unset($item);

            /*
            * Raw Material Dropdown
            */
            $data['raw_materials'] =
                $this->Production_model->get_raw_materialse();

            /*
            * Unit Dropdown
            */
            $data['units'] =
                $this->Production_model->get_units();

            /*
            * Load Edit View
            */
            $data['main_content'] = 'job_order/edit.php';

            $this->load->view('includes/template', $data);
    }
}
    public function save_job_order_item_materialse()
{
    $job_order_item_id =
        $this->input->post(
            'job_order_item_id'
        );

    $project_item_id =
        $this->input->post(
            'project_item_id'
        );

    $materials =
        json_decode(
            $this->input->post(
                'materials'
            ),
            true
        );


    if (!$job_order_item_id) {

        echo json_encode([
            'status' => false,
            'message' =>
                'Job Order Item ID is missing.'
        ]);

        return;
    }


    if (!$project_item_id) {

        echo json_encode([
            'status' => false,
            'message' =>
                'Project Item ID is missing.'
        ]);

        return;
    }


    $this->db->trans_start();


    /*
     * Delete current materials
     *
     * Then insert the complete current list.
     *
     * This makes editing much simpler.
     */

    $this->Production_model
         ->delete_job_order_item_materials(
             $job_order_item_id
         );


    if (!empty($materials)) {

        foreach (
            $materials as $material
        ) {

            $insertData = [

                'job_order_item_id' =>
                    $job_order_item_id,

                'project_item_id' =>
                    $project_item_id,

                'material_id' =>
                    !empty(
                        $material['material_id']
                    )
                    ? $material['material_id']
                    : null,

                'material_code' =>
                    isset(
                        $material['material_code']
                    )
                    ? $material['material_code']
                    : null,

                'material_name' =>
                    $material['material_name'],

                'quantity_required' =>
                    $material[
                        'quantity_required'
                    ],

                'unit' =>
                    isset(
                        $material['unit']
                    )
                    ? $material['unit']
                    : null,

                'cost' =>
                    isset(
                        $material['cost']
                    )
                    ? $material['cost']
                    : 0,

                'source' =>
                    isset(
                        $material['source']
                    )
                    ? $material['source']
                    : 'MANUAL',

                'updated_at' =>
                    date('Y-m-d H:i:s')

            ];


            $this->Production_model->insert_job_order_material(
                     $insertData
                 );

        }

    }
    $this->db->trans_complete();
    if (
        $this->db->trans_status() === FALSE
    ) {

        echo json_encode([
            'status' => false,
            'message' =>
                'Unable to save materials.'
        ]);

        return;
    }


    echo json_encode([
        'status' => true,
        'message' =>
            'Materials saved successfully.'
    ]);
}
    
public function print_job_order($job_order_id)
{
    
    if (!$job_order_id) {
        show_error('Invalid Job Order.');
        return;
    }
    
    /*
     * Job Order details
     */
    $job_order = $this->Production_model->get_job_order_print($job_order_id);

    if (!$job_order) {
        show_error('Job Order not found.');
        return;
    }
    $job_order_items = $this->Production_model->get_job_order_items_print($job_order_id);
    foreach ($job_order_items as &$item) {
        $item->materials = $this->Production_model->get_job_order_item_materials_print($item->job_order_item_id);
    }
    unset($item);
    $data = array(

        'job_order' =>
            $job_order,

        'job_order_items' =>
            $job_order_items

    );
    $data['title']  = "Print Job Order";
    $this->load->model('Setup_model');
    $data['company'] = $this->Setup_model->get_company_details();
    $data['main_content'] = 'job_order/job_order_print.php';
    $this->load->view('includes/template', $data);
}

    /*
     * Warehouse listing
     */
    public function warehouses()
    {
        $data['title'] = "Warehouses";
        $data['warehouses'] = $this->Production_model->get_warehouses();
        $data['main_content'] = 'production/warehouses.php';
        $this->load->view('includes/template', $data);
        
    }
    /*
     * Add warehouse
     */
    public function add_warehouse()
    {
        $data = array(

            'name' =>
                trim($this->input->post('name')),

            'code' =>
                trim($this->input->post('code')),

            'status' =>
                $this->input->post('status') ? 1 : 0
        );


        if ($data['name'] == '') {

            $this->session->set_flashdata(
                'error',
                'Warehouse name is required.'
            );

            redirect('/Production/warehouses');

            return;
        }


        if ($data['code'] == '') {

            $this->session->set_flashdata(
                'error',
                'Warehouse code is required.'
            );

            redirect('/Production/warehouses');

            return;
        }


        /*
         * Check duplicate code
         */
        if (
            $this->Production_model->warehouse_code_exists(
                     $data['code']
                 )
        ) {

            $this->session->set_flashdata(
                'error',
                'Warehouse code already exists.'
            );

            redirect('/Production/warehouses');

            return;
        }


        $result =
            $this->Production_model
                 ->insert_warehouse($data);


        if ($result) {

            $this->session->set_flashdata(
                'success',
                'Warehouse added successfully.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Unable to add warehouse.'
            );
        }


        redirect('/Production/warehouses');
    }


    /*
     * Edit warehouse page
     */
    public function edit_warehouse($wa_id)
    {
        $warehouse = $this->Production_model->get_warehouse($wa_id);
        $data['title'] = 'Edit Warehouse';
        if (!$warehouse) {

            show_404();

            return;
        }


        $data['warehouse'] =  $warehouse;
        $data['main_content'] = 'production/edit_warehouse.php';
        $this->load->view('includes/template', $data);
    }


    /*
     * Update warehouse
     */
    public function update_warehouse()
    {
        $wa_id =
            $this->input->post('wa_id');


        if (!$wa_id) {

            $this->session->set_flashdata(
                'error',
                'Invalid warehouse.'
            );

            redirect('/Production/warehouses');

            return;
        }


        $data = array(

            'name' =>
                trim($this->input->post('name')),

            'code' =>
                trim($this->input->post('code')),

            'status' =>
                $this->input->post('status') ? 1 : 0
        );


        if ($data['name'] == '') {

            $this->session->set_flashdata(
                'error',
                'Warehouse name is required.'
            );

            redirect(
                '/Production/edit_warehouse/' . $wa_id
            );

            return;
        }


        /*
         * Check duplicate code
         * excluding current warehouse
         */
        if (
            $this->Production_model
                 ->warehouse_code_exists(
                     $data['code'],
                     $wa_id
                 )
        ) {

            $this->session->set_flashdata(
                'error',
                'Warehouse code already exists.'
            );

            redirect(
                '/Production/edit_warehouse/' . $wa_id
            );

            return;
        }


        $result =
            $this->Production_model
                 ->update_warehouse(
                     $wa_id,
                     $data
                 );


        if ($result) {

            $this->session->set_flashdata(
                'success',
                'Warehouse updated successfully.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Unable to update warehouse.'
            );
        }


        redirect('/Production/warehouses');
    }


    /*
     * Delete warehouse
     */
    public function delete_warehouse($wa_id)
    {
        if (!$wa_id) {

            $this->session->set_flashdata(
                'error',
                'Invalid warehouse.'
            );

            redirect('/Production/warehouses');

            return;
        }


        $result =  $this->Production_model->delete_warehouse($wa_id);


        if ($result) {

            $this->session->set_flashdata(
                'success',
                'Warehouse deleted successfully.'
            );

        } else {

            $this->session->set_flashdata(
                'error',
                'Unable to delete warehouse.'
            );
        }


        redirect('/Production/warehouses');
    }

    public function job_completion()
    {
        $data['title'] = "Job order Completion";
        $data['job_orders'] = $this->Production_model->get_job_orders_for_completion();
        $data['job_completion_no'] = $this->Production_model->generate_job_completion_no();
        $data['main_content'] = 'production/job_completion.php';
        $this->load->view('includes/template', $data);
        
    }
    public function get_job_order_for_completion()
    {
        $job_order_id =
            $this->input->post('job_order_id');

        if (!$job_order_id) {

            echo json_encode([
                'status' => false,
                'message' => 'Job Order is required.'
            ]);

            return;
        }

        $job_order =
            $this->Production_model->get_job_order_for_completion(
                    $job_order_id
                );

        if (!$job_order) {

            echo json_encode([
                'status' => false,
                'message' => 'Job Order not found.'
            ]);

            return;
        }

        echo json_encode([
            'status' => true,
            'job_order' => $job_order
        ]);
    }

    public function get_remaining_job_order_items()
    {
        $job_order_id = $this->input->post('job_order_id');
        if (!$job_order_id) {

            echo json_encode([
                'status' => false,
                'message' => 'Job Order is required.'
            ]);

            return;
        }
        $items = $this->Production_model->get_remaining_job_order_items($job_order_id);
        echo json_encode([
            'status' => true,
            'items' => $items
        ]);
    }

    public function save_job_completion()
{
    $job_order_id = $this->input->post('job_order_id');
    $completion_date = $this->input->post('completion_date');
    $remarks = $this->input->post('remarks');
    $items_json = $this->input->post('items');
    if (!$job_order_id) {
        echo json_encode([
            'status' => false,
            'message' => 'Job Order is required.'
        ]);
        return;
    }
    if (!$completion_date) {
        echo json_encode([
            'status' => false,
            'message' => 'Completion date is required.'
        ]);
        return;
    }
    $items = json_decode(
            $items_json,
            true
        );
    if (
        !is_array($items) ||
        empty($items)
    ) {

        echo json_encode([
            'status' => false,
            'message' => 'Please select at least one item.'
        ]);

        return;
    }


    $this->db->trans_begin();


    /*
     * Generate completion number
     */
    $completion_no =  $this->Production_model->generate_job_completion_no();


    /*
     * Header
     */
    $header = [

        'job_completion_no' =>
            $completion_no,

        'job_order_id' =>
            $job_order_id,

        'completion_date' =>
            $completion_date,

        'remarks' =>
            $remarks
    ];


    $this->db->insert(
        'job_completion',
        $header
    );


    $job_completion_id = $this->db->insert_id();
    /*
     * Items
     */
    foreach ($items as $item) {

        $job_order_item_id = isset($item['job_order_item_id'])
                ? $item['job_order_item_id']
                : 0;


        $completed_qty =
            isset($item['completed_quantity'])
                ? (float)$item['completed_quantity']
                : 0;


        if (
            !$job_order_item_id ||
            $completed_qty <= 0
        ) {

            $this->db->trans_rollback();

            echo json_encode([
                'status' => false,
                'message' =>
                    'Invalid completed item quantity.'
            ]);

            return;
        }


        /*
         * Get original item
         */
        $job_item =  $this->Production_model->get_job_order_item_completion(
                     $job_order_item_id
                 );


        if (!$job_item) {

            $this->db->trans_rollback();

            echo json_encode([
                'status' => false,
                'message' =>
                    'Job Order item not found.'
            ]);

            return;
        }


        /*
         * Already completed
         */
        $previously_completed =
            $this->Production_model
                 ->get_completed_quantity(
                     $job_order_item_id
                 );


        $ordered_quantity =
            (float)$job_item->ordered_quantity;


        $remaining_quantity =
            $ordered_quantity -
            $previously_completed;


        /*
         * Do not allow over completion
         */
        if (
            $completed_qty >
            $remaining_quantity
        ) {

            $this->db->trans_rollback();

            echo json_encode([
                'status' => false,
                'message' =>
                    'Completed quantity for ' .
                    $job_item->product_name .
                    ' cannot exceed remaining quantity (' .
                    $remaining_quantity .
                    ').'
            ]);

            return;
        }


        $new_remaining =
            $remaining_quantity -
            $completed_qty;


        $item_data = [

            'job_completion_id' =>
                $job_completion_id,

            'job_order_item_id' =>
                $job_order_item_id,

            'project_item_id' =>
                $job_item->project_item_id,

            'ordered_quantity' =>
                $ordered_quantity,

            'previously_completed' =>
                $previously_completed,

            'completed_quantity' =>
                $completed_qty,

            'remaining_quantity' =>
                $new_remaining
        ];


        $this->db->insert(
            'job_completion_items',
            $item_data
        );
    }


    if (
        $this->db->trans_status() === false
    ) {

        $this->db->trans_rollback();

        echo json_encode([
            'status' => false,
            'message' =>
                'Unable to save Job Completion.'
        ]);

        return;
    }


    $this->db->trans_commit();


    echo json_encode([
        'status' => true,
        'message' =>
            'Job Completion saved successfully.',
        'job_completion_id' =>
            $job_completion_id,
        'job_completion_no' =>
            $completion_no
    ]);
}
public function get_job_order_details()
{
    $job_order_id = $this->input->post('job_order_id');
    if (!$job_order_id) {
        echo json_encode([
            'status'  => false,
            'message' => 'Job Order is required.'
        ]);
        return;
    }
    $job_order =  $this->Production_model->get_job_order_details($job_order_id);
    if (!$job_order) {

        echo json_encode([
            'status'  => false,
            'message' => 'Job Order not found.'
        ]);

        return;
    }
    echo json_encode([
        'status'    => true,
        'job_order' => $job_order
    ]);
}
// LIST COMPLETION 
public function job_completions()
{
    $data['title'] = "Job Completion List";
    $data['job_completions'] = $this->Production_model->get_job_completions();
    $this->load->model('Setup_model');
    $data['company'] =  $this->Setup_model->get_company_details();
    $data['main_content'] = 'production/job_completion_list';
    $this->load->view('includes/template', $data);
}


public function delete_job_completion()
{
    $completion_id = $this->input->post('completion_id');

    if (!$completion_id) {

        echo json_encode([
            'status'  => false,
            'message' => 'Invalid Job Completion.'
        ]);

        return;
    }

    $result = $this->Production_model->delete_job_completion(
        $completion_id
    );

    echo json_encode($result);
}


public function job_completion_edit($completion_id)
{
    if (!$completion_id) {
        show_error('Invalid Job Completion.');
    }
    $data['title'] = "Edit Job Completion";
    $data['completion'] = $this->Production_model->get_job_completion($completion_id);

    if (!$data['completion']) {
        show_404();
    }
    $data['items'] = $this->Production_model->get_job_completion_items($completion_id);
    $data['main_content'] = 'production/job_completion_edit';
    $this->load->view('includes/template', $data);
}
public function job_completion_view($completion_id)
{
    if (!$completion_id) {
        show_error('Invalid Job Completion.');
    }
    $data['title'] = "View Job Completion";
    $data['completion'] = $this->Production_model->get_job_completion($completion_id);

    if (!$data['completion']) {
        show_404();
    }

    $data['items'] =  $this->Production_model->get_job_completion_items($completion_id);
    $data['main_content'] = 'production/job_completion_view';
    $this->load->view('includes/template', $data);
}

public function update_job_completion()
{
    $completion_id = $this->input->post('job_completion_id');

    if (!$completion_id) {

        echo json_encode([
            'status' => false,
            'message' => 'Invalid Job Completion.'
        ]);

        return;
    }

    $completion_date = $this->input->post('completion_date');

    if (!$completion_date) {

        echo json_encode([
            'status' => false,
            'message' => 'Completion date is required.'
        ]);

        return;
    }

    $completion_data = [

        'completion_date' =>
            $completion_date,

        'remarks' =>
            $this->input->post('remarks'),

        'updated_at' =>
            date('Y-m-d H:i:s')
    ];

    $items = $this->input->post('items');

    if (!is_array($items) || empty($items)) {

        echo json_encode([
            'status' => false,
            'message' => 'Please add at least one completed item.'
        ]);

        return;
    }

    $result = $this->Production_model->update_job_completion(
        $completion_id,
        $completion_data,
        $items
    );

    if ($result) {

        echo json_encode([
            'status' => true,
            'message' => 'Job Completion updated successfully.'
        ]);

    } else {

        echo json_encode([
            'status' => false,
            'message' => 'Unable to update Job Completion.'
        ]);
    }
}

public function get_remaining_items_for_edit()
{
    $job_completion_id = $this->input->post('job_completion_id');

    if (empty($job_completion_id)) {

        echo json_encode([
            'status'  => false,
            'message' => 'Job Completion ID is required.'
        ]);

        return;
    }

    $items = $this->Production_model->get_remaining_items_for_edit($job_completion_id);

    echo json_encode([
        'status' => true,
        'items'  => $items
    ]);
}
/**
 * MATERIAL REQUESTS
 */
public function material_requests()
{
    $data['title'] = 'Production Material Requisition';
    $data['material_requests'] = $this->Production_model->get_production_material_requests();
    $data['company'] = $this->Setup_model->get_company_details();
    $data['main_content'] = 'production/material_request_list';
    $this->load->view(
        'includes/template',
        $data
    );
}
//add
public function material_request()
{
    $data['title'] = 'Create Material Requisition';
    $data['job_orders'] = $this->Production_model->get_job_orders_for_material_request();
    $data['material_request_no'] = $this->Production_model->generate_material_request_no();
    $data['main_content'] = 'production/material_request';
    $this->load->view(
        'includes/template',
        $data
    );
}
/*
public function get_materials_for_material_request()
{
    $job_order_id =
        $this->input->post('job_order_id');

    if (!$job_order_id) {

        echo json_encode(array(
            'status' => false,
            'message' => 'Invalid Job Order.'
        ));

        return;
    }

    $materials =
        $this->Production_model
             ->get_materials_for_material_request(
                 $job_order_id
             );

    echo json_encode(array(
        'status' => true,
        'items' => $materials
    ));
}
*/
public function get_production_item_materials_for_request()
{
    $production_item_id = $this->input->post('production_item_id');
    $job_order_id = $this->input->post('job_order_id');
    if (!$production_item_id || !$job_order_id) {
        echo json_encode([
            'status' => false,
            'message' =>
                'Production Item and Job Order are required.'
        ]);
        return;
    }
    $materials = $this->Production_model->get_production_item_materials_for_print(
                $production_item_id,
                $job_order_id
            );
    echo json_encode([
        'status' => true,
        'materials' => $materials
    ]);
}
/*
public function save_material_request()
{
    $job_order_id =
        $this->input->post('job_order_id');

    $request_date =
        $this->input->post('request_date');

    $remarks =
        $this->input->post('remarks');

    $items_json =
        $this->input->post('items');

    if (!$job_order_id) {

        echo json_encode(array(
            'status' => false,
            'message' => 'Job Order is required.'
        ));

        return;
    }

    $items =
        json_decode($items_json, true);

    if (empty($items)) {

        echo json_encode(array(
            'status' => false,
            'message' => 'Please add at least one material.'
        ));

        return;
    }

    $request_no =
        $this->Production_model
             ->generate_material_request_no();

    $header = array(
        'material_request_no' => $request_no,
        'job_order_id'        => $job_order_id,
        'request_date'        => $request_date,
        'remarks'             => $remarks,
        'status'              => 'Pending'
    );

    $this->db->trans_start();

    $this->db->insert(
        'production_material_request',
        $header
    );

    $request_id =
        $this->db->insert_id();

    foreach ($items as $item) {

        $request_qty =
            (float)$item['request_quantity'];

        if ($request_qty <= 0) {
            continue;
        }

        $this->db->insert(
            'production_material_request_items',
            array(

                'material_request_id' =>
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
                    $item['material_code'],

                'material_name' =>
                    $item['material_name'],

                'required_quantity' =>
                    $item['required_quantity'],

                'previously_requested' =>
                    $item['previously_requested'],

                'request_quantity' =>
                    $request_qty,

                'unit' =>
                    $item['unit']
            )
        );
    }

    $this->db->trans_complete();

    if ($this->db->trans_status()) {

        echo json_encode(array(
            'status' => true,
            'message' =>
                'Material Request created successfully.',
            'material_request_no' =>
                $request_no,
            'material_request_id' =>
                $request_id
        ));

    } else {

        echo json_encode(array(
            'status' => false,
            'message' =>
                'Unable to create Material Request.'
        ));
    }
}
    */

public function get_materials_for_material_request()
{
    $job_order_id = $this->input->post('job_order_id');
    if (!$job_order_id) {

        echo json_encode(array(
            'status' => false,
            'message' => 'Job Order is required.'
        ));
        return;
    }
    $items = $this->Production_model->get_materials_for_material_request($job_order_id);
    echo json_encode(array(
        'status' => true,
        'items' => $items
    ));
}
public function save_material_request()
{
    $job_order_id =  $this->input->post('job_order_id');
    $request_date =  $this->input->post('request_date');
    $remarks =  $this->input->post('remarks');
    $items_json = $this->input->post('items');
    if (!$job_order_id) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Job Order is required.'
        ));
        return;
    }

    if (!$request_date) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Request date is required.'
        ));
        return;
    }

    $items = json_decode(
            $items_json,
            true
        );
    if (!is_array($items) || empty($items)) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Please select materials.'
        ));
        return;
    }
    $result = $this->Production_model->save_material_request(
                 $job_order_id,
                 $request_date,
                 $remarks,
                 $items
             );

    if ($result) {
        echo json_encode(array(
            'status' => true,
            'message' => 'Material Request created successfully.'
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'message' =>
                'Unable to create Material Request.'
        ));
    }
}
public function material_request_view($request_id)
{
    $data['title'] = 'View Material Requisition';
    $data['request'] = $this->Production_model->get_material_request($request_id);
    if (empty($data['request'])) {
        show_404();
    }
    $data['items'] = $this->Production_model->get_material_request_items($request_id);
    $data['main_content'] = 'production/material_request_view';
    $this->load->view(
        'includes/template',
        $data
    );
}

public function material_request_edit($request_id)
{
    $data['title'] = 'Edit Material Requisition';
    $data['request'] = $this->Production_model->get_material_request($request_id);
    if (empty($data['request'])) {
        show_404();
    }
    $data['items'] =  $this->Production_model->get_material_request_items_for_edit($request_id);
    $data['main_content'] = 'production/material_request_edit';
    $this->load->view('includes/template', $data);
}

public function update_material_request()
{
    $request_id = $this->input->post('request_id');
    $request_date = $this->input->post('request_date');
    $remarks = $this->input->post('remarks');
    $items_json =  $this->input->post('items');
    if (empty($request_id)) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Invalid Material Request.'
        ));
        return;
    }

    $items = json_decode(
            $items_json,
            true
        );

    if (!is_array($items)) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Invalid material items.'
        ));
        return;
    }
    $result =  $this->Production_model->update_material_request(
                $request_id,
                $request_date,
                $remarks,
                $items
            );
    if ($result) {
        echo json_encode(array(
            'status' => true,
            'message' =>
                'Material Requisition updated successfully.'
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'message' =>
                'Unable to update Material Requisition.'
        ));
    }
}
//print material reqest
public function print_material_request($material_id)
{
    if (!$material_id) {
        show_error('Invalid Job Order.');
        return;
    }
    
    $job_order = $this->Production_model->get_material_print($material_id);
    $mInfo = $this->Production_model->get_material_info($material_id);
    if (!$job_order) {
        show_error('Job Order not found.');
        return;
    }
    $job_order_id = $job_order->job_order_id;
    $job_order_items = $this->Production_model->get_material_items_print($job_order_id);
    foreach ($job_order_items as &$item) {
        $item->materials = $this->Production_model->get_production_item_materials_for_print($item->job_order_item_id);
    }
    unset($item);
    $data = array(
        'mInfo' => $mInfo,
        'job_order' => $job_order,
        'job_order_items' => $job_order_items
    );
    $data['title']  = " ";
    $this->load->model('Setup_model');
    $data['company'] = $this->Setup_model->get_company_details();
    $data['main_content'] = 'material_request/print_material_request.php';
    $this->load->view('includes/template', $data);
}

/**
 * =========================================================
 * FMT - STOCK TRANSFER LIST
 * =========================================================
 */
public function stock_transfers()
{
    $data['stock_transfers'] = $this->Production_model->get_stock_transfers();

    $data['title'] = 'FMT - Stock Transfer';
    $data['company'] =  $this->Setup_model->get_company_details();
    $data['main_content'] = 'production/stock_transfers.php';

    $this->load->view(
        'includes/template',
        $data
    );
}


/**
 * =========================================================
 * ADD FMT / STOCK TRANSFER
 * =========================================================
 */
public function add_stock_transfer()
{
    $data['title'] =
        'Add Stock Transfer';

    /*
     * Generate FMT number from model
     */
    $data['stock_transfer_no'] =
        $this->Production_model
             ->generate_stock_transfer_no();

    /*
     * Job completions having completed
     * quantity available for transfer
     */
    $data['job_completions'] =
        $this->Production_model
             ->get_available_job_completions();

    /*
     * Branch list
     */
    $data['branches'] =
        $this->Production_model
             ->get_branches();

    /*
     * Initially empty.
     * These will be loaded by AJAX
     * after branch selection.
     */
    $data['warehouses'] = array();

    $data['stores'] = array();

    $data['main_content'] =
        'production/stock_transfer_form.php';

    $this->load->view(
        'includes/template',
        $data
    );
}


/**
 * =========================================================
 * EDIT FMT / STOCK TRANSFER
 * =========================================================
 */
public function edit_stock_transfer($id)
{
    $data['title'] = "Edit Stock Transfer";

    $stock_transfer =
        $this->Production_model
             ->get_stock_transfer($id);


    if (!$stock_transfer) {

        $this->session->set_flashdata(
            'error',
            'Stock transfer not found.'
        );

        redirect('/Production/stock_transfers');

        return;
    }


    $data['stock_transfer'] =
        $stock_transfer;


    /*
     * Existing transfer items
     * +
     * newly completed items from later
     * Job Completions of the same Job Order.
     */
    $data['stock_transfer_items'] =
        $this->Production_model
             ->get_stock_transfer_items_for_edit($id);


    $data['job_completions'] =
        $this->Production_model
             ->get_available_job_completions(
                 $stock_transfer['job_completion_id']
             );


    $data['branches'] =
        $this->Production_model->get_branches();


    $data['from_warehouses'] =
        $this->Production_model->get_warehouses(
            $stock_transfer['from_branch_id']
        );


    $data['to_warehouses'] =
        $this->Production_model->get_warehouses(
            $stock_transfer['to_branch_id']
        );


    $data['from_stores'] =
        $this->Production_model->get_stores(
            $stock_transfer['from_warehouse_id']
        );


    $data['to_stores'] =
        $this->Production_model->get_stores(
            $stock_transfer['to_warehouse_id']
        );


    $data['main_content'] ='production/stock_transfer_form.php';
    $this->load->view(
        'includes/template',
        $data
    );
}


/**
 * =========================================================
 * SAVE / UPDATE FMT
 * =========================================================
 */
public function save_stock_transfer()
{
    $stock_transfer_id =
        $this->input->post(
            'stock_transfer_id'
        );

    $job_completion_id =
        $this->input->post(
            'job_completion_id'
        );

    $ref_number =
        trim(
            $this->input->post(
                'ref_number'
            )
        );

    $ref_date =
        $this->input->post(
            'ref_date'
        );

    $from_branch_id =
        $this->input->post(
            'from_branch_id'
        );

    $from_warehouse_id =
        $this->input->post(
            'from_warehouse_id'
        );

    $from_store_id =
        $this->input->post(
            'from_store_id'
        );

    $to_branch_id =
        $this->input->post(
            'to_branch_id'
        );

    $to_warehouse_id =
        $this->input->post(
            'to_warehouse_id'
        );

    $to_store_id =
        $this->input->post(
            'to_store_id'
        );

    $remarks =
        $this->input->post(
            'remarks'
        );

    $item_ids =
        $this->input->post(
            'job_completion_item_id'
        );

    $transfer_quantities =
        $this->input->post(
            'transfer_quantity'
        );


    /*
     * =====================================================
     * REDIRECT URL
     * =====================================================
     */
    $redirect_url =
        $stock_transfer_id
            ? '/Production/edit_stock_transfer/'
                . $stock_transfer_id
            : '/Production/add_stock_transfer';


    /*
     * =====================================================
     * VALIDATION - JOB COMPLETION
     * =====================================================
     */
    if (!$job_completion_id) {

        $this->session->set_flashdata(
            'error',
            'Please select Job Completion.'
        );

        redirect($redirect_url);

        return;
    }


    /*
     * =====================================================
     * VALIDATION - FROM / TO
     * =====================================================
     */
    if (
        !$from_branch_id ||
        !$from_warehouse_id ||
        !$from_store_id ||
        !$to_branch_id ||
        !$to_warehouse_id ||
        !$to_store_id
    ) {

        $this->session->set_flashdata(
            'error',
            'Please select complete From and To locations.'
        );

        redirect($redirect_url);

        return;
    }


    /*
     * =====================================================
     * PREVENT SAME LOCATION
     * =====================================================
     */
    if (
        $from_branch_id == $to_branch_id &&
        $from_warehouse_id == $to_warehouse_id &&
        $from_store_id == $to_store_id
    ) {

        $this->session->set_flashdata(
            'error',
            'From and To locations cannot be the same.'
        );

        redirect($redirect_url);

        return;
    }


    /*
     * =====================================================
     * VALIDATE ITEMS
     * =====================================================
     */
    if (
        empty($item_ids) ||
        empty($transfer_quantities)
    ) {

        $this->session->set_flashdata(
            'error',
            'Please add at least one item.'
        );

        redirect($redirect_url);

        return;
    }


    /*
     * =====================================================
     * BUILD ITEM ARRAY
     * =====================================================
     */
    $items = array();

    foreach (
        $item_ids as $key => $job_completion_item_id
    ) {

        $qty =
            isset(
                $transfer_quantities[$key]
            )
                ? (float)$transfer_quantities[$key]
                : 0;

        /*
         * Ignore zero quantity rows
         */
        if ($qty <= 0) {
            continue;
        }

        $items[] = array(
            'job_completion_item_id'
                => (int)$job_completion_item_id,

            'transfer_quantity'
                => $qty
        );
    }


    /*
     * =====================================================
     * CHECK VALID ITEMS
     * =====================================================
     */
    if (empty($items)) {

        $this->session->set_flashdata(
            'error',
            'Please enter valid transfer quantities.'
        );

        redirect($redirect_url);

        return;
    }

    $header = array(
        'ref_number'  => $ref_number,
        'ref_date' => $ref_date,
        'from_branch_id'  => $from_branch_id,
        'from_warehouse_id' => $from_warehouse_id,
        'from_store_id' => $from_store_id,
        'to_branch_id'  => $to_branch_id,
        'to_warehouse_id' => $to_warehouse_id,
        'to_store_id' => $to_store_id,
        'remarks' => $remarks
    );


    /*
     * =====================================================
     * UPDATE
     * =====================================================
     */
    if ($stock_transfer_id) {

        $result =  $this->Production_model->update_stock_transfer(
                     $stock_transfer_id,
                     $header,
                     $items
                 );

        $message = 'Stock transfer updated successfully.';

    }

    /*
     * =====================================================
     * INSERT
     * =====================================================
     */
    else {

        $header['job_completion_id'] = $job_completion_id;
        $result = $this->Production_model->save_stock_transfer(
                     $header,
                     $items
                 );

        $message = 'Stock transfer saved successfully.';
    }


    /*
     * =====================================================
     * RESULT
     * =====================================================
     */
    if ($result) {

        $this->session->set_flashdata(
            'success',
            $message
        );

    } else {

        $this->session->set_flashdata(
            'error',
            'Unable to save stock transfer.'
        );
    }


    redirect(
        '/Production/stock_transfers'
    );
}

public function get_job_completion_for_transfer()
{
    $job_completion_id = $this->input->post('job_completion_id');

    if (empty($job_completion_id)) {

        echo json_encode([
            'status'  => false,
            'message' => 'Invalid Job Completion.'
        ]);

        return;
    }

    $result = $this->Production_model
        ->get_job_completion_for_transfer_fmt(
            $job_completion_id
        );

    if (empty($result['header'])) {

        echo json_encode([
            'status'  => false,
            'message' => 'Job Completion not found.'
        ]);

        return;
    }

    if (empty($result['items'])) {

        echo json_encode([
            'status'  => false,
            'message' => 'No fully completed items found for this Job Completion.'
        ]);

        return;
    }

    echo json_encode([
        'status' => true,
        'header' => $result['header'],
        'items'  => $result['items']
    ]);
}

public function get_warehouses()
{
    $branch_id =
        $this->input->post(
            'branch_id'
        );

    if (!$branch_id) {

        echo json_encode(
            array()
        );

        return;
    }


    $warehouses =
        $this->Production_model
             ->get_warehouses(
                 $branch_id
             );


    echo json_encode(
        $warehouses
    );
}


/**
 * =========================================================
 * AJAX - GET STORES BY WAREHOUSE
 * =========================================================
 */
public function get_stores()
{
    $warehouse_id =
        $this->input->post(
            'warehouse_id'
        );

    if (!$warehouse_id) {

        echo json_encode(
            array()
        );

        return;
    }


    $stores =
        $this->Production_model
             ->get_stores(
                 $warehouse_id
             );


    echo json_encode(
        $stores
    );
}

public function get_job_completion_for_transfer_fmt()
{
    $job_completion_id = $this->input->post('job_completion_id');

    if (empty($job_completion_id)) {

        echo json_encode([
            'status'  => false,
            'header'  => null,
            'items'   => [],
            'message' => 'Job Completion ID is required'
        ]);

        return;
    }


    $result = $this->Production_model
        ->get_job_completion_for_transfer_fmt(
            $job_completion_id
        );


    if (empty($result['header'])) {

        echo json_encode([
            'status'  => false,
            'header'  => null,
            'items'   => [],
            'message' => 'Job Completion not found'
        ]);

        return;
    }


    echo json_encode([
        'status' => true,
        'header' => $result['header'],
        'items'  => $result['items']
    ]);
}

//REPORTS
 
    public function reports()
{
    $data['title'] = "Production Reports";
    $data['projects'] = $this->Production_model->get_report_projects();
    $data['job_orders'] = $this->Production_model->get_report_job_orders();
    $data['main_content'] = 'production/reports.php';

    $this->load->view(
        'includes/template',
        $data
    );
}

    public function get_job_order_report()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $project_id = $this->input->post('project_id');
        $status     = $this->input->post('status');
        $job_order_id     = $this->input->post('job_order_id');

        $data = $this->Production_model->get_job_order_report(
            $from_date,
            $to_date,
            $project_id,
            $job_order_id,
            $status
        );

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    public function get_job_completion_report()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $project_id = $this->input->post('project_id');
        $job_order_id = $this->input->post('job_order_id');

        $data = $this->Production_model->get_job_completion_report(
            $from_date,
            $to_date,
            $project_id,
            $job_order_id
        );

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }


    public function get_material_request_report()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $job_order_id = $this->input->post('job_order_id');
        $status = $this->input->post('status');

        $data = $this->Production_model->get_material_request_report(
            $from_date,
            $to_date,
            $job_order_id,
            $status
        );

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }


    public function get_stock_transfer_report()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $project_id = $this->input->post('project_id');
        $job_order_id = $this->input->post('job_order_id');
        $status = $this->input->post('status');

        $data = $this->Production_model->get_stock_transfer_report(
            $from_date,
            $to_date,
            $project_id,
            $job_order_id,
            $status
        );

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }


    public function get_production_summary_report()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $project_id = $this->input->post('project_id');
        $status = $this->input->post('status');
        $job_order_id = $this->input->post('job_order_id');
        $data = $this->Production_model->get_production_summary_report(
            $from_date,
            $to_date,
            $project_id,
            $job_order_id,
            $status
        );

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    public function get_production_report()
{
    $report_type = $this->input->post('report_type');

    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');

    $project_id = $this->input->post('project_id');
    $job_order_id = $this->input->post('job_order_id');
    $status = $this->input->post('status');

    $data = array();

    switch ($report_type) {

        case 'summary':

            $data =
                $this->Production_model
                    ->get_production_summary_report(
                        $from_date,
                        $to_date,
                        $project_id,
                        $job_order_id,
                        $status
                    );

            break;

        case 'job_order':

            $data =
                $this->Production_model
                    ->get_job_order_report(
                        $from_date,
                        $to_date,
                        $project_id,
                        $job_order_id,
                        $status
                    );

            break;


        case 'job_completion':

            $data =
                $this->Production_model
                    ->get_job_completion_report(
                        $from_date,
                        $to_date,
                        $project_id,
                        $job_order_id
                    );

            break;


        case 'material_request':

            $data =
                $this->Production_model
                    ->get_material_request_report(
                        $from_date,
                        $to_date,
                        $job_order_id,
                        $status
                    );

            break;

        case 'stock_transfer':

            $data =
                $this->Production_model
                    ->get_stock_transfer_report(
                        $from_date,
                        $to_date,
                        $project_id,
                        $job_order_id,
                        $status
                    );

            break;


        default:

            echo json_encode(array(
                'status' => false,
                'message' => 'Invalid report type'
            ));

            return;
    }

    echo json_encode(array(
        'status' => true,
        'data' => $data
    ));
}

     /* ============================================================
     * PRODUCTION MANAGER DASHBOARD
     * ============================================================ */

    public function production_dashboard()
    {
        $data['title'] = "Production Dashboard";
        $data['projects'] =  $this->Production_model->get_production_projects();
        $data['main_content'] = 'production/production_dashboard.php';
        $this->load->view(
            'includes/template',
            $data
        );
       
    }

    public function get_production_dashboard_summary()
    {
        $filters = array(
            'from_date'    => $this->input->post('from_date'),
            'to_date'      => $this->input->post('to_date'),
            'project_id'   => $this->input->post('project_id')
        );

        $summary =
            $this->Production_model
                ->get_production_dashboard_summary($filters);

        echo json_encode(array(
            'status' => true,
            'data'   => $summary
        ));
    }

    public function get_job_order_status_chart()
    {
        $filters = array(
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'project_id' => $this->input->post('project_id')
        );

        $data =
            $this->Production_model
                ->get_job_order_status_chart($filters);

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    public function get_production_quantity_chart()
    {
        $filters = array(
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'project_id' => $this->input->post('project_id')
        );

        $data =
            $this->Production_model
                ->get_production_quantity_chart($filters);

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }


    public function get_monthly_production_chart()
    {
        $filters = array(
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'project_id' => $this->input->post('project_id')
        );

        $data =
            $this->Production_model
                ->get_monthly_production_chart($filters);

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    public function get_material_request_chart()
    {
        $filters = array(
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'project_id' => $this->input->post('project_id')
        );

        $data =
            $this->Production_model
                ->get_material_request_chart($filters);

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

   public function get_stock_transfer_chart()
    {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $project_id = $this->input->post('project_id');

        $data = $this->Production_model
            ->get_stock_transfer_chart(
                $from_date,
                $to_date,
                $project_id
            );

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function get_top_production_products()
    {
        $filters = array(
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'project_id' => $this->input->post('project_id')
        );

        $data =
            $this->Production_model
                ->get_top_production_products($filters);

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    public function get_production_drilldown()
    {
        $type = $this->input->post('type');

        $value = $this->input->post('value');

        $filters = array(
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'project_id' => $this->input->post('project_id')
        );

        $data =
            $this->Production_model
                ->get_production_drilldown(
                    $type,
                    $value,
                    $filters
                );

        echo json_encode(array(
            'status' => true,
            'type'   => $type,
            'value'  => $value,
            'data'   => $data
        ));
    }
/*    public function print_material_request($material_id)
{
    if (!$material_id) {
        show_error('Invalid Job Order.');
        return;
    }

    $job_order =
        $this->Production_model->get_material_print($material_id);

    $mInfo =
        $this->Production_model->get_material_info($material_id);

    if (!$job_order) {
        show_error('Job Order not found.');
        return;
    }

    $job_order_id = $job_order->job_order_id;

    $job_order_items =
        $this->Production_model
             ->get_material_items_print($job_order_id);

    foreach ($job_order_items as &$item) {

        $item->materials =
            $this->Production_model
                 ->get_production_item_materials_for_print(
                     $item->job_order_item_id
                 );
    }

    unset($item);



    $stock_transfer =
        $this->Production_model
             ->get_stock_transfer_for_print($job_order_id);


    $stock_transfer_items = array();

    if ($stock_transfer) {

        $stock_transfer_items =
            $this->Production_model
                 ->get_stock_transfer_items_print(
                     $stock_transfer->stock_transfer_id
                 );
    }


    $data = array(

        'mInfo'             => $mInfo,

        'job_order'         => $job_order,

        'job_order_items'   => $job_order_items,

        'stock_transfer'    => $stock_transfer,

        'stock_transfer_items' =>
            $stock_transfer_items
    );


    $data['title'] = " ";


    $this->load->model('Setup_model');

    $data['company'] =
        $this->Setup_model->get_company_details();


    $data['main_content'] =
        'material_request/print_material_request.php';


    $this->load->view(
        'includes/template',
        $data
    );
}
    */

public function print_stock_transfer($stock_id)
{
    if (!$stock_id) {
        show_error('Invalid Stock Transfer.');
        return;
    }

   
    $stock_transfer =
        $this->Production_model
             ->get_stock_transfer_for_print($stock_id);

    if (!$stock_transfer) {
        show_error('Stock Transfer not found.');
        return;
    }


    
    $stock_transfer_items =
        $this->Production_model
             ->get_stock_transfer_items_for_print($stock_id);


   
    $job_completion =
        $this->Production_model
             ->get_job_completion_for_stock_print(
                 $stock_transfer->job_completion_id
             );


   
    $job_completion_items =
        $this->Production_model
             ->get_job_completion_items_for_stock_print(
                 $stock_transfer->job_completion_id
             );


    $job_order =
        $this->Production_model
             ->get_job_order_for_stock_print(
                 $stock_transfer->job_order_id
             );


    $job_order_items =
        $this->Production_model
             ->get_job_order_items_for_stock_print(
                 $stock_transfer->job_order_id
             );

    $material_requests =
        $this->Production_model
             ->get_material_requests_for_stock_print(
                 $stock_transfer->job_order_id
             );

  foreach ($material_requests as &$material_request) {

        $material_request->items =
            $this->Production_model
                 ->get_material_request_items_for_stock_print(
                     $material_request
                         ->production_material_request_id
                 );
    }

    unset($material_request);
    $this->load->model('Setup_model');

    $company =  $this->Setup_model->get_company_details();

    $data = array(

        'stock_transfer'       => $stock_transfer,

        'stock_transfer_items' =>
            $stock_transfer_items,

        'job_completion'       =>
            $job_completion,

        'job_completion_items' =>
            $job_completion_items,

        'job_order'            =>
            $job_order,

        'job_order_items'      =>
            $job_order_items,

        'material_requests'    =>
            $material_requests,

        'company'              =>
            $company

    );

    $data['title'] = " ";

    $data['main_content'] =
        'production/print_stock_transfer.php';

    $this->load->view(
        'includes/template',
        $data
    );
}
public function get_sales_order_items()
    {
        $so_id = $this->input->post('so_id');

        if (empty($so_id)) {

            echo json_encode(array());

            return;
        }
        $items = $this->Production_model->get_sales_order_items($so_id);
        echo json_encode($items);
    }

    public function get_project_sales_orders()
    {
        $project_id = $this->input->post('project_id');

        if (!$project_id) {
            echo json_encode(array());
            return;
        }

        $sales_orders = $this->Production_model->get_sales_orders_job_order_project(
                $project_id
            );

        echo json_encode($sales_orders);
    }

    public function get_multiple_sales_order_items()
    {
        $so_ids = $this->input->post('so_ids');

        if (empty($so_ids) || !is_array($so_ids)) {
            echo json_encode(array());
            return;
        }

        $items = $this->Production_model
            ->get_multiple_sales_order_items($so_ids);

        echo json_encode($items);
    }

  public function print_project_job_order($job_order_id)
{
    if (!$job_order_id) {
        show_error('Invalid Project Job Order.');
        return;
    }

    // Project Job Order details
    $job_order = $this->Production_model->get_job_order_print($job_order_id);

    if (!$job_order) {
        show_error('Project Job Order not found.');
        return;
    }

    // Get project information
    $project = $this->Production_model->get_project_for_job_order_print(
            $job_order_id
        );

    // Get Sales Orders assigned to THIS Job Order
    $sales_orders = $this->Production_model->get_job_order_sales_orders_print(
            $job_order_id
        );

    /*
     * Get items/materials for each Sales Order
     *
     * This part depends on how your project_item_id
     * is related to each Sales Order.
     */
    foreach ($sales_orders as &$sales_order) {

        $sales_order->items =
            $this->Production_model->get_project_job_order_items_print(
                $job_order_id,
                $sales_order->so_id
            );

        foreach ($sales_order->items as &$item) {

            $item->materials =
                $this->Production_model
                    ->get_project_job_item_materials_print(
                        $item->job_order_item_id
                    );
        }

        unset($item);
    }

    unset($sales_order);

    $data = array(
        'job_order'   => $job_order,
        'project'     => $project,
        'sales_orders' => $sales_orders
    );

    $data['title'] = "Print Project Job Order";

    $this->load->model('Setup_model');

    $data['company'] =
        $this->Setup_model->get_company_details();

    $data['main_content'] =
        'job_order/project_job_order_print.php';

    $this->load->view(
        'includes/template',
        $data
    );
}

/** CNC MODULES */

    /**
     * CNC Task Creation Page
     */
    public function cnc_tasks()
    {
        $user = $this->session->userdata('user_id');

        /*if (!has_access($user, 'Production/cnc_tasks', 'A')) {
            $data['title'] = 'Access Denied';
            $data['main_content'] = 'errors/access_control.php';
        } else {*/
            $data['title'] = 'CNC Production Tasks';
            $data['main_content'] = 'production/cnc_tasks.php';
            $this->load->view(
                'includes/template',
                $data
            );
       // }
    }

    public function get_cnc_job_orders()
    {
        $data = $this->Production_model->get_cnc_job_orders();

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    /**
     * Get Sales Orders belonging to selected Job Order
     */
    public function get_job_order_sales_orders()
    {
        $job_order_id = $this->input->post('job_order_id');

        if (!$job_order_id) {
            echo json_encode(array(
                'status' => false,
                'data'   => array()
            ));
            return;
        }

        $data = $this->Production_model->get_job_order_sales_orders($job_order_id);

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    /**
     * Get Sales Order Products
     *
     * For normal JO:
     * selected SO
     *
     * For project JO:
     * selected SO inside project JO
     */
    public function get_cnc_sales_order_products()
    {
        $job_order_id  = $this->input->post('job_order_id');
        $sales_order_id = $this->input->post('sales_order_id');

        if (!$job_order_id || !$sales_order_id) {
            echo json_encode(array(
                'status' => false,
                'data'   => array()
            ));
            return;
        }

        $data = $this->Production_model->get_cnc_sales_order_products(
            $job_order_id,
            $sales_order_id
        );

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    /**
     * Get Employees
     *
     * Initially this returns CNC employees.
     *
     * We can later replace this with your actual
     * employee/user/designation relationship.
     */
    public function get_cnc_employees()
    {
        $data = $this->Production_model->get_cnc_employees();

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }

    /**
     * Save CNC Production Task
     */
    public function save_cnc_task()
    {
        $job_order_id          = (int) $this->input->post('job_order_id');
        $sales_order_id        = (int) $this->input->post('sales_order_id');
        $sales_order_product_id = (int) $this->input->post('sales_order_product_id');
        $task_description      = trim($this->input->post('task_description'));
        $quantity              = (float) $this->input->post('quantity');
        $assigned_employee_id  = (int) $this->input->post('assigned_employee_id');
        $priority              = trim($this->input->post('priority'));
        $remarks               = trim($this->input->post('remarks'));

        /*
         * Basic validation
         */
        if (!$job_order_id) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Please select Job Order.'
            ));
            return;
        }

        if (!$sales_order_id) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Please select Sales Order.'
            ));
            return;
        }

        if (!$sales_order_product_id) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Please select Sales Order Item.'
            ));
            return;
        }

        if ($task_description === '') {
            echo json_encode(array(
                'status' => false,
                'message' => 'Please enter task / part description.'
            ));
            return;
        }

        if ($quantity <= 0) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Quantity must be greater than zero.'
            ));
            return;
        }

        if (!$assigned_employee_id) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Please select CNC employee.'
            ));
            return;
        }

        if ($priority === '') {
            $priority = 'Normal';
        }

        /*
         * Department ID 8 = CNC
         *
         * We can later load this dynamically from
         * department_master.
         */
        $department_id = 8;

        /*
         * Current logged-in user.
         *
         * Change this according to your existing
         * login/session user ID.
         */
        $assigned_by = (int) $this->session->userdata('user_id');

        if (!$assigned_by) {
            $assigned_by = null;
        }

        /*
         * Verify that this SO Product actually belongs
         * to the selected Sales Order.
         */
        $product = $this->Production_model->validate_cnc_sales_order_product(
            $sales_order_id,
            $sales_order_product_id
        );

        if (!$product) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Invalid Sales Order Item selected.'
            ));
            return;
        }

        /*
         * Verify Job Order / SO relationship.
         *
         * Handles both:
         * 1. Normal Job Order
         * 2. Project Job Order
         */
        if (!$this->Production_model->validate_job_order_sales_order(
            $job_order_id,
            $sales_order_id
        )) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Selected Sales Order does not belong to this Job Order.'
            ));
            return;
        }

        /*
         * Save task
         */
        $task_data = array(
            'job_order_id'           => $job_order_id,
            'sales_order_id'         => $sales_order_id,
            'sales_order_product_id' => $sales_order_product_id,
            'department_id'          => $department_id,
            'task_description'       => $task_description,
            'quantity'               => $quantity,
            'assigned_employee_id'   => $assigned_employee_id,
            'assigned_by'            => $assigned_by,
            'priority'               => $priority,
            'status'                 => 'Pending',
            'remarks'                => $remarks !== '' ? $remarks : null
        );

        $this->db->trans_begin();

        $task_id = $this->Production_model->insert_production_task($task_data);

        if (!$task_id) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'status' => false,
                'message' => 'Failed to create CNC task.'
            ));
            return;
        }

        /*
         * First status history record
         */
        $history_data = array(
            'task_id'    => $task_id,
            'old_status' => null,
            'new_status' => 'Pending',
            'changed_by' => $assigned_by ? $assigned_by : 0,
            'remarks'    => 'CNC task created'
        );

        $this->Production_model->insert_task_status_history($history_data);

        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            echo json_encode(array(
                'status' => false,
                'message' => 'Failed to save CNC task.'
            ));
            return;
        }

        $this->db->trans_commit();

        echo json_encode(array(
            'status' => true,
            'message' => 'CNC task created successfully.',
            'task_id' => $task_id
        ));
    }

    /**
     * CNC task listing
     */
    public function get_cnc_task_list()
    {
        $data = $this->Production_model->get_cnc_task_list();

        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));
    }
   
   public function update_cnc_task()
    {
        $task_id = (int) $this->input->post('task_id');

        $job_order_id = (int) $this->input->post('job_order_id');

        $sales_order_id = (int) $this->input->post('sales_order_id');

        $sales_order_product_id =
            (int) $this->input->post('sales_order_product_id');

        $task_description =
            trim($this->input->post('task_description'));

        $quantity =
            (float) $this->input->post('quantity');

        $assigned_employee_id =
            (int) $this->input->post('assigned_employee_id');

        $priority =
            trim($this->input->post('priority'));

        $remarks =
            trim($this->input->post('remarks'));


        /*
        |--------------------------------------------------------------------------
        | Basic validation
        |--------------------------------------------------------------------------
        */

        if (!$task_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid CNC task.'
            ));

            return;
        }


        if (!$job_order_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Please select Job Order.'
            ));

            return;
        }


        if (!$sales_order_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Please select Sales Order.'
            ));

            return;
        }


        if (!$sales_order_product_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Please select Sales Order Item.'
            ));

            return;
        }


        if ($task_description === '') {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Please enter task / part description.'
            ));

            return;
        }


        if ($quantity <= 0) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Please enter valid quantity.'
            ));

            return;
        }


        if (!$assigned_employee_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Please select CNC employee.'
            ));

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Get existing task
        |--------------------------------------------------------------------------
        */

        $existing_task =
            $this->Production_model
                ->get_cnc_task_by_id($task_id);


        if (!$existing_task) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'CNC task not found.'
            ));

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Confirm CNC department
        |--------------------------------------------------------------------------
        */

        if ((int) $existing_task->department_id !== 8) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid CNC task department.'
            ));

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Job Order + Sales Order
        |--------------------------------------------------------------------------
        */

        $valid_job_order_so =
            $this->Production_model
                ->validate_job_order_sales_order(
                    $job_order_id,
                    $sales_order_id
                );


        if (!$valid_job_order_so) {

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Selected Sales Order does not belong to this Job Order.'
            ));

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Sales Order Product
        |--------------------------------------------------------------------------
        */

        $valid_product =
            $this->Production_model
                ->validate_cnc_sales_order_product(
                    $sales_order_id,
                    $sales_order_product_id
                );


        if (!$valid_product) {

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Selected item does not belong to Sales Order.'
            ));

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Employee
        |--------------------------------------------------------------------------
        */

        $valid_employee =
            $this->Production_model
                ->validate_cnc_employee(
                    $assigned_employee_id
                );


        if (!$valid_employee) {

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Selected employee is not an active CNC employee.'
            ));

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Existing employee
        |--------------------------------------------------------------------------
        */

        $old_employee_id =
            (int) $existing_task->assigned_employee_id;

        $new_employee_id =
            (int) $assigned_employee_id;


        /*
        |--------------------------------------------------------------------------
        | Update task
        |--------------------------------------------------------------------------
        */

        $data = array(
            'job_order_id' =>
                $job_order_id,

            'sales_order_id' =>
                $sales_order_id,

            'sales_order_product_id' =>
                $sales_order_product_id,

            'task_description' =>
                $task_description,

            'quantity' =>
                $quantity,

            'assigned_employee_id' =>
                $new_employee_id,

            'priority' =>
                ($priority !== '' ? $priority : 'Normal'),

            'remarks' =>
                $remarks,

            'updated_at' =>
                date('Y-m-d H:i:s')
        );


        $this->db->trans_begin();


        /*
        |--------------------------------------------------------------------------
        | Update production task
        |--------------------------------------------------------------------------
        */

        $updated =
            $this->Production_model
                ->update_production_task(
                    $task_id,
                    $data
                );


        if (!$updated) {

            $this->db->trans_rollback();

            echo json_encode(array(
                'status'  => false,
                'message' => 'Unable to update CNC task.'
            ));

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Employee changed?
        |--------------------------------------------------------------------------
        */

        if ($old_employee_id !== $new_employee_id) {

            /*
            * IMPORTANT:
            * Replace this with your actual logged-in employee/session ID.
            *
            * For now using assigned_by if available.
            */

            $changed_by =
                !empty($existing_task->assigned_by)
                    ? (int) $existing_task->assigned_by
                    : 0;


            $history_data = array(

                'task_id' =>
                    $task_id,

                'old_employee_id' =>
                    ($old_employee_id > 0
                        ? $old_employee_id
                        : null),

                'new_employee_id' =>
                    $new_employee_id,

                'changed_by' =>
                    $changed_by,

                'remarks' =>
                    'CNC employee reassigned during task edit.',

                'changed_at' =>
                    date('Y-m-d H:i:s')
            );


            $history_inserted =
                $this->Production_model
                    ->insert_task_assignment_history(
                        $history_data
                    );


            if (!$history_inserted) {

                $this->db->trans_rollback();

                echo json_encode(array(
                    'status'  => false,
                    'message' =>
                        'Task updated failed because assignment history could not be saved.'
                ));

                return;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Commit
        |--------------------------------------------------------------------------
        */

        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            echo json_encode(array(
                'status'  => false,
                'message' => 'Unable to update CNC task.'
            ));

            return;
        }


        $this->db->trans_commit();

        echo json_encode(array(
            'status'  => true,
            'message' => 'CNC task updated successfully.'
        ));
    }

    /**
     * ============================================================
     * CNC EMPLOYEE TASK PAGE
     * ============================================================
     */
    public function cnc_employee_tasks()
    {
        $employee_id = (int) $this->session->userdata(
            'employee_id'
        );

        if (!$employee_id) {
            show_error(
                'Employee session not found.',
                403
            );

            return;
        }

        $data['employee_id'] = $employee_id;

        $data['title'] = 'CNC Employee Tasks';
          $data['main_content'] = 'production/cnc_employee_tasks';
        $this->load->view('includes/template', $data);
       
    }
  /**
     * Get tasks assigned to logged-in CNC employee
     */
    public function get_cnc_employee_tasks()
    {
        $employee_id = (int) $this->session->userdata(
            'employee_id'
        );

        if (!$employee_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Employee session not found.',
                'data'    => array()
            ));

            return;
        }

        $tasks =
            $this->Production_model
                ->get_cnc_employee_tasks(
                    $employee_id
                );

        echo json_encode(array(
            'status' => true,
            'data'   => $tasks
        ));
    }
    
    /**
     * Update CNC task status by employee
     */
    public function update_cnc_task_status()
    {
        $employee_id = (int) $this->session->userdata(
            'employee_id'
        );

        if (!$employee_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Employee session not found.'
            ));

            return;
        }


        $task_id = (int) $this->input->post(
            'task_id'
        );

        $new_status = trim(
            $this->input->post('status')
        );

        $remarks = trim(
            $this->input->post('remarks')
        );


        if (!$task_id) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid task.'
            ));

            return;
        }


        if ($new_status === '') {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid status.'
            ));

            return;
        }


        /*
        * Allowed statuses
        */
        $allowed_statuses = array(
            'In Progress',
            'Hold',
            'Completed'
        );


        if (!in_array(
            $new_status,
            $allowed_statuses
        )) {

            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid status selected.'
            ));

            return;
        }


        /*
        * Get task belonging to logged-in employee
        */
        $task =
            $this->Production_model
                ->get_cnc_employee_task(
                    $task_id,
                    $employee_id
                );


        if (!$task) {

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Task not found or task is not assigned to you.'
            ));

            return;
        }


        $old_status = trim(
            $task->status
        );


        /*
        * Do not allow changes after Completed
        */
        if (
            strtolower($old_status) ===
            'completed'
        ) {

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Completed task cannot be changed.'
            ));

            return;
        }


        /*
        * Status transition validation
        */
        $valid_transition = false;


        /*
        * Pending → In Progress
        */
        if (
            $old_status === 'Pending' &&
            $new_status === 'In Progress'
        ) {
            $valid_transition = true;
        }


        /*
        * In Progress → Hold
        */
        if (
            $old_status === 'In Progress' &&
            $new_status === 'Hold'
        ) {
            $valid_transition = true;
        }


        /*
        * In Progress → Completed
        */
        if (
            $old_status === 'In Progress' &&
            $new_status === 'Completed'
        ) {
            $valid_transition = true;
        }


        /*
        * Hold → In Progress
        */
        if (
            $old_status === 'Hold' &&
            $new_status === 'In Progress'
        ) {
            $valid_transition = true;
        }
        
        /*
        * Rework → In Progress
        */
        if (
            $old_status === 'Rework' &&
            $new_status === 'In Progress'
        ) {
            $valid_transition = true;
        }

        if (!$valid_transition) {

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Invalid status change: ' .
                    $old_status .
                    ' → ' .
                    $new_status
            ));

            return;
        }


        /*
        * Prepare update
        */
        $update_data = array(
            'status'     => $new_status,
            'updated_at' => date('Y-m-d H:i:s')
        );


        /*
        * Start time
        */
        if (
            $new_status === 'In Progress' &&
            empty($task->started_at)
        ) {

            $update_data['started_at'] =
                date('Y-m-d H:i:s');
        }


        /*
        * Completed time
        */
        if ($new_status === 'Completed') {

            $update_data['completed_at'] =
                date('Y-m-d H:i:s');
        }


        /*
        * Transaction
        */
        $this->db->trans_begin();


        /*
        * Update task
        */
        $updated =
            $this->Production_model
                ->update_cnc_task_status(
                    $task_id,
                    $employee_id,
                    $new_status,
                    $update_data
                );


        if (!$updated) {

            $this->db->trans_rollback();

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Unable to update task status.'
            ));

            return;
        }


        /*
        * Insert status history
        */
        $history_inserted =
            $this->Production_model
                ->insert_cnc_status_history(
                    $task_id,
                    $old_status,
                    $new_status,
                    $employee_id,
                    $remarks
                );


        if (!$history_inserted) {

            $this->db->trans_rollback();

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Status updated failed because history could not be saved.'
            ));

            return;
        }


        /*
        * Check transaction
        */
        if ($this->db->trans_status() === false) {

            $this->db->trans_rollback();

            echo json_encode(array(
                'status'  => false,
                'message' =>
                    'Unable to update task.'
            ));

            return;
        }


        $this->db->trans_commit();


        echo json_encode(array(
            'status'  => true,
            'message' =>
                'Task status updated successfully.'
        ));
    }

    /**
     * Get status history for employee task
     */
    public function get_cnc_task_status_history()
    {
        $employee_id = (int) $this->session->userdata(
            'employee_id'
        );

        $task_id = (int) $this->input->post(
            'task_id'
        );


        if (!$employee_id || !$task_id) {

            echo json_encode(array(
                'status' => false,
                'data'   => array()
            ));

            return;
        }


        /*
        * Model itself verifies that this task
        * belongs to the employee.
        */
        $history =
            $this->Production_model
                ->get_cnc_task_status_history(
                    $task_id,
                    $employee_id
                );


        echo json_encode(array(
            'status' => true,
            'data'   => $history
        ));
    }



/**
 * Save CNC Task Work Note
 */
public function save_cnc_task_note()
{
    $task_id   = (int) $this->input->post('task_id');
    $note_type = trim($this->input->post('note_type'));
    $note      = trim($this->input->post('note'));
    $added_by_role =  trim($this->input->post('added_by_role'));

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task ID is required.'
        ));
        return;
    }

    if ($note_type == '') {
        $note_type = 'General';
    }

    if ($note == '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Please enter a note.'
        ));
        return;
    }

    /*
     * Logged-in user
     */
    $user_id = $this->session->userdata('user_id');

    if (!$user_id) {
        $user_id = $this->session->userdata('employee_id');
    }

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'User session not found.'
        ));
        return;
    }

    /*
     * Check task
     */
    $task = $this->Production_model->get_cnc_task_by_id($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task not found.'
        ));
        return;
    }

    /*
     * Determine who is adding the note.
     *
     * Employee:
     *   User is assigned to this CNC task.
     *
     * Supervisor:
     *   User is not the assigned employee.
     *
     * This keeps the same note endpoint for both screens.
     */
    $assigned_employee_id = isset($task->assigned_employee_id)
        ? (int) $task->assigned_employee_id
        : 0;

    /*if ($assigned_employee_id == (int) $user_id) {
        $added_by_role = 'Employee';
    } else {
        $added_by_role = 'Supervisor';
    }
    */
    /*
     * Save note
     */
    $data = array(
        'task_id'       => $task_id,
        'employee_id'   => (int) $user_id,
        'added_by_role' => $added_by_role,
        'note_type'     => $note_type,
        'note'          => $note,
        'created_at'    => date('Y-m-d H:i:s')
    );

    $note_id = $this->Production_model->save_cnc_task_note($data);

    if (!$note_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Unable to save note.'
        ));
        return;
    }

    echo json_encode(array(
        'status'        => true,
        'message'       => 'Note saved successfully.',
        'note_id'       => $note_id,
        'added_by_role' => $added_by_role
    ));
}

/**
 * Get CNC Task Timeline
 *
 * Combines:
 * 1. production_task_status_history
 * 2. production_task_notes
 */
public function get_cnc_task_timeline()
{
    $task_id = (int) $this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task ID is required.',
            'data'    => array()
        ));
        return;
    }

    $task = $this->Production_model->get_cnc_task_by_idt($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'CNC task not found.',
            'data'    => array()
        ));
        return;
    }

    $timeline = $this->Production_model->get_cnc_task_timeline($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $timeline
    ));
}

/* ============================================================
 * CNC SUPERVISOR APPROVAL / HANDOVER
 * ============================================================ */

/**
 * Get completed CNC task for supervisor approval.
 */
/*
public function get_cnc_task_for_approval()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid CNC task.'
        ));
        return;
    }

    $task = $this->Production_model->get_cnc_task_by_idt($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'CNC task not found.'
        ));
        return;
    }

    if ((int)$task->department_id !== 8) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid CNC task.'
        ));
        return;
    }

    if (strtolower(trim($task->status)) !== 'completed') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only completed CNC tasks can be approved.'
        ));
        return;
    }

    
    $existing_handover =
        $this->Production_model->get_task_handover_by_task_id($task_id);

    if ($existing_handover) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'This CNC task has already been processed.'
        ));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'data'   => $task
    ));
}
*/

/**
 * Approve CNC task and handover to Bending.
 *
 * decision:
 *   approve = Approve & Handover to Bending
 *   rework  = Send Back for Rework
 */
public function approve_cnc_handover()
{
    $task_id  = (int)$this->input->post('task_id');
    $decision = trim($this->input->post('decision'));
    $remarks  = trim($this->input->post('remarks'));

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid CNC task.'
        ));
        return;
    }

    if (!in_array($decision, array('approve', 'rework'))) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid approval decision.'
        ));
        return;
    }

    if ($decision === 'rework' && $remarks === '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Please enter rework remarks.'
        ));
        return;
    }

    /*
     * Logged-in supervisor/user.
     */
    $approved_by = (int)$this->session->userdata('user_id');

    if (!$approved_by) {
        $approved_by = (int)$this->session->userdata('employee_id');
    }

    if (!$approved_by) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Supervisor session not found.'
        ));
        return;
    }

    /*
     * Get CNC task.
     */
    $task = $this->Production_model->get_cnc_task_by_idt($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'CNC task not found.'
        ));
        return;
    }

    /*
     * Must be CNC.
     */
    if ((int)$task->department_id !== 8) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'This is not a CNC task.'
        ));
        return;
    }

    /*
     * Only Completed CNC tasks can be processed.
     */
    if (strtolower(trim($task->status)) !== 'completed') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only completed CNC tasks can be approved.'
        ));
        return;
    }
    /*
    * BENDING DEPARTMENT
    *
    * CNC = 8
    * Bending = 10
    */
    $bending_department_id = 10;

    /*
    * Prevent duplicate APPROVED handover to Bending.
    */
    $existing_handover = $this->Production_model->get_approved_task_handover(
            $task_id,
            $bending_department_id
        );

    if ($existing_handover) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'This CNC task has already been handed over to Bending.'
        ));
        return;
    }
    $this->db->trans_begin();

    if ($decision === 'approve') {

        $this->Production_model->update_cnc_task_supervisor_status(
            $task_id,
            'Approved'
        );

        $bending_task = array(
            'job_order_id'           => $task->job_order_id,
            'sales_order_id'         => $task->sales_order_id,
            'sales_order_product_id' => $task->sales_order_product_id,
            'department_id'          => $bending_department_id,
            'task_description'       => $task->task_description,
            'quantity'               => $task->quantity,
            'assigned_employee_id'   => null,
            'assigned_by'            => $approved_by,
            'priority'               => $task->priority,
            'status'                 => 'Pending',
            'remarks'                => $remarks !== ''
                                        ? $remarks
                                        : 'Handed over from CNC.',
            'created_at'             => date('Y-m-d H:i:s')
        );

        $bending_task_id =  $this->Production_model->create_production_task(
                $bending_task
            );

        if (!$bending_task_id) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'status'  => false,
                'message' => 'Unable to create Bending task.'
            ));
            return;
        }

        $this->Production_model->insert_task_status_history(array(
            'task_id'    => $bending_task_id,
            'old_status' => null,
            'new_status' => 'Pending',
            'changed_by' => $approved_by,
            'remarks'    => 'Task received from CNC after supervisor approval.',
            'changed_at' => date('Y-m-d H:i:s')
        ));

        $this->Production_model->insert_task_status_history(array(
            'task_id'    => $task_id,
            'old_status' => 'Completed',
            'new_status' => 'Approved',
            'changed_by' => $approved_by,
            'remarks'    => $remarks !== ''
                                ? $remarks
                                : 'CNC approved and handed over to Bending.',
            'changed_at' => date('Y-m-d H:i:s')
        ));

        $this->Production_model->insert_task_handover(array(
            'from_task_id'      => $task_id,
            'from_department_id'=> 8,
            'to_department_id'  => $bending_department_id,
            'approved_by'       => $approved_by,
            'approval_status'   => 'Approved',
            'remarks'           => $remarks !== ''
                                        ? $remarks
                                        : 'Approved and handed over to Bending.',
            'handed_over_at'   => date('Y-m-d H:i:s')
        ));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();

            echo json_encode(array(
                'status'  => false,
                'message' => 'Unable to complete CNC handover.'
            ));
            return;
        }

        $this->db->trans_commit();

        echo json_encode(array(
            'status'           => true,
            'message'          => 'CNC task approved and handed over to Bending successfully.',
            'bending_task_id'  => $bending_task_id
        ));

        return;
    }

    $this->Production_model->update_cnc_task_supervisor_status(
        $task_id,
        'Rework'
    );

    /*
     * Status history.
     */
    $this->Production_model->insert_task_status_history(array(
        'task_id'    => $task_id,
        'old_status' => 'Completed',
        'new_status' => 'Rework',
        'changed_by' => $approved_by,
        'remarks'    => $remarks,
        'changed_at' => date('Y-m-d H:i:s')
    ));

 
    $this->Production_model->insert_task_handover(array(
        'from_task_id'       => $task_id,
        'from_department_id' => 8,
        'to_department_id'   => 8,
        'approved_by'        => $approved_by,
        'approval_status'    => 'Rework',
        'remarks'            => $remarks,
        'handed_over_at'     => date('Y-m-d H:i:s')
    ));

    if ($this->db->trans_status() === false) {
        $this->db->trans_rollback();

        echo json_encode(array(
            'status'  => false,
            'message' => 'Unable to send CNC task for rework.'
        ));
        return;
    }

    $this->db->trans_commit();

    echo json_encode(array(
        'status'  => true,
        'message' => 'CNC task has been sent back for rework.'
    ));
}

public function get_task_handover_by_task_id($task_id)
{
    return $this->db
        ->where('from_task_id', (int)$task_id)
        ->order_by('handover_id', 'DESC')
        ->limit(1)
        ->get('production_task_handover')
        ->row();
}


public function update_cnc_task_supervisor_status($task_id, $status)
{
    return $this->db
        ->where('task_id', (int)$task_id)
        ->where('department_id', 8)
        ->update('production_tasks', array(
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ));
}


public function create_production_task($data)
{
    $this->db->insert('production_tasks', $data);

    if ($this->db->affected_rows() <= 0) {
        return false;
    }

    return $this->db->insert_id();
}


public function insert_task_status_history($data)
{
    return $this->db->insert(
        'production_task_status_history',
        $data
    );
}

public function insert_task_handover($data)
{
    return $this->db->insert(
        'production_task_handover',
        $data
    );
}
public function get_cnc_task_for_approval()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid CNC task.'
        ));
        return;
    }

    $task = $this->Production_model->get_cnc_task_for_approval($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'CNC task not found.'
        ));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'data'   => $task
    ));
}

/*
BENDING SECTION
*/
/* =========================================================
 * BENDING SUPERVISOR
 * Department ID = 10
 * ========================================================= */

/**
 * Bending Supervisor page
 */
public function bending_supervisor()
{
    $data['title'] = 'Bending Supervisor';
    $data['main_content'] = 'production/bending_supervisor';

    $this->load->view(
        'includes/template',
        $data
    );
}


/**
 * Get tasks received by Bending department
 *
 * CNC hands over to department 9.
 * Employee is NOT assigned during handover.
 */
public function get_bending_supervisor_tasks()
{
    $data =
        $this->Production_model
            ->get_bending_supervisor_tasks();

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/**
 * Get Bending employees
 *
 * IMPORTANT:
 * employee_master is the employee table.
 */
public function get_bending_employees()
{
    $employees =
        $this->Production_model
            ->get_bending_employees();

    echo json_encode(array(
        'status' => true,
        'data'   => $employees
    ));
}


/**
 * Assign a Bending task to an employee
 */
public function assign_bending_employee()
{
    $task_id =
        (int)$this->input->post('task_id');

    $employee_id =
        (int)$this->input->post('employee_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    if (!$employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Please select Bending employee.'
        ));
        return;
    }


    /*
     * Make sure selected employee actually belongs
     * to Bending department.
     */
    $employee = $this->Production_model->get_bending_employee($employee_id);

    if (!$employee) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid Bending employee.'
        ));
        return;
    }


    /*
     * Make sure task belongs to Bending department.
     */
    $task =
        $this->Production_model
            ->get_bending_task_by_id($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Bending task not found.'
        ));
        return;
    }


    /*
     * Assign employee.
     */
    $result =
        $this->Production_model
            ->assign_bending_employee(
                $task_id,
                $employee_id
            );

    if ($result) {

        echo json_encode(array(
            'status'  => true,
            'message' => 'Task assigned to Bending employee successfully.'
        ));

    } else {

        echo json_encode(array(
            'status'  => false,
            'message' => 'Unable to assign task.'
        ));
    }
}


/**
 * Get one Bending task
 */
public function get_bending_task()
{
    $task_id =
        (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $task =
        $this->Production_model
            ->get_bending_task_by_id($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Bending task not found.'
        ));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'data'   => $task
    ));
}


/**
 * Save Bending Supervisor note
 */
public function save_bending_supervisor_note()
{
    $task_id = (int)$this->input->post('task_id');

    $note_type = trim($this->input->post('note_type'));

    $note = trim($this->input->post('note'));
    $user_id = $this->session->userdata('user_id');

    if (!$user_id) {
        $user_id = $this->session->userdata('employee_id');
    }


    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }


    if ($note === '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Please enter note.'
        ));
        return;
    }


    /*
     * Verify task belongs to Bending.
     */
    $task =
        $this->Production_model
            ->get_bending_task_by_id($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Bending task not found.'
        ));
        return;
    }


    /*
     * IMPORTANT:
     * Do not trust added_by_role from AJAX.
     *
     * This is a supervisor note.
     */
    $data = array(
        'task_id'     => $task_id,
        'employee_id' => $user_id,
        'note_type'   => $note_type
            ? $note_type
            : 'General',
        'note'        => $note,
        'added_by_role' =>"Supervisor"
    );


    $result =
        $this->Production_model
            ->insert_bending_supervisor_note($data);


    if ($result) {

        echo json_encode(array(
            'status'  => true,
            'message' => 'Supervisor note saved successfully.'
        ));

    } else {

        echo json_encode(array(
            'status'  => false,
            'message' => 'Unable to save supervisor note.'
        ));
    }
}


/**
 * Get task timeline
 */
public function get_bending_supervisor_timeline()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }


    $task = $this->Production_model->get_bending_task_by_id($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Bending task not found.'
        ));
        return;
    }


    $timeline = $this->Production_model->get_bending_task_timeline($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $timeline
    ));
}


/**
 * Get status history
 */
public function get_bending_task_status_history()
{
    $task_id =
        (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }


    $history = $this->Production_model->get_bending_task_status_history($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $history
    ));
}
/* =========================================================
 * BENDING EMPLOYEE PAGE
 * ========================================================= */
public function bending_employee()
{
    $employee_id = (int) $this->session->userdata('employee_id');

    if (!$employee_id) {
        show_error('Employee account is not linked to employee_master.');
        return;
    }

    // Validate employee belongs to Bending
    $employee = $this->Production_model->get_bending_employee($employee_id);

    if (!$employee) {
        show_error('Invalid Bending employee account.');
        return;
    }
    $data['title'] = "Bending Tasks";
    $data['employee'] = $employee;
    $data['main_content'] = 'production/bending_employee';
    $this->load->view('includes/template', $data);
}


/* =========================================================
 * GET BENDING EMPLOYEE TASKS
 * ========================================================= */
public function get_bending_employee_tasks()
{
    $employee_id = (int) $this->session->userdata('employee_id');

    if (!$employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Employee session not found.',
            'data'    => array()
        ));
        return;
    }

    $employee = $this->Production_model->get_bending_employee($employee_id);

    if (!$employee) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid Bending employee.',
            'data'    => array()
        ));
        return;
    }

    $data = $this->Production_model->get_bending_employee_tasks($employee_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/* =========================================================
 * GET ONE BENDING TASK FOR EMPLOYEE
 * ========================================================= */
public function get_bending_employee_task()
{
    $task_id = (int) $this->input->post('task_id');

    $employee_id = (int) $this->session->userdata('employee_id');

    if (!$task_id || !$employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid request.'
        ));
        return;
    }

    $task = $this->Production_model->get_bending_task_for_employee(
        $task_id,
        $employee_id
    );

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task not found or not assigned to you.'
        ));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'data'   => $task
    ));
}


/* =========================================================
 * UPDATE BENDING EMPLOYEE TASK STATUS
 * ========================================================= */
public function update_bending_employee_task_status()
{
    $task_id = (int) $this->input->post('task_id');

    $new_status = trim($this->input->post('status'));
    $remarks    = trim($this->input->post('remarks'));

    $employee_id = (int) $this->session->userdata('employee_id');

    if (!$task_id || !$employee_id || $new_status == '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid request.'
        ));
        return;
    }

    /*
     * Always fetch the current task from DB.
     * Do NOT trust old_status from JavaScript.
     */
    $task = $this->Production_model->get_bending_task_for_employee(
        $task_id,
        $employee_id
    );

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task not found or not assigned to you.'
        ));
        return;
    }

    $old_status = trim($task->status);

    /*
     * Validate allowed employee transitions.
     */
    $allowed = false;

    $old = strtolower($old_status);
    $new = strtolower($new_status);

    if ($old == 'pending' && $new == 'in progress') {
        $allowed = true;
    }

    if (
        ($old == 'in progress' ||
         $old == 'started' ||
         $old == 'working')
        &&
        ($new == 'hold' || $new == 'on hold')
    ) {
        $allowed = true;
    }

    if (
        ($old == 'in progress' ||
         $old == 'started' ||
         $old == 'working')
        &&
        $new == 'completed'
    ) {
        $allowed = true;
    }

    if (
        ($old == 'hold' || $old == 'on hold')
        &&
        ($new == 'in progress' || $new == 'resume')
    ) {
        $allowed = true;
    }

    /*
     * Allow employee to start rework.
     */
    if (
        ($old == 'rework' ||
         $old == 'qc rework' ||
         $old == 'rejected')
        &&
        $new == 'in progress'
    ) {
        $allowed = true;
    }

    if (!$allowed) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid status transition.'
        ));
        return;
    }

    /*
     * Hold and Complete require a note.
     */
    if (
        ($new == 'hold' || $new == 'on hold' || $new == 'completed')
        &&
        $remarks == ''
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Please enter a note before changing the task to ' . $new_status . '.'
        ));
        return;
    }

    $result = $this->Production_model
        ->update_bending_employee_task_status(
            $task_id,
            $employee_id,
            $old_status,
            $new_status,
            $remarks
        );

    echo json_encode($result);
}


/* =========================================================
 * SAVE BENDING EMPLOYEE NOTE
 * ========================================================= */
public function save_bending_employee_note()
{
    $task_id   = (int) $this->input->post('task_id');
    $note_type = trim($this->input->post('note_type'));
    $note      = trim($this->input->post('note'));

    $employee_id = (int) $this->session->userdata('employee_id');

    if (!$task_id || !$employee_id || $note == '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Please enter a note.'
        ));
        return;
    }

    /*
     * Confirm task belongs to logged-in employee.
     */
    $task = $this->Production_model->get_bending_task_for_employee(
        $task_id,
        $employee_id
    );

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'You are not allowed to add a note to this task.'
        ));
        return;
    }

    /*
     * IMPORTANT:
     * employee_id comes from SESSION.
     * Never accept employee_id / role from JavaScript.
     */
    $data = array(
        'task_id'     => $task_id,
        'employee_id' => $employee_id,
        'note_type'   => ($note_type != '' ? $note_type : 'General'),
        'note'        => $note,
        'created_at'  => date('Y-m-d H:i:s')
    );

    $result = $this->Production_model
        ->insert_bending_employee_note($data);

    echo json_encode($result);
}


/* =========================================================
 * GET BENDING EMPLOYEE STATUS HISTORY
 * ========================================================= */
public function get_bending_employee_status_history()
{
    $task_id = (int) $this->input->post('task_id');

    $employee_id = (int) $this->session->userdata('employee_id');

    if (!$task_id || !$employee_id) {
        echo json_encode(array(
            'status' => false,
            'data'   => array()
        ));
        return;
    }

    /*
     * Employee can see history only for own task.
     */
    $task = $this->Production_model->get_bending_task_for_employee(
        $task_id,
        $employee_id
    );

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Unauthorized task.'
        ));
        return;
    }

    $data = $this->Production_model->get_bending_employee_status_history($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/* =========================================================
 * GET BENDING EMPLOYEE TIMELINE
 * ========================================================= */
public function get_bending_employee_timeline()
{
    $task_id = (int) $this->input->post('task_id');

    $employee_id = (int) $this->session->userdata('employee_id');

    if (!$task_id || !$employee_id) {
        echo json_encode(array(
            'status' => false,
            'data'   => array()
        ));
        return;
    }

    /*
     * Employee can see timeline only for own task.
     */
    $task = $this->Production_model->get_bending_task_for_employee(
        $task_id,
        $employee_id
    );

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Unauthorized task.'
        ));
        return;
    }

    $data = $this->Production_model->get_bending_employee_timeline($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}

/* =========================================================
 * BENDING SUPERVISOR V2
 *
 * NEW CONTROLLER FUNCTIONS
 * Existing functions remain untouched.
 * ========================================================= */


/**
 * Bending Supervisor V2 page
 */
public function bending_supervisor_v2()
{
    $data['title'] = 'Bending Supervisor';
    $data['main_content'] = 'production/bending_supervisor';

    $this->load->view(
        'includes/template',
        $data
    );
}


/**
 * Get Bending Supervisor tasks V2
 */
public function get_bending_supervisor_tasks_v2()
{
    $data = $this->Production_model
        ->get_bending_supervisor_tasks_v2();

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/**
 * Get Bending employees V2
 */
public function get_bending_employees_v2()
{
    $data = $this->Production_model
        ->get_bending_employees_v2();

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/**
 * Get one Bending task V2
 */
public function get_bending_task_v2()
{
    $task_id = (int) $this->input->post(
        'task_id'
    );

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $task = $this->Production_model
        ->get_bending_task_v2($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Bending task not found.'
        ));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'data'   => $task
    ));
}


/**
 * Assign / Reassign employee V2
 */
public function assign_bending_employee_v2()
{
    $task_id = (int) $this->input->post(
        'task_id'
    );

    $employee_id = (int) $this->input->post(
        'employee_id'
    );

    if (!$task_id || !$employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task and employee are required.'
        ));
        return;
    }

    /*
     * Get logged-in user.
     */
    $user_id = (int) $this->session
        ->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'User session expired.'
        ));
        return;
    }

    /*
     * Get actual users record.
     */
    $user = $this->db
        ->select("
            user_id,
            employee_id,
            dept_id,
            desig_id
        ")
        ->from('users')
        ->where(
            'user_id',
            $user_id
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();

    if (!$user) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid user.'
        ));
        return;
    }

    /*
     * Bending Supervisor:
     *
     * Department = 10
     * Designation = 20
     */
    if (
        (int) $user->dept_id !== 10 ||
        (int) $user->desig_id !== 20
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Bending Supervisor can assign employees.'
        ));
        return;
    }

    if (!(int) $user->employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Supervisor employee account is not linked.'
        ));
        return;
    }

    $result = $this->Production_model
        ->assign_bending_employee_v2(
            $task_id,
            $employee_id,
            (int) $user->employee_id
        );

    echo json_encode($result);
}


/**
 * Approve / Rework / Handover V2
 */
public function update_bending_supervisor_status_v2()
{
    $task_id = (int) $this->input->post(
        'task_id'
    );

    $status = trim(
        $this->input->post('status')
    );

    $next_department_id = (int)
        $this->input->post(
            'next_department_id'
        );

    $remarks = trim(
        $this->input->post('remarks')
    );

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    if ($status === '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Status is required.'
        ));
        return;
    }

    /*
     * Get logged-in user.
     */
    $user_id = (int) $this->session
        ->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'User session expired.'
        ));
        return;
    }

    /*
     * Get users record.
     */
    $user = $this->db
        ->select("
            user_id,
            employee_id,
            dept_id,
            desig_id
        ")
        ->from('users')
        ->where(
            'user_id',
            $user_id
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();

    if (!$user) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid user.'
        ));
        return;
    }

    /*
     * Bending Supervisor only.
     */
    if (
        (int) $user->dept_id !== 10 ||
        (int) $user->desig_id !== 20
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Bending Supervisor can perform this action.'
        ));
        return;
    }

    if (!(int) $user->employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Supervisor employee account is not linked.'
        ));
        return;
    }

    $status_lower = strtolower($status);

    /*
     * APPROVE
     *
     * Bending 10 -> Polishing 11
     */
    if ($status_lower === 'approved') {

        if ($next_department_id !== 11) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Bending must hand over to Polishing.'
            ));
            return;
        }

        if ($remarks === '') {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Please enter handover remarks.'
            ));
            return;
        }

        $result = $this->Production_model
            ->bending_supervisor_approve_and_handover_v2(
                $task_id,
                (int) $user->employee_id,
                $next_department_id,
                $remarks
            );

        echo json_encode($result);
        return;
    }

    /*
     * REWORK
     *
     * Remains Bending 10.
     */
    if ($status_lower === 'rework') {

        if ($next_department_id !== 10) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Rework must remain in Bending.'
            ));
            return;
        }

        if ($remarks === '') {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Please enter the rework reason.'
            ));
            return;
        }

        $result = $this->Production_model
            ->bending_supervisor_rework_v2(
                $task_id,
                (int) $user->employee_id,
                $remarks
            );

        echo json_encode($result);
        return;
    }

    echo json_encode(array(
        'status'  => false,
        'message' => 'Invalid supervisor action.'
    ));
}


/**
 * Save Bending Supervisor Note V2
 */
public function save_bending_supervisor_note_v2()
{
    $task_id = (int) $this->input->post(
        'task_id'
    );

    $note_type = trim(
        $this->input->post('note_type')
    );

    $note = trim(
        $this->input->post('note')
    );

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    if ($note === '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Please enter a note.'
        ));
        return;
    }

    /*
     * Get logged-in user.
     */
    $user_id = (int) $this->session
        ->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'User session expired.'
        ));
        return;
    }

    $user = $this->db
        ->select("
            user_id,
            employee_id,
            dept_id,
            desig_id
        ")
        ->from('users')
        ->where(
            'user_id',
            $user_id
        )
        ->where(
            'active',
            1
        )
        ->get()
        ->row();

    if (!$user) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid user.'
        ));
        return;
    }

    if (
        (int) $user->dept_id !== 10 ||
        (int) $user->desig_id !== 20
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Bending Supervisor can add supervisor notes.'
        ));
        return;
    }

    if (!(int) $user->employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Supervisor employee account is not linked.'
        ));
        return;
    }

    $result = $this->Production_model
        ->insert_bending_supervisor_note_v2(
            $task_id,
            (int) $user->employee_id,
            $note_type,
            $note
        );

    echo json_encode($result);
}


/**
 * Bending Supervisor Timeline V2
 */
public function get_bending_supervisor_timeline_v2()
{
    $task_id = (int) $this->input->post(
        'task_id'
    );

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $task = $this->Production_model
        ->get_bending_task_v2($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Bending task not found.'
        ));
        return;
    }

    $data = $this->Production_model
        ->get_bending_supervisor_timeline_v2(
            $task_id
        );

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/**
 * Bending Supervisor Handover Details V2
 */
public function get_bending_task_handover_v2()
{
    $task_id = (int) $this->input->post(
        'task_id'
    );

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $data = $this->Production_model
        ->get_bending_task_handover_v2(
            $task_id
        );

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}

/* =========================================================
 * POLISHING SUPERVISOR
 * Department = 11
 * Designation = 22
 * ========================================================= */

public function polishing_supervisor_v2()
{
        $user = $this->session->userdata('user_id');

        /*if (!has_access($user, 'Production/cnc_tasks', 'A')) {
            $data['title'] = 'Access Denied';
            $data['main_content'] = 'errors/access_control.php';
        } else {*/
            $data['title'] = 'Polishing Production Tasks';
            $data['main_content'] = 'production/polishing_supervisor_v2.php';
            $this->load->view(
                'includes/template',
                $data
            );
       // }

}


/* =========================================================
 * GET POLISHING SUPERVISOR TASKS
 * ========================================================= */

public function get_polishing_supervisor_tasks_v2()
{
    $data = $this->Production_model
        ->get_polishing_supervisor_tasks_v2();

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/* =========================================================
 * GET POLISHING EMPLOYEES
 * ========================================================= */

public function get_polishing_employees_v2()
{
    $data = $this->Production_model
        ->get_polishing_employees_v2();

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/* =========================================================
 * GET ONE POLISHING TASK
 * ========================================================= */

public function get_polishing_task_v2()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $task = $this->Production_model->get_polishing_task_v2($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Polishing task not found.'
        ));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'data'   => $task
    ));
}


/* =========================================================
 * ASSIGN / REASSIGN POLISHING EMPLOYEE
 * ========================================================= */

public function polishing_employee_v2()
{
    $user_id = (int)$this->session->userdata('user_id');
    $employee = null;

    if ($user_id) {
        $user = $this->db
            ->select('employee_id, dept_id, desig_id')
            ->from('users')
            ->where('user_id', $user_id)
            ->where('active', 1)
            ->get()
            ->row();

        if ($user && (int)$user->dept_id === 11 && (int)$user->desig_id === 23) {
            $employee = $this->Production_model
                ->get_polishing_employee_v2((int)$user->employee_id);
        }
    }

    $this->load->view('production/polishing_employee_v2', array(
        'employee' => $employee
    ));
}

/* =========================================================
 * POLISHING SUPERVISOR STATUS
 * Approve / Rework
 * ========================================================= */

public function update_polishing_supervisor_status_v2()
{
    $task_id = (int)$this->input->post('task_id');
    $status = trim($this->input->post('status'));
    $remarks = trim($this->input->post('remarks'));
    $next_department_id =
        (int)$this->input->post('next_department_id');

    if (!$task_id || !$status) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task ID and status are required.'
        ));
        return;
    }

    $user_id = (int)$this->session->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Session expired. Please login again.'
        ));
        return;
    }

    $user = $this->db
        ->select('user_id, employee_id, dept_id, desig_id')
        ->from('users')
        ->where('user_id', $user_id)
        ->where('active', 1)
        ->get()
        ->row();

    if (!$user) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid user.'
        ));
        return;
    }

    /*
     * Polishing Supervisor
     */
    if (
        (int)$user->dept_id !== 11 ||
        (int)$user->desig_id !== 22
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Polishing Supervisor can perform this action.'
        ));
        return;
    }

    $supervisor_employee_id = (int)$user->employee_id;

    if (!$supervisor_employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Supervisor employee link not found.'
        ));
        return;
    }

    $task = $this->Production_model
        ->get_polishing_task_v2($task_id);

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Polishing task not found.'
        ));
        return;
    }

    if ((int)$task->department_id !== 11) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'This task does not belong to Polishing.'
        ));
        return;
    }


    /* -----------------------------------------------------
     * APPROVE
     * ----------------------------------------------------- */

    if (strtolower($status) === 'approved') {

        if (!$next_department_id) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Next department is required.'
            ));
            return;
        }

        /*
         * Polishing -> Joining/Fixing
         */
        if ($next_department_id !== 12) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid next department for Polishing.'
            ));
            return;
        }

        $allowed_statuses = array(
            'completed',
            'supervisor review',
            'review'
        );

        if (!in_array(
            strtolower(trim($task->status)),
            $allowed_statuses
        )) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Only completed/review tasks can be approved.'
            ));
            return;
        }

        $result = $this->Production_model
            ->polishing_supervisor_approve_and_handover_v2(
                $task_id,
                $supervisor_employee_id,
                $next_department_id,
                $remarks
            );

        echo json_encode($result);
        return;
    }


    /* -----------------------------------------------------
     * REWORK
     * ----------------------------------------------------- */

    if (strtolower($status) === 'rework') {

        if ($remarks === '') {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Rework reason is required.'
            ));
            return;
        }

        $result = $this->Production_model
            ->polishing_supervisor_rework_v2(
                $task_id,
                $supervisor_employee_id,
                $remarks
            );

        echo json_encode($result);
        return;
    }


    echo json_encode(array(
        'status'  => false,
        'message' => 'Invalid supervisor status.'
    ));
}


/* =========================================================
 * SAVE POLISHING SUPERVISOR NOTE
 * ========================================================= */

public function save_polishing_supervisor_note_v2()
{
    $task_id = (int)$this->input->post('task_id');
    $note_type = trim($this->input->post('note_type'));
    $note = trim($this->input->post('note'));

    if (!$task_id || $note === '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task and note are required.'
        ));
        return;
    }

    $user_id = (int)$this->session->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Session expired.'
        ));
        return;
    }

    $user = $this->db
        ->select('employee_id, dept_id, desig_id')
        ->from('users')
        ->where('user_id', $user_id)
        ->where('active', 1)
        ->get()
        ->row();

    if (!$user) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid user.'
        ));
        return;
    }

    if (
        (int)$user->dept_id !== 11 ||
        (int)$user->desig_id !== 22
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Polishing Supervisor can add this note.'
        ));
        return;
    }

    $result = $this->Production_model
        ->insert_polishing_supervisor_note_v2(
            $task_id,
            (int)$user->employee_id,
            $note_type,
            $note
        );

    echo json_encode($result);
}


/* =========================================================
 * POLISHING SUPERVISOR TIMELINE
 * ========================================================= */

public function get_polishing_supervisor_timeline_v2()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $data = $this->Production_model
        ->get_polishing_supervisor_timeline_v2($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/* =========================================================
 * GET POLISHING HANDOVER
 * ========================================================= */

public function get_polishing_task_handover_v2()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $data = $this->Production_model
        ->get_polishing_task_handover_v2($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}

/* =========================================================
 * POLISHING EMPLOYEE
 * Department = 11
 * Designation = 23
 * ========================================================= */
/*
public function polishing_employee_v2()
{
    $this->load->view('production/polishing_employee_v2');
}
*/

/* =========================================================
 * GET MY POLISHING TASKS
 * ========================================================= */

public function get_polishing_employee_tasks_v2()
{
    $user_id = (int)$this->session->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Session expired.'
        ));
        return;
    }

    $user = $this->db
        ->select('employee_id, dept_id, desig_id')
        ->from('users')
        ->where('user_id', $user_id)
        ->where('active', 1)
        ->get()
        ->row();

    if (!$user) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid user.'
        ));
        return;
    }

    if (
        (int)$user->dept_id !== 11 ||
        (int)$user->desig_id !== 23
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Polishing Employee can access these tasks.'
        ));
        return;
    }

    $employee_id = (int)$user->employee_id;

    if (!$employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Employee link not found.'
        ));
        return;
    }

    $data = $this->Production_model
        ->get_polishing_employee_tasks_v2($employee_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/* =========================================================
 * GET ONE EMPLOYEE TASK
 * ========================================================= */

public function get_polishing_employee_task_v2()
{
    $task_id = (int)$this->input->post('task_id');

    $user_id = (int)$this->session->userdata('user_id');

    if (!$user_id || !$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid request.'
        ));
        return;
    }

    $user = $this->db
        ->select('employee_id, dept_id, desig_id')
        ->from('users')
        ->where('user_id', $user_id)
        ->where('active', 1)
        ->get()
        ->row();

    if (
        !$user ||
        (int)$user->dept_id !== 11 ||
        (int)$user->desig_id !== 23
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid Polishing Employee.'
        ));
        return;
    }

    $task = $this->Production_model
        ->get_polishing_task_for_employee_v2(
            $task_id,
            (int)$user->employee_id
        );

    if (!$task) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task is not assigned to you.'
        ));
        return;
    }

    echo json_encode(array(
        'status' => true,
        'data'   => $task
    ));
}


/* =========================================================
 * UPDATE EMPLOYEE TASK STATUS
 * ========================================================= */

public function update_polishing_employee_task_status_v2()
{
    $task_id = (int)$this->input->post('task_id');
    $status = trim($this->input->post('status'));
    $remarks = trim($this->input->post('remarks'));

    if (!$task_id || !$status) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task ID and status are required.'
        ));
        return;
    }

    $user_id = (int)$this->session->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Session expired.'
        ));
        return;
    }

    $user = $this->db
        ->select('employee_id, dept_id, desig_id')
        ->from('users')
        ->where('user_id', $user_id)
        ->where('active', 1)
        ->get()
        ->row();

    if (!$user) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid user.'
        ));
        return;
    }

    if (
        (int)$user->dept_id !== 11 ||
        (int)$user->desig_id !== 23
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Polishing Employee can update this task.'
        ));
        return;
    }

    $employee_id = (int)$user->employee_id;

    if (!$employee_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Employee link not found.'
        ));
        return;
    }

    $result = $this->Production_model
        ->update_polishing_employee_task_status_v2(
            $task_id,
            $employee_id,
            $status,
            $remarks
        );

    echo json_encode($result);
}


/* =========================================================
 * SAVE EMPLOYEE NOTE
 * ========================================================= */

public function save_polishing_employee_note_v2()
{
    $task_id = (int)$this->input->post('task_id');
    $note_type = trim($this->input->post('note_type'));
    $note = trim($this->input->post('note'));

    if (!$task_id || $note === '') {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Task and note are required.'
        ));
        return;
    }

    $user_id = (int)$this->session->userdata('user_id');

    if (!$user_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Session expired.'
        ));
        return;
    }

    $user = $this->db
        ->select('employee_id, dept_id, desig_id')
        ->from('users')
        ->where('user_id', $user_id)
        ->where('active', 1)
        ->get()
        ->row();

    if (
        !$user ||
        (int)$user->dept_id !== 11 ||
        (int)$user->desig_id !== 23
    ) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Only Polishing Employee can add work notes.'
        ));
        return;
    }

    $result = $this->Production_model
        ->insert_polishing_employee_note_v2(
            $task_id,
            (int)$user->employee_id,
            $note_type,
            $note
        );

    echo json_encode($result);
}


/* =========================================================
 * EMPLOYEE STATUS HISTORY
 * ========================================================= */

public function get_polishing_employee_status_history_v2()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $data = $this->Production_model
        ->get_polishing_employee_status_history_v2($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}


/* =========================================================
 * EMPLOYEE TIMELINE
 * ========================================================= */

public function get_polishing_employee_timeline_v2()
{
    $task_id = (int)$this->input->post('task_id');

    if (!$task_id) {
        echo json_encode(array(
            'status'  => false,
            'message' => 'Invalid task.'
        ));
        return;
    }

    $data = $this->Production_model
        ->get_polishing_employee_timeline_v2($task_id);

    echo json_encode(array(
        'status' => true,
        'data'   => $data
    ));
}
}
