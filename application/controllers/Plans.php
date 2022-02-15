<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Dashboard',
			'user'=>$user,
			'months'=>$pmodel->get_months(),
			'labels'=>$pmodel->get_labels(),
			'plans'=>$pmodel->get_plans_by_id($user['id_user']),
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
			'id_user'=>$input->post('id_user'),
			'plan'=>$input->post('plan'),
			'description'=>$input->post('description'),
			'expired'=>$input->post('expired') . " 23:59:59",
			'status'=>$status,
			'id_label'=>$input->post('label'),
			'id_month'=>$input->post('month')
		];

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
			'id_plan'=>$input->post('id_plan'),
			'plan'=>$input->post('plan'),
			'description'=>$input->post('description'),
			'id_label'=>$input->post('label')
		];
		
		# $expected_result variable to store array of unit test scenario
		$expected_result = [
			'id_plan'=>31,
			'plan'=>"Lulus Sertifikasi Analis Program",
			'description'=>"Menyelesaikan Sertifikasi Analis Program dengan baik tanpa kendala",
			'id_label'=>3,
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
			'id_plan'=>$this->input->post('id_plan')
		];

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
			'id_plan'=>$this->input->post('id_plan')
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
			'id_plan'=>$input->post('id_plan'),
			'id_month'=>$input->post('month'),
			'expired'=>$input->post('expired') . " 23:59:59"
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
			'id_plan'=>$input->post('id_plan')
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
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Success Plan',
			'user'=>$user,
			'months'=>$pmodel->get_months(),
			'labels'=>$pmodel->get_labels(),
			'splans'=>$pmodel->success_plans_by_id($user['id_user'])
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
			'message',
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
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Fail Plan',
			'user'=>$user,
			'months'=>$pmodel->get_months(),
			'labels'=>$pmodel->get_labels(),
			'fplans'=>$pmodel->fail_plans_by_id($user['id_user'])
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
			'message',
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
		#  $pmodel variable to load model 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->get_user_by_email($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Logs',
			'user'=>$user,
			'logs'=>$pmodel->get_logs_by_id($user['id_user'])
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
}