<?php
class Project_model extends CI_Model
{
    public function insert_project($data)
    {
        $this->db->insert('project_master', $data);
        return $this->db->insert_id();
    }

    public function update_project($project_id, $data)
    {
        $this->db->where('project_id', $project_id);
        return $this->db->update('project_master', $data);
    }

    public function save_project_items($project_id, $items)
    {
        // Delete old items
        $this->db->where('project_id', $project_id)->delete('project_items');
        // Insert new items
        if(!empty($items)) $this->db->insert_batch('project_items', $items);
    }

    public function save_project_technicians($project_id, $techs)
    {
        // Delete old technicians
        $this->db->where('project_id', $project_id)->delete('project_technicians');
        // Insert new technicians
        if(!empty($techs)) $this->db->insert_batch('project_technicians', $techs);
    }
/*
public function get_project_by_id($id)
{
    return $this->db
        ->select('p.*, s.so_code')
        ->from('project_master p')
        ->join('sales_order_master s', 's.so_id = p.so_id', 'left')
        ->where('p.project_id', $id)
        ->get()
        ->row_array();
}
*/
public function get_project_by_id($id)
{
    return $this->db
        ->select('p.*,u.user_name')
        ->from('project_master p')
       // ->join('sales_order_master s', 's.so_id = p.so_id', 'left')
        ->join('users u', 'u.user_id = p.approver_id', 'left')
        ->where('p.project_id', $id)
        ->get()
        ->row_array();
}


    public function get_project_items($project_id)
    {
        return $this->db->get_where('project_items', ['project_id' => $project_id])->result_array();
    }


