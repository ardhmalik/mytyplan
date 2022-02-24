<!-- Fail Plan Page -->
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
        <?= $this->session->flashdata('fail_message') ?>
    </div>
    <!-- End Message -->

    <!-- Content -->
    <?php foreach ($months as $mn) : ?>
        <!-- Months Card -->
        <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4>
                        <?= $mn['month_name'] ?>
                    </h4>    
                </div>
                <div class="card-body">
                    <!-- List Plan -->
                    <?php foreach ($fplans as $pl) : ?>
                        <!-- IF Condition to print list plan IF same of month value -->
                        <?php if (intval($pl['month']) == $mn['id_month']) : ?>
                            <ol class="list-group">
                                <?php
                                    # $list_bg to save plan list background class
                                    $list_bg = '';
                                    # $now to save current time
                                    $now = time();
                                    # $exp to store the expired value which has been converted to the time data type
                                    $exp = strtotime($pl['expired']);
                                    
                                    # If condition to compare expired with current time
                                    if ($exp < $now) {
                                        $list_bg = 'bg-secondary bg-opacity-10';
                                    }
                                ?>
                                <!-- List Plan -->
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start <?= $list_bg ?>">
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
                                        # $label_bg to save badge background class
                                        $label_bg = '';
                                        # Switch statement to specify badge background
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
    
                                        # Percabangan if untuk tampilan status
                                        $status_bg = '';
                                        # $status variable to save icon for status
                                        $status = '';
                                        # $now to save current time
                                        $now = time();
                                        # $exp to store the expired value which has been converted to the time data type
                                        $exp = strtotime($pl['expired']);
                                        # If condition to compare expired with current time
                                        if ($exp > $now) {
                                            # If TRUE, then status didn't display
                                            $status_bg = 'd-none';
                                        }
                                    ?>
                                    <div>
                                        <!-- Label Badge -->
                                        <div class="float-end">
                                            <span class="badge <?= $label_bg ?> rounded-pill">
                                                <?= $pl['label'] ?>
                                            </span>
                                        </div>
                                        <!-- End Label Badge -->
                                        
                                        <!-- Status Badge -->
                                        <div class="float-end">
                                            <span class="badge-lg <?= $status_bg ?> rounded-pill">
                                                <i class="fas fa-times-circle text-danger"></i>
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
        <a href="<?= site_url('dashboard') ?>" type="button" class="btn fw-bold btn-light btn-outline-dark mx-auto">
            Back to <i class="fa-solid fa-house"></i>
        </a>
    </div>
    <!-- End Button -->
</div>
<!-- End Fail Plan Page -->