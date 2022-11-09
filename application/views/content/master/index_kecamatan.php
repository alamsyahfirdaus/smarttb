<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-8 col-xs-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Daftar <?= $title ?></h3>
				<div class="card-tools">
				  <button type="button" onclick="add_kecamatan()" class="btn btn-tool" title="Tambah <?= $title ?>">
				    <i class="fas fa-plus"></i></button>
				</div>
			</div>
		  <div class="card-body table-responsive">
			<table id="kecamatan" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
				  <th>Kecamatan</th>
				  <th width="5%" class="text-center">Action</th>
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
	  <form action="<?= site_url('master/subdistrict/save_kecamatan') ?>" id="form" method="post">
    	<input type="text" name="id_kecamatan" value="" style="display: none;">
	    <div class="modal-body">
	      <div class="form-group">
	        <label for="nama_kecamatan">Kecamatan</label>
	        <input type="text" name="nama_kecamatan" id="nama_kecamatan" class="form-control" placeholder="Kecamatan" autocomplete="off">
            <small class="help-block text-danger"></small>
	      </div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas"> Batal</i></button>
	      <button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Simpan</i></button>
	    </div>
	  </form>
	</div>
  </div>
</div>

<script type="text/javascript">
var tb = "#kecamatan";
var url = index + "master/subdistrict/show_datatables";
var form = "#form";
var btn = "#btnsave";

$(document).ready(function() {
	datatable(tb, url);
	form_serialize(form, btn);
});

function add_kecamatan() {
	reset_form(form);
	$('#modal_form').modal('show');
	$('.modal-title').text('Tambah Kecamatan');
}

function edit_kecamatan(id) {
  	reset_form(form);
    $.ajax({
        url : index + "master/subdistrict/get_kecamatan/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_kecamatan"]').val(data.id_kecamatan);
            $('[name="nama_kecamatan"]').val(data.nama_kecamatan);
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Kecamatan');
        }
    });
}

function action_success() {
  $('#modal_form').modal('hide');
  reload_table();
  reset_form(form);
}

function delete_kecamatan(id) {
  var text = "Akan menghapus Kecamatan";
  var url = index + "master/subdistrict/delete_kecamatan/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>