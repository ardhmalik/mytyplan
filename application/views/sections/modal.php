<?php foreach ($plans as $pl) : ?>
<!-- Modal Details -->
<div class="modal fade" id="plan<?= $pl['id_plan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                                        $bgStatus = 'd-none';
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>