<script src="<?= base_url(JS . 'source.js') ?>"></script>
<script src="<?= base_url(JS . 'advanced.js') ?>"></script>

<script type="text/javascript">
  <?php if ($this->session->flashdata('success')): ?>
    Swal.fire({
      type: 'success',
      title: '<?= $this->session->flashdata('success'); ?>',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true
    });
  <?php elseif ($this->session->flashdata('error')): ?>
    Swal.fire({
      type: 'error',
      title: '<?= $this->session->flashdata('error'); ?>',
      showConfirmButton: false,
      timer: 1500
    });
  <?php endif ?>
</script>