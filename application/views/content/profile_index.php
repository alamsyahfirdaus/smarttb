<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="card-title"><?= $subtitle ?></h5>
            <div class="card-tools">
              <div class="btn-group">
                <a type="button" class="btn btn-tool btn-sm dropdown-toggle text-muted" data-toggle="dropdown" title="Pengaturan">
                  <i class="fas fa-wrench"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" role="menu">
                  <a href="javascript:void(0)" class="dropdown-item" onclick="edit_profile()">Edit Profile</a>
                  <div class="dropdown-divider"></div>
                  <a href="javascript:void(0)" class="dropdown-item" onclick="edit_pass()">Edit Password</a>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle"
                   src="<?= base_url(IMAGE . $this->library->image(@$user['profile_pic']))?>"
                   alt="User profile picture">
            </div>
            <h3 class="profile-username text-center"><?= ucwords(@$user['full_name']) ?></h3>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Email</b> <a class="float-right"><?= @$user['email'] ?></a>
              </li>
              <li class="list-group-item">
                <b>Jenis Kelamin</b> <a class="float-right"><?= @$user['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></a>
              </li>
              <li class="list-group-item">
                <b>Tanggal Lahir</b> <a class="float-right"><?= $this->library->date(@$user['date_of_birth']) ?></a>
              </li>
              <li class="list-group-item">
                <b>Telepon</b> <a class="float-right"><?= @$user['phone'] ?></a>
              </li>
            </ul>
          </div>
          <div class="card-footer">
           <p class="text-center">
              <small class="text-muted">Registrasi Tanggal, <?= date('d/m/Y', strtotime($user['date_created'])); ?>
              </small>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal_form">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" method="post" action="<?= site_url('home/editpassword') ?>">
        <div class="modal-body">
          <div class="form-group">
            <label for="password">Password Lama</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password Lama">
            <small class="help-block text-danger"></small>
          </div>
          <div class="form-group">
            <label for="new_password1">Password Baru</label>
            <input type="password" class="form-control" id="new_password1" name="new_password1" placeholder="Password Baru">
            <small class="help-block text-danger"></small>
          </div>
          <div class="form-group">
            <label for="new_password2">Konfirmasi Password</label>
            <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Konfirmasi Password">
            <small class="help-block text-danger"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary" data-dismiss="modal" value="Reset"><i class="fas"> Batal</i></button>
          <button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Simpan</i></button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
var form = "#form";
var btn = "#btnsave";

$(document).ready(function() {
  form_serialize(form, btn);
});

function action_success() {
  $('#modal_form').modal('hide');
}

function edit_profile() {
  window.location.href = index + "home/editprofile";
}

function edit_pass() {
  reset_form(form);
  $('#modal_form').modal('show');
}
</script>