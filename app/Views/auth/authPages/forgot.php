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
                            <h4><a href="javascript:history.back()" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Kembali</a></h4>
                        </div>

                        <div class="card-body">
                            <p class="text-muted">We will send a link to reset your password</p>
                            <?= form_open('', 'id="form-forgot" role="form" method="post"') ?>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Your Email" tabindex="1">
                                <div class="invalid-feedback" id="email">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-submit" tabindex="4" disabled>Forgot Password</button>
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
    const email = document.querySelector('#email');
    const btnSubmit = document.querySelector('#btn-submit');
    const inputEmail = document.querySelector('[name="email"]');
    const validationForm = response => {
        if (response.error) {
            email.innerHTML = response.error.email;
            inputEmail.classList.add('is-invalid');
        } else {
            email.innerHTML = '';
            inputEmail.classList.remove('is-invalid');
        }
    }
    const disableSubmit = () => {
        if (inputEmail.value == '') {
            btnSubmit.setAttribute('disabled', true);
        } else {
            btnSubmit.removeAttribute('disabled');
        }
    }
    inputEmail.addEventListener('input', disableSubmit);

    $(document).ready(function() {
        $('#form-forgot').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: '/auth/forgotpassword',
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
                            $('#form-forgot')[0].reset();
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