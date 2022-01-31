<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
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
}