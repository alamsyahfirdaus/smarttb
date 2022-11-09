<section class="content">
  <div class="container-fluid">
    <form action="" method="post" id="form">
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><?= $subtitle . ' ' . $breadcrumb ?></h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="setting_value">Nama Pengaturan</label>
                <input type="text" class="form-control" id="setting_value" value="<?= @$setting_name ?>" disabled="" readonly="">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="setting_value">Deskripsi</label>
                <textarea name="setting_value" id="setting_value" class="form-control textarea" placeholder="Deskripsi"><?= @$data->setting_value ?></textarea>
                <small class="help-block" id="required_deskripsi"></small>
              </div>

              <div style="display: none;">
                <input type="text" name="setting_name" value="<?= @$data->setting_name ?>">
                <textarea name="old_deskripsi"><?= @$data->setting_value ?></textarea>
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
var old_deskripsi = $('[name="old_deskripsi"]');

$(document).ready(function () {
  $('.textarea').summernote();
  form_validation();

  if (old_deskripsi.val()) {
    $('#required_deskripsi').text('');
  } else {
    $('#required_deskripsi').text('*Deskripsi wajib diisi');
  }

});

function form_validation() {

  $.validator.setDefaults({
    submitHandler: function () {
      submit_form();
    }
  });
  $('#form').validate({
    rules: {
      setting_name: {
        required: true,
      },
    },
    messages: {
      setting_name: {
        required: "Nama Pengaturan harus diisi",
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
}

function submit_form() {
  $.ajax({
      url : "<?= site_url('setting/save_data') ?>",
      type: "POST",
      data: new FormData($('#form')[0]),
      contentType:false,
      processData:false,
      dataType: "JSON",
      success: function(response) {
        if (response.status) {
           $("#back").click();
        } else {
          $.each(response.errors, function (key, val) {
              $('[name="' + key + '"]').addClass('is-invalid');
              $('[name="'+ key +'"]').next('.help-block').text(val);
              if (val === '') {
                  $('[name="' + key + '"]').removeClass('is-invalid');
                  $('[name="'+ key +'"]').next('.help-block').text('');
              }
          });
        }
      }
  });
}
</script>