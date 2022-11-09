<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-12 col-xs-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Daftar <?= $header ?></h3>
				<input type="hidden" name="title" value="<?= $header ?>">
				<div class="card-tools">
				  <button type="button" onclick="add_data()" class="btn btn-tool" title="Tambah <?= $header ?>">
				    <i class="fas fa-plus"></i></button>
				</div>
			</div>
		  <div class="card-body table-responsive">
			<table id="table" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
				  <th>Judul</th>
				  <th class="text-center">Gambar</th>
				  <th>Tipe Edukasi</th>
				  <th class="text-center">Video</th>
				  <th width="5%">Status</th>
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

<script type="text/javascript">
var title 		= $('[name="title"]').val();
var tb 			= "#table";
var url 		= index + "education/show_datatables";
var base_url 	= index + "education/";

$(document).ready(function() {
	datatable(tb, url);
});

function add_data() {
	window.location.href = base_url + "addedit"
}

function detail_data(id) {
	window.location.href = base_url + "detail/" + id;	
}

function edit_data(id) {
	window.location.href = base_url + "addedit/" + id;
}

function delete_data(id) {
  var text 		= "Akan menghapus " + title;
  var url_del 	= base_url + "delete/" + id;
  confirm_delete(text, url_del);
}

function success_delete() {
  reload_table();
}

function is_active(id) {
	window.location.href = base_url + "is_active/" + id;
}

</script>