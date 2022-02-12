<!-- Dashboard Page -->
<div class="row justify-content-center">
    <!-- Title -->
    <div class="col-12 mt-3 mb-4">
        <h2 class="text-center">
            <?= $title ?>
        </h2>
    </div>
    <!-- End Title -->

    <!-- Button Add New Plan -->
    <div class="d-flex flex-row-reverse mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planAdd">
            <i class="far fa-calendar-plus"></i> | New Plan
        </button>
    </div>
    <!-- End Button Add New Plan -->
    
    <!-- Message from action add, edit and delete plan -->
    <div class="col-12">
        <?= $this->session->flashdata('message') ?>
    </div>
    <!-- End Message -->

    <!-- Content -->
    <?php foreach ($months as $mn) : ?>
        <!-- Months Card -->
        <div class="col-sm-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <!-- Card Header -->
                <div class="card-header">
                    <h4>
                        <?= $mn['month_name'] ?>
                    </h4>    
                </div>
                <!-- End Card Header -->

                <!-- Card Body -->
                <div class="card-body">
                    <!-- List Plan -->
                    <?php foreach ($plans as $pl) : ?>
                        <!-- IF Condition to print list plan IF same of month value -->
                        <?php if (intval($pl['month']) == $mn['id_month']) : ?>
                            <ol class="list-group">
                                <!-- Link to modal detail plan -->
                                <a type="button" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#plan<?= $pl['id_plan'] ?>">
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
                                                    $bgStatus = 'd-none';
                                                } elseif ($pl['status'] == 1) {
                                                    # If status value is 1, then display check icon dan green color
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
                                </a>
                            </ol>
                        <?php endif ?>
                    <?php endforeach ?>
                    <!-- End List Plan -->
                </div>
                <!-- Card Body -->
            </div>
        </div>
        <!-- End Months Card -->
    <?php endforeach ?>
    <!-- End Content -->
</div>
<!-- End Dashboard Page -->