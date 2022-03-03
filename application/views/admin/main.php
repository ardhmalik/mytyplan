<?php
# Load header & navbar admin
$this->load->view('admin/header');
$this->load->view('admin/navigation');

# SWITCH statement to load appropriate files
switch ($title) {
    case 'Admin Dashboard':
        $this->load->view('admin/pages/dashboard');
        // $this->load->view('admin/modal');
        break;
    case 'User List':
        $this->load->view('admin/pages/users');
        break;
    case 'User Logs Activity':
        $this->load->view('admin/pages/user_logs');
        break;
    case 'Plans List':
        $this->load->view('admin/pages/all_plans');
        break;
    case 'Admin Profile':
        $this->load->view('admin/pages/profile');
        break;
    default:
        $this->load->view('admin/pages/dashboard');
        break;
}

# Load footer section
$this->load->view('admin/footer');
