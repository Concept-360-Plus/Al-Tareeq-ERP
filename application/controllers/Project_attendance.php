<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_attendance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Project_attendance_model','attendance');
        $this->load->helper(array('url','form'));
    }

    /*
    |--------------------------------------------------------------------------
    | Attendance Dashboard
    |--------------------------------------------------------------------------
    */
    

    public function index()
    {

        $data['title']="Project Employee Attendance";

        $data['attendance_list'] =$this->attendance->get_today_task_employees();
        $data['main_content']       = 'project/project_attendance_list.php';
        $this->load->view('includes/template.php', $data);

    }

    /*
    |--------------------------------------------------------------------------
    | Start Attendance
    |--------------------------------------------------------------------------
    */

    public function start_attendance()
    {

        $task_id=$this->input->post('task_id');

        $employee_id=$this->input->post('employee_id');

        $project_id=$this->input->post('project_id');

        $this->attendance->start_attendance(

            $task_id,
            $employee_id,
            $project_id

        );

        echo json_encode(array(

            'status'=>true

        ));

    }

    /*
    |--------------------------------------------------------------------------
    | Pause
    |--------------------------------------------------------------------------
    */

    public function pause_attendance()
    {

        $attendance_id=$this->input->post('attendance_id');

        $this->attendance->pause_attendance($attendance_id);

        echo json_encode(array(

            'status'=>true

        ));

    }

    /*
    |--------------------------------------------------------------------------
    | Resume
    |--------------------------------------------------------------------------
    */

    public function resume_attendance()
    {

        $attendance_id=$this->input->post('attendance_id');

        $this->attendance->resume_attendance($attendance_id);

        echo json_encode(array(

            'status'=>true

        ));

    }

    /*
    |--------------------------------------------------------------------------
    | Finish
    |--------------------------------------------------------------------------
    */

    public function finish_attendance()
    {

        $attendance_id=$this->input->post('attendance_id');

        $this->attendance->finish_attendance($attendance_id);

        echo json_encode(array(

            'status'=>true

        ));

    }

    /*
    |--------------------------------------------------------------------------
    | Attendance Report
    |--------------------------------------------------------------------------
    */

   public function report()
    {
        $data['title'] = "Attendance Report";

        // Dropdown data
        $data['projects'] = $this->attendance->get_projects();
        $data['employees'] = $this->attendance->get_employees();

        // Filters
        $filter = array(
            'project_id'  => $this->input->get('project_id'),
            'employee_id' => $this->input->get('employee_id'),
            'status'      => $this->input->get('status'),
            'from_date'   => $this->input->get('from_date'),
            'to_date'     => $this->input->get('to_date')
        );

        // Report data
        $data['attendance'] = $this->attendance->attendance_report($filter);
        $data['main_content']       = 'project/project_attendance_report.php';
        $this->load->view('includes/template.php', $data);
        
    }

    

}