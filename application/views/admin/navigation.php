<?php
$aside_nav = ['Admin Dashboard', 'User', 'User List', 'User Logs', 'Plans List', 'Admin Profile'];
?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="<?= site_url('admin_dashboard') ?>" class="logo d-flex align-items-center">
            <img src="<?= site_url('/assets/img/logo.png') ?>" alt="Logo">
            <span class="d-none d-lg-block">MTYPlan</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?= base_url('/assets/img/user/') . $user['avatar'] ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['username'] ?></span>
                </a>
                <!-- End Profile Image Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $user['username'] ?></h6>
                        <span><?= $this->session->userdata('role') ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= site_url('admin_profile') ?>">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= site_url('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
                <!-- End Profile Dropdown Items -->
            </li>
            <!-- End Profile Nav -->
        </ul>
    </nav>
    <!-- End Icons Navigation -->
</header>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?= ($title === $aside_nav[0]) ? '' : 'collapsed' ?>" href="<?= site_url('admin_dashboard') ?>">
                <i class="bi bi-grid"></i>
                <span><?= $aside_nav[0] ?></span>
            </a>
        </li>
        <!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link <?= (preg_match("/$aside_nav[1]/i", $title)) ? '' : 'collapsed' ?>" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bx bxs-user-account"></i>
                <span><?= $aside_nav[1] ?></span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse <?= (preg_match("/$aside_nav[1]/i", $title)) ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= site_url('get_user_list') ?>" class="<?= ($title === $aside_nav[2]) ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i>
                        <span><?= $aside_nav[2] ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('get_user_logs') ?>" class="<?= (preg_match("/$aside_nav[3]/i", $title)) ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i>
                        <span><?= $aside_nav[3] ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- End Users Nav -->
        <li class="nav-item">
            <a class="nav-link <?= ($title === $aside_nav[4]) ? '' : 'collapsed' ?>" href="<?= site_url('get_all_plans') ?>">
                <i class="bx bx-notepad"></i>
                <span><?= $aside_nav[4] ?></span>
            </a>
        </li>
        <!-- End Plans Nav -->
        <li class="nav-item">
            <a class="nav-link <?= ($title === $aside_nav[5]) ? '' : 'collapsed' ?>" href="<?= site_url('admin_profile') ?>">
                <i class="bi bi-person"></i>
                <span><?= $aside_nav[5] ?></span>
            </a>
        </li>
        <!-- End Login Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= site_url('logout') ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li>
        <!-- End Error 404 Page Nav -->
    </ul>
</aside>
<!-- End Sidebar-->