<?php
$this->load->view('sections/header');
$this->load->view('sections/navbar');

switch ($title) {
    case 'Dashboard':
        $this->load->view('pages/dashboard');
        $this->load->view('sections/modal');
        break;
    case 'Logs':
        $this->load->view('pages/logs');
        break;
    default:
        $this->load->view('pages/dashboard');
        break;
}

$this->load->view('sections/footer');

?>