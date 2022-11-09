<section class="content">
  <div class="container-fluid">
    <form action="<?= site_url('patient/save_data/' . md5(@$data->id_penderita)) ?>" method="post" id="form">

      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?= $subtitle ?> Penderita</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="nik">NIK</label>
                <input type="number" min="0" class="form-control" id="nik" name="nik" value="<?= @$data->nik ?>" placeholder="NIK" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="full_name">Nama Penderita</label>
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
              <h3 class="card-title">Akun Penderita</h3>
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
              <h3 class="card-title">Detail Data Penderita</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="umur">Umur</label>
                <input type="number" min="0" class="form-control" id="umur" name="umur" value="<?= @$data->umur ?>" placeholder="Umur" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="tinggi_badan">Tinggi Badan</label>
                <input type="number" min="0" class="form-control" id="tinggi_badan" name="tinggi_badan" value="<?= @$data->tinggi_badan ?>" placeholder="Tinggi Badan" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="berat_badan">Berat Badan</label>
                <input type="number" min="0" class="form-control" id="berat_badan" name="berat_badan" value="<?= @$data->berat_badan ?>" placeholder="Berat Badan" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="gol_darah">Golongan Darah</label>
                <select name="gol_darah" id="gol_darah" class="form-control">
                  <option value="">Golongan Darah</option>
                  <?php foreach ($gol_darah as $key): ?>
                    <option value="<?= $key ?>" <?php if($key == @$data->gol_darah) echo "selected"; ?>><?= $key ?></option>
                  <?php endforeach ?>
                </select>
                <small class="help-block text-danger"></small>
              </div>
              <!-- <div class="form-group">
                <label for="id_kategori">Kategori</label>
                <select name="id_kategori" id="id_kategori" class="form-control">
                  <option value="">Kategori</option>
                  <?php foreach ($kategori as $row): ?>
                    <option value="<?= $row->id_kategori ?>" <?php if($row->id_kategori == @$data->id_kategori) echo "selected"; ?>><?= $row->nama_kategori ?></option>
                  <?php endforeach ?>
                </select>
                <small class="help-block text-danger"></small>
              </div> -->
              <div class="form-group">
                <label for="id_pmo">Pengawas Minum Obat</label>
                <select name="id_pmo" id="id_pmo" class="form-control">
                  <option value="">Pengawas Minum Obat</option>
                  <?php foreach ($pmop as $row): ?>
                    <option value="<?= $row->user_id ?>" <?php if($row->user_id == @$data->id_pmo) echo "selected"; ?>><?= $row->full_name ?></option>
                  <?php endforeach ?>
                </select>
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Lengkap"><?= @$data->alamat ?></textarea>
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