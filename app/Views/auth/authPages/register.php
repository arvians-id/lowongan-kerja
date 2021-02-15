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
                            <h4>Register</h4>
                        </div>
                        <div class="card-body">
                            <?= form_open('', 'id="form-registration" role="form" method="post"') ?>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username">
                                <div class="invalid-feedback" id="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email">
                                <div class="invalid-feedback" id="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="password" class="d-block">Password <span data-toggle="tooltip" data-placement="right" title="Passwords must have 6+ characters, at least 1 number, at least 1 uppercase and no whitespace"><i class="fas fa-question-circle"></i></span></label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" data-indicator="pwindicator" name="password" placeholder="Password">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <a type="button" id="showPassword"><i class="fas fa-eye-slash"></i></a>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" id="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password2" class="d-block">Password Confirmation </label>
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
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="customCheckRegister" class="custom-control-input" id="customCheckRegister">
                                    <label class="custom-control-label" for="customCheckRegister">I agree with the terms and conditions</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-submit" disabled>Create Account</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Have already an account? <a href="/auth">Login Here</a><br>
                        Haven't received the email? <a href="/auth/verification">Click Here</a>
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
    const inputUsername = document.querySelector('[name="username"]');
    const inputEmail = document.querySelector('[name="email"]');
    const inputPassword = document.querySelector('[name="password"]');
    const inputRPassword = document.querySelector('[name="rpassword"]');

    // Validation
    const validationForm = response => {
        if (response.error.username) {
            document.querySelector('#username').innerHTML = response.error.username;
            inputUsername.classList.add('is-invalid');
        } else {
            document.querySelector('#username').innerHTML = '';
            inputUsername.classList.remove('is-invalid');
        }
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
        if (response.error.rpassword) {
            document.querySelector('#rpassword').innerHTML = response.error.rpassword;
            inputRPassword.classList.add('is-invalid');
        } else {
            document.querySelector('#rpassword').innerHTML = '';
            inputRPassword.classList.remove('is-invalid');
        }
    }
    const validationSuccessForm = response => {
        document.querySelector('#username').innerHTML = '';
        inputUsername.classList.remove('is-invalid');
        document.querySelector('#email').innerHTML = '';
        inputEmail.classList.remove('is-invalid');
        document.querySelector('#password').innerHTML = '';
        inputPassword.classList.remove('is-invalid');
        document.querySelector('#rpassword').innerHTML = '';
        inputRPassword.classList.remove('is-invalid');
    }

    // Disable Button
    const disableSubmit = () => {
        if (inputUsername.value == '' || inputEmail.value == '' || inputPassword.value == '' || inputRPassword.value == '') {
            document.querySelector('#btn-submit').setAttribute('disabled', true);
        } else {
            document.querySelector('#btn-submit').removeAttribute('disabled');
        }
    }
    inputUsername.addEventListener('input', disableSubmit);
    inputEmail.addEventListener('input', disableSubmit);
    inputPassword.addEventListener('input', disableSubmit);
    inputRPassword.addEventListener('input', disableSubmit);

    // Show Hide Password
    const resetPassword = () => {
        inputPassword.setAttribute('type', 'password');
        document.querySelector('#showPassword').innerHTML = '<i class="fas fa-eye-slash"></i>';
        inputRPassword.setAttribute('type', 'password');
        document.querySelector('#showRepeatPassword').innerHTML = '<i class="fas fa-eye-slash"></i>';
    }
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
    })
    document.querySelector('#showRepeatPassword').addEventListener('click', function() {
        showPassword(this, inputRPassword);
    })
    // Submit Form
    $(document).ready(function() {
        $('#form-registration').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '/auth/register',
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
                            resetPassword();
                            $('#form-registration')[0].reset();
                        }
                        validationSuccessForm(response);
                    }
                    $('[name="csrf_test_name"]').val(response.csrfHash);
                    disableSubmit()
                },
                complete: function() {
                    $('#btn-submit').html('Create account');
                },
                error: function(err) {
                    console.log(err)
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>