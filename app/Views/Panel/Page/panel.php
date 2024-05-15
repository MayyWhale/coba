<?= $this->extend($config->theme['panel'] . 'index') ?>
<?= $this->section('main') ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>
<?php if (in_groups('Admin')) : ?>
    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="<?= base_url('assets/purple') ?>/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Jurusan <i class="mdi mdi-account-multiple"></i>
                    </h4>
                    <h2 class="mb-5">15</h2>
                    <h6 class="card-text">Total Jurusan</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="<?= base_url('assets/purple') ?>/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Kriteria <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">1</h2>
                    <h6 class="card-text">Total Kriteria</h6>
                </div>
            </div>
        </div>
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="<?= base_url('assets/purple') ?>/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total totalUser <i class="mdi mdi-account-key"></i>
                    </h4>
                    <h2 class="mb-5"></h2>
                    <h6 class="card-text">Total User</h6>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-center">
                    <div class="">List Alternatif <span class="fw-bold">(Jurusan)</span></div>
                    <?php if ($alternatif) : ?>
                        <button class="btn btn-primary" id="pilihJurusanButton">
                            <i class="mdi mdi-account-multiple-plus"></i>
                        </button>
                    <?php endif ?>
                </div>

            </div>
            <div class="card-body p-4">
                <?php if ($alternatif) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Kode</th>
                                    <?php if ($kriteriaDone) : ?>
                                        <th scope="col">Input Nilai</th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1 ?>
                                <?php foreach ($alternatif as $j) : ?>
                                    <tr>
                                        <th scope="row"><?= $num++ ?></th>
                                        <td><?= $j->jurusan->nama ?></td>
                                        <td><?= $j->jurusan->kode ?></td>
                                        <?php if ($kriteriaDone) : ?>
                                            <?php if (isset($j->nilai)) : ?>
                                                <td><span class="badge rounded-pill text-bg-success"><i class="mdi mdi-check"></i></span>
                                                    <!-- <a href="#!" class="badge rounded-pill text-bg-warning calc-button" id="<?= $j->id ?>">
                                                        <i class="mdi mdi-circle-edit-outline"></i></a>
                                                   
                                                    <a href="#!" class="badge rounded-pill text-bg-danger delete-button" id="<?= $j->id ?>">
                                                        <i class="mdi mdi-delete"></i></a> -->
                                                </td>
                                            <?php else : ?>
                                                <td><a href="#!" class="btn btn-warning btn-sm p-2 calc-button" id="<?= $j->id ?>"><i class="mdi mdi-list-status"></i></a></td>
                                            <?php endif ?>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                <?php else : ?>
                    <div class="text-center">
                        <div class="alert alert-primary" role="alert">
                            Anda belum memilih Jurusan yang di inginkan, silahkan pilih Jurusan terlebih dahulu
                        </div>
                        <button class="btn btn-primary" id="pilihJurusanButton">Pilih Jurusan</button>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<?php if ($result) : ?>
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Rekomendasi Alternatif
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ranking</th>
                                    <th scope="col">Nama</th>
                                    <?php foreach ($kriteria['main']->features as $main) : ?>
                                        <th scope="col"><?= $main->nama ?></th>
                                    <?php endforeach ?>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1 ?>
                                <?php foreach ($result as $r) : ?>
                                    <tr>
                                        <th scope="row"><span class="badge rounded-pill text-bg-success"><?= $num++ ?></span>
                                        </th>
                                        <td><?= $r['nama'] ?></td>
                                        <?php foreach ($r['nilai'] as $nilai) : ?>
                                            <td><?= $nilai ?></td>
                                        <?php endforeach ?>
                                        <td><?= $r['total'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">List Kriteria</div>
                    <div class="">
                        <?php if (user()->step_kriteria < 10) : ?>
                            <a class="btn btn-primary" href="<?= route_to('hitung') ?>" role="button">Hitung</a>
                        <?php else : ?>
                            <a class="btn btn-success" href="<?= route_to('hitung') ?>" role="button">Detail</a>
                        <?php endif ?>
                        <?php if (user()->step_kriteria > 0) : ?>
                            <a class="btn btn-danger" href="<?= route_to('hitung-reset') ?>" role="button">Reset</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <?php if ($kriteria) : ?>
                        <?php foreach ($kriteria['main']->features as $main) : ?>
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        (<?= $main->kode ?>) <?= $main->nama ?>
                                    </div>
                                    <div class="card-body p-2">
                                        <?php if ($main->sub) : ?>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">No</th>
                                                            <th scope="col">Label</th>
                                                            <th scope="col">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $num = 1 ?>
                                                        <?php foreach ($main->sub as $sub) : ?>
                                                            <tr>
                                                                <th scope="row"><?= $num++ ?></th>
                                                                <td><?= $sub->label ?></td>
                                                                <td><?= $sub->keterangan ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else : ?>
                                            <div class="alert alert-primary" role="alert">
                                                Belum ada sub kriteria pada kriteria ini, silahkan hubungi admin
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <div class="text-center">
                            <div class="alert alert-primary" role="alert">
                                Anda belum melakukan akumulasi kriteria, silahkan akumulasikan kriteria terlebih dahulu
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>