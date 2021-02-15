<?= $this->extend('admin/adminLayout/usersLayout') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manage Blacklist</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a>Manage Admin</a></div>
                <div class="breadcrumb-item"><a>Manage Blacklist</a></div>
                <div class="breadcrumb-item">Users Blacklist</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">User Blacklist Management</h2>
            <p class="section-lead">This page contains user management that has been disabled.</p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="javascript:void(0);" onclick="javascript:history.back()" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Go Back</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?= csrf_field() ?>
                                <table class="table table-striped" id="datatable-blacklist">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Banned At</th>
                                            <th>Finished On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="unbanned-user" style="display:none"></div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
    const openModal = username => {
        $.ajax({
            url: '/admin/modalUnblacklist',
            dataType: 'json',
            data: {
                username: username
            },
            success: function(response) {
                $('.unbanned-user').html(response.view).show();
                $('#unbanned-user').modal('show')
            }
        })
    }
    let table;

    $(document).ready(function() {
        table = $('#datatable-blacklist').DataTable({
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "/admin/blacklist_datatable",
                "type": "POST",
                "data": {
                    "csrf_test_name": $('[name="csrf_test_name"]').val()
                },
                "data": function(data) {
                    data.csrf_test_name = $('[name="csrf_test_name"]').val();
                },
                "dataSrc": function(response) {
                    $('[name="csrf_test_name"]').val(response.csrf_test_name);
                    return response.data;
                },
            },
            "columnDefs": [{
                    "targets": [3, -1],
                    "orderable": false
                },
                {
                    "targets": [-1],
                    "className": "text-center"
                },
            ]
        })
        $.fn.DataTable.ext.pager.numbers_length = 4;
    })
</script>
<?= $this->endSection() ?>