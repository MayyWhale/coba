<?= $this->extend($config->theme['panel'] . 'index') ?>
<?= $this->section('main') ?>
<div class="page-header">
    <h3 class="page-title">
        Data Pengguna
    </h3>

</div>
<?= view('App\Views\Panel\Layout\Panel\_message_block') ?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4 class="card-title">Data Pengguna</h4>
                    </div>
                    <div class="col-md-6">
                        <a href="#!" class="btn btn-primary btn-sm float-end" id="addUserButton"><i class="mdi mdi-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="datatables-init">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($items as $item) : ?>
                                <?php $roles = $item->getRoles(); ?>
                                <?php foreach ($roles as $id => $role) {
                                    $role = [
                                        'role_id' => $id,
                                        'role_name' => $role,
                                    ];
                                } ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $item->email ?></td>
                                    <td><?= $item->username ?></td>
                                    <td><?= $role['role_name'] ?> </td>
                                    <td>
                                        <a id="<?= $item->id ?>" class="btn btn-primary btn-sm edit-button"><i class="mdi mdi-pencil"></i></a>

                                        <a href="<?= route_to('data-user-delete',$item->id) ?>" class="btn btn-danger btn-sm" id="deleteUserButton" data-id="<?= $item->id ?>"><i class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>