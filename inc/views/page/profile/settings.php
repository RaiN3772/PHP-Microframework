<?php include 'inc/views/_layout/headerinclude.php'; ?>
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid">
	<div class="d-flex flex-column-fluid">
		<div class="container-xxl">
			<?php include 'inc/views/page/profile/navbar.php'; ?>
			<?php include 'inc/views/page/profile/settings/details.php'; ?>
			<?php include 'inc/views/page/profile/settings/options.php'; ?>
			<?php include 'inc/views/page/profile/settings/password.php'; ?>
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

	document.querySelector('#profile_details_Submit').addEventListener('click', confirmSubmit);
	document.querySelector('#profile_options_Submit').addEventListener('click', confirmSubmit);
</script>
<script src="/assets/js/custom/password.js"></script>
<?php include 'inc/views/_layout/footer.php'; ?>