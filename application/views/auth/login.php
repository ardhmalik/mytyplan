<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
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
                            <input type="email" class="form-control" id="email" name="email" value="" placeholder="example@email.com" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Must include string and numbers" aria-describedby="passHelp">
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="ms-auto p-2 bd-highlight">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <span>Don't have an account?</span>    
                    <a href="<?= site_url('auth/register') ?>">Register Now</a>
                </div>
            </div>
        </div>
    </div>
</div>