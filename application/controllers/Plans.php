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
		$this->load->model('auth_model', 'amodel');
		$this->load->model('plans_model', 'pmodel');
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
		$user = $this->amodel->getUser($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Dashboard',
			'user'=>$user,
			'months'=>$pmodel->getMonths(),
			'labels'=>$pmodel->getLabels(),
			'plans'=>$pmodel->getPlans($user['id_user']),
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
			redirect('auth/login');
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
	public function add()
	{
		# $input variable to shorten input method
		$input = $this->input;
		# $pmodel variable to shorten model call 'pmodel'
		$pmodel = $this->pmodel;
		# $status variable to load private function _statusCheck()
		$status = $this->_statusCheck();
		
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

		# Passing $data as a parameter of createPlan() function to execute adding data to database
		$pmodel->createPlan($data);
		# Add an alert message to session if createPlan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Success to create a new plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('plans/dashboard');
	}

	/**
	 * Process of status check
	 * @todo Change status input from string to bool
	 * @access private
	 * @return bool 0 if NULL and return 1 if NOT NULL
	 */
	private function _statusCheck()
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
	public function edit()
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
		
		// var_dump($data);
		// die;

		# Passing $data as a parameter of updatePlan() function to execute update data on database
		$this->pmodel->updatePlan($data);
		# Add an alert message to session if updatePlan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Success to edit plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('plans/dashboard');
	}

	/**
	 * Mark a success plan
	 * @todo Processing a successful plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function successPlan()
	{
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan'=>$this->input->post('id_plan')
		];

		// var_dump($data);
		// die;

		# Passing $data as a parameter of successMark() function to execute update data on database
		$this->pmodel->successMark($data);
		# Add an alert message to session if successMark() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Done, marking a successful plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('plans/dashboard');
	}
	
	/**
	 * Mark a fail plan
	 * @todo Processing a failed plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function failPlan()
	{
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan'=>$this->input->post('id_plan')
		];
		
		// var_dump($data);
		// die;

		# Passing $data as a parameter of failMark() function to execute update data on database
		$this->pmodel->failMark($data);
		# Add an alert message to session if failMark() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Done, marks plan failed..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('plans/dashboard');
	}
	
	/**
	 * Move a plan to other month
	 * @todo Processing move a plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function move()
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
		
		# Passing $data as a parameter of movePlan() function to execute update data on database
		$this->pmodel->movePlan($data);
		# Add an alert message to session if movePlan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Move plan successfully..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('plans/dashboard');
	}
	
	/**
	 * Delete a plan
	 * @todo Processing delete a plan
	 * @access public
	 * @return message success on view dashboard
	 */
	public function delete()
	{
		# $input variable to shorten input method
		$input = $this->input;
		# $data variable to store array of data passed to 'Plans_model'
		$data = [
			'id_plan'=>$input->post('id_plan')
		];

		// var_dump($data);
		// die;

		# Passing $data as a parameter of delPlan() function to execute update data on database
		$this->pmodel->delPlan($data);
		# Add an alert message to session if delPlan() process is successful
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Delete plan successfully..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		# It will be returned to dashboard page
		redirect('plans/dashboard');
	}

	/**
	 * Navigate a successfull plan page
	 * @todo Fetch and present a successful plan
	 * @access public
	 * @description Show success plan page if successfully logged in and
	 * will be directed to login page if they don't have a session
	 * @return view main successp
	 */
	public function getSuccess()
	{
		#  $pmodel variable to load model 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->getUser($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Success Plan',
			'user'=>$user,
			'months'=>$pmodel->getMonths(),
			'labels'=>$pmodel->getLabels(),
			'splans'=>$pmodel->getSplans($user['id_user'])
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
			redirect('auth/login');
		}

		// var_dump($user);
		// die;

		# Add an alert message to session if success plan page has been loaded
		$this->session->set_flashdata(
			'sMessage',
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
	public function getFail()
	{
		#  $pmodel variable to load model 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->getUser($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Fail Plan',
			'user'=>$user,
			'months'=>$pmodel->getMonths(),
			'labels'=>$pmodel->getLabels(),
			'fplans'=>$pmodel->getFplans($user['id_user'])
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
			redirect('auth/login');
		}

		// var_dump($user);
		// die;

		# Add an alert message to session if fail plan page has been loaded
		$this->session->set_flashdata(
			'fMessage',
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
	public function userLogs()
	{
		#  $pmodel variable to load model 'pmodel'
		$pmodel = $this->pmodel;
		# $session variable to save field email & username from user
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		# $user variable returns user row array data value as per email in stored session
		$user = $this->amodel->getUser($sessions['email']);
		# $data variable to store array of data passed to dashboard page
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Logs',
			'user'=>$user,
			'logs'=>$pmodel->getLogs($user['id_user'])
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
			redirect('auth/login');
		}
		
		// var_dump($user);
		// die;

		# Load view main on folder sections and pass $data variable
		$this->load->view('sections/main', $data);
	}
}