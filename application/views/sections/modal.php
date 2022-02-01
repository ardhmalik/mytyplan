<!-- Modal Add -->
<div class="modal fade" id="planAdd" tabindex="-1" aria-labelledby="planAdd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planAdd">Add Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="<?= site_url('plans/add') ?>" method="post" class="mx-3 my-3">
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
                                <a href="<?= site_url('plans/dashboard') ?>" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                            <div class="p-2 ms-auto bd-highlight">
                                <input type="submit" class="btn btn-primary" value="Add"></input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add -->
    
<?php foreach ($plans as $pl) : ?>
<!-- Modal Details -->
<div class="modal fade" id="plan<?= $pl['id_plan'] ?>" tabindex="-1" aria-labelledby="planDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planDetails">Detail Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="text-bold">
                                <?= $pl['plan'] ?>
                                <?php
                                    # Percabangan switch untuk background label
                                    $bgLabel = '';
                                    switch ($pl['label']) {
                                        case 'Very Important':
                                            $bgLabel = 'bg-danger';
                                            break;
                                        case 'Important':
                                            $bgLabel = 'bg-warning';
                                            break;
                                        case 'Normal':
                                            $bgLabel = 'bg-primary';
                                            break;
                                        default:
                                            $bgLabel;
                                            break;
                                    }

                                    # Percabangan if untuk tampilan status
                                    $bgStatus = '';
                                    $status = '';
                                    $now = time();
                                    $exp = strtotime($pl['expired']);
                                    if ($exp < $now) {
                                        $bgStatus = 'bg-none';
                                        if ($pl['status'] == 0) {
                                            $status = 'fas fa-times-circle text-danger';
                                        } elseif ($pl['status'] == 1) {
                                            $status = 'fas fa-check-circle text-success';
                                        }
                                    } else {
                                        if ($pl['status'] == 0) {
                                            $bgStatus = 'd-none';
                                        } elseif ($pl['status'] == 1) {
                                            $status = 'fas fa-check-circle text-success';
                                        }
                                    }
                                ?>
                                <span class="badge <?= $bgLabel ?> rounded-pill">
                                    <?= $pl['label'] ?>
                                </span>
                                <span class="badge-lg <?= $bgStatus ?> rounded-pill">
                                    <i class="<?= $status ?>"></i>
                                </span>
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
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planEdit<?= $pl['id_plan'] ?>">
                    <i class="fas fa-edit"></i> | Edit Plan
                </button>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#planMove<?= $pl['id_plan'] ?>">
                    <i class="fas fa-arrows-alt"></i> | Move Plan
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Details -->

<!-- Modal Edit -->
<div class="modal fade" id="planEdit<?= $pl['id_plan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="planEdit" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planEdit">Edit Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Form Edit Plan -->
                    <form action="<?= site_url('plans/edit') ?>" method="post" class="mx-3 my-3">
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
                            <input type="submit" class="btn btn-primary" value="Save"></input>
                        </div>
                    </form>
                    <!-- End Form Edit -->
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#plan<?= $pl['id_plan'] ?>">Back</button>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#planDel<?= $pl['id_plan'] ?>">
                    <i class="fas fa-trash"></i> | Delete
                </button>
                <?php
                    # Percabangan if untuk tampilan button Mark as success & form action
                    $formUrl = '';
                    $btn = '';
                    $textBtn = '';

                    if ($pl['status'] == 0) {
                        $formUrl = 'plans/successPlan';
                        $btn = 'btn btn-success';
                        $textBtn = 'Mark as success';
                    } elseif ($pl['status'] == 1) {
                        $formUrl = 'plans/failPlan';
                        $btn = 'btn btn-danger';
                        $textBtn = 'Back to fail';
                    }
                ?>
                <form action="<?= site_url($formUrl) ?>" method="post">
                    <input type="hidden" name="id_plan" id="id_plan" value="<?= $pl['id_plan'] ?>">
                    <input type="submit" class="<?= $btn ?>" value="<?= $textBtn ?>">
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Move -->
<div class="modal fade" id="planMove<?= $pl['id_plan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="planMove" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planMove">Move Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="<?= site_url('plans/move') ?>" method="post">                       
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
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#plan<?= $pl['id_plan'] ?>">Cancel</button>
                            <input type="submit" class="btn btn-primary" value="Move"></input>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="planDel<?= $pl['id_plan'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="planDel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="planDel">Delete Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="container-fluid">
                    <h5 class="text-center text-bold mb-5">
                        Are you sure?
                    </h5>
                    <form action="<?= site_url('plans/delete') ?>" method="post">
                        <input type="hidden" name="id_plan" id="id_plan" value="<?= $pl['id_plan'] ?>">
                        <div class="d-flex bd-highlight">
                            <div class="p-2 bd-highlight">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#planEdit<?= $pl['id_plan'] ?>">No</button>
                            </div>
                            <div class="ms-auto p-2 bd-highlight">
                                <input type="submit" class="btn btn-primary" value="Yes, delete it">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>