<!-- Modal Add Plan -->
<div class="modal fade" id="planAdd" tabindex="-1" aria-labelledby="planAdd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planAdd">Add Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Form Add Plan -->
                    <form action="<?= site_url('add_plan') ?>" method="post" class="mx-3 my-3">
                        <input type="hidden" name="id_user" id="id_user" value="<?= $user['id_user'] ?>">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" name="plan" id="plan" value="" placeholder="Enter new plan" required>
                            <label for="plan">Plan</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <textarea class="form-control" id="description" name="description" style="height: 100px" placeholder="Describe your plan"></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <select class="form-select" name="label" id="label" aria-label="Default select example">
                                <?php foreach ($labels as $lb) : ?>
                                    <option value="<?= $lb['id_label'] ?>"><?= $lb['label'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="label" class="form-label">Label</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <select class="form-select" name="month" id="month" aria-label="Default select example">
                                <?php foreach ($months as $mn) : ?>
                                    <option value="<?= $mn['id_month'] ?>"><?= $mn['month_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="month" class="form-label">Month</label>
                        </div>
                        <div class="mb-3">
                            <label for="expired" class="form-label">Expired</label>
                            <input type="date" class="form-control" name="expired" id="expired" min="2022-01-01" max="2022-12-30" required>
                        </div>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight">
                                <span class="text-muted">Has the plan worked?</span>
                            </div>
                            <div class="p-2 bd-highlight">
                                <input type="checkbox" class="form-check-input" id="status" name="status">
                                <label class="form-check-label" for="status">Yes</label>                               
                            </div>
                        </div>
                        <div class="d-flex bd-highlight">
                            <div class="p-2 bd-highlight">
                                <a href="<?= site_url('dashboard') ?>" class="btn fw-bold btn-outline-secondary">Cancel</a>
                            </div>
                            <div class="p-2 ms-auto bd-highlight">
                                <input type="submit" class="btn fw-bold btn-primary" value="Add"></input>
                            </div>
                        </div>
                    </form>
                    <!-- End Form Add Plan -->
                </div>
            </div>
        </div>
        <!-- End Modal Body -->
    </div>
</div>
<!-- End Modal Add Plan -->

<!-- Foreach loop to print data plans in modal -->
<?php foreach ($plans as $pl) : ?>

<!-- Modal Details Plan -->
<div class="modal fade" id="plan<?= $pl['id_plan'] ?>" tabindex="-1" aria-labelledby="planDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planDetails">Detail Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-bold">
                                <?= $pl['plan'] ?>
                                <?php
                                    # $label_bg variable to store background class for label
                                    $label_bg = '';
                                    # Switch statement to specify background label
                                    switch ($pl['label']) {
                                        case 'Very Important':
                                            $label_bg = 'bg-danger';
                                            break;
                                        case 'Important':
                                            $label_bg = 'bg-warning';
                                            break;
                                        case 'Normal':
                                            $label_bg = 'bg-primary';
                                            break;
                                        default:
                                            $label_bg;
                                            break;
                                    }

                                    # $status_bg variable to save background class for status
                                    $status_bg = '';
                                    # $status variable to save icon for status
                                    $status = '';
                                    # $now to save current time
                                    $now = time();
                                    # $exp to store the expired value which has been converted to the time data type
                                    $exp = strtotime($pl['expired']);
                                    # If condition to compare expired with current time
                                    if ($exp < $now) {
                                        if ($pl['status'] == 0) {
                                            # If status value is 0, then display times icon and red color
                                            $status = 'fas fa-times-circle text-danger';
                                        } elseif ($pl['status'] == 1) {
                                            # If status value is 1, then display check icon dan green color
                                            $status = 'fas fa-check-circle text-success';
                                        }
                                    } else {
                                        if ($pl['status'] == 0) {
                                            # If status value is 0, then status isn't displayed
                                            $status_bg = 'd-none';
                                        } elseif ($pl['status'] == 1) {
                                            # If status value is 1, then display check icon dan green color
                                            $status = 'fas fa-check-circle text-success';
                                        }
                                    }
                                ?>
                                <!-- Label Badge -->
                                <span class="badge <?= $label_bg ?> rounded-pill">
                                    <?= $pl['label'] ?>
                                </span>
                                <!-- End Label Badge -->

                                <!-- Status Badge -->
                                <span class="badge-lg <?= $status_bg ?> rounded-pill">
                                    <i class="<?= $status ?>"></i>
                                </span>
                                <!-- End Status Badge -->
                            </h5>
                        </div>
                        <div class="col-12">
                            <small class="text-muted fst-italic">
                                Expired : <?= $pl['expired'] ?>
                            </small>
                        </div>
                        <div class="col-12">
                            <p>
                                <?= $pl['description'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Body -->

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn fw-bold btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#planEdit<?= $pl['id_plan'] ?>">
                    <i class="fas fa-edit"></i> | Edit Plan
                </button>
                <?php
                    # $form_url to save url text
                    $form_url = '';
                    # $btn to save button class
                    $btn = '';
                    # $text_btn to save button values
                    $text_btn = '';

                    # If condition for display button Mark as success & form action
                    if ($pl['status'] == 0) {
                        # If TRUE, then display button change mark to success plan
                        $form_url = 'mark_success';
                        $btn = 'btn btn-success';
                        $text_btn = '<i class="far fa-check-circle"></i> | Mark as success';
                    } elseif ($pl['status'] == 1) {
                        # If FALSE, then display button change mark to failed plan
                        $form_url = 'mark_fail';
                        $btn = 'btn btn-danger';
                        $text_btn = '<i class="far fa-times-circle"></i> | Back to fail';
                    }
                ?>
                <!-- Form Mark -->
                <form action="<?= site_url($form_url) ?>" method="post">
                    <input type="hidden" name="id_plan" id="id_plan" value="<?= $pl['id_plan'] ?>">
                    <button type="submit" class="<?= $btn ?>"><?= $text_btn ?></button>
                </form>
                <!-- End Form Mark -->
            </div>
            <!-- End Modal Footer -->
        </div>
    </div>
</div>
<!-- End Modal Details -->

<!-- Modal Edit Plan -->
<div class="modal fade" id="planEdit<?= $pl['id_plan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="planEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planEdit">Edit Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Form Edit Plan -->
                    <form action="<?= site_url('edit_plan') ?>" method="post" class="mx-3 my-3">
                        <input type="hidden" name="id_plan" id="id_plan" value="<?= $pl['id_plan'] ?>">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" name="plan" id="plan" value="<?= $pl['plan'] ?>" placeholder="Enter new plan" required>
                            <label for="plan">Plan</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <textarea class="form-control" id="description" name="description" style="height: 100px" placeholder="Describe your plan"><?= $pl['description'] ?></textarea>
                            <label for="description">Description</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <select class="form-select" name="label" id="label">
                                <?php foreach ($labels as $lb) : ?>
                                    <option value="<?= $lb['id_label'] ?>" <?= ($lb['label']==$pl['label'] ? 'selected' : '') ?> ><?= $lb['label'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="label" class="form-label">Label</label>
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
                <button type="button" class="btn fw-bold btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#plan<?= $pl['id_plan'] ?>">Back</button>
                <button type="button" class="btn fw-bold btn-outline-danger" data-bs-toggle="modal" data-bs-target="#planDel<?= $pl['id_plan'] ?>">
                    <i class="fas fa-trash"></i> | Delete
                </button>
                <button type="button" class="btn fw-bold btn-warning" data-bs-toggle="modal" data-bs-target="#planMove<?= $pl['id_plan'] ?>">
                    <i class="fas fa-arrows-alt"></i> | Move Plan
                </button>
            </div>
            <!-- End Modal Footer -->
        </div>
    </div>
</div>
<!-- Modal Edit Plan -->

<!-- Modal Move plan -->
<div class="modal fade" id="planMove<?= $pl['id_plan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="planMove" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planMove">Move Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Form Move Plan -->
                    <form action="<?= site_url('move_plan') ?>" method="post">                       
                        <input type="hidden" name="id_plan" id="id_plan" value="<?= $pl['id_plan'] ?>">
                        <div class="mb-3 form-floating">
                            <select class="form-select" name="month" id="month" aria-label="Default select example">
                                <?php foreach ($months as $mn) : ?>
                                    <option value="<?= $mn['id_month'] ?>" <?= ($mn['month']==$pl['month'] ? 'selected' : '') ?> ><?= $mn['month_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="month" class="form-label">Month</label>
                        </div>
                        <div class="mb-3">
                            <label for="expired" class="form-label">Expired</label>
                            <input type="date" class="form-control" name="expired" id="expired" min="2022-01-01" max="2022-12-30" value="<?= date('Y-m-d', strtotime($pl['expired'])) ?>" required>
                        </div>
                        <div class="float-end">
                            <button type="button" class="btn fw-bold btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#planEdit<?= $pl['id_plan'] ?>">
                                <i class="fa-solid fa-arrow-left"></i> | Back
                            </button>
                            <input type="submit" class="btn fw-bold btn-primary" value="Move"></input>
                        </div>
                    </form>
                    <!-- End Form Move Plan -->
                </div>
            </div>
            <!-- End Modal Body -->
        </div>
    </div>
</div>
<!-- End Modal Move plan -->

<!-- Modal Delete Plan -->
<div class="modal fade" id="planDel<?= $pl['id_plan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="planDel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planDel">Delete Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- End Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <h5 class="text-center text-bold mb-5">
                        Are you sure?
                    </h5>
                    <!-- Form Delete Plan -->
                    <form action="<?= site_url('delete_plan') ?>" method="post">
                        <input type="hidden" name="id_plan" id="id_plan" value="<?= $pl['id_plan'] ?>">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn fw-bold btn-light btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#planEdit<?= $pl['id_plan'] ?>">No</button>
                            </div>
                            <div class="ms-auto p-2 bd-highlight">
                                <input type="submit" class="btn fw-bold btn-danger fw-bold" value="Yes, delete it">
                            </div>
                        </div>
                    </form>
                    <!-- End Form Delete Plan -->
                </div>
            </div>
            <!-- End Modal Body -->
        </div>
    </div>
</div>
<!-- End Modal Delete Plan -->

<?php endforeach ?>


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
                            <input class="form-control" type="file" id="formFile" name="avatar" accept="image/png, image/jpeg, image/jpg, image/gif">
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