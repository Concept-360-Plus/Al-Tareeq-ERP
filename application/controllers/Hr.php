<?php
class Hr extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
		$this->load->model('Company_model');
	}

	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if (!isset($is_logged_in) || $is_logged_in != true) {
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';

			die();
			//$this->load->view('login/login_form');
		}
	}

	//// EMPLOYEE CODE START ////

	public function list_employee()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Hr/list_employee')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {
			$data['title'] = 'Employee List';
			$raw_input = $this->input->post('filter');

			if (!empty($raw_input)) {
				list($filter_type, $filter_value) = explode(':', $raw_input, 2);
				$filter_type = trim($filter_type);
				$filter_value = trim($filter_value);

				$column_map = [
					'Employee Name' => 'employee_name',
					'Employee Code' => 'employee_code'
					// No 'Designation' here, handled separately
				];

				if ($filter_type === 'Designation') {
					// Get the designation ID
					$designation = $this->db->where('designation_name', $filter_value)->get('designation_master')->row();

					if ($designation) {
						// Fetch using the ID condition
						$data['employee_list'] = $this->Company_model->get_all_employees('designation_id', $designation->id);
					} else {
						// No match, return empty list
						$data['employee_list'] = [];
					}
				} else {
					// Use column mapping for name/code
					$column = isset($column_map[$filter_type]) ? $column_map[$filter_type] : null;
					if ($column && $filter_value !== '') {
						$data['employee_list'] = $this->Company_model->get_all_employees($column, $filter_value);
					} else {
						$data['employee_list'] = $this->Company_model->get_all_employees();
					}
				}
			} else {
				// No filter input — fetch all employees
				$data['employee_list'] = $this->Company_model->get_all_employees();
			}

			$data['main_content'] = 'company/list_employees.php';
		}

		$this->load->view('includes/template', $data);
	}

	public function add_employee()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/list_employee', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {
			$data['title'] = 'Add Employee';
			$data['branch_list'] = $this->Company_model->get_all_branches();
			$data['department_list']  = $this->Company_model->get_all_departments();
			$data['designation_list'] = $this->Company_model->get_all_designations();
			// Generate user code automatically
			$last_id = $this->Company_model->get_last_employee_id(); // create this method
			$next_id = $last_id + 1;
			$data['user_code'] = 'EMP' . str_pad($next_id, 4, '0', STR_PAD_LEFT); // Example: EMP0001

			$data['main_content'] = 'company/add_employee.php';
		}

		$this->load->view('includes/template', $data);
	}

	public function save_employee()
	{
		$post = $this->input->post();
		// --- Handle file uploads ---
		$photo      = $this->_upload_file('employee_photo');
		$labor_card = $this->_upload_file('labor_card_image');
		$eid        = $this->_upload_file('eid_image');
		$signature  = $this->_upload_file('signature_file');

		// --- Prepare employee data ---
		$employee_data = [
			'employee_name'        => $post['employee_name'],
			'branch_id'            => $post['branch_id'],
			'mobile'               => $post['mobile'],
			'gender'               => $post['gender'],
			'birth_date'           => $post['birth_date'],
			'nationality'          => $post['nationality'],
			'joining_date'         => $post['joining_date'],
			'employee_photo'       => $photo,
			'signature_file'       => $signature,
			'department_id'        => $post['department_id'],
			'designation_id'       => $post['designation_id'],
			'uid_number'           => $post['uid_number'],
			'user_code'            => $post['employee_code'],


			// Passport Details
			'passport_name'        => $post['passport_name'],
			'passport_number'      => $post['passport_number'],
			'passport_issue_date'  => $post['passport_issue_date'],
			'passport_expiry_date' => $post['passport_expiry_date'],
			'passport_issue_place' => $post['passport_issue_place'],

			// Labor Card
			'work_permit_no'       => $post['work_permit_no'],
			'personal_id_no'       => $post['personal_id_no'],
			'labor_issue_date'     => $post['labor_issue_date'],
			'labor_expiry_date'    => $post['labor_expiry_date'],
			'labor_card_image'     => $labor_card,

			// Emirates ID
			'eid_number'           => $post['eid_number'],
			'eid_issue_date'       => $post['eid_issue_date'],
			'eid_expiry_date'      => $post['eid_expiry_date'],
			'eid_image'            => $eid,

			// Salary
			'salary_mode'          => $post['salary_mode'],
			'card_number'          => $post['card_number'],

			'created_on'           => date('Y-m-d H:i:s'),
		];

		// --- Start database transaction ---
		$this->db->trans_start();

		// --- 1️⃣ Save Employee Master ---
		$insert_id = $this->Company_model->insert_employee($employee_data);

		// --- 2️⃣ Create Software Access (if enabled) ---
		if (!empty($post['software_access'])) {
			$user_data = [
				'user_name'     => $post['employee_name'],
				'user_login'    => $this->input->post('user_login'),
				'user_password' => $this->input->post('user_password'),
				'gender'        => $post['gender'],
				'dob'           => $post['birth_date'],
				'employee_id'   => $insert_id,
				'active'        => 1
			];
			$this->Company_model->insert_user($user_data);
		}

		// --- 3️⃣ Create Ledger Entry ---
		if ($insert_id) {
			$grp_no = 11; // Ledger group (e.g., Employees / Salary Payable)
			$account_name = $post['employee_name'] . ' (' . $insert_id . ')';

			$ledger_data = [
				'account_name'     => $account_name,
				'group_no'         => $grp_no,
				'employee_id'      => $insert_id,
				'opening_bal_type' => 'Dr',
				'branch_id'        => $post['branch_id']
			];

			$this->db->insert('general_ledger', $ledger_data);
			$ledger_id = $this->db->insert_id();
		}

		// --- Complete the transaction ---
		$this->db->trans_complete();

		// --- 4️⃣ Transaction Status Check ---
		if ($this->db->trans_status() === FALSE) {
			$this->session->set_flashdata('error', 'Error while saving employee or ledger.');
		} else {
			$this->session->set_flashdata('success', 'Employee and Ledger created successfully!');
		}

		// --- 5️⃣ Redirect to employee list ---
		redirect('Hr/list_employee');
	}

	private function _upload_file($field_name)
	{
		if (!empty($_FILES[$field_name]['name'])) {
			$config['upload_path']   = './public/employee/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|PNG';
			$config['max_size']      = 2048;
			$config['encrypt_name']  = TRUE;
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($field_name)) {
				$this->session->set_flashdata('error', 'File upload error: ' . $this->upload->display_errors());
				redirect($_SERVER['HTTP_REFERER']);
			} else {
				return $this->upload->data('file_name');
			}
		}
		return null;
	}

	public function edit_employee($id)
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/list_employee', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {
			$data['title'] = 'Edit Employee';
			$data['employee_id'] = $id;
			//$data['branch_list']=$this->Company_model->get_all_branches();
			$employee = $this->Company_model->get_employee_by_id($id);
			$data['employee'] = $employee;
			$data['branch_list'] = $this->Company_model->get_all_branches();
			$data['department_list']  = $this->Company_model->get_all_departments();
			$data['designation_list'] = $this->Company_model->get_all_designations();
			$data['main_content'] = 'company/edit_employee.php';
			$this->load->view('includes/template', $data);
		}
	}

	public function update_employee($id)
	{

		$data = [
			'employee_name'         => $this->input->post('employee_name'),
			'branch_id'             => $this->input->post('branch_id'),
			'mobile'                => $this->input->post('mobile'),
			'gender'                => $this->input->post('gender'),
			'birth_date'            => $this->input->post('birth_date'),
			'uid_number'            => $this->input->post('uid_number'),
			'user_code'             => $this->input->post('employee_code'),
			'nationality'           => $this->input->post('nationality'),
			'joining_date'          => $this->input->post('joining_date'),
			'department_id'         => $this->input->post('department_id'),
			'designation_id'        => $this->input->post('designation_id'),
			'passport_name'         => $this->input->post('passport_name'),
			'passport_number'       => $this->input->post('passport_number'),
			'passport_issue_date'   => $this->input->post('passport_issue_date'),
			'passport_expiry_date'  => $this->input->post('passport_expiry_date'),
			'passport_issue_place'  => $this->input->post('passport_issue_place'),
			'work_permit_no'        => $this->input->post('work_permit_no'),
			'personal_id_no'        => $this->input->post('personal_id_no'),
			'labor_issue_date'      => $this->input->post('labor_issue_date'),
			'labor_expiry_date'     => $this->input->post('labor_expiry_date'),
			'eid_number'            => $this->input->post('eid_number'),
			'eid_issue_date'        => $this->input->post('eid_issue_date'),
			'eid_expiry_date'       => $this->input->post('eid_expiry_date'),
			'salary_mode'           => $this->input->post('salary_mode'),
			'card_number'           => $this->input->post('card_number'),
			'updated_on'            => date('Y-m-d H:i:s')
		];

		if (!empty($_FILES['employee_photo']['name'])) {
			$photo = $this->_upload_file('employee_photo');
			if ($photo) {
				$data['employee_photo'] = $photo;
			}
		}

		if (!empty($_FILES['labor_card_image']['name'])) {
			$labor_card = $this->_upload_file('labor_card_image');
			if ($labor_card) {
				$data['labor_card_image'] = $labor_card;
			}
		}

		if (!empty($_FILES['eid_image']['name'])) {
			$eid = $this->_upload_file('eid_image');
			if ($eid) {
				$data['eid_image'] = $eid;
			}
		}
		if (!empty($_FILES['signature_file']['name'])) {
			$signature = $this->_upload_file('signature_file');
			if ($signature) {
				$data['signature_file'] = $signature;
			}
		}

		$update_status = $this->Company_model->update_employee($id, $data);
		if ($update_status)
			$this->session->set_flashdata('success', 'Employee updated successfully.');
		else
			$this->session->set_flashdata('error', 'an error occured while updating .');
		redirect('Hr/list_employee');
	}

	public function delete_employee()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/list_employee', 'D')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {
			$id = $this->input->post("id");
			$is_exist = $this->Company_model->get_employee_by_id($id);
			if (empty($id) || empty($is_exist)) {
				echo json_encode([
					'status' => 0,
					'message' => 'Invalid employee ID or employee does not exist.'
				]);
				return;
			}

			$deleted = $this->Company_model->delete_employee($id);

			if ($deleted) {
				echo json_encode([
					'status' => 1,
					'message' => 'Employee deleted successfully.'
				]);
			} else {
				echo json_encode([
					'status' => 0,
					'message' => 'Failed to delete employee. Try again.'
				]);
			}
		}
	}

	//// EMPLOYEE CODE ENDS ////

	//// DEPARTMENT CODE START ////

	public function list_department()
	{
		$user = $this->session->userdata('user_id');

		if (!has_view_access($user, 'Hr/list_department')) {

			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {

			$data['title'] = 'Department List';
			$data['department_list'] = $this->Company_model->get_all_departments();

			$data['main_content'] = 'company/department_list.php';
		}

		$this->load->view('includes/template', $data);
	}

	public function add_department()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/list_department', 'A')) {

			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {

			$data['title'] = 'Add Department';
			$data['dashboard_list'] = $this->Company_model->get_dashboard_list();
			$data['main_content'] = 'company/department_add.php';
		}

		$this->load->view('includes/template', $data);
	}

	public function save_department()
	{
		$data = array(
			'dept_name'     => $this->input->post('dept_name', TRUE),
			'remark'        => $this->input->post('remark', TRUE),
			'status'        => $this->input->post('status', TRUE),
			'dashboard_id'  => $this->input->post('dashboard_id', TRUE),
			'created_by'    => $this->session->userdata('user_id')
		);

		if ($this->Company_model->add_department_data($data))
			$this->session->set_flashdata('success', 'Department added successfully.');
		else
			$this->session->set_flashdata('error', 'Error while saving.');

		redirect('Hr/list_department');
	}

	public function edit_department()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/list_department', 'E')) {

			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {

			$department_id   = $this->uri->segment(3);

			$data['title']   = 'Edit Department';
			$data['dashboard_list'] = $this->Company_model->get_dashboard_list();
			$data['records'] = $this->Company_model->get_department_record_by_id($department_id);
			$data['main_content'] = 'company/department_edit.php';
		}

		$this->load->view('includes/template', $data);
	}

	public function update_department()
	{
		$department_id = $this->input->post('dept_id');

		$data = array(
			'dept_name'      => $this->input->post('dept_name', TRUE),
			'dashboard_id'   => $this->input->post('dashboard_id', TRUE),
			'remark'         => $this->input->post('remark', TRUE),
			'status'         => $this->input->post('status', TRUE),
		);

		if ($this->Company_model->update_department_data($department_id, $data))
			$this->session->set_flashdata('success', 'Department updated successfully.');
		else
			$this->session->set_flashdata('error', 'Update failed.');

		redirect('Hr/list_department');
	}

	//// DEPARTMENT CODE END ////

	//// DESIGNATION CODE START ////

	public function list_designation()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Hr/list_designation')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {
			$data['title'] = 'List Designation';
			$raw_input = $this->input->post('filter');

			if (!empty($raw_input)) {
				$filter_type = '';
				$filter_value = '';

				if (strpos($raw_input, ':') !== false) {
					list($filter_type, $filter_value) = explode(':', $raw_input, 2);
					$filter_type = trim($filter_type);
					$filter_value = trim($filter_value);
					$column_map = [
						'Designation Code' => 'designation_code',
						'Designation Name' => 'designation_name',
						'Department' => 'department',
						'Reporting To' => 'reporting_to',
						'Level' => 'level',
						'Type' => 'employment_type',
						'Location' => 'location',
						'Status' => 'status'
					];
					$column = isset($column_map[$filter_type]) ? $column_map[$filter_type] : null;
					$data['designation_list'] = $this->Company_model->get_all_designations($column, $filter_value);
				} else {
					$data['designation_list'] = $this->Company_model->get_all_designations();
				}
			} else {
				$data['designation_list'] = $this->Company_model->get_all_designations();
			}
			$data['main_content'] = 'company/list_designation.php';
			$this->load->view('includes/template', $data);
		}
	}

	public function add_designation()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/list_designation', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {
			$data['title'] = 'Add Designation';
			$data['designation_code'] = $this->Company_model->generate_designation_code();
			$data['departments'] = $this->Company_model->get_active_department_list();
			$data['main_content'] = 'company/add_designation.php';
		}
		$this->load->view('includes/template', $data);
	}

	public function save_designation()
	{
		// Load form validation library if not auto-loaded
		// $this->load->library('form_validation');

		// Set validation rules
		// $this->form_validation->set_rules('designation_code', 'Designation Code', 'required|trim|is_unique[designation_master.designation_code]');
		// $this->form_validation->set_rules('designation_name', 'Designation Name', 'required|trim');

		// If validation fails, reload form with errors
		//if ($this->form_validation->run() == FALSE) {
		// $this->load->view('designation/add_designation'); // adjust to your actual view
		//} else {
		// Collect data
		$data = array(
			'designation_code'    => $this->input->post('designation_code', TRUE),
			'designation_name'    => $this->input->post('designation_name', TRUE),
			'department'          => $this->input->post('department', TRUE),
			'reporting_to'        => $this->input->post('reporting_to', TRUE),
			'level'               => $this->input->post('level', TRUE),
			'employment_type'     => $this->input->post('employment_type', TRUE),
			'location'            => $this->input->post('location', TRUE),
			'job_description'     => $this->input->post('job_description', TRUE),
			'responsibilities'    => $this->input->post('responsibilities', TRUE),
			'skills'              => $this->input->post('skills', TRUE),
			'qualification'       => $this->input->post('qualification', TRUE),
			'experience'          => $this->input->post('experience', TRUE),
			'status'              => $this->input->post('status', TRUE),
			'created_on'          => date('Y-m-d H:i:s')
		);
		$insert_status = $this->Company_model->insert_designation($data);
		if ($insert_status) {
			$this->session->set_flashdata('success', 'Designation saved successfully!');
		} else {
			$this->session->set_flashdata('error', 'error occured while saving designation!');
		}
		redirect('Hr/list_designation');
		// }
	}

	public function edit_designation()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/list_designation', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
		} else {
			$data['title'] = 'Edit Designation';
			$designation_id = $this->uri->segment('3');
			$data['designation'] = $this->Company_model->get_designation_by_id($designation_id);
			$data['designation_id'] = $designation_id;
			$data['departments'] = $this->Company_model->get_active_department_list();
			$data['main_content'] = 'company/edit_designation.php';
		}
		$this->load->view('includes/template', $data);
	}

	public function update_designation()
	{
		$designation_id = $this->input->post('designation_id');
		$data = array(
			'designation_name'    => $this->input->post('designation_name', TRUE),
			'department'          => $this->input->post('department', TRUE),
			'reporting_to'        => $this->input->post('reporting_to', TRUE),
			'level'               => $this->input->post('level', TRUE),
			'employment_type'     => $this->input->post('employment_type', TRUE),
			'location'            => $this->input->post('location', TRUE),
			'job_description'     => $this->input->post('job_description', TRUE),
			'responsibilities'    => $this->input->post('responsibilities', TRUE),
			'skills'              => $this->input->post('skills', TRUE),
			'qualification'       => $this->input->post('qualification', TRUE),
			'experience'          => $this->input->post('experience', TRUE),
			'status'              => $this->input->post('status', TRUE),
			'updated_on'          => date('Y-m-d H:i:s')
		);

		$update_status = $this->Company_model->update_designation($designation_id, $data);
		if ($update_status)
			$this->session->set_flashdata('success', 'Designation updated successfully.');
		else
			$this->session->set_flashdata('error', 'Error occured while updating');

		redirect('Hr/list_designation'); // or redirect to wherever you want
	}

	public function delete_designation()
	{
		$id = $this->input->post('id');
		$this->load->model('Company_model');
		$deleted = $this->Company_model->delete_designation($id);
		echo $deleted ? '1' : '0';
	}
	
	//// DESIGNATION CODE END ////


	///////////////////////////////////////Allowances////////////////////////////////////////////// 

	function add_allowances()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_allowances_list', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Allowances & Deductions Master";
		$data['main_content'] = 'hr/allowances_deductions_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_allowances_list()
	{
		$user = $this->session->userdata('user_id');

		if (!has_view_access($user, 'Hr/view_allowances_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Allowances & Deductions Master List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_allowances_list();
		$data['main_content'] = 'hr/allowances_deductions_list.php';
		$this->load->view('includes/template', $data);
	}

	public function add_allowances_data()
	{
		$data['title'] = "Allowances & Deductions Master";
		$this->load->model('Hr_model');

		// Get posted values
		$atype = $this->input->post('allowance_type');
		$aname = $this->input->post('allowance_name');

		// Check for duplicates
		$this->db->where('allowance_type', $atype);
		$this->db->where('allowance_name', $aname);
		$exists = $this->db->get('allowance_master')->num_rows();

		if ($exists > 0) {
			// Duplicate exists
			$this->session->set_flashdata('warning', 'Allowance Name Already Exists');
			redirect('Hr/add_allowances'); // reload form
			exit;
		}

		// No duplicate, proceed to save
		$flag = $this->Hr_model->add_allowances_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_allowances_list');
		} else {
			$this->session->set_flashdata('warning', 'Error Saving Record');
			redirect('Hr/add_allowances');
		}
	}
	function edit_allowances()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_allowances_list', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Edit Allowances & Deductions Master";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_allowances_by_id($id);
		$data['main_content'] = 'hr/allowances_deductions_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_allowances()
	{
		$data['title'] = "Allowances & Deductions Master";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_allowances($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_allowances_list');
		}
	}
	function delete_Allowances()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_allowances_list', 'D')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_allowance($id);

		$this->session->set_flashdata('success', 'Record Delete Successfully');
		redirect('Hr/view_allowances_list');
	}

	///////////////////////////////////////Leave application ////////////////////////////////////////////// 

	function add_leave_application()
	{
		$data['title'] = "Leave application";
		// $this->load->model('Users_model');
		// $data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');

		$data['records'] = $this->Hr_model->get_employee_list();

		$data['main_content'] = 'hr/leave_allocation_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_leave_application_list()
	{
		$data['title'] = "Leave application";

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_leave_list();
		$data['record1'] = $this->Hr_model->leave_approval_list();
		$data['record2'] = $this->Hr_model->get_user_list();
		// print_r($data['records']);
		// exit;
		$data['main_content'] = 'hr/leave_allocation_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_leave_application_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_employee_leave_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_leave_application_list');
		} else {
			$this->session->set_flashdata('warning', 'Supplier Company Name Already Exist');
			redirect('Hr/view_leave_application_list');
		}
	}

	function edit_leave_application()
	{
		$data['title'] = "Edit Leave application";
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		// Employee list
		$data['records'] = $this->Hr_model->get_employee_list();
		// Leave record
		$data['leave'] = $this->Hr_model->get_employee_leave_by_id($id);
		// Files
		$data['file_records'] = $this->Hr_model->get_employee_leave_doc_id($id);
		// HR list
		$data['admin_hr'] = $this->Hr_model->leave_hr_admin_list();
		// 🔥 ADD THIS (IMPORTANT FIX)
		$data['leave_status'] = $this->Hr_model->get_leave_latest_status($id);
		$data['main_content'] = 'hr/leave_allocation_edit';
		$this->load->view('includes/template', $data);
	}

	function update_leave_application()
	{
		$data['title'] = "Edit Leave application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_employee_leave($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_leave_application_list');
		}
	}

	function print_leave_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$this->load->model('Setup_model');
		$data['records'] = $this->Hr_model->get_employee_list();

		// Single leave record
		$data['leave'] = $this->Hr_model->get_employee_leave_by_id($id);

		// Documents
		$data['file_records'] = $this->Hr_model->get_employee_leave_doc_id($id);

		// Dropdown helpers (optional)
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$data['desig_list'] = $this->Setup_model->get_designation_list();

		$this->load->view('hr/print/print_leave_application.php', $data);
	}

	function delete_leave_application()
	{


		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_leave_application($id);

		$this->session->set_flashdata('success', 'Record Delete Successfully');
		redirect('Hr/view_leave_application_list');
	}

	//approvalcontroler//////////////////leave_id
	function add_leave_approval()
	{

		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_approval_leave();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_leave_application_list');
		}
	}

	///////////////////////////////////////Joining Application////////////////////////////////////////////// 

	function add_joining_application()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_joining_application_list', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$this->load->model('Hr_model');

		$data['user_records'] = $this->Hr_model->get_joining_new_list();
		$data['title'] = "Joining Application";
		$data['main_content'] = 'hr/joining_allocation_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_joining_application_list()
	{
		$user = $this->session->userdata('user_id');

		if (!has_view_access($user, 'Hr/view_joining_application_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Joining Application List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_joining_list();
		$data['main_content'] = 'hr/joining_allocation_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_joining_application_data()
	{
		$data['title'] = "Joining Application";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_joining_application_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_joining_application_list');
		} else {
			$this->session->set_flashdata('warning', 'Supplier Company Name Already Exist');
			redirect('Hr/view_joining_application_list');
		}
	}

	function edit_joining_application()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_joining_application_list', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Joining Application Edit";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		// $data['records'] = $this->Hr_model->get_employee_joining_by_id($id);
		$data['record'] = $this->Hr_model->get_employee_joining_by_id($id);

		$data['main_content'] = 'hr/joining_allocation_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_joining_application()
	{
		$data['title'] = "Joining Application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_joining_application($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_joining_application_list');
		}
	}

	function print_joining_application()
	{
		$id = $this->uri->segment(3);

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_joining_by_id($id);

		// ❌ REMOVE THIS (not needed)
		// $this->load->model('Users_model');
		// $data['record1'] = $this->Users_model->get_user_record_by_id_pass($id);

		$this->load->model('Setup_model');
		$data['dept_list'] = $this->Setup_model->get_active_department_list();

		$this->load->view('hr/print/print_joining_application.php', $data);
	}

	function delete_joining_application()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_joining_application_list', 'D')) {
			show_error('Access Denied');
			return;
		}
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_joining_application($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_joining_application_list');
	}

	///////////////////////////////////////salary_structure////////////////////////////////////////////// 

	function add_emp_salary_structure()
	{
		$data['title'] = "Employee Salary Structure";

		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_allowances_list();
		$data['records'] = $this->Hr_model->get_active_basic_salary();
		// $data['user_records'] = $this->Hr_model->get_active_basic_salary();
		$data['main_content'] = 'hr/basic_salary_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_salary_structure_list()
	{
		$data['title'] = "Employee Salary List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_salary_structure_list();

		$data['main_content'] = 'hr/basic_salary_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_salary_structure_data()
	{
		$data['title'] = "Add Salary Structure";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_salary_structure();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_salary_structure_list');
		} else {
			$this->session->set_flashdata('warning', 'data Already Exist');
			redirect('Hr/add_allowances');
		}
	}

	function edit_salary_structure()
	{
		$data['title'] = "Edit Salary Structure";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		// $data['user_records'] = $this->Users_model->get_user_list();
		$data['user_records'] = $this->Hr_model->get_employee_list();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_salary_structure_by_id($id);
		$data['record1'] = $this->Hr_model->get_allowances_list();
		$data['details'] = $this->Hr_model->get_salary_allowance_details($id);
		$data['main_content'] = 'hr/basic_salary_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_salary_structure()
	{
		$data['title'] = "Update Salary Structure";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$res = $this->Hr_model->update_salary_structure($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_salary_structure_list');
		}
	}

	function delete_basic_salary()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_salary_structure($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_salary_structure_list');
	}

	///////////////////////////////////////emp_attendance////////////////////////////////////////////// 

	function add_emp_attendance()
	{
		$data['title'] = "Employee Attendance";

		// $this->load->model('Users_model');
		// $data['records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');

		$data['records'] = $this->Hr_model->get_employee_list();
		$data['main_content'] = 'hr/employee_attendance_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_emp_attendance_list()
	{
		$data['title'] = "Employee Attendance List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_attendance_list();
		$data['main_content'] = 'hr/employee_attendance_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_attendance_data()
	{
		$data['title'] = "Add Employee Attendance";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_emp_attendance_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_attendance_list');
		} else {
			$this->session->set_flashdata('warning', 'Employee Name Already Exist');
			redirect('Hr/add_emp_attendance');
		}
	}

	function edit_emp_attendance()
	{
		$data['title'] = "Edit Employee Attendance";
		$id = $this->uri->segment('3');

		// $this->load->model('Users_model');
		// $data['records'] = $this->Users_model->get_user_list(); // Employee list for dropdown
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_list();

		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_emp_attendance_by_id($id);

		// Employee master details for pre-filling passport info
		if (!empty($data['record1']->employee_id)) {
			$data['record'] = $this->Hr_model->get_employee_by_id($data['record1']->employee_id);
		}
		$data['main_content'] = 'hr/employee_attendance_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_emp_attendance()
	{
		$data['title'] = "Attendance Data";
		$id = $this->input->post('emp_aId');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_emp_attendance($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_attendance_list');
		}
	}
	function delete_attendance_emp()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_attendance_emp($id);

		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_emp_attendance_list');
	}

	///////////////////////////////////////add_emp_overtime////////////////////////////////////////////// 

	function add_emp_overtime()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_emp_overtime_list', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Employee Overtime";

		// $this->load->model('Users_model');
		// $data['records'] = $this->Users_model->get_user_list();

		$this->load->model('Hr_model');

		$data['records'] = $this->Hr_model->get_employee_list();

		$data['main_content'] = 'hr/employee_overtime_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_emp_overtime_list()
	{
		$user = $this->session->userdata('user_id');

		if (!has_view_access($user, 'Hr/view_emp_overtime_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Employee Overtime List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_overtime_list();
		$data['main_content'] = 'hr/emp_overtime_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_overtime_data()
	{
		$data['title'] = "Add Overtime Data";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_emp_overtime_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_overtime_list');
		} else {
			$this->session->set_flashdata('warning', ' Record Already Exist');
			redirect('Hr/add_emp_overtime');
		}
	}

	public function edit_emp_overtime()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_emp_overtime_list', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}

		$data['title'] = "Edit Employee Overtime";
		$id = $this->uri->segment(3);

		$this->load->model('Hr_model');
		// Get the single row of overtime to edit
		$data['row'] = $this->Hr_model->get_emp_overtime_by_id($id);

		// Get list of all employees for dropdown
		$data['records'] = $this->Hr_model->get_employee_list();
		$data['main_content'] = 'hr/emp_overtime_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_emp_overtime()
	{
		$data['title'] = "Supplier Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_emp_overtime($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_overtime_list');
		}
	}

	function delete_overtime_emp()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_allowances_list', 'D')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_emp_overtime($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_emp_overtime_list');
	}

	///////////////////////////////////////add_resignation////////////////////////////////////////////// 

	function add_resignation()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_emp_resignation_list', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Add Resignation";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_list();
		// $this->load->model('Users_model');
		// 		$data['user_records'] = $this->Users_model->get_user_list();
		// $data['user_records'] = $this->Hr_model->get_resignation_active_list();
		$data['main_content'] = 'hr/resignation_emp_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_emp_resignation_list()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Hr/view_emp_resignation_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Resignation List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_resignation_list();
		$data['main_content'] = 'hr/resignation_emp_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_resignation_data()
	{
		$this->load->model('Hr_model');
		$employee_id = $this->input->post('employee_id');
		$resignation_date = $this->input->post('resignation_date');
		$last_working_date = $this->input->post('last_working_date');

		// Convert to comparable format (Y-m-d)
		$resignation_date = date('Y-m-d', strtotime($resignation_date));
		$last_working_date = date('Y-m-d', strtotime($last_working_date));

		// ✅ VALIDATION CHECK
		if (strtotime($last_working_date) < strtotime($resignation_date)) {
			$this->session->set_flashdata(
				'warning',
				'Effective Last Working Date cannot be earlier than the Resignation Date.'
			);
			redirect('Hr/add_resignation');
			return;
		}

		// Save data
		$flag = $this->Hr_model->add_resignation();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_resignation_list');
		} else {
			$this->session->set_flashdata('warning', 'Record Already Exists or Error Occurred');
			redirect('Hr/add_resignation');
		}
	}

	function edit_emp_resignation()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_emp_resignation_list', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}

		$data['title'] = "Edit Resignation";
		$id = $this->uri->segment(3);
		$this->load->model('Users_model');
		// $data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		// Employee list (dropdown)
		$data['user_records'] = $this->Hr_model->get_employee_list();
		$data['record'] = $this->Hr_model->get_employee_resigning_by_id($id); // single row
		$data['file_records'] = $this->Hr_model->get_employee_document_doc_id($id);
		$data['main_content'] = 'hr/resignation_emp_edit';
		$this->load->view('includes/template', $data);
	}

	function update_emp_resignation()
	{
		$data['title'] = "Update Resignation";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_resigning_application($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_resignation_list');
		}
	}

	function print_resignation_application()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_list();
		$data['resignation'] = $this->Hr_model->get_employee_resigning_by_id($id);
		$this->load->model('Users_model');
		$data['record1'] = $this->Users_model->get_user_record_by_id_pass($id);
		$this->load->model('Setup_model');
		$data['dept_list'] = $this->Setup_model->get_active_department_list();
		$this->load->view('hr/print/print_resigning_application.php', $data);
	}

	function delete_resignation_application()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_emp_resignation_list', 'D')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_resignation_application($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_emp_resignation_list');
	}

	///////////////////////////////////////add_passport_release////////////////////////////////////////////// 

	function add_passport_release()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_passport_release_list', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Passport Release";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_list();
		$data['main_content'] = 'hr/passport_relese_add.php';
		$this->load->view('includes/template', $data);
	}

	function view_passport_release_list()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Hr/view_passport_release_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Passport Release List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_passport_release_list();
		$data['main_content'] = 'hr/passport_relese_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_passport_release()
	{
		$data['title'] = "Passport Relese Add";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_passport_release();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_passport_release_list');
		} else {
			$this->session->set_flashdata('warning', 'Name Already Exist');
			redirect('Hr/view_passport_release_list');
		}
	}

	function edit_passport_release()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_passport_release_list', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}

		$data['title'] = "Edit Release Passport";
		$id = $this->uri->segment(3);

		// Employee list for dropdown
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_list();

		// Passport release record
		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_passport_release_list_by_id($id);

		// Employee master details for pre-filling passport info
		if (!empty($data['record1']->employee_id)) {
			$data['record'] = $this->Hr_model->get_employee_by_id($data['record1']->employee_id);
		}

		$data['main_content'] = 'hr/passport_release_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_passport_release()
	{
		$data['title'] = "Update_Release Passport";
		$id = $this->input->post('id');

		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_passport_re($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_passport_release_list');
		}
	}

	function print_passport_release()
	{
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_passport_release_list_by_id($id);
		$data['records'] = $this->Hr_model->get_user_record_by_id($id);

		$this->load->model('Setup_model');
		$data['dept_list'] = $this->Setup_model->get_active_department_list();

		$this->load->view('hr/print/print_passport_release.php', $data);
	}

	function delete_passport_release()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_emp_resignation_list', 'D')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_passport_release($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_passport_release_list');
	}

	///////////////////////////////////////add_corporate_file////////////////////////////////////////////// 

	function add_corporate_file()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_corporate_file_list', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Corporate File";
		$data['main_content'] = 'hr/corporate_file_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_corporate_file_list()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Hr/view_corporate_file_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Corporate File List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_corporate_file_list();
		$data['main_content'] = 'hr/corporate_file_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_corporate_file_data()
	{
		$data['title'] = "Corporate File ";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_corporate_file_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_corporate_file_list');
		} else {
			$this->session->set_flashdata('warning', 'Name Already Exist');
			redirect('Hr/view_corporate_file_list');
		}
	}

	function edit_corporate_file()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_corporate_file_list', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$data['title'] = "Corporate File Edit";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_corporate_file_id($id);
		$data['file_records'] = $this->Hr_model->get_employee_corporate_doc_id($id);
		$data['main_content'] = 'hr/corporate_file_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_corporate_file()
	{
		$data['title'] = "Update Corporate File";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_corporate_file_data($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_corporate_file_list');
		}
	}

	function delete_corporate_file()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_corporate_file_list', 'D')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_corporate_file_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_corporate_file_list');
	}
	///////////////////////////////////////add_vehicles////////////////////////////////////////////// 

	function add_vehicles()
	{
		$data['title'] = "Vehicle Details";
		$data['main_content'] = 'hr/vehicle_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_vehicles_list()
	{
		$data['title'] = "Vehicle Details List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_vehicle_list();
		$data['main_content'] = 'hr/vehicle_details_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_vehicles_details()
	{
		$data['title'] = " Add Vehicle Details";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_vehicle_details();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_vehicles_list');
		} else {
			$this->session->set_flashdata('warning', 'Vehicle Details Name Already Exist');
			redirect('Hr/add_vehicles');
		}
	}

	function edit_vehicles()
	{
		$data['title'] = " Edit Vehicle Details";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_vehicle_details_by_id($id);
		$data['main_content'] = 'hr/vehicle_details_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_vehicles()
	{
		$data['title'] = "Update Vehicle Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_vehicle_details($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_vehicles_list');
		}
	}
	function delete_vehicle_details()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_vehicle_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_vehicles_list');
	}
	///////////////////////////////////////add_monthly_salary////////////////////////////////////////////// 

	// function add_monthly_salary()
	// {
	// 	$data['title'] = "Monthly Salary";
	// 	$data['effective_date'] = date('M-Y');
	// 	$data['user_id'] = $this->input->post('user_id');
	// 	$this->load->model('Users_model');
	// 	$data['records'] = $this->Users_model->get_user_list();
	// 	if ($data['user_id'] == '')
	// 		$data['record1'] = array();
	// 	else {
	// 		$data['effective_date'] = $this->input->post('effective_date');
	// 		$data['user_id'] = $this->input->post('user_id');

	// 		$effective_date = $this->input->post('effective_date');
	// 		$selected_month_year = date('Y-m', strtotime($effective_date));
	// 		$start_date = date('Y-m-01', strtotime($selected_month_year));
	// 		$end_date = date('Y-m-t', strtotime($selected_month_year));
	// 		$data['days_in_month'] = date('t', strtotime($selected_month_year));


	// 		$this->load->model('Users_model');
	// 		$data['records'] = $this->Users_model->get_user_list();

	// 		$this->load->model('Hr_model');
	// 		$data['record1'] = $this->Hr_model->get_salary_structure_data();
	// 		foreach ($data['record1'] as $r) {
	// 			$data['record2'] = $this->Hr_model->get_salary_structure_details($r->sid);
	// 		}
	// 		$data['absent'] = $this->Hr_model->get_attendance_details();
	// 	}
	// 	$data['main_content'] = 'hr/emp_monthly_salary_add.php';
	// 	$this->load->view('includes/template', $data);
	// }
	public function add_monthly_salary()
	{
		$data['title'] = "Monthly Salary Report";

		$this->load->model('Hr_model');

		// ======================
		// MONTH SELECTION
		// ======================
		$effective_date = $this->input->post('effective_date');

		if (empty($effective_date)) {
			$effective_date = date('Y-m');
		}

		$data['effective_date'] = $effective_date;

		$selected_month = date('Y-m', strtotime($effective_date));
		$start_date     = date('Y-m-01', strtotime($selected_month));
		$end_date       = date('Y-m-t', strtotime($selected_month));
		$days_in_month  = date('t', strtotime($selected_month));

		// ======================
		// EMPLOYEE LIST
		// ======================
		$employees = $this->Hr_model->get_employee_list();

		$result = [];

		// ======================
		// LOOP EMPLOYEES
		// ======================
		foreach ($employees as $emp) {

			$emp_id = $emp->employee_id;

			// ======================
			// SKIP IF ALREADY GENERATED
			// ======================
			$exists = $this->Hr_model->check_salary_exist($emp_id, $start_date);

			if ($exists > 0) {
				continue;
			}

			// ======================
			// ATTENDANCE
			// ======================
			$attendance = $this->Hr_model->get_attendance_details($emp_id, $start_date, $end_date);

			$present_count = isset($attendance->present_count) ? (float)$attendance->present_count : 0;
			$half_count    = isset($attendance->half_count) ? (float)$attendance->half_count : 0;

			$present_days = ($present_count * 1) + ($half_count * 0.5);
			$leave_days   = max(0, $days_in_month - $present_days);

			// ======================
			// SALARY STRUCTURE
			// ======================
			$emp_structure = $this->Hr_model->get_salary_structure_data_new($emp_id);

			$basic_salary     = 0;
			$total_allowances = 0;
			$total_deductions = 0;

			if (!empty($emp_structure)) {

				$basic_salary = (float)$emp_structure->basic_salary;

				$details = $this->Hr_model->get_salary_structure_details($emp_structure->sid);

				foreach ($details as $row) {
					if ($row->allowance_type == 'A') {
						$total_allowances += $row->amount;
					} else {
						$total_deductions += $row->amount;
					}
				}
			}

			// ======================
			// SALARY CALCULATION (FIXED)
			// ======================
			$per_day = ($days_in_month > 0 && $basic_salary > 0)
				? ($basic_salary / $days_in_month)
				: 0;

			if ($present_days <= 0) {

				// ❌ No attendance → no salary
				$monthly_basic = 0;
				$gross = 0;
				$net   = 0;
			} else {

				$monthly_basic = $per_day * $present_days;

				$gross = $monthly_basic + $total_allowances;

				$net   = $gross - $total_deductions;
			}

			// ======================
			// RESULT
			// ======================
			$result[] = (object)[
				'employee_id'   => $emp_id,
				'employee_name' => $emp->employee_name,
				'working_days'  => $days_in_month,
				'present_days'  => $present_days,
				'leave_days'    => $leave_days,
				'basic_salary'  => $basic_salary,
				'allowances'    => $total_allowances,
				'deductions'    => $total_deductions,
				'overtime'      => 0,
				'gross_salary'  => $gross,
				'net_pay'       => $net
			];
		}

		// ======================
		// PASS TO VIEW
		// ======================
		$data['employee_salary_data'] = $result;

		$data['main_content'] = 'hr/emp_monthly_salary_add';
		$this->load->view('includes/template', $data);
	}
	/*function add_monthly_salary_data()
	   {
		   $data['title'] = "Monthly Salary";

		   $data['effective_date'] =$this->input->post('effective_date');
		   $data['user_id'] = $this->input->post('user_id');
		   
		   $effective_date = $this->input->post('effective_date');
		   $selected_month_year = date('Y-m', strtotime($effective_date));
		   $start_date = date('Y-m-01', strtotime($selected_month_year));
		   $end_date = date('Y-m-t', strtotime($selected_month_year));
		   $data['days_in_month'] = date('t', strtotime($selected_month_year));
		   

		   $this->load->model('Users_model');
		   $data['records'] = $this->Users_model->get_user_list();

		   $this->load->model('Hr_model');
		   $data['record1'] = $this->Hr_model->get_salary_structure_data();
		   foreach($data['record1'] as $r)
		   {
			   $data['record2'] = $this->Hr_model->get_salary_structure_details($r->sid);
		   }
		   $data['absent'] = $this->Hr_model->get_attendance_details();

		   $data['main_content'] = 'hr/emp_monthly_salary_add.php';
		   $this->load->view('includes/template', $data);
	   }*/


	function view_emp_monthly_salary_list()
	{
		$data['title'] = "Monthly Salary List";
		$data['from'] = date('M-Y');
		// $data['to'] = ('Y-m-t');


		if ($this->input->post('from') != '') {
			$data['from'] = $this->input->post('from');
		}

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_list($data['from']);
		$data['main_content'] = 'hr/emp_monthly_salary_list.php';
		$this->load->view('includes/template', $data);
	}






	function add_emp_monthly_salary()
	{
		$data['title'] = "Add Monthly Salary";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_emp_monthly_salary();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_monthly_salary_list');
		} else {
			$this->session->set_flashdata('warning', 'Name Already Exist');
			redirect('Hr/add_monthly_salary');
		}
	}

	function edit_emp_monthly_salary()
	{
		$data['title'] = "Edit Monthly Salary";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_by_id($id);
		$data['main_content'] = 'hr/emp_montly_salary_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_emp_monthly_salary()
	{
		$data['title'] = "Supplier Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_emp_monthly_salary($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_monthly_salary_list');
		}
	}
	function print_monthly_payslip()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_monthlypayslip_by_id($id);
		$data['record2'] = $this->Hr_model->get_monthly_salary_details($id);
		$this->load->view('hr/print/print_payslip.php', $data);
	}

	function print_monthly_record()
	{
		$data['from'] = $this->input->post('from');
		$data['to'] = ('Y-m-t');


		if ($this->input->post('from') != '') {
			$data['from'] = $this->input->post('from');
		}

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_list($data['from']);
		$this->load->view('hr/print/print_payslip_record.php', $data);
	}


	function export_monthly_record()
	{

		$data['from'] = $this->input->post('from');
		$data['to'] = ('Y-m-t');


		if ($this->input->post('from') != '') {
			$data['from'] = $this->input->post('from');
		}

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_emp_monthly_salary_list($data['from']);

		$this->load->view('hr/print/export_payslip_record.php', $data);
	}


	////////////////////////////////////////gratuaty-start/////////////////////////////////////////////
	function add_gratuity()
	{
		$data['title'] = "Gratuity Details";

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['record1'] = $this->Hr_model->get_allowances_list();

		$data['main_content'] = 'hr/add_gratuity_details.php';
		$this->load->view('includes/template', $data);
	}
	function view_gratuity_list()
	{
		$data['title'] = "Gratuity Details List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_vehicle_list();
		$data['main_content'] = 'hr/gratuity_detail_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_gratuity_details()
	{
		$data['title'] = " Add Gratuity Details";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_vehicle_details();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_gratuity_list');
		} else {
			$this->session->set_flashdata('warning', 'Gratuity Details Name Already Exist');
			redirect('Hr/add_gratuity');
		}
	}

	function edit_gratuity_details()
	{
		$data['title'] = " Edit Gratuity Details";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_vehicle_details_by_id($id);
		$data['main_content'] = 'hr/edit_gratuity_details.php';
		$this->load->view('includes/template', $data);
	}

	function update_gratuity()
	{
		$data['title'] = "Update Gratuity Details";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_vehicle_details($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_gratuity_list');
		}
	}
	function delete_gratuity_details()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_vehicle_data($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_gratuity_list');
	}



	///employee_corner
	//////////////////////////////employee corner //////////////////
	/////////////////////////////////leavev///////////////////////////
	function add_leave_corner_application()
	{
		$data['title'] = "Leave application";
		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$data['main_content'] = 'hr/leave_corner_allocation_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_leave_corner_application_list()
	{
		$data['title'] = "Leave application";
		$id = $this->uri->segment('3');
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_leave_corner_list();
		// $data['records'] = $this->Hr_model->get_employee_leave_by_id($id);
		$data['record1'] = $this->Hr_model->leave_approval_list();
		$data['main_content'] = 'hr/leave_corner_allocation_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_leave_corner_application_data()
	{
		$data['title'] = "Leave application";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_employee_leave_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_leave_corner_application_list');
		} else {
			$this->session->set_flashdata('warning', 'employee Company Name Already Exist');
			redirect('Hr/view_leave_corner_application_list');
		}
	}

	function edit_leave_corner_application()
	{
		$data['title'] = "Edit Leave application";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_leave_by_id($id);
		$data['file_records'] = $this->Hr_model->get_employee_leave_doc_id($id);
		$data['main_content'] = 'hr/leave_corner_allocation_edit.php';
		$this->load->view('includes/template', $data);
	}

	function update_leave_corner_application()
	{
		$data['title'] = "Edit Leave application";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_employee_leave($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_leave_corner_application_list');
		}
	}
	function delete_leave_corner_application()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_leave_application($id);

		$this->session->set_flashdata('success', 'Record Delete Successfully');
		redirect('Hr/view_leave_corner_application_list');
	}
	////////////////////////////////emd employee leave employee corner//////////////////////
	/// start resigignation///////////


	///////////////////////////////////////add_resignation////////////////////////////////////////////// 

	function add_regignation_corner()
	{
		$data['title'] = "Add Resignaion";

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_resignation_active_list();

		$data['main_content'] = 'hr/resignation_corner_emp_add.php';
		$this->load->view('includes/template', $data);
	}
	function view_emp_regignation_corner_list()
	{
		$data['title'] = "Resignation List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_regignation_corner_list();
		$data['main_content'] = 'hr/resignation_corner_emp_list.php';
		$this->load->view('includes/template', $data);
	}

	function add_emp_regignation_corner_data()
	{
		$data['title'] = "Add resignation";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_resignation();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_emp_regignation_corner_list');
		} else {
			$this->session->set_flashdata('warning', 'employee  Name Already Exist');
			redirect('Hr/add_regignation_corner');
		}
	}

	function edit_emp_regignation_corner()
	{
		$data['title'] = "Edit Resignation";
		$id = $this->uri->segment('3');

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();

		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_employee_resigning_by_id($id);
		$data['file_records'] = $this->Hr_model->get_employee_document_doc_id($id);

		$data['main_content'] = 'hr/resignation_corner_emp_edit.php';
		$this->load->view('includes/template', $data);
	}
	function update_emp_regignation_corner()
	{
		$data['title'] = "Update Resignation";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_resigning_application($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_emp_regignation_corner_list');
		}
	}
	/////////////////////////////// start approval setp///////////////////////////////////
	function approval_setup()
	{
		$data['title'] = "Approval Setup";

		$this->load->model('Users_model');
		$data['user_records'] = $this->Users_model->get_user_list();
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_approval_setup_list();

		$data['main_content'] = 'hr/approval_setup.php';
		$this->load->view('includes/template', $data);
	}
	function add_approve_data()
	{
		$data['title'] = "Approval Setup";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_approve_data();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/approval_setup');
		} else {
			$this->session->set_flashdata('warning', ' data Already Exist');
			redirect('Hr/approval_setup');
		}
	}

	///////////////////////////////////////start Advance Salary//////////////////////////////////////////

	function add_advance_salary()
	{
		$data['title'] = "Advance Salary";

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_user_list();

		$data['main_content'] = 'hr/add_advance_salary.php';
		$this->load->view('includes/template', $data);
	}
	function view_advance_salary_list()
	{
		$data['title'] = "Advance Salary List";
		$this->load->model('Hr_model');
		$data['records'] = $this->Hr_model->get_advance_salary_list();
		$data['main_content'] = 'hr/list_advance_salary.php';
		$this->load->view('includes/template', $data);
	}

	function add_advance_salary_details()
	{
		$data['title'] = " Add Advance Salary";
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->add_advance_salary();
		if ($flag) {
			$this->session->set_flashdata('success', 'Record Successfully Saved');
			redirect('Hr/view_advance_salary_list');
		} else {
			$this->session->set_flashdata('warning', 'Record Already Exist');
			redirect('Hr/add_advance_salary');
		}
	}

	function edit_advance_salary()
	{
		$data['title'] = " Edit Advance Salary ";
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->get_user_list();
		$data['records'] = $this->Hr_model->get_advance_salary_list_by_id($id);
		$data['main_content'] = 'hr/edit_advance_salary.php';
		$this->load->view('includes/template', $data);
	}

	function update_advance_salary()
	{
		$data['title'] = "Update Advance Salary";
		$id = $this->input->post('id');
		$this->load->model('Hr_model');
		$res = $this->Hr_model->update_advance_salary($id);
		if ($res) {
			$this->session->set_flashdata('success', 'Record Successfully Updated');
			redirect('Hr/view_advance_salary_list');
		}
	}
	function delete_advance_salary()
	{
		$id = $this->uri->segment('3');

		$this->load->model('Hr_model');
		$data['user_records'] = $this->Hr_model->delete_advance_salary($id);
		$this->session->set_flashdata('success', 'Delete Record Successfully');
		redirect('Hr/view_advance_salary_list');
	}


	public function delete_resignation_document()
	{
		$doc_id = $this->input->post('doc_id');

		$file = $this->db->get_where('employee_resignation_documents', [
			'doc_id' => $doc_id
		])->row();

		if ($file) {

			$path = FCPATH . 'public/uploaded_documents/' . $file->document_path;

			if (file_exists($path)) {
				unlink($path);
			}

			$this->db->where('doc_id', $doc_id);
			$this->db->delete('employee_resignation_documents');
		}

		echo 1;
	}

	public function add_monthly_salary_data()
	{
		$this->load->model('Hr_model');

		// =======================
		// POST DATA DEBUG
		// =======================
		$employee_ids   = $this->input->post('employee_ids');
		$effective_date = $this->input->post('effective_date');

		log_message('debug', 'EMPLOYEE IDS: ' . print_r($employee_ids, true));
		log_message('debug', 'EFFECTIVE DATE: ' . $effective_date);

		if (empty($employee_ids)) {
			$this->session->set_flashdata('error', 'No employees selected');
			redirect('Hr/add_monthly_salary');
		}

		// =======================
		// MONTH FIX + DEBUG
		// =======================
		if (empty($effective_date)) {
			$effective_date = date('Y-m');
		}

		$month = date('Y-m', strtotime($effective_date . '-01'));
		$start_date = $month . '-01';
		$end_date   = date('Y-m-t', strtotime($start_date));
		$days_in_month = date('t', strtotime($start_date));

		log_message('debug', "MONTH: $month | START: $start_date | END: $end_date | DAYS: $days_in_month");

		foreach ($employee_ids as $emp_id) {
			log_message('debug', "PROCESSING EMPLOYEE: $emp_id");

			// =======================
			// EMPLOYEE DATA
			// =======================
			$emp = $this->Hr_model->get_employee_by_id($emp_id);

			if (!$emp) {
				log_message('error', "Employee not found: $emp_id");
				continue;
			}

			// =======================
			// ATTENDANCE DEBUG
			// =======================
			$attendance = $this->Hr_model->get_attendance_details($emp_id, $start_date, $end_date);

			log_message('debug', 'ATTENDANCE RAW: ' . print_r($attendance, true));

			$present = isset($attendance->present_count) ? (float)$attendance->present_count : 0;
			$half    = isset($attendance->half_count) ? (float)$attendance->half_count : 0;

			$present_days = ($present * 1) + ($half * 0.5);
			$leave_days   = max(0, $days_in_month - $present_days);

			log_message('debug', "PRESENT: $present | HALF: $half | TOTAL: $present_days");

			// =======================
			// SALARY STRUCTURE DEBUG
			// =======================
			$structure = $this->Hr_model->get_salary_structure_by_employee($emp_id);

			log_message('debug', 'STRUCTURE: ' . print_r($structure, true));

			$basic_salary = 0;
			$sid = 0;

			if (!empty($structure)) {
				$basic_salary = (float)$structure->basic_salary;
				$sid = $structure->sid;
			}

			log_message('debug', "BASIC SALARY: $basic_salary | SID: $sid");

			// =======================
			// STRUCTURE DETAILS
			// =======================
			$details = $this->Hr_model->get_salary_structure_details($sid);

			log_message('debug', 'STRUCTURE DETAILS: ' . print_r($details, true));

			$total_allowance = 0;
			$total_deduction = 0;

			foreach ($details as $row) {
				if ($row->allowance_type == 'A') {
					$total_allowance += $row->amount;
				} else {
					$total_deduction += $row->amount;
				}
			}

			log_message('debug', "ALLOWANCE: $total_allowance | DEDUCTION: $total_deduction");

			// =======================
			// SALARY CALCULATION
			// =======================
			$per_day = ($days_in_month > 0) ? ($basic_salary / $days_in_month) : 0;
			$monthly_basic = $per_day * $present_days;

			$gross = $monthly_basic + $total_allowance;
			$net   = $gross - $total_deduction;

			log_message('debug', "PER DAY: $per_day | MONTH BASIC: $monthly_basic | GROSS: $gross | NET: $net");

			// =======================
			// INSERT DATA
			// =======================
			$data = [
				'emp_id'          => $emp_id,
				'salary_month'    => $start_date,
				'working_days'    => $days_in_month,
				'present_days'    => $present_days,
				'leave_days'      => $leave_days,
				'basic_salary'    => $basic_salary,
				'total_allowance' => $total_allowance,
				'total_deduction' => $total_deduction,
				'overtime'        => 0,
				'gross_salary'    => $gross,
				'net_salary'      => $net,
				'created_data'    => date('Y-m-d H:i:s')
			];

			log_message('debug', 'FINAL INSERT: ' . print_r($data, true));

			$this->db->insert('employee_monthly_salary', $data);
		}

		$this->session->set_flashdata('success', 'Salary generated successfully');
		redirect('Hr/view_emp_monthly_salary_list');
	}
	///////////////////////////////////////////End advance salary//////////////////////////////////////////


	///////////////////////////////////////////COMMISSION SETUP START//////////////////////////////////////////

	////// Commission Transaction Start /////////
	public function view_commission_transaction_list()
	{
		$user = $this->session->userdata('user_id');

		if (!has_view_access($user, 'Hr/view_commission_transaction_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}

		$this->load->model('Hr_model');
		$data['title'] = "Commission Transactions";
		$data['records'] = $this->Hr_model->get_commission_transactions();
		$data['main_content'] = "hr/commission/commission_transaction_list.php";
		$this->load->view('includes/template', $data);
	}

	function add_commission_transaction()
	{
		$user = $this->session->userdata('user_id');

		if (!has_access($user, 'Hr/view_commission_transaction_list', 'A')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}

		$this->load->model('Hr_model');
		$data['sales_rep'] = $this->Hr_model->get_sales_rep_list();
		$data['invoice_list'] = $this->Hr_model->get_invoice_list();
		$data['title'] = "Commission Transaction";
		$data['main_content'] = "hr/commission/commission_transaction_add.php";
		$this->load->view('includes/template', $data);
	}

	function save_commission_transaction()
	{
		$this->load->model('Hr_model');
		$flag = $this->Hr_model->save_commission_transaction();
		if ($flag) {
			$this->session->set_flashdata(
				'success',
				'Commission Saved Successfully'
			);
		} else {
			$this->session->set_flashdata(
				'warning',
				'Commission already created for this Invoice.'
			);
		}
		redirect('Hr/view_commission_transaction_list');
	}

	function edit_commission_transaction()
	{
		$id = $this->uri->segment(3);
		$this->load->model('Hr_model');
		$record = $this->Hr_model->get_commission_transaction($id);

		if (empty($record)) {
			$this->session->set_flashdata(
				'error',
				'Commission Transaction not found.'
			);
			redirect('Hr/view_commission_transaction_list');
			return;
		}

		if (in_array($record->status, array('Approved', 'Paid', 'Rejected'))) {
			$this->session->set_flashdata(
				'error',
				'This Commission Transaction is locked and cannot be edited.'
			);
			redirect('Hr/view_commission_transaction_list');
			return;
		}

		$data['record'] = $record;
		$data['sales_rep'] = $this->Hr_model->get_sales_rep_list();
		$data['invoice_list'] = $this->Hr_model->get_invoice_list();
		$data['title'] = "Edit Commission";
		$data['main_content'] = "hr/commission/commission_transaction_edit.php";

		$this->load->view('includes/template', $data);
	}

	function update_commission_transaction()
	{
		$id = $this->input->post('transaction_id');
		$this->load->model('Hr_model');
		$record = $this->Hr_model->get_commission_transaction($id);

		if (empty($record)) {
			$this->session->set_flashdata(
				'error',
				'Commission Transaction not found.'
			);
			redirect('Hr/view_commission_transaction_list');
			return;
		}

		if (in_array($record->status, array('Approved', 'Paid', 'Rejected'))) {
			$this->session->set_flashdata(
				'error',
				'This Commission Transaction is locked and cannot be updated.'
			);
			redirect('Hr/view_commission_transaction_list');
			return;
		}

		$result = $this->Hr_model->update_commission_transaction($id);
		if ($result) {
			$this->session->set_flashdata(
				'success',
				'Commission Transaction Updated Successfully.'
			);
		} else {
			$this->session->set_flashdata(
				'warning',
				'Commission already exists for the selected Invoice.'
			);
		}

		redirect('Hr/view_commission_transaction_list');
	}

	function delete_commission_transaction()
	{
		$id = $this->uri->segment(3);
		$this->load->model('Hr_model');
		$this->Hr_model->delete_commission_transaction($id);
		$this->session->set_flashdata('success', 'Deleted Successfully');
		redirect('Hr/view_commission_transaction_list');
	}

	////// Commission Transaction Ends /////////

	////// Commission Approval Starts /////////

	public function view_commission_approval_list()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Hr/view_commission_approval_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$this->load->model('Hr_model');
		$data['title'] = "Commission Approval";
		$data['records'] = $this->Hr_model->get_pending_commissions();
		$data['main_content'] = "hr/commission/commission_approval_list.php";
		$this->load->view('includes/template', $data);
	}

	public function reject_commission_transaction()
	{
		$id = $this->uri->segment(3);
		$this->load->model('Hr_model');
		$this->Hr_model->reject_commission_transaction($id);
		$this->session->set_flashdata(
			'success',
			'Commission Rejected Successfully'
		);
		redirect('Hr/view_commission_approval_list');
	}

	public function approve_commission_transaction()
	{
		$id = $this->uri->segment(3);
		$this->load->model('Hr_model');
		$this->Hr_model->approve_commission_transaction($id);
		$this->session->set_flashdata(
			'success',
			'Commission Approved Successfully'
		);

		redirect('Hr/view_commission_approval_list');
	}

	////// Commission Approval Ends /////////

	////// Commission Payments Starts /////////

	public function view_commission_payment_list()
	{
		$user = $this->session->userdata('user_id');
		if (!has_view_access($user, 'Hr/view_commission_payment_list')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}
		$this->load->model('Hr_model');
		$data['title'] = "Commission Payment";
		$data['records'] = $this->Hr_model->get_approved_commissions();
		$data['main_content'] = "hr/commission/commission_payment_list.php";
		$this->load->view('includes/template', $data);
	}

	public function commission_payment()
	{
		$user = $this->session->userdata('user_id');
		if (!has_access($user, 'Hr/view_commission_payment_list', 'E')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}

		$id = $this->uri->segment(3);
		$this->load->model('Hr_model');
		$data['record'] = $this->Hr_model->get_commission_payment($id);
		$data['title'] = "Commission Payment";
		$data['main_content'] = "hr/commission/commission_payment.php";
		$this->load->view('includes/template', $data);
	}

	public function save_commission_payment()
	{
		$this->load->model('Hr_model');
		$this->Hr_model->save_commission_payment();
		$this->session->set_flashdata(
			'success',
			'Commission Paid Successfully'
		);

		redirect('Hr/view_commission_payment_list');
	}

	////// Commission Payments Ends /////////

	////// Commission Reports Starts /////////

	public function view_commission_report()
	{
		$user = $this->session->userdata('user_id');

		if (!has_view_access($user, 'Hr/view_commission_report')) {
			$data['title'] = 'Access Denied';
			$data['main_content'] = 'errors/access_control.php';
			$this->load->view('includes/template', $data);
			return;
		}

		$this->load->model('Hr_model');

		$data['sales_rep'] = $this->Hr_model->get_sales_rep_list();

		$filter = array(
			'from_date'   => $this->input->post('from_date'),
			'to_date'     => $this->input->post('to_date'),
			'sales_rep_id' => $this->input->post('sales_rep_id'),
			'status'      => $this->input->post('status')
		);

		$data['records'] = $this->Hr_model->commission_report($filter);

		$data['title'] = "Commission Report";
		$data['main_content'] = "hr/commission/commission_report.php";

		$this->load->view('includes/template', $data);
	}

	public function print_commission_report()
	{
		$this->load->model('Hr_model');

		$filter = array(
			'from_date' => $this->input->get('from_date'),
			'to_date' => $this->input->get('to_date'),
			'sales_rep_id' => $this->input->get('sales_rep_id'),
			'status' => $this->input->get('status')
		);

		$data['records'] = $this->Hr_model->commission_report($filter);

		$this->load->view(
			'hr/print/print_commission_report',
			$data
		);
	}

	public function export_commission_report()
	{
		$this->load->model('Hr_model');

		$filter = array(
			'from_date'    => $this->input->get('from_date'),
			'to_date'      => $this->input->get('to_date'),
			'sales_rep_id' => $this->input->get('sales_rep_id'),
			'status'       => $this->input->get('status')
		);

		$data['records'] = $this->Hr_model->commission_report($filter);
		$this->load->view('excel_reports/export_commission_report', $data);
	}

	////// Commission Reports Starts /////////

	///////////////////////////////////////////COMMISSION SETUP ENDS//////////////////////////////////////////


}
