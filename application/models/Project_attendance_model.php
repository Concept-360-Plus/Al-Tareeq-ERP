<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_attendance_model extends CI_Model
{

    /*
    |--------------------------------------------------------------------------
    | Today's Project Employees
    |--------------------------------------------------------------------------
    */

    public function get_today_task_employees()
    {

        $today = date('Y-m-d');

        return $this->db
            ->select('
                pti.id as task_item_id,
                pti.project_id,
                pti.task_name,
                pti.priority,
                pti.status as task_status,

                pm.project_code,
                pm.project_name,

                em.employee_id,
                em.employee_name,

                dm.designation_name,

                pta.attendance_id,
                pta.check_in,
                pta.pause_time,
                pta.resume_time,
                pta.check_out,
                pta.attendance_status,
                pta.total_hours
            ')
            ->from('project_task_items pti')

            ->join('project_master pm',
                'pm.project_id=pti.project_id')

            ->join('employee_master em',
                'em.employee_id=pti.employee_id')

            ->join('designation_master dm',
                'dm.id=pti.designation_id',
                'left')

            ->join(
                'project_task_attendance pta',
                'pta.task_item_id=pti.id
                AND pta.attendance_date="'.$today.'"',
                'left'
            )

            ->where('pti.status <>','completed')

            ->order_by('pm.project_name')

            ->order_by('em.employee_name')

            ->get()

            ->result();

    }

    /*
    |--------------------------------------------------------------------------
    | Start Attendance
    |--------------------------------------------------------------------------
    */

    public function start_attendance($task_id,$employee_id,$project_id)
    {

        $today=date('Y-m-d');

        $exists=$this->db

            ->where('attendance_date',$today)

            ->where('task_item_id',$task_id)

            ->where('employee_id',$employee_id)

            ->get('project_task_attendance');

        if($exists->num_rows()>0){

            return false;

        }

        $data=array(

            'attendance_date'=>$today,

            'project_id'=>$project_id,

            'task_item_id'=>$task_id,

            'employee_id'=>$employee_id,

            'check_in'=>date('Y-m-d H:i:s'),

            'attendance_status'=>'Working',

            'created_by'=>$this->session->userdata('user_id')

        );

        $this->db->insert(

            'project_task_attendance',

            $data

        );

        return $this->db->insert_id();

    }

    /*
    |--------------------------------------------------------------------------
    | Pause
    |--------------------------------------------------------------------------
    */

    public function pause_attendance($attendance_id)
    {

        $this->db

            ->where('attendance_id',$attendance_id)

            ->update(

                'project_task_attendance',

                array(

                    'pause_time'=>date('Y-m-d H:i:s'),

                    'attendance_status'=>'Paused'

                )

            );

    }

    /*
    |--------------------------------------------------------------------------
    | Resume
    |--------------------------------------------------------------------------
    */

    public function resume_attendance($attendance_id)
    {

        $this->db

            ->where('attendance_id',$attendance_id)

            ->update(

                'project_task_attendance',

                array(

                    'resume_time'=>date('Y-m-d H:i:s'),

                    'attendance_status'=>'Working'

                )

            );

    }

    /*
    |--------------------------------------------------------------------------
    | Finish Attendance
    |--------------------------------------------------------------------------
    */

    public function finish_attendance($attendance_id)
    {

        $attendance=$this->db

            ->where('attendance_id',$attendance_id)

            ->get('project_task_attendance')

            ->row();

        if(!$attendance){

            return false;

        }

        $checkout=date('Y-m-d H:i:s');

        $checkin=strtotime($attendance->check_in);

        $checkout_time=strtotime($checkout);

        $hours=($checkout_time-$checkin)/3600;

        /*
        ------------------------------------
        Remove Pause Time
        ------------------------------------
        */

        if(!empty($attendance->pause_time)
            && !empty($attendance->resume_time))
        {

            $pause=strtotime($attendance->pause_time);

            $resume=strtotime($attendance->resume_time);

            $hours-=($resume-$pause)/3600;

        }

        $hours=number_format($hours,2);

        $this->db

            ->where('attendance_id',$attendance_id)

            ->update(

                'project_task_attendance',

                array(

                    'check_out'=>$checkout,

                    'attendance_status'=>'Completed',

                    'total_hours'=>$hours

                )

            );

    }

    /*
    |--------------------------------------------------------------------------
    | Attendance Report
    |--------------------------------------------------------------------------
    */

    public function attendance_report($filter = array())
    {
        $this->db->select("
            pta.*,
            pm.project_code,
            pm.project_name,
            em.employee_name,
            dm.designation_name,
            pti.task_name
        ");

        $this->db->from('project_task_attendance pta');

        $this->db->join('project_master pm','pm.project_id=pta.project_id');

        $this->db->join('employee_master em','em.employee_id=pta.employee_id');

        $this->db->join('designation_master dm','dm.id=em.designation_id','left');

        $this->db->join('project_task_items pti','pti.id=pta.task_item_id','left');

        if(!empty($filter['project_id']))
            $this->db->where('pta.project_id',$filter['project_id']);

        if(!empty($filter['employee_id']))
            $this->db->where('pta.employee_id',$filter['employee_id']);

        if(!empty($filter['status']))
            $this->db->where('pta.attendance_status',$filter['status']);

        if(!empty($filter['from_date']))
            $this->db->where('pta.attendance_date >=',$filter['from_date']);

        if(!empty($filter['to_date']))
            $this->db->where('pta.attendance_date <=',$filter['to_date']);

        $this->db->order_by('pta.attendance_date','DESC');

        return $this->db->get()->result();
    }

    public function get_projects()
    {
        return $this->db
            ->select('project_id, project_code, project_name')
            ->from('project_master')
            ->order_by('project_name', 'ASC')
            ->get()
            ->result();
    }
    public function get_employees()
    {
        return $this->db
            ->select('
                em.employee_id,
                em.employee_name,
                dm.designation_name
            ')
            ->from('employee_master em')
            ->join('designation_master dm', 'dm.id = em.designation_id', 'left')
            ->where('em.active', 1)
            ->order_by('em.employee_name', 'ASC')
            ->get()
            ->result();
    }

}