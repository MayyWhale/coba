<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
    <!-- <a class="navbar-brand brand-logo" href="#!"><img src="<?= base_url('assets/purple') ?>/images/logo.svg" alt="logo" /></a> -->
    <a class="navbar-brand brand-logo-mini" href="#!"><img src="<?= base_url('assets/purple') ?>/images/logo-mini.svg" alt="logo" /></a>
    <a href="" class="navbar-brand brand-logo fw-bold">
        SPK AHP
    </a>
</div>
<div class="navbar-menu-wrapper d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                    <img src="<?= base_url('assets/purple') ?>/images/faces/face1.jpg" alt="image">
                    <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                    <p class="mb-1 text-black"><?= user()->email ?></p>
                </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="#">
                    <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
            </div>
        </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
    </button>
</div>