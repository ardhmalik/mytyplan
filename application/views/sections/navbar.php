<!-- Navbar -->
<nav class="navbar navbar-light bg-light mb-3">
    <div class="container">
        <a href="<?= site_url() ?>" class="navbar-brand">
            <?= $user['username'] ?>
        </a>
        <div class="d-flex">
            <?php
                date_default_timezone_set("Asia/Jakarta");
                echo date("H:i") . " WIB"; 
            ?>
             | 
            <a href="<?= site_url('auth/logout') ?>">Logout</a>
        </div>
    </div>
</nav>
<!-- End Navbar -->