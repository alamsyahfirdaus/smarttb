<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-12 col-xs-12">
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
				  <th>Kelurahan</th>
				  <th>Kecamatan</th>
				  <th>Puskesmas</th>
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

	  <form action="<?= site_url('master/village/save_data') ?>" id="form" method="post">
    	<input type="text" name="id_kelurahan" value="" style="display: none;">
	    <div class="modal-body">
		  <!-- <div class="alert alert-danger" role="alert">Alert</div> -->
	      <div class="form-group">
	        <label for="nama_kelurahan">Kelurahan</label>
	        <input type="text" name="nama_kelurahan" id="nama_kelurahan" class="form-control" placeholder="Kelurahan" autocomplete="off">
            <small class="help-block text-danger"></small>
	      </div>
	      <div class="form-group">
	        <label for="id_kecamatan">Kecamatan</label>
	        <select class="form-control select2" id="id_kecamatan" name="id_kecamatan" required="">
	        	<option value="">Kecamatan</option>
	        	<?php foreach ($kecamatan as $row): ?>
	        		<option value="<?= $row->id_kecamatan ?>"><?= ucwords($row->nama_kecamatan) ?></option>
	        	<?php endforeach ?>
	        </select>
            <small class="help-block text-danger"></small>
	      </div>
	     <div class="form-group">
	        <label for="id_puskesmas">Puskesmas</label>
	        <select class="form-control select2" id="id_puskesmas" name="id_puskesmas" required="">
	        	<option value="">Puskesmas</option>
	        	<?php foreach ($puskesmas as $row): ?>
	        		<option value="<?= $row->id_puskesmas ?>"><?= ucwords($row->nama) ?></option>
	        	<?php endforeach ?>
	        </select>
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
var title = $('[name="title"]').val();
var tb = "#table";
var url = index + "master/village/show_datatables";
var base_url = index + "master/village/";
var form = "#form";
var btn = "#btnsave";

$(document).ready(function() {
	datatable(tb, url);
	form_serialize(form, btn);
});

function add_data() {
	reset_form(form);
	$('#modal_form').modal('show');
	$('.modal-title').text('Tambah ' + title);
}

function edit_data(id) {
  	reset_form(form);
    $.ajax({
        url : base_url + "get_data/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_kelurahan"]').val(id);
            $('[name="nama_kelurahan"]').val(data.nama_kelurahan);
            $('[name="id_kecamatan"]').val(data.id_kecamatan).select2();
            $('[name="id_puskesmas"]').val(data.id_puskesmas).select2();
            $('#modal_form').modal('show');
            $('.modal-title').text('Edit ' + title);
        }
    });
}

function action_success() {
  $('#modal_form').modal('hide');
  reload_table();
  reset_form(form);
}

function delete_data(id) {
  var text = "Akan menghapus " + title;
  var url = base_url + "delete/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>

<script type="text/javascript">
	$(".select").select2({
	  minimumResultsForSearch: Infinity
	});
</script>

<style type="text/css">
	.was-validated .custom-select:invalid + .select2 .select2-selection{
	    border-color: #dc3545!important;
	}
	.was-validated .custom-select:valid + .select2 .select2-selection{
	    border-color: #28a745!important;
	}
	*:focus{
	  outline:0px;
	}
</style>