<?= $this->extend('admin/adminLayout/usersProfileLayout') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a>Manage Admin</a></div>
                <div class="breadcrumb-item"><a>Manage Users</a></div>
                <div class="breadcrumb-item">Users</div>
                <div class="breadcrumb-item">Users Profile</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title"><?= $getUser['status'] == 1 ? "<del>" . $getUser['name'] . "</del>" : $getUser['name'] ?></h2>
            <p class="section-lead">
                Member <?= $getUser['status'] == 1 ? "</del> <span class='text-danger'>(This user is currently disabled)</span>" : "" ?>
            </p>
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="/template/stisla/assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Submit Application</div>
                                    <div class="profile-widget-item-value">187</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Applications Reviewed</div>
                                    <div class="profile-widget-item-value">27</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name"><?= $getUser['username'] ?> <div class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div> <?= $getUser['email'] ?>
                                </div>
                            </div>
                            Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>History</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                                <li class="media">
                                    <img alt="image" class="mr-3 rounded-circle" width="70" src="/template/stisla/assets/img/avatar/avatar-1.png">
                                    <div class="media-body">
                                        <div class="media-right">
                                            <div class="text-warning">Reviewed</div>
                                        </div>
                                        <div class="media-title mb-1">Rizal Fakhri</div>
                                        <div class="text-time">Yesterday</div>
                                        <div class="media-description text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img alt="image" class="mr-3 rounded-circle" width="70" src="/template/stisla/assets/img/avatar/avatar-2.png">
                                    <div class="media-body">
                                        <div class="media-right">
                                            <div class="text-danger">Rejected</div>
                                        </div>
                                        <div class="media-title mb-1">Bambang Uciha</div>
                                        <div class="text-time">Yesterday</div>
                                        <div class="media-description text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img alt="image" class="mr-3 rounded-circle" width="70" src="/template/stisla/assets/img/avatar/avatar-3.png">
                                    <div class="media-body">
                                        <div class="media-right">
                                            <div class="text-danger">Rejected</div>
                                        </div>
                                        <div class="media-title mb-1">Ujang Maman</div>
                                        <div class="text-time">Yesterday</div>
                                        <div class="media-description text-muted">Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident</div>
                                    </div>
                                </li>
                            </ul>
                            <nav aria-label="...">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<?= $this->endSection() ?>