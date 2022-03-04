<div id="main" class="main">
    <div class="pagetitle">
        <h1><?= $title ?></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('admin_dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Datatables of All User Account</h5>
                        <p>List of all user account on My This Year Plan</p>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($users as $usr) : ?>
                                    <tr>
                                        <th scope="row">
                                            <?= $no++; ?>
                                        </th>
                                        <td>
                                            <?= $usr['username'] ?>
                                        </td>
                                        <td>
                                            <?= $usr['email'] ?>
                                        </td>
                                        <td>
                                            <?= $usr['avatar'] ?>
                                        </td>
                                        <td>
                                            <?= $usr['joined'] ?>
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