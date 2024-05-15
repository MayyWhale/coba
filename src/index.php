<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Codeigniter 4 &amp; App Theme">
    <meta name="author" content="MrFrost">
    <meta name="keywords" content="codeigniter, bootstrap, bootstrap 5, theme, responsive, ui kit, web">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <title>Panel</title>
    <script>
    const page = '<?= $page ?? 'main' ?>';
    const baseurl = '<?= base_url() ?>/';
    </script>
    <!-- Assets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/css/perfect-scrollbar.min.css"
        integrity="sha512-ygIxOy3hmN2fzGeNqys7ymuBgwSCet0LVfqQbWY10AszPMn2rB9JY0eoG0m1pySicu+nvORrBmhHVSt7+GI9VA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- datatable -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/purple') ?>/css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets') ?>/css/main.css">
</head>

<style>
.preloader {
    width: 100%;
    height: 100%;
    top: 0px;
    position: fixed;
    z-index: 99999;
    background: #fff;
}

.center {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.wave {
    width: 5px;
    height: 100px;
    background: linear-gradient(45deg, purple, #fff);
    margin: 10px;
    animation: wave 1s linear infinite;
    border-radius: 20px;
}

.wave:nth-child(2) {
    animation-delay: 0.1s;
}

.wave:nth-child(3) {
    animation-delay: 0.2s;
}

.wave:nth-child(4) {
    animation-delay: 0.3s;
}

.wave:nth-child(5) {
    animation-delay: 0.4s;
}

.wave:nth-child(6) {
    animation-delay: 0.5s;
}

.wave:nth-child(7) {
    animation-delay: 0.6s;
}

.wave:nth-child(8) {
    animation-delay: 0.7s;
}

.wave:nth-child(9) {
    animation-delay: 0.8s;
}

.wave:nth-child(10) {
    animation-delay: 0.9s;
}

@keyframes wave {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1);
    }

    100% {
        transform: scale(0);
    }
}
</style>

<body>
    <?= view($config->theme['panel'] . 'preloader') ?>
    <div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <?= view($config->theme['panel'] . 'navbar') ?>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <?= view($config->theme['panel'] . 'sidebar') ?>
            </nav>
            <div class="main-panel">
                <div class="content-wrapper">
                    <?= $this->renderSection('main') ?>
                </div>
                <footer class="footer">
                    <?= view($config->theme['panel'] . 'footer') ?>
                </footer>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Judul Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Isi Modal</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Assets -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"
        integrity="sha512-X41/A5OSxoi5uqtS6Krhqz8QyyD8E/ZbN7B4IaBSgqPLRbWVuXJXr9UwOujstj71SoVxh5vxgy7kmtd17xrJRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"
        integrity="sha256-cHVO4dqZfamRhWD7s4iXyaXWVK10odD+qp4xidFzqTI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"
        integrity="sha512-3j3VU6WC5rPQB4Ld1jnLV7Kd5xr+cq9avvhwqzbH/taCRNURoeEpoPBK9pDyeukwSxwRPJ8fDgvYXd6SkaZ2TA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- datatable -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/purple') ?>/js/off-canvas.js"></script>
    <script src="<?= base_url('assets/purple') ?>/js/hoverable-collapse.js"></script>
    <script src="<?= base_url('assets/purple') ?>/js/todolist.js"></script>
    <script src="<?= base_url('assets/purple') ?>/js/panel.js"></script>
    <script src="<?= base_url('src') ?>/app.js" type="module"></script>

</body>

</html>