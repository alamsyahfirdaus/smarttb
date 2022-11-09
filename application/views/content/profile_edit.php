<section class="content">
  <div class="container-fluid">
  	<div class="row">
  		<div class="col-md-6">
		  	<form action="<?= site_url('home/save_editprofile/' . md5(@$user['user_id'])) ?>" id="form" method="post" enctype="multipart/form-data">
	  	    <div class="card">
	  	    	<div class="card-header card-primary card-outline">
	  	    	  <h3 class="card-title">Edit Profile</h3>
	  	    	</div>
	  	      <div class="card-body">
		  	      <div class="form-group">
	  		        <label for="full_name">Nama Lengkap</label>
	  		        <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Nama Lengkap" value="<?= (@$user['full_name']) ? $user['full_name'] : set_value('full_name') ?>" autocomplete="off">
	  	            <small class="help-block text-danger"></small>
	  		      </div>
	  		      <div class="form-group">
	  		        <label for="email">Email</label>
	  		        <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?= (@$user['email']) ? $user['email'] : set_value('email') ?>" autocomplete="off">
	  	            <small class="help-block text-danger"></small>
	  		      </div>
		  	      <div class="form-group">
		  	        <label for="gender">Jenis Kelamin</label>
		  	        <select name="gender" id="gender" class="form-control">
		  	          <option value="">Jenis Kelamin</option>
		  	          <option value="L" <?php if(@$user['gender'] == 'L') echo "selected"; ?>>Laki-Laki</option>
		  	          <option value="P" <?php if(@$user['gender'] == 'P') echo "selected"; ?>>Perempuan</option>
		  	        </select>
		  	        <small class="help-block text-danger"></small>
		  	      </div>
		  	      <div class="form-group">
		  	        <label for="phone">Telepon</label>
		  	        <input type="number" min="0" name="phone" class="form-control" id="phone" placeholder="Telepon" value="<?= (@$user['phone']) ? $user['phone'] : set_value('phone') ?>" autocomplete="off">
		            <small class="help-block text-danger"></small>
		  	      </div>
		  	      <div class="form-group">
		  	        <label for="date_of_birth">Tanggal Lahir</label>
		  	        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="Tanggal Lahir"  value="<?= @$user['date_of_birth'] ?>">
		  	        <small class="help-block text-danger"></small>
		  	      </div>
		  	      <div class="form-group">
		  	        <label for="profile_pic">Foto Profile</label>
		  	        <div class="input-group">
		  	          <div class="custom-file">
		  	            <input type="file" class="custom-file-input" id="profile_pic" name="profile_pic">
		  	            <label class="custom-file-label" for="profile_pic"><?= (@$user['profile_pic']) ? $user['profile_pic'] : set_value('profile_pic')  ?></label>
		  	          </div>
		  	          <div class="input-group-append">
		  	          	<input type="hidden" name="user_id" value="<?= md5(@$user['user_id']) ?>">
		  	            <button type="button" <?= (@$user['profile_pic']) ? 'title="Hapus"' : "disabled"; ?> class="btn btn-default" onclick="delete_img();"><i class="fas fa-trash"></i></button>
		  	          </div>
		  	        </div>
		  	      </div>
	  	      </div>
		      <div class="card-footer">
		      	<div class="float-right">
	  	      	<button type="button" onclick="profile()" class="btn btn-secondary mr-2"><i class="fas"> Batal</i></button>
	  	      	<button type="submit" id="btnsave" class="btn btn-primary"><i class="fas"> Simpan</i></button>
		      	</div>
		      </div>
	  	    </div>
		  	</form>
  		</div>
  	</div>
  </div>
</section>

<script type="text/javascript">
var form = "#form";
var btn  = "#btnsave";
$(document).ready(function () {
	form_multipart(form, btn);
});

function action_success() {
  profile();
}

function delete_img() {
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Akan menghapus Foto Profile",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'OK',
    cancelButtonText: 'Batal',
    reverseButtons: true,
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url : index + "user/delete_img",
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
          success: function(response) {
            flashdata(response.message);
            setTimeout(function() { 
              profile();
            }, 1800);
          }
      });
    }
  })
}

</script>