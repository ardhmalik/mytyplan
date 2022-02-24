<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">
                        <?= $title ?>
                    </h4>    
                </div>
                <div class="card-body">
                    <form action="" method="post" class="mx-4 my-5">
                        <div class="mb-3 form-floating">
                            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" placeholder="example@email.com" required>
                            <label for="email">Email address</label>
                            <?= form_error('email', '<span class="text-danger">', '</span>') ?>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="username" class="form-control" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Create a unique username" required>
                            <label for="username">Username</label>
                            <?= form_error('username', '<span class="text-danger">', '</span>') ?>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Must include string and numbers" required>
                            <label for="password">Password</label>
                            <?= form_error('password', '<span class="text-danger">', '</span>') ?>
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="p-2 bd-highlight">
                                <button type="reset" class="btn fw-bold btn-light btn-outline-secondary">Cancel</button>
                            </div>
                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn fw-bold btn-primary">Register Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <span>Do you have an account?</span>    
                    <a href="<?= site_url('login') ?>">Login Now</a>
                </div>
            </div>
        </div>
    </div>
</div>