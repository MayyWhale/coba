<?= $this->extend($config->theme['panel'] . 'index') ?>
<?= $this->section('main') ?>
<div class="page-header">
    <h3 class="page-title">
        Edit Kriteria
    </h3>

</div>
<?= view('App\Views\Panel\Layout\Panel\_message_block') ?>

<div class="row">
    <div class="col grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" method="POST">
                    <div class="form-group">
                        <label for="nama">Nama Kriteria</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?? $item->nama ?>" placeholder="Nama Kriteria">
                    </div>
                    <div class="form-group">
                        <label for="kode">Kode Kriteria</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="<?= old('kode') ?? $item->kode ?>" placeholder="Kode Kriteria">
                    </div>

                    <!-- sub Kriteria -->
                    <h3>Sub Kriteria</h3>

                    <div class="repeater">
                        <div data-repeater-list="subKriteria-group">
                            <?php foreach ($subKriteria as $subKriteria) : ?>
                                <div data-repeater-item>
                                    <div class="row">
                                        <!-- id -->
                                        <input type="hidden" name="id" value="<?= $subKriteria->id ?>">
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="label" placeholder="Label" value="<?= $subKriteria->label ?>" required />
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="keterangan" placeholder="Keterangan" value="<?= $subKriteria->keterangan ?>" required />
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control bg-danger text-white" data-repeater-delete type="button" value="Delete" />
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                        <input class="mt-2 form-control bg-success text-white" data-repeater-create type="button" value="Add" />
                    </div>

                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                    <a href="<?= route_to('data-kriteria') ?>" class="btn btn-light">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>