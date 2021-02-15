<?= $this->extend('admin/adminLayout/jobLayout') ?>
<?= $this->section('content') ?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Manage Job Applicant</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a>Manage Admin</a></div>
        <div class="breadcrumb-item"><a>Manage Job Applicant</a></div>
        <div class="breadcrumb-item">Users Job Applicant</div>
      </div>
    </div>

    <div class="section-body">
      <h2 class="section-title">Advanced Forms</h2>
      <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p>

      <div class="row">
        <div class="col-12 col-md-5 col-lg-5">
          <div class="card">
            <div class="card-header">
              <h4>Buat Lowongan Kerja Baru</h4>
            </div>
            <div class="card-body">
              <?= form_open_multipart('', 'id="form-edit-profile"') ?>
              <div class="form-group">
                <label>Nama/Judul Lowongan</label>
                <input type="text" class="form-control" name="title" placeholder="ex: Lowongan Kerja Junior Programmer">
              </div>
              <div class="form-group">
                <label>Kategori</label>&nbsp;<a href="/admin/setting" class="badge border">Buat kategori</a>
                <select class="form-control" name="id_category">
                  <option selected disabled value="">Choose...</option>
                  <?php foreach ($data_category as $category) : ?>
                    <option value="<?= $category['id'] ?>"><?= $category['category'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
              <div class="form-group">
                <label>Waktu Berakhir</label>
                <input type="text" class="form-control datepicker" name="expired">
              </div>
              <div class="form-group">
                <label>Jumlah Karyawan yang dibutuhkan</label>
                <input type="number" class="form-control" name="vacancy">
              </div>
              <div class="form-group">
                <label>Perkiraan Gaji</label>
                <input type="number" class="form-control" name="sallary" placeholder="ex: 3000000">
              </div>
              <div class="form-group">
                <label>Jadwalkan Wawancara</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="id_interview" id="interviewActive" value="1">
                  <label class="form-check-label" for="interviewActive">Aktifkan</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="id_interview" id="interviewInActive" value="0">
                  <label class="form-check-label" for="interviewInActive">Jangan Aktifkan</label>
                </div>
              </div>
              <div class="card card-primary" id="data-interview" style="display: none;">
                <div class="card-body">
                  <div class="form-group">
                    <label>Tempat Wawancara</label>
                    <input type="text" class="form-control" name="place_of_interview">
                  </div>
                  <div class="form-group">
                    <label>Tanggal dan Waktu</label>
                    <input type="text" class="form-control datetimepicker" name="date_time">
                  </div>
                  <div class="form-group">
                    <label>Wawancara dengan</label>
                    <input type="text" class="form-control" name="interview_with">
                  </div>
                  <div class="form-group">
                    <label>No Handphone Pewawancara</label>
                    <input type="text" class="form-control" name="phone_number">
                  </div>
                </div>
              </div>
              <div class="alert alert-info" id="alert-interviewInActive" role="alert" style="display: none;">
                Anda tidak mengaktifkan mode wawancara, maka jadwal akan diset default menjadi "tidak ada wawancara yang dilakukan"
              </div>
              <div class="form-group">
                <label>Keterangan Lainnya</label>
                <textarea type="text" class="form-control" name="note" style="height: 150px;"></textarea>
              </div>
              <div class="form-group">
                <label>Photo</label>
                <input type="file" name="image" class="form-control">
                <div class="invalid-feedback" id="photo">
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" id="btn-submit">Save Changes</button>
              </div>
              <?php form_close() ?>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-7 col-lg-7">
          <div class="card">
            <div class="card-header">
              <h4>Daftar Lowongan Kerja</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <?= csrf_field() ?>
                <table class="table table-striped" id="datatable-job">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>Kategori</th>
                      <th>Status</th>
                      <th>Interview</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Lowongan Junior Programmer</td>
                      <td>Freelance</td>
                      <td><a href="" class="btn btn-icon btn-success btn-sm btn-block">Active</a></td>
                      <td><a href="" class="btn btn-icon btn-success btn-sm btn-block">Yes</a></td>
                      <td>
                        <div class="btn-group mb-3" role="group" aria-label="Basic example"><a href="" class="btn btn-primary btn-sm">Detail</a><a href="javascript:void(0);" class="btn btn-danger btn-sm">Matikan</a></div>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Paruh Waktu Senior Programmer Website</td>
                      <td>Freelance</td>
                      <td><a href="" class="btn btn-icon btn-success btn-sm btn-block">Active</a></td>
                      <td><a href="" class="btn btn-icon btn-danger btn-sm btn-block">No</a></td>
                      <td>
                        <div class="btn-group mb-3" role="group" aria-label="Basic example"><a href="" class="btn btn-primary btn-sm">Detail</a><a href="javascript:void(0);" class="btn btn-danger btn-sm">Matikan</a></div>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Manager Keungan Perushaan</td>
                      <td>Freelance</td>
                      <td><a href="" class="btn btn-icon btn-danger btn-sm btn-block">No</a></td>
                      <td><a href="" class="btn btn-icon btn-danger btn-sm btn-block">No</a></td>
                      <td>
                        <div class="btn-group mb-3" role="group" aria-label="Basic example"><a href="" class="btn btn-primary btn-sm">Detail</a><a href="javascript:void(0);" class="btn btn-danger btn-sm">Hapus</a></div>
                      </td>
                    </tr>
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('#datatable-job').DataTable()

    $.ajax({

    })
  })
  let dataInterview = document.querySelector('#data-interview');
  let getInputInterview = document.querySelectorAll('[name="id_interview"]');
  let alertInterviewInactive = document.querySelector('#alert-interviewInActive');

  for (const interview of getInputInterview) {
    interview.addEventListener('click', function() {
      if (this.id == 'interviewActive') {
        dataInterview.style.display = 'block';
        alertInterviewInactive.style.display = 'none';
      } else {
        dataInterview.style.display = 'none';
        alertInterviewInactive.style.display = 'block';
      }
    })
  }
</script>
<?= $this->endSection() ?>