<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /*
    |--------------------------------------------------------------------------
    | Total Projects
    |--------------------------------------------------------------------------
    */

    public function count_total_projects()
    {
        return $this->db->count_all('project_master');
    }


    /*
    |--------------------------------------------------------------------------
    | Active Projects
    |--------------------------------------------------------------------------
    */

    public function count_active_projects()
    {
        return $this->db
            ->where('project_complete',0)
            ->count_all_results('project_master');
    }


    /*
    |--------------------------------------------------------------------------
    | Completed Projects
    |--------------------------------------------------------------------------
    */

    public function count_completed_projects()
    {
        return $this->db
            ->where('project_complete',1)
            ->count_all_results('project_master');
    }


    /*
    |--------------------------------------------------------------------------
    | Pending Work Orders
    |--------------------------------------------------------------------------
    */

    public function count_pending_workorders()
    {

        return $this->db
            ->where('approve_flag',0)
            ->count_all_results('project_work_order');

    }


    /*
    |--------------------------------------------------------------------------
    | Approved Work Orders
    |--------------------------------------------------------------------------
    */

    public function count_approved_workorders()
    {

        return $this->db
            ->where('approve_flag',1)
            ->count_all_results('project_work_order');

    }


    /*
    |--------------------------------------------------------------------------
    | Pending Outsource
    |--------------------------------------------------------------------------
    */

    public function count_pending_outsource()
    {

        return $this->db
            ->where('approve',0)
            ->count_all_results('project_outsource');

    }


    /*
    |--------------------------------------------------------------------------
    | Completed Outsource
    |--------------------------------------------------------------------------
    */

    public function count_completed_outsource()
    {

        return $this->db
            ->where('approve',1)
            ->count_all_results('project_outsource');

    }


    /*
    |--------------------------------------------------------------------------
    | Delayed Projects
    |--------------------------------------------------------------------------
    */

    public function count_delayed_projects()
    {

        return $this->db
            ->where('end_date <',date('Y-m-d'))
            ->where('project_complete',0)
            ->count_all_results('project_master');

    }


    /*
    |--------------------------------------------------------------------------
    | Projects Due This Week
    |--------------------------------------------------------------------------
    */

    public function count_due_projects()
    {

        return $this->db
            ->where('end_date >=',date('Y-m-d'))
            ->where('end_date <=',date('Y-m-d',strtotime('+7 days')))
            ->count_all_results('project_master');

    }


    /*
    |--------------------------------------------------------------------------
    | Average Progress
    |--------------------------------------------------------------------------
    */

    public function average_progress()
    {

        $this->db->select_avg('progress_percentage');

        $query=$this->db->get('project_progress');

        if($query->num_rows()>0)
        {
            return round($query->row()->progress_percentage);
        }

        return 0;

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Cards
    |--------------------------------------------------------------------------
    */

    public function dashboard_cards()
    {

        return array(

            'total_projects'=>$this->count_total_projects(),

            'active_projects'=>$this->count_active_projects(),

            'completed_projects'=>$this->count_completed_projects(),

            'pending_workorders'=>$this->count_pending_workorders(),

            'approved_workorders'=>$this->count_approved_workorders(),

            'pending_outsource'=>$this->count_pending_outsource(),

            'completed_outsource'=>$this->count_completed_outsource(),

            'average_progress'=>$this->average_progress(),

            'delayed_projects'=>$this->count_delayed_projects(),

            'due_projects'=>$this->count_due_projects()

        );

    }

        /*
    |--------------------------------------------------------------------------
    | Project Status Chart
    |--------------------------------------------------------------------------
    */

    public function project_status_chart()
    {

        return $this->db
            ->select('status, COUNT(*) as total')
            ->from('project_master')
            ->group_by('status')
            ->order_by('status')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Monthly Project Creation Chart
    |--------------------------------------------------------------------------
    */

    public function monthly_projects_chart()
    {

        return $this->db
            ->select("
                MONTH(created_on) as month_no,
                DATE_FORMAT(created_on,'%b') as month_name,
                COUNT(project_id) as total
            ", FALSE)
            ->from('project_master')
            ->group_by('MONTH(created_on)')
            ->order_by('MONTH(created_on)')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Work Order Status Chart
    |--------------------------------------------------------------------------
    */

    public function workorder_chart()
    {

        $approved = $this->db
            ->where('approve_flag',1)
            ->count_all_results('project_work_order');

        $pending = $this->db
            ->where('approve_flag',0)
            ->count_all_results('project_work_order');

        return array(

            (object)array(
                'status'=>'Approved',
                'total'=>$approved
            ),

            (object)array(
                'status'=>'Pending',
                'total'=>$pending
            )

        );

    }


    /*
    |--------------------------------------------------------------------------
    | Progress Distribution Chart
    |--------------------------------------------------------------------------
    */

    public function progress_distribution_chart()
    {

        $range1 = $this->db
            ->where('progress_percentage >=',0)
            ->where('progress_percentage <=',25)
            ->count_all_results('project_progress');

        $range2 = $this->db
            ->where('progress_percentage >',25)
            ->where('progress_percentage <=',50)
            ->count_all_results('project_progress');

        $range3 = $this->db
            ->where('progress_percentage >',50)
            ->where('progress_percentage <=',75)
            ->count_all_results('project_progress');

        $range4 = $this->db
            ->where('progress_percentage >',75)
            ->where('progress_percentage <=',100)
            ->count_all_results('project_progress');

        return array(

            (object)array(
                'range'=>'0-25%',
                'total'=>$range1
            ),

            (object)array(
                'range'=>'26-50%',
                'total'=>$range2
            ),

            (object)array(
                'range'=>'51-75%',
                'total'=>$range3
            ),

            (object)array(
                'range'=>'76-100%',
                'total'=>$range4
            )

        );

    }


    /*
    |--------------------------------------------------------------------------
    | Completion Summary Chart
    |--------------------------------------------------------------------------
    */

    public function completion_chart()
    {

        $completed = $this->db
            ->where('project_complete',1)
            ->count_all_results('project_master');

        $running = $this->db
            ->where('project_complete',0)
            ->count_all_results('project_master');

        return array(

            (object)array(
                'status'=>'Completed',
                'total'=>$completed
            ),

            (object)array(
                'status'=>'Running',
                'total'=>$running
            )

        );

    }

        /*
    |--------------------------------------------------------------------------
    | Recent Projects
    |--------------------------------------------------------------------------
    */

    public function recent_projects($limit = 10)
    {

        return $this->db
            ->select('
                pm.project_id,
                pm.project_code,
                pm.project_name,
                pm.customer_name,
                pm.start_date,
                pm.end_date,
                pm.status,
                pm.project_complete,
                IFNULL(pp.progress_percentage,0) AS progress
            ',FALSE)
            ->from('project_master pm')
            ->join(
                '(SELECT project_id,
                        MAX(progress_percentage) progress_percentage
                 FROM project_progress
                 GROUP BY project_id) pp',
                'pp.project_id = pm.project_id',
                'left',
                FALSE
            )
            ->order_by('pm.created_on','DESC')
            ->limit($limit)
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Recent Work Orders
    |--------------------------------------------------------------------------
    */

    public function recent_workorders($limit = 10)
    {

        return $this->db
            ->select('
                pwo.work_id,
                pwo.wo_code,
                pwo.work_order_date,
                pwo.approve_flag,
                pm.project_code,
                pm.project_name
            ')
            ->from('project_work_order pwo')
            ->join(
                'project_master pm',
                'pm.project_id=pwo.project_id',
                'left'
            )
            ->order_by('pwo.work_order_date','DESC')
            ->limit($limit)
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Recent Progress
    |--------------------------------------------------------------------------
    */

    public function recent_progress($limit = 10)
    {

        return $this->db
            ->select('
                pp.progress_percentage,
                pp.current_status,
                pp.last_updated,
                pm.project_code,
                pm.project_name
            ')
            ->from('project_progress pp')
            ->join(
                'project_master pm',
                'pm.project_id=pp.project_id',
                'left'
            )
            ->order_by('pp.last_updated','DESC')
            ->limit($limit)
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Pending Outsource
    |--------------------------------------------------------------------------
    */

    public function pending_outsource_list($limit = 10)
    {

        return $this->db
            ->select('
                po.outsource_id,
                po.outsource_date,
                po.outsource_finish_date,
                po.quality_check_done,
                pm.project_code,
                pm.project_name
            ')
            ->from('project_outsource po')
            ->join(
                'project_master pm',
                'pm.project_id=po.project_id',
                'left'
            )
            ->where('po.approve',0)
            ->order_by('po.outsource_date','DESC')
            ->limit($limit)
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Delayed Projects
    |--------------------------------------------------------------------------
    */

    public function delayed_projects()
    {

        return $this->db
            ->select('
                project_id,
                project_code,
                project_name,
                customer_name,
                end_date,
                DATEDIFF(CURDATE(),end_date) AS delay_days
            ',FALSE)
            ->from('project_master')
            ->where('project_complete',0)
            ->where('end_date <',date('Y-m-d'))
            ->order_by('end_date','ASC')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Projects Due This Week
    |--------------------------------------------------------------------------
    */

    public function due_projects()
    {

        return $this->db
            ->select('
                project_id,
                project_code,
                project_name,
                customer_name,
                end_date,
                status
            ')
            ->from('project_master')
            ->where('end_date >=',date('Y-m-d'))
            ->where('end_date <=',date('Y-m-d',strtotime('+7 days')))
            ->order_by('end_date','ASC')
            ->get()
            ->result();

    }

        /*
    |--------------------------------------------------------------------------
    | Get Single Project
    |--------------------------------------------------------------------------
    */

    public function get_project($project_id)
    {

        return $this->db
            ->select('pm.*')
            ->from('project_master pm')
            ->where('pm.project_id',$project_id)
            ->get()
            ->row();

    }


    /*
    |--------------------------------------------------------------------------
    | Get Project Progress
    |--------------------------------------------------------------------------
    */

    public function get_project_progress($project_id)
    {

        return $this->db
            ->select('*')
            ->from('project_progress')
            ->where('project_id',$project_id)
            ->order_by('last_updated','DESC')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Get Project Work Orders
    |--------------------------------------------------------------------------
    */

    public function get_project_workorders($project_id)
    {

        return $this->db
            ->select('
                work_id,
                wo_code,
                work_order_date,
                approve_flag,
                fabrication_manhr,
                installation_manhr
            ')
            ->from('project_work_order')
            ->where('project_id',$project_id)
            ->order_by('work_order_date','DESC')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Get Project Outsource
    |--------------------------------------------------------------------------
    */

    public function get_project_outsource($project_id)
    {

        return $this->db
            ->select('*')
            ->from('project_outsource')
            ->where('project_id',$project_id)
            ->order_by('outsource_date','DESC')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Active Projects
    |--------------------------------------------------------------------------
    */

    public function active_projects()
    {

        return $this->db
            ->select('*')
            ->from('project_master')
            ->where('project_complete',0)
            ->order_by('project_name')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Completed Projects
    |--------------------------------------------------------------------------
    */

    public function completed_projects()
    {

        return $this->db
            ->select('*')
            ->from('project_master')
            ->where('project_complete',1)
            ->order_by('project_name')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Search Projects
    |--------------------------------------------------------------------------
    */

    public function search_projects($keyword)
    {

        return $this->db
            ->select('*')
            ->from('project_master')
            ->group_start()
                ->like('project_code',$keyword)
                ->or_like('project_name',$keyword)
                ->or_like('customer_name',$keyword)
            ->group_end()
            ->order_by('project_name')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Filter Projects
    |--------------------------------------------------------------------------
    */

    public function filter_projects($project_id='',$manager='',$status='',$from='',$to='')
    {

        $this->db
            ->select('pm.*')
            ->from('project_master pm');

        if($project_id!='')
        {
            $this->db->where('pm.project_id',$project_id);
        }

        if($manager!='')
        {
            $this->db->where('pm.manager',$manager);
        }

        if($status!='')
        {
            $this->db->where('pm.status',$status);
        }

        if($from!='')
        {
            $this->db->where('pm.start_date >=',$from);
        }

        if($to!='')
        {
            $this->db->where('pm.end_date <=',$to);
        }

        return $this->db
            ->order_by('pm.project_name')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Recent Activity
    |--------------------------------------------------------------------------
    */

    public function recent_activity($limit=10)
    {

        return $this->db
            ->select('
                pm.project_code,
                pm.project_name,
                pp.progress_percentage,
                pp.current_status,
                pp.last_updated
            ')
            ->from('project_progress pp')
            ->join('project_master pm',
                'pm.project_id=pp.project_id',
                'left')
            ->order_by('pp.last_updated','DESC')
            ->limit($limit)
            ->get()
            ->result();

    }
        /*
    |--------------------------------------------------------------------------
    | Get Single Work Order
    |--------------------------------------------------------------------------
    */

    public function get_workorder($work_id)
    {

        return $this->db
            ->select('
                pwo.*,
                pm.project_code,
                pm.project_name,
                pm.customer_name
            ')
            ->from('project_work_order pwo')
            ->join(
                'project_master pm',
                'pm.project_id=pwo.project_id',
                'left'
            )
            ->where('pwo.work_id',$work_id)
            ->get()
            ->row();

    }


    /*
    |--------------------------------------------------------------------------
    | Get Work Order Items
    |--------------------------------------------------------------------------
    */

    public function get_workorder_items($work_id)
    {

        return $this->db
            ->select('
                t.product_desc,
                t.item_remark,
                d.item_name,
                d.item_code,
                d.qty,
                d.width,
                d.height,
                d.price,
                d.total,
                d.colour_finish
            ')
            ->from('project_work_order_transaction t')
            ->join(
                'project_work_order_transaction1 d',
                'd.trans_id1=t.trans_id',
                'left'
            )
            ->where('t.wo_master_id',$work_id)
            ->order_by('d.trid')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Project Timeline
    |--------------------------------------------------------------------------
    */

    public function project_timeline($project_id)
    {

        return $this->db
            ->select('
                wo_code,
                work_order_date,
                fsdate,
                fedate,
                isdate,
                iedate,
                fabrication_manhr,
                installation_manhr
            ')
            ->from('project_work_order')
            ->where('project_id',$project_id)
            ->order_by('work_order_date')
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Statistics
    |--------------------------------------------------------------------------
    */

    public function dashboard_statistics()
    {

        return array(

            'projects'=>$this->count_total_projects(),

            'active'=>$this->count_active_projects(),

            'completed'=>$this->count_completed_projects(),

            'workorders'=>$this->count_pending_workorders(),

            'outsource'=>$this->count_pending_outsource(),

            'progress'=>$this->average_progress()

        );

    }


    /*
    |--------------------------------------------------------------------------
    | Monthly Progress Summary
    |--------------------------------------------------------------------------
    */

    public function monthly_progress_summary()
    {

        return $this->db
            ->select("
                DATE_FORMAT(last_updated,'%b') month_name,
                ROUND(AVG(progress_percentage),0) progress
            ",FALSE)
            ->from('project_progress')
            ->group_by("MONTH(last_updated)",FALSE)
            ->order_by("MONTH(last_updated)",FALSE)
            ->get()
            ->result();

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Overview
    |--------------------------------------------------------------------------
    */

    public function dashboard_overview()
    {

        return array(

            'cards'=>$this->dashboard_cards(),

            'recent_projects'=>$this->recent_projects(),

            'recent_workorders'=>$this->recent_workorders(),

            'recent_progress'=>$this->recent_progress(),

            'pending_outsource'=>$this->pending_outsource_list(),

            'delayed_projects'=>$this->delayed_projects(),

            'due_projects'=>$this->due_projects()

        );

    }
    /*
|--------------------------------------------------------------------------
| Total Estimated Cost
|--------------------------------------------------------------------------
*/

public function total_estimated_cost()
{

    $this->db->select_sum('total');

    $query = $this->db->get('project_items');

    if($query->num_rows())
    {
        return $query->row()->total ?: 0;
    }

    return 0;

}


/*
|--------------------------------------------------------------------------
| Estimated Cost Per Project
|--------------------------------------------------------------------------
*/

public function estimated_cost_per_project()
{

    return $this->db
        ->select('
            pm.project_id,
            pm.project_code,
            pm.project_name,
            IFNULL(SUM(pi.total),0) AS estimated_cost
        ', FALSE)
        ->from('project_master pm')
        ->join('project_items pi','pi.project_id=pm.project_id','left')
        ->group_by('pm.project_id')
        ->order_by('pm.project_name')
        ->get()
        ->result();

}
//outsource cost
/*
|--------------------------------------------------------------------------
| Total Outsource Cost
|--------------------------------------------------------------------------
*/

public function total_outsource_cost()
{
    $this->db->select('SUM(quantity * item_price) AS total_cost', FALSE);
    $this->db->from('project_outsource_details');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return ($query->row()->total_cost != NULL) ? $query->row()->total_cost : 0;
    }

    return 0;
}

/*
|--------------------------------------------------------------------------
| Total Material Request Cost
|--------------------------------------------------------------------------
*/

public function total_material_request_cost()
{
    $this->db->select('SUM(mri.quantity * im.retail_price) AS total_cost', FALSE);
    $this->db->from('material_request_items mri');
    $this->db->join('item_master im', 'im.product_id = mri.product_id', 'left');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return ($query->row()->total_cost != NULL) ? $query->row()->total_cost : 0;
    }

    return 0;
}

}
