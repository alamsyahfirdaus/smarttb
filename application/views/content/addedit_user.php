<section class="content">
  <div class="container-fluid">
    <form action="<?= site_url('user/save/' . md5(@$user->user_id)) ?>" method="post" id="form">
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?= $subtitle . ' ' . $header ?></h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= @$user->full_name ?>" placeholder="Nama Lengkap" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email"value="<?= @$user->email ?>" placeholder="Email" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control">
                  <option value="">Jenis Kelamin</option>
                  <option value="L" <?php if(@$user->gender == 'L') echo "selected"; ?>>Laki-Laki</option>
                  <option value="P" <?php if(@$user->gender == 'P') echo "selected"; ?>>Perempuan</option>
                </select>
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="phone">Telepon</label>
                <input type="number" min="0" class="form-control" id="phone" name="phone" value="<?= @$user->phone ?>" placeholder="Telepon" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="date_of_birth">Tanggal Lahir</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Tanggal Lahir"  value="<?= @$user->date_of_birth ?>">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="profile_pic">Foto Profile</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profile_pic" name="profile_pic">
                    <label class="custom-file-label" for="profile_pic"><?= (@$user->profile_pic) ? $user->profile_pic : set_value('profile_pic')  ?></label>
                  </div>
                  <div class="input-group-append">
                    <button type="button" <?php if(!@$user->user_id || !@$user->profile_pic) echo "disabled"; ?> class="btn btn-default" data-toggle="modal" data-target="#modal_form"><i class="fas fa-eye"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="password1">Password</label>
                <input type="password" class="form-control" id="password1" name="password1" placeholder="Password <?php if(@$user->user_id) echo '(biarkan kosong jika tidak akan diubah)' ?>">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="password2">Konfirmasi Password</label>
                  <input type="password" class="form-control" id="password2" name="password2" placeholder="Konfirmasi Password">
                  <small class="help-block text-danger"></small>
              </div>
            </div>
            <div class="card-footer">
              <div class="float-right">
                <button type="button" id="back" onclick="window.history.back()" class="btn btn-secondary mr-2"><i class="fas"> Batal</i></button>
                <button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Simpan</i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<div class="modal fade" id="modal_form">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Foto Profile</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <form action="" method="post" id="form_img">
      <input type="hidden" name="user_id" value="<?= md5(@$user->user_id) ?>">
      <div class="modal-body">
        <img src="<?= site_url(IMAGE . @$user->profile_pic) ?>" class="img-fluid" alt="Photo">
      </div>
      <div class="modal-footer">
        <button type="button" onclick="delete_img()" class="btn btn-danger btn-sm">Hapus</button>
      </div>
    </form>
  </div>
  </div>
</div>

<script type="text/javascript"> 
var form  = "#form";
var btn   = "#btnsave";

$(document).ready(function() {
  form_multipart(form, btn);
});

function action_success() {
  window.location.href = index + "user";
}

function delete_img()
{
  $.ajax({
      url : index + "user/delete_img",
      type: "POST",
      data: $('#form_img').serialize(),
      dataType: "JSON",
      success: function(data) {
      if(data.status) {
        $('#modal_form').modal('hide');
        flashdata(data.message);
        setTimeout(function() { 
           $("#back").click();
        }, 1800);
      }
    }
  });
}
</script>