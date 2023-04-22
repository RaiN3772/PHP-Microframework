<?php include 'inc/views/_layout/headerinclude.php'; ?>
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid"">
  <div class=" d-flex flex-column-fluid">
  <div class="container-xxl">
    <div class="accordion accordion-flush" id="accordionsettings">
      <?php include 'inc/views/page/admin/settings/platform.php'; ?>
      <?php include 'inc/views/page/admin/settings/register.php'; ?>
      <?php include 'inc/views/page/admin/settings/profile.php'; ?>
    </div>
  </div>
</div>
</div>


<?php include 'inc/views/_layout/footerinclude.php'; ?>
<script>
  function confirmSubmit(e) {
    e.preventDefault();
    Swal.fire({
      html: `Are you sure you want to save these settings?`,
      icon: "warning",
      buttonsStyling: false,
      showCancelButton: true,
      cancelButtonText: 'Nope, cancel',
      confirmButtonText: "Yes, save!",
      customClass: {
        confirmButton: "btn btn-primary",
        cancelButton: 'btn btn-danger'
      }
    }).then((result) => {
      if (result.isConfirmed) {
        e.target.closest('form').submit();
      }
    });
  }

  document.querySelector('#web_submit').addEventListener('click', confirmSubmit);
  document.querySelector('#register_submit').addEventListener('click', confirmSubmit);
  document.querySelector('#profile_submit').addEventListener('click', confirmSubmit);
</script>
<?php include 'inc/views/_layout/footer.php'; ?>