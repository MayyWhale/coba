<?= $this->extend($config->theme['panel'] . 'index') ?>
<?= $this->section('main') ?>

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-calculator-variant"></i>
        </span> Perhitungan
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>
<div class="row mb-4">
    <div class="col">
        <div class="card" id="content-wrapper">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-header-text">Hasil Perhitungan</div>
                    <div class="">
                        <?php if (user()->step_kriteria > 0) : ?>
                        <a class="btn btn-danger" href="<?= route_to('hitung-reset') ?>" role="button">Reset</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <?php if ($result) : ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Kriteria Utama
                                </div>
                                <div class="card-body p-2">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">.</th>
                                                    <?php foreach ($result['main']->features as $f) : ?>
                                                    <th scope="col"><?= $f->nama ?></th>
                                                    <?php endforeach ?>
                                                    <th scope="col" class="text-center"
                                                        colspan="<?= $result['main']->ordo ?>">Hasil Normalisasi</th>
                                                    <th scope="col">Jumlah</th>
                                                    <th scope="col">Prioritas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($y = 0; $y < $result['main']->ordo; $y++) : ?>
                                                <tr>
                                                    <th scope="row"><?= $result['main']->features[$y]->nama ?></th>
                                                    <?php for ($x = 0; $x < $result['main']->ordo; $x++) : ?>
                                                    <td><?= $result['main']->pairwiseMatrix->toArray()[$y][$x] ?></td>
                                                    <?php endfor ?>
                                                    <?php for ($x = 0; $x < $result['main']->ordo; $x++) : ?>
                                                    <td><?= $result['main']->getNormalizeMatrix()->toArray()[$y][$x] ?>
                                                    </td>
                                                    <?php endfor ?>
                                                    <td><?= $result['main']->rowSum[$y] ?></td>
                                                    <td><?= $result['main']->getPriority()[$y] ?></td>
                                                </tr>
                                                <?php endfor ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($result['sub'] as $sub) : ?>
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Sub Kriteria <?= $sub->features[0]->kriteria->nama ?>
                                </div>
                                <div class="card-body p-2">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">.</th>
                                                    <?php foreach ($sub->features as $f) : ?>
                                                    <th scope="col"><?= $f->keterangan ?></th>
                                                    <?php endforeach ?>
                                                    <th scope="col" class="text-center" colspan="<?= $sub->ordo ?>">
                                                        Hasil Normalisasi</th>
                                                    <th scope="col">Jumlah</th>
                                                    <th scope="col">Prioritas</th>
                                                    <th scope="col">Prioritas Sub Kriteria</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($y = 0; $y < $sub->ordo; $y++) : ?>
                                                <tr>
                                                    <th scope="row"><?= $sub->features[$y]->keterangan ?></th>
                                                    <?php for ($x = 0; $x < $sub->ordo; $x++) : ?>
                                                    <td><?= $sub->pairwiseMatrix->toArray()[$y][$x] ?></td>
                                                    <?php endfor ?>
                                                    <?php for ($x = 0; $x < $sub->ordo; $x++) : ?>
                                                    <td><?= $sub->getNormalizeMatrix()->toArray()[$y][$x] ?></td>
                                                    <?php endfor ?>
                                                    <td><?= $sub->rowSum[$y] ?></td>
                                                    <td><?= $sub->getPriority()->main[$y] ?></td>
                                                    <td><?= $sub->getPriority()->sub[$y] ?></td>
                                                </tr>
                                                <?php endfor ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <span
                                        class="badge rounded-pill text-bg-<?= $sub->getConstRatio()->consistency ? 'success' : 'danger' ?> w-100 p-2">Rasio
                                        Konsistensi : <?= $sub->getConstRatio()->constRatioVal ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                NB : Jika Rasio Konsistensinya diatas 0.1 Artinya ada perhitungan yang kurang tepat
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <form class="forms-sample" id="form-hitung" method="POST">
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="kode">Kode Jurusan</label>
                            <span class="badge text-bg-primary">sama penting</span>
                            <label for="kode">Kode Jurusan</label>
                        </div>
                        <input type="range" class="form-range" min="-4" max="4" id="rangeku" id="rangeku">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>