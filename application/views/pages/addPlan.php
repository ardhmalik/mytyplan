<div class="row justify-content-center">
    <!-- Title -->
    <div class="col-12 mt-3 mb-4">
        <h2 class="text-center">
            <?= $title ?>
        </h2>
    </div>
    <!-- End Title -->

    <?php
        // var_dump($user);
        // die;
    ?>

    <div class="col-sm-8 col-md-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="text-center">
                    Form <?= $title ?>
                </h4>
            </div>
            <div class="card-body">
                <form action="" method="post" class="mx-3 my-3">
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