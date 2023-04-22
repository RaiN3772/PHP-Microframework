<?php include 'inc/views/_layout/headerinclude.php'; ?>
<?php include 'inc/views/_layout/body.php'; ?>

<div class="d-flex flex-column flex-column-fluid">
  <div class="d-flex flex-column-fluid">
    <div class="container-xxl">

      <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0">
          <div class="card-title m-0">
            <h3 class="fw-bold m-0">Edit
              <?= secure($userInfo['name']); ?>
            </h3>
          </div>
        </div>

        <form class="form" method="post" action="/admin/user/<?=$userInfo['id'];?>">
          <div class="card-body border-top p-9">
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-semibold fs-6">Remove Avatar</label>
              <div class="col-lg-8 fv-row">
                <div class="d-flex align-items-center mt-3">
                  <div class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input rounded-pill" type="checkbox" name="remove_avatar" value="1"/>
                    <label class="form-check-label">Remove</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-semibold fs-6">Display Name</label>
              <div class="col-lg-8 fv-row">
                <input type="text" name="display_name" class="form-control form-control-lg form-control-solid"
                  value="<?= secure($userInfo['display_name']); ?>" />
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-semibold fs-6">User Name</label>
              <div class="col-lg-8 fv-row">
                <input type="text" name="username" class="form-control form-control-lg form-control-solid"
                  value="<?= secure($userInfo['name']); ?>" />
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-semibold fs-6">User Email</label>
              <div class="col-lg-8 fv-row">
                <input type="email" name="email" class="form-control form-control-lg form-control-solid"
                  value="<?= $userInfo['email']; ?>" />
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-semibold fs-6">New Password</label>
              <div class="col-lg-8 fv-row">
                <input type="password" name="newpassword" class="form-control form-control-lg form-control-solid"/>
              </div>
            </div>
            <div class="row mb-6">
              <label class="col-lg-4 col-form-label fw-semibold fs-6">User Roles</label>
              <div class="col-lg-8 fv-row">
              <select class="form-select form-select-solid" name="roles[]" data-control="select2" data-close-on-select="false" data-placeholder="Select a role" data-allow-clear="true" multiple="multiple">
              <option></option>
              <?php foreach($roles['all'] as $all): ?>
                <?php $selected = in_array($all['role_id'], array_column($roles['user'], 'role_id')) ? ' selected' : ''; ?>
              <option value="<?=$all['role_id'];?>"<?=$selected;?>><?=secure($all['role_title']);?></option>
              <?php endforeach; ?>
            </select>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
            <button type="submit" class="btn btn-primary" id="edit_submit">Edit <?=secure($userInfo['name']);?></button>
          </div>
        </form>
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

	document.querySelector('#edit_submit').addEventListener('click', confirmSubmit);
</script><?php include 'inc/views/_layout/footer.php'; ?>