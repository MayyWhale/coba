<?= $this->extend($config->theme['panel'] . 'index') ?>
<?= $this->section('main') ?>
<div class="page-header">
    <h3 class="page-title">
        Edit Alternatif
    </h3>

</div>
<?= view('App\Views\Panel\Layout\Panel\_message_block') ?>

<div class="row">
    <div class="col grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST">
                    <div class="form-group">
                        <label for="nama">Nama Alternatif</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?? $item->nama ?>" placeholder="Nama Alternatif">
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode Alternatif</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="<?= old('kode') ?? $item->kode ?>" placeholder="Kode Alternatif">
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                    <a href="<?= route_to('data-alternatif') ?>" class="btn btn-light">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>