<?=$this->extend($config->theme['panel'] . 'index')?>
<?=$this->section('main')?>
<div class="page-header">
    <h3 class="page-title">
        Data Jurusan
    </h3>

</div>
<?=view('App\Views\Panel\Layout\Panel\_message_block')?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4 class="card-title">Data Jurusan</h4>
                    </div>
                    <div class="col-md-6">
                        <a href="#!" class="btn btn-primary btn-sm float-end" id="addJurusanButton"><i
                                class="mdi mdi-plus"></i> Tambah</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="datatables-init">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jurusan</th>
                                <th>Kode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
foreach ($items as $item): ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td><?=$item->nama?></td>
                                <td><?=$item->kode?></td>
                                <td>
                                    <a href="#!" class="btn btn-warning btn-sm edit-button" id="<?= $item->id ?>"><i
                                            class="mdi mdi-pencil"></i></a>
                                    <a href="<?=route_to('data-jurusan-delete', $item->id)?>"
                                        class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                            <?php endforeach?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?=$this->endSection()?>