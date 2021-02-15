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
                            <h4>Login</h4>
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
                            <?= form_open('', 'id="form-login" role="form" method="post"') ?>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Your Email" tabindex="1">
                                <div class="invalid-feedback" id="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                    <div class="float-right">
                                        <a href="/auth/forgot" class="text-small">
                                            Forgot Password?
                                        </a>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" placeholder="Your Password" tabindex="2">
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
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="rememberme" class="custom-control-input" tabindex="3" id="rememberme">
                                    <label class="custom-control-label" for="rememberme">Remember Me</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-submit" tabindex="4" disabled>Login Now</button>
                            </div>
                            <?= form_close() ?>
                            <div class="text-center mt-4 mb-3">
                                <div class="text-job text-muted">Login With Social</div>
                            </div>
                            <div class="row sm-gutters">
                                <div class="col-6">
                                    <a class="btn btn-block btn-social btn-facebook">
                                        <span class="fab fa-facebook"></span> Facebook
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-block btn-social btn-twitter">
                                        <span class="fab fa-twitter"></span> Twitter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Don't have an account? <a href="/auth/registration">Create One</a><br>
                        Forgot password? <a href="/auth/forgot">Click Here</a>
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
    const inputEmail = document.querySelector('[name="email"]');
    const inputPassword = document.querySelector('[name="password"]');
    const btnSubmit = document.querySelector('#btn-submit');

    const validationForm = response => {
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
    }
    const validationSuccessForm = response => {
        document.querySelector('#email').innerHTML = '';
        inputEmail.classList.remove('is-invalid');
        document.querySelector('#password').innerHTML = '';
        inputPassword.classList.remove('is-invalid');
    }
    const disableSubmit = () => {
        if (inputEmail.value == '' || inputPassword.value == '') {
            btnSubmit.setAttribute('disabled', true);
        } else {
            btnSubmit.removeAttribute('disabled');
        }
    }
    inputEmail.addEventListener('input', disableSubmit);
    inputPassword.addEventListener('input', disableSubmit);


    const resetPassword = () => {
        inputPassword.setAttribute('type', 'password');
        document.querySelector('#showPassword').innerHTML = '<i class="fas fa-eye-slash"></i>';
    }

    document.querySelector('#showPassword').addEventListener('click', function() {
        if (inputPassword.getAttribute('type') == 'password') {
            this.innerHTML = '<i class="fas fa-eye"></i>';
            inputPassword.setAttribute('type', 'text');
        } else {
            this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            inputPassword.setAttribute('type', 'password');
        }
    })
    $(document).ready(function() {
        $('#form-login').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '/auth/login',
                method: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function() {
                    $('#btn-submit').attr('disabled', true);
                    $('#btn-submit').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>`);
                },
                success: function(response) {
                    if (response.error) {
                        validationForm(response)
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
                        validationSuccessForm(response)
                    }
                    $('[name="csrf_test_name"]').val(response.csrfHash);
                    disableSubmit();
                },
                complete: function() {
                    $('#btn-submit').html('Login Now');
                },
                error: function(err) {
                    console.log(err)
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>