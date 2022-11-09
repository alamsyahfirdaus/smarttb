<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-xs-12">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Detail Data <?= $breadcrumb ?></h3>
            <div class="card-tools">
              <a href="<?= site_url('nurse/addedit/'. md5(@$data->id_pmo)) ?>" class="btn btn-tool" title="Edit Data <?= $breadcrumb ?>">
                <i class="fas fa-edit"></i></a>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-condensed">
              <tr>
                <td>Nama Penderita</td>
                <td>:</td>
                <td><?= @$data->full_name ?></td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?= @$data->gender == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
              </tr>
              <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td><?= $this->library->date(@$data->date_of_birth) ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td>:</td>
                <td><?= @$data->email ?></td>
              </tr>
              <tr>
                <td>Telepon</td>
                <td>:</td>
                <td><?= @$data->phone ?></td>
              </tr>
              <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?= @$data->pekerjaan ?></td>
              </tr>
              <tr>
                <td>Foto</td>
                <td>:</td>
                <td>
                  <img class="profile-user-img img-fluid" src="<?= site_url(IMAGE . $this->library->image(@$data->profile_pic)) ?>" alt="User profile picture">
                </td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                  <textarea class="form-control" disabled=""><?= @$data->alamat_pmo ?></textarea>
                </td>
              </tr>
            </table>
          </div>
          <div class="card-footer">
            <p class="text-center">
               <small class="text-muted">Tanggal Registrasi, <?= date('d/m/Y', strtotime(@$data->date_created)); ?>
               </small>
             </p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xs-12"></div>

    </div>
  </div>
</section>