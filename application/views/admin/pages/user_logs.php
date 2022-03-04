<div id="main" class="main">
    <div class="pagetitle">
        <h1><?= $title ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('admin_dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Datatables of User Logs Activity</h5>
                        <p>List of user logs activity on My This Year Plan</p>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Times</th>
                                    <th scope="col">Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($logs as $log) : ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $no++; ?>
                                        </th>
                                        <td>
                                            <?= $log['id_user'] ?>
                                        </td>
                                        <td>
                                            <?= $log['action'] ?>
                                        </td>
                                        <td>
                                            <?= $log['content'] ?>
                                        </td>
                                        <td>
                                            <?= $log['times'] ?>
                                        </td>
                                        <td>
                                            <?= $log['activity'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>