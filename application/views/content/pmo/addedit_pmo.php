<section class="content">
  <div class="container-fluid">
    <form action="<?= site_url('nurse/save_data/' . md5(@$data->id_pmo)) ?>" method="post" id="form">

      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?= $subtitle ?> PMO</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="full_name">Nama PMO</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= @$data->full_name ?>" placeholder="Nama Penderita" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control">
                  <option value="">Jenis Kelamin</option>
                  <option value="L" <?php if(@$data->gender == 'L') echo "selected"; ?>>Laki-Laki</option>
                  <option value="P" <?php if(@$data->gender == 'P') echo "selected"; ?>>Perempuan</option>
                </select>
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="phone">Telepon</label>
                <input type="number" min="0" class="form-control" id="phone" name="phone" value="<?= @$data->phone ?>" placeholder="Telepon" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="date_of_birth">Tanggal Lahir</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Tanggal Lahir"  value="<?= @$data->date_of_birth ?>">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="profile_pic">Foto</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="profile_pic" name="profile_pic">
                    <label class="custom-file-label" for="profile_pic"><?= (@$data->profile_pic) ? $data->profile_pic : set_value('profile_pic')  ?></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xs-12">

          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Akun PMO</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= @$data->email ?>" placeholder="Email" autocomplete="off">
                <small class="help-block text-danger"></small>
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
          </div>

          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Detail Data PMO</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="pekerjaan">Pekerjaan</label>
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= @$data->pekerjaan ?>" placeholder="Pekerjaan" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Lengkap"><?= @$data->alamat_pmo ?></textarea>
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

<script type="text/javascript"> 
var form  = "#form";
var btn   = "#btnsave";

$(document).ready(function() {
  form_multipart(form, btn);

});

function action_success() {
  $("#back").click();
}

</script>