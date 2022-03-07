<main id="main" class="main">
    <div class="pagetitle">
        <h1><?= $title ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('admin_dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col">
                <?= $this->session->flashdata('message') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <img src="<?= site_url('/assets/img/user/') . $user['avatar'] ?>" alt="Profile" class="rounded-circle">
                        <h2><?= $user['username'] ?></h2>
                        <h3><?= $this->session->userdata('role') ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">About</h5>
                                <p class="small fst-italic">
                                    Akun ini hanya dapat diakses oleh admin My This Year Plan
                                </p>
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Username</div>
                                    <div class="col-lg-9 col-md-8"><?= $user['username'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Company</div>
                                    <div class="col-lg-9 col-md-8"><?= $project ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Job</div>
                                    <div class="col-lg-9 col-md-8"><?= $this->session->userdata('role') ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">Indonesia</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">(+62) 812X-XXXX-XXXX</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8"><?= $user['email'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Joined</div>
                                    <div class="col-lg-9 col-md-8"><?= $user['joined'] ?></div>
                                </div>
                            </div>
                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <!-- Profile Edit Form -->
                                <form action="<?= site_url('edit_profile') ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id_user" id="id_user" value="<?= $user['id_user'] ?>">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="<?= site_url('/assets/img/user/') . $user['avatar'] ?>" class="img-fluid rounded" alt="Profile Avatar"><br>
                                            <small class="text-muted fst-italic">Max: 1MB (1800x1800 px) *.(png,jpg,jpeg,gif)</small>
                                            <div class="pt-2">
                                                <div class="input-group input-group-sm w-50">
                                                    <input type="file" name="avatar" id="avatar" class="form-control" title="Upload new profile image" accept="image/png, image/jpeg, image/jpg, image/gif">
                                                    <label class="input-group-text  me-2" for="avatar"><i class="bi bi-upload"></i></label>
                                                    <?php if ($user['avatar'] != 'avatar.png') : ?>
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delAvatar<?= $user['id_user'] ?>">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="username" type="text" class="form-control" id="username" value="<?= $user['username'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="company" class="col-md-4 col-lg-3 col-form-label">Company</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="company" type="text" class="form-control" id="company" value="<?= $project ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="job" type="text" class="form-control" id="Job" value="<?= $this->session->userdata('role') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="country" type="text" class="form-control" id="Country" value="Indonesia" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="Phone" value="(+62) 812X-XXXX-XXXX" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email" value="<?= $user['email'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>
                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form action="<?= site_url('change_password') ?>" method="post">
                                    <input type="hidden" name="id_user" id="id_user" value="<?= $user['id_user'] ?>">
                                    <div class="row mb-3">
                                        <label for="curr_password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" name="curr_password" class="form-control" id="curr_password">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="new_password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" name="new_password" class="form-control" id="new_password">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="renew_password" class="col-md-4 col-lg-3 col-form-label">Repeat New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" name="renew_password" class="form-control" id="renew_password">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<!-- Modal Set Default Avatar -->
<div class="modal fade" id="delAvatar<?= $user['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delAvatar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="delAvatar">Delete Profile Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <h5 class="text-center text-bold">
                        Are you sure to delete your profile image?
                    </h5>
                    <div class="div w-50 my-3 mx-auto">
                        <img src="<?= site_url('assets/img/user/') . $user['avatar'] ?>" class="img-fluid rounded" alt="Profile Avatar">
                    </div>
                    <!-- Form Set Default Avatar -->
                    <form action="<?= site_url('default_avatar') ?>" method="post">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $user['id_user'] ?>">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-light btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editProfile<?= $user['id_user'] ?>">No</button>
                            </div>
                            <div class="ms-auto p-2 bd-highlight">
                                <input type="submit" class="btn btn-danger" value="Yes, delete it">
                            </div>
                        </div>
                    </form>
                    <!-- End Form Set Default Avatar -->
                </div>
            </div>
            <!-- End Modal Body -->
        </div>
    </div>
</div>
<!-- End Modal Set Default Avatar -->