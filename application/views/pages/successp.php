<!-- Success Plan Page -->
<div class="row justify-content-center">
    <!-- Title -->
    <div class="col-12 mt-3 mb-4">
        <h2 class="text-center">
            <?= $title ?>
        </h2>
    </div>
    <!-- End Title -->

    <!-- Message from action add, edit and delete plan -->
    <div class="col-12">
        <?= $this->session->flashdata('sMessage') ?>
    </div>
    <!-- End Message -->

    <!-- Content -->
    <?php foreach ($months as $mn) : ?>
        <!-- Months Card -->
        <div class="col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4>
                        <?= $mn['month_name'] ?>
                    </h4>    
                </div>
                <div class="card-body">
                    <!-- List Plan -->
                    <?php foreach ($splans as $pl) : ?>
                        <!-- IF Condition to print list plan IF same of month value -->
                        <?php if (intval($pl['month']) == $mn['id_month']) : ?>
                            <ol class="list-group">
                                <?php
                                    # $bgList to save plan list background class
                                    $bgList = '';
                                    # $now to save current time
                                    $now = time();
                                    # $exp to store the expired value which has been converted to the time data type
                                    $exp = strtotime($pl['expired']);
                                    
                                    # If condition to compare expired with current time
                                    if ($exp < $now) {
                                        $bgList = 'bg-secondary bg-opacity-10';
                                    }
                                ?>
                                <!-- List Plan -->
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start <?= $bgList ?>">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <?= $pl['plan'] ?>
                                        </div>
                                        <small class="font-monospace text-light fw-bold bg-secondary opacity-50 rounded">
                                            Exp.<?= $pl['expired'] ?>
                                        </small>
                                        <br>
                                        <span class="text-muted fst-italic">
                                            <?= $pl['description'] ?>
                                        </span>
                                    </div>
                                    <?php
                                        # $bgBadge to save badge background class
                                        $bgBadge = '';
                                        # Switch statement to specify badge background
                                        switch ($pl['label']) {
                                            case 'Very Important':
                                                $bgBadge = 'bg-danger';
                                                break;
                                            case 'Important':
                                                $bgBadge = 'bg-warning';
                                                break;
                                            case 'Normal':
                                                $bgBadge = 'bg-primary';
                                                break;
                                            default:
                                                $bgBadge;
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
                                    <div>
                                        <!-- Label Badge -->
                                        <div class="float-end">
                                            <span class="badge <?= $bgBadge ?> rounded-pill">
                                                <?= $pl['label'] ?>
                                            </span>
                                        </div>
                                        <!-- End Label Badge -->
                                        
                                        <!-- Status Badge -->
                                        <div class="float-end">
                                            <span class="badge-lg <?= $bgStatus ?> rounded-pill">
                                                <i class="<?= $status ?>"></i>
                                            </span>
                                        </div>
                                        <!-- End Status Badge -->
                                    </div>
                                </li>
                                <!-- End List Plan -->
                            </ol>
                        <?php endif ?>
                    <?php endforeach ?>
                    <!-- End List Plan -->
                </div>
            </div>
        </div>
        <!-- End Months Card -->
    <?php endforeach ?>
    <!-- End Content -->

    <!-- Button to Dashboard -->
    <div class="col-12 text-center">
        <a href="<?= site_url('plans/dashboard') ?>" type="button" class="btn btn-light btn-outline-dark mx-auto">
            Back to <i class="bi bi-house-fill"></i>
        </a>
    </div>
    <!-- End Button -->
</div>
<!-- End Success Plan Page -->