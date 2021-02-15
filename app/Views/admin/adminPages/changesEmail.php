<?= $this->extend('admin/adminLayout/usersProfileLayout') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Changes Email</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a>Manage Admin</a></div>
                <div class="breadcrumb-item"><a>Manage Profile</a></div>
                <div class="breadcrumb-item">Changes Email</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Change Email</h2>
            <p class="section-lead">This page contains a form to modify an email.</p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0);" onclick="javascript:history.back()" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Go Back</a>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata()) : ?>
                                <div class="alert alert-<?= session()->getFlashdata('error') ? 'warning' : 'success' ?> alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ? session()->getFlashdata('error') : session()->getFlashdata('success') ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif ?>
                            <?= form_open('/admin/goChangesEmail', 'id="form-changes-email"') ?>
                            <div class="form-group row">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Current Email</label>
                                <div class="col-sm-12 col-md-7">
                                    <p><?= censoredEmail($sessUser['email']) ?>&nbsp;&nbsp; <small class="text-primary"><i class="fas fa-check-circle"></i> Verified</small></p>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">New Email</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" name="email" class="form-control" placeholder="Your New Email">
                                    <div class="invalid-feedback" id="email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Your Password</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" placeholder="Confirmation Your Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <a type="button" id="showPassword"><i class="fas fa-eye-slash"></i></a>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-primary" id="btn-submit" disabled>Send Verification</button>
                                </div>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    const inputEmail = document.querySelector('[name="email"]');
    const inputPassword = document.querySelector('[name="password"]');

    const validationForm = response => {
        if (response.error) {
            if (response.error.email) {
                document.querySelector('#email').innerHTML = response.error.email;
                inputEmail.classList.add('is-invalid');
            } else {
                document.querySelector('#email').innerHTML = '';
                inputEmail.classList.remove('is-invalid');
            }
            if (response.error.password) {
                document.querySelector('#password').innerHTML = response.error.password;
                inputPassword.classList.add('is-invalid');
            } else {
                document.querySelector('#password').innerHTML = '';
                inputPassword.classList.remove('is-invalid');
            }
        } else {
            document.querySelector('#email').innerHTML = '';
            inputEmail.classList.remove('is-invalid');
            document.querySelector('#password').innerHTML = '';
            inputPassword.classList.remove('is-invalid');
        }
    }
    document.querySelector('#showPassword').addEventListener('click', function() {
        if (inputPassword.getAttribute('type') == 'text') {
            this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            inputPassword.setAttribute('type', 'password');
        } else {
            this.innerHTML = '<i class="fas fa-eye"></i>';
            inputPassword.setAttribute('type', 'text');
        }
    })
    const disableButton = () => {
        if (inputEmail.value == '' || inputPassword.value == '') {
            document.querySelector('#btn-submit').setAttribute('disabled', true);
        } else {
            document.querySelector('#btn-submit').removeAttribute('disabled');
        }
    }
    inputEmail.addEventListener('input', disableButton);
    inputPassword.addEventListener('input', disableButton);

    const resetPassword = () => {
        inputPassword.setAttribute('type', 'password');

        document.querySelector('#showPassword').innerHTML = '<i class="fas fa-eye-slash"></i>';
    }

    $(document).ready(function() {
        $('#form-changes-email').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '/admin/goChangesEmail',
                method: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#btn-submit').attr('disabled', true);
                    $('#btn-submit').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>`);
                },
                success: function(response) {
                    if (response.error) {
                        validationForm(response);
                    } else {
                        if (response.blocked) {
                            iziToast.error({
                                timeout: 7000,
                                title: 'Error',
                                message: response.blocked,
                                position: 'topRight'
                            });
                        } else if (response.success) {
                            iziToast.success({
                                timeout: 7000,
                                title: 'Success',
                                message: response.success,
                                position: 'topRight'
                            });
                        }
                        resetPassword();
                        $('#form-changes-email')[0].reset();
                        validationForm(response);
                    }
                    $('[name="csrf_test_name"]').val(response.csrfHash);
                },
                complete: function() {
                    $('#btn-submit').html('Send Verification');
                },
                error: function(err) {
                    console.log(err)
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>