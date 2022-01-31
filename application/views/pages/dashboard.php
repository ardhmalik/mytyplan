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
    // var_dump($plans); 
    // die; 
    ?>

    <!-- Button Add New Plan -->
    <div class="d-flex flex-row-reverse mb-3">
        <a href="<?= site_url('plans/add') ?>" type="button" value="submit" class="btn btn-primary">
            New Plan
        </a>
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
                                <a href="#" class="text-decoration-none">
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">
                                                <?= $pl['plan'] ?>
                                            </div>
                                            <?= $pl['description'] ?>
                                        </div>
                                        <?php
                                            $bg = '';
                                            switch ($pl['label']) {
                                                case 'Very Important':
                                                    $bg = 'bg-danger';
                                                    break;
                                                case 'Important':
                                                    $bg = 'bg-warning';
                                                    break;
                                                case 'Normal':
                                                    $bg = 'bg-primary';
                                                    break;
                                                default:
                                                    $bg;
                                                    break;
                                            }
                                        ?>
                                        <span class="badge <?= $bg ?> rounded-pill">
                                            <?= $pl['label'] ?>
                                        </span>
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