     // Fetch all active employees
    public function get_employees($id="") {
        $this->db->select('employee_id, employee_name');
        $this->db->from('employee_master');
        if($id)
            $this->db->where('designation_id',$id); //technician
        $this->db->order_by('employee_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Fetch all active designations
    public function get_designations() {
        $this->db->select('id, designation_name');
        $this->db->from('designation_master');
        $this->db->where('status', 'Active'); // only active designations
        $this->db->order_by('designation_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

public function get_project_technicians($project_id)
{
    return $this->db
        ->select('pt.*, em.employee_id, em.employee_name, dm.id as designation_id, dm.designation_name')
        ->from('project_technicians pt')
        ->join('employee_master em', 'em.employee_id = pt.technician_id', 'left')
        ->join('designation_master dm', 'dm.id = pt.designation_id', 'left')
        ->where('pt.project_id', $project_id)
        ->get()
        ->result_array();
}

public function add_project_manpower()
{
    $manpower_code = $this->input->post('manpower_code');

    if (empty($manpower_code)) {
        $last = $this->db->select('manpower_code')
            ->from('project_manpower')
            ->order_by('manpower_id', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        if ($last && !empty($last->manpower_code)) {
            $num = (int) substr($last->manpower_code, 4);
            $manpower_code = 'PMP-' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $manpower_code = 'PMP-0001';
        }
    }

    $data = array(
        'manpower_code' => $manpower_code,
        'project_id' => $this->input->post('project_id'),
        'remarks' => $this->input->post('remarks'),
        'approved_by' => $this->session->userdata('user_id'),
        'bit_active' => 1,
        'created_by' => $this->session->userdata('user_id'),
        'created_date' => date('Y-m-d H:i:s')
    );

    $this->db->insert('project_manpower', $data);
    $manpower_id = $this->db->insert_id();

    $designation_ids = $this->input->post('designation_id');
    $employee_ids = $this->input->post('employee_id');
    $roles = $this->input->post('role');
    $percentages = $this->input->post('allocation_percentage');
    $daily_hours = $this->input->post('daily_hours');
    $from_dates = $this->input->post('from_date');
    $to_dates = $this->input->post('to_date');
    $statuses = $this->input->post('status');
    $item_remarks = $this->input->post('item_remarks');

    if (!empty($designation_ids)) {
        $items = [];
        foreach ($designation_ids as $i => $designation_id) {
            if (empty($designation_id) || empty($employee_ids[$i])) {
                continue;
            }

            $items[] = array(
                'manpower_id' => $manpower_id,
                'designation_id' => $designation_id,
                'employee_id' => $employee_ids[$i],
                'role' => $roles[$i] ?? null,
                'allocation_percentage' => !empty($percentages[$i]) ? $percentages[$i] : 100.00,
                'daily_hours' => $daily_hours[$i] ?? null,
                'from_date' => !empty($from_dates[$i]) ? $from_dates[$i] : null,
                'to_date' => !empty($to_dates[$i]) ? $to_dates[$i] : null,
                'status' => $statuses[$i] ?? 'Assigned',
                'remarks' => $item_remarks[$i] ?? null
            );
        }

        if (!empty($items)) {
            $this->db->insert_batch('project_manpower_items', $items);
        }
    }

    return $manpower_id;
}

public function get_all_project_manpower($project_id)
{
    return $this->db
        ->select('pm.manpower_id, pm.manpower_code, pm.project_id, pm.remarks, pm.approved_by, pm.bit_active, pm.created_date, p.project_code, p.project_name, GROUP_CONCAT(DISTINCT d.designation_name ORDER BY d.designation_name SEPARATOR ", ") as designation_name, GROUP_CONCAT(DISTINCT e.employee_name ORDER BY e.employee_name SEPARATOR ", ") as employee_name, GROUP_CONCAT(DISTINCT pmi.status ORDER BY pmi.status SEPARATOR ", ") as status')
        ->from('project_manpower pm')
        ->join('project_master p', 'p.project_id = pm.project_id', 'left')
        ->join('project_manpower_items pmi', 'pmi.manpower_id = pm.manpower_id', 'left')
        ->join('designation_master d', 'd.id = pmi.designation_id', 'left')
        ->join('employee_master e', 'e.employee_id = pmi.employee_id', 'left')
        ->where('pm.project_id', $project_id)
        ->group_by('pm.manpower_id, pm.manpower_code, pm.project_id, pm.remarks, pm.approved_by, pm.bit_active, pm.created_date, p.project_code, p.project_name')
        ->order_by('pm.manpower_id', 'DESC')
        ->get()
        ->result_array();
}

public function get_project_manpower($id)
{
    $master = $this->db
        ->where('manpower_id', $id)
        ->get('project_manpower')
        ->row_array();

    if (!empty($master)) {
        $master['items'] = $this->db
            ->select('pmi.*, d.designation_name, e.employee_name')
            ->from('project_manpower_items pmi')
            ->join('designation_master d', 'd.id = pmi.designation_id', 'left')
            ->join('employee_master e', 'e.employee_id = pmi.employee_id', 'left')
            ->where('pmi.manpower_id', $id)
            ->order_by('pmi.item_id', 'ASC')
            ->get()
            ->result_array();
    }

    return $master;
}

public function update_project_manpower($id)
{
    $data = array(
        'manpower_code' => $this->input->post('manpower_code'),
        'project_id' => $this->input->post('project_id'),
        'remarks' => $this->input->post('remarks'),
        'approved_by' => $this->session->userdata('user_id'),
        'bit_active' => $this->input->post('bit_active') ?? 1,
        'updated_by' => $this->session->userdata('user_id'),
        'updated_date' => date('Y-m-d H:i:s')
    );

    $this->db->where('manpower_id', $id);
    $this->db->update('project_manpower', $data);

    $this->db->where('manpower_id', $id)->delete('project_manpower_items');

    $designation_ids = $this->input->post('designation_id');
    $employee_ids = $this->input->post('employee_id');
    $roles = $this->input->post('role');
    $percentages = $this->input->post('allocation_percentage');
    $daily_hours = $this->input->post('daily_hours');
    $from_dates = $this->input->post('from_date');
    $to_dates = $this->input->post('to_date');
    $statuses = $this->input->post('status');
    $item_remarks = $this->input->post('item_remarks');

    if (!empty($designation_ids)) {
        $items = [];
        foreach ($designation_ids as $i => $designation_id) {
            if (empty($designation_id) || empty($employee_ids[$i])) {
                continue;
            }

            $items[] = array(
                'manpower_id' => $id,
                'designation_id' => $designation_id,
                'employee_id' => $employee_ids[$i],
                'role' => $roles[$i] ?? null,
                'allocation_percentage' => !empty($percentages[$i]) ? $percentages[$i] : 100.00,
                'daily_hours' => $daily_hours[$i] ?? null,
                'from_date' => !empty($from_dates[$i]) ? $from_dates[$i] : null,
                'to_date' => !empty($to_dates[$i]) ? $to_dates[$i] : null,
                'status' => $statuses[$i] ?? 'Assigned',
                'remarks' => $item_remarks[$i] ?? null
            );
        }

        if (!empty($items)) {
            $this->db->insert_batch('project_manpower_items', $items);
        }
    }

    return true;
}

public function delete_project_manpower($id)
{
    $this->db->where('manpower_id', $id)->delete('project_manpower_items');
    $this->db->where('manpower_id', $id)->delete('project_manpower');
    return $this->db->affected_rows() >= 0;
}

public function get_all_projects()
{
    $this->db->select('
        p.project_id,
        p.project_code,
        p.project_name,
        p.customer_name,
        p.start_date,
        p.end_date,
        p.duration,
        p.grand_total,
        p.status
    ');
    $this->db->from('project_master p');
    $this->db->order_by('p.project_id', 'DESC');
    return $this->db->get()->result_array();
}

public function get_project_items_list($project_id)
{
     return $this->db
        ->select('pi.*, im.product_name as product_name')
        ->from('project_items pi')
        ->join('item_master im', 'im.product_id = pi.product_id', 'left')
        // ->join('unit_master u', 'u.unit_id = pi.unit_id', 'left') // if you also store unit_id in project_items
        ->where('pi.project_id', $project_id)
        ->get()
        ->result_array();
}



public function delete_project($project_id)
{
    // Optional: Delete related items or technicians if needed
    $this->db->where('project_id', $project_id);
    $this->db->delete('project_items');
    $this->db->where('project_id', $project_id);
    $this->db->delete('project_technicians');
    $this->db->where('project_id', $project_id);
    return $this->db->delete('project_master'); // Replace 'projects' with your actual table name
}

    
// TECHNICIAN AVAILABILITY
public function get_technician_availability($technician_id, $start_date, $end_date, $exclude_project_id = null)
{
    $this->db->from('project_technicians');
    $this->db->where('technician_id', $technician_id);
    $this->db->where('assignment_start <=', $end_date);
    $this->db->where('assignment_end >=', $start_date);

    if (!empty($exclude_project_id)) {
        $this->db->where('project_id !=', $exclude_project_id);
    }

    return $this->db->count_all_results() > 0 ? 'Not Available' : 'Available';
}


// public function is_technician_available($technician_id, $start_date, $end_date, $current_project_id = null)
// {
//     $this->db->select('*');
//     $this->db->from('project_technicians pt');
//     $this->db->join('project_master pm', 'pm.project_id = pt.project_id');
//     $this->db->where('pt.technician_id', $technician_id);

//     // Exclude the current project (for updates)
//     if ($current_project_id) {
//         $this->db->where('pt.project_id !=', $current_project_id);
//     }

//     // Check overlapping date ranges
//     $this->db->where('(pm.start_date <=', $end_date);
//     $this->db->where('pm.end_date >=', $start_date . ')', false); // false to prevent automatic escaping

//     $query = $this->db->get();

//     if ($query->num_rows() > 0) {
//         return false; // Technician is already booked
//     }
//     return true; // Technician is available
// }


public function is_technician_available($technician_id, $start_date, $end_date, $current_project_id = null)
{
    if (!$technician_id || !$start_date || !$end_date) {
        return true; // assume available if dates missing
    }

    $this->db->select('pt.id');
    $this->db->from('project_technicians pt');
    $this->db->where('pt.technician_id', $technician_id);

    // Exclude current project while editing
    if (!empty($current_project_id)) {
        $this->db->where('pt.project_id !=', $current_project_id);
    }

    // ✅ CORRECT overlap logic (assignment dates)
    $this->db->where('pt.assignment_start <=', $end_date);
    $this->db->where('pt.assignment_end >=', $start_date);

    $query = $this->db->get();

    // If any row exists → overlapping → NOT available
    return $query->num_rows() === 0;
}


public function get_technician_name($technician_id)
{
    $row = $this->db
        ->select('employee_name')
        ->from('employee_master')
        ->where('employee_id', $technician_id)
        ->get()
        ->row();

    return $row ? $row->employee_name : 'Unknown';
}

public function get_active_users()
{
    return $this->db->select('user_id, user_name')
                    ->from('users')
                    ->where('active', 1)
                    ->get()
                    ->result_array();
}

public function insert_work_order($data)
{
    $this->db->insert('work_order', $data);
    return $this->db->insert_id();
}

public function get_work_order($id)
{
    return $this->db->where('work_order_id', $id)->get('work_order')->row_array();
}

public function get_all_work_orders($project_id = null)
{
    $this->db->select('wo.*, pm.project_code, pm.project_name, pt.project_task_name, r.resource_code');
    $this->db->from('work_order wo');
    $this->db->join('project_master pm', 'pm.project_id = wo.project_id', 'left');
    $this->db->join('project_task pt', 'pt.id = wo.project_task_id', 'left');
    $this->db->join('project_machine_resource r', 'r.resource_id = wo.resource_id', 'left');

    if (!empty($project_id)) {
        $this->db->where('wo.project_id', $project_id);
    }

    $this->db->order_by('wo.work_order_id', 'DESC');
    return $this->db->get()->result_array();
}

public function update_work_order($id, $data)
{
    $this->db->where('work_order_id', $id);
    return $this->db->update('work_order', $data);
}

public function get_work_order_resources($project_id = null)
{
    $this->db->select('resource_id, resource_code, operation_name');
    $this->db->from('project_machine_resource');

    if (!empty($project_id)) {
        $this->db->where('project_id', $project_id);
    }

    $this->db->order_by('resource_id', 'ASC');
    return $this->db->get()->result_array();
}

//------------------MATERIAL REQUEST START---------------------//

// Insert MR master record
public function insert_mr($data)
{
    $this->db->insert('material_requests', $data);
    return $this->db->insert_id();
}

// Update MR (used for MR code)
// public function update_mr($mr_id, $data)
// {
//     $this->db->where('mr_id', $mr_id);
//     $this->db->update('material_requests', $data);
// }

// Save MR items
public function save_items($items)
{
    //$this->db->insert_batch('material_request_items', $items);
    $this->db->insert_batch('project_material_items', $items);

}
public function get_approved_projects()
{
    return $this->db->where('status', 'Approved')->get('project_master')->result_array();
}

public function get_all_mrs()
{
    return $this->db->select('mr.*, p.project_name, p.project_code, u.user_name as initiated_by_name')
                    ->from('material_requests mr')
                    ->join('project_master p', 'mr.project_id = p.project_id', 'left')
                    ->join('users u', 'mr.initiated_by = u.user_id', 'left')
                    ->order_by('mr.mr_id', 'DESC')
                    ->get()
                    ->result_array();
}


public function update_mr($mr_id, $data)
{
    return $this->db->where('mr_id', $mr_id)
                    ->update('material_requests', $data);
}



public function get_mr_by_id($mr_id)
{
    return $this->db->select('mr.*, p.project_name, p.project_code, u.user_name as initiated_by_name')
                    ->from('material_requests mr')
                    ->join('project_master p', 'mr.project_id = p.project_id', 'left')
                    ->join('users u', 'mr.initiated_by = u.user_id', 'left')
                    ->where('mr.mr_id', $mr_id)
                    ->get()
                    ->row_array();
}
/*
public function get_mr_items($mr_id)
{
    return $this->db
        ->select('mi.*, im.item_name as product_name')
        ->from('material_request_items mi')
        ->join('item_master im', 'im.item_id = mi.product_id', 'left')  
        ->where('mi.mr_id', $mr_id)
        ->get()
        ->result_array();
}
*/
public function get_mr_items($mr_id)
{
     return $this->db
        ->select('mi.*, im.product_name as product_name')
        ->from('project_material_items mi')
        ->join('item_master im', 'im.product_id = mi.fk_item_id', 'left')  
        ->where('mi.mr_id', $mr_id)
        ->get()
        ->result_array();
        //echo $this->db->last_query();
        //exit;
}
public function get_project_items_list_mr($project_id)
{
    return $this->db
        ->select('pi.*, im.product_name as product_name, im.unit_id') 
        ->from('project_items pi')
        ->join('item_master im', 'im.product_id = pi.product_id', 'left')
        ->where('pi.project_id', $project_id)
        ->get()
        ->result_array();
}
public function get_all_units()
{
    return $this->db->where('active', 1)->get('unit_master')->result_array();
}

// Delete MR master
public function delete_mr($mr_id)
{
    return $this->db->delete('material_requests', ['mr_id' => $mr_id]);
}

/*
public function delete_mr_items($mr_id)
{
    return $this->db->delete('material_request_items', ['mr_id' => $mr_id]);
}
    */
public function delete_mr_items($mr_id)
{
    return $this->db->delete('project_material_items', ['mr_id' => $mr_id]);
}



////----------------PROJECT PROGRESS START--------------

public function get_projects_with_progress()
{
    return $this->db
        ->select('p.*, pp.progress_percentage, pp.current_status')
        ->from('project_master p')
        ->join('project_progress pp', 'pp.project_id = p.project_id', 'left')
        ->where('p.status', 'Approved')
        ->get()
        ->result_array();
}

public function get_project_progress($project_id)
{
    return $this->db
        ->where('project_id', $project_id)
        ->get('project_progress')
        ->row_array();
}

public function get_project_progress_logs($project_id)
{
    return $this->db
        ->where('project_id', $project_id)
        ->order_by('log_date', 'DESC')
        ->get('project_progress_logs')
        ->result_array();
}

public function save_progress_log($data)
{
    $this->db->insert('project_progress_logs', $data);
}

public function update_project_progress($project_id, $percentage, $current_status)
{
    $exists = $this->db->where('project_id', $project_id)
                       ->get('project_progress')
                       ->row();

    if ($exists) {
        $this->db->where('project_id', $project_id)
                 ->update('project_progress', [
                     'progress_percentage' => $percentage,
                     'current_status'     => $current_status,
                     'last_updated' => date('Y-m-d H:i:s')
                 ]);
    } else {
        $this->db->insert('project_progress', [
            'project_id' => $project_id,
            'progress_percentage' => $percentage
        ]);
    }
}

// --------------------MATERIAL ISSUE----------------

// Get all pending material requests
public function get_pending_material_requests()
{
    $this->db->select('mr.*, p.project_name');
    $this->db->from('material_requests mr');
    $this->db->join('project_master p', 'p.project_id = mr.project_id', 'left');
    $this->db->where('mr.status', 'Pending'); // Only pending MRs
    $this->db->order_by('mr.requested_date', 'DESC');
    $query = $this->db->get();
    return $query->result_array();
}
public function get_total_issued_qty($mr_id, $product_id)
{
    $total_issued = (float) $this->db
        ->select_sum('issued_qty', 'total_issued')
        ->from('material_issue_items mii')
        ->join('material_issue mi', 'mi.mi_id = mii.mi_id')
        ->where('mi.mr_id', $mr_id)
        ->where('mii.product_id', $product_id)
        ->where('mi.status', 'Issued')
        ->get()
        ->row()->total_issued ?? 0;

    return $total_issued;
}

//NOTIFICATION

 public function get_overdue_projects()
    {
        $this->db->select("
            pm.project_id,
            pm.project_code,
            pm.project_name,
            pm.end_date,
            pp.current_status,
            DATEDIFF(CURDATE(), pm.end_date) AS overdue_days
        ");
        $this->db->from('project_master pm');
        $this->db->join('project_progress pp', 'pp.project_id = pm.project_id');
        $this->db->where('pm.end_date <', date('Y-m-d'));
        $this->db->where('pp.current_status !=', 'Completed');

        return $this->db->get()->result();
    }

        // SO IF ALREADY CREATED PROJECT
    public function is_project_created_for_so($so_id)
{
    $this->db->select('project_id');
    $this->db->from('project_master');
    $this->db->where('so_id', $so_id);
    $result = $this->db->get()->row();

    return !empty($result);
}

//PROJECT PROGRESS LOG
public function get_last_progress_log($project_id)
{
    return $this->db
        ->where('project_id', $project_id)
        ->order_by('created_at', 'DESC')
        ->limit(1)
        ->get('project_progress_logs')
        ->row_array();
}
    //Enquiry
    
    public function get_enquiries(){
        return $this->db
            ->select('e.enquiry_id,e.enquiry_code, c.customer_name')
            ->from('enquiry_master e')
            ->join('customer_master c', 'e.enquiry_customer = c.customer_id', 'left')
            ->where('e.active', 1)
            ->get()
            ->result_array();
    }

    public function getQuotationByEnquiry($eid=""){
        $where = array('active'=>1,'aproval'=>1);
        return $this->db
            ->select('qtn_id,quotation_code,quotation_type')
            ->where($where)
            ->order_by('qtn_id', 'ASC')
            ->get('quotation_master')
            ->result_array();

    }

    public function getProjectDetailsByEnquiry($eid){
        return $this->db
            ->select('e.project_name,e.project_location')
            ->where('enquiry_id', $eid)
            ->get('enquiry_master e')
            ->row_array();
    }

    public function getBranchDetailsByQuotation($qid){
        return $this->db
            ->select('b.branch_name')
            ->from('branch_master b')
            ->join('quotation_master q', 'q.quotation_branch_id = b.branch_id', 'left')
            ->where('q.qtn_id',$qid)
            ->get()
            ->row_array();
    }

     public function getcustomerDetailsByQuotation($qid){
        return $this->db
            ->select('c.customer_name,q.enquiry_id')
            ->from('customer_master c')
            ->join('quotation_master q', 'q.quotation_customer = c.customer_id', 'left')
            ->where('q.qtn_id',$qid)
            ->get()
            ->row_array();
    }
    public function get_all_products_by_quotation($q_id) {
   
        $this->db->select('qp.qty,qp.prd_id, qp.unit_price, im.product_name, u.unit_name');
        $this->db->from('quotation_products qp');
        $this->db->join('item_master im', 'im.product_id = qp.prd_id', 'left');
        $this->db->join('unit_master u', 'u.unit_id = qp.unit_id', 'left');
        $this->db->where('qp.qtn_id', $q_id);
        return $this->db->get()->result_array();
    }

    public function get_project_items_list_quotation($project_id){

        return $this->db
            ->select('pi.*, im.project_name as product_name, im.item_unit') 
            ->from('project_items pi')
            ->join('item_master im', 'im.product_id = pi.product_id', 'left')
            ->where('pi.project_id', $project_id)
            ->get()
            ->result_array();
    }

    public function get_all_items(){
        $where = array('is_inactive'=>0,'is_marked_delete'=>'0');
        return $this->db->select('product_id, product_name,product_code')
          ->from('item_master')
          ->where($where)
          ->get()->result_array();
          
    }

    public function get_projectRawmaterials($id){
        if($id){
           
        $sql =  "SELECT pj.product_id,pj.quantity,im.product_code,im.product_name,im.product_id as it_id FROM project_items pj
                LEFT JOIN item_master im
                ON im.product_id = pj.product_id 
                 where pj.project_id=?
            ";
        $query = $this->db->query($sql, array($id));
        $result = $query->result_array();
        $item_array = [];
        foreach($result as $k=>$res){
            $this->load->model('Setup_model');
            $rid = $res['it_id'];
            $item_array[$k]['item_id']  =  $res['it_id'];
            $item_array[$k]['pname']    =  $res['product_name']."(".$res['product_code'].")";
            $item_array[$k]['quantity'] =  $res['quantity'];
            $item_array[$k]['quantity'] =  $res['quantity'];
            $rows = $this->Setup_model->get_rawmaterials($rid);
            $item_array[$k]['raw'] = $rows;
        
        }
            return $item_array;
        }else
            return false;
    }

    //get tasks
    public function get_tasks(){
        return $this->db
            ->select('t.project_task_id,t.project_task_name')
            ->from('project_task_category t')
            ->where('t.bit_active', 1)
            ->get()
            ->result_array();
    }
    //get milestone
    public function get_milestones(){
        return $this->db
            ->select('m.milestone_id,m.milestone_name')
            ->from('project_milestone m')
            ->where('m.bit_active', 1)
            ->get()
            ->result_array();
    }
    //get designations
    public function getDesignation(){
        return $this->db
        ->select('designation_id, designation_name')
        ->where('bit_active',1)
        ->order_by('designation_name','ASC')
        ->get('designation_master')
        ->result_array();
    }
    //save project task
    public function save_project_task($data){
        $this->db->insert('project_task', $data);
        return $this->db->insert_id();
    }
    //update project task
    public function update_project_task($project_task_id, $data){
        $this->db->where('id', $project_task_id);
        return $this->db->update('project_task', $data);
    }
    //insert project task
    public function insert_project_task_items($items){
        if (!empty($items)) {
            return $data =$this->db->insert_batch('project_task_items', $items);
        }
    }
    //update project task
    public function save_project_task_items($project_task_id, $items){

        $this->db->where('project_task_id', $project_task_id);
        $this->db->delete('project_task_items');

        if (!empty($items)) {
            $this->db->insert_batch('project_task_items', $items);
        }
    }
    public function get_project_task($project_id)
    {
        return $this->db
            ->where('project_id',$project_id)
            ->get('project_task')
            ->row_array();
    }

    public function get_project_task_items($project_task_id)
    {
        return $this->db
            ->where('project_task_id',$project_task_id)
            ->get('project_task_items')
            ->result_array(); 
    }

    //get all projects list
    public function get_projects_tasks_list(){
        $query = $this->db->select('pt.id, pt.remarks, u.user_name')
            ->from('project_task pt')
            ->join('users u', 'u.user_id = pt.approved_by','left')
            //->where('pt.project_id', $project_id)
            ->get();
        $final = [];
        if ($query->num_rows() > 0) {
            $results = $query->result_array();   
            foreach($results as $result){
                $final[$result['id']]['remark'] = $result['remarks'] ?? '';
                $final[$result['id']]['approved'] = $result['user_name'] ?? '';
                $query_tasks = $this->db->query("SELECT  pti.id,pti.task_name,`em`.`employee_id`,pti.priority,pti.start_date,pti.end_date,pti.status,pti.task_description, `pm`.`milestone_name`, `dm`.`designation_name`, `em`.`employee_name`
                    FROM `project_task` pt
                    LEFT JOIN `project_task_items` `pti` ON `pti`.`project_task_id` = `pt`.`id`
                    LEFT JOIN `project_milestone` `pm` ON `pm`.`milestone_id` = `pti`.`milestone_id`
                    LEFT JOIN `designation_master` `dm` ON `dm`.`id` = `pti`.`designation_id`
                    LEFT JOIN `employee_master` `em` ON `em`.`employee_id` = `pti`.`employee_id`
                    LEFT JOIN  project_task_category pc on pc.project_task_id=pti.task_category_id
                    WHERE `pt`.`id`=".$result['id']);
                $result_tasks = $query_tasks->result_array();
                $final[$result['id']]['tasks'] = $result_tasks;
            }
          return $final;

        }else{
            return $final;
        }
    }
    //get project's tasks
    
    public function get_projects_tasks($project_id){
        $query = $this->db->select('pt.id, pt.remarks, u.user_name')
            ->from('project_task pt')
            ->join('users u', 'u.user_id = pt.approved_by','left')
            ->where('pt.project_id', $project_id)
            ->get();
        $final = [];
        if ($query->num_rows() > 0) {
            $result = $query->row_array();   
            $final['remark'] = $result['remarks'] ?? '';
            $final['approved'] = $result['approved_by'] ?? '';
            $query = $this->db->query("SELECT  pti.id,pti.task_name,`em`.`employee_id`,pti.priority,pti.start_date,pti.end_date,pti.status,pti.task_description, `pm`.`milestone_name`, `dm`.`designation_name`, `em`.`employee_name`
                    FROM `project_task` pt
                    LEFT JOIN `project_task_items` `pti` ON `pti`.`project_task_id` = `pt`.`id`
                    LEFT JOIN `project_milestone` `pm` ON `pm`.`milestone_id` = `pti`.`milestone_id`
                    LEFT JOIN `designation_master` `dm` ON `dm`.`id` = `pti`.`designation_id`
                    LEFT JOIN `employee_master` `em` ON `em`.`employee_id` = `pti`.`employee_id`
                    LEFT JOIN  project_task_category pc on pc.project_task_id=pti.task_category_id
                    WHERE `pt`.`project_id`=$project_id");
            $result_tasks = $query->result_array();
            $final['tasks'] = $result_tasks;
            return $final;

        }else{
            return $final;
        }
    }

    //get project name
    public function get_projectName($id){
        return $this->db
            ->select('p.project_code,p.project_name')
            ->from('project_master p')
            ->where('p.project_id', $id)
            ->get()
            ->result_array();
    }
    //delete task item
    public function delete_taskitem($item_id)
    {
        return $this->db->delete('project_task_items', ['id' => $item_id]);
    }
    /****
     * Resource Management
     */

    public function get_all_machines()
    {
        return $this->db->get('machine_master')->result();
    }

    public function add_machine_data()
    {
        $machine_name = trim($this->input->post('machine_name'));

        // CHECK DUPLICATE
        $exists = $this->db->where('machine_name', $machine_name)
                        ->get('machine_master')
                        ->row();

        if (!empty($exists)) {

            $this->session->set_flashdata('error', 'Machine name already exists!');
            redirect('Project/list_machines');
            return;
        }

        // AUTO CODE GENERATION
        $last = $this->db->select('machine_code')
                        ->from('machine_master')
                        ->order_by('machine_id', 'DESC')
                        ->get()
                        ->row();

        if (!empty($last->machine_code)) {
            $num = (int) substr($last->machine_code, 3);
            $num++;
            $code = 'MA-' . str_pad($num, 4, '0', STR_PAD_LEFT);
        } else {
            $code = 'MA-0001';
        }

        // INSERT
        $data = array(
            'machine_code' => $code,
            'machine_name' => $machine_name,
            'description'     => $this->input->post('description'),
            'created_at'      => date('Y-m-d H:i:s')
        );

        $this->db->insert('machine_master', $data);

        $this->session->set_flashdata('success', 'Machine Added Successfully');
        redirect('Project/list_machines');
    }

    //Tools
    public function get_all_tools()
    {
        return $this->db->get('tool_master')->result();
    }

    public function add_tool_data()
    {
        $tool_name = trim($this->input->post('tool_name'));

        // CHECK DUPLICATE
        $exists = $this->db->where('tool_name', $tool_name)
                        ->get('tool_master')
                        ->row();

        if (!empty($exists)) {

            $this->session->set_flashdata('error', 'Tool name already exists!');
            redirect('Project/list_tools');
            return;
        }

        // AUTO CODE GENERATION
        $last = $this->db->select('tool_code')
                        ->from('tool_master')
                        ->order_by('tool_id', 'DESC')
                        ->get()
                        ->row();

        if (!empty($last->tool_code)) {
            $num = (int) substr($last->tool_code, 3);
            $num++;
            $code = 'TL-' . str_pad($num, 4, '0', STR_PAD_LEFT);
        } else {
            $code = 'TL-0001';
        }

        // INSERT
        $data = array(
            'tool_code' => $code,
            'tool_name' => $tool_name,
            'description'     => $this->input->post('description'),
            'created_at'      => date('Y-m-d H:i:s')
        );

        $this->db->insert('tool_master', $data);

        $this->session->set_flashdata('success', 'Tool Added Successfully');
        redirect('Project/list_tools');
    }

    //get machines

    public function get_machines(){

      return $res = $this->db->select('machine_id,machine_name')
            ->from('machine_master')
            ->where('active','1')
            ->order_by('machine_id', 'DESC')
            ->get()
            ->result_array();    
    }
    //Machine operator mapping
    public function add_mom_data(){
        $machine_id     = $this->input->post('machine_id');
        $employee_id    = $this->input->post('employee_id');
        $skill_level    = $this->input->post('skill_level');
        $bit_active     = $this->input->post('bit_active');
        $remarks        = $this->input->post('description');
        $code           = $this->input->post('map_code');

        $data = array(
            'machine_id' => $code,
            'machine_id' => $machine_id,
            'employee_id' => $employee_id,
            'skill_level' => $skill_level,
            'bit_active'  => $bit_active,
            'remarks'     => $remarks,
            'map_code'    => $code,
            'created_date'  => date('Y-m-d H:i:s')
        );

        $this->db->insert('machine_operator_mapping', $data);
        $this->session->set_flashdata('success', 'Machine Operator Mapping Added Successfully');
        redirect('Project/list_machineop_map');

    }

    public function get_machine_operator($id)
    {
        return $this->db
                ->where('mapping_id',$id)
                ->get('machine_operator_mapping')
                ->row_array();
    }
    public function update_mom_data($id)
    {
        $data = array(
            'machine_id'   => $this->input->post('machine_id'),
            'employee_id'  => $this->input->post('employee_id'),
            'skill_level'  => $this->input->post('skill_level'),
            'remarks'      => $this->input->post('description'),
            'bit_active'   => $this->input->post('bit_active'),
            'updated_at'   => date('Y-m-d H:i:s')
        );

        $this->db->where('mapping_id',$id);

        return $this->db->update('machine_operator_mapping',$data);
    }

    public function get_all_employyee_mapping(){
        $query = $this->db->select('m.mapping_id, m.map_code,e.employee_name, mc.machine_name,m.skill_level,m.bit_active,m.remarks')
            ->from('machine_operator_mapping m')
            ->join('employee_master e', 'e.employee_id = m.employee_id','left')
            ->join('machine_master mc', 'mc.machine_id = m.machine_id','left')
            //->where('pt.project_id', $project_id)
            ->get();
            
        $final = [];
        if ($query->num_rows() > 0) {
            return $final = $query->result();  
        }else{
            return $final;
        }
    }

    /***
     * Resource Planning
    ***/
    public function get_all_resource_planning($id=''){
        $this->db->select('
            pmr.resource_id,pmr.project_id,
            pmr.resource_code,
            pm.project_name,
            mm.machine_name,
            em.employee_name,
            mom.skill_level,
            pmr.operation_name,
            pmr.hours_needed,
            pmr.start_date,
            pmr.end_date,
            pmr.status,
            pmr.remarks
        ');

        $this->db->from('project_machine_resource pmr');
        $this->db->join('project_master pm', 'pm.project_id = pmr.project_id', 'left');
        $this->db->join('machine_operator_mapping mom', 'mom.mapping_id = pmr.mapping_id', 'left');
        $this->db->join('machine_master mm', 'mm.machine_id = mom.machine_id', 'left');
        $this->db->join('employee_master em', 'em.employee_id = mom.employee_id', 'left');
        if(!empty($id)) {
            $this->db->where('pmr.project_id', $id);
        }
       
        $query = $this->db->get();
        $final = [];
        if ($query->num_rows() > 0) {
            return $final = $query->result();  
        }else{
            return $final;
        }
    }
    
    public function add_machine_resource()
    {
        $project_id     = $this->input->post('project_id');
        //$machine_id     = $this->input->post('machine_id');
        //$employee_id    = $this->input->post('employee_id');
        $map_id         = $this->input->post('mapping_id');
        if (empty($map_id)) {
            $map_id = $this->input->post('machine_id');
        }
        $tool_ids       = $this->input->post('tool_ids');
        if (empty($tool_ids)) {
            $tool_ids = [];
        }
        $operation_name = $this->input->post('operation_name');
        $hours_needed   = $this->input->post('hours_needed');
        $start_date     = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date       = date('Y-m-d', strtotime($this->input->post('end_date')));
        $duration       = (int) $this->input->post('duration');
        $status         = $this->input->post('status');
        $remarks        = $this->input->post('description');
        //$resource_code  = $this->input->post('resource_code');
        $created_by    = $this->session->userdata('user_id');
        $last = $this->db->select('resource_code')
                 ->from('project_machine_resource')
                 ->order_by('resource_id', 'DESC')
                 ->limit(1)
                 ->get()
                 ->row();

            if ($last && !empty($last->resource_code)) {

                $num = (int) substr($last->resource_code, 4); // Skip "MRP-"
                $num++;

                $resource_code = 'MRP-' . str_pad($num, 4, '0', STR_PAD_LEFT);

            } else {

                $resource_code = 'MRP-0001';

            }

        $data = array(
            'project_id'     => $project_id,
            //'machine_id'   => $machine_id,
            //'employee_id'  => $employee_id,
            'mapping_id'     => $map_id,
            'tool_id'        => is_array($tool_ids) ? implode(',', $tool_ids) : $tool_ids,
            'operation_name' => $operation_name,
            'hours_needed'   => $hours_needed,
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'status'         => $status,
            'remarks'        => $remarks,
            'resource_code'  => $resource_code,
            'created_by'     => $created_by,
            'created_at'     => date('Y-m-d H:i:s')
        );

        if ($this->db->field_exists('duration', 'project_machine_resource')) {
            $data['duration'] = $duration;
        }

        if ($this->db->field_exists('tool_id', 'project_machine_resource')) {
            $data['tool_id'] = is_array($tool_ids) ? implode(',', $tool_ids) : $tool_ids;
        }

        $this->db->insert('project_machine_resource', $data);

        $this->session->set_flashdata('success', 'Machine Resource Added Successfully');

        redirect('Project/list_resource_planning/' . $project_id);
    }

    public function get_machine_resource($id)
    {
        return $this->db
                ->where('resource_id', $id)
                ->get('project_machine_resource')
                ->row_array();
    }

    public function update_machine_resource($id)
    {
        $map_id = $this->input->post('mapping_id');
        if (empty($map_id)) {
            $map_id = $this->input->post('machine_id');
        }

        $tool_ids = $this->input->post('tool_ids');
        if (empty($tool_ids)) {
            $tool_ids = [];
        }

        $data = array(
            'project_id'     => $this->input->post('project_id'),
            'mapping_id'     => $map_id,
            'operation_name' => $this->input->post('operation_name'),
            'hours_needed'   => $this->input->post('hours_needed'),
            'start_date'     => date('Y-m-d', strtotime($this->input->post('start_date'))),
            'end_date'       => date('Y-m-d', strtotime($this->input->post('end_date'))),
            'status'         => $this->input->post('status'),
            'remarks'        => $this->input->post('description'),
            'updated_at'     => date('Y-m-d H:i:s')
        );

        if ($this->db->field_exists('duration', 'project_machine_resource')) {
            $data['duration'] = (int) $this->input->post('duration');
        }

        if ($this->db->field_exists('tool_id', 'project_machine_resource')) {
            $data['tool_id'] = is_array($tool_ids) ? implode(',', $tool_ids) : $tool_ids;
        }

        $this->db->where('resource_id', $id);
        return $this->db->update('project_machine_resource', $data);
    }

    public function get_machine_operator_mapping()
    {
        return $res = $this->db
            ->select('
                m.mapping_id,
                m.machine_id,
                m.employee_id,
                m.skill_level,
                mc.machine_name,
                e.employee_name
            ')
            ->from('machine_operator_mapping m')
            ->join('machine_master mc', 'mc.machine_id = m.machine_id')
            ->join('employee_master e', 'e.employee_id = m.employee_id')
            ->where('m.bit_active', 1)
            ->order_by('mc.machine_name')
            ->get()
            ->result_array();
    }
    //delete 
    public function delete_machine_resource($pid,$id)
    {
        return $this->db->delete('project_machine_resource', ['resource_id' => $id]);
    }
     public function get_tools(){

      return $res = $this->db->select('tool_id,tool_name')
            ->from('tool_master')
            ->where('active','1')
            ->order_by('tool_id', 'DESC')
            ->get()
            ->result_array();    
    }

    /***
     * Project Dashboard
     */
    public function get_project($project_id)
    {
        return $this->db
            ->where('project_id', $project_id)
            ->get('project_master')
            ->row_array();
    }

    public function get_project_items_dash($project_id)
    {
        $this->db->select('
            pi.*,
            p.product_name,
            p.product_code,
            u.unit_name
        ');
        $this->db->from('project_items pi');
        $this->db->join('item_master p', 'p.product_id = pi.product_id', 'left');
        $this->db->join('unit_master u', 'u.unit_id = p.unit_id', 'left');
        $this->db->where('pi.project_id', $project_id);
        $this->db->order_by('pi.id', 'ASC');

        return $this->db->get()->result_array();
    }
    public function get_materials($project_id)
    {
        $this->db->select('
            mr.*,
            p.product_name,
            u.unit_name
        ');
        $this->db->from('project_material_items mr');
        $this->db->join('product_master p','p.product_id = mr.product_id','left');
        $this->db->join('unit_master u','u.unit_id = p.unit_id','left');
        $this->db->where('mr.project_id',$project_id);

        return $this->db->get()->result_array();
    }
    public function get_resources($project_id)
    {
        $this->db->select('
            pmr.*,
            mm.machine_name,
            em.employee_name,
            mom.skill_level
        ');

        $this->db->from('project_machine_resource pmr');

        $this->db->join(
            'machine_operator_mapping mom',
            'mom.mapping_id=pmr.mapping_id',
            'left'
        );

        $this->db->join(
            'machine_master mm',
            'mm.machine_id=mom.machine_id',
            'left'
        );

        $this->db->join(
            'employee_master em',
            'em.employee_id=mom.employee_id',
            'left'
        );

        $this->db->where('pmr.project_id',$project_id);

        return $this->db->get()->result_array();
    }
    public function get_tasks_dash($project_id)
    {
        $this->db->select('
            pti.*,
            pt.project_task_name,
            pm.milestone_name,
            dm.designation_name,
            em.employee_name
        ');

        $this->db->from('project_task_items pti');

        $this->db->join(
            'project_task p',
            'p.id=pti.project_task_id',
            'left'
        );

        $this->db->join(
            'project_task_category pt',
            'pt.project_task_id=pti.task_category_id',
            'left'
        );

        $this->db->join(
            'project_milestone pm',
            'pm.milestone_id=pti.milestone_id',
            'left'
        );

        $this->db->join(
            'designation_master dm',
            'dm.id=pti.designation_id',
            'left'
        );

        $this->db->join(
            'employee_master em',
            'em.employee_id=pti.employee_id',
            'left'
        );

        $this->db->where('p.project_id',$project_id);

        return $this->db->get()->result_array();
    }

    public function get_team($project_id)
    {
        $this->db->select('
            pt.*,
            em.employee_name,
            dm.designation_name
        ');

        $this->db->from('project_technicians pt');

        $this->db->join(
            'employee_master em',
            'em.employee_id=pt.technician_id',
            'left'
        );

        $this->db->join(
            'designation_master dm',
            'dm.id=pt.designation_id',
            'left'
        );

        $this->db->where('pt.project_id',$project_id);

        return $this->db->get()->result_array();
    }

    public function get_manpower($project_id)
    {
        $this->db->select('
            pm.*,
            pmi.item_id,
            pmi.designation_id,
            pmi.employee_id,
            pmi.role,
            pmi.allocation_percentage,
            pmi.daily_hours,
            pmi.from_date,
            pmi.to_date,
            pmi.status,
            pmi.remarks AS item_remarks,
            dm.designation_name,
            em.employee_name
        ');

        $this->db->from('project_manpower pm');
        $this->db->join('project_manpower_items pmi', 'pmi.manpower_id = pm.manpower_id', 'left');
        $this->db->join('designation_master dm', 'dm.id = pmi.designation_id', 'left');
        $this->db->join('employee_master em', 'em.employee_id = pmi.employee_id', 'left');
        $this->db->where('pm.project_id', $project_id);
        $this->db->where('pm.bit_active', 1);

        return $this->db->get()->result();
    }

    public function get_itemlist()
    {
        $this->db->select('item.product_id as item_id,
            item.product_name as item_name,
            item.product_code as item_code');
        $this->db->from('item_master item');
        $this->db->where('item.is_inactive', 0);
        return $this->db->get()->result();
    }
    public function get_userlist()
    {
        $this->db->select('item.user_id,
            item.user_name,
            item.user_code');
        $this->db->from('users item');
        //$this->db->where('pm.bit_active', 1);
        return $this->db->get()->result();
    }
    
    function get_quality_checked_project_list()
    {
        $query = $this->db->query("
            SELECT p.*, u.user_name, c.customer_name, p.fk_cust_id
            FROM project_master p
            JOIN users u ON p.approver_id = u.user_id
            JOIN customer_master c ON p.fk_cust_id = c.customer_id
            JOIN project_outsource po ON po.project_id = p.project_id
            WHERE p.project_complete = '0'
            ORDER BY p.created_on DESC
        ");
        //AND po.quality_check_done = 'Yes'
        return $s= $query->result();
   }
    function get_work_order_list()
	{
		$id = $this->session->userdata('product_id');


		$query = $this->db->query("SELECT pw.*,pm.project_id,pm.project_name,pm.project_code FROM project_work_order pw JOIN project_master pm ON pw.project_id = pm.project_id ORDER BY pw.work_order_date DESC");		
		return $query->result();
	}
    function transaction_work_order($id)
	{
		//$query = $this->db->query("SELECT pw.*, pt.* FROM project_work_order pw JOIN project_work_order_transaction pt ON pw.work_id = pt.wo_master_id AND pw.work_id=$id group by pw.work_id ORDER BY pw.work_order_date DESC");
		$query = $this->db->query("SELECT pw.* FROM project_work_order pw where pw.work_id=$id group by pw.work_id ORDER BY pw.work_order_date DESC");
        return $query->result();
	}
    function get_requisition_tr_by_id_item($id)
	{
		$query = $this->db->query("select *  from project_work_order_transaction where trans_id =$id");

		return $query->result();
	}
    
    function get_attachment_records($id)
	{
		$query = $this->db->query("select *  from project_work_order_extra_details where work_extra_id =$id");

		return $query->result();
	}
	
    function get_project_wo_trans1($id)
    {
        // $query=$this->db->query("select * from project_work_order_transaction1 where trans_id1 = '$id' ");
            $query=$this->db->query("select one.*, three.unit_abbr from (select * from project_work_order_transaction1  where trans_id1='$id' )as one  left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        // $query=$this->db->query("select one.*, two.item_name, two.item_code, three.unit_abbr from (select * from project_work_order_transaction1  where trans_id1='$id' )as one left join(select * from item_master)as two on(one.sub_details=two.item_id) left join(select * from unit_master)as three on(one.unit=three.unit_id)");
        
        return $query->result();
    }

    //outsoursing
    
	function get_project_running_list()  // used for project dropdown, those projects are not closing out
	{
		$query=$this->db->query("select p.*, u.user_name, c.customer_name,p.fk_cust_id from project_master p, users u, customer_master c where p.approver_id=u.user_id and p.fk_cust_id=c.customer_id and p.project_complete='0' order by created_on desc");
		return $query->result();
	}	
    function get_terms_details()
	{
		$query=$this->db->query("select * from terms_details group by term_name");
		return $query->result();
	}
    function get_feasible_enquiry_list()
	{
		//$query=$this->db->query("select * from enquiry_master  e, customer_master c where e.cust_id=c.customer_id and feasibility in(1,2) and cancelled=0 and order_status=0 order by enq_date desc");
		$query=$this->db->query("select * from enquiry_master  e, customer_master c where e.enquiry_customer=c.customer_id and active=1 order by e.created_at desc");
	    return $query->result();
	}
    function get_main_category_list()
	{
		//$query=$this->db->query("select * from category_master where child_id=0 and is_cancelled =0 order by category_type,category_name");
		$query=$this->db->query("select * from category_master where is_active =1 order by category_name");
        return $query->result();
	}
    /*
    function get_product_list()
	{
    //removed brand country
    //$query=$this->db->query("SELECT p.*,u.unit_abbr,m.brand_name,c.country_name,d.category_name FROM product_master p LEFT JOIN unit_master u ON p.unit_id = u.unit_id LEFT JOIN brand_master m ON p.product_brand_id = m.brand_id LEFT JOIN country_master c ON c.country_code = p.product_made_in LEFT JOIN category_master d ON d.category_id = p.product_category ORDER BY p.product_name;");
	$query=$this->db->query("SELECT p.*,u.unit_abbr,d.category_name FROM product_master p LEFT JOIN unit_master u ON p.unit_id = u.unit_id LEFT JOIN category_master d ON d.category_id = p.category_id ORDER BY p.product_name");
	return $query->result_array();
	}
    */
    function get_product_list()
	{
	$query=$this->db->query("select * from item_master order by product_code ");
	return $query->result();
	}
    
	function get_project_by_id_out($project_id)
	{
		$query=$this->db->query("select p.*, c.customer_name as cust_name,u.user_id, u.user_name as project_manager from project_master p, customer_master c, users u where p.fk_cust_id=c.customer_id and p.approver_id=u.user_id and project_id=$project_id");
		return $query->result();
	}	
    
	function add_outsource_processing_details()
	{

		$outsource_date = $this->input->post('outsource_date');
         $outsource_finish_date = $this->input->post('outsource_finish_date');

		$data = array(
			'project_id' => $this->input->post('project_id'),
			'supplier_id' => $this->input->post('supplier_id'),
            'outsource_date' => !empty($outsource_date) ? date('Y-m-d', strtotime($outsource_date)) : NULL,
            'outsource_finish_date' => !empty($outsource_finish_date) ? date('Y-m-d', strtotime($outsource_finish_date)) : NULL,
			'remark' => $this->input->post('remark'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),
		);
		$this->db->insert('project_outsource', $data);
		$insert_id = $this->db->insert_id();

		for ($c = 0; $c < count($_POST['product_id']); $c++) {
			$data = array(
				'os_master_id' => $insert_id,
				'outsource_type' => $_POST['product_id'][$c],
				'product_desc' => $_POST["desc"][$c],
				'quantity' => $_POST["trading_qty"][$c],
				'nature_work' => $_POST["nature_work"][$c],

			);
			$this->db->insert('project_outsource_details', $data);
		}
		
		if ($insert_id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_outsource', 'outsource_id', $insert_id);
		}
		return $insert_id;
	}
	function update_outsource_processing_details($id)
	{
         $outsource_date = $this->input->post('outsource_date');
         $outsource_finish_date = $this->input->post('outsource_finish_date');
		$data = array(
			'remark' => $this->input->post('remark'),
			'outsource_date' => !empty($outsource_date) ? date('Y-m-d', strtotime($outsource_date)) : NULL,
            'outsource_finish_date' => !empty($outsource_finish_date) ? date('Y-m-d', strtotime($outsource_finish_date)) : NULL,
			'quality_check_done' => $this->input->post('quality_check_done'),
            'quality_check_by' => $this->input->post('quality_check_by'),
            'quality_check_comments' => $this->input->post('quality_check_comments')
		
			);
		$this->db->where('outsource_id', $id);
		$res = $this->db->update('project_outsource', $data);

		$query = $this->db->query(" delete from project_outsource_details where os_master_id=$id");
		for ($c = 0; $c < count($_POST['product_id']); $c++) {
			$data = array(
				'os_master_id' => $id,
				'outsource_type' => $_POST['product_id'][$c],
				'product_desc' => $_POST["desc"][$c],
				'quantity' => $_POST["trading_qty"][$c],
				'nature_work' => $_POST["nature_work"][$c],

			);
			$this->db->insert('project_outsource_details', $data);
		}
		if ($id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'project_outsource', 'outsource_id', $id);

		}
		return $id;

	}
	function get_outsource_processing_list()
	{
		$query = $this->db->query("SELECT pm.project_name, pm.project_code, po.outsource_id,po.outsource_date,po.remark,sm.supplier_code,sm.supplier_name 
        FROM project_outsource po JOIN project_master pm ON po.project_id = pm.project_id JOIN 
        supplier_master sm ON po.supplier_id = sm.supplier_id ORDER BY po.outsource_date DESC ");
		return $query->result();
	}

	function print_outsource_processing_list($id)
	{
		$query = $this->db->query("
        SELECT 
             po.*,
            pm.project_name, 
            pm.project_code, 
            po.outsource_id, 
            po.outsource_date,
			po.remark, 
            sm.supplier_code, 
			pm.project_id,
            sm.supplier_name 
        FROM 
            project_outsource po 
        JOIN 
            project_master pm ON po.project_id = pm.project_id 
		
        JOIN 
            supplier_master sm ON po.supplier_id = sm.supplier_id 
			AND po.outsource_id=$id
        ORDER BY 
            po.outsource_date DESC
    ");
		return $query->result();
	}
	function outsource_processing_details_list($id)
	{
		$query = $this->db->query("
        SELECT 
             po.*,pd.*,
           
            po.outsource_id, 
            po.outsource_date,
			po.remark
           
        FROM 
            project_outsource po 
        JOIN 
		project_outsource_details pd ON po.outsource_id = pd.os_master_id 
        
			AND po.outsource_id=$id
        ORDER BY 
            po.outsource_date DESC
    ");
		return $query->result();
	}

	function delete_outsource_data($id)
	{
		$query = $this->db->query(" delete from project_outsource where outsource_id=$id");
		$query = $this->db->query(" delete from project_outsource_details where os_master_id=$id");

	}
    function get_project_list()  
	{
		$query=$this->db->query("select p.*, u.user_name, c.customer_name as cust_name,p.fk_cust_id from project_master p, users u, customer_master c where p.approver_id=u.user_id and p.fk_cust_id=c.customer_id order by p.created_on desc");
		// $query=$this->db->query("select p.*, u.user_name, cust_name,p.customer_id from project_master p, users u, customer_master c where p.manager=u.user_id and p.customer_id=c.customer_id and p.project_complete='0' order by created_date desc");

		return $query->result();
	}
    	function get_requisition_tr_by_id_outsource($id)
	{
		$query = $this->db->query("select *  from project_outsource_details  where os_master_id =$id");
		return $query->result();
	}	
     function get_product_list_out()
	{
	$query=$this->db->query("select * from item_master order by product_code ");
	return $query->result_array();
	}
    
    function get_project_details($id)
    {
        $query = $this->db->query("
            SELECT  u.user_name, c.customer_name,p.start_date,p.end_date 
            FROM project_master p
            JOIN users u ON p.approver_id = u.user_id
            JOIN customer_master c ON p.fk_cust_id = c.customer_id
            JOIN project_outsource po ON po.project_id = p.project_id
            WHERE p.project_id = $id
            
        ");

        return $query->result_array();
    }
    function get_project_quotaions($project_id)
	{
		$query=$this->db->query("select * from project_quotation where pid = '$project_id' ");
		return $query->result();
	}
    function get_max_revision_project_trans1($id)
	{
		$query=$this->db->query("select max(revision)as revision from project_transaction1 where pid='$id'");
		return $query->row('revision');
	}

    ///neeeddddddd to checkkkkkkkkkkkkkkkkkk
    function get_project_trans1($id,$revtype)
	{
		$condition= "";
		if($revtype==0)
			$condition= "and revision=0";
		else if($revtype>0)
			$condition= "and revision=$revtype";
			
		$query=$this->db->query("select * from project_transaction1 where pid='$id' $condition");
		return $query->result();
	}
	function get_project_trans2($id,$revtype)
	{
		$condition= "";
		if($revtype==0)
			$condition= "and revision=0";
		else if($revtype>0)
			$condition= "and revision=$revtype";
			
		$query=$this->db->query("select one.*, two.product_name as item_name, two.product_code as item_code, three.unit_abbr from (select * from project_transaction2  where pid='$id' $condition)as one left join(select * from item_master)as two on(one.sub_details=two.product_id) left join(select * from unit_master)as three on(one.unit=three.unit_id)");
		echo $this->db->last_query();
        return $query->result();
	}

    /****
     * WORK ORDER
     */

    function add_work_order_details()
{
	// if ($_FILES["documents_res"]) {
	// 	$allowedExts = array("jpeg", "jpg", "png");
	// 	$fname = $_FILES["documents_res"]["name"];
	// 	$temp = explode(".", $fname);
	// 	$extension = end($temp);
	// 	$other_file = '';

	// 	if (($_FILES["documents_res"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
	// 		if ($_FILES["documents_res"]["error"] > 0) {
	// 			$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
	// 		} else {
	// 			$timestamp1 = time();
	// 			$file_tmp = $_FILES["documents_res"]["tmp_name"];
	// 			$other_file = $timestamp1 . "_" . $fname;
	// 			move_uploaded_file($file_tmp, "/home/webadmin/gen/multiscale/public/uploded_documents/" . $other_file);
	// 		}
	// 	} else {
	// 		$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
	// 	}
	// }

	$prifix = 'WO/' . date('y') . '/';
	$this->load->model('Setup_model');
	$num = $this->Setup_model->get_next_code($prifix, 'wo_code', 'project_work_order', 7) + 1;
	$digit = sprintf("%1$04d", $num);
	$code = $prifix . $digit;

	

	$data = array(
		'project_id' => $this->input->post('project_id'),
		'work_order_date' => date('Y-m-d', strtotime($this->input->post('work_order_date'))),
		'wo_code' => $this->input->post('wo_code'),
		// 'reamrk' => $this->input->post('remark'),
		'installation_manhr' => $this->input->post('im'),
		'fabrication_manhr' => $this->input->post('fm'),
		'fsdate' => date('Y-m-d', strtotime($this->input->post('fsdate'))),
		'fedate' => date('Y-m-d', strtotime($this->input->post('fedate'))),
		'isdate' => date('Y-m-d', strtotime($this->input->post('isdate'))),
		'iedate' => date('Y-m-d', strtotime($this->input->post('iedate'))),
		'prepared_by' => $this->input->post('prepared_id'),
		'checked_by' => $this->input->post('checked_id'),
		'approved_by' => $this->input->post('approved_id'),
		'handed_over_to' => $this->input->post('handed_over_to'),
		'created_by' => $this->session->userdata('user_id'),
		'created_date' => date('Y-m-d'),
	);
	$this->db->insert('project_work_order', $data);
	$insert_id = $this->db->insert_id();

	// for ($c = 0; $c < count($_POST['product_id']); $c++) {
	// 	$data2 = array(
	// 		'wo_master_id' => $insert_id,
	// 		'item_desc' => $_POST['desc'][$c],
	// 		'cproduct_type' => $_POST['product_id'][$c],
	// 		'colour_finish' => $_POST['colour_finish'][$c],
	// 		'uom' => $_POST['item_uom'][$c],
	// 		'quntity' => $_POST['trading_qty'][$c],

	// 	);
	// 	$this->db->insert('project_work_order_transaction', $data2);
	// }
	$revision=0;	
	for ($i = 0; $i < count($_POST['desc']); $i++)
 {		
 $trans_id= $_POST['trans_id'][$i];
 $revision= $_POST['revision'][$i];
 $data = array(
	'pid' => $insert_id,
	'wo_master_id' => $insert_id,
 'revision'=>$revision,
 'qid' => $_POST['qid'][$i],
 'product_desc' => $_POST['desc'][$i],
 'item_remark' => $_POST['item_remark'][$i],
 );
 $this->db->insert('project_work_order_transaction', $data);
 $insert_id1 = $this->db->insert_id();





 for ($j = 0; $j < count($_POST["sub_details$trans_id"]); $j++)
	 {
	 $data = array(
	 'trans_id1' => $insert_id1,
	 'pid' => $insert_id,
	 'revision' => $revision,
	 'sub_details' => $_POST["sub_details$trans_id"][$j],
	 'qty' =>  $_POST["qty$trans_id"][$j],
	 'width' =>  $_POST["width$trans_id"][$j],
	 'height' =>  $_POST["height$trans_id"][$j],
	 'unit' =>  $_POST["unit$trans_id"][$j],
	 'price' =>  $_POST["price$trans_id"][$j],
	 'total' =>  $_POST["total$trans_id"][$j],
	 'colour_finish' => $_POST['colour_finish'][$j],
	 'item_name' => $_POST['item_name'][$j],
	 'item_code' => $_POST['item_code'][$j],

	 );
	 $this->db->insert('project_work_order_transaction1', $data);
 }
}




	if ($insert_id) {
		if (!empty($_FILES["documents_res"])) {
			$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
			foreach ($_FILES['documents_res']["name"] as $key => $filename) {
				if (!empty($filename)) {
					$temp = explode(".", $filename);
					$extension = end($temp);
					if (in_array($extension, $allowedExts)) {
						$timestamp1 = time();
						$file_tmp = $_FILES["documents_res"]["tmp_name"][$key];
						$other_file = $timestamp1 . "_" . $filename;
						//move_uploaded_file($file_tmp, "/home/webadmin/gen/multiscale/public/uploded_documents/" . $other_file);
                        move_uploaded_file($file_tmp, "./public/uploded_documents/" . $other_file);

						// $data1 = array(
						// 	'wo_master_id' => $insert_id,
						// 	'wo_attachments' => $_POST['wo_attachments'][$i],
						// 	'attachment_one' => $other_file,
						// );
						// $this->db->insert('project_work_order_extra_details', $data1);
					}
				}
			}
		}
	}

	for ($i = 0; $i < count($_POST['wo_attachments']); $i++) {
		$data3 = array(
			'wo_master_id' => $insert_id,
			'wo_type' => 'Work Order Attachments',
			'wo_attachments' => $_POST['wo_attachments'][$i],
		'attachment_one' => $other_file,
		// 'product_route' => $_POST['product_route'][$i],
		// 	'proute_desc' => $_POST['proute_desc'][$i],
		// 	'wo_plan' => $_POST['wo_plan'][$i],
		// 	'woplan_desc' => $_POST['woplan_desc'][$i],

		);
		$this->db->insert('project_work_order_extra_details', $data3);
	}
	for ($j = 0; $j < count($_POST['product_route']); $j++) {
		$data4 = array(
			'wo_master_id' => $insert_id,
			'wo_type' => 'Product Process Route',
		'product_route' => $_POST['product_route'][$j],
			'proute_desc' => $_POST['proute_desc'][$j],
		);
		$this->db->insert('project_work_order_extra_details', $data4);
	}
	for ($k = 0; $k < count($_POST['wo_plan']); $k++) {
		$data5 = array(
			'wo_master_id' => $insert_id,
			'wo_type' =>'Work Order Distribution Plan',
			'wo_plan' => $_POST['wo_plan'][$k],
			'woplan_desc' => $_POST['woplan_desc'][$k],

		);
		$this->db->insert('project_work_order_extra_details', $data5);
	}
	if ($insert_id) {
		$user_se_id = $this->session->userdata('user_id');
		$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
		$ci = get_instance();
		$ci->load->helper('log');
		$log_msg = add_log_entry($user_se_id, 1, $page_name[1], 'project_work_order', 'work_id', $insert_id);
	}
	return $insert_id;
}

	function update_work_order_details($id)
	{

		// if ($_FILES["documents_res"]) {
		// 	$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
		// 	$fname = $_FILES["documents_res"]["name"];
		// 	$temp = explode(".", $fname);
		// 	$extension = end($temp);
		// 	$other_file = '';

		// 	if (($_FILES["documents_res"]["size"] < 15728640) && in_array($extension, $allowedExts)) {
		// 		if ($_FILES["documents_res"]["error"] > 0) {
		// 			$this->session->set_flashdata('error', 'Failed to upload - Please check file size and file format');
		// 		} else {
		// 			$timestamp1 = time();
		// 			$file_tmp = $_FILES["documents_res"]["tmp_name"];
		// 			$other_file = $timestamp1 . "_" . $fname;
		// 			move_uploaded_file($file_tmp, "/home/webadmin/gen/multiscale/public/uploded_documents/" . $other_file);
		// 			// $query = $this->db->query("update project_work_order_extra_details set attachment_one='$other_file' where work_extra_id=$id");
		// 		}
		// 	}
		// }
		$data = array(
			'project_id' => $this->input->post('project_id'),
			'work_order_date' => date('Y-m-d', strtotime($this->input->post('work_order_date'))),
			'wo_code' => $this->input->post('wo_code'),
			// 'reamrk' => $this->input->post('remark'),
			'installation_manhr' => $this->input->post('im'),
			'fabrication_manhr' => $this->input->post('fm'),
			'fsdate' => date('Y-m-d', strtotime($this->input->post('fsdate'))),
			'fedate' => date('Y-m-d', strtotime($this->input->post('fedate'))),
			'isdate' => date('Y-m-d', strtotime($this->input->post('isdate'))),
			'iedate' => date('Y-m-d', strtotime($this->input->post('iedate'))),
			'prepared_by' => $this->input->post('prepared_id'),
			'checked_by' => $this->input->post('checked_id'),
			'approved_by' => $this->input->post('approved_id'),
			'handed_over_to' => $this->input->post('handed_over_to'),
			'created_by' => $this->session->userdata('user_id'),
			'created_date' => date('Y-m-d'),
		);
		$this->db->where('work_id', $id);
		$res = $this->db->update('project_work_order', $data);

		// $query = $this->db->query(" delete from project_work_order_transaction where wo_master_id=$id");
		// for ($c = 0; $c < count($_POST['category_id']); $c++) {
		// 	$data = array(
		// 		'wo_master_id' => $id,
		// 		'dept_id' => $_POST['dept_id'][$c],
		// 		'category_type' => $_POST['category_id'][$c],
		// 		'scope_details' => $_POST['work_details'][$c],


		// 	);
		// 	$this->db->insert('project_work_order_transaction', $data);
		// }


		
		// for ($c = 0; $c < count($_POST['product_id']); $c++) {
		// 	$data2 = array(
		// 		'wo_master_id' => $id,
		// 		'item_desc' => $_POST['desc'][$c],
		// 		'cproduct_type' => $_POST['product_id'][$c],
		// 		'colour_finish' => $_POST['colour_finish'][$c],
		// 		'uom' => $_POST['item_uom'][$c],
		// 		'quntity' => $_POST['trading_qty'][$c],

		// 	);
		// 	$this->db->update('project_work_order_transaction', $data2);
		// }




		

		// if ($id) {
		// 	if (!empty($_FILES["documents_res"])) {
		// 		$allowedExts = array("jpeg", "jpg", "png", "doc", "pdf");
		// 		foreach ($_FILES['documents_res']["name"] as $key => $filename) {
		// 			if (!empty($filename)) {
		// 				$temp = explode(".", $filename);
		// 				$extension = end($temp);
		// 				if (in_array($extension, $allowedExts)) {
		// 					$timestamp1 = time();
		// 					$file_tmp = $_FILES["documents_res"]["tmp_name"][$key];
		// 					$other_file = $timestamp1 . "_" . $filename;
		// 					move_uploaded_file($file_tmp, "/home/webadmin/gen/multiscale/public/uploded_documents/" . $other_file);

		// 				}
		// 			}
		// 		}
		// 	}
		// }

		// for ($i = 0; $i < count($_POST['wo_attachments']); $i++) {
		// 	$data3 = array(
		// 		'wo_master_id' => $id,
		// 		'wo_attachments' => $_POST['wo_attachments'][$i],
		// 	'attachment_one' => $other_file,
		// 	'product_route' => $_POST['product_route'][$i],
		// 		'proute_desc' => $_POST['proute_desc'][$i],
		// 		'wo_plan' => $_POST['wo_plan'][$i],
		// 		'woplan_desc' => $_POST['woplan_desc'][$i],

		// 	);
		// 	$this->db->update('project_work_order_extra_details', $data3);
		// }


		if ($id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'project_work_order', 'work_id', $id);

		}
		return $id;
	}

	function approve_work_order($id)
	{

		$data = array(
			'approve_flag' => $this->input->post('action'),
			'approved_by' => $this->input->post('approved_id'),
			'created_date' => date('Y-m-d'),
		);
		$this->db->where('work_id', $id);
		$res = $this->db->update('project_work_order', $data);


		if ($id) {
			$user_se_id = $this->session->userdata('user_id');
			$page_name = explode('index.php/', $_SERVER['PHP_SELF']);
			$ci = get_instance();
			$ci->load->helper('log');
			$log_msg = add_log_entry($user_se_id, 2, $page_name[1], 'project_work_order', 'work_id', $id);

		}
		return $id;
	}
	function print_work_order($id)
	{
		$query = $this->db->query("
			SELECT 
				pw.*, 
				pm.project_name, 
				pm.project_code, 
				pw.work_id, 
				pw.work_order_date
			FROM 
			project_work_order pw 
			JOIN 
				project_master pm ON pw.project_id = pm.project_id 
				AND pw.work_id=$id
			ORDER BY 
			pw.work_order_date DESC
		");
		return $query->result();
	}

	function delete_work_order_data($id)
	{
		$query = $this->db->query(" delete from project_work_order where work_id=$id");
		$query = $this->db->query(" delete from project_work_order_transaction where wo_master_id=$id");
		$query = $this->db->query(" delete from project_work_order_transaction1 where trid=$id");
		$query = $this->db->query(" delete from project_work_order_extra_details where work_extra_id=$id");

	}


	function get_wo_by_id($id)
	{
		$query=$this->db->query("select wo.*, p.*, u.user_name, cust_name,p.customer_id,c.* from project_work_order wo, project_master p, users u, customer_master c where wo.project_id=p.project_id and p.manager=u.user_id and p.customer_id=c.customer_id and work_id='$id' order by work_id desc");
		return $query->result();
	}
	function get_wo_tr_by_id($id)
	{
		$query = $this->db->query("select one.*, two.unit_abbr from(SELECT pw.product_desc,pw.item_remark, pt.*,pt.pid as p_id FROM project_work_order_transaction pw JOIN project_work_order_transaction1 pt ON pw.trans_id = pt.trans_id1 AND pw.trans_id='$id') as one left join(select * from unit_master)as two on(one.unit=two.unit_id)");		return $query->result();
	}
  

	function get_product_extra_records($id)
	{
		// $query = $this->db->query("select *  from project_work_order_extra_details where work_extra_id =$id");
		$query = $this->db->query("select *  from project_work_order_extra_details where wo_master_id =$id");

		return $query->result();
	}
	
	function get_employee_document_doc_id($id)
	{
		$query = $this->db->query("select * from project_work_order_extra_details where wo_master_id='$id' ");
		return $query->result();
	}
    function get_project_wo_trans($id)
    {
        $query=$this->db->query("select * from project_work_order_transaction where trans_id = '$id' ");
        // $query=$this->db->query("select * from project_production_transaction where ptrans_id = '$id' ");

        return $query->result();
    }
    public function get_project_progress_report(){
        return $this->db->select('pm.project_id,pm.project_code,pm.created_on,pm.project_name,cm.customer_name,u.user_name as manager,pm.start_date,pm.end_date,pm.status,pp.progress_percentage,pp.current_status,pp.last_updated')
        ->from('project_master pm')
        ->join('customer_master cm','cm.customer_id=pm.fk_cust_id','left')
        ->join('users u','u.user_id=pm.approver_id','left')
        ->join('project_progress pp','pp.project_id=pm.project_id','left')
        ->order_by('pm.project_id','DESC')->get()->result();
    }

    public function get_projects()
    {
        return $this->db
                ->select('project_id,project_code,project_name')
                ->from('project_master')
                ->order_by('project_name','ASC')
                ->get()
                ->result();
    }
    //project model
    // Project Details
    /*soumya
    public function get_project_details_report($id)
    {

    return $this->db
    ->select('
    pm.*,
    cm.customer_name,
    u.user_name as manager
    ')
    ->from('project_master pm')
    ->join(
    'customer_master cm',
    'cm.customer_id=pm.fk_cust_id',
    'left'
    )
    ->join(
    'users u',
    'u.user_id=pm.approver_id',
    'left'
    )
    ->where(
    'pm.project_id',
    $id
    )
    ->get()
    ->row();

    }

    // Tasks

    public function get_project_tasks($id)
    {

    return $this->db
    ->select('
    pt.*,
    tc.category_name,
    e.employee_name
    ')
    ->from('project_task_items pt')
    ->join(
    'project_task_category tc',
    'tc.category_id=pt.category_id',
    'left'
    )
    ->join(
    'employee_master e',
    'e.employee_id=pt.employee_id',
    'left'
    )
    ->where(
    'pt.project_id',
    $id
    )
    ->get()
    ->result();

    }
    // Material Planning

    public function get_project_materials($id)
    {

    return $this->db
    ->select('
    m.material_name,
    pmp.quantity,
    pmp.required_date,
    pmp.status
    ')
    ->from('project_material_plan pmp')
    ->join(
    'material_master m',
    'm.material_id=pmp.material_id',
    'left'
    )
    ->where(
    'pmp.project_id',
    $id
    )
    ->get()
    ->result();

    }

    // Machine Resource

    public function get_project_resources($id)
    {

    return $this->db
    ->select('
    pmr.resource_code,
    mm.machine_name,
    em.employee_name,
    pmr.operation_name,
    pmr.hours_needed,
    pmr.status
    ')
    ->from('project_machine_resource pmr')
    ->join(
    'machine_master mm',
    'mm.machine_id=pmr.machine_id',
    'left'
    )
    ->join(
    'employee_master em',
    'em.employee_id=pmr.employee_id',
    'left'
    )
    ->where(
    'pmr.project_id',
    $id
    )
    ->get()
    ->result();

    }

    // Manpower

    public function get_project_manpower_report($id)
    {

    return $this->db
    ->select('
    e.employee_name,
    d.designation_name,
    ppm.hours,
    ppm.status
    ')
    ->from('project_manpower ppm')
    ->join(
    'employee_master e',
    'e.employee_id=ppm.employee_id',
    'left'
    )
    ->join(
    'designation_master d',
    'd.designation_id=e.designation_id',
    'left'
    )
    ->where(
    'ppm.project_id',
    $id
    )
    ->get()
    ->result();

    }

    // Work Orders

    public function get_workorders($id)
    {

    return $this->db
    ->where(
    'project_id',
    $id
    )
    ->get('work_order')
    ->result();

    }

    // Progress

    public function get_progress($id)
    {

    return $this->db
    ->where(
    'project_id',
    $id
    )
    ->order_by(
    'last_updated',
    'DESC'
    )
    ->get('project_progress')
    ->result();

    }
    // Expenses
    public function get_expenses($id)
    {

    return $this->db
    ->where(
    'project_id',
    $id
    )
    ->get('project_expense')
    ->result();

    }
    soumya*/
    public function get_projectmr_items($p_id)
    {
        return $result = $this->db
            ->select('mi.*, im.product_name AS product_name, mr.mr_code, mr.project_id,mi.item_desc,mi.item_remarks')
            ->from('project_material_items mi')
            ->join('item_master im', 'im.product_id = mi.fk_item_id', 'left')
            ->join('material_requests mr', 'mr.mr_id = mi.mr_id', 'left')
            ->where('mr.project_id', $p_id)
            ->get()
            ->result_array();

    }

    

}
