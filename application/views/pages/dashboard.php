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
        <button class="btn fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#planAdd">
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
                                            <span class="text-muted fst-italic">
                                                <?= substr($pl['description'], 0, 20) . "..." ?>
                                            </span>
                                        </div>
                                        <?php
                                            # $badge_bg to save badge background class
                                            $badge_bg = '';
                                            # Switch statement to specify badge background
                                            switch ($pl['label']) {
                                                case 'Very Important':
                                                    $badge_bg = 'bg-danger';
                                                    break;
                                                case 'Important':
                                                    $badge_bg = 'bg-warning';
                                                    break;
                                                case 'Normal':
                                                    $badge_bg = 'bg-primary';
                                                    break;
                                                default:
                                                    $badge_bg;
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
                                        <div>
                                            <!-- Label Badge -->
                                            <div class="float-end">
                                                <span class="badge <?= $badge_bg ?> rounded-pill">
                                                    <?= $pl['label'] ?>
                                                </span>
                                            </div>
                                            <!-- End Label Badge -->

                                            <!-- Status Badge -->
                                            <div class="float-end">
                                                <span class="badge-lg <?= $status_bg ?> rounded-pill">
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