<ul class="nav">
    <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
            <div class="nav-profile-image">
                <img src="<?= base_url('assets/purple') ?>/images/faces/face1.jpg" alt="profile">
                <span class="login-status online"></span>
                <!--change to offline or busy as needed-->
            </div>
            <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">
                    <?= user()->username ?>
                </span>
                <span class="text-secondary text-small">
                    <?php
                    $role = user()->getRoles();
                    foreach ($role as $key => $value) {
                        echo $value;
                    }
                    ?>
                </span>
            </div>
            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= route_to('') ?>">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-home menu-icon"></i>
        </a>
    </li>


    <?php if (in_groups('Admin')) : ?>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#data-master" aria-expanded="false" aria-controls="data-master">
                <span class="menu-title">Master Data</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-file menu-icon"></i>
            </a>
            <div class="collapse" id="data-master">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= route_to('data-jurusan') ?>"> Jurusan </a></li>

                    <li class="nav-item"> <a class="nav-link" href="<?= route_to('data-kriteria') ?>"> Kriteria </a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="<?= route_to('data-alternatif') ?>"> Alternatif </a></li> -->
                </ul>
            </div>
        </li>
    <?php endif ?>
    <?php if (in_groups('User')) : ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= route_to('hitung') ?>">
                <span class="menu-title">Perhitungan</span>
                <i class="mdi mdi-calculator-variant menu-icon"></i>
            </a>
        </li>
    <?php endif ?>
    <!-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="laporan">
            <span class="menu-title">Laporan</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-file menu-icon"></i>
        </a>
    </li> -->
        <?php if (in_groups('Admin')) : ?>

    <li class="nav-item">
        <a class="nav-link" href="<?= route_to('data-user') ?>">
            <span class="menu-title">Pengguna</span>
            <i class="mdi mdi-account menu-icon"></i>
        </a>
    </li>
    <?php endif?>
    <li class="nav-item sidebar-actions">
        <span class="nav-link text-center">
            <a href="<?= route_to('logout') ?>" class="btn btn-block btn-lg btn-gradient-primary mt-4" role="button">Logout</a>
        </span>
    </li>
</ul>