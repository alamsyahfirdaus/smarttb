<section class="content">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-md-12 col-xs-12">
		<div class="card card-primary card-outline">
			<div class="card-header">
				<h3 class="card-title">Daftar <?= $header ?></h3>
				<input type="hidden" name="title" value="<?= $header ?>">
			</div>
		  <div class="card-body table-responsive">
			<table id="table" class="table table-bordered" style="width:100%">
			  <thead>
				<tr>
				  <th width="5%">No</th>
				  <th>Nama Pengaturan</th>
				  <th>Deskripsi</th>
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
var url 		= index + "setting/show_datatables";

$(document).ready(function() {
	datatable(tb, url);
});

function edit_data(id) {
	window.location.href = index + "setting/edit/" + id;
}

</script>