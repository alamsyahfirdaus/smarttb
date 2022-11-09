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
				  <th>Jumlah Obat</th>
				  <th>Kategori</th>
				  <th>Obat</th>
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
	  <form action="<?= site_url('master/drugcategory/save_data') ?>" id="form" method="post">
    	<input type="text" name="id_obat_kategori" value="" style="display: none;">
	    <div class="modal-body">
	      <div class="form-group">
	        <label for="jumlah_obat">Jumlah Obat</label>
	        <input type="number" min="0" name="jumlah_obat" id="jumlah_obat" class="form-control" placeholder="Jumlah Obat" autocomplete="off">
            <small class="help-block text-danger"></small>
	      </div>
	      <div class="form-group">
	        <label for="id_kategori">Kategori</label>
	        <select class="form-control select2" id="id_kategori" name="id_kategori" required="">
	        	<option value="">Kategori</option>
	        	<?php foreach ($kategori as $row): ?>
	        		<option value="<?= $row->id_kategori ?>"><?= ucwords($row->nama_kategori) ?></option>
	        	<?php endforeach ?>
	        </select>
            <small class="help-block text-danger"></small>
	      </div>
	     <div class="form-group">
	        <label for="id_obat">Obat</label>
	        <select class="form-control select2" id="id_obat" name="id_obat" required="">
	        	<option value="">Obat</option>
	        	<?php foreach ($obat as $row): ?>
	        		<option value="<?= $row->id_obat ?>"><?= ucwords($row->nama_obat) ?></option>
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
var title 		= $('[name="title"]').val();
var tb 			= "#table";
var url 		= index + "master/drugcategory/show_datatables";
var base_url 	= index + "master/drugcategory/";
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

function edit_data(id) {
  	reset_form(form);
    $.ajax({
        url : base_url + "get_data/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id_obat_kategori"]').val(id);
            $('[name="jumlah_obat"]').val(data.jumlah_obat);
            $('[name="id_kategori"]').val(data.id_kategori).select2();
            $('[name="id_obat"]').val(data.id_obat).select2();
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