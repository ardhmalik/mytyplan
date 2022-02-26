<!-- Modal Detail Profile -->
<div class="modal fade" id="profile<?= $user['id_user'] ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="profile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="profile">Your Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="card border-0 mb-3">
                        <div class="row g-0">
                            <div class="col-md-4 my-auto">
                                <img src="<?= site_url('assets/img/user/') . $user['avatar'] ?>" class="img-fluid rounded" alt="Profile Avatar">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= $user['username'] ?>
                                    </h5>
                                    <p class="card-text">
                                        <?= $user['email'] ?>
                                    </p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Joined at <?= $user['joined'] ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#editProfile<?= $user['id_user'] ?>">
                    <i class="fas fa-edit"></i> | Edit Profile
                </button>
            </div>
            <!-- End Modal Footer -->
        </div>
    </div>
</div>
<!-- End Modal Move plan -->

<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfile<?= $user['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editProfile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="editProfile">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Form Edit Plan -->
                    <form action="<?= site_url('edit_profile') ?>" method="post" enctype="multipart/form-data" class="mx-3 my-3">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $user['id_user'] ?>">
                        <div class="mb-2 w-50 mx-auto">
                            <img src="<?= site_url('assets/img/user/') . $user['avatar'] ?>" class="img-fluid rounded" alt="Profile Avatar">
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="file" id="formFile" name="avatar" accept="image/png, image/jpeg, image/jpg, image/gif" aria-describedby="imgHelp">
                            <div id="imgHelp" class="form-text">Max: 1MB (1800x1800 px) *.(png,jpg,jpeg,gif)</div>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" name="username" id="username" value="<?= $user['username'] ?>" placeholder="Enter new username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" name="email" id="email" value="<?= $user['email'] ?>" placeholder="Enter new email" required readonly>
                            <label for="email">email</label>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn fw-bold btn-primary">
                                <i class="far fa-save"></i> | Save
                            </button>
                        </div>
                    </form>
                    <!-- End Form Edit Plan -->
                </div>
            </div>
            <!-- End Modal Body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn fw-bold btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#profile<?= $user['id_user'] ?>">
                    <i class="fa-solid fa-arrow-left"></i> | Back
                </button>
                <?php if ($user['avatar'] != 'avatar.png') : ?>
                    <button type="button" class="btn fw-bold btn-info" data-bs-toggle="modal" data-bs-target="#defaultAvatar<?= $user['id_user'] ?>">
                        <i class="fa-solid fa-image-portrait"></i> | Set Default Avatar
                    </button>
                <?php endif; ?>
            </div>
            <!-- End Modal Footer -->
        </div>
    </div>
</div>
<!-- Modal Edit Plan -->

<!-- Modal Set Default Avatar -->
<div class="modal fade" id="defaultAvatar<?= $user['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="defaultAvatar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="defaultAvatar">Set Default Avatar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <h5 class="text-center text-bold">
                        Are you sure delete this avatar?
                    </h5>
                    <div class="div w-50 my-3 mx-auto">
                        <img src="<?= site_url('assets/img/user/') . $user['avatar'] ?>" class="img-fluid rounded" alt="Profile Avatar">
                    </div>
                    <!-- Form Set Default Avatar -->
                    <form action="<?= site_url('default_avatar') ?>" method="post">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $user['id_user'] ?>">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn fw-bold btn-light btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editProfile<?= $user['id_user'] ?>">No</button>
                            </div>
                            <div class="ms-auto p-2 bd-highlight">
                                <input type="submit" class="btn fw-bold btn-danger fw-bold" value="Yes, delete it">
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