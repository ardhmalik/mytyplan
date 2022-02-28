<?php
# Load header & navbar admin
$this->load->view('admin/header');
$this->load->view('admin/navigation');

# SWITCH statement to load appropriate files
switch ($title) {
    case 'Dashboard Admin':
        $this->load->view('admin/pages/dashboard');
        // $this->load->view('admin/modal');
        break;
    case 'Success Plan':
        $this->load->view('admin/successp');
        break;
    case 'Fail Plan':
        $this->load->view('admin/failp');
        break;
    case 'Logs':
        $this->load->view('admin/logs');
        break;
    default:
        $this->load->view('admin/dashboard');
        break;
}

# Load footer section
$this->load->view('admin/footer');

?>