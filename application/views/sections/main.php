<!-- Route main page -->
<?php
# variable to pass data to another page
$data = [
    'title'=>$title,
    'months'=>$months,
    'plans'=>$plans
];

switch ($title) {
    case 'Dashboard':
        $this->load->view('sections/navbar', $data);
        $this->load->view('pages/dashboard', $data);
        break;
    default:
        redirect('auth/login');
        break;
}
?>
<!-- End Route -->