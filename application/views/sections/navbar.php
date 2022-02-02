<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a href="<?= site_url('plans/dashboard') ?>" class="navbar-brand">
            <?= $project ?>
        </a>
        <div class="d-flex" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="actionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $user['username'] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="actionDropdown">
                        <li>
                            <a href="<?= site_url('plans/getsuccess') ?>" class="dropdown-item">Success plan</a>
                        </li>
                        <li>
                            <a href="<?= site_url('plans/getfail') ?>" class="dropdown-item">Fail Plan</a>
                        </li>
                        <li>
                            <a href="<?= site_url('plans/userlogs') ?>" class="dropdown-item">Logs</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a href="<?= site_url('auth/logout') ?>" class="dropdown-item">Logout</a>
                        </li>
                  </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Main Content -->
<div class="container">