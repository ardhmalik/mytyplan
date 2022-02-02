<!-- User Logs -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mt-3 mb-4">
            <h2 class="text-center">
                <?= $title ?>
            </h2>
        </div>
        <div class="col-12 table-responsive">
            <table class="table table-hover align-middle caption-top">
                <caption>
                    List of <?= $user['username'] ?> Logs
                </caption>
                <thead class="text-center">
                    <tr class="table-dark">
                        <th scope="col">Times</th>
                        <th scope="col">Action</th>
                        <th scope="col">Content</th>
                        <th scope="col">Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log) : ?>
                    <tr  class="text-center">
                        <td class="fst-italic">
                            <?= $log['times'] ?>
                        </td>
                        <td class="fw-bold">
                            <?= $log['action'] ?>
                        </td>
                        <td class="text-start">
                            <?= $log['content'] ?>
                        </td>
                        <td class="text-muted">
                            <?= $log['activity'] ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="col-12 text-center">
                <a href="<?= site_url('plans/dashboard') ?>" type="button" class="btn btn-light btn-outline-dark mx-auto">
                    Back to <i class="bi bi-house-fill"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End User Logs -->