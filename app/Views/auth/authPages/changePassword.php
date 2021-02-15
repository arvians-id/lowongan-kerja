<?= $this->extend('auth/authLayout/indexLayout') ?>
<?= $this->section('content') ?>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                    <div class="login-brand">
                        <img src="/template/stisla/assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Reset Password</h4>
                        </div>

                        <div class="card-body">
                            <p class="text-muted">Make your password secure</p>
                            <?= form_open('', 'id="form-forgot" role="form" method="post"') ?>
                            <div class="form-group"><label for="password2" class="d-block">New Password <button type="button" class="btn" data-toggle="tooltip" data-placement="right" title="Passwords must have 6+ characters, at least 1 number, at least 1 uppercase and no whitespace"><i class="fas fa-question-circle"></i></button></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" placeholder="Your Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a type="button" id="showPassword"><i class="fas fa-eye-slash"></i></a>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback" id="password">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password2" class="d-block">Password Confirmation</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="rpassword" placeholder="Repeat Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <a type="button" id="showRepeatPassword"><i class="fas fa-eye-slash"></i></a>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback" id="rpassword">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-submit" tabindex="4" disabled>Reset Password</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; Stisla 2018
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    // Declaration
    const password = document.querySelector('#password');
    const rpassword = document.querySelector('#rpassword');
    const btnSubmit = document.querySelector('#btn-submit');
    const inputPassword = document.querySelector('[name="password"]');
    const inputRPassword = document.querySelector('[name="rpassword"]');
    // Validation
    const validationForm = response => {
        if (response.error) {
            password.innerHTML = response.error.password;
            inputPassword.classList.add('is-invalid');
            rpassword.innerHTML = response.error.rpassword;
            inputRPassword.classList.add('is-invalid');
        } else {
            password.innerHTML = '';
            inputRPassword.classList.remove('is-invalid');
            rpassword.innerHTML = '';
            inputRPassword.classList.remove('is-invalid');
        }
    }
    // Disable Button
    const disableSubmit = () => {
        if (inputPassword.value == '' || inputRPassword.value == '') {
            btnSubmit.setAttribute('disabled', true);
        } else {
            btnSubmit.removeAttribute('disabled');
        }
    }
    inputPassword.addEventListener('input', disableSubmit);
    inputRPassword.addEventListener('input', disableSubmit);
    // Show Hide Password
    const showPassword = (show, idPassword) => {
        if (idPassword.getAttribute('type') == 'password') {
            idPassword.setAttribute('type', 'text');
            show.innerHTML = '<i class="fas fa-eye"></i>';
        } else {
            idPassword.setAttribute('type', 'password');
            show.innerHTML = '<i class="fas fa-eye-slash"></i>';
        }
    }
    document.querySelector('#showPassword').addEventListener('click', function() {
        showPassword(this, inputPassword);
    });
    document.querySelector('#showRepeatPassword').addEventListener('click', function() {
        showPassword(this, inputRPassword);
    })
    // Submit Form
    $(document).ready(function() {
        $('#form-forgot').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '/auth/resetpassword',
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
                            window.location.href = response.success;
                        }
                        validationForm(response);
                    }
                    $('[name="csrf_test_name"]').val(response.csrfHash);
                    disableSubmit();
                },
                complete: function() {
                    $('#btn-submit').html('Reset Password');
                },
                error: function(err) {
                    console.log(err);
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>