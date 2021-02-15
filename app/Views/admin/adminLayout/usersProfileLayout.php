<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title; ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="/template/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/template/stisla/node_modules/bootstrap-social/bootstrap-social.css">
    <link rel="stylesheet" href="/template/stisla/node_modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="/template/stisla/node_modules/selectric/public/selectric.css">
    <!-- Izitoast -->
    <link rel="stylesheet" href="/node_modules/izitoast/dist/css/iziToast.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="/template/stisla/assets/css/style.css">
    <link rel="stylesheet" href="/template/stisla/assets/css/components.css">
</head>

<body>

    <div id="app">
        <div class="main-wrapper">

            <!-- Layout -->
            <?= $this->include('admin/adminLayout/layout/navbar') ?>
            <?= $this->include('admin/adminLayout/layout/sidebar') ?>

            <!-- Content -->
            <?= $this->renderSection('content') ?>

            <!-- Layout -->
            <?= $this->include('admin/adminLayout/layout/footer') ?>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="/template/stisla/assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="/template/stisla/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/template/stisla/node_modules/summernote/dist/summernote-bs4.js"></script>
    <script src="/template/stisla/node_modules/selectric/public/jquery.selectric.min.js"></script>
    <!-- Izitoast -->
    <script src="/node_modules/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Template JS File -->
    <script src="/template/stisla/assets/js/scripts.js"></script>
    <script src="/template/stisla/assets/js/custom.js"></script>
</body>

</html>