<?= $this->extend('admin/adminLayout/usersProfileLayout') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a>Manage Admin</a></div>
                <div class="breadcrumb-item"><a>Manage Profile</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Admin Profile Detail</h2>
            <p class="section-lead">This page contains profile details and edit the admin profile.</p>
            <div class="row mt-sm-4">
                <div class="col-12 col-sm-12 col-lg-6">
                    <div class="card author-box card-primary">
                        <div class="card-body">
                            <div class="author-box-left">
                                <img alt="image" id="img-profile-user" src="/image/profile/<?= $sessUser['photo'] ?>" class="rounded-circle author-box-picture" style="width: 100px; height: 100px" />
                                <div class="clearfix"></div>
                            </div>
                            <div class="author-box-details">
                                <div class="author-box-name">
                                    <a id="authorName"><?= ucfirst($sessUser['name']) ?></a>
                                </div>
                                <div class="author-box-job"> <?= $sessUser['username'] ?> - <?= censoredEmail($sessUser['email']) ?> </div>
                                <div class="author-box-description">
                                    <div class="card-header mb-3">
                                        <h4>Profil Detail</h4>
                                    </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <td><?= $sessUser['username'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?= censoredEmail($sessUser['email']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Full Name</th>
                                                <td id="shName"><?= $sessUser['name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td id="shPhone"><?= $sessUser['phone'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Birthdate</th>
                                                <td id="shBirthdate"><?= $sessUser['birthdate'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Gender</th>
                                                <td id="shGender"><?= $sessUser['gender'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Age</th>
                                                <td id="shAge"><?= $sessUser['age'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td id="shAddress"><?= $sessUser['address'] ?></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <div class="card author-box card-primary">
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <?= form_open_multipart('', 'id="form-edit-profile"') ?>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="<?= $sessUser["username"] ?>" readonly>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Email</label> <small class="text-primary"><i class="fas fa-check-circle"></i> Verified</small>
                                    <input type="email" class="form-control" value="<?= censoredEmail($sessUser['email']) ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Full Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= $sessUser["name"] ?>">
                                    <div class="invalid-feedback" id="name">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" class="form-control" value="<?= $sessUser["phone"] ?>">
                                    <div class="invalid-feedback" id="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Birthdate</label>
                                    <input type="text" name="birthdate" class="form-control datepicker" value="<?= $sessUser["birthdate"] ?>">
                                    <div class="invalid-feedback" id="birthdate">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option selected disabled value="">Choose...</option>
                                        <option <?= $sessUser["gender"] == "Male" ? 'selected' : '' ?>>Male</option>
                                        <option <?= $sessUser["gender"] == "Female" ? 'selected' : '' ?>>Female</option>
                                    </select>
                                    <div class="invalid-feedback" id="gender">gender
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Age</label>
                                <input type="tel" name="age" class="form-control" value="<?= $sessUser["age"] ?>">
                                <div class="invalid-feedback" id="age">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" style="height: 150px;"><?= $sessUser["address"] ?></textarea>
                                <div class="invalid-feedback" id="address">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" name="photo" class="form-control">
                                <div class="invalid-feedback" id="photo">
                                </div>
                                <img src="/image/profile/<?= $sessUser['photo'] ?>" class="img-thumbnail mt-3 col-lg-4 col-sm-12" id="img-profile" width="200" alt="">
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary" id="btn-submit">Save Changes</button>
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
    const inputName = document.querySelector("[name=\"name\"]"),
        inputPhone = document.querySelector("[name=\"phone\"]"),
        inputBirthdate = document.querySelector("[name=\"birthdate\"]"),
        inputGender = document.querySelector("[name=\"gender\"]"),
        inputAge = document.querySelector("[name=\"age\"]"),
        inputAddress = document.querySelector("[name=\"address\"]"),
        inputPhoto = document.querySelector("[name=\"photo\"]");

    inputPhoto.addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let src = URL.createObjectURL(file);
            let preview = document.querySelector('#img-profile');
            preview.setAttribute('src', src);
            preview.style.display = 'block';
        }
    })

    validationForm = a => {
            a.error.name ? (document.querySelector("#name").innerHTML = a.error.name, inputName.classList.add("is-invalid")) : (document.querySelector("#name").innerHTML = "", inputName.classList.remove("is-invalid")), a.error.phone ? (document.querySelector("#phone").innerHTML = a.error.phone, inputPhone.classList.add("is-invalid")) : (document.querySelector("#phone").innerHTML = "", inputPhone.classList.remove("is-invalid")), a.error.birthdate ? (document.querySelector("#birthdate").innerHTML = a.error.birthdate, inputBirthdate.classList.add("is-invalid")) : (document.querySelector("#birthdate").innerHTML = "", inputBirthdate.classList.remove("is-invalid")), a.error.gender ? (document.querySelector("#gender").innerHTML = a.error.gender, inputGender.classList.add("is-invalid")) : (document.querySelector("#gender").innerHTML = "", inputGender.classList.remove("is-invalid")), a.error.age ? (document.querySelector("#age").innerHTML = a.error.age, inputAge.classList.add("is-invalid")) : (document.querySelector("#age").innerHTML = "", inputAge.classList.remove("is-invalid")), a.error.address ? (document.querySelector("#address").innerHTML = a.error.address, inputAddress.classList.add("is-invalid")) : (document.querySelector("#address").innerHTML = "", inputAddress.classList.remove("is-invalid")), a.error.photo ? (document.querySelector("#photo").innerHTML = a.error.photo, inputPhoto.classList.add("is-invalid")) : (document.querySelector("#photo").innerHTML = "", inputPhoto.classList.remove("is-invalid"))
        },
        validationSuccessForm = a => {
            document.querySelector("#name").innerHTML = "", inputName.classList.remove("is-invalid"), document.querySelector("#phone").innerHTML = "", inputPhone.classList.remove("is-invalid"), document.querySelector("#birthdate").innerHTML = "", inputBirthdate.classList.remove("is-invalid"), document.querySelector("#gender").innerHTML = "", inputGender.classList.remove("is-invalid"), document.querySelector("#age").innerHTML = "", inputAge.classList.remove("is-invalid"), document.querySelector("#address").innerHTML = "", inputAddress.classList.remove("is-invalid"), document.querySelector("#photo").innerHTML = "", inputPhoto.classList.remove("is-invalid"), shName.innerHTML = a.data.name, shPhone.innerHTML = a.data.phone, shBirthdate.innerHTML = a.data.birthdate, shGender.innerHTML = a.data.gender, shAge.innerHTML = a.data.age, shAddress.innerHTML = a.data.address, authorName.innerHTML = a.data.name, document.querySelector('#img-profile-user').setAttribute('src', '/image/profile/' + a.data.photo)
        };
    $(document).ready(function() {
        $("#form-edit-profile").submit(function(a) {
            a.preventDefault(), $.ajax({
                url: "/admin/goEditProfile",
                method: "POST",
                dataType: "json",
                data: new FormData(this),
                contentType: !1,
                cache: !1,
                processData: !1,
                beforeSend: function() {
                    $("#btn-submit").attr("disabled", !0), $("#btn-submit").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>`)
                },
                success: function(a) {
                    a.error ? validationForm(a) : (iziToast.success({
                        timeout: 7e3,
                        title: "Success",
                        message: a.success,
                        position: "topRight"
                    }), validationSuccessForm(a)), $("[name=\"csrf_test_name\"]").val(a.csrfHash)
                },
                complete: function() {
                    $("#btn-submit").removeAttr("disabled", !0), $("#btn-submit").html("Save Changes")
                },
                error: function(a) {
                    console.log(a)
                }
            })
        })
    });
</script>
<?= $this->endSection() ?>