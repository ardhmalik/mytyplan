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
                <a type="button" class="btn btn-outline-danger">
                    <i class="fas fa-trash"></i> | Delete
                </a>
                <?php
                    # Percabangan if untuk tampilan button Mark as success
                    $btn = '';
                    $textBtn = '';

                    if ($pl['status'] == 0) {
                        $btn = 'btn btn-success';
                        $textBtn = '<i class="fas fa-check-circle"></i> | Mark as success';
                    } elseif ($pl['status'] == 1) {
                        $btn = 'btn btn-danger';
                        $textBtn = '<i class="fas fa-times-circle"></i> | Back to fail';
                    }
                ?>
                <a type="button" class="<?= $btn ?>">
                    <?= $textBtn ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>