<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Navbar Brand-->
        <a href="<?= site_url('dashboard') ?>" class="navbar-brand">
            <?= $project ?>
        </a>
        <!-- End Navbar Brand-->
        
        <!-- Navbar Dropdown Menu -->
        <div class="d-flex" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="actionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= base_url('/assets/img/user/') . $user['avatar'] ?>" alt="" width="22" height="22" class="d-inline-block align-text-top rounded-circle">
                        <?= $user['username'] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                        <li>
                            <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#profile<?= $user['id_user'] ?>">Profile</a>
                        </li>
                        <li>
                            <a href="<?= site_url('success_plans') ?>" class="dropdown-item">Success plan</a>
                        </li>
                        <li>
                            <a href="<?= site_url('fail_plans') ?>" class="dropdown-item">Fail Plan</a>
                        </li>
                        <li>
                            <a href="<?= site_url('user_activity_logs') ?>" class="dropdown-item">Logs</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="<?= site_url('logout') ?>" class="dropdown-item">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- End Navbar Dropdown Menu -->
    </div>
</nav>
<!-- End Navbar -->

<!-- Main Content -->
<div class="container">