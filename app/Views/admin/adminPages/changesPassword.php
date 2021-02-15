<?= $this->extend('admin/adminLayout/usersProfileLayout') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Changes Password</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a>Manage Admin</a></div>
                <div class="breadcrumb-item"><a>Manage Profile</a></div>
                <div class="breadcrumb-item">Changes Password</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Change Password</h2>
            <p class="section-lead">This page contains a form to change password.</p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0);" onclick="javascript:history.back()" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Go Back</a>
                        </div>
                        <div class="card-body">
                            <?= form_open('', 'id="form-changes-password"') ?>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Current Password</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <input type="password" name="cpassword" class="form-control" placeholder="Your Current Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <a type="button" id="showCurrentPassword"><i class="fas fa-eye-slash"></i></a>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="cpassword">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">New Password</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" placeholder="Your New Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <a type="button" id="showNewPassword"><i class="fas fa-eye-slash"></i></a>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="password">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="Passwords must have 6+ characters, at least 1 number, at least 1 uppercase and no whitespace"><i class="fas fa-question-circle"></i></button>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Repeat New Password</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <input type="password" name="rpassword" class="form-control" placeholder="Confirmation Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <a type="button" id="showRepeatPassword"><i class="fas fa-eye-slash"></i></a>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="rpassword">
                                        </div>
                                    </div>
                                    <small>Forgot your password ? Please log out of your account and select "Forgot Password" on the Log In Page.</small>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-primary" id="btn-submit" disabled>Save Changes</button>
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
    const inputCPassword = document.querySelector('[name="cpassword"]');
    const inputNPassword = document.querySelector('[name="password"]');
    const inputRPassword = document.querySelector('[name="rpassword"]');
    const validationForm = response => {
        if (response.error) {
            if (response.error.cpassword) {
                document.querySelector('#cpassword').innerHTML = response.error.cpassword;
                inputCPassword.classList.add('is-invalid');
            } else {
                document.querySelector('#cpassword').innerHTML = '';
                inputCPassword.classList.remove('is-invalid');
            }
            if (response.error.password) {
                document.querySelector('#password').innerHTML = response.error.password;
                inputNPassword.classList.add('is-invalid');
            } else {
                document.querySelector('#password').innerHTML = '';
                inputNPassword.classList.remove('is-invalid');
            }
            if (response.error.rpassword) {
                document.querySelector('#rpassword').innerHTML = response.error.rpassword;
                inputRPassword.classList.add('is-invalid');
            } else {
                document.querySelector('#rpassword').innerHTML = '';
                inputRPassword.classList.remove('is-invalid');
            }
        } else {
            document.querySelector('#cpassword').innerHTML = '';
            inputCPassword.classList.remove('is-invalid');
            document.querySelector('#password').innerHTML = '';
            inputNPassword.classList.remove('is-invalid');
            document.querySelector('#rpassword').innerHTML = '';
            inputRPassword.classList.remove('is-invalid');
        }
    }
    const disableButton = () => {
        if (inputCPassword.value == '' || inputNPassword.value == '' || inputRPassword.value == '') {
            document.querySelector('#btn-submit').setAttribute('disabled', true);
        } else {
            document.querySelector('#btn-submit').removeAttribute('disabled');
        }
    }
    inputCPassword.addEventListener('input', disableButton);
    inputNPassword.addEventListener('input', disableButton);
    inputRPassword.addEventListener('input', disableButton);

    const resetPassword = () => {
        inputCPassword.setAttribute('type', 'password');
        inputNPassword.setAttribute('type', 'password');
        inputRPassword.setAttribute('type', 'password');

        document.querySelector('#showCurrentPassword').innerHTML = '<i class="fas fa-eye-slash"></i>';
        document.querySelector('#showNewPassword').innerHTML = '<i class="fas fa-eye-slash"></i>';
        document.querySelector('#showRepeatPassword').innerHTML = '<i class="fas fa-eye-slash"></i>';
    }
    const showPassword = (show, idPassword) => {
        if (idPassword.getAttribute('type') == 'password') {
            show.innerHTML = '<i class="fas fa-eye"></i>';
            idPassword.setAttribute('type', 'text');
        } else {
            show.innerHTML = '<i class="fas fa-eye-slash"></i>';
            idPassword.setAttribute('type', 'password');
        }
    }
    document.querySelector('#showCurrentPassword').addEventListener('click', function() {
        showPassword(this, inputCPassword)
    })
    document.querySelector('#showNewPassword').addEventListener('click', function() {
        showPassword(this, inputNPassword)
    })
    document.querySelector('#showRepeatPassword').addEventListener('click', function() {
        showPassword(this, inputRPassword)
    })

    $(document).ready(function() {
        $('#form-changes-password').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '/admin/goChangesPassword',
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
                        validationForm(response);
                        $('#form-changes-password')[0].reset();
                    }
                    $('[name="csrf_test_name"]').val(response.csrfHash);
                },
                complete: function() {
                    $('#btn-submit').html('Save Changes');
                },
                error: function(err) {
                    console.log(err)
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>