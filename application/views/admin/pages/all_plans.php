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
                        <h5 class="card-title">Datatables of All Plans</h5>
                        <p>List of all plans on My This Year Plan</p>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">#</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Plan</th>
                                    <th scope="col">Label</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Expired</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($plans as $pl) : ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $no++; ?>
                                        </th>
                                        <td>
                                            <?= $pl['id_user'] ?>
                                        </td>
                                        <td>
                                            <?= $pl['plan'] ?>
                                        </td>
                                        <td>
                                            <?= $pl['label'] ?>
                                        </td>
                                        <td>
                                            <?= $pl['created'] ?>
                                        </td>
                                        <td>
                                            <?= $pl['expired'] ?>
                                        </td>
                                        <td>
                                            <?= $pl['status'] ?>
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