<section class="content">
  <div class="container-fluid">
    <form action="" method="post" id="form">

      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?= $subtitle ?></h3>
              <div class="card-tools">
                <?php if (@$reminder->reminder_id): ?>
                  <button type="button" onclick="delete_data()" class="btn btn-tool" title="Hapus <?= $subtitle ?>">
                    <i class="fas fa-trash"></i></button>
                <?php endif ?>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label>Kode Penderita</label>
                <input type="text" class="form-control" value="<?= @$data->nik ?>" disabled="">
                <input type="text" name="kode_penderita" value="<?= @$data->nik ?>" style="display: none;">
              </div>


              <?php if (@$reminder->reminder_id && date('Y-m-d') <= @$reminder->tanggal_selesai): ?>

                <div class="form-group">
                  <label for="id_jenis_penderita">Jenis Penderita</label>
                  <select class="form-control" disabled="">
                    <option value="">Jenis Penderita</option>
                    <?php foreach ($jenis_penderita as $row): ?>
                      <option value="<?= $row->id_jenis_penderita ?>" <?php if(@$reminder->id_jenis_penderita == $row->id_jenis_penderita) echo "selected"; ?>><?= $row->nama_jenis_penderita ?></option>
                    <?php endforeach ?>
                  </select>
                  <input type="text" name="id_jenis_penderita" value="<?= @$reminder->id_jenis_penderita ?>" style="display: none;">
                </div>
                <div class="form-group">
                  <label>Mulai Pengobatan</label>
                  <input type="text" class="form-control" value="<?= $this->library->date(@$reminder->tanggal_mulai) ?>" disabled="">
                  <input type="text" name="tanggal_mulai" value="<?= @$reminder->tanggal_mulai ?>" style="display: none;">
                </div>
                <div class="form-group">
                  <label>Selesai Pengobatan</label>
                  <input type="text" class="form-control" value="<?= $this->library->date(@$reminder->tanggal_selesai) ?>" disabled="">
                </div>

              <?php else: ?>

                <div class="form-group">
                  <label for="id_jenis_penderita">Jenis Penderita</label>
                  <select name="id_jenis_penderita" id="id_jenis_penderita" class="form-control">
                    <option value="">Jenis Penderita</option>
                    <?php foreach ($jenis_penderita as $row): ?>
                      <option value="<?= $row->id_jenis_penderita ?>" <?php if(@$reminder->id_jenis_penderita == $row->id_jenis_penderita) echo "selected"; ?>><?= $row->nama_jenis_penderita ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="tanggal_mulai">Mulai Pengobatan</label>
                  <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder="Mulai Pengobatan"  value="<?= @$reminder->tanggal_mulai ?>">
                  <small class="help-block text-danger"></small>
                </div>

              <?php endif ?>

              <div class="form-group">
                <label for="jam_alarm">Jam Alarm</label>
                <input type="time" class="form-control" id="jam_alarm" name="jam_alarm" placeholder="Jam Alarm" value="<?= @$reminder->jam_alarm ?>">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control textarea" placeholder="Deskripsi"><?= @$reminder->deskripsi ?></textarea>
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
        <div class="col-md-6 col-xs-12">
<!--           <?php if (@$reminder->reminder_id): ?>
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Detail Minum Obat</h3>
                <div class="card-tools"></div>
              </div>
              <div class="card-body">
                <table class="table table-condensed">
                  <tr>
                    <td>Lama Pengobatan</td>
                    <td>:</td>
                    <td>
                      <?php if ($row->id_jenis_penderita == 1): ?>
                        <?= '6 Bulan' ?>
                      <?php elseif($row->id_jenis_penderita): ?>
                        <?= '12 Bulan' ?>
                      <?php elseif($row->id_jenis_penderita): ?>
                        <?= '24 Bulan' ?>
                      <?php else: ?>
                        <?= '-' ?>
                      <?php endif ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Jumlah Minum Obat</td>
                    <td>:</td>
                    <?php
                      $firstDate        = date('Y/m/d', strtotime(@$reminder->tanggal_mulai));
                      $secondDate       = date('Y/m/d', strtotime(@$reminder->tanggal_selesai));
                      $startTimeStamp   = strtotime($firstDate);
                      $endTimeStamp     = strtotime($secondDate);
                      $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                      $numberDays       = $timeDiff / 86400;
                      $numberDays1       = intval($numberDays);
                    ?>
                    <td><?= $numberDays1 ?> Hari</td>
                  </tr>
                  <tr>
                    <td>Sudah Minum Obat</td>
                    <td>:</td>
                    <td><?= $sudah_minum_obat > 0 ? $sudah_minum_obat . ' Hari' : '-' ?></td>
                  </tr>
                  <tr>
                    <td>Sisa Minum Obat</td>
                    <td>:</td>
                    <?php
                      $firstDate        = date('Y/m/d');
                      $secondDate       = date('Y/m/d', strtotime(@$reminder->tanggal_selesai));
                      $startTimeStamp   = strtotime($firstDate);
                      $endTimeStamp     = strtotime($secondDate);
                      $timeDiff         = abs($endTimeStamp - $startTimeStamp);
                      $numberDays       = $timeDiff / 86400;
                      $numberDays2       = intval($numberDays);
                    ?>
                    <td><?= $numberDays2 ?> Hari</td>
                  </tr>
                  <?php if (date('Y-m-d') <= @$reminder->tanggal_selesai): ?>
                  <?php else: ?>
                    <tr>
                      <td>Minum Obat Terlewat</td>
                      <td>:</td>
                      <td><?= $numberDays1 - $sudah_minum_obat ?> Hari</td>
                    </tr>
                  <?php endif ?>
                </table>
              </div>
              <div class="card-footer"></div>
            </div>
          <?php endif ?> -->
        </div>
      </div>

    </form>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
    $('.textarea').summernote();

    $('#form').validate({
      rules: {
        id_jenis_penderita: {
          required: true,
        },
        tanggal_mulai: {
          required: true,
        },
        jam_alarm: {
          required: true,
        },
        deskripsi: {
          required: true,
        },
      },
      messages: {
        id_jenis_penderita: {
          required: "Jenis TB harus diisi",
        },
        tanggal_mulai: {
          required: "Tanggal Mulai harus diisi",
        },
        jam_alarm: {
          required: "Jam Alarm harus diisi",
        },
        deskripsi: {
          required: "Deskripsi harus diisi",
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });

  function delete_data() {
    var text      = "Akan menghapus <?= $subtitle ?>";
    var url_del   = "<?= site_url('patient/delete_alarm/' . md5(@$reminder->reminder_id) . '/' . md5(@$data->user_id)) ?>";
    confirm_delete(text, url_del);
  }

  function success_delete() {
    window.location.reload();
  }
</script>