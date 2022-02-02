<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('auth_model', 'amodel');
		$this->load->model('plans_model', 'pmodel');
	}

	public function dashboard()
	{
		$pmodel = $this->pmodel;
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		$user = $this->amodel->getUser($sessions['email']);
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Dashboard',
			'user'=>$user,
			'months'=>$pmodel->getMonths(),
			'labels'=>$pmodel->getLabels(),
			'plans'=>$pmodel->getPlans($user['id_user']),
		];

		if (!$this->session->userdata('email')) {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			redirect('auth/login');
		}

		// var_dump($user);
		// die;

		$this->load->view('sections/main', $data);
	}
	
	public function add()
	{
		$input = $this->input;
		$pmodel = $this->pmodel;
		$status = $this->_statusCheck();

		$validation = $this->form_validation;
		$validation->set_rules($pmodel->add_rules());

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

		$pmodel->createPlan($data);
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Success to create a new plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		redirect('plans/dashboard');
	}

	private function _statusCheck()
	{
		$check = $this->input->post('status');

		if ($check == NULL) {
			$status = 0;
		} else {
			$status = 1;
		}

		return $status;
	}

	public function edit()
	{
		$input = $this->input;
		$data = [
			'id_plan'=>$input->post('id_plan'),
			'plan'=>$input->post('plan'),
			'description'=>$input->post('description'),
			'id_label'=>$input->post('label')
		];
		
		// var_dump($data);
		// die;

		$this->pmodel->updatePlan($data);
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Success to edit plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		redirect('plans/dashboard');
	}

	public function successPlan()
	{
		$data = [
			'id_plan'=>$this->input->post('id_plan')
		];

		// var_dump($data);
		// die;

		$this->pmodel->successMark($data);
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Done, marking a successful plan..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		redirect('plans/dashboard');
	}
	
	public function failPlan()
	{
		$data = [
			'id_plan'=>$this->input->post('id_plan')
		];
		
		// var_dump($data);
		// die;

		$this->pmodel->failMark($data);
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Done, marks the plan failed..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		redirect('plans/dashboard');
	}
	
	public function move()
	{
		$input = $this->input;
		$data = [
			'id_plan'=>$input->post('id_plan'),
			'id_month'=>$input->post('month'),
			'expired'=>$input->post('expired') . " 23:59:59"
		];
		
		// var_dump($data);
		// die;
		
		$this->pmodel->movePlan($data);
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Move plan successfully..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		redirect('plans/dashboard');
	}
	
	public function delete()
	{
		$input = $this->input;
		$data = [
			'id_plan'=>$input->post('id_plan')
		];

		// var_dump($data);
		// die;

		$this->pmodel->delPlan($data);
		$this->session->set_flashdata(
			'message',
			'<div class="alert alert-success alert-dismissible fade show" role="alert">
			Delete plan successfully..
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);
		redirect('plans/dashboard');
	}

	public function getSuccess()
	{
		$pmodel = $this->pmodel;
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		$user = $this->amodel->getUser($sessions['email']);
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Success Plan',
			'user'=>$user,
			'months'=>$pmodel->getMonths(),
			'labels'=>$pmodel->getLabels(),
			'splans'=>$pmodel->getSplans($user['id_user'])
		];

		if (!$this->session->userdata('email')) {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			redirect('auth/login');
		}

		// var_dump($user);
		// die;

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

		$this->load->view('sections/main', $data);
	}
	
	public function getFail()
	{
		$pmodel = $this->pmodel;
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		$user = $this->amodel->getUser($sessions['email']);
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Fail Plan',
			'user'=>$user,
			'months'=>$pmodel->getMonths(),
			'labels'=>$pmodel->getLabels(),
			'fplans'=>$pmodel->getFplans($user['id_user'])
		];

		if (!$this->session->userdata('email')) {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			redirect('auth/login');
		}

		// var_dump($user);
		// die;

		$this->session->set_flashdata(
			'fMessage',
			'<div class="alert alert-info alert-dismissible fade show" role="alert">
				<h4 class="alert-heading">Finish it!</h4>
				<p>You have other plans to complete, stay <span class="fw-bold">motivated</span> and <span class="fw-bold">focused</span> on your goals!</p>
				<hr>
				<figure class="text-end">
					<blockquote class="blockquote">Failure is the beginning of success</blockquote>
					<figcaption class="blockquote-footer">
						Writer on <cite title="Source Title">Earth</cite>
				</figure>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>'
		);

		$this->load->view('sections/main', $data);
	}

	public function userLogs()
	{
		$pmodel = $this->pmodel;
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		$user = $this->amodel->getUser($sessions['email']);
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Logs',
			'user'=>$user,
			'logs'=>$pmodel->getLogs($user['id_user'])
		];

		if (!$this->session->userdata('email')) {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-info alert-dismissible fade show" role="alert">
					You are still not logged in, please Login..
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>'
			);
			redirect('auth/login');
		}
		
		// var_dump($user);
		// die;

		$this->load->view('sections/main', $data);
	}
}