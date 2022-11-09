<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <?php foreach ($this->db->get('menu')->result() as $m): ?>
      <?php if ($m->url_menu): ?>
        <li class="nav-item">
          <a href="<?= site_url($m->url_menu) ?>" class="nav-link <?php if ($m->url_menu == $this->uri->segment(1)) echo 'active' ?>">
            <i class="nav-icon <?= $m->icon ?>"></i>
            <p> <?= $m->menu ?></p>
          </a>
        </li>
      <?php else: ?>
        <?php 
          $sub_menu   = $this->mall->getSubMenu($user['user_type_id'], $m->menu_id);
          $segment    = $this->uri->segment(1) . '/' . $this->uri->segment(2);

        if ($sub_menu['num_rows']): ?>
          <li class="nav-item has-treeview <?php if ($m->menu == @$breadcrumb) echo 'menu-open' ?>">
            <a href="javascript:void(0)" class="nav-link <?php if ($m->menu == @$breadcrumb) echo 'active' ?>">
              <i class="nav-icon <?= $m->icon ?>"></i>
              <p> <?= $m->menu ?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php foreach ($sub_menu['result'] as $sm): ?>
                <li class="nav-item">
                  <a href="<?= site_url($sm->url) ?>" class="nav-link <?php if($sm->url == $segment) echo 'active' ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?= $sm->sub_menu ?></p>
                  </a>
                </li>
              <?php endforeach ?>
            </ul>
          </li>
        <?php endif ?>
      <?php endif ?>
    <?php endforeach ?>
  </ul>
</nav>