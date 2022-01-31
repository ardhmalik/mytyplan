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
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		$user = $this->amodel->getUser($sessions['email']);
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Dashboard',
			'user'=>$user,
			'months'=>$this->pmodel->getMonths(),
			'plans'=>$this->pmodel->getPlans($user['id_user']),
		];

		$this->load->view('sections/header', $data);
		$this->load->view('sections/main', $data);
		$this->load->view('sections/footer');
	}
	
	public function add()
	{
		$amodel = $this->amodel;
		$pmodel = $this->pmodel;
		$sessions = [
			'email'=>$this->session->userdata('email'),
			'username'=>$this->session->userdata('username')
		];
		$data = [
			'project'=>'My This Year Plan',
			'title'=>'Add Plan',
			'user'=>$amodel->getUser($sessions['email']),
			'months'=>$pmodel->getMonths(),
			'labels'=>$pmodel->getLabels(),
		];

		$validation = $this->form_validation;
		$validation->set_rules($pmodel->add_rules());

		if ($validation->run() == FALSE) {
			$this->load->view('sections/header', $data);
			$this->load->view('sections/main', $data);
			$this->load->view('sections/footer');
		} else {
			$status = $this->_statusCheck();
			$input = $this->input;
			$data = [
				'id_user'=>$input->post('id_user'),
				'plan'=>$input->post('plan'),
				'description'=>$input->post('description'),
				'expired'=>$input->post('expired') . " 23:59:59",
				'status'=>$status,
				'id_label'=>$input->post('label'),
				'id_month'=>$input->post('month')
			];

			var_dump($data);

			$pmodel->createPlan($data);
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-success" role="alert">
				Succes to create a new plan..
				</div>'
			);
			redirect('plans/dashboard');
		}
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
}