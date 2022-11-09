<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-12 col-xs-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Daftar <?= $title ?></h3>
				<div class="card-tools">
				  <button type="button" onclick="add_puskesmas()" class="btn btn-tool" title="Tambah <?= $title ?>">
				    <i class="fas fa-plus"></i></button>
				</div>
			</div>
		  <div class="card-body table-responsive">
			<table id="puskesmas" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
				  <th>Kode Puskesmas</th>
				  <th>Puskesmas</th>
				  <th>Kecamatan</th>
				  <th>Alamat</th>
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

<!-- <div class="modal fade" id="modal_form">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title">#</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <form action="<?= site_url('master/clinic/save_puskesmas') ?>" id="form" method="post">
    	<input type="text" name="id_puskesmas" value="" style="display: none;">
	    <div class="modal-body">
	      <div class="form-group">
	        <label for="nama">Puskesmas</label>
	        <input type="text" name="nama" id="nama" class="form-control" placeholder="Puskesmas" autocomplete="off">
            <small class="help-block text-danger"></small>
	      </div>
	      <div class="form-group">
	        <label for="id_kecamatan">Kecamatan</label>
	        <select name="id_kecamatan" class="form-control select2" id="id_kecamatan">
	          <option value="">Kecamatan</option>
	        </select>
	        <small class="help-block text-danger"></small>
	      </div>
	      <div class="form-group">
	        <label for="alamat">Alamat</label>
	        <textarea name="alamat" id="alamat" class="form-control"></textarea>
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
</div> -->

<script type="text/javascript">
var tb 	= "#puskesmas";
var url = index + "master/clinic/show_datatables";

$(document).ready(function() {
	datatable(tb, url);
});

function add_puskesmas() {
	window.location.href = index + "master/clinic/addedit";
}

function edit_puskesmas(id) {
	window.location.href = index + "master/clinic/addedit/" + id;
}

function delete_puskesmas(id) {
  var text 	= "Akan menghapus Puskesmas";
  var url 	= index + "master/clinic/delete_puskesmas/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>