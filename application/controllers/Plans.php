<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Plans is child of CI_Controller
 * @author Malik Ardhiansyah
 * @description This controller acts as a link between models and views
 * @return functions Used by view
 */
class Plans extends CI_Controller
{
	/**
	 * @todo initialize all function needed
	 * @access public
	 * @description This function used to load library 
	 * 'form_validation', load model 'Auth_model' as 'amodel' and 'Plans_model' as 'pmodel'
	 * @see https://codeigniter.com/userguide3/general/creating_libraries.html?highlight=construct
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('unit_test');
		$this->load->model('auth_model', 'amodel');
		$this->load->model('plans_model', 'pmodel');
	}

	/**
	 * Running the unit test process
	 * @access private
	 * @param array $test
	 * @param array $expected
	 * @param string $test_name
	 * @return void
	 */
	private function _unit_test($test, $expected, $test_name)
	{
		# $test_run variable to store result unit test
		$test_run = $this->unit->run($test, $expected, $test_name);
		# Show result
		echo $test_run;
		die;
	}

	/**
	 * Navigate to dashboard page
	 * @access public
	 * @description Show dashboard page if successfully logged in and 
	 * will be directed to login page if they don't have a session
	 * @return view main dashboard
	 */
	public function dashboard()
	{
		# $pmodel variable to shorten model call 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);

		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];

		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Dashboard',
			'user' => $user,
			'months' => $pmodel->get_months(),
			'labels' => $pmodel->get_labels(),
			'plans' => $pmodel->get_plans_by_id($user['id_user']),
		];

		# IF condition to check if there is a stored 'email' session
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}

		// var_dump($user);
		// die;

		# Load view main on folder sections and pass $data variable
		$this->load->view('sections/main', $data);
	}

	/**
	 * Add a new plan
	 * @todo Processing of add a plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function proc_add_plan()
	{
		# $input variable to shorten input method
		$input = $this->input;
		# $pmodel variable to shorten model call 'pmodel'
		$pmodel = $this->pmodel;
		# $status variable to load private function _status_check()
		$status = $this->_status_check();

		# $validation variable to shorten form_validation library
		$validation = $this->form_validation;
		# Initialize adding plan rules with add_rules()
		$validation->set_rules($pmodel->add_rules());

		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_user' => $input->post('id_user'),
			'plan' => $input->post('plan'),
			'description' => $input->post('description'),
			'expired' => $input->post('expired') . " 23:59:59",
			'status' => $status,
			'id_label' => $input->post('label'),
			'id_month' => $input->post('month')
		];

		# $expected_result variable to store array of unit test scenario
		$expected_result = [
			'id_user' => "1",
			'plan' => "Mempelajari dan Memahami Python",
			'description' => "Belajar dari dasar bahasa Python melalui berbagai sumber gratis",
			'expired' => "2022-03-12 23:59:59",
			'status' => 0,
			'id_label' => "1",
			'id_month' => "3"
		];

		# run unit_test with function _unit_test
		// $this->_unit_test($data, $expected_result, "Form add plan test");

		// var_dump($data);
		// die;

		# Passing $data as a parameter of create_plan() function to execute adding data to database
		$pmodel->create_plan($data);
		# Add an alert message to session if create_plan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Success to create a new plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('dashboard');
	}

	/**
	 * Process of status check
	 * @todo Change status input from string to bool
	 * @access private
	 * @return bool 0 if NULL and return 1 if NOT NULL
	 */
	private function _status_check()
	{
		# $check variable to store input from status field
		$check = $this->input->post('status');

		# IF condition to check value of $check
		if ($check == NULL) {
			# If TRUE, convert $status value to 0
			$status = 0;
		} else {
			# If FALSE, convert $status value to 1
			$status = 1;
		}

		# Return $status value
		return $status;
	}

	/**
	 * Update a plan
	 * @todo Processing of update a plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function proc_edit_plan()
	{
		# $input variable to shorten input method
		$input = $this->input;
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan' => $input->post('id_plan'),
			'plan' => $input->post('plan'),
			'description' => $input->post('description'),
			'id_label' => $input->post('label')
		];

		# $expected_result variable to store array of unit test scenario
		$expected_result = [
			'id_plan' => 31,
			'plan' => "Lulus Sertifikasi Analis Program",
			'description' => "Menyelesaikan Sertifikasi Analis Program dengan baik tanpa kendala",
			'id_label' => 3,
		];

		# run unit_test with function _unit_test
		// $this->_unit_test($data, $expected_result, "Form edit plan test");

		// var_dump($data);
		// die;

		# Passing $data as a parameter of update_plan() function to execute update data on database
		$this->pmodel->update_plan($data);
		# Add an alert message to session if update_plan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Success to edit plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('dashboard');
	}

	/**
	 * Mark a success plan
	 * @todo Processing a successful plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function proc_mark_success()
	{
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan' => $this->input->post('id_plan')
		];

		# $expected_result variable to store array of unit test scenario
		$expected_result = [
			'id_plan' => "39"
		];

		# run unit_test with function _unit_test
		// $this->_unit_test($data, $expected_result, "Form mark succcess plan test");

		// var_dump($data);
		// die;

		# Passing $data as a parameter of mark_success_plan() function to execute update data on database
		$this->pmodel->mark_success_plan($data);
		# Add an alert message to session if mark_success_plan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Done, marking a successful plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('dashboard');
	}

	/**
	 * Mark a fail plan
	 * @todo Processing a failed plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function proc_mark_fail()
	{
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan' => $this->input->post('id_plan')
		];

		// var_dump($data);
		// die;

		# Passing $data as a parameter of mark_fail_plan() function to execute update data on database
		$this->pmodel->mark_fail_plan($data);
		# Add an alert message to session if mark_fail_plan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Done, marks plan failed..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('dashboard');
	}

	/**
	 * Move a plan to other month
	 * @todo Processing move a plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function proc_move_plan()
	{
		# $input variable to shorten input method
		$input = $this->input;
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan' => $input->post('id_plan'),
			'id_month' => $input->post('month'),
			'expired' => $input->post('expired') . " 23:59:59"
		];

		// var_dump($data);
		// die;

		# Passing $data as a parameter of move_plan() function to execute update data on database
		$this->pmodel->move_plan($data);
		# Add an alert message to session if move_plan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Move plan successfully..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('dashboard');
	}

	/**
	 * Delete a plan
	 * @todo Processing delete a plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function proc_delete_plan()
	{
		# $input variable to shorten input method
		$input = $this->input;
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan' => $input->post('id_plan')
		];

		// var_dump($data);
		// die;

		# Passing $data as a parameter of del_plan() function to execute update data on database
		$this->pmodel->del_plan($data);
		# Add an alert message to session if del_plan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Delete plan successfully..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('dashboard');
	}

	/**
	 * Navigate a successfull plan page
	 * @todo Fetch and present a successful plan
	 * @access public
	 * @description Show success plan page if successfully logged in and
	 * will be directed to login page if they don't have a session
	 * @return view main successp
	 */
	public function get_success_plans()
	{
		#  $pmodel variable to load model 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Success Plan',
			'user' => $user,
			'months' => $pmodel->get_months(),
			'labels' => $pmodel->get_labels(),
			'splans' => $pmodel->success_plans_by_id($user['id_user'])
		];

		# IF condition to check if no 'email' session is stored
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}

		// var_dump($user);
		// die;

		# Add an alert message to session if success plan page has been loaded
		$this->session->set_flashdata(
			'success_message',
			'<div class="alert alert-info alert-dismissible fade show" role="alert">
				<h4 class="alert-heading">You`re Amazing!</h4>
				<p>Don`t be <span class="fw-bold">complacent</span> with your success, keep <span class="fw-bold">going</span> and <span class="fw-bold">focus</span> on your goals this year.</p>
				<hr>
				<figure class="text-end">
					<blockquote class="blockquote">Hope you can finish this year with happiness</blockquote>
					<figcaption class="blockquote-footer">
						Developer on <cite title="Source Title">Earth</cite>
				</figure>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);

		# Load view main on folder sections and pass $data variable
		$this->load->view('sections/main', $data);
	}

	/**
	 * Navigate a failed plan page
	 * @todo Fetch and present a failed plan
	 * @access public
	 * @description Show a fail plan page if successfully logged in and
	 * will be directed to login page if they don't have a session
	 * @return view main and returns login page if isn't have 'email' session
	 */
	public function get_fail_plans()
	{
		#  $pmodel variable to load model 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Fail Plan',
			'user' => $user,
			'months' => $pmodel->get_months(),
			'labels' => $pmodel->get_labels(),
			'fplans' => $pmodel->fail_plans_by_id($user['id_user'])
		];

		# IF condition to check if there is a stored 'email' session
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}

		// var_dump($user);
		// die;

		# Add an alert message to session if fail plan page has been loaded
		$this->session->set_flashdata(
			'fail_message',
			'<div class="alert alert-info alert-dismissible fade show" role="alert">
				<h4 class="alert-heading">Finish it!</h4>
				<p>You have other plans to complete, stay <span class="fw-bold">motivated</span> and <span class="fw-bold">focused</span> on your goals!</p>
				<hr>
				<figure class="text-end">
					<blockquote class="blockquote">Failure is beginning of success</blockquote>
					<figcaption class="blockquote-footer">
						Writer on <cite title="Source Title">Earth</cite>
				</figure>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);

		# Load view main on folder sections and pass $data variable
		$this->load->view('sections/main', $data);
	}

	/**
	 * Navigate a user logs page
	 * @todo Fetch and present a user logs
	 * @access public
	 * @description Show user logs page if successfully logged in and
	 * will be directed to login page if they don't have a session
	 * @return view main and returns login page if isn't have 'email' session
	 */
	public function user_activity_logs()
	{
		# Load pagination library
		$this->load->library('pagination');
		#  $pmodel variable to load model 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Logs',
			'user' => $user,
			'logs' => $pmodel->get_num_logs($user['id_user'])
		];

		# $config variable to store pagination library settings
		$config = [
			# common_config
			'base_url' => 'http://localhost/mytyplan/plans/user_activity_logs',
			'total_rows' => $data['logs'],
			'per_page' => 15,
			'uri_segment' => 3,

			# page_button_styling
			'full_tag_open' => '<nav aria-label="Page navigation example"><ul class="pagination">',
			'full_tag_close' => '</ul></nav>',
			'first_link' => 'First',
			'first_tag_open' => '<li class="page-item">',
			'first_tag_close' => '</li>',
			'last_link' => 'Last',
			'last_tag_open' => '<li class="page-item">',
			'last_tag_close' => '</li>',
			'next_link' => '&raquo',
			'next_tag_open' => '<li class="page-item">',
			'next_tag_close' => '</li>',
			'prev_link' => '&laquo',
			'prev_tag_open' => '<li class="page-item">',
			'prev_tag_close' => '</li>',
			'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
			'cur_tag_close' => '</a></li>',
			'num_tag_open' => '<li class="page-item">',
			'num_tag_close' => '</li>',
			'attributes' => array('class' => 'page-link')
		];

		# initialize pagination library
		$this->pagination->initialize($config);

		# $data['start'] variable to store values of URI segment 3
		$data['start'] = $this->uri->segment(3);
		# $data['logs'] variable to store arrays of limit logs
		$data['logs'] = $pmodel->get_logs_limit($user['id_user'], $config['per_page'], $data['start']);

		# IF condition to check if there is a stored 'email' session
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}

		// var_dump($user);
		// die;

		# Load view main on folder sections and pass $data variable
		$this->load->view('sections/main', $data);
	}

	/**
	 * Navigate to Admin dashboard page
	 * @access public
	 * @description Show admin dashboard page if successfully logged in and 
	 * will be directed to login page if they don't have a session
	 * @return void
	 */
	public function admin_dashboard()
	{
		# $pmodel variable to shorten model call 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);

		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];

		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Admin Dashboard',
			'user' => $user,
			'months' => $pmodel->get_months(),
			'labels' => $pmodel->get_labels(),
			'users' => $this->amodel->get_all_users(),
			'plans' => $pmodel->get_all_plans(),
			'new_users' => [],
			'new_plans' => [],
			'users_per_month' => [],
			'plans_per_month' => [],
			'success_plans' => $pmodel->all_success_plans(),
			'get_fail' => $pmodel->all_fail_plans(),
			'fail_plans' => [],
			'unfulfilled_plans' => []
		];

		# Looping to insert array data to $data['new_users']
		for ($i = 0; $i < count($data['users']); $i++) {
			# $now variable to store current time on format date('Y-m-d)
			$now = date('Y-m-d', time());
			# $exp variable to store joined on format date('Y-m-d)
			$join = date('Y-m-d', strtotime($data['users'][$i]['joined']));

			if ($join == $now) {
				# push array to $data['new_users'] when user join is equal now
				array_push($data['new_users'], $data['get_fail'][$i]);
			}
		}

		# Looping to insert array data to $data['users_per_month'] and $data['plans_per_month']
		for ($i = 0; $i < count($data['months']); $i++) {
			/**
			 * Logic for insert array count to $data['users_per_month']
			 */
			# $users variable to store result array of users per month
			$users = $this->db->like('joined', '-' . $data['months'][$i]['month'] . '-')->get('users')->result_array();
			# $count_user variable to store number of users
			$count = count($users);
			# push array to $data['users_per_month']
			array_push($data['users_per_month'], $count);
			
			/**
			 * Logic for insert array count to $data['plans_per_month']
			 */
			# $plans variable to store result array of plans per month
			$plans = $this->db->get_where('all_plans', ['month' => $data['months'][$i]['month']])->result_array();
			# $count_user variable to store number of plans
			$count = count($plans);
			# push array to $data['plans_per_month']
			array_push($data['plans_per_month'], $count);
		}

		# Looping to insert array data to $data['new_plans']
		for ($i = 0; $i < count($data['plans']); $i++) {
			# $now variable to store current time on format date('Y-m-d)
			$now = date('Y-m-d', time());
			# $created variable to store created on format date('Y-m-d)
			$created = date('Y-m-d', strtotime($data['plans'][$i]['created']));

			if ($created == $now) {
				# push array to $data['new_plans'] when user join is equal now
				array_push($data['new_plans'], $data['get_fail'][$i]);
			}
		}

		# Looping to insert array data to $data['fail_plans'] or $data['unfulfilled_plans']
		for ($i = 0; $i < count($data['get_fail']); $i++) {
			# $now variable to store current time
			$now = time();
			# $exp variable to store time value of expired
			$exp = strtotime($data['get_fail'][$i]['expired']);

			if ($now < $exp) {
				# push array to $data['unfulfilled_plans'] when now less than expired
				array_push($data['unfulfilled_plans'], $data['get_fail'][$i]);
			} else {
				# push array to $data['fail_plans']
				array_push($data['fail_plans'], $data['get_fail'][$i]);
			}
		}

		// var_dump($data['plans_per_month']);
		// die;

		# IF condition to check if there is a stored 'email' session
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}

		# Load view main on folder sections and pass $data variable
		$this->load->view('admin/main', $data);
	}

	/**
	 * Navigate an user list page
	 * @access public
	 * @description Show user list page
	 * @return void
	 */
	public function get_user_list()
	{
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'User List',
			'user' => $user,
			'users' => $this->amodel->get_all_users()
		];

		// var_dump($data);
		// die;

		# IF condition to check if no 'email' session is stored
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}
		# Load view main on folder sections and pass $data variable
		$this->load->view('admin/main', $data);
	}

	/**
	 * Navigate an user logs page
	 * @access public
	 * @description Show user logs page
	 * @return void
	 */
	public function get_user_logs()
	{
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'User Logs Activity',
			'user' => $user,
			'logs' => $this->amodel->get_user_Logs()
		];

		// var_dump($data);
		// die;

		# IF condition to check if no 'email' session is stored
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}
		# Load view main on folder sections and pass $data variable
		$this->load->view('admin/main', $data);
	}

	/**
	 * Navigate a plans list page
	 * @access public
	 * @description Show plans list page
	 * @return void
	 */
	public function get_all_plans()
	{
		# $session variable to save field email & username from user
		$sessions = [
			'email' => $this->session->userdata('email'),
			'username' => $this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# Ternary operation to set avatar image for user
		($user['avatar'] == null) ? $user['avatar'] = 'avatar.png' : $user['avatar'];
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project' => 'My This Year Plan',
			'title' => 'Plans List',
			'user' => $user,
			'plans' => $this->pmodel->get_all_plans()
		];

		// var_dump($data);
		// die;

		# IF condition to check if no 'email' session is stored
		if (!$this->session->userdata('email')) {
			# If TRUE, add an alert message to session
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			# It will be returned to login page
			redirect('login');
		}
		# Load view main on folder sections and pass $data variable
		$this->load->view('admin/main', $data);
	}
}
