<!-- Route main page -->
<?php
# variable to pass data to another page
// $data = [
//     'title'=>$title,
//     'user'=>$user,
//     'months'=>$months,
//     'labels'=>$labels,
//     'plans'=>$plans
// ];

$this->load->view('sections/navbar');

switch ($title) {
    case 'Dashboard':
        $this->load->view('pages/dashboard');
        $this->load->view('sections/modal');
        break;
    case 'Add Plan':
        $this->load->view('pages/addPlan');
        break;
    default:
        redirect('auth/login');
        break;
}
?>
<!-- End Route -->