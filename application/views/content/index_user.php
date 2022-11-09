<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Daftar <?= $header ?></h3>
            <div class="card-tools">
              <button type="button" onclick="add_user()" class="btn btn-tool" title="Tambah <?= $header ?>">
                <i class="fas fa-user-plus"></i></button>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table id="table" class="table table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th>Nama Lengkap</th>
                  <!-- <th>Email</th>
                  <th>Jenis Kelamin</th>
                  <th>Tanggal Lahir</th>
                  <th>Telepon</th> -->
                  <th class="text-center">Foto Profile</th>
                  <th>Detail Administrator</th>
                  <th width="5%" class="text-center">Aksi</th>
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
var tb  = "#table";
var url = index + "user/show_datatables";

$(document).ready(function() {
  datatable(tb, url);
});

function add_user() {
  window.location.href = index + "user/addedit";
}

function edit_user(id) {
  window.location.href = index + "user/addedit/" + id;
}

function delete_user(id, name) {
  var text = "Akan menghapus " + name;
  var url = index + "user/delete/" + id;
  confirm_delete(text, url);
}

function success_delete() {
  reload_table();
}
</script>