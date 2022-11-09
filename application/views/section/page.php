<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= TITLE .' | '. $breadcrumb ?><?php if (@$title) echo ' - ' . $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
  $this->load->view('section/css');
  $this->load->view('section/js');
  $user = $this->library->session();
  ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
<!--       <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> -->
      <li class="nav-item">
        <a type="button" class="nav-link" onclick="logout()"><i class="fas fa-sign-out-alt" title="Keluar"></i></a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="javascript:void(0)" onclick="home()" class="brand-link">
      <i class="fas fa-laptop-medical  ml-3 mr-2"></i>
      <span class="brand-text font-weight-bold text-white" style="font-family: sans-serif;"><?= TITLE ?></span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url(IMAGE . $this->library->image($user['profile_pic'])) ?>" class="img-circle elevation-1" alt="User Image">
        </div>
        <div class="info">
          <a type="button" onclick="profile()" class="d-block" title="Profile"><?= ucwords($user['full_name']) ?></a>
        </div>
      </div>
      <?php if ($user['user_type_id'] == 1): ?>
        <?php $this->load->view('section/sidebar');  ?>
      <?php else: ?>
          <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?= site_url('home') ?>" class="nav-link <?php if($this->uri->segment(1) == 'home') echo 'active' ?>">
                <i class="nav-icon fas fa-home"></i>
                <p> Beranda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('pmo/patient') ?>" class="nav-link <?php if($this->uri->segment(2) == 'patient' || $this->uri->segment(2) == 'message') echo 'active' ?>">
                <i class="nav-icon fas fa-user"></i>
                <p> Penderita</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= site_url('education') ?>" class="nav-link <?php if($this->uri->segment(1) == 'education') echo 'active' ?>">
                <i class="nav-icon fas fa-bullhorn"></i>
                <p> Edukasi</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="<?= site_url('pmo/message') ?>" class="nav-link <?php if($this->uri->segment(2) == 'message') echo 'active' ?>">
                <i class="nav-icon fas fa-envelope"></i>
                <p> Pesan</p>
              </a>
            </li>  -->
            <li class="nav-item">
              <a href="<?= site_url('logout') ?>" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Keluar</p>
              </a>
            </li>
          </ul>
        </nav>
      <?php endif ?>
    </div>
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?= @$title ? $title : $breadcrumb  ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <a href=""><?= @$breadcrumb ?></a>
                </li>
                <?php if (@$title): ?>
                  <li class="breadcrumb-item active"><?= $title ?></li>
                <?php endif ?>
                <?php if (@$subtitle): ?>
                  <li class="breadcrumb-item active"><?= $subtitle ?></li>
                <?php endif ?>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <?= $content ?>
  </div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Versi</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2020 - <?= date('Y') ?><a  class="text-muted" href="javascript:void(0)"> <?= FOOTER ?></a>.</strong>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
</div>
<?php $this->load->view('section/scripts'); ?>
</body>
</html>