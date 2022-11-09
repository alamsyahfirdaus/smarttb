<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-12 col-xs-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Daftar <?= $header ?></h3>
				<input type="hidden" name="title" value="<?= $header ?>">
				<div class="card-tools">
				  <button type="button" onclick="broadcast_message()" class="btn btn-tool" title="Pesan Siaran">
				    <i class="fas fa-envelope"></i></button>
				</div>
			</div>
		  <div class="card-body table-responsive">
			<table id="table" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
				  <th>NIK</th>
				  <th>Nama Penderita</th>
				  <th>Jenis Kelamin</th>
				  <th>Telepon</th>
				  <th width="10%" class="text-center">Action</th>
				</tr>
			  </thead>
			</table>
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
		<h5 class="modal-title">#</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <form action="" id="form" method="post">
	    <div class="modal-body">
		  <input type="text" name="received_id" value="" style="display: none;">
	      <div class="form-group">
	        <label for="message">Pesan</label>
	        <textarea class="form-control" name="message" id="message" placeholder="Pesan"></textarea>
            <small class="help-block text-danger"></small>
	      </div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas"> Batal</i></button>
	      <button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Kirim</i></button>
	    </div>
	  </form>
	</div>
  </div>
</div>

<script type="text/javascript">
var title = $('[name="title"]').val();
var tb = "#table";
var url = index + "pmo/patient/show_datatables";
var base_url = index + "pmo/patient/";

$(document).ready(function() {
	datatable(tb, url);
	form_validation();
});

function detail_data(id) {
	window.location.href = base_url + "detail/" + id;	
}

function send_message(id) {
	window.location.href = index + "pmo/message/send/" + id;	
}

function broadcast_message() {
	reset_form(form);
	$('#modal_form').modal('show');
	$('.modal-title').text('Pesan Siaran');
}

function form_validation() {
	$.validator.setDefaults({
	  submitHandler: function () {
	    submit_form();
	  }
	});
	$('#form').validate({
	  rules: {
	    message: {
	      required: true,
	    },
	  },
	  messages: {
	    message: {
	      required: "Pesan harus diisi",
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
      url : "<?= site_url('pmo/message/broadcast_message') ?>",
      type: "POST",
      data: new FormData($('#form')[0]),
      contentType:false,
      processData:false,
      dataType: "JSON",
      success: function(response) {
        if (response.status) {
           $('#modal_form').modal('hide');
           reload_table();
           Swal.fire({
             type: 'success',
             title: 'Berhasil Mengirim Pesan',
             showConfirmButton: false,
             timer: 1500
           });
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