<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-6 col-xs-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Daftar <?= $title ?></h3>
				<input type="hidden" name="title" value="<?= $title ?>">
				<div class="card-tools">
				  <button type="button" onclick="add_data()" class="btn btn-tool" title="Tambah <?= $title ?>">
				    <i class="fas fa-plus"></i></button>
				</div>
			</div>
		  <div class="card-body table-responsive">
			<table id="table" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
				  <th>Nama Obat</th>
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
	  <form action="<?= site_url('master/drug/save_data') ?>" id="form" method="post">
    	<input type="text" name="id_obat" value="" style="display: none;">
	    <div class="modal-body">
	      <div class="form-group">
	        <label for="nama_obat">Nama Obat</label>
	        <input type="text" name="nama_obat" id="nama_obat" class="form-control" placeholder="Nama Obat" autocomplete="off">
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
var title 		= $('[name="title"]').val();
var tb 			= "#table";
var url 		= index + "master/drug/show_datatables";
var base_url 	= index + "master/drug/";
var form 		= "#form";
var btn 		= "#btnsave";

$(document).ready(function() {
	datatable(tb, url);
	form_serialize(form, btn);
});

function add_data() {
	reset_form(form);
	$('#modal_form').modal('show');
	$('.modal-title').text('Tambah ' + title);
}

function edit_data(id, name) {
  	reset_form(form);
    $('[name="id_obat"]').val(id);
    $('[name="nama_obat"]').val(name);
    $('#modal_form').modal('show');
    $('.modal-title').text('Edit ' + title);
}

function action_success() {
  $('#modal_form').modal('hide');
  reload_table();
  reset_form(form);
}

function delete_data(id) {
  var text 	= "Akan menghapus " + title;
  var url 	= base_url + "delete/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>