<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Check Login
        if (!$this->session->userdata('user_id'))
        {
            redirect('login');
        }

        $this->load->model('Project_dashboard_model','dashboard');

        $this->load->helper(array('url','form'));

        $this->load->library(array('session'));

       date_default_timezone_set('Asia/Dubai');
    }


    /*
    |--------------------------------------------------------------------------
    | Project Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $data = array();
        $data['title'] = 'Project Dashboard';
        /*====================================================
            Dashboard Cards
        ====================================================*/

        $data['total_projects']
            = $this->dashboard->count_total_projects();

        $data['active_projects']
            = $this->dashboard->count_active_projects();

        $data['completed_projects']
            = $this->dashboard->count_completed_projects();

        $data['pending_workorders']
            = $this->dashboard->count_pending_workorders();

        $data['approved_workorders']
            = $this->dashboard->count_approved_workorders();

        $data['pending_outsource']
            = $this->dashboard->count_pending_outsource();

        $data['completed_outsource']
            = $this->dashboard->count_completed_outsource();

        $data['delayed_projects']
            = $this->dashboard->count_delayed_projects();

        $data['due_projects']
            = $this->dashboard->count_due_projects();

        $data['average_progress']= $this->dashboard->average_progress();
        $data['estimated_cost'] = $this->dashboard->total_estimated_cost();
        $data['outsource_cost'] = $this->dashboard->total_outsource_cost();
        $data['material_request_cost'] = $this->dashboard->total_material_request_cost();
        /*====================================================
            Charts
        ====================================================*/

        $data['project_status']
            = $this->dashboard->project_status_chart();

        $data['monthly_projects']
            = $this->dashboard->monthly_projects_chart();

        $data['workorder_chart']
            = $this->dashboard->workorder_chart();

        $data['progress_chart']
            = $this->dashboard->progress_distribution_chart();


        /*====================================================
            Dashboard Tables
        ====================================================*/

        $data['recent_projects']
            = $this->dashboard->recent_projects();

        $data['recent_workorders']
            = $this->dashboard->recent_workorders();

        $data['recent_progress']
            = $this->dashboard->recent_progress();

        $data['pending_outsource_list']
            = $this->dashboard->pending_outsource_list();

        $data['delayed_project_list']
            = $this->dashboard->delayed_projects();

        $data['due_project_list']
            = $this->dashboard->due_projects();


        /*====================================================
            Header Information
        ====================================================*/

        $data['page_title']
            = 'Project Manager Dashboard';

        $data['module']
            = 'Project Management';

        $data['icon']
            = 'fa fa-dashboard';
        $data['cost_summary']=$this->dashboard->estimated_cost_per_project();

        /*====================================================
            Load View
        ====================================================*/
        $data['main_content'] = 'Project/dashboard.php';
        $this->load->view('includes/template', $data);
       
    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Cards (AJAX Refresh)
    |--------------------------------------------------------------------------
    */

    public function dashboard_cards()
    {

        $response = array(

            'total_projects'
                => $this->dashboard->count_total_projects(),

            'active_projects'
                => $this->dashboard->count_active_projects(),

            'completed_projects'
                => $this->dashboard->count_completed_projects(),

            'pending_workorders'
                => $this->dashboard->count_pending_workorders(),

            'approved_workorders'
                => $this->dashboard->count_approved_workorders(),

            'pending_outsource'
                => $this->dashboard->count_pending_outsource(),

            'completed_outsource'
                => $this->dashboard->count_completed_outsource(),

            'average_progress'
                => $this->dashboard->average_progress(),

            'delayed_projects'
                => $this->dashboard->count_delayed_projects(),

            'due_projects'
                => $this->dashboard->count_due_projects()

        );

        echo json_encode($response);

    }

    /*
    |--------------------------------------------------------------------------
    | Recent Projects
    |--------------------------------------------------------------------------
    */

    public function recent_projects()
    {

        $data['projects'] = $this->dashboard->recent_projects();

        $this->load->view(
            'project/recent_projects',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Recent Work Orders
    |--------------------------------------------------------------------------
    */

    public function recent_workorders()
    {

        $data['workorders'] = $this->dashboard->recent_workorders();

        $this->load->view(
            'project/recent_workorders',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Recent Progress
    |--------------------------------------------------------------------------
    */

    public function recent_progress()
    {

        $data['progress'] = $this->dashboard->recent_progress();

        $this->load->view(
            'project/recent_progress',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Pending Outsource
    |--------------------------------------------------------------------------
    */

    public function pending_outsource()
    {

        $data['outsource'] = $this->dashboard->pending_outsource_list();

        $this->load->view(
            'project/pending_outsource',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Delayed Projects
    |--------------------------------------------------------------------------
    */

    public function delayed_projects()
    {

        $data['projects'] = $this->dashboard->delayed_projects();

        $this->load->view(
            'project/delayed_projects',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Projects Due This Week
    |--------------------------------------------------------------------------
    */

    public function due_projects()
    {

        $data['projects'] = $this->dashboard->due_projects();

        $this->load->view(
            'project/due_projects',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Summary
    |--------------------------------------------------------------------------
    */

    public function dashboard_summary()
    {

        $response = array(

            'total_projects'      => $this->dashboard->count_total_projects(),

            'active_projects'     => $this->dashboard->count_active_projects(),

            'completed_projects'  => $this->dashboard->count_completed_projects(),

            'pending_workorders'  => $this->dashboard->count_pending_workorders(),

            'pending_outsource'   => $this->dashboard->count_pending_outsource(),

            'average_progress'    => $this->dashboard->average_progress(),

            'delayed_projects'    => $this->dashboard->count_delayed_projects(),

            'due_projects'        => $this->dashboard->count_due_projects()

        );

        header('Content-Type: application/json');

        echo json_encode($response);

    }

    /*
    |--------------------------------------------------------------------------
    | Project Status Pie Chart
    |--------------------------------------------------------------------------
    */

    public function chart_project_status()
    {
        $result = $this->dashboard->project_status_chart();

        $labels = array();
        $values = array();

        foreach ($result as $row)
        {
            $labels[] = $row->status;
            $values[] = (int)$row->total;
        }

        echo json_encode(array(
            'labels' => $labels,
            'values' => $values
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Monthly Project Creation Line Chart
    |--------------------------------------------------------------------------
    */

    public function chart_monthly_projects()
    {
        $result = $this->dashboard->monthly_projects_chart();

        $labels = array();
        $values = array();

        foreach ($result as $row)
        {
            $labels[] = $row->month_name;
            $values[] = (int)$row->total;
        }

        echo json_encode(array(
            'labels' => $labels,
            'values' => $values
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Work Order Status Bar Chart
    |--------------------------------------------------------------------------
    */

    public function chart_workorder_status()
    {
        $result = $this->dashboard->workorder_chart();

        $labels = array();
        $values = array();

        foreach ($result as $row)
        {
            $labels[] = $row->status;
            $values[] = (int)$row->total;
        }

        echo json_encode(array(
            'labels' => $labels,
            'values' => $values
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Progress Distribution
    |--------------------------------------------------------------------------
    */

    public function chart_progress_distribution()
    {

        $result = $this->dashboard->progress_distribution_chart();

        $labels = array();
        $values = array();

        foreach($result as $row)
        {
            $labels[] = $row->range;
            $values[] = (int)$row->total;
        }

        echo json_encode(array(

            'labels' => $labels,

            'values' => $values

        ));

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Refresh
    |--------------------------------------------------------------------------
    */

    public function dashboard_refresh()
    {

        $response = array(

            'cards' => array(

                'total_projects'
                    => $this->dashboard->count_total_projects(),

                'active_projects'
                    => $this->dashboard->count_active_projects(),

                'completed_projects'
                    => $this->dashboard->count_completed_projects(),

                'pending_workorders'
                    => $this->dashboard->count_pending_workorders(),

                'approved_workorders'
                    => $this->dashboard->count_approved_workorders(),

                'pending_outsource'
                    => $this->dashboard->count_pending_outsource(),

                'completed_outsource'
                    => $this->dashboard->count_completed_outsource(),

                'average_progress'
                    => $this->dashboard->average_progress(),

                'delayed_projects'
                    => $this->dashboard->count_delayed_projects(),

                'due_projects'
                    => $this->dashboard->count_due_projects()

            ),

            'charts' => array(

                'project_status'
                    => $this->dashboard->project_status_chart(),

                'monthly_projects'
                    => $this->dashboard->monthly_projects_chart(),

                'workorder_status'
                    => $this->dashboard->workorder_chart(),

                'progress_distribution'
                    => $this->dashboard->progress_distribution_chart()

            )

        );

        header('Content-Type: application/json');

        echo json_encode($response);

    }

    /*
    |--------------------------------------------------------------------------
    | Project Details
    |--------------------------------------------------------------------------
    */

    public function project_details($project_id = 0)
    {

        if($project_id==0)
        {
            show_404();
        }

        $data['project'] = $this->dashboard->get_project($project_id);

        if(empty($data['project']))
        {
            show_404();
        }

        $data['progress'] = $this->dashboard->get_project_progress($project_id);

        $data['workorders'] = $this->dashboard->get_project_workorders($project_id);

        $data['outsource'] = $this->dashboard->get_project_outsource($project_id);

        $this->load->view('project/project_details',$data);

    }


    /*
    |--------------------------------------------------------------------------
    | Work Order Details
    |--------------------------------------------------------------------------
    */

    public function workorder_details($work_id=0)
    {

        if($work_id==0)
        {
            show_404();
        }

        $data['workorder']=$this->dashboard->get_workorder($work_id);

        $data['items']=$this->dashboard->get_workorder_items($work_id);

        $this->load->view('project/workorder_details',$data);

    }


    /*
    |--------------------------------------------------------------------------
    | Project Progress Timeline
    |--------------------------------------------------------------------------
    */

    public function project_timeline($project_id=0)
    {

        if($project_id==0)
        {
            show_404();
        }

        $data['timeline']=$this->dashboard->project_timeline($project_id);

        $this->load->view('project/project_timeline',$data);

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Notifications
    |--------------------------------------------------------------------------
    */

    public function notifications()
    {

        $response=array(

            'delayed_projects'
                =>$this->dashboard->count_delayed_projects(),

            'pending_workorders'
                =>$this->dashboard->count_pending_workorders(),

            'pending_outsource'
                =>$this->dashboard->count_pending_outsource(),

            'due_projects'
                =>$this->dashboard->count_due_projects()

        );

        header('Content-Type: application/json');

        echo json_encode($response);

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Activity
    |--------------------------------------------------------------------------
    */

    public function recent_activity()
    {

        $data['activities']=$this->dashboard->recent_activity();

        $this->load->view(
            'project/recent_activity',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard Search
    |--------------------------------------------------------------------------
    */

    public function search()
    {

        $keyword=$this->input->post('keyword');

        $data['projects']=$this->dashboard->search_projects($keyword);

        $this->load->view(
            'project/search_result',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Project Completion List
    |--------------------------------------------------------------------------
    */

    public function completed_projects()
    {

        $data['projects']=$this->dashboard->completed_projects();

        $this->load->view(
            'project/completed_projects',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Active Projects
    |--------------------------------------------------------------------------
    */

    public function active_projects()
    {

        $data['projects']=$this->dashboard->active_projects();

        $this->load->view(
            'project/active_projects',
            $data
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Filter Dashboard
    |--------------------------------------------------------------------------
    */

    public function filter_dashboard()
    {

        $project_id = $this->input->post('project_id');
        $manager_id = $this->input->post('manager_id');
        $status     = $this->input->post('status');
        $from_date  = $this->input->post('from_date');
        $to_date    = $this->input->post('to_date');

        $data['projects'] = $this->dashboard->filter_projects(
            $project_id,
            $manager_id,
            $status,
            $from_date,
            $to_date
        );

        $this->load->view(
            'project/filter_result',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Export Dashboard (CSV)
    |--------------------------------------------------------------------------
    */

    public function export_dashboard()
    {

        $projects = $this->dashboard->recent_projects();

        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=Project_Dashboard.csv");

        $output = fopen("php://output", "w");

        fputcsv($output,array(
            'Project Code',
            'Project',
            'Customer',
            'Start Date',
            'End Date',
            'Status'
        ));

        foreach($projects as $row)
        {

            fputcsv($output,array(

                $row->project_code,
                $row->project_name,
                $row->customer_name,
                $row->start_date,
                $row->end_date,
                $row->status

            ));

        }

        fclose($output);

    }


    /*
    |--------------------------------------------------------------------------
    | Print Dashboard
    |--------------------------------------------------------------------------
    */

    public function print_dashboard()
    {

        $data['projects']=$this->dashboard->recent_projects();

        $data['workorders']=$this->dashboard->recent_workorders();

        $data['progress']=$this->dashboard->recent_progress();

        $this->load->view(
            'project/dashboard_print',
            $data
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Refresh Entire Dashboard
    |--------------------------------------------------------------------------
    */

    public function refresh()
    {

        $response=array(

            'cards'=>$this->dashboard->dashboard_cards(),

            'recent_projects'=>$this->dashboard->recent_projects(),

            'recent_progress'=>$this->dashboard->recent_progress(),

            'recent_workorders'=>$this->dashboard->recent_workorders(),

            'pending_outsource'=>$this->dashboard->pending_outsource_list(),

            'delayed_projects'=>$this->dashboard->delayed_projects()

        );

        header('Content-Type: application/json');

        echo json_encode($response);

    }


    /*
    |--------------------------------------------------------------------------
    | Logout (Optional)
    |--------------------------------------------------------------------------
    */

    public function logout()
    {

        $this->session->sess_destroy();

        redirect('login');

    }

}

