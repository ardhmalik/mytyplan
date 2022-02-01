<div class="row justify-content-center">
    <!-- Title -->
    <div class="col-12 mt-3 mb-4">
        <h2 class="text-center">
            <?= $title ?>
        </h2>
    </div>
    <!-- End Title -->

    <?php 
    // $pswd = "Khakasi123";
    // $hash = password_hash($pswd, PASSWORD_DEFAULT);
    // echo $hash;
    // $new = [1, 2, 4, 5];
    // $jml = $pl;
    // $brp = count([$jml]);
    // $datetime = time();
    // $result = date('d-m-Y H:i:s', $datetime);
    // $result = strtotime($datetime);
    // var_dump($plans); 
    // die; 
    ?>

    <!-- Button Add New Plan -->
    <div class="d-flex flex-row-reverse mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planAdd">
            New Plan
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
        <div class="col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header">
                    <h4>
                        <?= $mn['month_name'] ?>
                    </h4>    
                </div>
                <div class="card-body">
                    <!-- List Plan -->
                    <?php foreach ($plans as $pl) : ?>
                        <?php if (intval($pl['month']) == $mn['id_month']) : ?>
                            <ol class="list-group">
                                <a type="button" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#plan<?= $pl['id_plan'] ?>">
                                    <?php
                                        $bgList = '';
                                        $now = time();
                                        $exp = strtotime($pl['expired']);
                                        if ($exp < $now) {
                                            $bgList = 'bg-secondary bg-opacity-10';
                                        }
                                    ?>
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
                                            $bgBadge = '';
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
                                            <div class="float-end">
                                                <span class="badge <?= $bgBadge ?> rounded-pill">
                                                    <?= $pl['label'] ?>
                                                </span>
                                            </div>
                                            <div class="float-end">
                                                <span class="badge-lg <?= $bgStatus ?> rounded-pill">
                                                    <i class="<?= $status ?>"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                </a>
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
</div>