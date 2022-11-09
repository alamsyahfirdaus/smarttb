<section class="content">
  <div class="container-fluid">
    <form action="<?= site_url('master/category/save_data/' . md5(@$data->id_kategori)) ?>" method="post" id="form">
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?= $subtitle . ' ' . $title ?></h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= @$data->nama_kategori ?>" placeholder="Nama Kategori" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="berat_badan">Berat Badan (Kg)</label>
                <input type="text" class="form-control" id="berat_badan" name="berat_badan" value="<?= @$data->berat_badan ?>" placeholder="Berat Badan (Kg)" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="fase">Fase</label>
                <input type="text" class="form-control" id="fase" name="fase"value="<?= @$data->fase ?>" placeholder="Fase" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
             <div class="form-group">
                <label for="id_aturan">Aturan Minum Obat</label>
                <select class="form-control select2" id="id_aturan" name="id_aturan" required="">
                  <option value="">Aturan Minum Obat</option>
                  <?php foreach ($aturan as $row): ?>
                    <option value="<?= $row->id_aturan ?>" <?php if($row->id_aturan == @$data->id_aturan) echo "selected"; ?>><?= ucwords($row->nama_aturan) ?></option>
                  <?php endforeach ?>
                </select>
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