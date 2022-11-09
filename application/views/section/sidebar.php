  <nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="<?= site_url('home') ?>" class="nav-link <?php if($this->uri->segment(1) == 'home') echo 'active' ?>">
        <i class="nav-icon fas fa-home"></i>
        <p> Beranda</p>
      </a>
    </li>
<!--     <li class="nav-item has-treeview <?php if ($this->uri->segment(1) == 'master') echo 'menu-open' ?>">
      <a href="javascript:void(0)" class="nav-link <?php if ($this->uri->segment(1) == 'master') echo 'active' ?>">
        <i class="nav-icon fas fa-folder-open"></i>
        <p> Master Data
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?= site_url('master/clinic') ?>" class="nav-link <?php if (@$title == 'Puskesmas') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Puskesmas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('master/category') ?>" class="nav-link <?php if (@$title == 'Kategori') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Kategori</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('master/drug') ?>" class="nav-link <?php if (@$title == 'Obat') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Obat</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('master/drugcategory') ?>" class="nav-link <?php if (@$title == 'Kategori Obat') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Kategori Obat</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('master/dose') ?>" class="nav-link <?php if (@$title == 'Aturan Minum Obat') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Aturan Minum Obat</p>
          </a>
        </li>
      </ul>
    </li> -->
    <li class="nav-item">
      <a href="<?= site_url('patient') ?>" class="nav-link <?php if($this->uri->segment(1) == 'patient' || @$breadcrumb == 'Penderita') echo 'active' ?>">
        <i class="nav-icon fas fa-user"></i>
        <p> Penderita</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('nurse') ?>" class="nav-link <?php if($this->uri->segment(1) == 'nurse') echo 'active' ?>">
        <i class="nav-icon fas fa-user-md"></i>
        <p> Pengawas Minum Obat</p>
      </a>
    </li> 
    <!-- <li class="nav-item has-treeview <?php if ($this->uri->segment(1) == 'service') echo 'menu-open' ?>">
      <a href="javascript:void(0)" class="nav-link <?php if ($this->uri->segment(1) == 'service') echo 'active' ?>">
        <i class="nav-icon fas fa-medkit"></i>
        <p>
          Layanan
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="<?= site_url('service/patientpmo') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'service' && @$title == 'PMO') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>PMO</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('service/patientpmo') ?>" class="nav-link <?php if ($this->uri->segment(1) == 'service' && @$title == 'PMO Penderita') echo 'active' ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>PMO Penderita</p>
          </a>
        </li>
      </ul>
    </li> -->
    <li class="nav-item">
      <a href="<?= site_url('education') ?>" class="nav-link <?php if($this->uri->segment(1) == 'education') echo 'active' ?>">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p> Edukasi</p>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a href="<?= site_url('pmo/message') ?>" class="nav-link <?php if($this->uri->segment(2) == 'message') echo 'active' ?>">
        <i class="nav-icon fas fa-envelope"></i>
        <p> Konsultasi</p>
      </a>
    </li>  -->
    <li class="nav-item">
      <a href="<?= site_url('user') ?>" class="nav-link <?php if($this->uri->segment(1) == 'user') echo 'active' ?>">
        <i class="nav-icon fas fa-user-cog"></i>
        <p> Administrator</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="<?= site_url('setting') ?>" class="nav-link <?php if($this->uri->segment(1) == 'setting') echo 'active' ?>">
        <i class="nav-icon fas fa-cogs"></i>
        <p> Pengaturan</p>
      </a>
    </li> 
    <li class="nav-item">
      <a href="<?= site_url('logout') ?>" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Keluar</p>
      </a>
    </li>
  </ul>
</nav>