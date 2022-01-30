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
                    <form action="" method="post" class="mx-4 my-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="" placeholder="example@email.com">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="username" class="form-control" id="username" name="username" value="" placeholder="Create a unique username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Must include string and numbers">
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-primary">Register Account</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <span>Do you have an account?</span>    
                    <a href="<?= site_url('auth/login') ?>">Login Now</a>
                </div>
            </div>
        </div>
    </div>
</div>