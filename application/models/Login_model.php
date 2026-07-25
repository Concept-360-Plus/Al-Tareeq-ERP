<?php
class Login_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function validate()
    {
        $user_login =$this->input->post('user_login');
        $user_password =$this->input->post('user_password');      

		$sanitized_user_login =   mysqli_real_escape_string($this->db->conn_id, $user_login); 
	      
		$sanitized_user_password =  mysqli_real_escape_string($this->db->conn_id, $user_password);
	    
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_login',$sanitized_user_login);
        $this->db->where('user_password',$sanitized_user_password);
        $this->db->where('active',1);
        $query = $this->db->get()->result();
        return $query;      
    }

    public function get_user_dashboard($user_id)
    {
        $this->db->select('dashboard_master.controller_name');

        $this->db->from('users');

        $this->db->join(
            'employee_master',
            'employee_master.employee_id = users.employee_id'
        );

        $this->db->join(
            'department_master',
            'department_master.dept_id = employee_master.department_id'
        );

        $this->db->join(
            'dashboard_master',
            'dashboard_master.dashboard_id = department_master.dashboard_id'
        );

        $this->db->where('users.user_id',$user_id);

        return $this->db->get()->row();
    }
}