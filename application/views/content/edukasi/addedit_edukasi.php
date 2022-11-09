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
                <label for="title">Judul</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= @$data->title ?>" placeholder="Judul" autocomplete="off">
                <small class="help-block text-danger"></small>
              </div>
              <div class="form-group">
                <label for="image">Gambar</label>
                <input type="text" value="<?= @$data->image ?>" name="file-image" style="display: none;">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="image" name="image" value="<?= @$data->image ?>">
                    <label class="custom-file-label" for="image"><?= (@$data->image) ? $data->image : set_value('image')  ?></label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="type">Tipe Edukasi</label>
                <select name="type" id="type" class="form-control">
                  <option value="">Tipe Edukasi</option>
                  <option value="1" <?php if(@$data->type == 1) echo "selected"; ?>>Artikel</option>
                  <option value="2" <?php if(@$data->type == 2) echo "selected"; ?>>Video</option>
                </select>
                <small class="help-block text-danger"></small>
              </div>

              <div class="form-group">
                <div id="video" style="display: none;">
                  <label for="url">ID Video</label>
                  <input type="text" class="form-control" id="url" name="url" value="<?= @$data->url ?>" placeholder="ID Video (YouTube)" autocomplete="off">
                  <small class="help-block text-danger"></small>
                </div>
              </div>

              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control textarea" placeholder="Deskripsi"><?= @$data->deskripsi ?></textarea>
                <textarea name="old_deskripsi" style="display: none;"><?= @$data->deskripsi ?></textarea>
                <small class="help-block" id="required_deskripsi"></small>
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
var type          = $('[name="type"]');
var old_deskripsi = $('[name="old_deskripsi"]');

$(document).ready(function () {
  $('.textarea').summernote();
  form_validation();

  if (type.val() == 1) {
    $('#video').hide();
  }

  if (type.val() == 2) {
    $('#video').show();
  }

  if (old_deskripsi.val()) {
    $('#required_deskripsi').text('');
  } else {
    $('#required_deskripsi').text('*Deskripsi wajib diisi');
  }

  type.on('change', function() {
    if (type.val() == 2) {
      $('#video').show();
      $('#required_deskripsi').text('');
    } else {
      $('#video').hide();
      $('#required_deskripsi').text('*Deskripsi wajib diisi');
    }
  });

});

function form_validation() {
  var value_Image    = $('[name="file-image"]').val();
  var validate_image = value_Image ? false : true;

  $.validator.setDefaults({
    submitHandler: function () {
      submit_form();
    }
  });
  $('#form').validate({
    rules: {
      title: {
        required: true,
      },
      deskripsi: {
        required: true,
      },
      type: {
        required: true,
      },
      url: {
        required: true,
      },
      image: {
        required: validate_image,
      },
    },
    messages: {
      title: {
        required: "Judul harus diisi",
      },
      deskripsi: {
        required: "Deskripsi harus diisi",
      },
      type: {
        required: "Tipe Edukasi harus diisi",
      },
      image: {
        required: "Gambar harus diisi",
      },
      url: {
        required: "Url Video harus diisi",
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
      url : "<?= site_url('education/save_data/'. md5(@$data->id_edukasi)) ?>",
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