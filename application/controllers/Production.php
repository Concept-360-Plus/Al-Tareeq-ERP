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

        $job_order_id = $this->Production_model->save_job_order(
            $job_order_data,
            $items
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
            $data['items'] = $this->Production_model->get_job_order_items($job_order_id);
            $data['main_content'] = 'job_order/edit.php';
        }
		
        $this->load->view('includes/template', $data);
    }
    /*
     * Update Job Order
     */
public function update()
{
    $job_order_id = $this->input->post('job_order_id');

    if (!$job_order_id) {

        echo json_encode([
            'status' => false,
            'message' => 'Invalid Job Order.'
        ]);

        return;
    }

    $job_order_data = array(
        //'fk_project_id'  => $this->input->post('fk_project_id'),
        'order_date'     => $this->input->post('order_date'),
        'order_no'       => $this->input->post('order_no'),
        'rep_name'       => $this->input->post('rep_name'),
        'contact_person' => $this->input->post('contact_person'),
        'remarks'        => $this->input->post('remarks'),
        'start_date'     => $this->input->post('start_date'),
        'finish_date'    => $this->input->post('finish_date')
    );

    $result = $this->Production_model->update_job_order(
        $job_order_id,
        $job_order_data
    );

    echo json_encode([
        'status' => $result,
        'message' => $result
            ? 'Job Order updated successfully.'
            : 'Unable to update Job Order.'
    ]);
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

        $jobOrderType = $this->input->post('job_order_type');

        $projectId   = null;
        $salesOrderId = null;


        // =============================================
        // 2. VALIDATE TYPE
        // =============================================

        if ($jobOrderType == 1) {

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

            'job_order_no' => $this->input->post('job_order_no'),

            'job_order_type' => $jobOrderType,

            'fk_project_id' => $projectId,

            'fk_sales_order_id' => $salesOrderId,

            'order_date' => $this->input->post('order_date'),

            'order_no' => $this->input->post('order_no'),

            'rep_name' => $this->input->post('rep_name'),

            'contact_person' => $this->input->post('contact_person'),

            'remarks' => $this->input->post('remarks'),

            'start_date' => $this->input->post('start_date'),

            'finish_date' => $this->input->post('finish_date')
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

        if ($jobOrderType == 1) {

            // PROJECT
            // Multiple Sales Orders

            $salesOrderIds = $this->input->post('sales_order_ids');

            if (!empty($salesOrderIds) && is_array($salesOrderIds)) {

                foreach ($salesOrderIds as $salesOrderId) {

                    if (empty($salesOrderId)) {
                        continue;
                    }

                    $mappingData = [

                        'job_order_id' => $jobOrderId,

                        'so_id' => $salesOrderId
                    ];


                    $savedMapping = $this->Production_model
                        ->insert_job_order_sales_order($mappingData);


                    if (!$savedMapping) {

                        throw new Exception(
                            'Failed to save Sales Order mapping.'
                        );
                    }
                }
            }

        } else {

            // NORMAL SALES ORDER
            // Single Sales Order

            $mappingData = [

                'job_order_id' => $jobOrderId,

                'so_id' => $salesOrderId
            ];


            $savedMapping = $this->Production_model->insert_job_order_sales_order($mappingData);


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


        if (empty($items) || !is_array($items)) {

            throw new Exception(
                'Please select at least one item.'
            );
        }


        // =============================================
        // 7. GET MATERIALS
        // =============================================

        $materialsJson = $this->input->post(
            'job_order_materials'
        );


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
        // 8. SAVE ITEMS
        // =============================================

        foreach ($items as $item) {

            // -----------------------------------------
            // ITEM VALUES
            // -----------------------------------------

            $projectItemId = !empty(
                $item['project_item_id']
            )
                ? $item['project_item_id']
                : null;


            $itemMasterId = !empty(
                $item['item_master_id']
            )
                ? $item['item_master_id']
                : null;


            if (empty($itemMasterId)) {

                throw new Exception(
                    'Item master ID is missing.'
                );
            }


            // -----------------------------------------
            // INSERT JOB ORDER ITEM
            // -----------------------------------------

            $itemData = [

                'job_order_id' => $jobOrderId,

                'project_item_id' => $item['product_table_id'],

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


            $jobOrderItemId = $this->Production_model
                ->insert_job_order_item($itemData);


            if (!$jobOrderItemId) {

                throw new Exception(
                    'Failed to save job order item.'
                );
            }


            // =========================================
            // 9. FIND MATERIALS
            // =========================================

            $materials = [];


            // PROJECT ITEM
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


            // NORMAL SALES ORDER ITEM
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
                        ? $material['material_id']
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

                        // BOM MATERIAL

                        $materialRow = $this->db
                            ->select('cost')
                            ->from(
                                'amc_product_materials'
                            )
                            ->where(
                                'material_id',
                                $materialId
                            )
                            ->get()
                            ->row();

                    } else {

                        // MANUAL RAW MATERIAL

                        $materialRow = $this->db
                            ->select('cost')
                            ->from(
                                'amc_raw_materials'
                            )
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
                            $material['quantity']
                        )
                            ? $material['quantity']
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
        // 13. SUCCESS RESPONSE
        // =============================================

        echo json_encode([

            'status' => true,

            'message' =>
                'Job Order created successfully.',

            'job_order_id' =>
                $jobOrderId
        ]);

    } catch (Exception $e) {

        // =============================================
        // ROLLBACK
        // =============================================

        $this->db->trans_rollback();


        // =============================================
        // ERROR RESPONSE
        // =============================================

        echo json_encode([

            'status' => false,

            'message' => $e->getMessage()
        ]);
    }
}

    public function save_job_order_item_materials()
        {
            $project_item_id = $this->input->post('project_item_id');

            $job_order_id = $this->input->post('job_order_id');

            $materials = json_decode(
                    $this->input->post('materials'),
                    true
                );
            if (!$project_item_id) {

                echo json_encode([
                    'status' => false,
                    'message' => 'Project item not found.'
                ]);
                return;
            }
            if (empty($materials)) {

                echo json_encode([
                    'status' => false,
                    'message' => 'No materials found.'
                ]);

                return;
            }


            /*
            * Find job_order_item
            */

            $job_order_item = $this->Production_model->get_job_order_item(
                        $job_order_id,
                        $project_item_id
                    );
            if (!$job_order_item) {

                echo json_encode([
                    'status' => false,
                    'message' => 'Job Order item not found.'
                ]);

                return;
            }
            $this->db->trans_start();
            /*
            * Delete existing saved materials
            *
            * This allows editing the material list.
            */

            $this->Production_model->delete_job_order_item_materials(
                    $job_order_item->job_order_item_id
                );


            /*
            * Insert current list
            */

            foreach ($materials as $material) {
                if ($material['source'] == 'MANUAL') {

                        $manual_material = $this->db
                            ->select('cost')
                            ->where(
                                'material_id',
                                $material['material_id']
                            )->get('amc_material_requst')->row();
                        $cost = !empty($manual_material)? (float)$manual_material->cost : 0;
                } else {
                        // BOM material
                        $cost = !empty($material['cost'])? (float)$material['cost']: 0;
                }


                $data = [
                    'job_order_item_id' => $job_order_item->job_order_item_id,

                    'material_id' =>
                        !empty($material['material_id'])
                            ? $material['material_id']
                            : null,

                    'material_code' =>
                        isset($material['material_code'])
                            ? $material['material_code']
                            : null,

                    'material_name' =>
                        $material['material_name'],

                    'unit_id' =>
                        !empty($material['unit_id'])
                            ? $material['unit_id']
                            : null,

                    'unit' => isset($material['unit']) ? $material['unit'] : null,
                    'quantity_required' => $material['quantity_required'],
                    'cost' =>  isset( $cost)?  $cost : 0,
                    'source' => isset($material['source']) ? $material['source'] : 'MANUAL'
                ];
                $this->Production_model
                    ->insert_job_order_material(
                        $data
                    );

            }
           $this->db->trans_complete();
           if ($this->db->trans_status() === FALSE) {

                echo json_encode([
                    'status' => false,
                    'message' => 'Unable to save materials.'
                ]);

                return;
            }
            echo json_encode([
                'status' => true,
                'message' => 'Materials saved successfully.'
            ]);
        }
        //// EDIT JOB ORDER

    public function edit_job_order($job_order_id)
    {
        $data['title']  =   "Edit Job order";
        $data['job_order'] = $this->Production_model->get_job_ordere($job_order_id);
        $data['project'] = $this->Project_model->get_project_details($data['job_order']->fk_project_id);
        
        if (!$data['job_order']) {
            show_404();
        }
        $data['job_order_items'] =  $this->Production_model->get_job_order_itemse($job_order_id);
        foreach ($data['job_order_items'] as &$item) {

            $item->materials = $this->Production_model->get_job_order_item_materials(
                        $item->job_order_item_id
                    );
        }
        /*
        * Raw material dropdown
        */
        $data['raw_materials'] = $this->Production_model->get_raw_materialse();


        /*
        * Unit dropdown
        */
        $data['units'] = $this->Production_model->get_units();
        $data['main_content'] = 'job_order/edit.php';
        $this->load->view('includes/template', $data);

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
    $data['title'] = 'Production Material Requests';
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
    $data['title'] = 'Create Material Request';
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
    $data['title'] = 'View Material Request';
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
    $data['title'] = 'Edit Material Request';
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
                'Material Request updated successfully.'
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'message' =>
                'Unable to update Material Request.'
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
        $so_id = $this->input->post('sales_order_id');

        if (empty($so_id)) {

            echo json_encode(array());

            return;
        }
        $items = $this->Production_model->get_sales_order_items($so_id);
        echo json_encode($items);
    }
}
